<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$script_name = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';

$is_https = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === '1')) ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') ||
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

$root = ($is_https ? "https" : "http") . "://" . $http_host;
$root .= str_replace(basename($script_name), "", $script_name);

$config['base_url'] = $root;
$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = TRUE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 1;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;

$config['encryption_key'] = 'JurnalGuruEnterpriseSecuredKey2026!#$';

$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'jg_session';
$config['sess_expiration'] = 86400;

// Dynamic Session Save Path for Hosting Safety
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 86400;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= TRUE;
$config['standardize_newlines'] = FALSE;

$config['global_xss_filtering'] = TRUE;

$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_token';
$config['csrf_cookie_name'] = 'csrf_cookie';
$config['csrf_expire'] = 86400;
$config['csrf_regenerate'] = FALSE;
$config['csrf_exclude_uris'] = array(
    'google_drive_sync/process_sync_all',
    'google_drive_sync/process_verify',
    'google_drive_sync/retry_failed',
    'google_drive_sync/process_compress_existing'
);



$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';

/*
|--------------------------------------------------------------------------
| Custom Service Autoloader
|--------------------------------------------------------------------------
*/
spl_autoload_register(function ($class) {
    if (strpos($class, 'Service') !== false) {
        $baseFile = APPPATH . 'services/BaseService.php';
        if (file_exists($baseFile) && !class_exists('BaseService')) {
            require_once $baseFile;
        }
        $file = APPPATH . 'services/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

