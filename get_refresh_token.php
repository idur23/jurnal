<?php
/**
 * ====================================================================
 * GOOGLE DRIVE OAUTH 2.0 REFRESH TOKEN GENERATOR (SETUP & DEV TOOL)
 * Website Jurnal Guru Enterprise
 * ====================================================================
 * 
 * Script ini digunakan 1 kali saat setup/pengembangan untuk mendapatkan
 * OAuth 2.0 Refresh Token dari akun Google Anda.
 * 
 * PETUNJUK PENGGUNAAN:
 * 1. Buka Google Cloud Console (https://console.cloud.google.com/)
 * 2. Buat Project & Aktifkan "Google Drive API"
 * 3. Buka menu "OAuth consent screen":
 *    - Isi Data Aplikasi (App Name, User Support Email, Developer Contact).
 *    - ⚠️ SANGAT PENTING: Pada "Publishing status" (Status Publikasi), klik tombol "PUBLISH APP" (Publikasikan Aplikasi) agar statusnya menjadi "In Production" (Produksi).
 *      Jika status masih "Testing", Google secara otomatis menghapus Refresh Token setiap 7 HARI (1 Minggu)!
 * 4. Buka menu "Credentials" -> Create Credentials -> OAuth client ID:
 *    - Application type: Web application
 *    - Authorized redirect URIs: http://localhost/jg/get_refresh_token.php
 *      (atau URL domain server Anda yang sesuai)
 * 5. Masukkan Client ID dan Client Secret ke form di bawah ini.
 */

session_start();

// URL redirect halaman ini
$is_https = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === '1')) 
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
$protocol = $is_https ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script_name = strtok($_SERVER['REQUEST_URI'] ?? '/get_refresh_token.php', '?');
$current_uri = $protocol . '://' . $host . $script_name;

// Hapus session gdrive_setup_redirect_uri jika berisi domain .test dari percobaan sebelumnya
if (isset($_SESSION['gdrive_setup_redirect_uri']) && (strpos($_SESSION['gdrive_setup_redirect_uri'], '.test') !== false || strpos($_SESSION['gdrive_setup_redirect_uri'], '.local') !== false)) {
    unset($_SESSION['gdrive_setup_redirect_uri']);
}

// Google OAuth 2.0 melarang HTTP untuk domain lokal (.test). Untuk domain produksi (seperti jurnal.masdafindo.com) gunakan HTTPS/HTTP domain tersebut.
$localhost_uri = 'http://localhost/jg/get_refresh_token.php';
$is_local_test = (strpos($host, '.test') !== false || strpos($host, '.local') !== false);
$redirect_uri = $_SESSION['gdrive_setup_redirect_uri'] ?? ($is_local_test ? $localhost_uri : $current_uri);

$error_msg = '';
$success_data = null;

// Standard Google OAuth Endpoints
$auth_url_endpoint = 'https://accounts.google.com/o/oauth2/v2/auth';
$token_url_endpoint = 'https://oauth2.googleapis.com/token';

// Handle Step 2: Callback Code Exchange
if (isset($_GET['code'])) {
    $code = trim($_GET['code']);
    $client_id = $_SESSION['gdrive_setup_client_id'] ?? '';
    $client_secret = $_SESSION['gdrive_setup_client_secret'] ?? '';
    $redirect_uri = $_SESSION['gdrive_setup_redirect_uri'] ?? $redirect_uri;

    if (empty($client_id) || empty($client_secret)) {
        $error_msg = 'Session Client ID/Secret hilang. Silakan masukkan ulang Form Client ID & Client Secret.';
    } else {
        // Exchange authorization code for refresh_token via cURL
        $post_fields = [
            'code'          => $code,
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri'  => $redirect_uri,
            'grant_type'    => 'authorization_code',
        ];

        $ch = curl_init($token_url_endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode($response, true);

        if ($http_code === 200 && !empty($json['refresh_token'])) {
            $success_data = [
                'refresh_token' => $json['refresh_token'],
                'access_token'  => $json['access_token'] ?? '',
                'expires_in'    => $json['expires_in'] ?? 3600,
                'client_id'     => $client_id,
                'client_secret' => $client_secret
            ];

            // Automatically update google_drive_credentials.json if writable
            $cred_file = __DIR__ . '/application/config/google_drive_credentials.json';
            $existing_folder_id = '';
            $existing_drive_id = '';
            if (file_exists($cred_file)) {
                $raw_existing = @file_get_contents($cred_file);
                $json_existing = json_decode($raw_existing, true);
                if (isset($json_existing['web']['folder_id'])) {
                    $existing_folder_id = $json_existing['web']['folder_id'];
                }
                if (isset($json_existing['web']['drive_id'])) {
                    $existing_drive_id = $json_existing['web']['drive_id'];
                }
            }
            if (is_writable(dirname($cred_file))) {
                $save_json = [
                    'web' => [
                        'client_id'     => $client_id,
                        'client_secret' => $client_secret,
                        'refresh_token' => $json['refresh_token'],
                        'folder_id'     => $existing_folder_id,
                        'drive_id'      => $existing_drive_id
                    ]
                ];
                file_put_contents($cred_file, json_encode($save_json, JSON_PRETTY_PRINT));
            }

        } else {
            $error_detail = $json['error_description'] ?? $json['error'] ?? $response;
            $error_msg = "Gagal menukar OAuth Code dengan Refresh Token (HTTP $http_code): $error_detail";
        }
    }
}

// Handle Step 1: Redirect User to Google OAuth Consent Page
if (isset($_POST['action']) && $_POST['action'] === 'authorize') {
    $client_id     = trim($_POST['client_id'] ?? '');
    $client_secret = trim($_POST['client_secret'] ?? '');
    $custom_redirect_uri = trim($_POST['redirect_uri'] ?? '');
    if (!empty($custom_redirect_uri)) {
        $redirect_uri = $custom_redirect_uri;
    }

    if (empty($client_id) || empty($client_secret)) {
        $error_msg = 'Client ID dan Client Secret wajib diisi!';
    } else {
        $_SESSION['gdrive_setup_client_id']     = $client_id;
        $_SESSION['gdrive_setup_client_secret'] = $client_secret;
        $_SESSION['gdrive_setup_redirect_uri']  = $redirect_uri;

        $params = [
            'client_id'       => $client_id,
            'redirect_uri'    => $redirect_uri,
            'response_type'   => 'code',
            'scope'           => 'https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive',
            'access_type'     => 'offline',
            'prompt'          => 'consent'
        ];

        $google_auth_url = $auth_url_endpoint . '?' . http_build_query($params);
        header('Location: ' . $google_auth_url);
        exit;
    }
}


// Auto load existing config from application/config/google_drive.php or fallback from google_drive_credentials.json
$default_client_id = '';
$default_client_secret = '';
$cfg_file = __DIR__ . '/application/config/google_drive.php';
if (file_exists($cfg_file)) {
    if (!defined('BASEPATH')) define('BASEPATH', '1');
    if (!defined('APPPATH')) define('APPPATH', __DIR__ . '/application/');
    @include $cfg_file;
    if (isset($config)) {
        $default_client_id = $config['google_drive_client_id'] ?? '';
        $default_client_secret = $config['google_drive_client_secret'] ?? '';
    }
}

if (empty($default_client_id)) {
    $cred_file = __DIR__ . '/application/config/google_drive_credentials.json';
    if (file_exists($cred_file)) {
        $raw_cred = @file_get_contents($cred_file);
        $json_cred = json_decode($raw_cred, true);
        if (isset($json_cred['web'])) {
            $default_client_id = $json_cred['web']['client_id'] ?? '';
            $default_client_secret = $json_cred['web']['client_secret'] ?? '';
        }
    }
}

$input_client_id = $_SESSION['gdrive_setup_client_id'] ?? $default_client_id;
$input_client_secret = $_SESSION['gdrive_setup_client_secret'] ?? $default_client_secret;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Drive OAuth 2.0 Setup — Jurnal Guru</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; padding-top: 40px; padding-bottom: 60px; }
        .card { border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .token-box { background: #1e293b; color: #38bdf8; font-family: monospace; padding: 15px; border-radius: 8px; word-break: break-all; }
    </style>
</head>
<body>
<div class="container" style="max-width: 720px;">
    <div class="card p-4">
        <h3 class="fw-bold text-primary mb-1">🔑 Google Drive OAuth 2.0 Setup Tool</h3>
        <p class="text-muted small">Alat bantu konfigurasi Refresh Token Google Drive API v3 untuk Jurnal Guru Enterprise.</p>
        
        <div class="alert alert-warning border-start border-warning border-4 shadow-sm mb-3">
            <h6 class="fw-bold text-dark mb-1">💡 Tips Agar Refresh Token Permanen (Tidak Expire Tiap 7 Hari):</h6>
            <p class="mb-0 small text-secondary">
                Secara <i>default</i>, Google membatasi Refresh Token aplikasi berstatus <b>Testing (Pengujian)</b> agar kedaluwarsa otomatis setelah <b>7 hari (1 minggu)</b>.<br>
                <b>Solusi:</b> Buka <a href="https://console.cloud.google.com/apis/credentials/consent" target="_blank" class="fw-bold text-primary">Google Cloud Console → OAuth consent screen</a>, lalu pada <b>Publishing status</b> klik tombol <b>"PUBLISH APP"</b> (Publikasikan Aplikasi) menjadi <b>In Production</b>. Setelah itu, buat Refresh Token baru di halaman ini.
            </p>
        </div>

        <div class="alert alert-info border-start border-info border-4 shadow-sm mb-3">
            <h6 class="fw-bold text-dark mb-1">🛠️ Panduan Mengatasi Error OAuth Google:</h6>
            <ul class="mb-0 small text-secondary ps-3">
                <li><b>Error 401: invalid_client (The OAuth client was not found):</b> Client ID yang dimasukkan salah, terhapus, atau tidak cocok di Google Cloud Console. Salin ulang <b>Client ID</b> & <b>Client Secret</b> yang aktif dari Google Cloud Console.</li>
                <li><b>Gunakan URL Localhost:</b> Google OAuth melarang HTTP pada domain selain <code>localhost</code> (misal: <code>http://jg.test</code>). Gunakan <a href="http://localhost/jg/get_refresh_token.php" class="fw-bold text-primary">http://localhost/jg/get_refresh_token.php</a>.</li>
                <li><b>Authorized Redirect URIs:</b> Pastikan <code>http://localhost/jg/get_refresh_token.php</code> (atau domain live Anda) sudah didaftarkan di <a href="https://console.cloud.google.com/apis/credentials" target="_blank" class="fw-bold text-primary">Google Cloud Console → Credentials → Web application → Authorized redirect URIs</a>.</li>
            </ul>
        </div>
        <hr>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger font-weight-bold">
                ⚠️ <strong>Error:</strong> <?= htmlspecialchars($error_msg) ?>
            </div>
        <?php endif; ?>

        <?php if ($success_data): ?>
            <div class="alert alert-success">
                🎉 <strong>BERHASIL DITERIMA!</strong> Refresh Token Google Drive OAuth 2.0 berhasil dibuat.
            </div>

            <h5 class="fw-bold text-dark mt-3">1. Refresh Token Anda:</h5>
            <div class="token-box mb-3">
                <?= htmlspecialchars($success_data['refresh_token']) ?>
            </div>

            <h5 class="fw-bold text-dark mt-3">2. Langkah Konfigurasi Selanjutnya:</h5>
            <ol class="small text-secondary">
                <li>Buka file <code class="bg-light text-danger px-1">application/config/google_drive.php</code> di editor Anda.</li>
                <li>Isikan data konfigurasi berikut:
                    <pre class="bg-dark text-white p-3 rounded mt-2">
$config['google_drive_client_id']     = '<?= htmlspecialchars($success_data['client_id']) ?>';
$config['google_drive_client_secret'] = '<?= htmlspecialchars($success_data['client_secret']) ?>';
$config['google_drive_refresh_token'] = '<?= htmlspecialchars($success_data['refresh_token']) ?>';
$config['google_drive_folder_id']    = 'MASUKKAN_FOLDER_ID_ANDA_DISINI';
</pre>
                </li>
                <li>Folder ID dapat diambil dari URL folder Google Drive Anda.<br>
                    Contoh: <code>drive.google.com/drive/folders/<strong>1ABC123xyz...</strong></code> → Folder ID adalah <code>1ABC123xyz...</code>
                </li>
                <li>Setelah selesai, <strong>amankan atau hapus akses publik</strong> ke file <code>get_refresh_token.php</code> ini untuk alasan keamanan server production.</li>
            </ol>

            <a href="get_refresh_token.php" class="btn btn-outline-secondary mt-3">← Buat Ulang / OAuth Akun Lain</a>

        <?php else: ?>

            <form action="get_refresh_token.php" method="POST">
                <input type="hidden" name="action" value="authorize">

                <div class="mb-3">
                    <label class="form-label fw-bold">Authorized Redirect URI (Sesuaikan dengan Google Cloud Console):</label>
                    <input type="text" name="redirect_uri" class="form-control" value="<?= htmlspecialchars($_SESSION['gdrive_setup_redirect_uri'] ?? $redirect_uri) ?>" required>
                    <div class="form-text text-danger font-weight-bold">
                        ⚠️ Pastikan URL di atas SAMA PERSIS dengan URL yang didaftarkan di <strong>Google Cloud Console → Credentials → Client ID → Authorized redirect URIs</strong>.
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Google Client ID:</label>
                    <input type="text" name="client_id" class="form-control" placeholder="123456789-xxx.apps.googleusercontent.com" required value="<?= htmlspecialchars($input_client_id) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Google Client Secret:</label>
                    <input type="password" name="client_secret" class="form-control" placeholder="GOCSPX-xxxxxxxxxxxxxx" required value="<?= htmlspecialchars($input_client_secret) ?>">
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                        🚀 Lanjutkan Otorisasi Oauth 2.0 dengan Akun Google
                    </button>
                </div>
            </form>

        <?php endif; ?>
    </div>
</div>
</body>
</html>
