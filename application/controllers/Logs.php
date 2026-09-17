<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Audit Trail & Activity Log';
        $data['logs'] = $this->log_model->get_logs(200);

        $this->template->load('layout/main', 'logs/index', $data);
    }
}
