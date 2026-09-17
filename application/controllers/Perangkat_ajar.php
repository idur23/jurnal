<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Perangkat_ajar extends Base_Controller {

    protected $perangkatService;

    public function __construct() {
        parent::__construct();
        $this->perangkatService = new PerangkatService();
        $this->load->model('perangkat_model');
        
        // Authorization check
        $role = $this->current_user['role_code'];
        if (!in_array($role, array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))) {
            show_error('Akses ditolak: Anda tidak memiliki wewenang untuk mengakses halaman ini.', 403, '403 Forbidden');
        }
    }

    /**
     * Sub Menu 1: Dashboard Perangkat Ajar
     */
    public function index() {
        $data['title'] = 'Dashboard Perangkat Ajar';
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
        
        $filters = array('is_active' => 1, 'is_archived' => 0);
        if ($role == 'guru' && $guru) {
            $filters['guru_id'] = $guru['id'];
        }

        // Metrics
        $data['total'] = $this->perangkat_model->count_filtered($filters);
        
        $filters['status_verifikasi'] = 'Disetujui';
        $data['approved'] = $this->perangkat_model->count_filtered($filters);
        
        $filters['status_verifikasi'] = 'Menunggu Verifikasi';
        $data['pending'] = $this->perangkat_model->count_filtered($filters);
        
        $filters['status_verifikasi'] = 'Revisi';
        $data['needs_revision'] = $this->perangkat_model->count_filtered($filters);
        
        $filters['status_verifikasi'] = 'Ditolak';
        $data['rejected'] = $this->perangkat_model->count_filtered($filters);

        unset($filters['status_verifikasi']);

        // Stats by Subject
        $this->db->select('mata_pelajaran.nama_mapel, COUNT(*) as total');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id');
        if (isset($filters['guru_id'])) {
            $this->db->where('perangkat_ajar.guru_id', $filters['guru_id']);
        }
        $this->db->where('perangkat_ajar.is_active', 1);
        $this->db->where('perangkat_ajar.is_archived', 0);
        $this->db->group_by('perangkat_ajar.mapel_id');
        $data['stats_mapel'] = $this->db->get('perangkat_ajar')->result_array();

        // Stats by Teacher
        $this->db->select('guru.nama_lengkap, COUNT(*) as total');
        $this->db->join('guru', 'guru.id = perangkat_ajar.guru_id');
        if (isset($filters['guru_id'])) {
            $this->db->where('perangkat_ajar.guru_id', $filters['guru_id']);
        }
        $this->db->where('perangkat_ajar.is_active', 1);
        $this->db->where('perangkat_ajar.is_archived', 0);
        $this->db->group_by('perangkat_ajar.guru_id');
        $data['stats_guru'] = $this->db->get('perangkat_ajar')->result_array();

        // Stats by Semester
        $this->db->select('semester, COUNT(*) as total');
        if (isset($filters['guru_id'])) {
            $this->db->where('perangkat_ajar.guru_id', $filters['guru_id']);
        }
        $this->db->where('perangkat_ajar.is_active', 1);
        $this->db->where('perangkat_ajar.is_archived', 0);
        $this->db->group_by('semester');
        $data['stats_semester'] = $this->db->get('perangkat_ajar')->result_array();

        $this->template->load('layout/main', 'perangkat_ajar/dashboard', $data);
    }

    /**
     * Sub Menu 2: Upload Perangkat Ajar
     */
    public function upload($id = NULL) {
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
        
        if ($role == 'guru' && !$guru) {
            $this->session->set_flashdata('error', 'Data guru Anda tidak terdaftar di sistem.');
            redirect('perangkat_ajar/index');
            return;
        }

        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $data['edit_mode'] = FALSE;
        $data['device'] = NULL;

        if ($id) {
            $data['edit_mode'] = TRUE;
            $data['device'] = $this->perangkat_model->get_by_id($id);
            if (!$data['device']) {
                show_404();
            }
            if ($role == 'guru' && $data['device']['guru_id'] != $guru['id']) {
                show_error('Akses ditolak: Anda hanya dapat mengubah perangkat ajar Anda sendiri.', 403);
            }
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');
            $this->form_validation->set_rules('semester', 'Semester', 'required');

            if ($this->form_validation->run() == TRUE) {
                $result = $this->perangkatService->upload_perangkat(
                    $this->input->post(NULL, TRUE),
                    $_FILES,
                    $active_tp,
                    $this->current_user['id'],
                    $id
                );

                if ($result['status']) {
                    $this->session->set_flashdata('success', $result['message']);
                    redirect('perangkat_ajar/daftar');
                    return;
                } else {
                    $this->session->set_flashdata('error', $result['message']);
                }
            }
        }

        $data['title'] = $id ? 'Edit/Revisi Perangkat Ajar' : 'Unggah Perangkat Ajar';
        $data['active_tp'] = $active_tp;
        if (in_array($role, array('admin', 'superadmin'))) {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
            $data['list_guru'] = $this->master_model->get_all_guru();
        } else {
            $data['list_kelas'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id']);
            $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
            $data['list_guru'] = array($guru);
        }

        // List Rencana Pelaksanaan for multi-select dropdown
        $this->db->select('rencana_pelaksanaan.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = rencana_pelaksanaan.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = rencana_pelaksanaan.kelas_id', 'left');
        if ($role == 'guru' && $guru) {
            $this->db->where('rencana_pelaksanaan.guru_id', $guru['id']);
        }
        $this->db->order_by('rencana_pelaksanaan.id', 'DESC');
        $data['list_rencana'] = $this->db->get('rencana_pelaksanaan')->result_array();

        $this->template->load('layout/main', 'perangkat_ajar/upload', $data);
    }

    /**
     * Sub Menu 3: Daftar Perangkat Ajar
     */
    public function daftar() {
        $data['title'] = 'Daftar Perangkat Ajar';
        $role = $this->current_user['role_code'];
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        if (in_array($role, array('admin', 'superadmin', 'waka', 'kamad'))) {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
            $data['list_guru'] = $this->master_model->get_all_guru();
        } else {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            $data['list_kelas'] = $guru ? $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id']) : array();
            $data['list_mapel'] = $guru ? $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']) : array();
            $data['list_guru'] = $guru ? array($guru) : array();
        }

        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();

        $this->template->load('layout/main', 'perangkat_ajar/daftar', $data);
    }

    public function get_daftar_ajax() {
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        $params = $this->input->post(NULL, TRUE);
        $filters = array(
            'kelas_id' => $this->input->post('kelas_id', TRUE),
            'mapel_id' => $this->input->post('mapel_id', TRUE),
            'guru_id' => $this->input->post('guru_id', TRUE),
            'tahun_pelajaran_id' => $this->input->post('tahun_pelajaran_id', TRUE),
            'semester' => $this->input->post('semester', TRUE),
            'status_verifikasi' => $this->input->post('status_verifikasi', TRUE),
            'is_active' => 1,
            'is_archived' => 0
        );

        if ($role == 'guru' && $guru) {
            $filters['guru_id'] = $guru['id'];
        }

        $list = $this->perangkat_model->get_datatables($params, $filters);
        $total_filtered = $this->perangkat_model->count_datatables_filtered($params, $filters);
        $total_all = $this->perangkat_model->count_filtered($filters);

        $data = array();

        foreach ($list as $item) {
            $row = array();
            $row[] = $item['jenis_perangkat'];
            $row[] = $item['nama_mapel'];
            $row[] = $item['nama_kelas'];
            $row[] = $item['nama_guru'];
            $row[] = $item['semester'] . ' (Pertemuan ' . $item['pertemuan_ke'] . ')';
            $row[] = 'v' . $item['version'];
            
            $status_class = 'bg-secondary';
            if ($item['status_verifikasi'] == 'Disetujui') $status_class = 'bg-success';
            elseif ($item['status_verifikasi'] == 'Revisi') $status_class = 'bg-warning';
            elseif ($item['status_verifikasi'] == 'Ditolak') $status_class = 'bg-danger';
            elseif ($item['status_verifikasi'] == 'Draft') $status_class = 'bg-info';
            
            $row[] = '<span class="badge ' . $status_class . '">' . $item['status_verifikasi'] . '</span>';
            
            $actions = '<div class="btn-list flex-nowrap">';
            $actions .= '<a href="' . base_url('perangkat_ajar/detail/' . $item['id']) . '" class="btn btn-sm btn-icon btn-outline-info" title="Detail"><i class="ti ti-eye"></i></a>';
            
            if ($item['file_path']) {
                $actions .= '<a href="' . base_url('perangkat_ajar/download/' . $item['id']) . '" class="btn btn-sm btn-icon btn-outline-primary" title="Unduh"><i class="ti ti-download"></i></a>';
            }
            
            if (in_array($role, array('admin', 'superadmin', 'waka', 'kamad'))) {
                $actions .= '<a href="' . base_url('perangkat_ajar/verifikasi/' . $item['id']) . '" class="btn btn-sm btn-icon btn-outline-success" title="Verifikasi"><i class="ti ti-checkbox"></i></a>';
            }
            
            if (in_array($role, array('admin', 'superadmin', 'guru')) && ($item['status_verifikasi'] == 'Draft' || $item['status_verifikasi'] == 'Revisi' || $role != 'guru')) {
                $actions .= '<a href="' . base_url('perangkat_ajar/upload/' . $item['id']) . '" class="btn btn-sm btn-icon btn-outline-warning" title="Revisi/Edit"><i class="ti ti-edit"></i></a>';
                $actions .= '<a href="' . base_url('perangkat_ajar/do_archive/' . $item['id']) . '" class="btn btn-sm btn-icon btn-outline-danger" title="Arsipkan" onclick="return confirm(\'Arsipkan perangkat ajar ini?\')"><i class="ti ti-archive"></i></a>';
            }
            $actions .= '</div>';
            
            $row[] = $actions;
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($params['draw']) ? intval($params['draw']) : 0,
            "recordsTotal" => $total_all,
            "recordsFiltered" => $total_filtered,
            "data" => $data
        );

        echo json_encode($output);
        exit;
    }

    /**
     * Sub Menu 4: Detail Perangkat Ajar
     */
    public function detail($id) {
        $device = $this->perangkat_model->get_by_id($id);
        if (!$device) {
            show_404();
        }

        $data['title'] = 'Detail Perangkat Ajar';
        $data['d'] = $device;
        $data['history'] = $this->perangkat_model->get_version_history($id);

        $this->template->load('layout/main', 'perangkat_ajar/detail', $data);
    }

    /**
     * Sub Menu 5: Riwayat Revisi
     */
    public function revisi($id = NULL) {
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        if ($id) {
            $device = $this->perangkat_model->get_by_id($id);
            if (!$device) show_404();
            
            if ($role == 'guru' && $device['guru_id'] != $guru['id']) {
                show_error('Akses ditolak.', 403);
            }

            $data['title'] = 'Riwayat Versi Perangkat Ajar';
            $data['d'] = $device;
            $data['history'] = $this->perangkat_model->get_version_history($id);
            
            $this->template->load('layout/main', 'perangkat_ajar/detail', $data);
        } else {
            $data['title'] = 'Daftar Riwayat Perubahan Perangkat';
            
            $filters = array();
            if ($role == 'guru' && $guru) {
                $filters['guru_id'] = $guru['id'];
            }
            
            $data['revisions'] = $this->perangkat_model->get_devices_with_revisions($filters);
            $this->template->load('layout/main', 'perangkat_ajar/revisi', $data);
        }
    }

    /**
     * Sub Menu 6: Verifikasi Perangkat Ajar
     */
    public function verifikasi($id = NULL) {
        $role = $this->current_user['role_code'];
        if (!in_array($role, array('admin', 'superadmin', 'waka', 'kamad'))) {
            show_error('Akses ditolak: Hanya Admin, Waka Kurikulum, atau Kepala Madrasah yang dapat mengakses halaman verifikasi.', 403);
        }

        if ($id) {
            $device = $this->perangkat_model->get_by_id($id);
            if (!$device) show_404();

            if ($this->input->post()) {
                $status = $this->input->post('status_verifikasi', TRUE);
                $catatan = $this->input->post('catatan_revisi', TRUE);
                
                $this->db->trans_begin();
                $this->db->where('id', $id);
                $this->db->update('perangkat_ajar', array(
                    'status_verifikasi' => $status,
                    'catatan_revisi' => $catatan,
                    'verified_by' => $this->current_user['id'],
                    'verified_at' => date('Y-m-d H:i:s')
                ));

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Gagal memproses verifikasi.');
                } else {
                    $this->db->trans_commit();
                    
                    // Clear search caches
                    $this->perangkatService->clear_device_cache($device['tahun_pelajaran_id'], $device['semester'], $device['mapel_id'], $device['guru_id'], $device['kelas_id'], $device['pertemuan_ke']);

                    $this->CI = &get_instance(); // Load loader lib in controller explicitly
                    $this->logger_lib->log('VERIFY_PERANGKAT', 'Memproses Verifikasi Perangkat ID: ' . $id . ' -> Status: ' . $status);
                    $this->session->set_flashdata('success', 'Status verifikasi perangkat ajar berhasil diperbarui.');
                }
                redirect('perangkat_ajar/verifikasi');
                return;
            }

            $data['title'] = 'Proses Verifikasi Perangkat Ajar';
            $data['d'] = $device;
            $data['history'] = $this->perangkat_model->get_version_history($id);
            
            $this->template->load('layout/main', 'perangkat_ajar/verifikasi_form', $data);
        } else {
            $data['title'] = 'Daftar Verifikasi Perangkat Ajar';
            
            $filters = array(
                'is_active' => 1,
                'is_archived' => 0,
                'status_verifikasi' => 'Menunggu Verifikasi'
            );
            
            $data['pending_list'] = $this->perangkat_model->get_all_with_relations($filters);
            $this->template->load('layout/main', 'perangkat_ajar/verifikasi', $data);
        }
    }

    /**
     * Sub Menu 7: Arsip Perangkat Ajar
     */
    public function arsip() {
        $data['title'] = 'Arsip Perangkat Ajar';
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        $filters = array('is_active' => 1, 'is_archived' => 1);
        if ($role == 'guru' && $guru) {
            $filters['guru_id'] = $guru['id'];
        }

        $data['list'] = $this->perangkat_model->get_all_with_relations($filters);
        $this->template->load('layout/main', 'perangkat_ajar/arsip', $data);
    }

    public function do_archive($id) {
        $device = $this->perangkat_model->get_by_id($id);
        if (!$device) show_404();

        $this->db->where('id', $id);
        $this->db->update('perangkat_ajar', array('is_archived' => 1));
        
        $this->perangkatService->clear_device_cache($device['tahun_pelajaran_id'], $device['semester'], $device['mapel_id'], $device['guru_id'], $device['kelas_id'], $device['pertemuan_ke']);

        $this->logger_lib->log('ARCHIVE_PERANGKAT', 'Mengarsipkan Perangkat ID: ' . $id);
        $this->session->set_flashdata('success', 'Perangkat Ajar berhasil dipindahkan ke Arsip.');
        redirect('perangkat_ajar/daftar');
    }

    public function do_restore($id) {
        $device = $this->perangkat_model->get_by_id($id);
        if (!$device) show_404();

        $this->db->where('id', $id);
        $this->db->update('perangkat_ajar', array('is_archived' => 0));

        $this->perangkatService->clear_device_cache($device['tahun_pelajaran_id'], $device['semester'], $device['mapel_id'], $device['guru_id'], $device['kelas_id'], $device['pertemuan_ke']);

        $this->logger_lib->log('RESTORE_PERANGKAT', 'Mengembalikan Perangkat ID: ' . $id);
        $this->session->set_flashdata('success', 'Perangkat Ajar berhasil dikembalikan ke Daftar aktif.');
        redirect('perangkat_ajar/arsip');
    }

    public function download($id) {
        $device = $this->perangkat_model->get_by_id($id);
        if (!$device || !$device['file_path']) {
            show_404();
        }

        $file = './' . $device['file_path'];
        if (file_exists($file)) {
            $this->load->helper('download');
            force_download($file, NULL);
        } else {
            $this->session->set_flashdata('error', 'File tidak ditemukan di server.');
            redirect('perangkat_ajar/daftar');
        }
    }

    public function export_report($type = 'pdf') {
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'guru_id' => $this->input->get('guru_id', TRUE),
            'tahun_pelajaran_id' => $active_tp['id'],
            'semester' => $this->input->get('semester', TRUE),
            'status_verifikasi' => $this->input->get('status_verifikasi', TRUE),
            'is_active' => 1,
            'is_archived' => 0
        );

        if ($role == 'guru' && $guru) {
            $filters['guru_id'] = $guru['id'];
        }

        $list = $this->perangkat_model->get_all_with_relations($filters);

        $selected_kelas = $filters['kelas_id'] ? $this->db->get_where('kelas', array('id' => $filters['kelas_id']))->row_array() : NULL;
        $selected_mapel = $filters['mapel_id'] ? $this->db->get_where('mata_pelajaran', array('id' => $filters['mapel_id']))->row_array() : NULL;
        $selected_guru = $filters['guru_id'] ? $this->db->get_where('guru', array('id' => $filters['guru_id']))->row_array() : NULL;

        $data['list'] = $list;
        $data['active_tp'] = $active_tp;
        $data['selected_kelas'] = $selected_kelas;
        $data['selected_mapel'] = $selected_mapel;
        $data['selected_guru'] = $selected_guru;
        $data['filters'] = $filters;

        $settings = $this->db->get('system_settings')->result_array();
        $settings_map = array();
        foreach ($settings as $s) {
            $settings_map[$s['setting_key']] = $s['setting_value'];
        }
        $data['settings'] = $settings_map;

        if ($type == 'pdf') {
            $data['title'] = 'Laporan Dokumen Perangkat Ajar';
            $this->laporanService->render_pdf('perangkat_ajar/pdf_report', $data, 'laporan-perangkat-ajar-' . date('Ymd') . '.pdf', 'landscape');
        } else {
            // Excel Export
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'LAPORAN REKAPITULASI DOKUMEN PERANGKAT AJAR GURU');
            $sheet->setCellValue('A2', 'Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');
            $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d M Y H:i'));

            if ($selected_kelas) $sheet->setCellValue('A4', 'Kelas: ' . $selected_kelas['nama_kelas']);
            if ($selected_mapel) $sheet->setCellValue('C4', 'Mata Pelajaran: ' . $selected_mapel['nama_mapel']);
            if ($selected_guru) $sheet->setCellValue('E4', 'Guru Pengampu: ' . $selected_guru['nama_lengkap']);

            $headers = array('No', 'Jenis Perangkat', 'Mata Pelajaran', 'Kelas', 'Guru Pengampu', 'Semester / Pertemuan', 'Versi', 'Status Verifikasi', 'Tanggal Unggah');
            $col = 'A';
            foreach ($headers as $h) {
                $sheet->setCellValue($col . '6', $h);
                $sheet->getStyle($col . '6')->getFont()->setBold(true);
                $col++;
            }

            $row_index = 7;
            $no = 1;
            foreach ($list as $item) {
                $sheet->setCellValue('A' . $row_index, $no++);
                $sheet->setCellValue('B' . $row_index, $item['jenis_perangkat']);
                $sheet->setCellValue('C' . $row_index, $item['nama_mapel']);
                $sheet->setCellValue('D' . $row_index, $item['nama_kelas']);
                $sheet->setCellValue('E' . $row_index, $item['nama_guru']);
                $sheet->setCellValue('F' . $row_index, $item['semester'] . ' (Pertemuan ' . $item['pertemuan_ke'] . ')');
                $sheet->setCellValue('G' . $row_index, 'v' . $item['version']);
                $sheet->setCellValue('H' . $row_index, $item['status_verifikasi']);
                $sheet->setCellValue('I' . $row_index, date('d-m-Y H:i', strtotime($item['created_at'])));
                $row_index++;
            }

            foreach (range('A', 'I') as $c_col) {
                $sheet->getColumnDimension($c_col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'Laporan_Perangkat_Ajar_' . date('Ymd') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            $writer->save('php://output');
            exit;
        }
    }

    /**
     * Unduh Template Excel Rencana Pelaksanaan & Detail Pembelajaran
     */
    /**
     * Unduh Template Excel Rencana Pelaksanaan & Detail Pembelajaran
     */
    public function download_template_rencana() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'TEMPLATE RENCANA PELAKSANAAN & DETAIL PEMBELAJARAN');
        $sheet->setCellValue('A2', 'Isi data rencana pelaksanaan pada baris ke-5 dan seterusnya. Jangan mengubah baris 4 (Header).');

        $headers = array(
            'Elemen Mapel', 
            'Materi Pembelajaran / Pokok Bahasan', 
            'Sub Materi Pembelajaran', 
            'Capaian Pembelajaran (CP)', 
            'Tujuan Pembelajaran (TP)', 
            'Metode Pembelajaran', 
            'Model Pembelajaran', 
            'Media Pembelajaran', 
            'Sumber Belajar', 
            'Bentuk Penilaian / Asesmen'
        );

        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '4', $h);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $col++;
        }

        // Example row
        $sheet->setCellValue('A5', 'Pemahaman Al-Qur\'an');
        $sheet->setCellValue('B5', 'Hukum Tajwid & Bacaan Al-Qur\'an');
        $sheet->setCellValue('C5', 'Hukum Nun Mati dan Tanwin');
        $sheet->setCellValue('D5', 'Peserta didik mampu menerapkan hukum tajwid dalam membaca Al-Qur\'an secara tartil.');
        $sheet->setCellValue('E5', 'Memahami dan mendemonstrasikan bacaan tajwid nun mati dan tanwin.');
        $sheet->setCellValue('F5', 'Ceramah, Diskusi Kelompok, Drill');
        $sheet->setCellValue('G5', 'Problem Based Learning (PBL)');
        $sheet->setCellValue('H5', 'Mushaf Al-Qur\'an, LCD Proyektor, Slide PPT');
        $sheet->setCellValue('I5', 'Buku Al-Qur\'an Hadis Kelas X Kemag');
        $sheet->setCellValue('J5', 'Observasi Sikap, Tes Praktik Bacaan, Tes Tertulis');

        foreach (range('A', 'J') as $c_col) {
            $sheet->getColumnDimension($c_col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Template_Rencana_Pelaksanaan_Pembelajaran.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    /**
     * AJAX Endpoint: Baca Berkas Excel Rencana Pelaksanaan & Simpan ke DB / Kembalikan JSON Form
     */
    public function import_excel_rencana_ajax() {
        @ini_set('display_errors', 0);
        @error_reporting(0);

        if (empty($_FILES['file_excel']['tmp_name'])) {
            while (ob_get_level() > 0) { @ob_end_clean(); }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('success' => false, 'message' => 'Tidak ada file Excel yang diunggah.'));
            exit;
        }

        try {
            $role = $this->current_user['role_code'];
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            $active_tp = $this->master_model->get_active_tahun_pelajaran();

            $mapel_id = $this->input->post('mapel_id', TRUE);
            $guru_id = in_array($role, array('admin', 'superadmin')) ? $this->input->post('guru_id', TRUE) : ($guru ? $guru['id'] : 0);
            $kelas_ids = $this->input->post('kelas_ids', TRUE);
            if (!is_array($kelas_ids)) {
                $kelas_ids = array();
            }
            $primary_kelas_id = !empty($kelas_ids) ? $kelas_ids[0] : NULL;

            $tmp = $_FILES['file_excel']['tmp_name'];
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($tmp);
            $spreadsheet = $reader->load($tmp);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Extract valid rows starting from row index 4 (baris 5 Excel)
            $valid_rows = array();
            for ($i = 4; $i < count($rows); $i++) {
                if (!empty(trim((string)($rows[$i][0] ?? ''))) || !empty(trim((string)($rows[$i][1] ?? ''))) || !empty(trim((string)($rows[$i][4] ?? '')))) {
                    $valid_rows[] = $rows[$i];
                }
            }

            if (empty($valid_rows)) {
                while (ob_get_level() > 0) { @ob_end_clean(); }
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('success' => false, 'message' => 'Tidak ditemukan data baris rencana pada file Excel (pastikan diisi mulai baris 5).'));
                exit;
            }

            // If mapel_id, primary_kelas_id, and guru_id are all selected, auto-save to database!
            if (!empty($mapel_id) && !empty($primary_kelas_id) && !empty($guru_id)) {
                $inserted_count = 0;
                foreach ($valid_rows as $idx => $r) {
                    $insert_data = array(
                        'guru_id'              => $guru_id,
                        'mapel_id'             => $mapel_id,
                        'kelas_id'             => $primary_kelas_id,
                        'kelas_ids'            => json_encode(array_values(array_map('intval', $kelas_ids))),
                        'tahun_pelajaran_id'   => $active_tp['id'],
                        'semester'             => $active_tp['semester'],
                        'pertemuan_ke'         => 1,
                        'elemen'               => trim((string)($r[0] ?? '')),
                        'materi_pembelajaran'  => trim((string)($r[1] ?? '')),
                        'sub_materi'           => trim((string)($r[2] ?? '')),
                        'capaian_pembelajaran' => trim((string)($r[3] ?? '')),
                        'tujuan_pembelajaran'  => trim((string)($r[4] ?? '')),
                        'metode_pembelajaran'  => trim((string)($r[5] ?? '')),
                        'model_pembelajaran'   => trim((string)($r[6] ?? '')),
                        'media_pembelajaran'   => trim((string)($r[7] ?? '')),
                        'sumber_belajar'       => trim((string)($r[8] ?? '')),
                        'bentuk_penilaian'     => trim((string)($r[9] ?? '')),
                        'created_at'           => date('Y-m-d H:i:s'),
                        'updated_at'           => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('rencana_pelaksanaan', $insert_data);
                    $inserted_count++;
                }

                $this->session->set_flashdata('success', "🎉 Berhasil mengimpor $inserted_count data Rencana Pelaksanaan dari Excel ke database!");

                while (ob_get_level() > 0) { @ob_end_clean(); }
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array(
                    'success' => true, 
                    'auto_saved' => true, 
                    'count' => $inserted_count, 
                    'message' => "Berhasil mengimpor $inserted_count data Rencana Pelaksanaan langsung ke database!"
                ));
                exit;
            }

            // Fallback: pre-fill form fields for user to select Mapel & Kelas and submit manually
            $target_row = $valid_rows[0];
            $data = array(
                'elemen'               => trim((string)($target_row[0] ?? '')),
                'materi_pembelajaran'  => trim((string)($target_row[1] ?? '')),
                'sub_materi'           => trim((string)($target_row[2] ?? '')),
                'capaian_pembelajaran' => trim((string)($target_row[3] ?? '')),
                'tujuan_pembelajaran'  => trim((string)($target_row[4] ?? '')),
                'metode_pembelajaran'  => trim((string)($target_row[5] ?? '')),
                'model_pembelajaran'   => trim((string)($target_row[6] ?? '')),
                'media_pembelajaran'   => trim((string)($target_row[7] ?? '')),
                'sumber_belajar'       => trim((string)($target_row[8] ?? '')),
                'bentuk_penilaian'     => trim((string)($target_row[9] ?? ''))
            );

            while (ob_get_level() > 0) { @ob_end_clean(); }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array(
                'success' => true, 
                'auto_saved' => false, 
                'data' => $data, 
                'message' => 'Data Excel berhasil diisikan ke form. Silakan tentukan Mata Pelajaran & Kelas, lalu klik "Simpan Rencana Pelaksanaan".'
            ));
            exit;

        } catch (Exception $e) {
            while (ob_get_level() > 0) { @ob_end_clean(); }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('success' => false, 'message' => 'Gagal membaca file Excel: ' . $e->getMessage()));
            exit;
        }
    }

    /**
     * Sub Menu: Kelola Rencana Pelaksanaan Pembelajaran
     */
    public function rencana($id = NULL) {
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
        
        if ($role == 'guru' && !$guru) {
            $this->session->set_flashdata('error', 'Data guru Anda tidak terdaftar di sistem.');
            redirect('perangkat_ajar/index');
            return;
        }

        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $data['edit_mode'] = FALSE;
        $data['edit_item'] = NULL;

        if ($id) {
            $data['edit_mode'] = TRUE;
            $data['edit_item'] = $this->db->get_where('rencana_pelaksanaan', array('id' => $id))->row_array();
            if (!$data['edit_item']) {
                show_404();
            }
            if ($role == 'guru' && $data['edit_item']['guru_id'] != $guru['id']) {
                show_error('Akses ditolak: Anda hanya dapat mengubah rencana pelaksanaan Anda sendiri.', 403);
            }
        }

        $data['title'] = $id ? 'Edit Rencana Pelaksanaan' : 'Kelola Rencana Pelaksanaan Pembelajaran';
        $data['active_tp'] = $active_tp;

        if (in_array($role, array('admin', 'superadmin'))) {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
            $data['list_guru'] = $this->master_model->get_all_guru();
        } else {
            $data['list_kelas'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id']);
            $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
            $data['list_guru'] = array($guru);
        }

        // Get list of existing Rencana Pelaksanaan
        $this->db->select('rencana_pelaksanaan.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = rencana_pelaksanaan.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = rencana_pelaksanaan.kelas_id', 'left');
        if ($role == 'guru' && $guru) {
            $this->db->where('rencana_pelaksanaan.guru_id', $guru['id']);
        }
        $this->db->order_by('rencana_pelaksanaan.id', 'DESC');
        $data['rencana_list'] = $this->db->get('rencana_pelaksanaan')->result_array();

        $this->template->load('layout/main', 'perangkat_ajar/rencana', $data);
    }

    public function save_rencana() {
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $id = $this->input->post('id', TRUE);
        $guru_id = in_array($role, array('admin', 'superadmin')) ? $this->input->post('guru_id', TRUE) : ($guru ? $guru['id'] : 0);

        $kelas_ids = $this->input->post('kelas_ids', TRUE);
        if (!is_array($kelas_ids)) {
            $kelas_ids = array();
        }
        $primary_kelas_id = !empty($kelas_ids) ? $kelas_ids[0] : $this->input->post('kelas_id', TRUE);

        $format_array_input = function($input) {
            if (is_array($input)) {
                return implode(', ', array_filter(array_map('trim', $input)));
            }
            return trim((string)$input);
        };

        $data = array(
            'guru_id'              => $guru_id,
            'mapel_id'             => $this->input->post('mapel_id', TRUE),
            'kelas_id'             => $primary_kelas_id,
            'kelas_ids'            => json_encode(array_values(array_map('intval', $kelas_ids))),
            'tahun_pelajaran_id'   => $active_tp['id'],
            'semester'             => $active_tp['semester'],
            'pertemuan_ke'         => 1,
            'elemen'               => $this->input->post('elemen', TRUE),
            'materi_pembelajaran'  => $this->input->post('materi_pembelajaran', TRUE),
            'sub_materi'           => $this->input->post('sub_materi', TRUE),
            'capaian_pembelajaran' => $this->input->post('capaian_pembelajaran', TRUE),
            'tujuan_pembelajaran'  => $this->input->post('tujuan_pembelajaran', TRUE),
            'metode_pembelajaran'  => $format_array_input($this->input->post('metode_pembelajaran')),
            'model_pembelajaran'   => $format_array_input($this->input->post('model_pembelajaran')),
            'media_pembelajaran'   => $format_array_input($this->input->post('media_pembelajaran')),
            'sumber_belajar'       => $format_array_input($this->input->post('sumber_belajar')),
            'bentuk_penilaian'     => $format_array_input($this->input->post('bentuk_penilaian')),
            'updated_at'           => date('Y-m-d H:i:s')
        );

        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('rencana_pelaksanaan', $data);
            $this->session->set_flashdata('success', 'Rencana Pelaksanaan Pembelajaran berhasil diperbarui.');
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('rencana_pelaksanaan', $data);
            $this->session->set_flashdata('success', 'Rencana Pelaksanaan Pembelajaran berhasil disimpan.');
        }

        redirect('perangkat_ajar/rencana');
    }

    public function delete_rencana($id) {
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        $item = $this->db->get_where('rencana_pelaksanaan', array('id' => $id))->row_array();
        if (!$item) {
            show_404();
        }

        if ($role == 'guru' && $item['guru_id'] != $guru['id']) {
            show_error('Akses ditolak.', 403);
        }

        $this->db->where('id', $id);
        $this->db->delete('rencana_pelaksanaan');

        $this->session->set_flashdata('success', 'Rencana Pelaksanaan Pembelajaran berhasil dihapus.');
        redirect('perangkat_ajar/rencana');
    }

    /**
     * AJAX Endpoint: Get list of Rencana Pelaksanaan for Jurnal Add Dropdown
     */
    public function get_rencana_list_ajax() {
        @ini_set('display_errors', 0);
        @error_reporting(0);

        $mapel_id = $this->input->get_post('mapel_id', TRUE);
        $guru_id  = $this->input->get_post('guru_id', TRUE);
        $kelas_id = $this->input->get_post('kelas_id', TRUE);

        $this->db->select('rencana_pelaksanaan.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = rencana_pelaksanaan.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = rencana_pelaksanaan.kelas_id', 'left');

        if (!empty($mapel_id)) {
            $this->db->where('rencana_pelaksanaan.mapel_id', $mapel_id);
        }
        if (!empty($guru_id)) {
            $this->db->where('rencana_pelaksanaan.guru_id', $guru_id);
        }
        if (!empty($kelas_id)) {
            $this->db->group_start();
            $this->db->where('rencana_pelaksanaan.kelas_id', $kelas_id);
            $this->db->or_like('rencana_pelaksanaan.kelas_ids', '"' . $kelas_id . '"');
            $this->db->or_like('rencana_pelaksanaan.kelas_ids', $kelas_id);
            $this->db->group_end();
        }

        $this->db->order_by('rencana_pelaksanaan.id', 'DESC');
        $list = $this->db->get('rencana_pelaksanaan')->result_array();

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('success' => true, 'data' => $list));
        exit;
    }
}

