<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Presensi extends Base_Controller {

    protected $presensiService;

    public function __construct() {
        parent::__construct();
        $this->presensiService = new PresensiService();
    }

    public function index() {
        $data['title'] = 'Presensi Kehadiran Siswa';
        $role = $this->current_user['role_code'];
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'tanggal_mulai' => $this->input->get('tanggal_mulai', TRUE),
            'tanggal_selesai' => $this->input->get('tanggal_selesai', TRUE),
            'tahun_pelajaran_id' => $active_tp['id']
        );

        if (in_array($role, array('guru', 'walikelas', 'waka'))) {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            if ($guru) {
                $filters['guru_id'] = $guru['id'];
                $data['list_kelas'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id']);
                $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
            } else {
                $data['list_kelas'] = $this->master_model->get_all_kelas();
                $data['list_mapel'] = $this->master_model->get_all_mapel();
            }
        } else {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
        }

        $sessions = $this->presensiService->get_presensi_kelas_list($filters);
        
        // Enrich counts
        foreach ($sessions as &$s) {
            $this->db->select('status, COUNT(*) as count');
            $this->db->where('presensi_kelas_id', $s['id']);
            $this->db->group_by('status');
            $counts = $this->db->get('presensi_siswa')->result_array();
            
            $s['hadir_count'] = 0;
            $s['sakit_count'] = 0;
            $s['izin_count'] = 0;
            $s['alpa_count'] = 0;
            $s['terlambat_count'] = 0;
            $s['dispen_count'] = 0;
            $s['total_count'] = 0;

            foreach ($counts as $c) {
                $status = strtolower($c['status']);
                if ($status == 'hadir') $s['hadir_count'] = (int)$c['count'];
                elseif ($status == 'sakit') $s['sakit_count'] = (int)$c['count'];
                elseif ($status == 'izin') $s['izin_count'] = (int)$c['count'];
                elseif ($status == 'alpa' || $status == 'alpha') $s['alpa_count'] = (int)$c['count'];
                elseif ($status == 'terlambat') $s['terlambat_count'] = (int)$c['count'];
                elseif ($status == 'dispen') $s['dispen_count'] = (int)$c['count'];
                
                $s['total_count'] += (int)$c['count'];
            }
        }

        $data['list_sessions'] = $sessions;
        $data['filters'] = $filters;

        $this->template->load('layout/main', 'presensi/index', $data);
    }

    public function input($presensi_kelas_id) {
        $presensi_kelas_id = (int)$presensi_kelas_id;
        $pk = $this->presensiService->get_presensi_kelas_detail($presensi_kelas_id);
        if (!$pk) {
            $this->session->set_flashdata('error', 'Sesi Presensi Kelas tidak ditemukan.');
            redirect('presensi');
            return;
        }

        if ($pk['status_pembelajaran'] == 'Tidak Terlaksana') {
            $this->session->set_flashdata('warning', 'Pembelajaran berstatus Tidak Terlaksana. Tidak diperlukan absensi siswa.');
            redirect('presensikelas');
            return;
        }

        if ($this->input->post()) {
            $attendance_post = array();
            $presensi_input = $this->input->post('presensi', TRUE);
            $catatan_input = $this->input->post('catatan', TRUE);
            
            // Get existing files
            $existing_presensi = $this->presensi_model->get_presensi_by_kelas_presensi($presensi_kelas_id);
            $existing_files = array_column($existing_presensi, 'bukti_izin', 'siswa_id');

            if (!empty($presensi_input) && is_array($presensi_input)) {
                foreach ($presensi_input as $siswa_id => $status) {
                    $attendance_post[$siswa_id] = array(
                        'status' => $status,
                        'catatan' => isset($catatan_input[$siswa_id]) ? $catatan_input[$siswa_id] : NULL,
                        'existing_bukti' => isset($existing_files[$siswa_id]) ? $existing_files[$siswa_id] : NULL
                    );
                }
            }

            $result = $this->presensiService->save_presensi_siswa($presensi_kelas_id, $attendance_post);

            if ($result['status']) {
                $this->session->set_flashdata('success', 'Kehadiran siswa berhasil disimpan.');
                redirect('presensi');
                return;
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
        }

        $data['title'] = 'Input Kehadiran Siswa';
        $data['pk'] = $pk;
        $data['siswa'] = $this->master_model->get_siswa_by_kelas($pk['kelas_id']);
        $data['list_siswa'] = $data['siswa'];
        
        $existing = $this->presensi_model->get_presensi_by_kelas_presensi($presensi_kelas_id);
        $existing_map = array();
        foreach ($existing as $e) {
            $existing_map[$e['siswa_id']] = $e;
        }
        $data['existing'] = $existing_map;
        $data['existing_presensi'] = $existing_map;

        $this->template->load('layout/main', 'presensi/input', $data);
    }

    public function rekap() {
        $data['title'] = 'Rekap Kehadiran Siswa';
        $role = $this->current_user['role_code'];
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $selected_kelas_id = $this->input->get('kelas_id', TRUE);
        $selected_bulan = $this->input->get('bulan', TRUE) ? $this->input->get('bulan', TRUE) : date('m');
        $selected_tahun = $this->input->get('tahun', TRUE) ? $this->input->get('tahun', TRUE) : date('Y');

        if (in_array($role, array('guru', 'walikelas', 'waka'))) {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            if ($guru) {
                $data['list_kelas'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id']);
            } else {
                $data['list_kelas'] = $this->master_model->get_all_kelas();
            }
        } else {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
        }

        if ($selected_kelas_id) {
            $data['rekap_presensi'] = $this->presensi_model->get_rekap_kelas($selected_kelas_id, $selected_bulan, $selected_tahun);
        } else {
            $data['rekap_presensi'] = array();
        }

        $data['selected_kelas_id'] = $selected_kelas_id;
        $data['selected_bulan'] = $selected_bulan;
        $data['selected_tahun'] = $selected_tahun;

        $this->template->load('layout/main', 'presensi/rekap', $data);
    }

    public function print_rekap() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $selected_bulan = $this->input->get('bulan', TRUE) ? $this->input->get('bulan', TRUE) : date('m');
        $selected_tahun = $this->input->get('tahun', TRUE) ? $this->input->get('tahun', TRUE) : date('Y');

        $kelas = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
        if (!$kelas) {
            show_404();
        }

        $settings_raw = $this->db->get('system_settings')->result_array();
        $settings_map = array();
        foreach ($settings_raw as $s) {
            $settings_map[$s['setting_key']] = $s['setting_value'];
        }
        $data['settings'] = $settings_map;

        $data['kelas'] = $kelas;
        $data['selected_bulan'] = $selected_bulan;
        $data['selected_tahun'] = $selected_tahun;
        $data['rekap_presensi'] = $this->presensi_model->get_rekap_kelas($kelas_id, $selected_bulan, $selected_tahun);

        $this->load->view('presensi/print_rekap', $data);
    }

    public function export_excel() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $selected_bulan = $this->input->get('bulan', TRUE) ? $this->input->get('bulan', TRUE) : date('m');
        $selected_tahun = $this->input->get('tahun', TRUE) ? $this->input->get('tahun', TRUE) : date('Y');

        $kelas = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
        if (!$kelas) {
            show_404();
        }

        $rekap_presensi = $this->presensi_model->get_rekap_kelas($kelas_id, $selected_bulan, $selected_tahun);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'REKAPITULASI PRESENSI BULANAN SISWA');
        $sheet->setCellValue('A2', 'Kelas: ' . ($kelas['nama_kelas'] ?? '') . ' | Periode: ' . date('F', mktime(0, 0, 0, $selected_bulan, 10)) . ' ' . $selected_tahun);
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'NIS', 'Nama Siswa', 'Hadir', 'Sakit', 'Izin', 'Alpa', 'Terlambat', 'Dispen', 'Persentase Kehadiran');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '5', $h);
            $sheet->getStyle($col . '5')->getFont()->setBold(true);
            $col++;
        }

        $row_index = 6;
        $no = 1;
        foreach ($rekap_presensi as $r) {
            $total = $r['hadir'] + $r['izin'] + $r['sakit'] + $r['alpa'] + $r['terlambat'] + $r['dispen'];
            $percent = ($total > 0) ? round(($r['hadir'] / $total) * 100, 1) . '%' : '0%';

            $sheet->setCellValue('A' . $row_index, $no++);
            $sheet->setCellValueExplicit('B' . $row_index, $r['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row_index, $r['nama_lengkap']);
            $sheet->setCellValue('D' . $row_index, $r['hadir']);
            $sheet->setCellValue('E' . $row_index, $r['sakit']);
            $sheet->setCellValue('F' . $row_index, $r['izin']);
            $sheet->setCellValue('G' . $row_index, $r['alpa']);
            $sheet->setCellValue('H' . $row_index, $r['terlambat']);
            $sheet->setCellValue('I' . $row_index, $r['dispen']);
            $sheet->setCellValue('J' . $row_index, $percent);
            $row_index++;
        }

        foreach (range('A', 'J') as $c_col) {
            $sheet->getColumnDimension($c_col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Rekap_Presensi_Bulanan_' . str_replace(' ', '_', $kelas['nama_kelas'] ?? 'Kelas') . '_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }
}
