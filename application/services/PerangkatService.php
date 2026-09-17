<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerangkatService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('perangkat_model');
        $this->CI->load->model('master_model');
    }

    public function get_matched_device($tp_id, $semester, $mapel_id, $guru_id, $kelas_id, $pertemuan_ke) {
        return $this->CI->perangkat_model->get_matched_device($tp_id, $semester, $mapel_id, $guru_id, $kelas_id, $pertemuan_ke);
    }

    public function clear_device_cache($tp_id, $semester, $mapel_id, $guru_id, $kelas_id, $pertemuan_ke) {
        $this->CI->perangkat_model->clear_device_cache($tp_id, $semester, $mapel_id, $guru_id, $kelas_id, $pertemuan_ke);
    }

    public function upload_perangkat($post_data, $files, $active_tp, $current_user_id, $id = NULL) {
        $role = $this->CI->session->userdata('user_session')['role_code'];
        $guru = $this->CI->master_model->get_guru_by_user_id($current_user_id);
        $target_guru_id = in_array($role, array('admin', 'superadmin')) ? $post_data['guru_id'] : $guru['id'];

        $device = NULL;
        $file_path = NULL;

        if ($id) {
            $device = $this->CI->perangkat_model->get_by_id($id);
            if ($device) {
                $file_path = $device['file_path'];
            }
        }

        // Upload handler
        if (!empty($files['file_perangkat']['name'])) {
            // Structured storage: /uploads/perangkat/year/semester/guru/kelas/
            $year_folder = str_replace('/', '_', $active_tp['tahun']);
            $semester_folder = $post_data['semester'];
            $dest_dir = "./assets/uploads/perangkat/{$year_folder}/{$semester_folder}/{$target_guru_id}/{$post_data['kelas_id']}/";
            
            if (!is_dir($dest_dir)) {
                mkdir($dest_dir, 0777, TRUE);
            }

            $config['upload_path']   = $dest_dir;
            $config['allowed_types'] = 'pdf|docx|xlsx|pptx';
            $config['max_size']      = 10240; // 10MB
            
            $ext = pathinfo($files['file_perangkat']['name'], PATHINFO_EXTENSION);
            $config['file_name'] = 'PERANGKAT_' . $post_data['jenis_perangkat'] . '_' . $post_data['pertemuan_ke'] . '_' . time() . '.' . $ext;

            $this->CI->load->library('upload');
            $this->CI->upload->initialize($config);

            if ($this->CI->upload->do_upload('file_perangkat')) {
                $upload_data = $this->CI->upload->data();
                $file_path = str_replace('./', '', $dest_dir) . $upload_data['file_name'];
                $this->CI->load->helper('gdrive');
                gdrive_sync_file($upload_data['full_path']);
            } else {

                return array('status' => false, 'message' => $this->CI->upload->display_errors());
            }
        }

        // Ensure kelas_ids and rencana_ids columns exist in database table
        if (!$this->CI->db->field_exists('kelas_ids', 'perangkat_ajar')) {
            @$this->CI->db->query("ALTER TABLE `perangkat_ajar` ADD `kelas_ids` TEXT NULL AFTER `kelas_id`");
        }
        if (!$this->CI->db->field_exists('rencana_ids', 'perangkat_ajar')) {
            @$this->CI->db->query("ALTER TABLE `perangkat_ajar` ADD `rencana_ids` TEXT NULL AFTER `kelas_ids`");
        }

        // Handle Multi-Class Selection
        $kelas_ids_input = isset($post_data['kelas_ids']) ? $post_data['kelas_ids'] : (isset($post_data['kelas_id']) ? array($post_data['kelas_id']) : array());
        if (is_array($kelas_ids_input)) {
            $primary_kelas_id = !empty($kelas_ids_input[0]) ? $kelas_ids_input[0] : 0;
            $json_kelas_ids = json_encode(array_values(array_map('intval', $kelas_ids_input)));
        } else {
            $primary_kelas_id = $kelas_ids_input;
            $json_kelas_ids = json_encode(array((int)$kelas_ids_input));
        }

        // Handle Multi-Select Rencana Pelaksanaan
        $rencana_ids_input = isset($post_data['rencana_ids']) ? $post_data['rencana_ids'] : array();
        $json_rencana_ids = is_array($rencana_ids_input) ? json_encode(array_values(array_map('intval', $rencana_ids_input))) : json_encode(array());

        $jenis_perangkat = !empty($post_data['jenis_perangkat']) ? $post_data['jenis_perangkat'] : 'Dokumen Utama';
        $pertemuan_ke    = !empty($post_data['pertemuan_ke']) ? $post_data['pertemuan_ke'] : 1;

        $save_data = array(
            'tahun_pelajaran_id' => $active_tp['id'],
            'semester' => $post_data['semester'],
            'mapel_id' => $post_data['mapel_id'],
            'kelas_id' => $primary_kelas_id,
            'kelas_ids' => $json_kelas_ids,
            'rencana_ids' => $json_rencana_ids,
            'guru_id' => $target_guru_id,
            'jenis_perangkat' => $jenis_perangkat,
            'fase' => isset($post_data['fase']) ? $post_data['fase'] : NULL,
            'file_path' => $file_path
        );

        $this->trans_begin();

        try {
            if ($id && $device) {
                if ($device['status_verifikasi'] == 'Draft') {
                    // Update draft directly
                    $this->CI->db->where('id', $id);
                    $this->CI->db->update('perangkat_ajar', $save_data);
                    
                    if ($this->trans_status() === FALSE) {
                        $this->trans_rollback();
                        return array('status' => false, 'message' => 'Gagal memperbarui draft.');
                    }
                    
                    $this->trans_commit();
                    $this->clear_device_cache($active_tp['id'], $save_data['semester'], $save_data['mapel_id'], $target_guru_id, $save_data['kelas_id'], $save_data['pertemuan_ke']);
                    $this->CI->logger_lib->log('UPDATE_PERANGKAT', 'Mengubah Draft Perangkat ID: ' . $id);
                    return array('status' => true, 'message' => 'Draft Perangkat Ajar berhasil diperbarui.');
                } else {
                    // Insert as a new version revision
                    $new_id = $this->CI->perangkat_model->save_revision($id, $save_data, $current_user_id);
                    
                    if ($this->trans_status() === FALSE) {
                        $this->trans_rollback();
                        return array('status' => false, 'message' => 'Gagal menyimpan revisi.');
                    }
                    
                    $this->trans_commit();
                    $this->clear_device_cache($active_tp['id'], $save_data['semester'], $save_data['mapel_id'], $target_guru_id, $save_data['kelas_id'], $save_data['pertemuan_ke']);
                    $this->CI->logger_lib->log('REVISE_PERANGKAT', 'Membuat Revisi/Versi Baru Perangkat ID: ' . $id . ' -> New ID: ' . $new_id);
                    return array('status' => true, 'message' => 'Revisian berhasil dikirim sebagai Versi Baru.');
                }
            } else {
                // New upload
                $save_data['status_verifikasi'] = 'Menunggu Verifikasi';
                $save_data['created_by'] = $current_user_id;
                
                $this->CI->db->insert('perangkat_ajar', $save_data);
                $new_id = $this->CI->db->insert_id();

                if ($this->trans_status() === FALSE) {
                    $this->trans_rollback();
                    return array('status' => false, 'message' => 'Gagal menyimpan perangkat ajar.');
                }
                
                $this->trans_commit();
                $this->CI->logger_lib->log('UPLOAD_PERANGKAT', 'Mengunggah Perangkat Ajar Baru ID: ' . $new_id);
                return array('status' => true, 'message' => 'Perangkat Ajar berhasil diunggah dan menunggu verifikasi.');
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }
}
