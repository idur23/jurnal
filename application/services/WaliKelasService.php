<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WaliKelasService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('walikelas_model');
        $this->CI->load->model('master_model');
    }

    public function save_program_kelas($post_data, $files, $active_tp, $id = NULL) {
        $this->trans_begin();

        try {
            $wali = $this->CI->master_model->get_guru_by_user_id($this->CI->session->userdata('user_session')['id']);
            $wali_id = $wali ? $wali['id'] : 1;
            
            $kelas = $this->CI->master_model->get_kelas_by_wali_user_id($this->CI->session->userdata('user_session')['id']);
            $kelas_id = $kelas ? $kelas['id'] : 1;

            $file_path = NULL;
            if ($id) {
                $existing = $this->CI->db->get_where('jurnal_walikelas', array('id' => $id))->row_array();
                if ($existing) {
                    $file_path = $existing['dokumentasi'];
                }
            }

            if (!empty($files['dokumentasi']['name'])) {
                // Delete existing documentation file if editing
                if ($id && $file_path && file_exists('./' . $file_path)) {
                    @unlink('./' . $file_path);
                }

                if (!is_dir('./assets/uploads/program_kelas/')) {
                    mkdir('./assets/uploads/program_kelas/', 0777, TRUE);
                }

                $config['upload_path']   = './assets/uploads/program_kelas/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']      = 5120;
                
                $ext = pathinfo($files['dokumentasi']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'PRG_' . $kelas_id . '_' . time() . '.' . $ext;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config);

                if ($this->CI->upload->do_upload('dokumentasi')) {
                    $upload_data = $this->CI->upload->data();
                    $file_path = 'assets/uploads/program_kelas/' . $upload_data['file_name'];
                    $this->CI->load->helper('gdrive');
                    gdrive_sync_file($upload_data['full_path']);
                }
            }


            $data = array(
                'tahun_pelajaran_id' => $active_tp['id'],
                'kelas_id' => $kelas_id,
                'wali_id' => $wali_id,
                'tanggal' => $post_data['tanggal'],
                'program' => $post_data['program'],
                'target' => $post_data['target'],
                'pelaksanaan' => $post_data['pelaksanaan'],
                'catatan' => $post_data['catatan'],
                'status' => $post_data['status'],
                'dokumentasi' => $file_path
            );

            if ($id) {
                $this->CI->db->where('id', $id);
                $this->CI->db->update('jurnal_walikelas', $data);
                $log_action = 'UPDATE_PROGRAM_KELAS';
                $log_msg = 'Mengubah Program Kelas ID: ' . $id;
            } else {
                $this->CI->db->insert('jurnal_walikelas', $data);
                $log_action = 'CREATE_PROGRAM_KELAS';
                $log_msg = 'Membuat Program Kelas: ' . $post_data['program'];
            }

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menyimpan program kelas.');
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

    public function save_kokurikuler($post_data, $files, $active_tp, $id = NULL) {
        $this->trans_begin();

        try {
            $wali = $this->CI->master_model->get_guru_by_user_id($this->CI->session->userdata('user_session')['id']);
            $wali_id = $wali ? $wali['id'] : 1;

            $kelas = $this->CI->master_model->get_kelas_by_wali_user_id($this->CI->session->userdata('user_session')['id']);
            $kelas_id = $kelas ? $kelas['id'] : 1;

            $file_path = NULL;
            if ($id) {
                $existing = $this->CI->db->get_where('kokurikuler', array('id' => $id))->row_array();
                if ($existing) {
                    $file_path = $existing['dokumentasi'];
                }
            }

            if (!empty($files['dokumentasi']['name'])) {
                // Delete existing documentation file if editing
                if ($id && $file_path && file_exists('./' . $file_path)) {
                    @unlink('./' . $file_path);
                }

                if (!is_dir('./assets/uploads/kokurikuler/')) {
                    mkdir('./assets/uploads/kokurikuler/', 0777, TRUE);
                }

                $config['upload_path']   = './assets/uploads/kokurikuler/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']      = 5120;

                $ext = pathinfo($files['dokumentasi']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'KOKU_' . $kelas_id . '_' . time() . '.' . $ext;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config);

                if ($this->CI->upload->do_upload('dokumentasi')) {
                    $upload_data = $this->CI->upload->data();
                    $file_path = 'assets/uploads/kokurikuler/' . $upload_data['file_name'];
                    $this->CI->load->helper('gdrive');
                    gdrive_sync_file($upload_data['full_path']);
                }
            }


            $data = array(
                'tahun_pelajaran_id' => $active_tp['id'],
                'kelas_id' => $kelas_id,
                'guru_id' => $wali_id, // Homeroom teacher is always the coordinating teacher
                'tema' => $post_data['tema'],
                'sub_tema' => $post_data['sub_tema'],
                'aktivitas' => $post_data['aktivitas'],
                'tujuan' => $post_data['tujuan'],
                'tanggal' => $post_data['tanggal'],
                'catatan' => $post_data['catatan'] ?? '',
                'status' => $post_data['status'],
                'output' => $post_data['output'],
                'dokumentasi' => $file_path
            );

            if ($id) {
                $this->CI->db->where('id', $id);
                $this->CI->db->update('kokurikuler', $data);
                $log_action = 'UPDATE_KOKURIKULER';
                $log_msg = 'Mengubah Aktivitas Kokurikuler ID: ' . $id;
            } else {
                $this->CI->db->insert('kokurikuler', $data);
                $log_action = 'CREATE_KOKURIKULER';
                $log_msg = 'Membuat Aktivitas Kokurikuler Tema: ' . $post_data['tema'];
            }

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menyimpan aktivitas kokurikuler.');
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
