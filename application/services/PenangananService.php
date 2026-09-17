<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PenangananService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('walikelas_model');
        $this->CI->load->model('master_model');
    }

    public function save_penanganan($post_data, $files, $active_tp, $id = NULL) {
        $this->trans_begin();

        try {
            $wali = $this->CI->master_model->get_guru_by_user_id($this->CI->session->userdata('user_session')['id']);
            $wali_id = $wali ? $wali['id'] : 1;

            $kelas = $this->CI->master_model->get_kelas_by_wali_user_id($this->CI->session->userdata('user_session')['id']);
            $kelas_id = $kelas ? $kelas['id'] : 1;

            $file_path = NULL;
            if ($id) {
                $existing = $this->CI->db->get_where('penanganan_siswa', array('id' => $id))->row_array();
                if ($existing) {
                    $file_path = $existing['dokumentasi'];
                }
            }

            if (!empty($files['dokumentasi']['name'])) {
                // Delete existing documentation file if editing
                if ($id && $file_path && file_exists('./' . $file_path)) {
                    @unlink('./' . $file_path);
                }

                if (!is_dir('./assets/uploads/penanganan/')) {
                    mkdir('./assets/uploads/penanganan/', 0777, TRUE);
                }

                $config['upload_path']   = './assets/uploads/penanganan/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']      = 5120;

                $ext = pathinfo($files['dokumentasi']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'PEN_' . $kelas_id . '_' . time() . '.' . $ext;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config);

                if ($this->CI->upload->do_upload('dokumentasi')) {
                    $upload_data = $this->CI->upload->data();
                    $file_path = 'assets/uploads/penanganan/' . $upload_data['file_name'];
                    $this->CI->load->helper('gdrive');
                    gdrive_sync_file($upload_data['full_path']);
                }
            }


            $data = array(
                'tahun_pelajaran_id' => $active_tp['id'],
                'kelas_id' => $kelas_id,
                'siswa_id' => $post_data['siswa_id'],
                'wali_id' => $wali_id,
                'tanggal' => $post_data['tanggal'],
                'permasalahan' => $post_data['permasalahan'],
                'kategori' => $post_data['kategori'],
                'tindakan' => $post_data['tindakan'],
                'hasil' => $post_data['hasil'],
                'rencana_tindak_lanjut' => $post_data['rencana_tindak_lanjut'],
                'status' => $post_data['status'],
                'dokumentasi' => $file_path
            );

            if ($id) {
                $this->CI->db->where('id', $id);
                $this->CI->db->update('penanganan_siswa', $data);
                $log_action = 'UPDATE_PENANGANAN';
                $log_msg = 'Mengubah Jurnal Penanganan Siswa ID: ' . $post_data['siswa_id'] . ' Case ID: ' . $id;
            } else {
                $this->CI->db->insert('penanganan_siswa', $data);
                $log_action = 'CREATE_PENANGANAN';
                $log_msg = 'Membuat Jurnal Penanganan Siswa ID: ' . $post_data['siswa_id'];
            }

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menyimpan penanganan siswa.');
            } else {
                $this->trans_commit();
                $this->CI->logger_lib->log($log_action, $log_msg);
                return array('status' => true);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }
}
