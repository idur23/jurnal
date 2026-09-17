<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poinkeaktifan extends Guru_Controller {

    protected $poinService;

    public function __construct() {
        parent::__construct();
        $this->poinService = new PoinKeaktifanService();
        $this->load->model('poin_keaktifan_model');
    }

    /**
     * Main Dashboard & Recap Center for Poin Keaktifan Siswa
     */
    public function index() {
        $data['title'] = 'Poin Keaktifan Siswa';
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'guru_id'  => $this->input->get('guru_id', TRUE),
            'siswa_id' => $this->input->get('siswa_id', TRUE),
            'bulan'    => $this->input->get('bulan', TRUE) ? (int)$this->input->get('bulan', TRUE) : (int)date('m'),
            'tahun'    => $this->input->get('tahun', TRUE) ? (int)$this->input->get('tahun', TRUE) : (int)date('Y')
        );

        // Auto filter scope for teacher/wali kelas
        if (in_array($role, array('guru', 'walikelas')) && $guru) {
            $data['list_kelas'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id'] ?? 0);
            $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id'] ?? 0);
        } else {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
        }

        $data['list_guru'] = $this->master_model->get_all_guru();
        $data['list_siswa'] = $this->master_model->get_all_siswa();
        $data['filters'] = $filters;
        $data['active_tp'] = $active_tp;

        // Fetch recent journals for Quick Input Modal
        $this->load->model('jurnal_model');
        $jurnal_filters = array();
        if (in_array($role, array('guru', 'walikelas')) && $guru) {
            $jurnal_filters['guru_id'] = $guru['id'];
        }
        $data['recent_jurnal'] = array_slice($this->jurnal_model->get_jurnal_filtered($jurnal_filters), 0, 15);

        // Load statistics & chart data
        $data['stats'] = $this->poin_keaktifan_model->get_dashboard_stats($filters);
        $data['charts'] = $this->poin_keaktifan_model->get_dashboard_charts($filters);

        // Load recaps
        $data['rekap_bulanan'] = $this->poin_keaktifan_model->get_rekap_bulanan($filters);
        
        if (!empty($filters['kelas_id'])) {
            $data['rekap_kelas'] = $this->poin_keaktifan_model->get_rekap_per_kelas($filters['kelas_id'], $filters);
        } else if (!empty($data['list_kelas'][0]['id'])) {
            $data['rekap_kelas'] = $this->poin_keaktifan_model->get_rekap_per_kelas($data['list_kelas'][0]['id'], $filters);
            $data['selected_kelas_id'] = $data['list_kelas'][0]['id'];
        } else {
            $data['rekap_kelas'] = array();
        }

        if (!empty($filters['siswa_id'])) {
            $data['rekap_siswa'] = $this->poin_keaktifan_model->get_rekap_per_siswa($filters['siswa_id'], $filters);
        } else {
            $data['rekap_siswa'] = null;
        }

        $data['detail_transaksi'] = $this->poin_keaktifan_model->get_detail_transaksi($filters, 100);

        $this->template->load('layout/main', 'poinkeaktifan/index', $data);
    }

    /**
     * Input page for assigning student points per journal
     */
    public function input($jurnal_id = null) {
        if (!$jurnal_id) {
            $this->session->set_flashdata('error', 'Silakan pilih jurnal pembelajaran terlebih dahulu.');
            redirect('jurnal');
            return;
        }

        $res = $this->poinService->get_journal_with_points($jurnal_id, $this->current_user['id'], $this->current_user['role_code']);
        if (!$res['status']) {
            $this->session->set_flashdata('error', $res['message']);
            redirect('jurnal');
            return;
        }

        $data['title'] = 'Input Poin Keaktifan Siswa - ' . $res['jurnal']['kode_jurnal'];
        $data['jurnal'] = $res['jurnal'];
        $data['students'] = $res['students'];

        $this->template->load('layout/main', 'poinkeaktifan/input', $data);
    }

    /**
     * AJAX endpoint to update student points (+1 or -1)
     */
    public function update_poin_ajax() {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $jurnal_id = $this->input->post('jurnal_id', TRUE);
        $siswa_id = $this->input->post('siswa_id', TRUE);
        $action = $this->input->post('action', TRUE);

        if (!$jurnal_id || !$siswa_id || !$action) {
            return json_response(false, 'Parameter tidak lengkap.');
        }

        $res = $this->poinService->adjust_student_point(
            $jurnal_id,
            $siswa_id,
            $action,
            $this->current_user['id'],
            $this->current_user['role_code']
        );

        if ($res['status']) {
            return json_response(true, $res['message'], array(
                'siswa_id' => $res['siswa_id'],
                'new_poin' => $res['new_poin']
            ));
        } else {
            return json_response(false, $res['message']);
        }
    }

    /**
     * Export Excel Recap
     */
    public function export_excel() {
        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'guru_id'  => $this->input->get('guru_id', TRUE),
            'bulan'    => $this->input->get('bulan', TRUE) ? (int)$this->input->get('bulan', TRUE) : (int)date('m'),
            'tahun'    => $this->input->get('tahun', TRUE) ? (int)$this->input->get('tahun', TRUE) : (int)date('Y')
        );

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $this->poinService->generate_excel_rekap($filters, $active_tp);
    }

    /**
     * Printable view for point recap
     */
    public function print_rekap() {
        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'guru_id'  => $this->input->get('guru_id', TRUE),
            'bulan'    => $this->input->get('bulan', TRUE) ? (int)$this->input->get('bulan', TRUE) : (int)date('m'),
            'tahun'    => $this->input->get('tahun', TRUE) ? (int)$this->input->get('tahun', TRUE) : (int)date('Y')
        );

        $data['rekap'] = $this->poin_keaktifan_model->get_rekap_bulanan($filters);
        $data['filters'] = $filters;
        $data['active_tp'] = $this->master_model->get_active_tahun_pelajaran();

        $settings_raw = $this->db->get('system_settings')->result_array();
        $settings_map = array();
        foreach ($settings_raw as $s) {
            $settings_map[$s['setting_key']] = $s['setting_value'];
        }
        $data['settings'] = $settings_map;

        $this->load->view('poinkeaktifan/print_rekap', $data);
    }

    /**
     * PDF Export for point recap
     */
    public function export_pdf() {
        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'guru_id'  => $this->input->get('guru_id', TRUE),
            'bulan'    => $this->input->get('bulan', TRUE) ? (int)$this->input->get('bulan', TRUE) : (int)date('m'),
            'tahun'    => $this->input->get('tahun', TRUE) ? (int)$this->input->get('tahun', TRUE) : (int)date('Y')
        );

        $data['rekap'] = $this->poin_keaktifan_model->get_rekap_bulanan($filters);
        $data['filters'] = $filters;
        $data['active_tp'] = $this->master_model->get_active_tahun_pelajaran();

        $settings_raw = $this->db->get('system_settings')->result_array();
        $settings_map = array();
        foreach ($settings_raw as $s) {
            $settings_map[$s['setting_key']] = $s['setting_value'];
        }
        $data['settings'] = $settings_map;

        $this->load->service('LaporanService');
        $laporanService = new LaporanService();
        $laporanService->render_pdf('poinkeaktifan/pdf_rekap', $data, 'rekap-poin-keaktifan-' . date('Ymd') . '.pdf', 'portrait');
    }
}
