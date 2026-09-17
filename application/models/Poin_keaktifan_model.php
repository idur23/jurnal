<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poin_keaktifan_model extends MY_Model {

    protected $table = 'jurnal_poin_keaktifan';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get student list for a specific journal with current points
     */
    public function get_poin_by_jurnal($jurnal_id, $kelas_id) {
        $this->db->select('siswa.id as siswa_id, siswa.nis, siswa.nisn, siswa.nama_lengkap, siswa.jk, COALESCE(jpk.poin, 0) as poin, jpk.id as transaction_id, jpk.updated_at');
        $this->db->from('siswa');
        $this->db->join('jurnal_poin_keaktifan jpk', 'jpk.siswa_id = siswa.id AND jpk.jurnal_id = ' . (int)$jurnal_id, 'left');
        $this->db->where('siswa.kelas_id', $kelas_id);
        $this->db->where('siswa.status_aktif', 1);
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Increment or decrement points for a student in a journal context.
     * Prevents points from going below 0.
     */
    public function adjust_poin($jurnal_id, $siswa_id, $action, $guru_id, $mapel_id, $kelas_id, $tanggal) {
        $existing = $this->db->get_where($this->table, array(
            'jurnal_id' => $jurnal_id,
            'siswa_id' => $siswa_id
        ))->row_array();

        if ($existing) {
            $current_poin = (int)$existing['poin'];
            if ($action === 'add') {
                $new_poin = $current_poin + 1;
            } else {
                $new_poin = max(0, $current_poin - 1);
            }

            $this->db->where('id', $existing['id']);
            $this->db->update($this->table, array(
                'poin' => $new_poin,
                'guru_id' => $guru_id,
                'mapel_id' => $mapel_id,
                'kelas_id' => $kelas_id,
                'tanggal' => $tanggal,
                'updated_at' => date('Y-m-d H:i:s')
            ));
        } else {
            $new_poin = ($action === 'add') ? 1 : 0;
            $insert_data = array(
                'jurnal_id' => $jurnal_id,
                'siswa_id' => $siswa_id,
                'guru_id' => $guru_id,
                'mapel_id' => $mapel_id,
                'kelas_id' => $kelas_id,
                'tanggal' => $tanggal,
                'poin' => $new_poin,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert($this->table, $insert_data);
        }

        return $new_poin;
    }

    /**
     * Rekapitulasi Bulanan Poin Keaktifan Siswa using SQL Aggregations
     */
    public function get_rekap_bulanan($filters = array()) {
        $bulan = !empty($filters['bulan']) ? (int)$filters['bulan'] : (int)date('m');
        $tahun = !empty($filters['tahun']) ? (int)$filters['tahun'] : (int)date('Y');

        $this->db->select('siswa.id as siswa_id, siswa.nis, siswa.nama_lengkap, siswa.jk, kelas.nama_kelas, kelas.id as kelas_id, 
                           COALESCE(SUM(jpk.poin), 0) as total_poin, 
                           COUNT(DISTINCT jpk.jurnal_id) as total_sesi_aktif');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id');
        $this->db->join('jurnal_poin_keaktifan jpk', 'jpk.siswa_id = siswa.id AND MONTH(jpk.tanggal) = ' . $bulan . ' AND YEAR(jpk.tanggal) = ' . $tahun, 'left');
        $this->db->where('siswa.status_aktif', 1);

        if (!empty($filters['kelas_id'])) {
            $this->db->where('siswa.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['mapel_id'])) {
            $this->db->where('jpk.mapel_id', $filters['mapel_id']);
        }
        if (!empty($filters['guru_id'])) {
            $this->db->where('jpk.guru_id', $filters['guru_id']);
        }

        $this->db->group_by(array('siswa.id', 'siswa.nis', 'siswa.nama_lengkap', 'siswa.jk', 'kelas.nama_kelas', 'kelas.id'));
        $this->db->order_by('total_poin', 'DESC');
        $this->db->order_by('siswa.nama_lengkap', 'ASC');

        return $this->db->get()->result_array();
    }

    /**
     * Detail Rekapitulasi per Siswa
     */
    public function get_rekap_per_siswa($siswa_id, $filters = array()) {
        $bulan = !empty($filters['bulan']) ? (int)$filters['bulan'] : null;
        $tahun = !empty($filters['tahun']) ? (int)$filters['tahun'] : null;

        // Student Info
        $this->db->select('siswa.*, kelas.nama_kelas');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id');
        $this->db->where('siswa.id', $siswa_id);
        $siswa = $this->db->get('siswa')->row_array();

        if (!$siswa) return null;

        // Point Breakdown
        $this->db->select('jpk.*, jurnal_guru.kode_jurnal, jurnal_guru.materi_pembelajaran, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru');
        $this->db->from('jurnal_poin_keaktifan jpk');
        $this->db->join('jurnal_guru', 'jurnal_guru.id = jpk.jurnal_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = jpk.mapel_id');
        $this->db->join('guru', 'guru.id = jpk.guru_id');
        $this->db->where('jpk.siswa_id', $siswa_id);

        if ($bulan) {
            $this->db->where('MONTH(jpk.tanggal)', $bulan);
        }
        if ($tahun) {
            $this->db->where('YEAR(jpk.tanggal)', $tahun);
        }
        if (!empty($filters['mapel_id'])) {
            $this->db->where('jpk.mapel_id', $filters['mapel_id']);
        }

        $this->db->order_by('jpk.tanggal', 'DESC');
        $this->db->order_by('jpk.id', 'DESC');
        $details = $this->db->get()->result_array();

        $total_poin = 0;
        foreach ($details as $d) {
            $total_poin += (int)$d['poin'];
        }

        return array(
            'siswa' => $siswa,
            'details' => $details,
            'total_poin' => $total_poin
        );
    }

    /**
     * Rekap per Kelas / Ranking Keaktifan Kelas
     */
    public function get_rekap_per_kelas($kelas_id, $filters = array()) {
        $bulan = !empty($filters['bulan']) ? (int)$filters['bulan'] : (int)date('m');
        $tahun = !empty($filters['tahun']) ? (int)$filters['tahun'] : (int)date('Y');

        $this->db->select('siswa.id as siswa_id, siswa.nis, siswa.nama_lengkap, siswa.jk, 
                           COALESCE(SUM(jpk.poin), 0) as total_poin, 
                           COUNT(DISTINCT CASE WHEN jpk.poin > 0 THEN jpk.jurnal_id END) as sesi_aktif');
        $this->db->from('siswa');
        $this->db->join('jurnal_poin_keaktifan jpk', 'jpk.siswa_id = siswa.id AND MONTH(jpk.tanggal) = ' . $bulan . ' AND YEAR(jpk.tanggal) = ' . $tahun, 'left');
        $this->db->where('siswa.kelas_id', $kelas_id);
        $this->db->where('siswa.status_aktif', 1);

        if (!empty($filters['mapel_id'])) {
            $this->db->where('jpk.mapel_id', $filters['mapel_id']);
        }

        $this->db->group_by(array('siswa.id', 'siswa.nis', 'siswa.nama_lengkap', 'siswa.jk'));
        $this->db->order_by('total_poin', 'DESC');
        $this->db->order_by('siswa.nama_lengkap', 'ASC');

        return $this->db->get()->result_array();
    }

    /**
     * Get Dashboard High-level Statistics
     */
    public function get_dashboard_stats($filters = array()) {
        $bulan = !empty($filters['bulan']) ? (int)$filters['bulan'] : (int)date('m');
        $tahun = !empty($filters['tahun']) ? (int)$filters['tahun'] : (int)date('Y');

        // Total active students
        $this->db->where('status_aktif', 1);
        if (!empty($filters['kelas_id'])) {
            $this->db->where('kelas_id', $filters['kelas_id']);
        }
        $total_siswa = $this->db->count_all_results('siswa');

        // Total points & transactions this month
        $this->db->select('COALESCE(SUM(poin), 0) as total_poin, COUNT(id) as total_transaksi, COUNT(DISTINCT siswa_id) as siswa_dapat_poin');
        $this->db->from($this->table);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);

        if (!empty($filters['kelas_id'])) $this->db->where('kelas_id', $filters['kelas_id']);
        if (!empty($filters['mapel_id'])) $this->db->where('mapel_id', $filters['mapel_id']);
        if (!empty($filters['guru_id'])) $this->db->where('guru_id', $filters['guru_id']);

        $stats_row = $this->db->get()->row_array();

        $total_poin = (int)($stats_row['total_poin'] ?? 0);
        $total_transaksi = (int)($stats_row['total_transaksi'] ?? 0);
        $avg_poin = ($total_siswa > 0) ? round($total_poin / $total_siswa, 1) : 0;

        // Top 1 Student
        $rekap_bulan = $this->get_rekap_bulanan($filters);
        $top_siswa = !empty($rekap_bulan) ? $rekap_bulan[0] : null;
        $lowest_siswa = (!empty($rekap_bulan) && count($rekap_bulan) > 1) ? $rekap_bulan[count($rekap_bulan) - 1] : null;

        return array(
            'total_siswa' => $total_siswa,
            'total_poin_bulan_ini' => $total_poin,
            'rata_rata_poin' => $avg_poin,
            'total_transaksi' => $total_transaksi,
            'top_siswa' => $top_siswa,
            'lowest_siswa' => $lowest_siswa
        );
    }

    /**
     * Get Dashboard Chart Data
     */
    public function get_dashboard_charts($filters = array()) {
        $bulan = !empty($filters['bulan']) ? (int)$filters['bulan'] : (int)date('m');
        $tahun = !empty($filters['tahun']) ? (int)$filters['tahun'] : (int)date('Y');

        // Chart 1: Poin per Kelas
        $this->db->select('kelas.nama_kelas, COALESCE(SUM(jpk.poin), 0) as total_poin');
        $this->db->from('kelas');
        $this->db->join('jurnal_poin_keaktifan jpk', 'jpk.kelas_id = kelas.id AND MONTH(jpk.tanggal) = ' . $bulan . ' AND YEAR(jpk.tanggal) = ' . $tahun, 'left');
        $this->db->group_by('kelas.id, kelas.nama_kelas');
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $poin_per_kelas = $this->db->get()->result_array();

        // Chart 2: Poin per Bulan (Yearly trend)
        $this->db->select('MONTH(tanggal) as bulan, COALESCE(SUM(poin), 0) as total_poin');
        $this->db->from($this->table);
        $this->db->where('YEAR(tanggal)', $tahun);
        if (!empty($filters['kelas_id'])) $this->db->where('kelas_id', $filters['kelas_id']);
        if (!empty($filters['mapel_id'])) $this->db->where('mapel_id', $filters['mapel_id']);
        $this->db->group_by('MONTH(tanggal)');
        $this->db->order_by('bulan', 'ASC');
        $poin_per_bulan_raw = $this->db->get()->result_array();

        $bulan_names = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
        $poin_per_bulan = array();
        for ($m = 1; $m <= 12; $m++) {
            $found = 0;
            foreach ($poin_per_bulan_raw as $pbr) {
                if ((int)$pbr['bulan'] === $m) {
                    $found = (int)$pbr['total_poin'];
                    break;
                }
            }
            $poin_per_bulan[] = array(
                'bulan_name' => $bulan_names[$m],
                'total_poin' => $found
            );
        }

        // Chart 3: Top 10 Active Students
        $this->db->select('siswa.nama_lengkap, kelas.nama_kelas, COALESCE(SUM(jpk.poin), 0) as total_poin');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id');
        $this->db->join('jurnal_poin_keaktifan jpk', 'jpk.siswa_id = siswa.id AND MONTH(jpk.tanggal) = ' . $bulan . ' AND YEAR(jpk.tanggal) = ' . $tahun, 'left');
        $this->db->where('siswa.status_aktif', 1);
        if (!empty($filters['kelas_id'])) $this->db->where('siswa.kelas_id', $filters['kelas_id']);
        $this->db->group_by('siswa.id, siswa.nama_lengkap, kelas.nama_kelas');
        $this->db->order_by('total_poin', 'DESC');
        $this->db->limit(10);
        $top_10_siswa = $this->db->get()->result_array();

        return array(
            'poin_per_kelas' => $poin_per_kelas,
            'poin_per_bulan' => $poin_per_bulan,
            'top_10_siswa' => $top_10_siswa
        );
    }

    /**
     * Audit log / Transaction details
     */
    public function get_detail_transaksi($filters = array(), $limit = 100, $offset = 0) {
        $this->db->select('jpk.*, siswa.nis, siswa.nama_lengkap as nama_siswa, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, jurnal_guru.kode_jurnal');
        $this->db->from('jurnal_poin_keaktifan jpk');
        $this->db->join('siswa', 'siswa.id = jpk.siswa_id');
        $this->db->join('kelas', 'kelas.id = jpk.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = jpk.mapel_id');
        $this->db->join('guru', 'guru.id = jpk.guru_id');
        $this->db->join('jurnal_guru', 'jurnal_guru.id = jpk.jurnal_id');

        if (!empty($filters['kelas_id'])) $this->db->where('jpk.kelas_id', $filters['kelas_id']);
        if (!empty($filters['mapel_id'])) $this->db->where('jpk.mapel_id', $filters['mapel_id']);
        if (!empty($filters['guru_id'])) $this->db->where('jpk.guru_id', $filters['guru_id']);
        if (!empty($filters['siswa_id'])) $this->db->where('jpk.siswa_id', $filters['siswa_id']);
        if (!empty($filters['bulan'])) $this->db->where('MONTH(jpk.tanggal)', $filters['bulan']);
        if (!empty($filters['tahun'])) $this->db->where('YEAR(jpk.tanggal)', $filters['tahun']);

        $this->db->order_by('jpk.tanggal', 'DESC');
        $this->db->order_by('jpk.id', 'DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result_array();
    }
}
