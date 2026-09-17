<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function load($template = 'layout/main', $view = '', $view_data = array(), $return = FALSE) {
        $user = $this->ci->session->userdata('user_session');
        $active_tp = $this->ci->master_model->get_active_tahun_pelajaran();

        // Prepare merged data for inner content view
        $inner_data = array_merge($view_data, array(
            '_user' => $user,
            'user' => $user,
            '_active_tp' => $active_tp
        ));

        // Render inner content
        $data = $inner_data;
        $data['_content'] = $this->ci->load->view($view, $inner_data, TRUE);

        // Render main template wrapper
        return $this->ci->load->view($template, $data, $return);
    }
}
