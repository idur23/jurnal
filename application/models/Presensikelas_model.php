<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensikelas_model extends MY_Model {
    protected $table = 'presensi_kelas';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_jurnal($jurnal_id) {
        $this->db->select('presensi_kelas.*, ruangan.nama_ruangan');
        $this->db->join('ruangan', 'ruangan.id = presensi_kelas.ruangan_id', 'left');
        $this->db->where('presensi_kelas.jurnal_id', $jurnal_id);
        return $this->db->get($this->table)->row_array();
    }

    public function has_presensi_kelas($jurnal_id) {
        $count = $this->db->where('jurnal_id', $jurnal_id)->count_all_results($this->table);
        return ($count > 0);
    }

    public function get_detail($id) {
        $this->db->select('presensi_kelas.*, jurnal_guru.kode_jurnal, jurnal_guru.jam_ke, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, ruangan.nama_ruangan');
        $this->db->join('jurnal_guru', 'jurnal_guru.id = presensi_kelas.jurnal_id');
        $this->db->join('kelas', 'kelas.id = presensi_kelas.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = presensi_kelas.mapel_id');
        $this->db->join('guru', 'guru.id = presensi_kelas.guru_id');
        $this->db->join('ruangan', 'ruangan.id = presensi_kelas.ruangan_id', 'left');
        $this->db->where('presensi_kelas.id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function get_all_with_relations($filters = array()) {
        $this->db->select('presensi_kelas.*, jurnal_guru.kode_jurnal, jurnal_guru.file_dokumentasi as jurnal_file_dokumentasi, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, ruangan.nama_ruangan');
        $this->db->join('jurnal_guru', 'jurnal_guru.id = presensi_kelas.jurnal_id');
        $this->db->join('kelas', 'kelas.id = presensi_kelas.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = presensi_kelas.mapel_id');
        $this->db->join('guru', 'guru.id = presensi_kelas.guru_id');
        $this->db->join('ruangan', 'ruangan.id = presensi_kelas.ruangan_id', 'left');

        if (!empty($filters['guru_id'])) {
            $this->db->where('presensi_kelas.guru_id', $filters['guru_id']);
        }
        if (!empty($filters['kelas_id'])) {
            $this->db->where('presensi_kelas.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['mapel_id'])) {
            $this->db->where('presensi_kelas.mapel_id', $filters['mapel_id']);
        }
        if (!empty($filters['status_pembelajaran'])) {
            $this->db->where('presensi_kelas.status_pembelajaran', $filters['status_pembelajaran']);
        }
        if (!empty($filters['tanggal_mulai']) && !empty($filters['tanggal_selesai'])) {
            $this->db->where('presensi_kelas.tanggal >=', $filters['tanggal_mulai']);
            $this->db->where('presensi_kelas.tanggal <=', $filters['tanggal_selesai']);
        }

        // Add semester and TP filtering if requested
        if (!empty($filters['tahun_pelajaran_id'])) {
            $this->db->where('jurnal_guru.tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        }

        $this->db->order_by('presensi_kelas.tanggal', 'DESC');
        $this->db->order_by('presensi_kelas.id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }
}
