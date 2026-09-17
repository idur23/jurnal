<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_model extends MY_Model {
    protected $table = 'jurnal_guru';

    public function __construct() {
        parent::__construct();
    }

    public function generate_kode_jurnal() {
        $prefix = 'JRN-' . date('Ymd') . '-';
        $this->db->like('kode_jurnal', $prefix, 'after');
        $this->db->order_by('id', 'DESC');
        $last = $this->db->get($this->table)->row_array();

        if ($last) {
            $num = (int) substr($last['kode_jurnal'], -4);
            $num++;
        } else {
            $num = 1;
        }

        return $prefix . sprintf('%04d', $num);
    }

    public function get_jurnal_filtered($filters = array()) {
        $this->db->select('jurnal_guru.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, tahun_pelajaran.tahun, tahun_pelajaran.semester, ruangan.nama_ruangan, ruangan.kode_ruangan');
        $this->db->join('kelas', 'kelas.id = jurnal_guru.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = jurnal_guru.mapel_id');
        $this->db->join('guru', 'guru.id = jurnal_guru.guru_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = jurnal_guru.tahun_pelajaran_id');
        $this->db->join('presensi_kelas', 'presensi_kelas.jurnal_id = jurnal_guru.id', 'left');
        $this->db->join('ruangan', 'ruangan.id = presensi_kelas.ruangan_id', 'left');

        if (!empty($filters['guru_id'])) {
            $this->db->where('jurnal_guru.guru_id', $filters['guru_id']);
        }
        if (!empty($filters['kelas_id'])) {
            $this->db->where('jurnal_guru.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['mapel_id'])) {
            $this->db->where('jurnal_guru.mapel_id', $filters['mapel_id']);
        }
        if (!empty($filters['tanggal_mulai']) && !empty($filters['tanggal_selesai'])) {
            $this->db->where('jurnal_guru.tanggal >=', $filters['tanggal_mulai']);
            $this->db->where('jurnal_guru.tanggal <=', $filters['tanggal_selesai']);
        }

        $this->db->order_by('jurnal_guru.tanggal', 'DESC');
        $this->db->order_by('jurnal_guru.id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_jurnal_detail($id) {
        $this->db->select('jurnal_guru.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, guru.nip as nip_guru, tahun_pelajaran.tahun, tahun_pelajaran.semester, ruangan.nama_ruangan, ruangan.kode_ruangan, perangkat_ajar.capaian_pembelajaran as pa_cp, perangkat_ajar.tujuan_pembelajaran as pa_tp, perangkat_ajar.metode_pembelajaran as pa_metode, perangkat_ajar.model_pembelajaran as pa_model, perangkat_ajar.media_pembelajaran as pa_media, perangkat_ajar.sumber_belajar as pa_sumber, perangkat_ajar.bentuk_penilaian as pa_penilaian, perangkat_ajar.alokasi_waktu as pa_alokasi');
        $this->db->join('kelas', 'kelas.id = jurnal_guru.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = jurnal_guru.mapel_id');
        $this->db->join('guru', 'guru.id = jurnal_guru.guru_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = jurnal_guru.tahun_pelajaran_id');
        $this->db->join('presensi_kelas', 'presensi_kelas.jurnal_id = jurnal_guru.id', 'left');
        $this->db->join('ruangan', 'ruangan.id = presensi_kelas.ruangan_id', 'left');
        $this->db->join('perangkat_ajar', 'perangkat_ajar.id = jurnal_guru.perangkat_ajar_id', 'left');
        $this->db->where('jurnal_guru.id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function create_jurnal_with_presensi($jurnal_data, $presensi_data) {
        $this->db->trans_begin();

        $this->db->insert('jurnal_guru', $jurnal_data);
        $jurnal_id = $this->db->insert_id();

        if (!empty($presensi_data)) {
            foreach ($presensi_data as &$p) {
                $p['jurnal_id'] = $jurnal_id;
                $p['tanggal'] = $jurnal_data['tanggal'];
            }
            $this->db->insert_batch('presensi_siswa', $presensi_data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $jurnal_id;
        }
    }

    public function update_jurnal_with_presensi($jurnal_id, $jurnal_data, $presensi_data) {
        $this->db->trans_begin();

        $this->db->where('id', $jurnal_id);
        $this->db->update('jurnal_guru', $jurnal_data);

        if (!empty($presensi_data)) {
            $this->db->where('jurnal_id', $jurnal_id);
            $this->db->delete('presensi_siswa');

            foreach ($presensi_data as &$p) {
                $p['jurnal_id'] = $jurnal_id;
                $p['tanggal'] = $jurnal_data['tanggal'];
            }
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
}
