<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Walikelas_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    // --- 1. Program Kelas (Jurnal Wali Kelas) ---
    public function get_program_kelas($kelas_id, $tp_id) {
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('tahun_pelajaran_id', $tp_id);
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('jurnal_walikelas')->result_array();
    }

    // --- 2. Penanganan Siswa (Counseling log) ---
    public function get_penanganan_siswa($kelas_id, $tp_id) {
        $this->db->select('penanganan_siswa.*, siswa.nama_lengkap as nama_siswa, siswa.nis');
        $this->db->join('siswa', 'siswa.id = penanganan_siswa.siswa_id');
        $this->db->where('penanganan_siswa.kelas_id', $kelas_id);
        $this->db->where('penanganan_siswa.tahun_pelajaran_id', $tp_id);
        $this->db->order_by('penanganan_siswa.tanggal', 'DESC');
        return $this->db->get('penanganan_siswa')->result_array();
    }

    // --- 3. Kokurikuler ---
    public function get_kokurikuler($kelas_id, $tp_id) {
        $this->db->select('kokurikuler.*, guru.nama_lengkap as nama_guru_pendamping');
        $this->db->join('guru', 'guru.id = kokurikuler.guru_id');
        $this->db->where('kokurikuler.kelas_id', $kelas_id);
        $this->db->where('kokurikuler.tahun_pelajaran_id', $tp_id);
        $this->db->order_by('kokurikuler.tanggal', 'DESC');
        return $this->db->get('kokurikuler')->result_array();
    }

    public function get_penanganan_by_siswa($siswa_id) {
        $this->db->select('penanganan_siswa.*, siswa.nama_lengkap as nama_siswa, siswa.nis, siswa.nisn, kelas.nama_kelas, guru.nama_lengkap as nama_guru, tahun_pelajaran.tahun, tahun_pelajaran.semester');
        $this->db->join('siswa', 'siswa.id = penanganan_siswa.siswa_id');
        $this->db->join('kelas', 'kelas.id = penanganan_siswa.kelas_id');
        $this->db->join('guru', 'guru.id = penanganan_siswa.wali_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = penanganan_siswa.tahun_pelajaran_id');
        $this->db->where('penanganan_siswa.siswa_id', $siswa_id);
        $this->db->order_by('penanganan_siswa.tanggal', 'ASC');
        return $this->db->get('penanganan_siswa')->result_array();
    }

    public function get_stats_per_siswa($tp_id, $kelas_id = NULL) {
        $this->db->select('siswa.nama_lengkap, COUNT(penanganan_siswa.id) as total');
        $this->db->join('siswa', 'siswa.id = penanganan_siswa.siswa_id');
        $this->db->where('penanganan_siswa.tahun_pelajaran_id', $tp_id);
        if ($kelas_id) {
            $this->db->where('penanganan_siswa.kelas_id', $kelas_id);
        }
        $this->db->group_by('penanganan_siswa.siswa_id');
        $this->db->order_by('total', 'DESC');
        $this->db->limit(10);
        return $this->db->get('penanganan_siswa')->result_array();
    }

    public function get_stats_per_kelas($tp_id) {
        $this->db->select('kelas.nama_kelas, COUNT(penanganan_siswa.id) as total');
        $this->db->join('kelas', 'kelas.id = penanganan_siswa.kelas_id');
        $this->db->where('penanganan_siswa.tahun_pelajaran_id', $tp_id);
        $this->db->group_by('penanganan_siswa.kelas_id');
        $this->db->order_by('total', 'DESC');
        return $this->db->get('penanganan_siswa')->result_array();
    }

    public function get_stats_per_kategori($tp_id, $kelas_id = NULL) {
        $this->db->select('penanganan_siswa.kategori, COUNT(penanganan_siswa.id) as total');
        $this->db->where('penanganan_siswa.tahun_pelajaran_id', $tp_id);
        if ($kelas_id) {
            $this->db->where('penanganan_siswa.kelas_id', $kelas_id);
        }
        $this->db->group_by('penanganan_siswa.kategori');
        $this->db->order_by('total', 'DESC');
        return $this->db->get('penanganan_siswa')->result_array();
    }

    public function get_stats_per_status($tp_id, $kelas_id = NULL) {
        $this->db->select('penanganan_siswa.status, COUNT(penanganan_siswa.id) as total');
        $this->db->where('penanganan_siswa.tahun_pelajaran_id', $tp_id);
        if ($kelas_id) {
            $this->db->where('penanganan_siswa.kelas_id', $kelas_id);
        }
        $this->db->group_by('penanganan_siswa.status');
        $this->db->order_by('total', 'DESC');
        return $this->db->get('penanganan_siswa')->result_array();
    }

    public function get_stats_tren_bulanan($tp_id, $kelas_id = NULL) {
        $this->db->select("DATE_FORMAT(penanganan_siswa.tanggal, '%Y-%m') as bulan, COUNT(penanganan_siswa.id) as total");
        $this->db->where('penanganan_siswa.tahun_pelajaran_id', $tp_id);
        if ($kelas_id) {
            $this->db->where('penanganan_siswa.kelas_id', $kelas_id);
        }
        $this->db->group_by("bulan");
        $this->db->order_by("bulan", "ASC");
        return $this->db->get('penanganan_siswa')->result_array();
    }

    public function get_penanganan_filtered($filters = array()) {
        $this->db->select('penanganan_siswa.*, siswa.nama_lengkap as nama_siswa, siswa.nis, siswa.nisn, kelas.nama_kelas, guru.nama_lengkap as nama_guru, tahun_pelajaran.tahun, tahun_pelajaran.semester');
        $this->db->join('siswa', 'siswa.id = penanganan_siswa.siswa_id');
        $this->db->join('kelas', 'kelas.id = penanganan_siswa.kelas_id');
        $this->db->join('guru', 'guru.id = penanganan_siswa.wali_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = penanganan_siswa.tahun_pelajaran_id');

        if (!empty($filters['siswa_id'])) {
            $this->db->where('penanganan_siswa.siswa_id', $filters['siswa_id']);
        }
        if (!empty($filters['kelas_id'])) {
            $this->db->where('penanganan_siswa.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['semester'])) {
            $this->db->where('tahun_pelajaran.semester', $filters['semester']);
        }
        if (!empty($filters['tahun_pelajaran_id'])) {
            $this->db->where('penanganan_siswa.tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        }
        if (!empty($filters['tanggal_mulai'])) {
            $this->db->where('penanganan_siswa.tanggal >=', $filters['tanggal_mulai']);
        }
        if (!empty($filters['tanggal_selesai'])) {
            $this->db->where('penanganan_siswa.tanggal <=', $filters['tanggal_selesai']);
        }
        if (!empty($filters['kategori'])) {
            $this->db->where('penanganan_siswa.kategori', $filters['kategori']);
        }

        $this->db->order_by('penanganan_siswa.tanggal', 'DESC');
        return $this->db->get('penanganan_siswa')->result_array();
    }

    public function get_student_kategori_stats($siswa_id, $tp_id) {
        $categories = array('Akademik', 'Disiplin', 'Perilaku', 'Kesehatan', 'Sosial');
        $stats = array_fill_keys($categories, 0);

        $this->db->select('kategori, COUNT(*) as total');
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_pelajaran_id', $tp_id);
        $this->db->group_by('kategori');
        $res = $this->db->get('penanganan_siswa')->result_array();

        foreach ($res as $r) {
            if (isset($stats[$r['kategori']])) {
                $stats[$r['kategori']] = (int)$r['total'];
            }
        }
        return $stats;
    }

    public function get_student_trend_stats($siswa_id, $tp_id) {
        $this->db->select("DATE_FORMAT(tanggal, '%Y-%m') as bulan, COUNT(*) as total");
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_pelajaran_id', $tp_id);
        $this->db->group_by('bulan');
        $this->db->order_by('bulan', 'ASC');
        $res = $this->db->get('penanganan_siswa')->result_array();

        $stats = array();
        foreach ($res as $r) {
            $stats[$r['bulan']] = (int)$r['total'];
        }

        if (empty($stats)) {
            $stats[date('Y-m')] = 0;
        }
        return $stats;
    }
}

