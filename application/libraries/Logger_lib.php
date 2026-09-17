<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger_lib {
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function log($action, $description = '') {
        $user = $this->ci->session->userdata('user_session');
        $user_id = !empty($user['id']) ? $user['id'] : NULL;

        if ($user_id !== NULL) {
            $check = $this->ci->db->select('id')->get_where('users', array('id' => $user_id))->row_array();
            if (!$check) {
                $user_id = NULL;
            }
        }

        $ip_address = $this->ci->input->ip_address();
        $user_agent = substr($this->ci->input->user_agent(), 0, 250);

        $this->ci->db->insert('activity_logs', array(
            'user_id' => $user_id,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'created_at' => date('Y-m-d H:i:s')
        ));
    }
}
