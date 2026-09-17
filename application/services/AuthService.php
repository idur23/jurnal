<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('user_model');
    }

    public function login($identity, $password, $ip_address) {
        // Rate limiting check
        if ($this->CI->auth_lib->check_attempt_limit($ip_address, $identity)) {
            return array(
                'status' => false,
                'message' => 'Terlalu banyak percobaan login gagal. Akun dikunci sementara 15 menit.'
            );
        }

        $user = $this->CI->user_model->get_user_by_identity($identity);

        if ($user && $user['is_active'] == 1) {
            if (password_verify($password, $user['password'])) {
                // Clear attempts
                $this->CI->auth_lib->clear_login_attempts($ip_address, $identity);

                // Update last login
                $this->CI->user_model->update($user['id'], array('last_login' => date('Y-m-d H:i:s')));

                // Map Session data
                $session_data = array(
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role_id' => $user['role_id'],
                    'role_code' => $user['role_code'],
                    'role_name' => $user['role_name']
                );
                
                // Set session
                $this->CI->session->set_userdata('user_session', $session_data);

                // Log Activity
                $this->CI->logger_lib->log('LOGIN_SUCCESS', 'User ' . $user['username'] . ' (' . $user['role_name'] . ') berhasil login.');

                return array('status' => true, 'user' => $user);
            }
        }

        // Failed Login
        $this->CI->auth_lib->record_login_attempt($ip_address, $identity);
        $this->CI->logger_lib->log('LOGIN_FAILED', 'Percobaan login gagal untuk identity: ' . $identity);

        return array(
            'status' => false,
            'message' => 'Username/Email atau Password salah!'
        );
    }

    public function logout() {
        if ($this->CI->auth_lib->is_logged_in()) {
            $user = $this->CI->auth_lib->get_user();
            $this->CI->logger_lib->log('LOGOUT', 'User ' . $user['username'] . ' logout.');
        }
        $this->CI->session->unset_userdata('user_session');
        $this->CI->session->sess_destroy();
    }
}
