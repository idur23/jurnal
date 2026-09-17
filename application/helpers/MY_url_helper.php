<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter 3 MY_url_helper Extension
 * Mencegah penggabungan domain lokal (localhost) pada URL eksternal (Google Drive).
 */
if (!function_exists('base_url')) {
    function base_url($uri = '', $protocol = NULL) {
        if (!empty($uri)) {
            if (is_array($uri)) {
                $uri = implode('/', $uri);
            }
            $uri_str = (string)$uri;
            if (strpos($uri_str, 'http://') === 0 || strpos($uri_str, 'https://') === 0 || strpos($uri_str, '//') === 0) {
                return $uri_str;
            }
        }
        return get_instance()->config->base_url($uri, $protocol);
    }
}

if (!function_exists('gdrive_media_url')) {
    /**
     * Konversi URL / Path file menjadi URL Google Drive thumbnail / stream langsung
     */
    function gdrive_media_url($path_or_url) {
        if (empty($path_or_url)) return '';

        // 1. Jika sudah berupa URL Google Drive atau URL HTTP(S) eksternal
        if (strpos($path_or_url, 'http://') === 0 || strpos($path_or_url, 'https://') === 0) {
            if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $path_or_url, $matches)) {
                return "https://drive.google.com/thumbnail?id=" . $matches[1] . "&sz=w1000";
            } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $path_or_url, $matches)) {
                return "https://drive.google.com/thumbnail?id=" . $matches[1] . "&sz=w1000";
            }
            return $path_or_url;
        }

        // 2. Jika berupa path lokal / relatif, cari drive_file_id di database google_drive_sync
        $CI =& get_instance();
        $file_name = basename($path_or_url);

        if (isset($CI->db)) {
            $rec = $CI->db->group_start()
                ->where('local_path', $path_or_url)
                ->or_where('relative_path', $path_or_url)
                ->or_where('file_name', $file_name)
                ->group_end()
                ->where('drive_file_id IS NOT NULL')
                ->where('drive_file_id !=', '')
                ->order_by('id', 'DESC')
                ->get('google_drive_sync')
                ->row_array();

            if (!empty($rec['drive_file_id'])) {
                return "https://drive.google.com/thumbnail?id=" . $rec['drive_file_id'] . "&sz=w1000";
            }
        }

        return base_url($path_or_url);
    }
}
