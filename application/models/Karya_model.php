<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karya_model extends MY_Model {
    protected $table = 'karya_pembelajaran';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_karya($filters = array()) {
        $this->db->select('karya_pembelajaran.*, guru.nama_lengkap as nama_guru, kelas.nama_kelas, mata_pelajaran.nama_mapel');
        $this->db->join('guru', 'guru.id = karya_pembelajaran.guru_id');
        $this->db->join('kelas', 'kelas.id = karya_pembelajaran.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = karya_pembelajaran.mapel_id');
        
        if (isset($filters['guru_id']) && $filters['guru_id']) {
            $this->db->where('karya_pembelajaran.guru_id', $filters['guru_id']);
        }
        if (isset($filters['kelas_id']) && $filters['kelas_id']) {
            $this->db->where('karya_pembelajaran.kelas_id', $filters['kelas_id']);
        }
        if (isset($filters['mapel_id']) && $filters['mapel_id']) {
            $this->db->where('karya_pembelajaran.mapel_id', $filters['mapel_id']);
        }
        if (isset($filters['status_publikasi']) && $filters['status_publikasi']) {
            $this->db->where('karya_pembelajaran.status_publikasi', $filters['status_publikasi']);
        }

        $this->db->order_by('karya_pembelajaran.id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }
}
