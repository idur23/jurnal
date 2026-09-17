<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerkembanganService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('perkembangan_model');
        $this->CI->load->model('master_model');
    }

    public function save_perkembangan($post_data, $active_tp, $current_user_id) {
        $siswa_id = $post_data['siswa_id'];
        $mapel_id = $post_data['mapel_id'];
        $kelas_id = $post_data['kelas_id'];

        $guru = $this->CI->master_model->get_guru_by_user_id($current_user_id);
        $guru_id = $guru ? $guru['id'] : 1;

        $this->trans_begin();

        try {
            $data = array(
                'tahun_pelajaran_id' => $active_tp['id'],
                'siswa_id' => $siswa_id,
                'kelas_id' => $kelas_id,
                'mapel_id' => $mapel_id,
                'guru_id' => $guru_id,
                'catatan_perkembangan' => $post_data['catatan_perkembangan'],
                'kelebihan' => isset($post_data['kelebihan']) ? $post_data['kelebihan'] : NULL,
                'kekurangan' => isset($post_data['kekurangan']) ? $post_data['kekurangan'] : NULL,
                'perilaku' => isset($post_data['perilaku']) ? $post_data['perilaku'] : NULL,
                'keaktifan' => isset($post_data['keaktifan']) ? $post_data['keaktifan'] : NULL,
                'kedisiplinan' => isset($post_data['kedisiplinan']) ? $post_data['kedisiplinan'] : NULL,
                'motivasi' => isset($post_data['motivasi']) ? $post_data['motivasi'] : NULL,
                'rekomendasi' => isset($post_data['rekomendasi']) ? $post_data['rekomendasi'] : NULL
            );

            // Check if entry exists for this tp, student, and subject
            $existing = $this->CI->db->get_where('perkembangan_siswa', array(
                'tahun_pelajaran_id' => $active_tp['id'],
                'siswa_id' => $siswa_id,
                'mapel_id' => $mapel_id
            ))->row_array();

            if ($existing) {
                $this->CI->db->where('id', $existing['id']);
                $this->CI->db->update('perkembangan_siswa', $data);
            } else {
                $this->CI->db->insert('perkembangan_siswa', $data);
            }

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menyimpan catatan perkembangan siswa.');
            } else {
                $this->trans_commit();
                $this->CI->logger_lib->log('SAVE_PERKEMBANGAN', "Input Perkembangan Siswa ID: $siswa_id Mapel ID: $mapel_id");
                return array('status' => true);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    public function save_rekap($post_data, $active_tp) {
        $siswa_id = $post_data['siswa_id'];
        $kelas_id = $post_data['kelas_id'];

        $wali = $this->CI->master_model->get_guru_by_user_id($this->CI->session->userdata('user_session')['id']);
        $wali_id = $wali ? $wali['id'] : 1;

        $this->trans_begin();

        try {
            $data = array(
                'tahun_pelajaran_id' => $active_tp['id'],
                'siswa_id' => $siswa_id,
                'kelas_id' => $kelas_id,
                'wali_id' => $wali_id,
                'kesimpulan_wali' => $post_data['kesimpulan_wali'],
                'tindak_lanjut' => $post_data['tindak_lanjut'],
                'status_perkembangan' => $post_data['status_perkembangan']
            );

            $existing = $this->CI->db->get_where('perkembangan_rekap', array(
                'tahun_pelajaran_id' => $active_tp['id'],
                'siswa_id' => $siswa_id
            ))->row_array();

            if ($existing) {
                $this->CI->db->where('id', $existing['id']);
                $this->CI->db->update('perkembangan_rekap', $data);
            } else {
                $this->CI->db->insert('perkembangan_rekap', $data);
            }

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menyimpan rekapitulasi perkembangan.');
            } else {
                $this->trans_commit();
                $this->CI->logger_lib->log('SAVE_REKAP_PERKEMBANGAN', "Input Rekap Perkembangan Siswa ID: $siswa_id");
                return array('status' => true);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }
}
