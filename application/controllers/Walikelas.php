<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Walikelas extends Wali_Controller {

    protected $waliKelasService;
    protected $penangananService;

    public function __construct() {
        parent::__construct();
        $this->waliKelasService = new WaliKelasService();
        $this->penangananService = new PenangananService();
        $this->load->model('walikelas_model');
    }

    private function get_wali_kelas_or_redirect($user_id) {
        $role = $this->current_user['role_code'];
        
        if (in_array($role, array('admin', 'superadmin'))) {
            $kelas_id = $this->input->get('kelas_id', TRUE);
            if (!$kelas_id) {
                $kelas_id = $this->session->userdata('selected_wali_kelas_id');
            }
            
            $list_kelas = $this->master_model->get_all_kelas();
            if (empty($list_kelas)) {
                $this->session->set_flashdata('error', 'Belum ada data kelas di sistem.');
                redirect('dashboard');
                return null;
            }
            
            if (!$kelas_id) {
                $kelas_id = $list_kelas[0]['id'];
            }
            
            $this->session->set_userdata('selected_wali_kelas_id', $kelas_id);
            
            $selected_kelas = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
            if (!$selected_kelas) {
                $kelas_id = $list_kelas[0]['id'];
                $this->session->set_userdata('selected_wali_kelas_id', $kelas_id);
                $selected_kelas = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
            }

            $guru = $selected_kelas['wali_kelas_id'] ? $this->db->get_where('guru', array('id' => $selected_kelas['wali_kelas_id']))->row_array() : NULL;
            
            $wali_kelas = array(
                'id' => $selected_kelas['id'],
                'nama_kelas' => $selected_kelas['nama_kelas'],
                'kode_kelas' => $selected_kelas['kode_kelas'],
                'tingkat' => $selected_kelas['tingkat'],
                'guru_id' => $selected_kelas['wali_kelas_id'] ? $selected_kelas['wali_kelas_id'] : 1,
                'nama_wali' => $guru ? $guru['nama_lengkap'] : 'Administrator',
                'is_admin_mode' => TRUE,
                'list_kelas_all' => $list_kelas
            );
            return $wali_kelas;
        } else {
            $wali_kelas = $this->master_model->get_kelas_by_wali_user_id($user_id);
            if (!$wali_kelas) {
                $this->session->set_flashdata('error', 'Akses dibatasi: Anda bukan merupakan wali kelas aktif pada tahun pelajaran ini.');
                redirect('dashboard');
                return null;
            }
            $wali_kelas['is_admin_mode'] = FALSE;
            $wali_kelas['list_kelas_all'] = array($wali_kelas);
            return $wali_kelas;
        }
    }

    public function index() {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $data['title'] = 'Dashboard Wali Kelas';
        $data['kelas'] = $wali_kelas;
        $data['active_tp'] = $active_tp;

        // Statistics
        $data['total_siswa'] = $this->db->where('kelas_id', $wali_kelas['id'])->where('status_aktif', 1)->count_all_results('siswa');
        
        // Jurnal/Program Kelas Realization Progress
        $programs = $this->walikelas_model->get_program_kelas($wali_kelas['id'], $active_tp['id']);
        $total_programs = count($programs);
        $done_programs = 0;
        foreach ($programs as $p) {
            if ($p['status'] == 'Terealisasi') $done_programs++;
        }
        $data['total_program'] = $total_programs;
        $data['done_program'] = $done_programs;
        $data['percent_program'] = $total_programs > 0 ? round(($done_programs / $total_programs) * 100) : 0;

        // Cases/Penanganan statistics
        $cases = $this->walikelas_model->get_penanganan_siswa($wali_kelas['id'], $active_tp['id']);
        $data['total_cases'] = count($cases);
        $solved_cases = 0;
        foreach ($cases as $c) {
            if ($c['status'] == 'Selesai') $solved_cases++;
        }
        $data['solved_cases'] = $solved_cases;
        $data['pending_cases'] = count($cases) - $solved_cases;

        // Recent logs
        $data['recent_programs'] = array_slice($programs, 0, 5);
        $data['recent_cases'] = array_slice($cases, 0, 5);

        $this->template->load('layout/main', 'walikelas/dashboard', $data);
    }

    public function program_kelas() {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $result = $this->waliKelasService->save_program_kelas($this->input->post(NULL, TRUE), $_FILES, $active_tp);
            if ($result['status']) {
                $this->session->set_flashdata('success', 'Program Kelas berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
            redirect('walikelas/program_kelas');
            return;
        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $result = $this->waliKelasService->save_program_kelas($this->input->post(NULL, TRUE), $_FILES, $active_tp, $id);
            if ($result['status']) {
                $this->session->set_flashdata('success', 'Program Kelas berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
            redirect('walikelas/program_kelas');
            return;
        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $program = $this->db->get_where('jurnal_walikelas', array('id' => $id))->row_array();
            if ($program) {
                $this->db->delete('jurnal_walikelas', array('id' => $id));
                if ($program['dokumentasi'] && file_exists('./' . $program['dokumentasi'])) {
                    @unlink('./' . $program['dokumentasi']);
                }
                $this->session->set_flashdata('success', 'Program Kelas berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Program Kelas tidak ditemukan.');
            }
            redirect('walikelas/program_kelas');
            return;
        }

        $data['title'] = 'Jurnal Program Kerja Wali Kelas';
        $data['kelas'] = $wali_kelas;
        $data['programs'] = $this->walikelas_model->get_program_kelas($wali_kelas['id'], $active_tp['id']);

        $this->template->load('layout/main', 'walikelas/program_kelas', $data);
    }

    public function program_delete($id) {
        $program = $this->db->get_where('jurnal_walikelas', array('id' => $id))->row_array();
        if ($program) {
            $this->db->delete('jurnal_walikelas', array('id' => $id));
            if ($program['dokumentasi'] && file_exists('./' . $program['dokumentasi'])) {
                unlink('./' . $program['dokumentasi']);
            }
            $this->session->set_flashdata('success', 'Program kelas berhasil dihapus.');
        }
        redirect('walikelas/program_kelas');
    }

    public function penanganan_siswa() {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $result = $this->penangananService->save_penanganan($this->input->post(NULL, TRUE), $_FILES, $active_tp);
            if ($result['status']) {
                $this->session->set_flashdata('success', 'Catatan Penanganan Siswa berhasil disimpan.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
            redirect('walikelas/penanganan_siswa');
            return;
        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $result = $this->penangananService->save_penanganan($this->input->post(NULL, TRUE), $_FILES, $active_tp, $id);
            if ($result['status']) {
                $this->session->set_flashdata('success', 'Catatan Penanganan Siswa berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
            redirect('walikelas/penanganan_siswa');
            return;
        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $case = $this->db->get_where('penanganan_siswa', array('id' => $id))->row_array();
            if ($case) {
                $this->db->delete('penanganan_siswa', array('id' => $id));
                if ($case['dokumentasi'] && file_exists('./' . $case['dokumentasi'])) {
                    @unlink('./' . $case['dokumentasi']);
                }
                $this->session->set_flashdata('success', 'Catatan pembinaan siswa berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Catatan tidak ditemukan.');
            }
            redirect('walikelas/penanganan_siswa');
            return;
        }

        $data['title'] = 'Buku Catatan Penanganan & Pembinaan Siswa';
        $data['kelas'] = $wali_kelas;
        $data['siswa_list'] = $this->master_model->get_siswa_by_kelas($wali_kelas['id']);
        $data['cases'] = $this->walikelas_model->get_penanganan_siswa($wali_kelas['id'], $active_tp['id']);

        // Inject stats for charts and summaries
        $data['stats_siswa'] = $this->walikelas_model->get_stats_per_siswa($active_tp['id'], $wali_kelas['id']);
        $data['stats_kategori'] = $this->walikelas_model->get_stats_per_kategori($active_tp['id'], $wali_kelas['id']);
        $data['stats_status'] = $this->walikelas_model->get_stats_per_status($active_tp['id'], $wali_kelas['id']);
        $data['stats_tren'] = $this->walikelas_model->get_stats_tren_bulanan($active_tp['id'], $wali_kelas['id']);

        $this->template->load('layout/main', 'walikelas/penanganan_siswa', $data);
    }

    public function penanganan_delete($id) {
        $case = $this->db->get_where('penanganan_siswa', array('id' => $id))->row_array();
        if ($case) {
            $this->db->delete('penanganan_siswa', array('id' => $id));
            if ($case['dokumentasi'] && file_exists('./' . $case['dokumentasi'])) {
                unlink('./' . $case['dokumentasi']);
            }
            $this->session->set_flashdata('success', 'Catatan pembinaan siswa berhasil dihapus.');
        }
        redirect('walikelas/penanganan_siswa');
    }

    public function kokurikuler() {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $result = $this->waliKelasService->save_kokurikuler($this->input->post(NULL, TRUE), $_FILES, $active_tp);
            if ($result['status']) {
                $this->session->set_flashdata('success', 'Aktivitas Kokurikuler berhasil disimpan.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
            redirect('walikelas/kokurikuler');
            return;
        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $result = $this->waliKelasService->save_kokurikuler($this->input->post(NULL, TRUE), $_FILES, $active_tp, $id);
            if ($result['status']) {
                $this->session->set_flashdata('success', 'Aktivitas Kokurikuler berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
            redirect('walikelas/kokurikuler');
            return;
        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $koku = $this->db->get_where('kokurikuler', array('id' => $id))->row_array();
            if ($koku) {
                $this->db->delete('kokurikuler', array('id' => $id));
                if ($koku['dokumentasi'] && file_exists('./' . $koku['dokumentasi'])) {
                    @unlink('./' . $koku['dokumentasi']);
                }
                $this->session->set_flashdata('success', 'Aktivitas kokurikuler berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Aktivitas tidak ditemukan.');
            }
            redirect('walikelas/kokurikuler');
            return;
        }

        $data['title'] = 'Aktivitas Kokurikuler & Pembimbingan';
        $data['kelas'] = $wali_kelas;
        $data['kokurikuler_list'] = $this->walikelas_model->get_kokurikuler($wali_kelas['id'], $active_tp['id']);

        // Pass list_guru containing only the homeroom teacher/wali kelas
        $data['list_guru'] = array(
            array(
                'id' => $wali_kelas['guru_id'],
                'nama_lengkap' => $wali_kelas['nama_wali'] ?? 'Wali Kelas'
            )
        );

        $this->template->load('layout/main', 'walikelas/kokurikuler', $data);
    }

    public function kokurikuler_delete($id) {
        $koku = $this->db->get_where('kokurikuler', array('id' => $id))->row_array();
        if ($koku) {
            $this->db->delete('kokurikuler', array('id' => $id));
            if ($koku['dokumentasi'] && file_exists('./' . $koku['dokumentasi'])) {
                unlink('./' . $koku['dokumentasi']);
            }
            $this->session->set_flashdata('success', 'Aktivitas kokurikuler berhasil dihapus.');
        }
        redirect('walikelas/kokurikuler');
    }

    public function profil_penanganan($siswa_id) {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $siswa_id = (int)$siswa_id;

        // Fetch student
        $this->db->select('siswa.*, kelas.nama_kelas, guru.nama_lengkap as nama_wali, guru.nip as nip_wali');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id');
        $this->db->join('guru', 'guru.id = kelas.wali_kelas_id', 'left');
        $this->db->where('siswa.id', $siswa_id);
        $siswa = $this->db->get()->row_array();

        if (!$siswa) {
            show_404();
        }

        // Verify that this student belongs to the wali kelas's class (unless admin/superadmin)
        $role = $this->current_user['role_code'];
        if (!in_array($role, array('admin', 'superadmin')) && $siswa['kelas_id'] != $wali_kelas['id']) {
            show_error('Akses ditolak: Anda bukan wali kelas dari siswa ini.', 403, '403 Forbidden');
            return;
        }

        // Fetch history
        $history = $this->walikelas_model->get_penanganan_by_siswa($siswa_id);

        // Fetch student stats
        $kategori_stats = $this->walikelas_model->get_student_kategori_stats($siswa_id, $active_tp['id']);
        $trend_stats = $this->walikelas_model->get_student_trend_stats($siswa_id, $active_tp['id']);

        $data['title'] = 'Profil Histori Penanganan Siswa';
        $data['siswa'] = $siswa;
        $data['history'] = $history;
        $data['kategori_stats'] = $kategori_stats;
        $data['trend_stats'] = $trend_stats;

        $this->template->load('layout/main', 'walikelas/profil_penanganan', $data);
    }

    public function download_template($module) {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        if ($module == 'program_kelas') {
            $sheet->setCellValue('A1', 'TANGGAL (YYYY-MM-DD)');
            $sheet->setCellValue('B1', 'PROGRAM WORK');
            $sheet->setCellValue('C1', 'TARGET');
            $sheet->setCellValue('D1', 'PELAKSANAAN / KBM');
            $sheet->setCellValue('E1', 'STATUS (Belum/Terealisasi)');
            $sheet->setCellValue('F1', 'CATATAN');
            
            $sheet->setCellValue('A2', date('Y-m-d'));
            $sheet->setCellValue('B2', 'Kunjungan Perpustakaan');
            $sheet->setCellValue('C2', 'Siswa gemar membaca');
            $sheet->setCellValue('D2', 'Membaca buku 15 menit');
            $sheet->setCellValue('E2', 'Terealisasi');
            $sheet->setCellValue('F2', 'Berjalan tertib');
            
            $filename = 'Template_Program_Wali_Kelas.xlsx';
        } else {
            $sheet->setCellValue('A1', 'TANGGAL (YYYY-MM-DD)');
            $sheet->setCellValue('B1', 'TEMA');
            $sheet->setCellValue('C1', 'SUB TEMA / JUDUL');
            $sheet->setCellValue('D1', 'AKTIVITAS');
            $sheet->setCellValue('E1', 'TUJUAN');
            $sheet->setCellValue('F1', 'STATUS (Draft/Terlaksana)');
            $sheet->setCellValue('G1', 'CATATAN');
            
            $sheet->setCellValue('A2', date('Y-m-d'));
            $sheet->setCellValue('B2', 'Kewirausahaan');
            $sheet->setCellValue('C2', 'Market Day');
            $sheet->setCellValue('D2', 'Bazar kuliner sehat');
            $sheet->setCellValue('E2', 'Melatih jiwa wirausaha');
            $sheet->setCellValue('F2', 'Terlaksana');
            $sheet->setCellValue('G2', 'Siswa antusias');
            
            $filename = 'Template_Kokurikuler_Wali_Kelas.xlsx';
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    public function import($module) {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        if (empty($_FILES['excel_file']['name'])) {
            $this->session->set_flashdata('error', 'Silakan pilih file Excel terlebih dahulu.');
            redirect('walikelas/' . ($module == 'program_kelas' ? 'program_kelas' : 'kokurikuler'));
            return;
        }

        if (!is_dir('./assets/uploads/excel_imports/')) {
            mkdir('./assets/uploads/excel_imports/', 0777, TRUE);
        }

        $config['upload_path']   = './assets/uploads/excel_imports/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['max_size']      = 5120; // 5MB
        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('excel_file')) {
            $this->session->set_flashdata('error', 'Gagal upload file: ' . $this->upload->display_errors());
            redirect('walikelas/' . ($module == 'program_kelas' ? 'program_kelas' : 'kokurikuler'));
            return;
        }

        $upload_data = $this->upload->data();
        $file_path = './assets/uploads/excel_imports/' . $upload_data['file_name'];

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
            $sheet = $spreadsheet->getActiveSheet();
            $highest_row = $sheet->getHighestRow();
            
            $preview_rows = array();
            $valid_count = 0;
            $invalid_count = 0;

            for ($row = 2; $row <= $highest_row; $row++) {
                if ($module == 'program_kelas') {
                    $tanggal = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                    $program = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                    $target = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                    $pelaksanaan = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                    $status = trim($sheet->getCell('E' . $row)->getValue() ?? 'Belum');
                    $catatan = trim($sheet->getCell('F' . $row)->getValue() ?? '');

                    if ($tanggal === '' && $program === '') continue;

                    $row_errors = array();
                    if ($tanggal === '') $row_errors[] = 'Tanggal tidak boleh kosong.';
                    elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) $row_errors[] = 'Format tanggal harus YYYY-MM-DD.';
                    if ($program === '') $row_errors[] = 'Program tidak boleh kosong.';
                    if ($status !== 'Belum' && $status !== 'Terealisasi') $row_errors[] = 'Status harus Belum atau Terealisasi.';

                    if (empty($row_errors)) $valid_count++; else $invalid_count++;

                    $preview_rows[] = array(
                        'row_num' => $row,
                        'tanggal' => $tanggal,
                        'program' => $program,
                        'target' => $target,
                        'pelaksanaan' => $pelaksanaan,
                        'status' => $status,
                        'catatan' => $catatan,
                        'errors' => $row_errors
                    );
                } else {
                    $tanggal = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                    $tema = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                    $sub_tema = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                    $aktivitas = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                    $tujuan = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                    $status = trim($sheet->getCell('F' . $row)->getValue() ?? 'Draft');
                    $catatan = trim($sheet->getCell('G' . $row)->getValue() ?? '');

                    if ($tanggal === '' && $tema === '') continue;

                    $row_errors = array();
                    if ($tanggal === '') $row_errors[] = 'Tanggal tidak boleh kosong.';
                    elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) $row_errors[] = 'Format tanggal harus YYYY-MM-DD.';
                    if ($tema === '') $row_errors[] = 'Tema tidak boleh kosong.';
                    if ($status !== 'Draft' && $status !== 'Terlaksana') $row_errors[] = 'Status harus Draft atau Terlaksana.';

                    if (empty($row_errors)) $valid_count++; else $invalid_count++;

                    $preview_rows[] = array(
                        'row_num' => $row,
                        'tanggal' => $tanggal,
                        'tema' => $tema,
                        'sub_tema' => $sub_tema,
                        'aktivitas' => $aktivitas,
                        'tujuan' => $tujuan,
                        'status' => $status,
                        'catatan' => $catatan,
                        'errors' => $row_errors
                    );
                }
            }

            $data['title'] = 'Preview Import Wali Kelas';
            $data['module'] = $module;
            $data['file_name'] = $upload_data['file_name'];
            $data['preview_rows'] = $preview_rows;
            $data['summary'] = array(
                'total' => count($preview_rows),
                'valid' => $valid_count,
                'invalid' => $invalid_count,
                'duplicate' => 0
            );

            $this->template->load('layout/main', 'walikelas/preview_import', $data);

        } catch (Exception $e) {
            if (file_exists($file_path)) unlink($file_path);
            $this->session->set_flashdata('error', 'Gagal memproses file Excel: ' . $e->getMessage());
            redirect('walikelas/' . ($module == 'program_kelas' ? 'program_kelas' : 'kokurikuler'));
        }
    }

    public function confirm_import($module) {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $file_name = $this->input->post('file_name', TRUE);
        $file_path = './assets/uploads/excel_imports/' . $file_name;
        
        if (!file_exists($file_path)) {
            $this->session->set_flashdata('error', 'Sesi file import kadaluarsa. Silakan upload kembali.');
            redirect('walikelas/' . ($module == 'program_kelas' ? 'program_kelas' : 'kokurikuler'));
            return;
        }

        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
            $sheet = $spreadsheet->getActiveSheet();
            $highest_row = $sheet->getHighestRow();
            $success_count = 0;
            $error_count = 0;

            $this->db->trans_begin();

            for ($row = 2; $row <= $highest_row; $row++) {
                if ($module == 'program_kelas') {
                    $tanggal = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                    $program = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                    $target = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                    $pelaksanaan = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                    $status = trim($sheet->getCell('E' . $row)->getValue() ?? 'Belum');
                    $catatan = trim($sheet->getCell('F' . $row)->getValue() ?? '');

                    if ($tanggal === '' && $program === '') continue;

                    if ($tanggal === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal) || $program === '' || ($status !== 'Belum' && $status !== 'Terealisasi')) {
                        $error_count++;
                        continue;
                    }

                    $insert_data = array(
                        'tahun_pelajaran_id' => $active_tp['id'],
                        'kelas_id' => $wali_kelas['id'],
                        'wali_id' => $wali_kelas['guru_id'],
                        'tanggal' => $tanggal,
                        'program' => $program,
                        'target' => $target,
                        'pelaksanaan' => $pelaksanaan,
                        'status' => $status,
                        'catatan' => $catatan
                    );

                    $this->db->insert('jurnal_walikelas', $insert_data);
                    $success_count++;
                } else {
                    $tanggal = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                    $tema = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                    $sub_tema = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                    $aktivitas = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                    $tujuan = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                    $status = trim($sheet->getCell('F' . $row)->getValue() ?? 'Draft');
                    $catatan = trim($sheet->getCell('G' . $row)->getValue() ?? '');

                    if ($tanggal === '' && $tema === '') continue;

                    if ($tanggal === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal) || $tema === '' || ($status !== 'Draft' && $status !== 'Terlaksana')) {
                        $error_count++;
                        continue;
                    }

                    $insert_data = array(
                        'tahun_pelajaran_id' => $active_tp['id'],
                        'kelas_id' => $wali_kelas['id'],
                        'guru_id' => $wali_kelas['guru_id'],
                        'tema' => $tema,
                        'sub_tema' => $sub_tema,
                        'aktivitas' => $aktivitas,
                        'tujuan' => $tujuan,
                        'tanggal' => $tanggal,
                        'status' => $status,
                        'catatan' => $catatan
                    );

                    $this->db->insert('kokurikuler', $insert_data);
                    $success_count++;
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal memproses transaksi import.');
            } else {
                $this->db->trans_commit();
                $msg = "Import data berhasil! $success_count data disimpan.";
                if ($error_count > 0) $msg .= " Namun terdapat $error_count data dilewati karena error.";
                $this->session->set_flashdata('success', $msg);
            }

        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Error memproses import data: ' . $e->getMessage());
        }

        if (file_exists($file_path)) unlink($file_path);
        redirect('walikelas/' . ($module == 'program_kelas' ? 'program_kelas' : 'kokurikuler'));
    }

    public function rekap_pelanggaran() {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $data['kelas'] = $wali_kelas;
        
        $data['list_siswa'] = $this->db->select('siswa.*, SUM(IFNULL(penanganan_siswa.poin, 0)) as total_poin, COUNT(penanganan_siswa.id) as total_kasus')
            ->from('siswa')
            ->join('penanganan_siswa', 'penanganan_siswa.siswa_id = siswa.id AND penanganan_siswa.tahun_pelajaran_id = ' . $this->db->escape($active_tp['id']), 'left')
            ->where('siswa.kelas_id', $wali_kelas['id'])
            ->group_by('siswa.id')
            ->order_by('total_poin', 'DESC')
            ->get()->result_array();

        $data['title'] = 'Rekap Pelanggaran Siswa';
        $data['active_tp'] = $active_tp;

        $this->template->load('layout/main', 'walikelas/rekap_pelanggaran', $data);
    }

    public function rekap_pelanggaran_detail($siswa_id) {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $siswa = $this->db->select('siswa.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->get_where('siswa', array('siswa.id' => $siswa_id, 'siswa.kelas_id' => $wali_kelas['id']))->row_array();

        if (!$siswa) {
            $this->session->set_flashdata('error', 'Siswa tidak ditemukan atau bukan dari kelas Anda.');
            redirect('walikelas/rekap_pelanggaran');
            return;
        }

        $timeline = $this->db->select('penanganan_siswa.*, guru.nama_lengkap as nama_wali')
            ->join('guru', 'guru.id = penanganan_siswa.wali_id', 'left')
            ->where('penanganan_siswa.siswa_id', $siswa_id)
            ->where('penanganan_siswa.tahun_pelajaran_id', $active_tp['id'])
            ->order_by('penanganan_siswa.tanggal', 'DESC')
            ->get('penanganan_siswa')->result_array();

        $trends = $this->db->select("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(poin) as total_poin, COUNT(id) as total_kasus")
            ->where('siswa_id', $siswa_id)
            ->where('tahun_pelajaran_id', $active_tp['id'])
            ->group_by("DATE_FORMAT(tanggal, '%Y-%m')")
            ->order_by('bulan', 'ASC')
            ->get('penanganan_siswa')->result_array();

        $data['title'] = 'Detail Pelanggaran Siswa: ' . $siswa['nama_lengkap'];
        $data['siswa'] = $siswa;
        $data['timeline'] = $timeline;
        $data['trends'] = $trends;
        $data['active_tp'] = $active_tp;
        $data['kelas'] = $wali_kelas;

        $this->template->load('layout/main', 'walikelas/rekap_pelanggaran_detail', $data);
    }

    public function rekap_pelanggaran_export($type) {
        $wali_kelas = $this->get_wali_kelas_or_redirect($this->current_user['id']);
        if (!$wali_kelas) return;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $kelas = $wali_kelas;
        
        $list_siswa = $this->db->select('siswa.*, SUM(IFNULL(penanganan_siswa.poin, 0)) as total_poin, COUNT(penanganan_siswa.id) as total_kasus')
            ->from('siswa')
            ->join('penanganan_siswa', 'penanganan_siswa.siswa_id = siswa.id AND penanganan_siswa.tahun_pelajaran_id = ' . $this->db->escape($active_tp['id']), 'left')
            ->where('siswa.kelas_id', $kelas['id'])
            ->group_by('siswa.id')
            ->order_by('total_poin', 'DESC')
            ->get()->result_array();

        $data['kelas'] = $kelas;
        $data['list_siswa'] = $list_siswa;
        $data['active_tp'] = $active_tp;
        $data['title'] = 'Rekap Pelanggaran Kelas ' . $kelas['nama_kelas'];

        if ($type == 'excel') {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            $sheet->setCellValue('A1', 'REKAPITULASI PELANGGARAN SISWA');
            $sheet->setCellValue('A2', 'Kelas: ' . $kelas['nama_kelas']);
            $sheet->setCellValue('A3', 'Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');
            
            $sheet->setCellValue('A5', 'No');
            $sheet->setCellValue('B5', 'NIS');
            $sheet->setCellValue('C5', 'Nama Lengkap');
            $sheet->setCellValue('D5', 'Jenis Kelamin');
            $sheet->setCellValue('E5', 'Total Kasus');
            $sheet->setCellValue('F5', 'Akumulasi Poin');
            
            $row_idx = 6;
            $no = 1;
            foreach ($list_siswa as $s) {
                $sheet->setCellValue('A' . $row_idx, $no++);
                $sheet->setCellValueExplicit('B' . $row_idx, $s['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('C' . $row_idx, $s['nama_lengkap']);
                $sheet->setCellValue('D' . $row_idx, $s['jk'] == 'L' ? 'Laki-laki' : 'Perempuan');
                $sheet->setCellValue('E' . $row_idx, $s['total_kasus']);
                $sheet->setCellValue('F' . $row_idx, $s['total_poin']);
                $row_idx++;
            }

            foreach (range('A', 'F') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rekap_Pelanggaran_' . str_replace(' ', '_', $kelas['nama_kelas']) . '.xlsx"');
            $writer->save('php://output');
            exit;

        } elseif ($type == 'pdf') {
            require_once APPPATH . 'services/LaporanService.php';
            $laporanService = new LaporanService();
            $laporanService->render_pdf('walikelas/rekap_pelanggaran_pdf', $data, 'Rekap_Pelanggaran_' . date('Ymd') . '.pdf', 'portrait');
            exit;
            
        } elseif ($type == 'print') {
            $this->load->view('walikelas/rekap_pelanggaran_print', $data);
        }
    }
}
