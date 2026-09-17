<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'services/BaseService.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MbfService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('mbf_model');
        $this->CI->load->model('master_model');
    }

    /**
     * Get system settings for report headers & signers
     */
    public function get_report_settings() {
        $settings_raw = $this->CI->db->get('system_settings')->result_array();
        $settings_map = array();
        foreach ($settings_raw as $s) {
            $settings_map[$s['setting_key']] = $s['setting_value'];
        }

        // Fetch Kamad info from DB for synchronization if not explicitly set
        $kamad = $this->CI->db->select('guru.nama_lengkap, guru.nip, users.full_name')
            ->from('users')
            ->join('roles', 'roles.id = users.role_id')
            ->join('guru', 'guru.user_id = users.id', 'left')
            ->where('roles.role_code', 'kamad')
            ->get()->row_array();

        if (!empty($kamad)) {
            $settings_map['headmaster_name'] = (!empty($settings_map['report_signer_name']) && $settings_map['report_signer_name'] !== '')
                ? $settings_map['report_signer_name'] 
                : (!empty($kamad['nama_lengkap']) ? $kamad['nama_lengkap'] : $kamad['full_name']);
            
            $settings_map['headmaster_nip'] = (!empty($settings_map['report_signer_nip']) && $settings_map['report_signer_nip'] !== '')
                ? $settings_map['report_signer_nip'] 
                : (!empty($kamad['nip']) ? $kamad['nip'] : '001');
        } else {
            $settings_map['headmaster_name'] = !empty($settings_map['report_signer_name']) ? $settings_map['report_signer_name'] : 'M. Fakhrur Rozi, M.Pd';
            $settings_map['headmaster_nip'] = !empty($settings_map['report_signer_nip']) ? $settings_map['report_signer_nip'] : '001';
        }

        // Set printed_by from current logged-in user
        $user_session = $this->CI->session->userdata('user_session');
        $printed_by = '';
        if (!empty($user_session['id'])) {
            $curr_user = $this->CI->db->select('users.full_name, users.username, tentor.nama_lengkap as tentor_nama, guru.nama_lengkap as guru_nama')
                ->from('users')
                ->join('tentor', 'tentor.user_id = users.id', 'left')
                ->join('guru', 'guru.user_id = users.id', 'left')
                ->where('users.id', $user_session['id'])
                ->get()->row_array();

            if (!empty($curr_user)) {
                $printed_by = !empty($curr_user['tentor_nama'])
                    ? $curr_user['tentor_nama']
                    : (!empty($curr_user['guru_nama']) ? $curr_user['guru_nama'] : (!empty($curr_user['full_name']) ? $curr_user['full_name'] : $curr_user['username']));
            }
        }

        if (empty($printed_by)) {
            $printed_by = !empty($user_session['full_name']) 
                ? $user_session['full_name'] 
                : (!empty($user_session['username']) ? $user_session['username'] : 'Administrator MBF');
        }

        $settings_map['printed_by'] = $printed_by;
        return $settings_map;
    }

    /**
     * Render PDF view using Dompdf
     */
    public function render_pdf($view_name, $data, $filename, $orientation = 'portrait') {
        if (!isset($data['settings'])) {
            $data['settings'] = $this->get_report_settings();
        }

        $html = $this->CI->load->view($view_name, $data, TRUE);
        
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => 0));
        exit;
    }

    /**
     * Export MBF Rekap to Excel (PhpSpreadsheet)
     */
    public function generate_rekap_excel($mapel_mbf_id, $filters, $active_tp) {
        $mapel = $this->CI->mbf_model->get_mapel_by_id($mapel_mbf_id);
        if (!$mapel) {
            show_error('Mapel MBF tidak ditemukan.', 404);
            return;
        }

        $rekap = $this->CI->mbf_model->get_rekap_per_mapel($mapel_mbf_id, $filters);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN REKAPITULASI PRESENSI MBF');
        $sheet->setCellValue('A2', 'Mapel MBF: ' . $mapel['nama_mapel'] . ' (' . $mapel['kode_mapel'] . ') | Tentor: ' . $mapel['nama_tentor']);
        $sheet->setCellValue('A3', 'Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');
        $sheet->setCellValue('A4', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'NIS', 'Nama Siswa', 'Kelas', 'Hadir', 'Izin', 'Sakit', 'Alpa', 'Total Pertemuan', 'Persentase Kehadiran');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '6', $h);
            $sheet->getStyle($col . '6')->getFont()->setBold(true);
            $col++;
        }

        $row_index = 7;
        $no = 1;
        foreach ($rekap as $r) {
            $s = $r['siswa'];
            $sheet->setCellValue('A' . $row_index, $no++);
            $sheet->setCellValueExplicit('B' . $row_index, $s['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row_index, $s['nama_lengkap']);
            $sheet->setCellValue('D' . $row_index, $s['nama_kelas']);
            $sheet->setCellValue('E' . $row_index, $r['Hadir']);
            $sheet->setCellValue('F' . $row_index, $r['Izin']);
            $sheet->setCellValue('G' . $row_index, $r['Sakit']);
            $sheet->setCellValue('H' . $row_index, $r['Alpa']);
            $sheet->setCellValue('I' . $row_index, $r['total']);
            $sheet->setCellValue('J' . $row_index, $r['persentase'] . '%');
            $row_index++;
        }

        foreach (range('A', 'J') as $c_col) {
            $sheet->getColumnDimension($c_col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Rekap_MBF_' . str_replace(' ', '_', $mapel['nama_mapel']) . '_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
