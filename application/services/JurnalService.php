<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JurnalService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('jurnal_model');
        $this->CI->load->model('master_model');
    }

    public function get_jurnal_list($filters) {
        return $this->CI->jurnal_model->get_jurnal_filtered($filters);
    }

    public function get_jurnal_detail($id) {
        return $this->CI->jurnal_model->get_jurnal_detail($id);
    }

    public function create_jurnal($post_data, $files, $active_tp, $current_user_id) {
        $this->trans_begin();

        try {
            $guru = $this->CI->master_model->get_guru_by_user_id($current_user_id);
            $guru_id = $guru ? $guru['id'] : (isset($post_data['guru_id']) ? $post_data['guru_id'] : 1);

            $jam_mulai = isset($post_data['jam_mulai_ke']) ? $post_data['jam_mulai_ke'] : '';
            $jam_selesai = isset($post_data['jam_selesai_ke']) ? $post_data['jam_selesai_ke'] : '';
            if ($jam_mulai && $jam_selesai) {
                $jam_ke_str = ($jam_mulai == $jam_selesai) ? $jam_mulai : ($jam_mulai . '-' . $jam_selesai);
            } else {
                $jam_ke_str = isset($post_data['jam_ke']) ? $post_data['jam_ke'] : '1-2';
            }

            // File upload logic (Photo/PDF)
            $file_path = NULL;
            if (!empty($files['file_dokumentasi']['name'])) {
                if (!is_dir('./assets/uploads/jurnal/')) {
                    mkdir('./assets/uploads/jurnal/', 0777, TRUE);
                }
                
                $config['upload_path']   = './assets/uploads/jurnal/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']      = 5120; // 5MB
                
                // Structured filename
                $ext = pathinfo($files['file_dokumentasi']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'JRN_DOC_' . $active_tp['tahun'] . '_' . $active_tp['semester'] . '_' . $guru_id . '_' . time() . '.' . $ext;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config);
                
                if ($this->CI->upload->do_upload('file_dokumentasi')) {
                    $upload_data = $this->CI->upload->data();
                    $file_path = 'assets/uploads/jurnal/' . $upload_data['file_name'];

                    // Google Drive Real-Time Upload Sync
                    $this->CI->load->helper('gdrive');
                    gdrive_upload_file($upload_data['full_path']);


                }
            }

            // File upload logic (Video)
            $video_path = NULL;
            if (!empty($files['file_video']['name'])) {
                if (!is_dir('./assets/uploads/jurnal_videos/')) {
                    mkdir('./assets/uploads/jurnal_videos/', 0777, TRUE);
                }
                
                $config_v['upload_path']   = './assets/uploads/jurnal_videos/';
                $config_v['allowed_types'] = 'mp4|mkv|avi|mov|3gp';
                $config_v['max_size']      = 20480; // 20MB
                
                // Structured filename
                $ext_v = pathinfo($files['file_video']['name'], PATHINFO_EXTENSION);
                $config_v['file_name'] = 'JRN_VID_' . $active_tp['tahun'] . '_' . $active_tp['semester'] . '_' . $guru_id . '_' . time() . '.' . $ext_v;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config_v);
                
                if ($this->CI->upload->do_upload('file_video')) {
                    $upload_data_v = $this->CI->upload->data();
                    $video_path = 'assets/uploads/jurnal_videos/' . $upload_data_v['file_name'];
                }
            }

            $jurnal_data = array(
                'kode_jurnal' => $this->CI->jurnal_model->generate_kode_jurnal(),
                'tanggal' => $post_data['tanggal'],
                'tahun_pelajaran_id' => $active_tp['id'],
                'kelas_id' => $post_data['kelas_id'],
                'mapel_id' => $post_data['mapel_id'],
                'guru_id' => $guru_id,
                'perangkat_ajar_id' => !empty($post_data['perangkat_ajar_id']) ? $post_data['perangkat_ajar_id'] : NULL,
                'pertemuan_ke' => !empty($post_data['pertemuan_ke']) ? $post_data['pertemuan_ke'] : NULL,
                'jam_ke' => $jam_ke_str,
                'materi_pembelajaran' => $post_data['materi_pembelajaran'],
                'capaian_pembelajaran' => isset($post_data['capaian_pembelajaran']) ? $post_data['capaian_pembelajaran'] : NULL,
                'tujuan_pembelajaran' => isset($post_data['tujuan_pembelajaran']) ? $post_data['tujuan_pembelajaran'] : NULL,
                'indikator_tp' => isset($post_data['tujuan_pembelajaran']) ? $post_data['tujuan_pembelajaran'] : (isset($post_data['indikator_tp']) ? $post_data['indikator_tp'] : $post_data['materi_pembelajaran']),
                'sub_materi' => isset($post_data['sub_materi']) ? $post_data['sub_materi'] : NULL,
                'metode_pembelajaran' => isset($post_data['metode_pembelajaran']) ? $post_data['metode_pembelajaran'] : NULL,
                'model_pembelajaran' => isset($post_data['model_pembelajaran']) ? $post_data['model_pembelajaran'] : NULL,
                'media_pembelajaran' => isset($post_data['media_pembelajaran']) ? $post_data['media_pembelajaran'] : NULL,
                'sumber_belajar' => isset($post_data['sumber_belajar']) ? $post_data['sumber_belajar'] : NULL,
                'bentuk_penilaian' => isset($post_data['bentuk_penilaian']) ? $post_data['bentuk_penilaian'] : NULL,
                'alokasi_waktu' => isset($post_data['alokasi_waktu']) ? $post_data['alokasi_waktu'] : NULL,
                'catatan_pembelajaran' => isset($post_data['catatan_pembelajaran']) ? $post_data['catatan_pembelajaran'] : NULL,
                'refleksi_pembelajaran' => isset($post_data['refleksi_pembelajaran']) ? $post_data['refleksi_pembelajaran'] : NULL,
                'kendala' => isset($post_data['kendala']) ? $post_data['kendala'] : NULL,
                'solusi' => isset($post_data['solusi']) ? $post_data['solusi'] : NULL,
                'hambatan_solusi' => (!empty($post_data['kendala']) || !empty($post_data['solusi'])) ? ($post_data['kendala'] . ' | ' . $post_data['solusi']) : NULL,
                'file_dokumentasi' => $file_path,
                'file_video' => $video_path,
                'status' => 'Submitted',
                'created_by' => $current_user_id
            );

            $this->CI->db->insert('jurnal_guru', $jurnal_data);
            $jurnal_id = $this->CI->db->insert_id();

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menyimpan Jurnal ke database.');
            } else {
                $this->trans_commit();

                // Clear dashboard statistics cache
                $dashboardService = new DashboardService();
                $dashboardService->clear_dashboard_cache();

                $this->CI->logger_lib->log('CREATE_JURNAL', 'Membuat Jurnal Kode: ' . $jurnal_data['kode_jurnal']);
                return array('status' => true, 'jurnal_id' => $jurnal_id);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    public function update_jurnal($id, $post_data, $files, $active_tp, $current_user_id) {
        $this->trans_begin();

        try {
            $existing = $this->CI->jurnal_model->get_by_id($id);
            if (!$existing) {
                return array('status' => false, 'message' => 'Data Jurnal tidak ditemukan.');
            }

            $guru = $this->CI->master_model->get_guru_by_user_id($current_user_id);
            $guru_id = isset($post_data['guru_id']) && !empty($post_data['guru_id']) 
                ? $post_data['guru_id'] 
                : ($guru ? $guru['id'] : $existing['guru_id']);

            $jam_mulai = isset($post_data['jam_mulai_ke']) ? $post_data['jam_mulai_ke'] : '';
            $jam_selesai = isset($post_data['jam_selesai_ke']) ? $post_data['jam_selesai_ke'] : '';
            if ($jam_mulai && $jam_selesai) {
                $jam_ke_str = ($jam_mulai == $jam_selesai) ? $jam_mulai : ($jam_mulai . '-' . $jam_selesai);
            } else {
                $jam_ke_str = isset($post_data['jam_ke']) ? $post_data['jam_ke'] : $existing['jam_ke'];
            }

            // Optional new photo/document upload
            $file_path = $existing['file_dokumentasi'];
            if (!empty($files['file_dokumentasi']['name'])) {
                if (!is_dir('./assets/uploads/jurnal/')) {
                    mkdir('./assets/uploads/jurnal/', 0777, TRUE);
                }
                
                $config['upload_path']   = './assets/uploads/jurnal/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']      = 5120; // 5MB
                
                $ext = pathinfo($files['file_dokumentasi']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'JRN_DOC_' . $active_tp['tahun'] . '_' . $active_tp['semester'] . '_' . $guru_id . '_' . time() . '.' . $ext;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config);
                
                if ($this->CI->upload->do_upload('file_dokumentasi')) {
                    $upload_data = $this->CI->upload->data();
                    $file_path = 'assets/uploads/jurnal/' . $upload_data['file_name'];

                    // Google Drive Real-Time Upload Sync
                    $this->CI->load->helper('gdrive');
                    gdrive_upload_file($upload_data['full_path']);
                }
            }

            // Optional new video upload
            $video_path = $existing['file_video'];
            if (!empty($files['file_video']['name'])) {
                if (!is_dir('./assets/uploads/jurnal_videos/')) {
                    mkdir('./assets/uploads/jurnal_videos/', 0777, TRUE);
                }
                
                $config_v['upload_path']   = './assets/uploads/jurnal_videos/';
                $config_v['allowed_types'] = 'mp4|mkv|avi|mov|3gp';
                $config_v['max_size']      = 20480; // 20MB
                
                $ext_v = pathinfo($files['file_video']['name'], PATHINFO_EXTENSION);
                $config_v['file_name'] = 'JRN_VID_' . $active_tp['tahun'] . '_' . $active_tp['semester'] . '_' . $guru_id . '_' . time() . '.' . $ext_v;

                $this->CI->load->library('upload');
                $this->CI->upload->initialize($config_v);
                
                if ($this->CI->upload->do_upload('file_video')) {
                    $upload_data_v = $this->CI->upload->data();
                    $video_path = 'assets/uploads/jurnal_videos/' . $upload_data_v['file_name'];
                }
            }

            $jurnal_data = array(
                'tanggal' => $post_data['tanggal'],
                'kelas_id' => $post_data['kelas_id'],
                'mapel_id' => $post_data['mapel_id'],
                'guru_id' => $guru_id,
                'perangkat_ajar_id' => !empty($post_data['perangkat_ajar_id']) ? $post_data['perangkat_ajar_id'] : $existing['perangkat_ajar_id'],
                'pertemuan_ke' => !empty($post_data['pertemuan_ke']) ? $post_data['pertemuan_ke'] : $existing['pertemuan_ke'],
                'jam_ke' => $jam_ke_str,
                'materi_pembelajaran' => $post_data['materi_pembelajaran'],
                'capaian_pembelajaran' => isset($post_data['capaian_pembelajaran']) ? $post_data['capaian_pembelajaran'] : $existing['capaian_pembelajaran'],
                'tujuan_pembelajaran' => isset($post_data['tujuan_pembelajaran']) ? $post_data['tujuan_pembelajaran'] : $existing['tujuan_pembelajaran'],
                'indikator_tp' => isset($post_data['tujuan_pembelajaran']) ? $post_data['tujuan_pembelajaran'] : (isset($post_data['indikator_tp']) ? $post_data['indikator_tp'] : $post_data['materi_pembelajaran']),
                'sub_materi' => isset($post_data['sub_materi']) ? $post_data['sub_materi'] : $existing['sub_materi'],
                'metode_pembelajaran' => isset($post_data['metode_pembelajaran']) ? $post_data['metode_pembelajaran'] : $existing['metode_pembelajaran'],
                'model_pembelajaran' => isset($post_data['model_pembelajaran']) ? $post_data['model_pembelajaran'] : $existing['model_pembelajaran'],
                'media_pembelajaran' => isset($post_data['media_pembelajaran']) ? $post_data['media_pembelajaran'] : $existing['media_pembelajaran'],
                'sumber_belajar' => isset($post_data['sumber_belajar']) ? $post_data['sumber_belajar'] : $existing['sumber_belajar'],
                'bentuk_penilaian' => isset($post_data['bentuk_penilaian']) ? $post_data['bentuk_penilaian'] : $existing['bentuk_penilaian'],
                'alokasi_waktu' => isset($post_data['alokasi_waktu']) ? $post_data['alokasi_waktu'] : $existing['alokasi_waktu'],
                'catatan_pembelajaran' => isset($post_data['catatan_pembelajaran']) ? $post_data['catatan_pembelajaran'] : $existing['catatan_pembelajaran'],
                'refleksi_pembelajaran' => isset($post_data['refleksi_pembelajaran']) ? $post_data['refleksi_pembelajaran'] : $existing['refleksi_pembelajaran'],
                'kendala' => isset($post_data['kendala']) ? $post_data['kendala'] : $existing['kendala'],
                'solusi' => isset($post_data['solusi']) ? $post_data['solusi'] : $existing['solusi'],
                'hambatan_solusi' => (!empty($post_data['kendala']) || !empty($post_data['solusi'])) ? ($post_data['kendala'] . ' | ' . $post_data['solusi']) : $existing['hambatan_solusi'],
                'file_dokumentasi' => $file_path,
                'file_video' => $video_path,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->CI->db->where('id', $id);
            $this->CI->db->update('jurnal_guru', $jurnal_data);

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal memperbarui Jurnal ke database.');
            } else {
                $this->trans_commit();

                $dashboardService = new DashboardService();
                $dashboardService->clear_dashboard_cache();

                $this->CI->logger_lib->log('UPDATE_JURNAL', 'Memperbarui Jurnal ID: ' . $id);
                return array('status' => true, 'jurnal_id' => $id);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    public function delete_jurnal($id) {
        $jurnal = $this->CI->jurnal_model->get_by_id($id);
        if ($jurnal) {
            $this->trans_begin();
            $this->CI->jurnal_model->delete($id);

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return false;
            } else {
                $this->trans_commit();
                
                $dashboardService = new DashboardService();
                $dashboardService->clear_dashboard_cache();

                $this->CI->logger_lib->log('DELETE_JURNAL', 'Menghapus Jurnal ID: ' . $id);
                return true;
            }
        }
        return false;
    }
}
