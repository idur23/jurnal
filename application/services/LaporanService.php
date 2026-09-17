<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('jurnal_model');
        $this->CI->load->model('presensikelas_model');
        $this->CI->load->model('penilaian_model');
    }

    /**
     * Generate Jurnal Guru Excel report using memory-efficient queries
     */
    public function generate_jurnal_excel($filters, $active_tp) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN JURNAL KEGIATAN KBM GURU');
        $sheet->setCellValue('A2', 'Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'Tanggal', 'Jam Ke', 'Kelas', 'Mata Pelajaran', 'Guru Pengampu', 'Materi Pembelajaran', 'Catatan KBM', 'Hambatan & Solusi');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '5', $h);
            $sheet->getStyle($col . '5')->getFont()->setBold(true);
            $col++;
        }

        // Fetch data by pagination or chunking if query is massive to prevent out-of-memory
        $limit = 1000;
        $offset = 0;
        $row_index = 6;
        $no = 1;

        while (true) {
            // Retrieve chunks of journals to avoid memory bottlenecks
            $this->CI->db->select('jurnal_guru.tanggal, jurnal_guru.jam_ke, jurnal_guru.materi_pembelajaran, jurnal_guru.catatan_pembelajaran, jurnal_guru.hambatan_solusi, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru');
            $this->CI->db->join('kelas', 'kelas.id = jurnal_guru.kelas_id');
            $this->CI->db->join('mata_pelajaran', 'mata_pelajaran.id = jurnal_guru.mapel_id');
            $this->CI->db->join('guru', 'guru.id = jurnal_guru.guru_id');
            
            if (!empty($filters['kelas_id'])) $this->CI->db->where('jurnal_guru.kelas_id', $filters['kelas_id']);
            if (!empty($filters['mapel_id'])) $this->CI->db->where('jurnal_guru.mapel_id', $filters['mapel_id']);
            if (!empty($filters['guru_id'])) $this->CI->db->where('jurnal_guru.guru_id', $filters['guru_id']);
            if (!empty($filters['tanggal_mulai'])) $this->CI->db->where('jurnal_guru.tanggal >=', $filters['tanggal_mulai']);
            if (!empty($filters['tanggal_selesai'])) $this->CI->db->where('jurnal_guru.tanggal <=', $filters['tanggal_selesai']);
            
            $this->CI->db->limit($limit, $offset);
            $this->CI->db->order_by('jurnal_guru.tanggal', 'DESC');
            $query = $this->CI->db->get('jurnal_guru')->result_array();

            if (empty($query)) {
                break;
            }

            foreach ($query as $j) {
                $sheet->setCellValue('A' . $row_index, $no++);
                $sheet->setCellValue('B' . $row_index, date('d-m-Y', strtotime($j['tanggal'])));
                $sheet->setCellValue('C' . $row_index, $j['jam_ke']);
                $sheet->setCellValue('D' . $row_index, $j['nama_kelas']);
                $sheet->setCellValue('E' . $row_index, $j['nama_mapel']);
                $sheet->setCellValue('F' . $row_index, $j['nama_guru']);
                $sheet->setCellValue('G' . $row_index, $j['materi_pembelajaran']);
                $sheet->setCellValue('H' . $row_index, $j['catatan_pembelajaran'] ? $j['catatan_pembelajaran'] : '-');
                $sheet->setCellValue('I' . $row_index, $j['hambatan_solusi'] ? $j['hambatan_solusi'] : '-');
                $row_index++;
            }

            $offset += $limit;
            if (count($query) < $limit) {
                break;
            }
        }

        foreach (range('A', 'I') as $c_col) {
            $sheet->getColumnDimension($c_col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Jurnal_' . date('Ymd') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    /**
     * Generate PDF using Dompdf helper
     */
    public function render_pdf($view_name, $data, $filename, $orientation = 'portrait') {
        if (!isset($data['settings']) || empty($data['settings']['printed_by']) || empty($data['settings']['headmaster_name'])) {
            $settings_raw = $this->CI->db->get('system_settings')->result_array();
            $settings_map = array();
            foreach ($settings_raw as $s) {
                $settings_map[$s['setting_key']] = $s['setting_value'];
            }

            // Sync Kamad info
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

            // Sync printed_by from live database user
            $user_session = $this->CI->session->userdata('user_session');
            $printed_by = '';
            if (!empty($user_session['id'])) {
                $curr_user = $this->CI->db->select('users.full_name, users.username, guru.nama_lengkap as guru_nama')
                    ->from('users')
                    ->join('guru', 'guru.user_id = users.id', 'left')
                    ->where('users.id', $user_session['id'])
                    ->get()->row_array();

                if (!empty($curr_user)) {
                    $printed_by = !empty($curr_user['guru_nama']) 
                        ? $curr_user['guru_nama'] 
                        : (!empty($curr_user['full_name']) ? $curr_user['full_name'] : $curr_user['username']);
                }
            }

            if (empty($printed_by)) {
                $printed_by = !empty($user_session['full_name']) 
                    ? $user_session['full_name'] 
                    : (!empty($user_session['username']) ? $user_session['username'] : 'Staf Tata Usaha');
            }

            $settings_map['printed_by'] = $printed_by;

            $passed_settings = (isset($data['settings']) && is_array($data['settings'])) ? $data['settings'] : array();
            $data['settings'] = array_merge($settings_map, $passed_settings);
        }

        $html = $this->CI->load->view($view_name, $data, TRUE);
        
        // Ensure Dompdf loads successfully
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => 0));
        exit;
    }
}
