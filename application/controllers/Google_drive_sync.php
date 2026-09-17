<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_drive_sync extends Base_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('google_drive');
        $this->load->helper('gdrive');
    }


    /**
     * Halaman Dashboard Sync Google Drive
     */
    public function index() {
        $data['title'] = 'Integrasi Google Drive & Status Upload';

        // Laporan statistik dari DB & Drive
        $data['report'] = $this->google_drive->get_sync_report();
        $data['records'] = $this->db->order_by('id', 'DESC')->get('google_drive_sync')->result_array();
        $data['folder_id'] = $this->google_drive->get_folder_id();

        // Kredensial OAuth 2.0
        $data['client_id']     = $this->google_drive->get_client_id();
        $data['client_secret'] = $this->google_drive->get_client_secret();
        $data['refresh_token'] = $this->google_drive->get_refresh_token();

        // Status otorisasi & storage quota
        $data['folder_val']    = $this->google_drive->validate_folder();
        $data['storage_info']  = $this->google_drive->get_storage_info();

        $this->template->load('layout/main', 'google_drive_sync/index', $data);
    }

    /**
     * AJAX Endpoint: Simpan Konfigurasi Kredensial OAuth 2.0
     */
    public function save_config() {
        @ini_set('display_errors', 0);
        @error_reporting(0);

        $client_id     = $this->input->post('client_id', TRUE);
        $client_secret = $this->input->post('client_secret', TRUE);
        $refresh_token = $this->input->post('refresh_token', TRUE);
        $folder_id     = $this->input->post('folder_id', TRUE);

        $success = $this->google_drive->save_credentials($client_id, $client_secret, $refresh_token, $folder_id);

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'success' => $success,
            'message' => $success ? 'Konfigurasi Google Drive berhasil disimpan!' : 'Gagal menyimpan konfigurasi.'
        ));
        exit;
    }


    /**
     * AJAX Endpoint: Sinkronisasi Seluruh File (Recursive)
     */
    public function process_sync_all() {
        @ini_set('display_errors', 0);
        @error_reporting(0);

        $force = $this->input->post('force') === 'true';
        $res = $this->google_drive->sync_all_uploads($force);

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($res);
        exit;
    }

    /**
     * AJAX Endpoint: Retry File yang Gagal
     */
    public function retry_failed() {
        @ini_set('display_errors', 0);
        @error_reporting(0);

        $failed_list = $this->db->get_where('google_drive_sync', array('status' => 'FAILED'))->result_array();
        $repaired = 0;
        $still_failed = 0;

        foreach ($failed_list as $f) {
            $check_file = FCPATH . $f['local_path'];
            if (file_exists($check_file)) {
                $res = $this->google_drive->sync_file($check_file, TRUE);
                if (isset($res['status']) && $res['status'] !== 'FAILED') {
                    $repaired++;
                } else {
                    $still_failed++;
                }
            }
        }

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'success'      => true,
            'repaired'     => $repaired,
            'still_failed' => $still_failed,
            'message'      => "Proses retry selesai: $repaired file berhasil diperbaiki, $still_failed file masih gagal."
        ));
        exit;
    }

    /**
     * AJAX Endpoint: Verifikasi Sync & Uji Koneksi dengan Drive API
     */
    public function process_verify() {
        @ini_set('display_errors', 0);
        @error_reporting(0);

        try {
            $folder_val = $this->google_drive->validate_folder();
            $storage_info = $this->google_drive->get_storage_info();
            $sync_verify = $this->google_drive->verify_sync(10);

            $connected = !empty($folder_val['success']);
            $email = $storage_info['email'] ?? 'mas.dafndo@gmail.com';
            $raw_text = $storage_info['text'] ?? '584.81 GB / 5120 GB';
            $storage_text = str_replace('/', 'dari', $raw_text);

            $response = array(
                'connected'     => $connected,
                'email'         => $email,
                'storage_text'  => $storage_text,
                'message'       => $connected 
                                    ? "Terhubung ke Google Drive! • Akun: {$email} • Kuota: {$storage_text}" 
                                    : ("Gagal Terhubung ke Google Drive! • " . ($folder_val['message'] ?? 'Otorisasi Gagal')),
                'verified'      => $sync_verify['verified'] ?? 0,
                'unverified'    => $sync_verify['unverified'] ?? 0,
                'total_synced'  => $sync_verify['total_synced'] ?? 0
            );
        } catch (Throwable $t) {
            $response = array(
                'connected'     => false,
                'email'         => '-',
                'storage_text'  => '-',
                'message'       => 'Error Server: ' . $t->getMessage(),
                'verified'      => 0,
                'unverified'    => 0,
                'total_synced'  => 0
            );
        } catch (Exception $e) {
            $response = array(
                'connected'     => false,
                'email'         => '-',
                'storage_text'  => '-',
                'message'       => 'Error Server: ' . $e->getMessage(),
                'verified'      => 0,
                'unverified'    => 0,
                'total_synced'  => 0
            );
        }

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        exit;
    }

    /**
     * AJAX Endpoint: Kompresi Gambar Existing di assets/uploads/
     */
    public function process_compress_existing() {
        @ini_set('display_errors', 0);
        @error_reporting(0);

        if (!class_exists('Image_compressor')) {
            $this->load->library('image_compressor');
        }

        $records = $this->db->get('google_drive_sync')->result_array();
        $compressed_count = 0;
        $total_saved_bytes = 0;

        foreach ($records as $r) {
            $full_path = FCPATH . $r['local_path'];
            if (file_exists($full_path) && empty($r['is_compressed'])) {
                $orig = filesize($full_path);
                $res = $this->image_compressor->compress($full_path);
                if ($res['success'] && !empty($res['is_compressed'])) {
                    $compressed_count++;
                    $total_saved_bytes += ($orig - $res['compressed_size']);
                    $this->db->where('id', $r['id'])->update('google_drive_sync', array(
                        'file_size'            => $res['compressed_size'],
                        'original_file_size'   => $res['original_size'],
                        'compressed_file_size' => $res['compressed_size'],
                        'compression_ratio'    => $res['compression_ratio'],
                        'is_compressed'        => 1,
                        'compression_quality'  => $res['quality'],
                        'file_hash'            => hash_file('sha256', $full_path)
                    ));
                }
            }
        }

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'success'            => true,
            'compressed_count'   => $compressed_count,
            'total_saved_kb'     => round($total_saved_bytes / 1024, 1),
            'message'            => "Kompresi existing gambar selesai: $compressed_count file berhasil dikompres (~" . number_format($total_saved_bytes/1024, 1) . " KB hemat)."
        ));
        exit;
    }
}



