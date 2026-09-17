<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karya extends Guru_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('karya_model');
    }

    public function index() {
        $action = $this->input->post('action', TRUE);
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        if ($action == 'add') {
            if (!is_dir('./assets/uploads/karya/')) {
                mkdir('./assets/uploads/karya/', 0777, TRUE);
            }

            $config['upload_path']   = './assets/uploads/karya/';
            $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|ppt|pptx|zip|rar|mp4|mkv';
            $config['max_size']      = 51200; // 50MB
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_karya')) {
                $this->session->set_flashdata('error', 'Gagal upload file: ' . $this->upload->display_errors());
                redirect('karya');
                return;
            }

            $upload_data = $this->upload->data();
            $file_path = 'assets/uploads/karya/' . $upload_data['file_name'];

            // Optional Google Drive Upload with Subfolder
            $this->load->helper('gdrive');
            $subfolder = 'Karya_Pembelajaran/' . date('Y-m');
            $gdrive_res = gdrive_upload_file($upload_data['full_path'], $upload_data['file_name'], $subfolder);
            if ($gdrive_res && !empty($gdrive_res['webViewLink'])) {
                $file_path = $gdrive_res['webViewLink'];
            }

            $insert_data = array(
                'guru_id' => $guru ? $guru['id'] : 1,
                'kelas_id' => $this->input->post('kelas_id', TRUE),
                'mapel_id' => $this->input->post('mapel_id', TRUE),
                'judul' => $this->input->post('judul', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'materi' => $this->input->post('materi', TRUE),
                'jenis_karya' => $this->input->post('jenis_karya', TRUE),
                'tags' => $this->input->post('tags', TRUE),
                'status_publikasi' => $this->input->post('status_publikasi', TRUE) ? $this->input->post('status_publikasi', TRUE) : 'Draft',
                'file_path' => $file_path
            );

            $this->db->insert('karya_pembelajaran', $insert_data);
            $this->logger_lib->log('ADD_KARYA', "Menambahkan karya: " . $insert_data['judul']);
            $this->session->set_flashdata('success', 'Karya/luaran pembelajaran berhasil diunggah.');
            redirect('karya');
            return;

        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $karya = $this->db->get_where('karya_pembelajaran', array('id' => $id))->row_array();

            if (!$karya || ($role != 'admin' && $guru && $karya['guru_id'] != $guru['id'])) {
                $this->session->set_flashdata('error', 'Akses ditolak.');
                redirect('karya');
                return;
            }

            $update_data = array(
                'kelas_id' => $this->input->post('kelas_id', TRUE),
                'mapel_id' => $this->input->post('mapel_id', TRUE),
                'judul' => $this->input->post('judul', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'materi' => $this->input->post('materi', TRUE),
                'jenis_karya' => $this->input->post('jenis_karya', TRUE),
                'tags' => $this->input->post('tags', TRUE),
                'status_publikasi' => $this->input->post('status_publikasi', TRUE)
            );

            // Optional new file upload
            if (!empty($_FILES['file_karya']['name'])) {
                $config['upload_path']   = './assets/uploads/karya/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|ppt|pptx|zip|rar|mp4|mkv';
                $config['max_size']      = 51200; // 50MB
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file_karya')) {
                    // delete old file if local
                    if (!empty($karya['file_path']) && file_exists('./' . $karya['file_path'])) {
                        @unlink('./' . $karya['file_path']);
                    }
                    $upload_data = $this->upload->data();
                    $new_file_path = 'assets/uploads/karya/' . $upload_data['file_name'];

                    $this->load->helper('gdrive');
                    $subfolder = 'Karya_Pembelajaran/' . date('Y-m');
                    $gdrive_res = gdrive_upload_file($upload_data['full_path'], $upload_data['file_name'], $subfolder);
                    if ($gdrive_res && !empty($gdrive_res['webViewLink'])) {
                        $new_file_path = $gdrive_res['webViewLink'];
                    }


                    $update_data['file_path'] = $new_file_path;
                }
            }


            $this->db->where('id', $id);
            $this->db->update('karya_pembelajaran', $update_data);
            $this->logger_lib->log('EDIT_KARYA', "Mengedit karya ID: $id");
            $this->session->set_flashdata('success', 'Karya/luaran pembelajaran berhasil diperbarui.');
            redirect('karya');
            return;

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $karya = $this->db->get_where('karya_pembelajaran', array('id' => $id))->row_array();

            if (!$karya || ($role != 'admin' && $guru && $karya['guru_id'] != $guru['id'])) {
                $this->session->set_flashdata('error', 'Akses ditolak.');
                redirect('karya');
                return;
            }

            if (file_exists('./' . $karya['file_path'])) {
                unlink('./' . $karya['file_path']);
            }

            $this->db->where('id', $id);
            $this->db->delete('karya_pembelajaran');
            $this->logger_lib->log('DELETE_KARYA', "Menghapus karya ID: $id");
            $this->session->set_flashdata('success', 'Karya pembelajaran berhasil dihapus.');
            redirect('karya');
            return;
        }

        $data['title'] = 'Karya & Luaran Pembelajaran';

        // Filters
        $filters = array();
        if ($role != 'admin' && $guru) {
            $filters['guru_id'] = $guru['id'];
        }
        
        $data['list_karya'] = $this->karya_model->get_all_karya($filters);

        // Dropdowns for upload modal
        if ($role == 'admin') {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
        } else {
            $data['list_kelas'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id']);
            $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
        }

        $this->template->load('layout/main', 'karya/index', $data);
    }
}
