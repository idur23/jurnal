<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->input->post()) {
            $settings = $this->input->post('setting', TRUE);
            
            // Handle Logo Upload
            if (!empty($_FILES['app_logo']['name'])) {
                if (!is_dir('./assets/img/')) {
                    mkdir('./assets/img/', 0777, TRUE);
                }
                
                $config['upload_path']   = './assets/img/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = 2048; // 2MB
                $ext = pathinfo($_FILES['app_logo']['name'], PATHINFO_EXTENSION);
                $config['file_name']     = 'logo_' . time() . '.' . $ext;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('app_logo')) {
                    $upload_data = $this->upload->data();
                    
                    // Remove old logo file if exists
                    $old_logo = $this->db->get_where('system_settings', array('setting_key' => 'app_logo'))->row_array();
                    if ($old_logo && file_exists('./' . $old_logo['setting_value'])) {
                        unlink('./' . $old_logo['setting_value']);
                    }

                    $new_logo_path = 'assets/img/' . $upload_data['file_name'];
                    
                    // Upsert setting
                    $existing = $this->db->get_where('system_settings', array('setting_key' => 'app_logo'))->row_array();
                    if ($existing) {
                        $this->db->where('setting_key', 'app_logo')->update('system_settings', array('setting_value' => $new_logo_path));
                    } else {
                        $this->db->insert('system_settings', array('setting_key' => 'app_logo', 'setting_value' => $new_logo_path));
                    }
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload logo: ' . $this->upload->display_errors());
                    redirect('settings');
                    return;
                }
            }

            // Handle Logo KOP Kiri Upload
            if (!empty($_FILES['app_logo_left']['name'])) {
                if (!is_dir('./assets/img/')) {
                    mkdir('./assets/img/', 0777, TRUE);
                }
                
                $config_l['upload_path']   = './assets/img/';
                $config_l['allowed_types'] = 'gif|jpg|jpeg|png';
                $config_l['max_size']      = 2048; // 2MB
                $ext = pathinfo($_FILES['app_logo_left']['name'], PATHINFO_EXTENSION);
                $config_l['file_name']     = 'logo_left_' . time() . '.' . $ext;

                $this->load->library('upload');
                $this->upload->initialize($config_l);

                if ($this->upload->do_upload('app_logo_left')) {
                    $upload_data = $this->upload->data();
                    
                    // Remove old logo file if exists
                    $old_logo = $this->db->get_where('system_settings', array('setting_key' => 'app_logo_left'))->row_array();
                    if ($old_logo && file_exists('./' . $old_logo['setting_value'])) {
                        @unlink('./' . $old_logo['setting_value']);
                    }

                    $new_logo_path = 'assets/img/' . $upload_data['file_name'];
                    
                    // Upsert setting
                    $existing = $this->db->get_where('system_settings', array('setting_key' => 'app_logo_left'))->row_array();
                    if ($existing) {
                        $this->db->where('setting_key', 'app_logo_left')->update('system_settings', array('setting_value' => $new_logo_path));
                    } else {
                        $this->db->insert('system_settings', array('setting_key' => 'app_logo_left', 'setting_value' => $new_logo_path));
                    }
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload logo kiri: ' . $this->upload->display_errors());
                    redirect('settings');
                    return;
                }
            }

            // Handle Logo KOP Kanan Upload
            if (!empty($_FILES['app_logo_right']['name'])) {
                if (!is_dir('./assets/img/')) {
                    mkdir('./assets/img/', 0777, TRUE);
                }
                
                $config_r['upload_path']   = './assets/img/';
                $config_r['allowed_types'] = 'gif|jpg|jpeg|png';
                $config_r['max_size']      = 2048; // 2MB
                $ext = pathinfo($_FILES['app_logo_right']['name'], PATHINFO_EXTENSION);
                $config_r['file_name']     = 'logo_right_' . time() . '.' . $ext;

                $this->load->library('upload');
                $this->upload->initialize($config_r);

                if ($this->upload->do_upload('app_logo_right')) {
                    $upload_data = $this->upload->data();
                    
                    // Remove old logo file if exists
                    $old_logo = $this->db->get_where('system_settings', array('setting_key' => 'app_logo_right'))->row_array();
                    if ($old_logo && file_exists('./' . $old_logo['setting_value'])) {
                        @unlink('./' . $old_logo['setting_value']);
                    }

                    $new_logo_path = 'assets/img/' . $upload_data['file_name'];
                    
                    // Upsert setting
                    $existing = $this->db->get_where('system_settings', array('setting_key' => 'app_logo_right'))->row_array();
                    if ($existing) {
                        $this->db->where('setting_key', 'app_logo_right')->update('system_settings', array('setting_value' => $new_logo_path));
                    } else {
                        $this->db->insert('system_settings', array('setting_key' => 'app_logo_right', 'setting_value' => $new_logo_path));
                    }
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload logo kanan: ' . $this->upload->display_errors());
                    redirect('settings');
                    return;
                }
            }

            // Handle Favicon Upload
            if (!empty($_FILES['app_favicon']['name'])) {
                if (!is_dir('./assets/img/')) {
                    mkdir('./assets/img/', 0777, TRUE);
                }
                
                $config_f['upload_path']   = './assets/img/';
                $config_f['allowed_types'] = 'ico|png|gif|jpg|jpeg';
                $config_f['max_size']      = 1024; // 1MB
                $ext = pathinfo($_FILES['app_favicon']['name'], PATHINFO_EXTENSION);
                $config_f['file_name']     = 'favicon_' . time() . '.' . $ext;

                $this->load->library('upload');
                $this->upload->initialize($config_f);

                if ($this->upload->do_upload('app_favicon')) {
                    $upload_data = $this->upload->data();
                    
                    // Remove old favicon file if exists
                    $old_fav = $this->db->get_where('system_settings', array('setting_key' => 'app_favicon'))->row_array();
                    if ($old_fav && file_exists('./' . $old_fav['setting_value'])) {
                        unlink('./' . $old_fav['setting_value']);
                    }

                    $new_fav_path = 'assets/img/' . $upload_data['file_name'];
                    
                    // Upsert setting
                    $existing = $this->db->get_where('system_settings', array('setting_key' => 'app_favicon'))->row_array();
                    if ($existing) {
                        $this->db->where('setting_key', 'app_favicon')->update('system_settings', array('setting_value' => $new_fav_path));
                    } else {
                        $this->db->insert('system_settings', array('setting_key' => 'app_favicon', 'setting_value' => $new_fav_path));
                    }
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload favicon: ' . $this->upload->display_errors());
                    redirect('settings');
                    return;
                }
            }

            if (!empty($settings) && is_array($settings)) {
                foreach ($settings as $key => $val) {
                    $existing = $this->db->get_where('system_settings', array('setting_key' => $key))->row_array();
                    if ($existing) {
                        $this->db->where('setting_key', $key);
                        $this->db->update('system_settings', array('setting_value' => $val));
                    } else {
                        $this->db->insert('system_settings', array(
                            'setting_key' => $key,
                            'setting_value' => $val
                        ));
                    }
                }
                $this->logger_lib->log('UPDATE_SETTINGS', 'Memperbarui Pengaturan Sistem & Format Laporan');
                $this->session->set_flashdata('success', 'Pengaturan sistem & format cetak laporan berhasil diperbarui.');
            }
            redirect('settings');
            return;
        }

        $data['title'] = 'Pengaturan Sistem';
        $settings_raw = $this->db->get('system_settings')->result_array();
        $settings_map = array();
        foreach ($settings_raw as $s) {
            $settings_map[$s['setting_key']] = $s['setting_value'];
        }
        $data['settings'] = $settings_map;

        $this->template->load('layout/main', 'settings/index', $data);
    }
}
