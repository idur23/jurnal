<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Base_Controller {

    protected $dashboardService;

    public function __construct() {
        parent::__construct();
        $this->dashboardService = new DashboardService();
    }

    public function index() {
        $user = $this->current_user;

        if (isset($user['role_code']) && $user['role_code'] == 'tentor') {
            redirect('tentor');
            return;
        }

        $data['title'] = 'Dashboard Utama';

        // Fetch all metrics and charts dynamically from the service
        $stats = $this->dashboardService->get_dashboard_data($user['role_code'], $user['id']);
        
        $data = array_merge($data, $stats);

        $this->template->load('layout/main', 'dashboard/index', $data);
    }
}
