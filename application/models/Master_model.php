<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    // --- Tahun Pelajaran ---
    public function get_active_tahun_pelajaran() {
        $this->db->where('is_active', 1);
        return $this->db->get('tahun_pelajaran')->row_array();
    }

    public function get_all_tahun_pelajaran() {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tahun_pelajaran')->result_array();
    }

    public function set_active_tahun_pelajaran($id) {
        $this->db->update('tahun_pelajaran', array('is_active' => 0));
        $this->db->where('id', $id);
        return $this->db->update('tahun_pelajaran', array('is_active' => 1));
    }

    // --- Kelas ---
    public function get_all_kelas() {
        $this->db->select('kelas.*, guru.nama_lengkap as nama_wali_kelas, guru.nip as nip_wali');
        $this->db->join('guru', 'guru.id = kelas.wali_kelas_id', 'left');
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        return $this->db->get('kelas')->result_array();
    }

    public function get_kelas_by_wali_user_id($user_id) {
        $this->db->select('kelas.*, guru.id as guru_id, guru.nama_lengkap as nama_wali');
        $this->db->join('guru', 'guru.id = kelas.wali_kelas_id');
        $this->db->where('guru.user_id', $user_id);
        return $this->db->get('kelas')->row_array();
    }

    public function get_kelas_by_guru($guru_id, $tp_id = NULL) {
        $this->db->select('DISTINCT(kelas.id), kelas.nama_kelas, kelas.kode_kelas, kelas.tingkat');
        $this->db->join('jadwal_pelajaran', 'jadwal_pelajaran.kelas_id = kelas.id');
        $this->db->where('jadwal_pelajaran.guru_id', $guru_id);
        if ($tp_id) {
            $this->db->where('jadwal_pelajaran.tahun_pelajaran_id', $tp_id);
        }
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $res = $this->db->get('kelas')->result_array();

        if (empty($res)) {
            return $this->get_all_kelas();
        }
        return $res;
    }

    public function get_kelas_by_guru_or_wali($guru_id, $user_id, $tp_id = NULL) {
        // 1. From jadwal_pelajaran
        $this->db->select('DISTINCT(kelas.id), kelas.nama_kelas, kelas.kode_kelas, kelas.tingkat');
        $this->db->join('jadwal_pelajaran', 'jadwal_pelajaran.kelas_id = kelas.id');
        $this->db->where('jadwal_pelajaran.guru_id', $guru_id);
        if ($tp_id) {
            $this->db->where('jadwal_pelajaran.tahun_pelajaran_id', $tp_id);
        }
        $res1 = $this->db->get('kelas')->result_array();

        // 2. From guru_mapel -> mapel_kelas (classes for subjects taught by guru)
        $mapel_ids = $this->get_mapel_ids_by_guru($guru_id);
        $res_mapel = array();
        if (!empty($mapel_ids)) {
            $this->db->select('DISTINCT(kelas.id), kelas.nama_kelas, kelas.kode_kelas, kelas.tingkat');
            $this->db->join('mapel_kelas', 'mapel_kelas.kelas_id = kelas.id');
            $this->db->where_in('mapel_kelas.mapel_id', $mapel_ids);
            $res_mapel = $this->db->get('kelas')->result_array();
        }

        // 3. From wali kelas
        $this->db->select('kelas.id, kelas.nama_kelas, kelas.kode_kelas, kelas.tingkat');
        $this->db->join('guru', 'guru.id = kelas.wali_kelas_id');
        $this->db->where('guru.user_id', $user_id);
        $res2 = $this->db->get('kelas')->result_array();

        $merged = array();
        $ids = array();
        foreach (array_merge($res1, $res_mapel, $res2) as $k) {
            if (!in_array($k['id'], $ids)) {
                $ids[] = $k['id'];
                $merged[] = $k;
            }
        }

        if (empty($merged)) {
            return $this->get_all_kelas();
        }

        usort($merged, function($a, $b) {
            return strcmp($a['nama_kelas'], $b['nama_kelas']);
        });

        return $merged;
    }

    // --- Mata Pelajaran ---
    public function get_all_mapel() {
        $this->db->order_by('nama_mapel', 'ASC');
        return $this->db->get('mata_pelajaran')->result_array();
    }

    public function get_mapel_ids_by_guru($guru_id) {
        $res = $this->db->get_where('guru_mapel', array('guru_id' => $guru_id))->result_array();
        $mapel_ids = array();
        foreach ($res as $r) {
            $mapel_ids[] = $r['mapel_id'];
        }
        return $mapel_ids;
    }

    public function save_guru_mapel($guru_id, $mapel_ids = array()) {
        $this->db->where('guru_id', $guru_id);
        $this->db->delete('guru_mapel');
        if (!empty($mapel_ids) && is_array($mapel_ids)) {
            foreach ($mapel_ids as $m_id) {
                if ($m_id) {
                    $this->db->insert('guru_mapel', array(
                        'guru_id' => $guru_id,
                        'mapel_id' => $m_id
                    ));
                }
            }
        }
    }

    public function get_kelas_ids_by_mapel($mapel_id) {
        $res = $this->db->get_where('mapel_kelas', array('mapel_id' => $mapel_id))->result_array();
        $kelas_ids = array();
        foreach ($res as $r) {
            $kelas_ids[] = (int)$r['kelas_id'];
        }
        return $kelas_ids;
    }

    public function save_mapel_kelas($mapel_id, $kelas_ids = array()) {
        $this->db->where('mapel_id', $mapel_id);
        $this->db->delete('mapel_kelas');
        if (!empty($kelas_ids) && is_array($kelas_ids)) {
            foreach ($kelas_ids as $k_id) {
                if ($k_id) {
                    $this->db->insert('mapel_kelas', array(
                        'mapel_id' => $mapel_id,
                        'kelas_id' => $k_id
                    ));
                }
            }
        }
    }

    public function get_mapel_by_guru($guru_id, $tp_id = NULL, $kelas_id = NULL) {
        // 1. Try from jadwal_pelajaran
        $this->db->select('DISTINCT(mata_pelajaran.id), mata_pelajaran.kode_mapel, mata_pelajaran.nama_mapel, mata_pelajaran.kkm');
        $this->db->join('jadwal_pelajaran', 'jadwal_pelajaran.mapel_id = mata_pelajaran.id');
        $this->db->where('jadwal_pelajaran.guru_id', $guru_id);
        if ($tp_id) {
            $this->db->where('jadwal_pelajaran.tahun_pelajaran_id', $tp_id);
        }
        if ($kelas_id) {
            $this->db->where('jadwal_pelajaran.kelas_id', $kelas_id);
        }
        $this->db->order_by('mata_pelajaran.nama_mapel', 'ASC');
        $res = $this->db->get('mata_pelajaran')->result_array();

        if (!empty($res)) {
            return $res;
        }

        // 2. Try from guru_mapel assigned subjects
        $mapel_ids = $this->get_mapel_ids_by_guru($guru_id);
        if (!empty($mapel_ids)) {
            $this->db->where_in('id', $mapel_ids);
            $this->db->order_by('nama_mapel', 'ASC');
            return $this->db->get('mata_pelajaran')->result_array();
        }

        // 3. Fallback all mapel
        return $this->get_all_mapel();
    }

    // --- Ruangan ---
    public function get_all_ruangan() {
        $this->db->order_by('nama_ruangan', 'ASC');
        return $this->db->get('ruangan')->result_array();
    }

    // --- Jam Pelajaran ---
    public function get_all_jam() {
        $this->db->order_by('jam_ke', 'ASC');
        return $this->db->get('jam_pelajaran')->result_array();
    }

    // --- Guru ---
    public function get_all_guru() {
        $this->db->select('guru.*, users.username, users.email as user_email, users.is_active, users.role_id, roles.role_name');
        $this->db->join('users', 'users.id = guru.user_id', 'left');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->order_by('guru.nama_lengkap', 'ASC');
        $gurus = $this->db->get('guru')->result_array();

        foreach ($gurus as &$g) {
            $g['mapel_ids'] = $this->get_mapel_ids_by_guru($g['id']);
            $g['list_mapel_nama'] = array();
            if (!empty($g['mapel_ids'])) {
                $this->db->where_in('id', $g['mapel_ids']);
                $mapels = $this->db->get('mata_pelajaran')->result_array();
                foreach ($mapels as $m) {
                    $g['list_mapel_nama'][] = $m['nama_mapel'];
                }
            }
        }
        return $gurus;
    }

    public function get_guru_by_user_id($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('guru')->row_array();
    }

    // --- Siswa ---
    public function get_all_siswa($kelas_id = NULL, $tingkat = NULL) {
        $this->db->select('siswa.*, kelas.nama_kelas, kelas.kode_kelas, kelas.tingkat');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id');
        if ($kelas_id) {
            $this->db->where('siswa.kelas_id', $kelas_id);
        }
        if ($tingkat) {
            $this->db->where('kelas.tingkat', $tingkat);
        }
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        return $this->db->get('siswa')->result_array();
    }

    public function get_siswa_by_kelas($kelas_id) {
        return $this->get_all_siswa($kelas_id);
    }

    // --- Jadwal Pelajaran ---
    public function get_all_jadwal($tp_id = NULL) {
        $this->db->select('jadwal_pelajaran.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, ruangan.nama_ruangan');
        $this->db->join('kelas', 'kelas.id = jadwal_pelajaran.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = jadwal_pelajaran.mapel_id');
        $this->db->join('guru', 'guru.id = jadwal_pelajaran.guru_id');
        $this->db->join('ruangan', 'ruangan.id = jadwal_pelajaran.ruangan_id', 'left');
        if ($tp_id) {
            $this->db->where('jadwal_pelajaran.tahun_pelajaran_id', $tp_id);
        }
        $this->db->order_by('FIELD(jadwal_pelajaran.hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu")');
        $this->db->order_by('jadwal_pelajaran.jam_mulai_ke', 'ASC');
        return $this->db->get('jadwal_pelajaran')->result_array();
    }
}
