<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PresensiService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('presensikelas_model');
        $this->CI->load->model('jurnal_model');
        $this->CI->load->model('presensi_model');
    }

    public function get_presensi_kelas_list($filters) {
        return $this->CI->presensikelas_model->get_all_with_relations($filters);
    }

    public function get_presensi_kelas_detail($id) {
        return $this->CI->presensikelas_model->get_detail($id);
    }

    /**
     * Create presensi kelas and validate restrictions
     */
    public function create_presensi_kelas($jurnal_id, $post_data, $files) {
        $jurnal = $this->CI->jurnal_model->get_jurnal_detail($jurnal_id);
        if (!$jurnal) {
            return array('status' => false, 'message' => 'Jurnal Mengajar tidak ditemukan.');
        }

        // VALIDATION: Prevent duplicate class presence for journal
        if ($this->CI->presensikelas_model->has_presensi_kelas($jurnal_id)) {
            return array('status' => false, 'message' => 'Presensi Kelas sudah dibuat untuk Jurnal ini.');
        }

        // VALIDATION: One schedule slot only gets one Class Presence record
        $this->CI->db->where('tanggal', $jurnal['tanggal']);
        $this->CI->db->where('kelas_id', $jurnal['kelas_id']);
        $this->CI->db->where('mapel_id', $jurnal['mapel_id']);
        $this->CI->db->where('guru_id', $jurnal['guru_id']);
        $existing = $this->CI->db->get('presensi_kelas')->row_array();
        if ($existing) {
            return array('status' => false, 'message' => 'Presensi Kelas sudah dibuat untuk sesi jadwal KBM ini.');
        }

        $this->trans_begin();

        try {
            // Parse jam_ke to get time
            $jam_parts = explode('-', $jurnal['jam_ke']);
            $jam_mulai_ke = (int)$jam_parts[0];
            $jam_selesai_ke = isset($jam_parts[1]) ? (int)$jam_parts[1] : $jam_mulai_ke;

            $start_time = $this->CI->db->select('jam_mulai')->where('jam_ke', $jam_mulai_ke)->get('jam_pelajaran')->row_array();
            $end_time = $this->CI->db->select('jam_selesai')->where('jam_ke', $jam_selesai_ke)->get('jam_pelajaran')->row_array();

            $jam_mulai = $start_time ? $start_time['jam_mulai'] : '07:00:00';
            $jam_selesai = $end_time ? $end_time['jam_selesai'] : '08:30:00';

            $file_path = NULL;
            if (!empty($files['dokumentasi']['name'])) {
                if (!is_dir('./assets/uploads/presensikelas/')) {
                    mkdir('./assets/uploads/presensikelas/', 0777, TRUE);
                }
                
                $config['upload_path']   = './assets/uploads/presensikelas/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = 5120; // 5MB
                
                $ext = pathinfo($files['dokumentasi']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'PK_DOC_' . $jurnal_id . '_' . time() . '.' . $ext;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config);
                
                if ($this->CI->upload->do_upload('dokumentasi')) {
                    $upload_data = $this->CI->upload->data();
                    $file_path = 'assets/uploads/presensikelas/' . $upload_data['file_name'];
                    $this->CI->load->helper('gdrive');
                    gdrive_sync_file($upload_data['full_path']);
                }
            }


            $status_pembelajaran = $post_data['status_pembelajaran'];
            $save_data = array(
                'jurnal_id' => $jurnal_id,
                'tanggal' => $jurnal['tanggal'],
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'guru_id' => $jurnal['guru_id'],
                'mapel_id' => $jurnal['mapel_id'],
                'kelas_id' => $jurnal['kelas_id'],
                'ruangan_id' => !empty($post_data['ruangan_id']) ? $post_data['ruangan_id'] : NULL,
                'pertemuan_ke' => $post_data['pertemuan_ke'],
                'status_pembelajaran' => $status_pembelajaran,
                'alasan_tidak_terlaksana' => ($status_pembelajaran == 'Tidak Terlaksana') ? $post_data['alasan_tidak_terlaksana'] : NULL,
                'dokumentasi' => $file_path,
                'catatan_guru' => isset($post_data['catatan_guru']) ? $post_data['catatan_guru'] : NULL
            );

            $this->CI->db->insert('presensi_kelas', $save_data);
            $presensi_kelas_id = $this->CI->db->insert_id();

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menyimpan Presensi Kelas.');
            } else {
                $this->trans_commit();

                // Clear dashboard statistics cache
                $dashboardService = new DashboardService();
                $dashboardService->clear_dashboard_cache();

                $this->CI->logger_lib->log('CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: ' . $presensi_kelas_id . ' untuk Jurnal: ' . $jurnal['kode_jurnal']);
                return array('status' => true, 'presensi_kelas_id' => $presensi_kelas_id);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * Edit class presence
     */
    public function update_presensi_kelas($id, $post_data, $files) {
        $pk = $this->CI->presensikelas_model->get_detail($id);
        if (!$pk) {
            return array('status' => false, 'message' => 'Presensi Kelas tidak ditemukan.');
        }

        $this->trans_begin();

        try {
            $file_path = $pk['dokumentasi'];
            if (!empty($files['dokumentasi']['name'])) {
                if (!is_dir('./assets/uploads/presensikelas/')) {
                    mkdir('./assets/uploads/presensikelas/', 0777, TRUE);
                }
                
                $config['upload_path']   = './assets/uploads/presensikelas/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = 5120;
                
                $ext = pathinfo($files['dokumentasi']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'PK_DOC_EDIT_' . $id . '_' . time() . '.' . $ext;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config);
                
                if ($this->CI->upload->do_upload('dokumentasi')) {
                    $upload_data = $this->CI->upload->data();
                    $file_path = 'assets/uploads/presensikelas/' . $upload_data['file_name'];
                    $this->CI->load->helper('gdrive');
                    gdrive_sync_file($upload_data['full_path']);
                }
            }


            $status_pembelajaran = $post_data['status_pembelajaran'];
            $update_data = array(
                'ruangan_id' => !empty($post_data['ruangan_id']) ? $post_data['ruangan_id'] : NULL,
                'pertemuan_ke' => $post_data['pertemuan_ke'],
                'status_pembelajaran' => $status_pembelajaran,
                'alasan_tidak_terlaksana' => ($status_pembelajaran == 'Tidak Terlaksana') ? $post_data['alasan_tidak_terlaksana'] : NULL,
                'dokumentasi' => $file_path,
                'catatan_guru' => isset($post_data['catatan_guru']) ? $post_data['catatan_guru'] : NULL
            );

            $this->CI->db->where('id', $id);
            $this->CI->db->update('presensi_kelas', $update_data);

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal memperbarui Presensi Kelas.');
            } else {
                $this->trans_commit();

                // Clear dashboard statistics cache
                $dashboardService = new DashboardService();
                $dashboardService->clear_dashboard_cache();

                $this->CI->logger_lib->log('UPDATE_PRESENSI_KELAS', 'Mengubah Presensi Kelas ID: ' . $id);
                return array('status' => true);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * Delete class presence
     */
    public function delete_presensi_kelas($id) {
        $pk = $this->CI->db->get_where('presensi_kelas', array('id' => $id))->row_array();
        if ($pk) {
            $this->trans_begin();
            $this->CI->db->delete('presensi_kelas', array('id' => $id));

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return false;
            } else {
                $this->trans_commit();

                $dashboardService = new DashboardService();
                $dashboardService->clear_dashboard_cache();

                $this->CI->logger_lib->log('DELETE_PRESENSI_KELAS', 'Menghapus Presensi Kelas ID: ' . $id);
                return true;
            }
        }
        return false;
    }

    /**
     * Batch save student attendance with Transaction
     */
    public function save_presensi_siswa($presensi_kelas_id, $attendance_post) {
        $pk = $this->CI->presensikelas_model->get_detail($presensi_kelas_id);
        if (!$pk) {
            return array('status' => false, 'message' => 'Presensi Kelas tidak ditemukan.');
        }

        $this->trans_begin();

        try {
            // Delete existing records
            $this->CI->db->where('presensi_kelas_id', $presensi_kelas_id);
            $this->CI->db->delete('presensi_siswa');

            $batch_data = array();
            
            // Handle uploaded files for leave/permits evidence
            $uploaded_files = array();
            if (!empty($_FILES)) {
                if (!is_dir('./assets/uploads/bukti_izin/')) {
                    mkdir('./assets/uploads/bukti_izin/', 0777, TRUE);
                }
                
                $config['upload_path']   = './assets/uploads/bukti_izin/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']      = 5120; // 5MB
                
                $this->CI->load->library('upload');

                foreach ($_FILES as $input_name => $file_info) {
                    if (strpos($input_name, 'bukti_izin_') === 0 && !empty($file_info['name'])) {
                        $siswa_id = str_replace('bukti_izin_', '', $input_name);
                        
                        $ext = pathinfo($file_info['name'], PATHINFO_EXTENSION);
                        $config['file_name'] = 'PERMIT_' . $presensi_kelas_id . '_' . $siswa_id . '_' . time() . '.' . $ext;
                        
                        $this->CI->upload->initialize($config);
                        
                        if ($this->CI->upload->do_upload($input_name)) {
                            $upload_data = $this->CI->upload->data();
                            $uploaded_files[$siswa_id] = 'assets/uploads/bukti_izin/' . $upload_data['file_name'];
                            $this->CI->load->helper('gdrive');
                            gdrive_sync_file($upload_data['full_path']);
                        }
                    }
                }
            }


            foreach ($attendance_post as $siswa_id => $details) {
                if (isset($details['status'])) {
                    $status = $details['status'];
                    $catatan = isset($details['catatan']) ? $details['catatan'] : NULL;
                    
                    $bukti_izin = isset($uploaded_files[$siswa_id]) ? $uploaded_files[$siswa_id] : NULL;
                    
                    // Keep original proof if not re-uploaded
                    if (!$bukti_izin && isset($details['existing_bukti'])) {
                        $bukti_izin = $details['existing_bukti'];
                    }

                    $batch_data[] = array(
                        'presensi_kelas_id' => $presensi_kelas_id,
                        'siswa_id' => $siswa_id,
                        'tanggal' => $pk['tanggal'],
                        'status' => $status,
                        'catatan' => $catatan,
                        'bukti_izin' => $bukti_izin
                    );
                }
            }

            if (!empty($batch_data)) {
                $this->CI->db->insert_batch('presensi_siswa', $batch_data);
            }

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menyimpan presensi siswa.');
            } else {
                $this->trans_commit();

                // Clear dashboard statistics cache
                $dashboardService = new DashboardService();
                $dashboardService->clear_dashboard_cache();

                $this->CI->logger_lib->log('INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: ' . $pk['nama_kelas'] . ' Mapel: ' . $pk['nama_mapel']);
                return array('status' => true);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }
}
