<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Supervisi extends MY_Controller {

    protected $current_user;

    public function __construct() {
        parent::__construct();

        $this->load->model('Supervisi_model', 'supervisi_m');
        $this->load->model('Master_model', 'master_m');
        $this->load->library('form_validation');

        if (is_cli()) return;

        // Check authentication & allowed roles (kamad, waka, admin, superadmin, guru)
        $this->auth_lib->check_access(array('admin', 'superadmin', 'kamad', 'waka', 'guru'));
        $this->current_user = $this->auth_lib->get_user();
    }

    // ============================================================
    // 1. DASHBOARD SUPERVISI
    // ============================================================
    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $role = $this->current_user['role_code'] ?? '';
        $active_tp = $this->master_m->get_active_tahun_pelajaran();
        $tp_id = $active_tp['id'] ?? NULL;
        $semester = $active_tp['semester'] ?? 'Ganjil';

        $data['title'] = 'Dashboard Supervisi Akademik';
        $data['active_tp'] = $active_tp;
        $data['user_role'] = $role;

        if ($role == 'waka') {
            $data['stats'] = $this->supervisi_m->get_waka_dashboard_stats($tp_id, $semester);
            $this->template->load('layout/main', 'supervisi/dashboard_waka', $data);
        } else {
            // Kamad, Admin, Superadmin default to Kamad Dashboard
            $data['stats'] = $this->supervisi_m->get_kamad_dashboard_stats($tp_id, $semester);
            $this->template->load('layout/main', 'supervisi/dashboard_kamad', $data);
        }
    }

    // ============================================================
    // 2. DAFTAR GURU UNTUK SUPERVISI
    // ============================================================
    public function guru() {
        $active_tp = $this->master_m->get_active_tahun_pelajaran();
        $tp_id = $active_tp['id'] ?? NULL;
        $semester = $active_tp['semester'] ?? 'Ganjil';

        $data['title'] = 'Daftar Guru Supervisi Akademik';
        $data['active_tp'] = $active_tp;
        $data['gurus'] = $this->supervisi_m->get_guru_supervisi_list($tp_id, $semester);
        $data['user_role'] = $this->current_user['role_code'] ?? '';

        $this->template->load('layout/main', 'supervisi/daftar_guru', $data);
    }

    // ============================================================
    // 3. INSTRUMEN FORMS (FORM 1, FORM 2, FORM 3, FORM 4)
    // ============================================================
    public function form1() { $this->load_form(1); }
    public function form2() { $this->load_form(2); }
    public function form3() { $this->load_form(3); }
    public function form4() { $this->load_form(4); }

    private function load_form($form_id) {
        $role = $this->current_user['role_code'] ?? '';

        // Guru role cannot create or edit supervision scores directly
        if ($role == 'guru' && !in_array($role, array('admin', 'superadmin', 'kamad', 'waka'))) {
            show_error('Akses Ditolak: Hak akses supervisi terbatas untuk Kepala Madrasah dan Waka Kurikulum.', 403);
            return;
        }

        $id = (int)$this->input->get('id');
        $guru_id = (int)$this->input->get('guru_id');
        $mapel_id = (int)$this->input->get('mapel_id');
        $kelas_id = (int)$this->input->get('kelas_id');
        $tahap = $this->input->get('tahap') ? $this->input->get('tahap') : 'Tahap 1';

        $active_tp = $this->master_m->get_active_tahun_pelajaran();

        $form_info = $this->supervisi_m->get_form_by_id($form_id);
        if (!$form_info) {
            show_404();
            return;
        }

        $supervisi = NULL;
        $details_map = array();

        if ($id > 0) {
            $supervisi = $this->supervisi_m->get_supervisi_by_id($id);
            if ($supervisi) {
                $guru_id = $supervisi['guru_id'];
                $mapel_id = $supervisi['mapel_id'];
                $kelas_id = $supervisi['kelas_id'];
                $tahap = $supervisi['tahap'];
                $form_id = $supervisi['form_id'];
                $raw_details = $this->supervisi_m->get_supervisi_details($id);
                foreach ($raw_details as $d) {
                    $details_map[$d['indikator_id']] = $d;
                }
            }
        } else {
            // Check if draft exists for this teacher, form, tp, and semester
            if ($guru_id > 0) {
                $this->db->where('guru_id', $guru_id);
                $this->db->where('form_id', $form_id);
                $this->db->where('tahun_pelajaran_id', $active_tp['id'] ?? 0);
                $this->db->where('tahap', $tahap);
                $this->db->order_by('id', 'DESC');
                $existing = $this->db->get('supervisi')->row_array();
                if ($existing && $existing['status'] != 'SELESAI') {
                    $supervisi = $this->supervisi_m->get_supervisi_by_id($existing['id']);
                    $id = $existing['id'];
                    $raw_details = $this->supervisi_m->get_supervisi_details($id);
                    foreach ($raw_details as $d) {
                        $details_map[$d['indikator_id']] = $d;
                    }
                }
            }
        }

        $indikators = $this->supervisi_m->get_indikator_by_form($form_id);

        // Group indicators by sub_bagian
        $grouped_indikators = array();
        foreach ($indikators as $ind) {
            $sub = !empty($ind['sub_bagian']) ? $ind['sub_bagian'] : 'Umum';
            $grouped_indikators[$sub][] = $ind;
        }

        // Fetch Master data for selectors
        $data['title'] = $form_info['nama_form'];
        $data['form_info'] = $form_info;
        $data['form_id'] = $form_id;
        $data['indikators'] = $indikators;
        $data['grouped_indikators'] = $grouped_indikators;
        $data['supervisi'] = $supervisi;
        $data['details_map'] = $details_map;
        $data['supervisi_id'] = $id;

        $data['guru_list'] = $this->master_m->get_all_guru();
        if ($guru_id > 0) {
            $data['mapel_list'] = $this->master_m->get_mapel_by_guru($guru_id, $active_tp['id'] ?? NULL);
            $data['kelas_list'] = $this->master_m->get_kelas_by_guru_or_wali($guru_id, 0, $active_tp['id'] ?? NULL);
        } else {
            $data['mapel_list'] = $this->master_m->get_all_mapel();
            $data['kelas_list'] = $this->master_m->get_all_kelas();
        }
        $data['active_tp'] = $active_tp;

        $data['selected_guru_id'] = $guru_id;
        $data['selected_mapel_id'] = $mapel_id;
        $data['selected_kelas_id'] = $kelas_id;
        $data['selected_tahap'] = $tahap;

        // Auto supervisor logic
        $data['supervisor_id'] = $this->current_user['id'];
        $data['supervisor_name'] = $this->current_user['full_name'];
        $data['supervisor_role'] = ($role == 'kamad') ? 'Kepala Madrasah' : (($role == 'waka') ? 'Waka Kurikulum' : 'Administrator');

        // Teacher uploaded documents for Form 1 & Form 2 reference
        $data['teacher_docs'] = ($guru_id > 0) ? $this->supervisi_m->get_teacher_documents($guru_id, $mapel_id) : array();

        $this->template->load('layout/main', 'supervisi/form_input', $data);
    }

    // ============================================================
    // 4. AJAX SAVE DRAFT & SUBMIT
    // ============================================================
    public function save() {
        if (!$this->input->is_ajax_request()) {
            show_error('Direct access not allowed', 400);
            return;
        }

        $role = $this->current_user['role_code'] ?? '';
        if ($role == 'guru' && !in_array($role, array('admin', 'superadmin', 'kamad', 'waka'))) {
            echo json_encode(array('status' => 'error', 'message' => 'Anda tidak memiliki hak akses untuk menyimpan data supervisi.'));
            return;
        }

        $id = (int)$this->input->post('supervisi_id');
        $form_id = (int)$this->input->post('form_id');
        $guru_id = (int)$this->input->post('guru_id');
        $mapel_id = (int)$this->input->post('mapel_id');
        $kelas_id = (int)$this->input->post('kelas_id');
        $tahun_pelajaran_id = (int)$this->input->post('tahun_pelajaran_id');
        $semester = $this->input->post('semester') ?? 'Ganjil';
        $tahap = $this->input->post('tahap') ?? 'Tahap 1';
        $tanggal_supervisi = $this->input->post('tanggal_supervisi') ?? date('Y-m-d');
        $jam_mulai = !empty($this->input->post('jam_mulai')) ? $this->input->post('jam_mulai') : NULL;
        $jam_selesai = !empty($this->input->post('jam_selesai')) ? $this->input->post('jam_selesai') : NULL;
        $action_type = $this->input->post('action_type'); // 'draft' or 'submit'

        if ($guru_id <= 0 || $form_id <= 0 || $mapel_id <= 0 || $kelas_id <= 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Pilih Guru, Mata Pelajaran, dan Kelas terlebih dahulu.'));
            return;
        }

        // Check if locked
        if ($id > 0) {
            $existing = $this->supervisi_m->get_supervisi_by_id($id);
            if ($existing && $existing['status'] == 'SELESAI' && $role != 'admin' && $role != 'superadmin') {
                echo json_encode(array('status' => 'error', 'message' => 'Data supervisi ini telah dikunci (SELESAI). Gunakan opsi Ajukan Revisi jika ingin mengubah data.'));
                return;
            }
        }

        $details = $this->input->post('skor') ?? array(); // array(indikator_id => array('skor' => X, 'catatan' => Y))

        // If submitting, validate all indicators are scored
        $is_submit = ($action_type === 'submit');
        if ($is_submit) {
            $indikators = $this->supervisi_m->get_indikator_by_form($form_id);
            $unscored = array();
            foreach ($indikators as $ind) {
                if (!isset($details[$ind['id']]) || !isset($details[$ind['id']]['skor']) || $details[$ind['id']]['skor'] === '') {
                    $unscored[] = $ind['nomor_urut'] . '. ' . $ind['nama_indikator'];
                }
            }

            if (!empty($unscored)) {
                echo json_encode(array(
                    'status' => 'validation_error',
                    'message' => 'Terdapat ' . count($unscored) . ' indikator yang belum dinilai.',
                    'unscored' => $unscored
                ));
                return;
            }
        }

        $supervisor_role_name = ($role == 'kamad') ? 'Kepala Madrasah' : (($role == 'waka') ? 'Waka Kurikulum' : 'Administrator');

        $data = array(
            'id' => $id,
            'guru_id' => $guru_id,
            'supervisor_id' => $this->current_user['id'],
            'supervisor_role' => $supervisor_role_name,
            'mapel_id' => $mapel_id,
            'kelas_id' => $kelas_id,
            'tahun_pelajaran_id' => $tahun_pelajaran_id,
            'semester' => $semester,
            'form_id' => $form_id,
            'tahap' => $tahap,
            'tanggal_supervisi' => $tanggal_supervisi,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'catatan_analisis' => $this->input->post('catatan_analisis'),
            'tindak_lanjut' => $this->input->post('tindak_lanjut'),
            'saran' => $this->input->post('saran')
        );

        $saved_id = $this->supervisi_m->save_supervisi($data, $details, $this->current_user['id'], $role, $is_submit);

        if ($saved_id) {
            $msg = $is_submit ? 'Supervisi Akademik berhasil diselesaikan!' : 'Draft supervisi berhasil disimpan.';
            echo json_encode(array('status' => 'success', 'message' => $msg, 'supervisi_id' => $saved_id));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menyimpan data supervisi ke database.'));
        }
    }

    // ============================================================
    // 4b. GET MAPEL & KELAS OPTIONS BY GURU (AJAX)
    // ============================================================
    public function get_guru_options() {
        if (!$this->input->is_ajax_request()) return;
        $guru_id = (int)$this->input->get('guru_id');
        $active_tp = $this->master_m->get_active_tahun_pelajaran();
        $tp_id = $active_tp['id'] ?? NULL;

        if ($guru_id > 0) {
            $mapel = $this->master_m->get_mapel_by_guru($guru_id, $tp_id);
            $kelas = $this->master_m->get_kelas_by_guru_or_wali($guru_id, 0, $tp_id);
        } else {
            $mapel = $this->master_m->get_all_mapel();
            $kelas = $this->master_m->get_all_kelas();
        }

        echo json_encode(array(
            'status' => 'success',
            'mapel' => $mapel,
            'kelas' => $kelas
        ));
    }

    // ============================================================
    // 5. OBSERVASI KELAS (FORM 3 TIME TRACKING)
    // ============================================================
    public function start_observation() {
        if (!$this->input->is_ajax_request()) return;
        $supervisi_id = (int)$this->input->post('supervisi_id');
        $jam_mulai = date('H:i:s');

        if ($supervisi_id > 0) {
            $this->db->where('id', $supervisi_id);
            $this->db->update('supervisi', array('jam_mulai' => $jam_mulai, 'status' => 'DALAM PROSES'));
        }

        echo json_encode(array('status' => 'success', 'jam_mulai' => $jam_mulai));
    }

    public function finish_observation() {
        if (!$this->input->is_ajax_request()) return;
        $supervisi_id = (int)$this->input->post('supervisi_id');
        $jam_selesai = date('H:i:s');

        if ($supervisi_id > 0) {
            $this->db->where('id', $supervisi_id);
            $this->db->update('supervisi', array('jam_selesai' => $jam_selesai));
        }

        echo json_encode(array('status' => 'success', 'jam_selesai' => $jam_selesai));
    }

    // ============================================================
    // 6. REKAP SUPERVISI AKADEMIK
    // ============================================================
    public function rekap() {
        $active_tp = $this->master_m->get_active_tahun_pelajaran();

        $filters = array(
            'tahun_pelajaran_id' => $this->input->get('tp_id') ?? ($active_tp['id'] ?? NULL),
            'semester' => $this->input->get('semester') ?? ($active_tp['semester'] ?? 'Ganjil'),
            'guru_id' => $this->input->get('guru_id'),
            'mapel_id' => $this->input->get('mapel_id'),
            'kelas_id' => $this->input->get('kelas_id'),
            'supervisor_id' => $this->input->get('supervisor_id'),
            'form_id' => $this->input->get('form_id'),
            'status' => $this->input->get('status'),
            'search' => $this->input->get('search')
        );

        // Standard CI Pagination or Full Data
        $data['rekap_list'] = $this->supervisi_m->get_rekap($filters);
        $data['title'] = 'Rekap Supervisi Akademik';
        $data['filters'] = $filters;

        $data['tp_list'] = $this->master_m->get_all_tahun_pelajaran();
        $data['guru_list'] = $this->master_m->get_all_guru();
        $data['mapel_list'] = $this->master_m->get_all_mapel();
        $data['kelas_list'] = $this->master_m->get_all_kelas();
        $data['form_list'] = $this->supervisi_m->get_forms();
        $data['user_role'] = $this->current_user['role_code'] ?? '';

        $this->template->load('layout/main', 'supervisi/rekap', $data);
    }

    // ============================================================
    // 7. LAPORAN SUPERVISI
    // ============================================================
    public function laporan() {
        $active_tp = $this->master_m->get_active_tahun_pelajaran();

        $data['title'] = 'Laporan Supervisi Akademik';
        $data['active_tp'] = $active_tp;
        $data['tp_list'] = $this->master_m->get_all_tahun_pelajaran();
        $data['guru_list'] = $this->master_m->get_all_guru();
        $data['form_list'] = $this->supervisi_m->get_forms();
        $data['user_role'] = $this->current_user['role_code'] ?? '';

        $this->template->load('layout/main', 'supervisi/laporan', $data);
    }

    // ============================================================
    // 8. DETAIL GURU & GRAFIK PERKEMBANGAN
    // ============================================================
    public function detail_guru($guru_id = NULL) {
        if (!$guru_id) {
            $guru_id = (int)$this->input->get('guru_id');
        }

        // If teacher login, force guru_id to their own guru record
        $role = $this->current_user['role_code'] ?? '';
        if ($role == 'guru' && !in_array($role, array('admin', 'superadmin', 'kamad', 'waka'))) {
            $guru_rec = $this->master_m->get_guru_by_user_id($this->current_user['id']);
            if ($guru_rec) {
                $guru_id = $guru_rec['id'];
            }
        }

        $detail_data = $this->supervisi_m->get_guru_detail_supervisi($guru_id);
        if (!$detail_data) {
            show_404();
            return;
        }

        $data['title'] = 'Detail & Riwayat Supervisi: ' . $detail_data['guru']['nama_lengkap'];
        $data['guru'] = $detail_data['guru'];
        $data['history'] = $detail_data['history'];
        $data['user_role'] = $role;

        $this->template->load('layout/main', 'supervisi/detail_guru', $data);
    }

    // Teacher Respon Tindak Lanjut
    public function update_tindak_lanjut() {
        $id = (int)$this->input->post('supervisi_id');
        $status_tindak_lanjut = $this->input->post('status_tindak_lanjut');
        $respon_guru = $this->input->post('respon_guru');

        if ($id > 0) {
            $this->supervisi_m->update_tindak_lanjut($id, $status_tindak_lanjut, $respon_guru);
            $this->session->set_flashdata('success', 'Respon tindak lanjut berhasil diperbarui.');
        }

        redirect('supervisi/detail_guru/' . (int)$this->input->post('guru_id'));
    }

    // Request Revision
    public function request_revision() {
        $id = (int)$this->input->post('supervisi_id');
        $alasan = $this->input->post('alasan');
        $role = $this->current_user['role_code'] ?? '';

        if ($id > 0 && !empty($alasan)) {
            $this->supervisi_m->request_revision($id, $this->current_user['id'], $role, $alasan);
            $this->session->set_flashdata('success', 'Pengajuan revisi supervisi telah dicatat.');
        }

        redirect('supervisi/rekap');
    }

    // ============================================================
    // 9. EXPORT PDF (DOMPDF)
    // ============================================================
    public function export_pdf($id) {
        $supervisi = $this->supervisi_m->get_supervisi_by_id($id);
        if (!$supervisi) {
            show_404();
            return;
        }

        $details = $this->supervisi_m->get_supervisi_details($id);

        $data['supervisi'] = $supervisi;
        $data['details'] = $details;
        $data['form_info'] = $this->supervisi_m->get_form_by_id($supervisi['form_id']);
        $data['settings'] = $this->load->get_var('settings');

        $html = $this->load->view('supervisi/pdf_template', $data, TRUE);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Supervisi_' . str_replace(' ', '_', $supervisi['kode_form']) . '_' . str_replace(' ', '_', $supervisi['nama_guru']) . '.pdf';
        $dompdf->stream($filename, array("Attachment" => false));
    }

    // ============================================================
    // 10. EXPORT EXCEL (PHPSPREADSHEET)
    // ============================================================
    public function export_excel() {
        $filters = array(
            'tahun_pelajaran_id' => $this->input->get('tp_id'),
            'semester' => $this->input->get('semester'),
            'guru_id' => $this->input->get('guru_id'),
            'mapel_id' => $this->input->get('mapel_id'),
            'kelas_id' => $this->input->get('kelas_id'),
            'supervisor_id' => $this->input->get('supervisor_id'),
            'form_id' => $this->input->get('form_id'),
            'status' => $this->input->get('status'),
            'search' => $this->input->get('search')
        );

        $rekap_list = $this->supervisi_m->get_rekap($filters);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Supervisi');

        // Headers
        $sheet->setCellValue('A1', 'YAYASAN DARUL FAQIH MALANG INDONESIA');
        $sheet->setCellValue('A2', 'MA DARUL FAQIH INDONESIA');
        $sheet->setCellValue('A3', 'REKAPITULASI HASIL SUPERVISI AKADEMIK');
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3');

        $headers = array('No', 'Tanggal', 'Nama Guru', 'NIP', 'Mata Pelajaran', 'Kelas', 'Supervisor', 'Form', 'Jumlah Skor', 'Nilai Akhir', 'Status');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '5', $h);
            $col++;
        }

        $row_idx = 6;
        $no = 1;
        foreach ($rekap_list as $r) {
            $sheet->setCellValue('A' . $row_idx, $no++);
            $sheet->setCellValue('B' . $row_idx, date('d/m/Y', strtotime($r['tanggal_supervisi'])));
            $sheet->setCellValue('C' . $row_idx, $r['nama_guru']);
            $sheet->setCellValueExplicit('D' . $row_idx, $r['nip_guru'] ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('E' . $row_idx, $r['nama_mapel'] ?? '-');
            $sheet->setCellValue('F' . $row_idx, $r['nama_kelas'] ?? '-');
            $sheet->setCellValue('G' . $row_idx, $r['nama_supervisor'] ?? '-');
            $sheet->setCellValue('H' . $row_idx, $r['kode_form']);
            $sheet->setCellValue('I' . $row_idx, $r['jumlah_skor'] . ' / ' . $r['skor_maksimal']);
            $sheet->setCellValue('J' . $row_idx, $r['nilai_akhir']);
            $sheet->setCellValue('K' . $row_idx, $r['status']);
            $row_idx++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Rekap_Supervisi_Akademik_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    // ============================================================
    // 11. PRINT FORM (PRINT VIEW)
    // ============================================================
    public function print_form($id) {
        $supervisi = $this->supervisi_m->get_supervisi_by_id($id);
        if (!$supervisi) {
            show_404();
            return;
        }

        $details = $this->supervisi_m->get_supervisi_details($id);

        $data['supervisi'] = $supervisi;
        $data['details'] = $details;
        $data['form_info'] = $this->supervisi_m->get_form_by_id($supervisi['form_id']);
        $data['settings'] = $this->load->get_var('settings');

        $this->load->view('supervisi/print_template', $data);
    }
}
