<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Media Controller — Automatic Google Drive Fallback Handler
 * 
 * Menangani permintaan berkas gambar/dokumen di assets/uploads/
 * yang tidak ada di penyimpanan lokal server (misal: telah dipindah/disinkronkan
 * ke Google Drive atau di-upload dari lingkungan lain).
 */
class Media extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Fallback handler untuk assets/uploads/(.+)
     */
    public function serve() {
        $args = func_get_args();
        if (empty($args)) {
            show_404();
            return;
        }

        $rel_path = implode('/', $args);
        $full_local_path = FCPATH . 'assets/uploads/' . $rel_path;

        // 1. Jika berkas fisik ternyata ada di server lokal, tampilkan langsung
        if (file_exists($full_local_path) && is_file($full_local_path)) {
            $mime = mime_content_type($full_local_path) ?: 'image/jpeg';
            header('Content-Type: ' . $mime);
            header('Content-Length: ' . filesize($full_local_path));
            readfile($full_local_path);
            exit;
        }

        // 2. Jika berkas fisik tidak ada di lokal, cari drive_file_id di tabel database google_drive_sync
        $file_name = basename($rel_path);
        $db_rec = $this->db->group_start()
            ->where('local_path', 'assets/uploads/' . $rel_path)
            ->or_where('relative_path', $rel_path)
            ->or_where('file_name', $file_name)
            ->group_end()
            ->where('drive_file_id IS NOT NULL')
            ->where('drive_file_id !=', '')
            ->order_by('id', 'DESC')
            ->get('google_drive_sync')
            ->row_array();

        if (!empty($db_rec['drive_file_id'])) {
            $drive_file_id = $db_rec['drive_file_id'];
            // Redirect ke Google Drive Direct View / Thumbnail Stream
            $redirect_url = "https://lh3.googleusercontent.com/d/" . $drive_file_id;
            header("Location: " . $redirect_url, true, 302);
            exit;
        }

        // 3. Jika tidak ditemukan di Google Drive, tampilkan 404
        show_404();
    }
}
