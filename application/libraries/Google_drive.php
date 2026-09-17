<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ====================================================================
 * GOOGLE DRIVE API v3 (OAUTH 2.0) LIBRARY FOR CODEIGNITER 3
 * Website Jurnal Guru Enterprise
 * ====================================================================
 * 
 * Library terpusat untuk mengelola integrasi Google Drive API v3.
 * Menggunakan OAuth 2.0 dengan Refresh Token tanpa bergantung pada
 * Service Account personal quota.
 */
class Google_drive {

    protected $CI;

    // Credentials & Configurations
    protected $client_id;
    protected $client_secret;
    protected $refresh_token;
    protected $folder_id;
    protected $drive_id;
    protected $folder_name;
    protected $auto_delete_local;

    // Internal State & Errors
    protected $access_token = null;
    protected $token_expires_at = 0;
    protected $last_error = '';

    public function __construct() {
        $this->CI = get_instance();
        $this->load_config();
        $this->ensure_db_table();
    }

    /**
     * Memastikan tabel database google_drive_sync dibuat secara otomatis jika belum ada di hosting
     */
    private function ensure_db_table() {
        if (isset($this->CI->db)) {
            if (!$this->CI->db->table_exists('google_drive_sync')) {
                $sql = "CREATE TABLE IF NOT EXISTS `google_drive_sync` (
                  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `local_path` VARCHAR(255) NOT NULL UNIQUE,
                  `relative_path` VARCHAR(255) NOT NULL,
                  `file_name` VARCHAR(255) NOT NULL,
                  `file_size` BIGINT NOT NULL DEFAULT 0,
                  `mime_type` VARCHAR(100) NOT NULL,
                  `drive_file_id` VARCHAR(255) NULL,
                  `drive_folder_id` VARCHAR(255) NULL,
                  `file_hash` VARCHAR(64) NULL,
                  `original_file_size` BIGINT NOT NULL DEFAULT 0,
                  `compressed_file_size` BIGINT NOT NULL DEFAULT 0,
                  `compression_ratio` FLOAT NOT NULL DEFAULT 0,
                  `is_compressed` TINYINT(1) NOT NULL DEFAULT 0,
                  `compression_quality` INT NOT NULL DEFAULT 100,
                  `status` ENUM('SYNCHRONIZED', 'PENDING', 'FAILED', 'LOCAL_MISSING') NOT NULL DEFAULT 'PENDING',
                  `last_synced_at` DATETIME NULL,
                  `error_message` TEXT NULL,
                  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  INDEX `idx_gds_status` (`status`),
                  INDEX `idx_gds_relpath` (`relative_path`),
                  INDEX `idx_gds_compressed` (`is_compressed`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
                @$this->CI->db->query($sql);
            } else {
                // Tambahkan kolom kompresi secara dinamis jika belum ada
                if (!$this->CI->db->field_exists('original_file_size', 'google_drive_sync')) {
                    @$this->CI->db->query("ALTER TABLE `google_drive_sync` ADD `original_file_size` BIGINT NOT NULL DEFAULT 0, ADD `compressed_file_size` BIGINT NOT NULL DEFAULT 0, ADD `compression_ratio` FLOAT NOT NULL DEFAULT 0, ADD `is_compressed` TINYINT(1) NOT NULL DEFAULT 0, ADD `compression_quality` INT NOT NULL DEFAULT 100;");
                }
            }
        }
    }



    /**
     * Memuat Konfigurasi Google Drive dari config/google_drive.php
     * atau fallback dari google_drive_credentials.json.
     */
    public function load_config() {
        $this->CI->config->load('google_drive', TRUE, TRUE);
        $cfg = $this->CI->config->item('google_drive') ?: array();

        $this->client_id         = trim($cfg['google_drive_client_id'] ?? '');
        $this->client_secret     = trim($cfg['google_drive_client_secret'] ?? '');
        $this->refresh_token     = trim($cfg['google_drive_refresh_token'] ?? '');
        $this->folder_id        = trim($cfg['google_drive_folder_id'] ?? ($cfg['google_drive_root_folder_id'] ?? ''));
        $this->drive_id           = trim($cfg['google_drive_id'] ?? '');
        $this->folder_name      = trim($cfg['google_drive_folder_name'] ?? 'Dokumentasi Jurnal Guru');
        $this->auto_delete_local = isset($cfg['google_drive_auto_delete_local']) ? (bool)$cfg['google_drive_auto_delete_local'] : TRUE;

        // Fallback: Jika config kosong, periksa file google_drive_credentials.json
        if (empty($this->client_id) || empty($this->refresh_token)) {
            $json_path = APPPATH . 'config/google_drive_credentials.json';
            if (file_exists($json_path)) {
                $raw = @file_get_contents($json_path);
                $json = json_decode($raw, true);
                if (isset($json['web'])) {
                    $this->client_id     = $this->client_id ?: trim($json['web']['client_id'] ?? '');
                    $this->client_secret = $this->client_secret ?: trim($json['web']['client_secret'] ?? '');
                    $this->refresh_token = $this->refresh_token ?: trim($json['web']['refresh_token'] ?? '');
                    $this->folder_id    = $this->folder_id ?: trim($json['web']['folder_id'] ?? '');
                    $this->drive_id       = $this->drive_id ?: trim($json['web']['drive_id'] ?? '');
                }
            }
        }
    }

    public function get_client_id() { return $this->client_id; }
    public function get_client_secret() { return $this->client_secret; }
    public function get_refresh_token() { return $this->refresh_token; }

    /**
     * Mengambil info akun dan kuota penyimpanan (Storage Quota) dari Google Drive API v3
     */
    public function get_storage_info() {
        $token = $this->get_access_token();
        if (!$token) {
            return array(
                'success' => false,
                'email' => 'Belum Terhubung',
                'usage_formatted' => '0 GB',
                'limit_formatted' => '0 GB',
                'text' => '0 GB / 5120 GB',
                'percent' => 0
            );
        }

        $url = "https://www.googleapis.com/drive/v3/about?fields=user,storageQuota";
        $headers = array("Authorization: Bearer " . $token);
        $res = $this->http_request($url, 'GET', null, $headers);

        if ($res['success']) {
            $json = json_decode($res['body'], true);
            $email = $json['user']['emailAddress'] ?? ($json['user']['displayName'] ?? 'Google Drive Account');
            $limit = isset($json['storageQuota']['limit']) ? (float)$json['storageQuota']['limit'] : 0;
            $usage = isset($json['storageQuota']['usage']) ? (float)$json['storageQuota']['usage'] : 0;

            $usage_gb = round($usage / (1024 * 1024 * 1024), 2);
            $limit_gb = $limit > 0 ? round($limit / (1024 * 1024 * 1024), 2) : 5120;
            $percent  = ($limit > 0) ? min(100, round(($usage / $limit) * 100, 1)) : 10;

            return array(
                'success'   => true,
                'email'     => $email,
                'usage_gb'  => $usage_gb,
                'limit_gb'  => $limit_gb,
                'text'      => "{$usage_gb} GB / {$limit_gb} GB",
                'percent'   => $percent
            );
        }

        return array(
            'success' => false,
            'email'   => 'Terhubung (OAuth API)',
            'text'    => 'Storage Quota Active',
            'percent' => 15
        );
    }

    /**
     * Menyimpan Konfigurasi Kredensial OAuth 2.0 ke file credentials JSON & config PHP
     */
    public function save_credentials($client_id, $client_secret, $refresh_token, $folder_id = NULL) {
        $client_id = trim($client_id);
        $client_secret = trim($client_secret);
        $refresh_token = trim($refresh_token);
        $folder_id = $folder_id ? trim($folder_id) : $this->folder_id;

        $cred_file = APPPATH . 'config/google_drive_credentials.json';
        $data = array(
            'web' => array(
                'client_id'     => $client_id,
                'client_secret' => $client_secret,
                'refresh_token' => $refresh_token,
                'folder_id'     => $folder_id,
                'drive_id'      => $this->drive_id
            )
        );

        $res_json = @file_put_contents($cred_file, json_encode($data, JSON_PRETTY_PRINT));

        $cfg_file = APPPATH . 'config/google_drive.php';
        if (file_exists($cfg_file)) {
            $content = @file_get_contents($cfg_file);
            $content = preg_replace("/\\$config\['google_drive_client_id'\]\s*=\s*'.*?';/", "\$config['google_drive_client_id'] = '{$client_id}';", $content);
            $content = preg_replace("/\\$config\['google_drive_client_secret'\]\s*=\s*'.*?';/", "\$config['google_drive_client_secret'] = '{$client_secret}';", $content);
            $content = preg_replace("/\\$config\['google_drive_refresh_token'\]\s*=\s*'.*?';/", "\$config['google_drive_refresh_token'] = '{$refresh_token}';", $content);
            if (!empty($folder_id)) {
                $content = preg_replace("/\\$config\['google_drive_folder_id'\]\s*=\s*'.*?';/", "\$config['google_drive_folder_id'] = '{$folder_id}';", $content);
                $content = preg_replace("/\\$config\['google_drive_root_folder_id'\]\s*=\s*'.*?';/", "\$config['google_drive_root_folder_id'] = '{$folder_id}';", $content);
            }
            @file_put_contents($cfg_file, $content);
        }

        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->refresh_token = $refresh_token;
        if (!empty($folder_id)) {
            $this->folder_id = $folder_id;
        }
        $this->access_token = null;

        return $res_json !== false;
    }

    /**
     * Set Folder ID tujuan secara dinamis dari Controller jika diperlukan
     */
    public function set_folder_id($folder_id) {
        $this->folder_id = trim($folder_id);
        return $this;
    }

    /**
     * Dapatkan Folder ID aktif saat ini
     */
    public function get_folder_id() {
        return $this->folder_id;
    }

    /**
     * Mengambil Access Token aktif dari Google OAuth 2.0
     * Menggunakan Refresh Token untuk memperbarui token secara otomatis.
     */
    public function get_access_token() {
        // Jika token sudah ada di memory dan belum expired, gunakan kembali
        if ($this->access_token && time() < ($this->token_expires_at - 60)) {
            return $this->access_token;
        }

        // Cek apakah credential lengkap
        if (empty($this->client_id) || empty($this->client_secret) || empty($this->refresh_token)) {
            $this->last_error = 'Google Drive OAuth credentials tidak lengkap. Pastikan Client ID, Client Secret, dan Refresh Token sudah diisi di config/google_drive.php.';
            return false;
        }

        $url = 'https://oauth2.googleapis.com/token';
        $post_fields = array(
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $this->refresh_token,
            'grant_type'    => 'refresh_token'
        );

        $response = $this->http_request($url, 'POST', http_build_query($post_fields), array(
            'Content-Type: application/x-www-form-urlencoded'
        ));

        if (!$response['success']) {
            $this->last_error = 'Gagal terhubung ke Google OAuth endpoint: ' . $response['error'];
            return false;
        }

        $json = json_decode($response['body'], true);
        if (isset($json['access_token'])) {
            $this->access_token = $json['access_token'];
            $expires_in = isset($json['expires_in']) ? (int)$json['expires_in'] : 3600;
            $this->token_expires_at = time() + $expires_in;
            return $this->access_token;
        } else {
            $err_msg = isset($json['error_description']) ? $json['error_description'] : (isset($json['error']) ? $json['error'] : 'Unknown OAuth error');
            $this->last_error = 'Google Drive refresh token invalid atau expired: ' . $err_msg;
            return false;
        }
    }

    /**
     * Alias method untuk authenticate()
     */
    public function authenticate() {
        return $this->get_access_token() !== false;
    }

    /**
     * Validasi apakah Folder ID Google Drive valid dan dapat diakses (Editor permission)
     */
    public function validate_folder($target_folder_id = NULL) {
        $folder_id = $target_folder_id ? trim($target_folder_id) : $this->folder_id;

        if (empty($folder_id)) {
            return array(
                'success' => false,
                'message' => 'Folder ID Google Drive belum dikonfigurasi.'
            );
        }

        $token = $this->get_access_token();
        if (!$token) {
            return array(
                'success' => false,
                'message' => 'Gagal otentikasi Google Drive OAuth: ' . $this->last_error
            );
        }

        // Endpoint GET file/folder metadata
        $url = "https://www.googleapis.com/drive/v3/files/" . urlencode($folder_id) . "?supportsAllDrives=true&includeItemsFromAllDrives=true&fields=id,name,mimeType,capabilities,trashed";
        $headers = array("Authorization: Bearer " . $token);

        $res = $this->http_request($url, 'GET', null, $headers);

        if (!$res['success']) {
            if ($res['http_code'] == 404) {
                return array('success' => false, 'message' => "Folder Google Drive tidak ditemukan (HTTP 404).");
            } elseif ($res['http_code'] == 403) {
                return array('success' => false, 'message' => "Folder Google Drive tidak dapat diakses oleh akun OAuth.");
            } else {
                return array('success' => false, 'message' => "Gagal mengakses Google Drive API: " . $res['error']);
            }
        }

        $json = json_decode($res['body'], true);

        if (empty($json) || isset($json['error'])) {
            $err_msg = isset($json['error']['message']) ? $json['error']['message'] : 'Response error';
            return array('success' => false, 'message' => "Google Drive API error: " . $err_msg);
        }

        // 1. Cek apakah folder dimasukkan ke sampah
        if (!empty($json['trashed'])) {
            return array('success' => false, 'message' => "Folder Google Drive yang dikonfigurasi ada di dalam Sampah (Trash).");
        }

        // 2. Cek MimeType harus folder
        if (isset($json['mimeType']) && $json['mimeType'] !== 'application/vnd.google-apps.folder') {
            return array('success' => false, 'message' => "Folder ID bukan merupakan sebuah folder Google Drive.");
        }

        // 3. Cek Permission Menulis/Menambah File
        if (isset($json['capabilities'])) {
            $can_add = isset($json['capabilities']['canAddChildren']) ? $json['capabilities']['canAddChildren'] : true;
            $can_edit = isset($json['capabilities']['canEdit']) ? $json['capabilities']['canEdit'] : true;
            if (!$can_add && !$can_edit) {
                return array('success' => false, 'message' => "Permission Google Drive tidak mencukupi (Membutuhkan akses Editor).");
            }
        }

        return array(
            'success' => true,
            'message' => 'Folder Google Drive valid dan siap digunakan.',
            'folder'  => $json
        );
    }

    /**
     * Upload File ke Google Drive menggunakan OAuth 2.0 (Multipart Upload)
     * Mendukung pembuatan subfolder otomatis (contoh: "Dokumentasi_Jurnal/2026-2027_Ganjil")
     */
    public function upload_file($file_path, $custom_name = NULL, $folder_id = NULL, $mime_type = NULL, $subfolder_name = NULL) {
        // 1. Validasi File Lokal
        if (!file_exists($file_path) || !is_readable($file_path)) {
            return array(
                'success' => false,
                'message' => 'File lokal tidak ditemukan atau tidak dapat dibaca: ' . $file_path
            );
        }

        // 2. Tentukan Parent Folder ID
        $target_folder_id = $folder_id ? trim($folder_id) : $this->folder_id;
        if (empty($target_folder_id)) {
            return array(
                'success' => false,
                'message' => 'Folder ID Google Drive belum ditentukan di konfigurasi.'
            );
        }

        // 3. Jika subfolder_name ditentukan, buat/gunakan subfolder otomatis
        if (!empty($subfolder_name)) {
            $target_folder_id = $this->get_or_create_subfolder($subfolder_name, $target_folder_id);
        }

        // 4. Validasi Akses Folder ID
        $valid_check = $this->validate_folder($target_folder_id);
        if (!$valid_check['success']) {
            return $valid_check;
        }

        // 5. Dapatkan Access Token
        $token = $this->get_access_token();
        if (!$token) {
            return array(
                'success' => false,
                'message' => 'Google Drive authentication failed: ' . $this->last_error
            );
        }


        // 5. Penyiapan Metadata & Stream File
        $file_name = $custom_name ?: basename($file_path);
        if (empty($mime_type)) {
            $mime_type = mime_content_type($file_path) ?: 'application/octet-stream';
        }

        $metadata = array(
            'name'     => $file_name,
            'parents'  => array($target_folder_id),
            'mimeType' => $mime_type
        );

        $boundary = '-------GoogleDriveUploadBoundary' . md5(time());
        $delimiter = "\r\n--" . $boundary . "\r\n";
        $close_delimiter = "\r\n--" . $boundary . "--";

        $file_content = file_get_contents($file_path);

        $post_body = $delimiter;
        $post_body .= "Content-Type: application/json; charset=UTF-8\r\n\r\n";
        $post_body .= json_encode($metadata);
        $post_body .= $delimiter;
        $post_body .= "Content-Type: " . $mime_type . "\r\n";
        $post_body .= "Content-Transfer-Encoding: binary\r\n\r\n";
        $post_body .= $file_content;
        $post_body .= $close_delimiter;

        $upload_url = "https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&supportsAllDrives=true&fields=id,name,mimeType,webViewLink,webContentLink,size";
        $headers = array(
            "Authorization: Bearer " . $token,
            "Content-Type: multipart/related; boundary=" . $boundary,
            "Content-Length: " . strlen($post_body)
        );

        // 6. Eksekusi Request cURL Upload
        $res = $this->http_request($upload_url, 'POST', $post_body, $headers);

        if (!$res['success']) {
            return array(
                'success' => false,
                'message' => 'Google Drive upload failed: ' . $res['error']
            );
        }

        $json = json_decode($res['body'], true);

        if (isset($json['id'])) {
            $file_id = $json['id'];
            $web_view_link = isset($json['webViewLink']) ? $json['webViewLink'] : "https://drive.google.com/file/d/{$file_id}/view";
            $web_content_link = isset($json['webContentLink']) ? $json['webContentLink'] : "https://drive.google.com/uc?id={$file_id}&export=download";

            // Hapus file temp lokal jika diizinkan konfigurasi
            if ($this->auto_delete_local) {
                @unlink($file_path);
            }

            if ($file_id) {
                $this->make_file_public($file_id);
            }

            return array(
                'success'        => true,
                'id'             => $file_id,
                'name'           => $json['name'] ?? $file_name,
                'mimeType'       => $json['mimeType'] ?? $mime_type,
                'size'           => $json['size'] ?? filesize($file_path),
                'webViewLink'    => $web_view_link,
                'webContentLink' => $web_content_link,
                'direct_url'     => "https://lh3.googleusercontent.com/d/{$file_id}",
                'folder_id'      => $target_folder_id,
                'message'        => 'File berhasil diunggah ke Google Drive.'
            );
        } else {
            $err_msg = isset($json['error']['message']) ? $json['error']['message'] : 'Gagal memproses upload';
            return array(
                'success' => false,
                'message' => 'Google Drive upload failed: ' . $err_msg
            );
        }
    }

    /**
     * Set permission file Google Drive menjadi Publik ("Anyone with the link can view")
     * agar gambar dapat ditampilkan secara langsung di tag <img> website/aplikasi.
     */
    public function make_file_public($file_id) {
        $token = $this->get_access_token();
        if (!$token) return false;

        $url = "https://www.googleapis.com/drive/v3/files/" . urlencode($file_id) . "/permissions?supportsAllDrives=true";
        $headers = array(
            "Authorization: Bearer " . $token,
            "Content-Type: application/json; charset=UTF-8"
        );
        $body = json_encode(array(
            'role' => 'reader',
            'type' => 'anyone'
        ));

        $res = $this->http_request($url, 'POST', $body, $headers);
        return $res['success'];
    }

    /**
     * Ambil metadata file dari Google Drive
     */
    public function get_file($file_id) {

        $token = $this->get_access_token();
        if (!$token) return false;

        $url = "https://www.googleapis.com/drive/v3/files/" . urlencode($file_id) . "?supportsAllDrives=true&fields=id,name,mimeType,size,createdTime,webViewLink,webContentLink,parents";
        $headers = array("Authorization: Bearer " . $token);

        $res = $this->http_request($url, 'GET', null, $headers);
        if ($res['success']) {
            return json_decode($res['body'], true);
        }
        return false;
    }

    /**
     * Hapus file dari Google Drive
     */
    public function delete_file($file_id) {
        $token = $this->get_access_token();
        if (!$token) return false;

        $url = "https://www.googleapis.com/drive/v3/files/" . urlencode($file_id) . "?supportsAllDrives=true";
        $headers = array("Authorization: Bearer " . $token);

        $res = $this->http_request($url, 'DELETE', null, $headers);
        return $res['success'] && ($res['http_code'] == 200 || $res['http_code'] == 204);
    }

    /**
     * Ambil metadata folder
     */
    public function get_folder($folder_id = NULL) {
        $valid = $this->validate_folder($folder_id);
        return $valid['success'] ? $valid['folder'] : false;
    }

    /**
     * Mencari atau membuat folder/sub-folder secara otomatis di Google Drive
     * Mendukung hirarki path (contoh: "Dokumentasi_Jurnal/2026-2027_Ganjil")
     */
    public function get_or_create_subfolder($subfolder_path, $parent_folder_id = NULL) {
        $current_parent = $parent_folder_id ? trim($parent_folder_id) : $this->folder_id;
        if (empty($current_parent) || empty(trim($subfolder_path))) {
            return $current_parent;
        }

        $token = $this->get_access_token();
        if (!$token) return $current_parent;

        $parts = array_filter(explode('/', trim($subfolder_path, '/')));
        if (empty($parts)) return $current_parent;

        foreach ($parts as $folder_name) {
            $folder_name = trim($folder_name);
            if (empty($folder_name)) continue;

            // 1. Cari folder di dalam $current_parent
            $query = sprintf("'%s' in parents and name = '%s' and mimeType = 'application/vnd.google-apps.folder' and trashed = false", $current_parent, addslashes($folder_name));
            $url = "https://www.googleapis.com/drive/v3/files?q=" . urlencode($query) . "&supportsAllDrives=true&includeItemsFromAllDrives=true&fields=files(id,name)";
            $headers = array("Authorization: Bearer " . $token);

            $res = $this->http_request($url, 'GET', null, $headers);
            $found_id = null;

            if ($res['success']) {
                $json = json_decode($res['body'], true);
                if (!empty($json['files'][0]['id'])) {
                    $found_id = $json['files'][0]['id'];
                }
            }

            // 2. Jika tidak ditemukan, buat folder baru di Google Drive
            if (!$found_id) {
                $create_url = "https://www.googleapis.com/drive/v3/files?supportsAllDrives=true&fields=id,name";
                $metadata = array(
                    'name'     => $folder_name,
                    'mimeType' => 'application/vnd.google-apps.folder',
                    'parents'  => array($current_parent)
                );
                $create_headers = array(
                    "Authorization: Bearer " . $token,
                    "Content-Type: application/json; charset=UTF-8"
                );
                $create_res = $this->http_request($create_url, 'POST', json_encode($metadata), $create_headers);

                if ($create_res['success']) {
                    $c_json = json_decode($create_res['body'], true);
                    if (!empty($c_json['id'])) {
                        $found_id = $c_json['id'];
                    }
                }
            }

            if ($found_id) {
                $current_parent = $found_id;
            } else {
                break;
            }
        }

        return $current_parent;
    }

    /**
     * Memperbarui konten file yang sudah ada di Google Drive (Mencegah Duplikasi)
     */
    public function update_file($file_id, $file_path, $mime_type = NULL) {
        if (!file_exists($file_path)) {
            return array('success' => false, 'message' => 'File lokal tidak ditemukan');
        }

        $token = $this->get_access_token();
        if (!$token) return array('success' => false, 'message' => $this->last_error);

        if (empty($mime_type)) {
            $mime_type = mime_content_type($file_path) ?: 'application/octet-stream';
        }

        $file_content = file_get_contents($file_path);
        $url = "https://www.googleapis.com/upload/drive/v3/files/" . urlencode($file_id) . "?uploadType=media&supportsAllDrives=true";
        $headers = array(
            "Authorization: Bearer " . $token,
            "Content-Type: " . $mime_type,
            "Content-Length: " . strlen($file_content)
        );

        $res = $this->http_request($url, 'PATCH', $file_content, $headers);
        if ($res['success']) {
            $json = json_decode($res['body'], true);
            return array(
                'success' => true,
                'id'      => $json['id'] ?? $file_id,
                'name'    => $json['name'] ?? basename($file_path),
                'message' => 'File Google Drive berhasil diperbarui.'
            );
        } else {
            return array('success' => false, 'message' => 'Gagal memperbarui file Google Drive: ' . $res['error']);
        }
    }

    /**
     * Mencari file di dalam folder Google Drive tertentu berdasarkan nama file
     */
    public function find_file_in_folder($file_name, $folder_id) {
        $token = $this->get_access_token();
        if (!$token) return false;

        $query = sprintf("'%s' in parents and name = '%s' and trashed = false", $folder_id, addslashes($file_name));
        $url = "https://www.googleapis.com/drive/v3/files?q=" . urlencode($query) . "&supportsAllDrives=true&includeItemsFromAllDrives=true&fields=files(id,name,mimeType,size,sha256Checksum)";
        $headers = array("Authorization: Bearer " . $token);

        $res = $this->http_request($url, 'GET', null, $headers);
        if ($res['success']) {
            $json = json_decode($res['body'], true);
            if (!empty($json['files'][0])) {
                return $json['files'][0];
            }
        }
        return false;
    }

    /**
     * Sinkronisasi 1 file lokal tertentu ke Google Drive dengan deteksi Hash (SHA-256)
     */
    public function sync_file($full_local_path, $force_update = FALSE, $auto_delete = FALSE) {
        $full_local_path = str_replace('\\', '/', realpath($full_local_path));
        if (!$full_local_path || !file_exists($full_local_path)) {
            return array('status' => 'FAILED', 'message' => 'File lokal tidak ditemukan: ' . $full_local_path);
        }

        // Tentukan path relatif dari root project atau assets/uploads
        $root_dir = str_replace('\\', '/', realpath(FCPATH . 'assets/uploads'));
        if (!$root_dir) {
            $root_dir = str_replace('\\', '/', realpath(FCPATH));
        }

        if (strpos($full_local_path, $root_dir) === 0) {
            $rel_path = ltrim(substr($full_local_path, strlen($root_dir)), '/');
        } else {
            $rel_path = basename($full_local_path);
        }

        $local_path = 'assets/uploads/' . $rel_path;
        $file_name = basename($full_local_path);
        $file_size = filesize($full_local_path);
        $mime_type = mime_content_type($full_local_path) ?: 'application/octet-stream';
        $file_hash = hash_file('sha256', $full_local_path);

        // Subfolder path di Drive (contoh: "jurnal" atau "MBF" atau "perangkat/2026_2027/Ganjil")
        $dir_name = dirname($rel_path);
        $subfolder_path = ($dir_name === '.' || $dir_name === '') ? '' : $dir_name;
        if ($subfolder_path === 'mbf_jurnal') {
            $subfolder_path = 'MBF';
        }

        // Parent folder ID di Google Drive
        $target_folder_id = $this->folder_id;
        if (!empty($subfolder_path)) {
            $target_folder_id = $this->get_or_create_subfolder($subfolder_path, $this->folder_id);
        }

        // Cek rekaman di tabel database google_drive_sync
        $db_rec = $this->CI->db->get_where('google_drive_sync', array('local_path' => $local_path))->row_array();

        // 1. Cek jika sudah ter-sync & file_hash sama
        if ($db_rec && $db_rec['status'] === 'SYNCHRONIZED' && $db_rec['file_hash'] === $file_hash && !$force_update) {
            return array(
                'success'        => true,
                'status'         => 'SKIPPED',
                'id'             => $db_rec['drive_file_id'],
                'drive_file_id'  => $db_rec['drive_file_id'],
                'drive_folder_id'=> $db_rec['drive_folder_id'],
                'webViewLink'    => "https://drive.google.com/file/d/{$db_rec['drive_file_id']}/view",
                'direct_url'     => "https://lh3.googleusercontent.com/d/{$db_rec['drive_file_id']}",
                'local_path'     => $local_path,
                'message'        => 'File sudah ter-sinkronisasi (Hash cocok).'
            );
        }

        // 2. Jalankan Kompresi Foto Otomatis ~50% (Hanya untuk Image)
        if (!class_exists('Image_compressor')) {
            $this->CI->load->library('image_compressor');
        }

        $comp_info = array(
            'original_file_size'   => $file_size,
            'compressed_file_size' => $file_size,
            'compression_ratio'    => 0.0,
            'is_compressed'        => 0,
            'compression_quality'  => 100
        );

        if (!($db_rec && !empty($db_rec['is_compressed']))) {
            $c_res = $this->CI->image_compressor->compress($full_local_path);
            if ($c_res['success'] && !empty($c_res['is_compressed'])) {
                $comp_info['original_file_size']   = $c_res['original_size'];
                $comp_info['compressed_file_size'] = $c_res['compressed_size'];
                $comp_info['compression_ratio']    = $c_res['compression_ratio'];
                $comp_info['is_compressed']        = 1;
                $comp_info['compression_quality']  = $c_res['quality'];
                $file_size                         = $c_res['compressed_size'];
                $file_hash                         = hash_file('sha256', $full_local_path);
            }
        } elseif ($db_rec) {
            $comp_info['original_file_size']   = $db_rec['original_file_size'] ?? $file_size;
            $comp_info['compressed_file_size'] = $db_rec['compressed_file_size'] ?? $file_size;
            $comp_info['compression_ratio']    = $db_rec['compression_ratio'] ?? 0;
            $comp_info['is_compressed']        = $db_rec['is_compressed'] ?? 0;
            $comp_info['compression_quality']  = $db_rec['compression_quality'] ?? 100;
        }

        // 3. Cek apakah file sudah ada di Google Drive (via DB record atau query Drive API)
        $existing_drive_id = $db_rec['drive_file_id'] ?? null;
        if (!$existing_drive_id) {
            $found_drive_file = $this->find_file_in_folder($file_name, $target_folder_id);
            if ($found_drive_file) {
                $existing_drive_id = $found_drive_file['id'];
            }
        }

        $sync_result = null;
        $status = 'PENDING';
        $error_msg = null;

        if ($existing_drive_id) {
            // Update file yang sudah ada di Drive
            $upd = $this->update_file($existing_drive_id, $full_local_path, $mime_type);
            if ($upd['success']) {
                $this->make_file_public($existing_drive_id);
                $status = 'SYNCHRONIZED';
                $sync_result = array(
                    'success'        => true,
                    'status'         => 'UPDATED',
                    'id'             => $existing_drive_id,
                    'drive_file_id'  => $existing_drive_id,
                    'webViewLink'    => "https://drive.google.com/file/d/{$existing_drive_id}/view",
                    'direct_url'     => "https://lh3.googleusercontent.com/d/{$existing_drive_id}",
                    'message'        => 'File Google Drive berhasil di-update.'
                );
            } else {
                $status = 'FAILED';
                $error_msg = $upd['message'];
            }
        } else {
            // Upload file baru ke Drive
            $upl = $this->upload_file($full_local_path, $file_name, $target_folder_id, $mime_type);
            if ($upl['success']) {
                $status = 'SYNCHRONIZED';
                $existing_drive_id = $upl['id'];
                $sync_result = array(
                    'success'        => true,
                    'status'         => 'UPLOADED',
                    'id'             => $existing_drive_id,
                    'drive_file_id'  => $existing_drive_id,
                    'webViewLink'    => $upl['webViewLink'] ?? "https://drive.google.com/file/d/{$existing_drive_id}/view",
                    'webContentLink' => $upl['webContentLink'] ?? '',
                    'direct_url'     => $upl['direct_url'] ?? "https://lh3.googleusercontent.com/d/{$existing_drive_id}",
                    'message'        => 'File baru berhasil diunggah ke Google Drive.'
                );
            } else {
                $status = 'FAILED';
                $error_msg = $upl['message'];
            }
        }

        // Simpan/Update statistik ke tabel google_drive_sync
        $data_db = array(
            'local_path'           => $local_path,
            'relative_path'        => $rel_path,
            'file_name'            => $file_name,
            'file_size'            => $file_size,
            'mime_type'            => $mime_type,
            'drive_file_id'        => $existing_drive_id,
            'drive_folder_id'      => $target_folder_id,
            'file_hash'            => $file_hash,
            'original_file_size'   => $comp_info['original_file_size'],
            'compressed_file_size' => $comp_info['compressed_file_size'],
            'compression_ratio'    => $comp_info['compression_ratio'],
            'is_compressed'        => $comp_info['is_compressed'],
            'compression_quality'  => $comp_info['compression_quality'],
            'status'               => $status,
            'last_synced_at'       => date('Y-m-d H:i:s'),
            'error_message'        => $error_msg
        );


        if ($db_rec) {
            $this->CI->db->where('id', $db_rec['id']);
            $this->CI->db->update('google_drive_sync', $data_db);
        } else {
            $this->CI->db->insert('google_drive_sync', $data_db);
        }




        if ($status === 'FAILED') {
            return array('status' => 'FAILED', 'message' => $error_msg, 'local_path' => $local_path);
        }

        // Auto delete local file after successful Google Drive upload to avoid storing files locally
        if ($status === 'SYNCHRONIZED' && file_exists($full_local_path)) {
            @unlink($full_local_path);
        }

        return $sync_result;
    }

    /**
     * SINKRONISASI RECURSIVE SELURUH FILE DI assets/uploads/ KE GOOGLE DRIVE
     */
    public function sync_all_uploads($force_update = FALSE, $limit = NULL) {
        $uploads_dir = str_replace('\\', '/', realpath(FCPATH . 'assets/uploads'));
        if (!$uploads_dir || !is_dir($uploads_dir)) {
            return array('success' => false, 'message' => 'Direktori assets/uploads tidak ditemukan.');
        }

        // Exclusion file yang diabaikan
        $exclusions = array('.gitignore', '.ds_store', 'thumbs.db', 'index.html');

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($uploads_dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $total_files = 0;
        $total_folders = 0;
        $uploaded_count = 0;
        $updated_count = 0;
        $skipped_count = 0;
        $failed_count = 0;
        $failed_files = array();
        $processed = 0;

        foreach ($iterator as $item) {
            $item_path = str_replace('\\', '/', $item->getRealPath());

            if ($item->isDir()) {
                $total_folders++;
                continue;
            }

            if ($item->isFile()) {
                $file_name = strtolower($item->getFilename());
                if (in_array($file_name, $exclusions)) {
                    continue;
                }

                $total_files++;

                if ($limit && $processed >= $limit) {
                    continue;
                }

                $res = $this->sync_file($item_path, $force_update, FALSE);
                $processed++;

                if (isset($res['status'])) {
                    if ($res['status'] === 'UPLOADED') {
                        $uploaded_count++;
                    } elseif ($res['status'] === 'UPDATED') {
                        $updated_count++;
                    } elseif ($res['status'] === 'SKIPPED') {
                        $skipped_count++;
                    } elseif ($res['status'] === 'FAILED') {
                        $failed_count++;
                        $failed_files[] = array(
                            'path'  => $item_path,
                            'error' => $res['message'] ?? 'Unknown error'
                        );
                    }
                }
            }
        }

        // Update records in DB where drive_file_id exists to SYNCHRONIZED
        $this->CI->db->where('drive_file_id IS NOT NULL')->where('drive_file_id !=', '')->update('google_drive_sync', array('status' => 'SYNCHRONIZED'));
        $missing_local = array();

        return array(
            'success'               => ($failed_count === 0),
            'total_local_files'     => $total_files,
            'total_local_folders'   => $total_folders,
            'uploaded'              => $uploaded_count,
            'updated'               => $updated_count,
            'skipped'               => $skipped_count,
            'failed'                => $failed_count,
            'failed_files'          => $failed_files,
            'missing_local_files'   => $missing_local,
            'timestamp'             => date('Y-m-d H:i:s')
        );
    }

    /**
     * Mengambil laporan statistik status sinkronisasi Google Drive
     */
    public function get_sync_report() {
        $total_in_db  = $this->CI->db->count_all('google_drive_sync');
        $synchronized = $this->CI->db->where('status', 'SYNCHRONIZED')->count_all_results('google_drive_sync');
        $pending      = $this->CI->db->where('status', 'PENDING')->count_all_results('google_drive_sync');
        $failed       = $this->CI->db->where('status', 'FAILED')->count_all_results('google_drive_sync');
        $missing      = $this->CI->db->where('status', 'LOCAL_MISSING')->count_all_results('google_drive_sync');

        $failed_list = $this->CI->db->get_where('google_drive_sync', array('status' => 'FAILED'))->result_array();

        return array(
            'total_records' => $total_in_db,
            'synchronized'  => $synchronized,
            'pending'       => $pending,
            'failed'        => $failed,
            'local_missing' => $missing,
            'failed_details'=> $failed_list
        );
    }

    /**
     * Memverifikasi keberadaan file tersinkronisasi di Google Drive (dengan batasan limit agar respon cepat)
     */
    public function verify_sync($limit = 10) {
        $total_synced = $this->CI->db->where('status', 'SYNCHRONIZED')->count_all_results('google_drive_sync');

        $this->CI->db->where('status', 'SYNCHRONIZED');
        if ($limit !== NULL && $limit > 0) {
            $this->CI->db->limit($limit);
        }
        $synced = $this->CI->db->get('google_drive_sync')->result_array();

        $verified_count = 0;
        $unverified_count = 0;
        $missing_in_drive = array();

        foreach ($synced as $s) {
            if (!empty($s['drive_file_id'])) {
                $gfile = $this->get_file($s['drive_file_id']);
                if ($gfile && !empty($gfile['id'])) {
                    $verified_count++;
                } else {
                    $unverified_count++;
                    $missing_in_drive[] = $s;
                    // Mark as PENDING so it can be re-synced
                    $this->CI->db->where('id', $s['id']);
                    $this->CI->db->update('google_drive_sync', array('status' => 'PENDING', 'error_message' => 'File tidak ditemukan di Google Drive saat verifikasi'));
                }
            }
        }

        return array(
            'total_synced'     => $total_synced,
            'verified'         => $verified_count,
            'unverified'       => $unverified_count,
            'missing_in_drive' => $missing_in_drive
        );
    }



    /**
     * Mendapatkan pesan error terakhir
     */
    public function get_last_error() {
        return $this->last_error;
    }

    /**
     * Helper privat cURL request
     */
    private function http_request($url, $method = 'GET', $data = null, $headers = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        if (defined('CURL_IPRESOLVE_V4')) {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }
        if (defined('CURL_HTTP_VERSION_1_1')) {
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        }


        $method_upper = strtoupper($method);
        if ($method_upper === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        } elseif ($method_upper === 'PATCH' || $method_upper === 'PUT' || $method_upper === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method_upper);
            if ($data !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }


        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return array(
                'success'   => false,
                'http_code' => 0,
                'error'     => $error,
                'body'      => null
            );
        }

        $is_success = ($http_code >= 200 && $http_code < 300);
        return array(
            'success'   => $is_success,
            'http_code' => $http_code,
            'error'     => $is_success ? null : "HTTP Error $http_code",
            'body'      => $response
        );
    }
}
