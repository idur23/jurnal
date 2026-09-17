<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisi_model extends MY_Model {

    protected $table = 'supervisi';

    public function __construct() {
        parent::__construct();
    }

    // ============================================================
    // DASHBOARD KEPALA MADRASAH
    // ============================================================
    public function get_kamad_dashboard_stats($tp_id = NULL, $semester = NULL) {
        // Total Guru
        $total_guru = $this->db->count_all('guru');

        // Total Guru Sudah Disupervisi (selesai at least 1 form in current tp/semester if specified)
        $this->db->select('COUNT(DISTINCT guru_id) as total');
        $this->db->where('status', 'SELESAI');
        if ($tp_id) $this->db->where('tahun_pelajaran_id', $tp_id);
        if ($semester) $this->db->where('semester', $semester);
        $res = $this->db->get('supervisi')->row_array();
        $guru_disupervisi = (int)($res['total'] ?? 0);
        $guru_belum_disupervisi = max(0, $total_guru - $guru_disupervisi);

        // Supervisi Berjalan & Selesai
        $this->db->where_in('status', array('DRAFT', 'DALAM PROSES'));
        if ($tp_id) $this->db->where('tahun_pelajaran_id', $tp_id);
        if ($semester) $this->db->where('semester', $semester);
        $supervisi_berjalan = $this->db->count_all_results('supervisi');

        $this->db->where('status', 'SELESAI');
        if ($tp_id) $this->db->where('tahun_pelajaran_id', $tp_id);
        if ($semester) $this->db->where('semester', $semester);
        $supervisi_selesai = $this->db->count_all_results('supervisi');

        // Rata-rata hasil supervisi
        $this->db->select('AVG(nilai_akhir) as avg_nilai');
        $this->db->where('status', 'SELESAI');
        if ($tp_id) $this->db->where('tahun_pelajaran_id', $tp_id);
        if ($semester) $this->db->where('semester', $semester);
        $avg_res = $this->db->get('supervisi')->row_array();
        $rata_rata_hasil = round((float)($avg_res['avg_nilai'] ?? 0), 2);

        // Total Supervisi per Form
        $form_counts = array(1 => 0, 2 => 0, 3 => 0, 4 => 0);
        for ($f = 1; $f <= 4; $f++) {
            $this->db->where('form_id', $f);
            $this->db->where('status', 'SELESAI');
            if ($tp_id) $this->db->where('tahun_pelajaran_id', $tp_id);
            if ($semester) $this->db->where('semester', $semester);
            $form_counts[$f] = $this->db->count_all_results('supervisi');
        }

        // Supervisi Terbaru (Top 10)
        $supervisi_terbaru = $this->get_recent_supervisions(10, $tp_id, $semester);

        // Chart Data per Form Average Score
        $chart_form_avg = array();
        for ($f = 1; $f <= 4; $f++) {
            $this->db->select('AVG(nilai_akhir) as avg_val');
            $this->db->where('form_id', $f);
            $this->db->where('status', 'SELESAI');
            if ($tp_id) $this->db->where('tahun_pelajaran_id', $tp_id);
            if ($semester) $this->db->where('semester', $semester);
            $r = $this->db->get('supervisi')->row_array();
            $chart_form_avg['Form ' . $f] = round((float)($r['avg_val'] ?? 0), 2);
        }

        // Perkembangan Hasil Supervisi (Monthly or Date Trend)
        $this->db->select("DATE_FORMAT(tanggal_supervisi, '%Y-%m') as periode, AVG(nilai_akhir) as avg_nilai");
        $this->db->where('status', 'SELESAI');
        if ($tp_id) $this->db->where('tahun_pelajaran_id', $tp_id);
        if ($semester) $this->db->where('semester', $semester);
        $this->db->group_by("DATE_FORMAT(tanggal_supervisi, '%Y-%m')");
        $this->db->order_by("periode", "ASC");
        $trend = $this->db->get('supervisi')->result_array();

        return array(
            'total_guru' => $total_guru,
            'guru_disupervisi' => $guru_disupervisi,
            'guru_belum_disupervisi' => $guru_belum_disupervisi,
            'supervisi_berjalan' => $supervisi_berjalan,
            'supervisi_selesai' => $supervisi_selesai,
            'rata_rata_hasil' => $rata_rata_hasil,
            'total_form1' => $form_counts[1],
            'total_form2' => $form_counts[2],
            'total_form3' => $form_counts[3],
            'total_form4' => $form_counts[4],
            'chart_progress' => array(
                'Sudah Disupervisi' => $guru_disupervisi,
                'Belum Disupervisi' => $guru_belum_disupervisi
            ),
            'chart_form_avg' => $chart_form_avg,
            'trend' => $trend,
            'supervisi_terbaru' => $supervisi_terbaru
        );
    }

    // ============================================================
    // DASHBOARD WAKA KURIKULUM
    // ============================================================
    public function get_waka_dashboard_stats($tp_id = NULL, $semester = NULL) {
        $stats = $this->get_kamad_dashboard_stats($tp_id, $semester);

        // Additional Waka specific charts:
        // Rekap per Mata Pelajaran
        $this->db->select('mata_pelajaran.nama_mapel, COUNT(supervisi.id) as total_sup, AVG(supervisi.nilai_akhir) as avg_nilai');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = supervisi.mapel_id');
        $this->db->where('supervisi.status', 'SELESAI');
        if ($tp_id) $this->db->where('supervisi.tahun_pelajaran_id', $tp_id);
        if ($semester) $this->db->where('supervisi.semester', $semester);
        $this->db->group_by('mata_pelajaran.id');
        $this->db->order_by('total_sup', 'DESC');
        $this->db->limit(10);
        $rekap_mapel = $this->db->get('supervisi')->result_array();

        // Rekap per Guru
        $this->db->select('guru.nama_lengkap as nama_guru, COUNT(supervisi.id) as total_form, AVG(supervisi.nilai_akhir) as avg_nilai');
        $this->db->join('guru', 'guru.id = supervisi.guru_id');
        $this->db->where('supervisi.status', 'SELESAI');
        if ($tp_id) $this->db->where('supervisi.tahun_pelajaran_id', $tp_id);
        if ($semester) $this->db->where('supervisi.semester', $semester);
        $this->db->group_by('guru.id');
        $this->db->order_by('avg_nilai', 'DESC');
        $this->db->limit(10);
        $rekap_guru = $this->db->get('supervisi')->result_array();

        $stats['rekap_mapel'] = $rekap_mapel;
        $stats['rekap_guru'] = $rekap_guru;
        return $stats;
    }

    // ============================================================
    // RECENT SUPERVISIONS TABLE
    // ============================================================
    public function get_recent_supervisions($limit = 10, $tp_id = NULL, $semester = NULL) {
        $this->db->select('supervisi.*, guru.nama_lengkap as nama_guru, guru.nip as nip_guru, mata_pelajaran.nama_mapel, kelas.nama_kelas, users.full_name as nama_supervisor, supervisi_form.kode_form, supervisi_form.nama_form');
        $this->db->join('guru', 'guru.id = supervisi.guru_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = supervisi.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = supervisi.kelas_id', 'left');
        $this->db->join('users', 'users.id = supervisi.supervisor_id', 'left');
        $this->db->join('supervisi_form', 'supervisi_form.id = supervisi.form_id');
        if ($tp_id) $this->db->where('supervisi.tahun_pelajaran_id', $tp_id);
        if ($semester) $this->db->where('supervisi.semester', $semester);
        $this->db->order_by('supervisi.updated_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('supervisi')->result_array();
    }

    // ============================================================
    // DAFTAR GURU UNTUK SUPERVISI
    // ============================================================
    public function get_guru_supervisi_list($tp_id = NULL, $semester = NULL) {
        $this->db->select('guru.id as guru_id, guru.nama_lengkap as nama_guru, guru.nip, guru.user_id');
        $this->db->order_by('guru.nama_lengkap', 'ASC');
        $gurus = $this->db->get('guru')->result_array();

        foreach ($gurus as &$g) {
            // Get main mapels
            $this->db->select('mata_pelajaran.nama_mapel');
            $this->db->join('mata_pelajaran', 'mata_pelajaran.id = guru_mapel.mapel_id');
            $this->db->where('guru_mapel.guru_id', $g['guru_id']);
            $mapels = $this->db->get('guru_mapel')->result_array();
            $g['mapels'] = array_column($mapels, 'nama_mapel');

            // Get main class from schedule or wali
            $this->db->select('kelas.nama_kelas');
            $this->db->join('kelas', 'kelas.id = jadwal_pelajaran.kelas_id');
            $this->db->where('jadwal_pelajaran.guru_id', $g['guru_id']);
            if ($tp_id) $this->db->where('jadwal_pelajaran.tahun_pelajaran_id', $tp_id);
            $this->db->group_by('kelas.id');
            $kelas_list = $this->db->get('jadwal_pelajaran')->result_array();
            $g['kelas'] = array_column($kelas_list, 'nama_kelas');

            // Status per Form 1 - 4
            $forms_status = array(1 => 'Belum', 2 => 'Belum', 3 => 'Belum', 4 => 'Belum');
            for ($f = 1; $f <= 4; $f++) {
                $this->db->select('status, id');
                $this->db->where('guru_id', $g['guru_id']);
                $this->db->where('form_id', $f);
                if ($tp_id) $this->db->where('tahun_pelajaran_id', $tp_id);
                if ($semester) $this->db->where('semester', $semester);
                $this->db->order_by('id', 'DESC');
                $sup = $this->db->get('supervisi')->row_array();
                if (!empty($sup)) {
                    $forms_status[$f] = $sup['status'];
                }
            }
            $g['form_status'] = $forms_status;

            // Overall Status
            $finished_count = 0;
            $in_progress_count = 0;
            foreach ($forms_status as $st) {
                if ($st == 'SELESAI') $finished_count++;
                if ($st == 'DRAFT' || $st == 'DALAM PROSES') $in_progress_count++;
            }

            if ($finished_count == 4) {
                $g['overall_status'] = 'Selesai';
            } elseif ($finished_count > 0 || $in_progress_count > 0) {
                $g['overall_status'] = 'Dalam Proses';
            } else {
                $g['overall_status'] = 'Belum';
            }
        }

        return $gurus;
    }

    // ============================================================
    // MASTER FORMS & INDIKATOR
    // ============================================================
    public function get_forms() {
        return $this->db->get('supervisi_form')->result_array();
    }

    public function get_form_by_id($form_id) {
        return $this->db->get_where('supervisi_form', array('id' => $form_id))->row_array();
    }

    public function get_indikator_by_form($form_id) {
        $this->db->where('form_id', $form_id);
        $this->db->order_by('nomor_urut', 'ASC');
        return $this->db->get('supervisi_indikator')->result_array();
    }

    // ============================================================
    // SUPERVISI TRANSACTION CRUD
    // ============================================================
    public function get_supervisi_by_id($id) {
        $this->db->select('supervisi.*, guru.nama_lengkap as nama_guru, guru.nip as nip_guru, guru.user_id as guru_user_id, mata_pelajaran.nama_mapel, kelas.nama_kelas, users.full_name as nama_supervisor, supervisi_form.kode_form, supervisi_form.nama_form, tahun_pelajaran.tahun');
        $this->db->join('guru', 'guru.id = supervisi.guru_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = supervisi.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = supervisi.kelas_id', 'left');
        $this->db->join('users', 'users.id = supervisi.supervisor_id', 'left');
        $this->db->join('supervisi_form', 'supervisi_form.id = supervisi.form_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = supervisi.tahun_pelajaran_id', 'left');
        $this->db->where('supervisi.id', $id);
        return $this->db->get('supervisi')->row_array();
    }

    public function get_supervisi_by_uuid($uuid) {
        $this->db->select('id');
        $this->db->where('uuid', $uuid);
        $res = $this->db->get('supervisi')->row_array();
        if ($res) {
            return $this->get_supervisi_by_id($res['id']);
        }
        return NULL;
    }

    public function get_supervisi_details($supervisi_id) {
        $this->db->select('supervisi_detail.*, supervisi_indikator.sub_bagian, supervisi_indikator.nomor_urut, supervisi_indikator.kode_indikator, supervisi_indikator.nama_indikator');
        $this->db->join('supervisi_indikator', 'supervisi_indikator.id = supervisi_detail.indikator_id');
        $this->db->where('supervisi_detail.supervisi_id', $supervisi_id);
        $this->db->order_by('supervisi_indikator.nomor_urut', 'ASC');
        return $this->db->get('supervisi_detail')->result_array();
    }

    /**
     * Save Draft or Submit Supervisi
     */
    public function save_supervisi($data, $details, $user_id, $user_role, $is_submit = false) {
        $this->db->trans_start();

        $supervisi_id = isset($data['id']) ? (int)$data['id'] : 0;
        $form_id = (int)$data['form_id'];

        // Calculate score server side
        $indikators = $this->get_indikator_by_form($form_id);
        $total_items = count($indikators);
        $skor_maksimal = $total_items * 4; // Each item max score is 4
        $jumlah_skor = 0;

        foreach ($details as $ind_id => $det) {
            $skor = (int)($det['skor'] ?? 0);
            if ($skor < 0) $skor = 0;
            if ($skor > 4) $skor = 4;
            $jumlah_skor += $skor;
        }

        $nilai_akhir = ($skor_maksimal > 0) ? round(($jumlah_skor / $skor_maksimal) * 100, 2) : 0.00;

        $save_data = array(
            'guru_id' => (int)$data['guru_id'],
            'supervisor_id' => (int)$data['supervisor_id'],
            'supervisor_role' => $data['supervisor_role'],
            'mapel_id' => (int)$data['mapel_id'],
            'kelas_id' => (int)$data['kelas_id'],
            'tahun_pelajaran_id' => (int)$data['tahun_pelajaran_id'],
            'semester' => $data['semester'],
            'form_id' => $form_id,
            'tahap' => $data['tahap'] ?? 'Tahap 1',
            'tanggal_supervisi' => $data['tanggal_supervisi'] ?? date('Y-m-d'),
            'jam_mulai' => $data['jam_mulai'] ?? NULL,
            'jam_selesai' => $data['jam_selesai'] ?? NULL,
            'status' => $is_submit ? 'SELESAI' : 'DRAFT',
            'jumlah_skor' => $jumlah_skor,
            'skor_maksimal' => $skor_maksimal,
            'nilai_akhir' => $nilai_akhir,
            'catatan_analisis' => $data['catatan_analisis'] ?? NULL,
            'tindak_lanjut' => $data['tindak_lanjut'] ?? NULL,
            'saran' => $data['saran'] ?? NULL
        );

        if ($supervisi_id > 0) {
            // Get data before edit for audit history
            $old_data = $this->get_supervisi_by_id($supervisi_id);

            $this->db->where('id', $supervisi_id);
            $this->db->update('supervisi', $save_data);

            $act = $is_submit ? 'Mengirim & Menyelesaikan Supervisi Form ' . $form_id : 'Menyimpan Draft Supervisi Form ' . $form_id;
            $this->log_histori($supervisi_id, $user_id, $user_role, $act, json_encode($old_data), json_encode($save_data));
        } else {
            $save_data['uuid'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0cff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            $this->db->insert('supervisi', $save_data);
            $supervisi_id = $this->db->insert_id();

            $act = $is_submit ? 'Membuat & Menyelesaikan Supervisi Form ' . $form_id : 'Membuat Draft Supervisi Form ' . $form_id;
            $this->log_histori($supervisi_id, $user_id, $user_role, $act, NULL, json_encode($save_data));
        }

        // Save Details
        $this->db->where('supervisi_id', $supervisi_id);
        $this->db->delete('supervisi_detail');

        foreach ($details as $ind_id => $det) {
            $skor = (int)($det['skor'] ?? 0);
            if ($skor < 0) $skor = 0;
            if ($skor > 4) $skor = 4;

            $this->db->insert('supervisi_detail', array(
                'supervisi_id' => $supervisi_id,
                'indikator_id' => (int)$ind_id,
                'skor' => $skor,
                'catatan_item' => $det['catatan'] ?? NULL
            ));
        }

        // Send notification to teacher if submitted
        if ($is_submit) {
            $guru = $this->db->get_where('guru', array('id' => $data['guru_id']))->row_array();
            if ($guru && !empty($guru['user_id'])) {
                $form_info = $this->get_form_by_id($form_id);
                $this->db->insert('supervisi_notifikasi', array(
                    'user_id' => $guru['user_id'],
                    'supervisi_id' => $supervisi_id,
                    'title' => 'Supervisi Akademik Telah Selesai',
                    'message' => 'Supervisi ' . ($form_info['nama_form'] ?? ('Form ' . $form_id)) . ' Anda telah selesai dilaksanakan dengan Nilai: ' . $nilai_akhir . '.'
                ));
            }
        }

        $this->db->trans_complete();

        return ($this->db->trans_status() !== FALSE) ? $supervisi_id : FALSE;
    }

    // Audit History Logging
    public function log_histori($supervisi_id, $user_id, $user_role, $activity, $before_data = NULL, $after_data = NULL) {
        $this->db->insert('supervisi_histori', array(
            'supervisi_id' => $supervisi_id,
            'user_id' => $user_id,
            'user_role' => $user_role,
            'activity' => $activity,
            'data_before' => $before_data,
            'data_after' => $after_data
        ));
    }

    public function get_histori($supervisi_id) {
        $this->db->select('supervisi_histori.*, users.full_name as user_name');
        $this->db->join('users', 'users.id = supervisi_histori.user_id', 'left');
        $this->db->where('supervisi_histori.supervisi_id', $supervisi_id);
        $this->db->order_by('supervisi_histori.id', 'DESC');
        return $this->db->get('supervisi_histori')->result_array();
    }

    // ============================================================
    // REKAP & LAPORAN FILTERED
    // ============================================================
    public function get_rekap($filters = array(), $limit = NULL, $offset = NULL) {
        $this->db->select('supervisi.*, guru.nama_lengkap as nama_guru, guru.nip as nip_guru, mata_pelajaran.nama_mapel, kelas.nama_kelas, users.full_name as nama_supervisor, supervisi_form.kode_form, supervisi_form.nama_form, tahun_pelajaran.tahun');
        $this->db->join('guru', 'guru.id = supervisi.guru_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = supervisi.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = supervisi.kelas_id', 'left');
        $this->db->join('users', 'users.id = supervisi.supervisor_id', 'left');
        $this->db->join('supervisi_form', 'supervisi_form.id = supervisi.form_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = supervisi.tahun_pelajaran_id', 'left');

        $this->apply_rekap_filters($filters);

        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('supervisi.id', 'DESC');
        return $this->db->get('supervisi')->result_array();
    }

    public function count_rekap($filters = array()) {
        $this->db->join('guru', 'guru.id = supervisi.guru_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = supervisi.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = supervisi.kelas_id', 'left');
        $this->db->join('users', 'users.id = supervisi.supervisor_id', 'left');
        $this->db->join('supervisi_form', 'supervisi_form.id = supervisi.form_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = supervisi.tahun_pelajaran_id', 'left');

        $this->apply_rekap_filters($filters);

        return $this->db->count_all_results('supervisi');
    }

    private function apply_rekap_filters($filters) {
        if (!empty($filters['tahun_pelajaran_id'])) {
            $this->db->where('supervisi.tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        }
        if (!empty($filters['semester'])) {
            $this->db->where('supervisi.semester', $filters['semester']);
        }
        if (!empty($filters['guru_id'])) {
            $this->db->where('supervisi.guru_id', $filters['guru_id']);
        }
        if (!empty($filters['mapel_id'])) {
            $this->db->where('supervisi.mapel_id', $filters['mapel_id']);
        }
        if (!empty($filters['kelas_id'])) {
            $this->db->where('supervisi.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['supervisor_id'])) {
            $this->db->where('supervisi.supervisor_id', $filters['supervisor_id']);
        }
        if (!empty($filters['form_id'])) {
            $this->db->where('supervisi.form_id', $filters['form_id']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('supervisi.status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start();
            $this->db->like('guru.nama_lengkap', $search);
            $this->db->or_like('mata_pelajaran.nama_mapel', $search);
            $this->db->or_like('kelas.nama_kelas', $search);
            $this->db->or_like('users.full_name', $search);
            $this->db->group_end();
        }
    }

    // ============================================================
    // GURU DETAIL & TRENDS
    // ============================================================
    public function get_guru_detail_supervisi($guru_id) {
        $guru = $this->db->get_where('guru', array('id' => $guru_id))->row_array();
        if (!$guru) return NULL;

        $this->db->select('supervisi.*, mata_pelajaran.nama_mapel, kelas.nama_kelas, users.full_name as nama_supervisor, supervisi_form.nama_form, supervisi_form.kode_form');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = supervisi.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = supervisi.kelas_id', 'left');
        $this->db->join('users', 'users.id = supervisi.supervisor_id', 'left');
        $this->db->join('supervisi_form', 'supervisi_form.id = supervisi.form_id');
        $this->db->where('supervisi.guru_id', $guru_id);
        $this->db->order_by('supervisi.tanggal_supervisi', 'DESC');
        $history = $this->db->get('supervisi')->result_array();

        return array(
            'guru' => $guru,
            'history' => $history
        );
    }

    // Follow-up Response Update by Teacher
    public function update_tindak_lanjut($id, $status_tindak_lanjut, $respon_guru) {
        $this->db->where('id', $id);
        return $this->db->update('supervisi', array(
            'status_tindak_lanjut' => $status_tindak_lanjut,
            'respon_guru' => $respon_guru,
            'respon_at' => date('Y-m-d H:i:s')
        ));
    }

    // Revision Request Mechanism
    public function request_revision($id, $user_id, $user_role, $alasan) {
        $supervisi = $this->get_supervisi_by_id($id);
        if (!$supervisi) return FALSE;

        $this->db->where('id', $id);
        $this->db->update('supervisi', array('status' => 'DALAM PROSES'));

        $this->log_histori($id, $user_id, $user_role, 'Pengajuan Revisi: ' . $alasan, json_encode($supervisi), json_encode(array('status' => 'DALAM PROSES', 'alasan' => $alasan)));
        return TRUE;
    }

    // Delete Supervisi Assessment Data
    public function delete_supervisi($id, $user_id, $user_role) {
        $supervisi = $this->get_supervisi_by_id($id);
        if (!$supervisi) return FALSE;

        $this->db->trans_start();

        // Delete related detail items, history, and notifications
        $this->db->where('supervisi_id', $id)->delete('supervisi_detail');
        $this->db->where('supervisi_id', $id)->delete('supervisi_histori');
        $this->db->where('supervisi_id', $id)->delete('supervisi_notifikasi');
        $this->db->where('id', $id)->delete('supervisi');

        // Log activity if table exists
        if ($this->db->table_exists('activity_logs')) {
            $this->db->insert('activity_logs', array(
                'user_id' => $user_id,
                'action' => 'DELETE_SUPERVISI',
                'description' => 'Menghapus data supervisi #' . $id . ' (' . ($supervisi['kode_form'] ?? '') . ') guru ' . ($supervisi['nama_guru'] ?? ''),
                'ip_address' => $this->input->ip_address(),
                'user_agent' => substr($this->input->user_agent(), 0, 255)
            ));
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Helper: Link to Teacher's Uploaded Teaching Documents
    public function get_teacher_documents($guru_id, $mapel_id = NULL) {
        $this->db->select('perangkat_ajar.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = perangkat_ajar.kelas_id', 'left');
        $this->db->where('perangkat_ajar.guru_id', $guru_id);
        if ($mapel_id) {
            $this->db->where('perangkat_ajar.mapel_id', $mapel_id);
        }
        $this->db->where('perangkat_ajar.is_active', 1);
        $this->db->order_by('perangkat_ajar.id', 'DESC');
        return $this->db->get('perangkat_ajar')->result_array();
    }
}
