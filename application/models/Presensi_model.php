<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_model extends MY_Model {
    protected $table = 'presensi_siswa';

    public function __construct() {
        parent::__construct();
    }

    public function get_presensi_by_jurnal($jurnal_id) {
        $this->db->select('presensi_siswa.*, siswa.nis, siswa.nisn, siswa.nama_lengkap, siswa.jk');
        $this->db->join('siswa', 'siswa.id = presensi_siswa.siswa_id');
        $this->db->join('presensi_kelas', 'presensi_kelas.id = presensi_siswa.presensi_kelas_id');
        $this->db->where('presensi_kelas.jurnal_id', $jurnal_id);
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_presensi_by_kelas_presensi($presensi_kelas_id) {
        $this->db->select('presensi_siswa.*, siswa.nis, siswa.nisn, siswa.nama_lengkap, siswa.jk');
        $this->db->join('siswa', 'siswa.id = presensi_siswa.siswa_id');
        $this->db->where('presensi_siswa.presensi_kelas_id', $presensi_kelas_id);
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function save_presensi_siswa_batch($presensi_kelas_id, $tanggal, $presensi_data) {
        $this->db->trans_begin();

        $this->db->where('presensi_kelas_id', $presensi_kelas_id);
        $this->db->delete('presensi_siswa');

        foreach ($presensi_data as &$p) {
            $p['presensi_kelas_id'] = $presensi_kelas_id;
            $p['tanggal'] = $tanggal;
        }

        if (!empty($presensi_data)) {
            $this->db->insert_batch('presensi_siswa', $presensi_data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_rekap_kelas($kelas_id, $bulan = NULL, $tahun = NULL) {
        $this->db->select('siswa.id as siswa_id, siswa.nis, siswa.nama_lengkap,
            SUM(CASE WHEN presensi_siswa.status = "Hadir" THEN 1 ELSE 0 END) as hadir,
            SUM(CASE WHEN presensi_siswa.status = "Izin" THEN 1 ELSE 0 END) as izin,
            SUM(CASE WHEN presensi_siswa.status = "Sakit" THEN 1 ELSE 0 END) as sakit,
            SUM(CASE WHEN presensi_siswa.status = "Alpa" THEN 1 ELSE 0 END) as alpa,
            SUM(CASE WHEN presensi_siswa.status = "Terlambat" THEN 1 ELSE 0 END) as terlambat,
            SUM(CASE WHEN presensi_siswa.status = "Dispen" THEN 1 ELSE 0 END) as dispen,
            COUNT(presensi_siswa.id) as total_pertemuan');
        $this->db->from('siswa');
        $this->db->join('presensi_siswa', 'presensi_siswa.siswa_id = siswa.id', 'left');
        $this->db->join('presensi_kelas', 'presensi_kelas.id = presensi_siswa.presensi_kelas_id', 'left');
        $this->db->where('siswa.kelas_id', $kelas_id);
        $this->db->where('siswa.status_aktif', 1);

        if ($bulan) {
            $this->db->where('MONTH(presensi_siswa.tanggal)', $bulan);
        }
        if ($tahun) {
            $this->db->where('YEAR(presensi_siswa.tanggal)', $tahun);
        }

        $this->db->group_by('siswa.id');
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_rekap_presensi($filters = array()) {
        $this->db->select('siswa.id as siswa_id, siswa.nis, siswa.nama_lengkap,
            SUM(CASE WHEN presensi_siswa.status = "Hadir" THEN 1 ELSE 0 END) as hadir,
            SUM(CASE WHEN presensi_siswa.status = "Izin" THEN 1 ELSE 0 END) as izin,
            SUM(CASE WHEN presensi_siswa.status = "Sakit" THEN 1 ELSE 0 END) as sakit,
            SUM(CASE WHEN presensi_siswa.status = "Alpa" THEN 1 ELSE 0 END) as alpa,
            SUM(CASE WHEN presensi_siswa.status = "Terlambat" THEN 1 ELSE 0 END) as terlambat,
            SUM(CASE WHEN presensi_siswa.status = "Dispen" THEN 1 ELSE 0 END) as dispen,
            COUNT(presensi_siswa.id) as total_pertemuan');
        $this->db->from('siswa');
        $this->db->join('presensi_siswa', 'presensi_siswa.siswa_id = siswa.id', 'left');
        $this->db->join('presensi_kelas', 'presensi_kelas.id = presensi_siswa.presensi_kelas_id', 'left');
        $this->db->join('jurnal_guru', 'jurnal_guru.id = presensi_kelas.jurnal_id', 'left');
        
        if (!empty($filters['kelas_id'])) {
            $this->db->where('siswa.kelas_id', $filters['kelas_id']);
        }
        $this->db->where('siswa.status_aktif', 1);

        if (!empty($filters['mapel_id'])) {
            $this->db->where('presensi_kelas.mapel_id', $filters['mapel_id']);
        }
        if (!empty($filters['tahun_pelajaran_id'])) {
            $this->db->where('jurnal_guru.tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        }
        if (!empty($filters['tanggal_mulai'])) {
            $this->db->where('presensi_siswa.tanggal >=', $filters['tanggal_mulai']);
        }
        if (!empty($filters['tanggal_selesai'])) {
            $this->db->where('presensi_siswa.tanggal <=', $filters['tanggal_selesai']);
        }

        $this->db->group_by('siswa.id');
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        $raw = $this->db->get()->result_array();

        $rekap = array();
        foreach ($raw as $row) {
            $rekap[$row['siswa_id']] = array(
                'siswa_id' => $row['siswa_id'],
                'nis' => $row['nis'],
                'nama_lengkap' => $row['nama_lengkap'],
                'hadir' => (int)$row['hadir'],
                'izin' => (int)$row['izin'],
                'sakit' => (int)$row['sakit'],
                'alpa' => (int)$row['alpa'],
                'terlambat' => (int)$row['terlambat'],
                'dispen' => (int)$row['dispen'],
                'Hadir' => (int)$row['hadir'],
                'Izin' => (int)$row['izin'],
                'Sakit' => (int)$row['sakit'],
                'Alpa' => (int)$row['alpa'],
                'Terlambat' => (int)$row['terlambat'],
                'Dispen' => (int)$row['dispen'],
                'total_pertemuan' => (int)$row['total_pertemuan']
            );
        }
        return $rekap;
    }
}
