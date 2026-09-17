<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_lib {
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function is_logged_in() {
        $user = $this->ci->session->userdata('user_session');
        return (!empty($user) && isset($user['id']));
    }

    public function get_user() {
        return $this->ci->session->userdata('user_session');
    }

    public function get_role() {
        $user = $this->get_user();
        return isset($user['role_code']) ? $user['role_code'] : null;
    }

    public function check_access($allowed_roles = array()) {
        if (!$this->is_logged_in()) {
            log_message('error', 'Auth_lib check_access redirecting to login. URI: ' . $this->ci->uri->uri_string() . ' - Session ID: ' . session_id());
            redirect('login');
            exit;
        }

        // Security check: teacher active/inactive enforcement
        $session_user = $this->get_user();
        if (!empty($session_user['id'])) {
            $user_id = (int)$session_user['id'];
            $db_user = $this->ci->db->query("SELECT id, is_active FROM users WHERE id = ?", array($user_id))->row_array();
            if ($db_user && isset($db_user['is_active']) && (int)$db_user['is_active'] === 0) {
                $this->ci->session->unset_userdata('user_session');
                $this->ci->session->sess_destroy();
                $this->ci->session->set_flashdata('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi Administrator.');
                redirect('login');
                exit;
            }
        }

        if (!empty($allowed_roles)) {
            $user_role = $this->get_role();
            if (!in_array($user_role, $allowed_roles)) {
                show_error('Akses ditolak: Anda tidak memiliki wewenang untuk mengakses halaman ini.', 403, '403 Forbidden');
                exit;
            }
        }
    }

    public function check_attempt_limit($ip, $username) {
        $time_window = time() - 900; // 15 minutes
        $this->ci->db->where('ip_address', $ip);
        $this->ci->db->where('username', $username);
        $this->ci->db->where('attempt_time >=', $time_window);
        $attempts = $this->ci->db->count_all_results('login_attempts');

        return ($attempts >= 5); // Max 5 attempts
    }

    public function record_login_attempt($ip, $username) {
        $this->ci->db->insert('login_attempts', array(
            'ip_address' => $ip,
            'username' => $username,
            'attempt_time' => time()
        ));
    }

    public function clear_login_attempts($ip, $username) {
        $this->ci->db->where('ip_address', $ip);
        $this->ci->db->where('username', $username);
        $this->ci->db->delete('login_attempts');
    }
}
