<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Helper Utility untuk Google Drive Upload Integration
 */
if (!function_exists('gdrive_upload_file')) {
    /**
     * Mengunggah file lokal ke Google Drive via Google_drive Library.
     * Jika gagal atau belum dikonfigurasi, mengembalikan false sehingga
     * sistem dapat memproses fallback penyimpanan lokal dengan aman.
     *
     * @param string $local_full_path Path lengkap file lokal di server
     * @param string|null $custom_name Nama custom file di Google Drive
     * @param string|null $subfolder_name Nama/path subfolder otomatis (contoh: "Dokumentasi_Jurnal/2026-2027_Ganjil")
     * @param string|null $folder_id Folder ID root opsional
     * @return array|false Metadata upload Google Drive atau false jika gagal
     */
    function gdrive_upload_file($local_full_path, $custom_name = NULL, $subfolder_name = NULL, $folder_id = NULL) {
        $CI =& get_instance();
        
        if (!class_exists('Google_drive')) {
            $CI->load->library('google_drive');
        }

        if (!$CI->google_drive->authenticate()) {
            log_message('debug', 'Google Drive OAuth belum terotentikasi: ' . $CI->google_drive->get_last_error());
            return false;
        }

        $res = $CI->google_drive->sync_file($local_full_path);


        if ($res['success']) {
            log_message('info', 'File berhasil diunggah ke Google Drive ID: ' . $res['id']);
            return $res;
        } else {
            log_message('error', 'Gagal mengunggah file ke Google Drive: ' . $res['message']);
            return false;
        }
    }

}

if (!function_exists('gdrive_validate_config')) {
    /**
     * Memvalidasi konfigurasi Google Drive dan permission folder saat ini
     */
    function gdrive_validate_config($folder_id = NULL) {
        $CI =& get_instance();

        if (!class_exists('Google_drive')) {
            $CI->load->library('google_drive');
        }

        return $CI->google_drive->validate_folder($folder_id);
    }
}

if (!function_exists('gdrive_sync_file')) {
    /**
     * Sinkronisasi 1 file lokal ke Google Drive dengan pencatatan database google_drive_sync
     */
    function gdrive_sync_file($local_path_or_full_path, $force_update = FALSE) {
        $CI =& get_instance();
        if (!class_exists('Google_drive')) {
            $CI->load->library('google_drive');
        }
        return $CI->google_drive->sync_file($local_path_or_full_path, $force_update);
    }
}

if (!function_exists('gdrive_sync_all')) {
    /**
     * Sinkronisasi recursive seluruh assets/uploads/ ke Google Drive
     */
    function gdrive_sync_all($force_update = FALSE, $limit = NULL) {
        $CI =& get_instance();
        if (!class_exists('Google_drive')) {
            $CI->load->library('google_drive');
        }
        return $CI->google_drive->sync_all_uploads($force_update, $limit);
    }
}

