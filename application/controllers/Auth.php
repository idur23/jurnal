<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    protected $authService;

    public function __construct() {
        parent::__construct();
        $this->authService = new AuthService();
    }

    public function index() {
        if ($this->auth_lib->is_logged_in()) {
            redirect('dashboard');
        }
        $this->login();
    }

    public function login() {
        if ($this->auth_lib->is_logged_in()) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('identity', 'Username atau Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login System';
            $this->load->view('auth/login', $data);
        } else {
            $identity = $this->input->post('identity', TRUE);
            $password = $this->input->post('password');
            $ip_address = $this->input->ip_address();

            $result = $this->authService->login($identity, $password, $ip_address);

            if ($result['status']) {
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', $result['message']);
                redirect('login');
            }
        }
    }

    public function logout() {
        $this->authService->logout();
        redirect('login');
    }
}
