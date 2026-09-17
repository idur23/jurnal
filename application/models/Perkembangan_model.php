<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perkembangan_model extends MY_Model {
    protected $table = 'perkembangan_siswa';

    public function __construct() {
        parent::__construct();
    }

    public function get_perkembangan_by_filters($kelas_id, $mapel_id, $tp_id) {
        $this->db->select('perkembangan_siswa.*, siswa.nis, siswa.nama_lengkap');
        $this->db->join('siswa', 'siswa.id = perkembangan_siswa.siswa_id');
        $this->db->where('perkembangan_siswa.kelas_id', $kelas_id);
        $this->db->where('perkembangan_siswa.mapel_id', $mapel_id);
        $this->db->where('perkembangan_siswa.tahun_pelajaran_id', $tp_id);
        $raw = $this->db->get($this->table)->result_array();

        $result = array();
        foreach ($raw as $r) {
            $result[$r['siswa_id']] = $r;
        }
        return $result;
    }

    public function get_perkembangan_by_kelas($kelas_id, $tp_id) {
        $this->db->select('perkembangan_siswa.*, siswa.nis, siswa.nama_lengkap, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru');
        $this->db->join('siswa', 'siswa.id = perkembangan_siswa.siswa_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perkembangan_siswa.mapel_id');
        $this->db->join('guru', 'guru.id = perkembangan_siswa.guru_id');
        $this->db->where('perkembangan_siswa.kelas_id', $kelas_id);
        $this->db->where('perkembangan_siswa.tahun_pelajaran_id', $tp_id);
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function save_batch_perkembangan($data) {
        $this->db->trans_begin();

        foreach ($data as $d) {
            $where = array(
                'tahun_pelajaran_id' => $d['tahun_pelajaran_id'],
                'kelas_id' => $d['kelas_id'],
                'mapel_id' => $d['mapel_id'],
                'siswa_id' => $d['siswa_id']
            );
            $existing = $this->db->get_where($this->table, $where)->row_array();

            $update_data = array(
                'catatan_perkembangan' => $d['catatan_perkembangan'],
                'kelebihan' => $d['kelebihan'],
                'kekurangan' => $d['kekurangan'],
                'perilaku' => $d['perilaku'],
                'keaktifan' => $d['keaktifan'],
                'kedisiplinan' => $d['kedisiplinan'],
                'motivasi' => $d['motivasi'],
                'rekomendasi' => $d['rekomendasi'],
                'guru_id' => $d['guru_id']
            );

            if ($existing) {
                $this->db->where('id', $existing['id']);
                $this->db->update($this->table, $update_data);
            } else {
                $insert_data = array_merge($d, $update_data);
                $this->db->insert($this->table, $insert_data);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_rekap_by_siswa($siswa_id, $tp_id) {
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_pelajaran_id', $tp_id);
        return $this->db->get('perkembangan_rekap')->row_array();
    }

    public function save_rekap_perkembangan($data) {
        $where = array(
            'tahun_pelajaran_id' => $data['tahun_pelajaran_id'],
            'siswa_id' => $data['siswa_id']
        );
        $existing = $this->db->get_where('perkembangan_rekap', $where)->row_array();
        if ($existing) {
            $this->db->where('id', $existing['id']);
            return $this->db->update('perkembangan_rekap', $data);
        } else {
            return $this->db->insert('perkembangan_rekap', $data);
        }
    }

    public function get_perkembangan_grouped_by_siswa($siswa_id, $tp_id) {
        $this->db->select('perkembangan_siswa.*, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perkembangan_siswa.mapel_id');
        $this->db->join('guru', 'guru.id = perkembangan_siswa.guru_id');
        $this->db->where('perkembangan_siswa.siswa_id', $siswa_id);
        $this->db->where('perkembangan_siswa.tahun_pelajaran_id', $tp_id);
        return $this->db->get('perkembangan_siswa')->result_array();
    }

    public function get_riwayat_perkembangan_sebelumnya($siswa_id, $current_tp_id) {
        $this->db->select('perkembangan_rekap.*, tahun_pelajaran.tahun, tahun_pelajaran.semester, kelas.nama_kelas');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = perkembangan_rekap.tahun_pelajaran_id');
        $this->db->join('kelas', 'kelas.id = perkembangan_rekap.kelas_id');
        $this->db->where('perkembangan_rekap.siswa_id', $siswa_id);
        $this->db->where('perkembangan_rekap.tahun_pelajaran_id !=', $current_tp_id);
        $this->db->order_by('tahun_pelajaran.id', 'DESC');
        return $this->db->get('perkembangan_rekap')->result_array();
    }
}

