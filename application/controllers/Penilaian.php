<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Penilaian extends Guru_Controller {

    protected $nilaiService;

    public function __construct() {
        parent::__construct();
        $this->nilaiService = new NilaiService();
    }

    public function index() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        
        $categories = $this->penilaian_model->get_categories();
        $default_cat = !empty($categories) ? $categories[0]['kode_kategori'] : '';
        $jenis_penilaian = $this->input->get('jenis_penilaian', TRUE) ? $this->input->get('jenis_penilaian', TRUE) : $default_cat;

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        // Check mapel ownership for teachers
        if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru) {
            $allowed_mapels = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
            $allowed_mapel_ids = array_column($allowed_mapels, 'id');

            if ($mapel_id && !in_array($mapel_id, $allowed_mapel_ids)) {
                $this->session->set_flashdata('error', 'Akses ditolak: Anda hanya dapat menginput nilai akademik untuk mata pelajaran yang Anda ampu.');
                redirect('penilaian');
                return;
            }
        }

        if ($this->input->post('action') == 'save_nilai') {
            $p_kelas_id = $this->input->post('kelas_id', TRUE);
            $p_mapel_id = $this->input->post('mapel_id', TRUE);
            $p_jenis = $this->input->post('jenis_penilaian', TRUE);

            // Double check backend security
            if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru) {
                $allowed_mapels = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
                $allowed_mapel_ids = array_column($allowed_mapels, 'id');

                if (!in_array($p_mapel_id, $allowed_mapel_ids)) {
                    $this->session->set_flashdata('error', 'Gagal menyimpan: Anda tidak memiliki hak akses menginput nilai mata pelajaran ini.');
                    redirect('penilaian');
                    return;
                }
            }

            // Validate Workflow: Check if presensi_kelas exists
            $has_presensi = $this->db->where('kelas_id', $p_kelas_id)
                                      ->where('mapel_id', $p_mapel_id)
                                      ->count_all_results('presensi_kelas');
            if ($has_presensi == 0) {
                $this->session->set_flashdata('error', 'Gagal menyimpan: Presensi Kelas belum dibuat untuk mata pelajaran dan kelas ini pada tahun pelajaran ini. Silakan buat presensi kelas terlebih dahulu.');
                redirect("presensikelas?kelas_id=$p_kelas_id&mapel_id=$p_mapel_id");
                return;
            }

            $result = $this->nilaiService->save_nilai($this->input->post(NULL, TRUE), $_FILES, $active_tp, $this->current_user['id']);

            if ($result['status']) {
                $this->session->set_flashdata('success', 'Nilai siswa berhasil disimpan.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
            
            $p_nama = $this->input->post('nama_penilaian', TRUE);
            redirect("penilaian?kelas_id=$p_kelas_id&mapel_id=$p_mapel_id&jenis_penilaian=$p_jenis&nama_penilaian=" . urlencode($p_nama));
            return;
        }

        if ($this->input->post('action') == 'delete_penilaian') {
            $p_kelas_id = $this->input->post('kelas_id', TRUE);
            $p_mapel_id = $this->input->post('mapel_id', TRUE);
            $p_jenis = $this->input->post('jenis_penilaian', TRUE);
            $p_nama = $this->input->post('nama_penilaian', TRUE);

            // Double check backend security
            if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru) {
                $allowed_mapels = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
                $allowed_mapel_ids = array_column($allowed_mapels, 'id');

                if (!in_array($p_mapel_id, $allowed_mapel_ids)) {
                    $this->session->set_flashdata('error', 'Gagal menghapus: Anda tidak memiliki hak akses mata pelajaran ini.');
                    redirect('penilaian');
                    return;
                }
            }

            if ($p_kelas_id && $p_mapel_id && $p_jenis && $p_nama) {
                // Delete attached files if any
                $files = $this->db->select('file_portofolio')
                                  ->where('tahun_pelajaran_id', $active_tp['id'])
                                  ->where('kelas_id', $p_kelas_id)
                                  ->where('mapel_id', $p_mapel_id)
                                  ->where('jenis_penilaian', $p_jenis)
                                  ->where('nama_penilaian', $p_nama)
                                  ->get('penilaian_siswa')
                                  ->result_array();
                foreach ($files as $f) {
                    if (!empty($f['file_portofolio']) && file_exists('./assets/uploads/portofolio/' . $f['file_portofolio'])) {
                        @unlink('./assets/uploads/portofolio/' . $f['file_portofolio']);
                    }
                }

                $this->db->where('tahun_pelajaran_id', $active_tp['id'])
                         ->where('kelas_id', $p_kelas_id)
                         ->where('mapel_id', $p_mapel_id)
                         ->where('jenis_penilaian', $p_jenis)
                         ->where('nama_penilaian', $p_nama)
                         ->delete('penilaian_siswa');

                $this->session->set_flashdata('success', 'Data penilaian "' . html_escape($p_nama) . '" beserta seluruh nilai siswa terkait berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus penilaian: Parameter tidak lengkap.');
            }

            redirect("penilaian?kelas_id=$p_kelas_id&mapel_id=$p_mapel_id&jenis_penilaian=$p_jenis");
            return;
        }

        $data['title'] = 'Penilaian Hasil Belajar Siswa';
        $data['categories'] = $categories;
        $data['jenis_penilaian'] = $jenis_penilaian;

        if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru) {
            $data['list_kelas'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id']);
            $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
        } else {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
        }

        if ($kelas_id && $mapel_id) {
            // Validate Workflow: Check if presensi_kelas exists
            $has_presensi = $this->db->where('kelas_id', $kelas_id)
                                      ->where('mapel_id', $mapel_id)
                                      ->count_all_results('presensi_kelas');
            if ($has_presensi == 0) {
                $this->session->set_flashdata('error', 'Presensi Kelas belum dibuat untuk mata pelajaran dan kelas ini. Silakan buat presensi kelas terlebih dahulu.');
                redirect("presensikelas?kelas_id=$kelas_id&mapel_id=$mapel_id");
                return;
            }

            $data['siswa'] = $this->master_model->get_siswa_by_kelas($kelas_id);
            
            // Get unique assessment titles for the dropdown
            $data['list_nama_penilaian'] = array_column(
                $this->db->select('DISTINCT(nama_penilaian)')
                         ->where('tahun_pelajaran_id', $active_tp['id'])
                         ->where('kelas_id', $kelas_id)
                         ->where('mapel_id', $mapel_id)
                         ->where('jenis_penilaian', $jenis_penilaian)
                         ->get('penilaian_siswa')
                         ->result_array(),
                'nama_penilaian'
            );

            $selected_nama_penilaian = $this->input->get('nama_penilaian', TRUE);
            $data['selected_nama_penilaian'] = $selected_nama_penilaian;

            $existing = array();
            if ($selected_nama_penilaian && $selected_nama_penilaian !== 'new') {
                $existing = $this->penilaian_model->get_nilai_filtered(array(
                    'tahun_pelajaran_id' => $active_tp['id'],
                    'kelas_id' => $kelas_id,
                    'mapel_id' => $mapel_id,
                    'jenis_penilaian' => $jenis_penilaian,
                    'nama_penilaian' => $selected_nama_penilaian
                ));
            }
            
            $existing_map = array();
            foreach ($existing as $e) {
                // Group by student to make it easily accessible in view
                $existing_map[$e['siswa_id']] = $e;
            }
            $data['existing_nilai'] = $existing_map;
        } else {
            $data['siswa'] = array();
            $data['list_nama_penilaian'] = array();
            $data['existing_nilai'] = array();
            $data['selected_nama_penilaian'] = '';
        }

        $data['kelas_id'] = $kelas_id;
        $data['mapel_id'] = $mapel_id;
        $data['selected_kelas_id'] = $kelas_id;
        $data['selected_mapel_id'] = $mapel_id;
        $data['selected_jenis'] = $jenis_penilaian;

        $this->template->load('layout/main', 'penilaian/index', $data);
    }

    public function download_template() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $jenis_penilaian = $this->input->get('jenis_penilaian', TRUE);

        $kelas = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
        $mapel = $this->db->get_where('mata_pelajaran', array('id' => $mapel_id))->row_array();
        $siswa = $this->master_model->get_siswa_by_kelas($kelas_id);
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        if (empty($kelas) || empty($mapel)) {
            show_404();
        }

        // Get existing grades to pre-populate template
        $existing = $this->penilaian_model->get_nilai_filtered(array(
            'tahun_pelajaran_id' => $active_tp['id'],
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id,
            'jenis_penilaian' => $jenis_penilaian
        ));
        
        $existing_nilai = array();
        foreach ($existing as $e) {
            $existing_nilai[$e['siswa_id']] = $e;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'TEMPLATE IMPORT NILAI RAPOR DIGITAL MADRASAH (RDM)');
        $sheet->setCellValue('A2', 'Kelas: ' . ($kelas['nama_kelas'] ?? ''));
        $sheet->setCellValue('A3', 'Mata Pelajaran: ' . ($mapel['nama_mapel'] ?? ''));
        $sheet->setCellValue('A4', 'Kategori Penilaian: ' . html_escape(ucfirst(str_replace('_', ' ', $jenis_penilaian))));
        $sheet->setCellValue('A5', 'PENTING: Jangan mengubah kolom A (NIS) dan B (Nama Siswa)!');

        $sheet->setCellValue('A6', 'NIS');
        $sheet->setCellValue('B6', 'Nama Siswa');
        $sheet->setCellValue('C6', 'Nilai (0 - 100)');
        $sheet->setCellValue('D6', 'Catatan Evaluasi / Keterangan');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $row_index = 7;
        foreach ($siswa as $s) {
            $sheet->setCellValueExplicit('A' . $row_index, $s['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $row_index, $s['nama_lengkap']);
            
            $val = isset($existing_nilai[$s['id']]['nilai']) ? $existing_nilai[$s['id']]['nilai'] : '';
            $cat = isset($existing_nilai[$s['id']]['catatan']) ? $existing_nilai[$s['id']]['catatan'] : '';
            
            $sheet->setCellValue('C' . $row_index, $val);
            $sheet->setCellValue('D' . $row_index, $cat);
            $row_index++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Template_Nilai_' . str_replace(' ', '_', $kelas['nama_kelas'] ?? 'Kelas') . '_' . str_replace(' ', '_', $mapel['kode_mapel'] ?? 'Mapel') . '.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function import() {
        if ($this->input->post('action') == 'preview') {
            $kelas_id = $this->input->post('kelas_id', TRUE);
            $mapel_id = $this->input->post('mapel_id', TRUE);
            $jenis_penilaian = $this->input->post('jenis_penilaian', TRUE);
            $nama_penilaian = $this->input->post('nama_penilaian', TRUE);

            if (empty($_FILES['excel_file']['name'])) {
                $this->session->set_flashdata('error', 'Silakan pilih file Excel terlebih dahulu.');
                redirect("penilaian?kelas_id=$kelas_id&mapel_id=$mapel_id&jenis_penilaian=$jenis_penilaian");
                return;
            }

            if (!is_dir('./assets/uploads/excel_imports/')) {
                mkdir('./assets/uploads/excel_imports/', 0777, TRUE);
            }

            $config['upload_path']   = './assets/uploads/excel_imports/';
            $config['allowed_types'] = 'xlsx|xls';
            $config['max_size']      = 5120; // 5MB
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('excel_file')) {
                $this->session->set_flashdata('error', 'Gagal upload file: ' . $this->upload->display_errors());
                redirect("penilaian?kelas_id=$kelas_id&mapel_id=$mapel_id&jenis_penilaian=$jenis_penilaian");
                return;
            }

            $upload_data = $this->upload->data();
            $file_path = './assets/uploads/excel_imports/' . $upload_data['file_name'];

            try {
                $preview_data = $this->nilaiService->preview_import($file_path, $kelas_id);

                $data['title'] = 'Preview Import Nilai Excel';
                $data['kelas'] = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
                $data['mapel'] = $this->db->get_where('mata_pelajaran', array('id' => $mapel_id))->row_array();
                $data['jenis_penilaian'] = $jenis_penilaian;
                $data['nama_penilaian'] = $nama_penilaian;
                $data['file_name'] = $upload_data['file_name'];
                $data['import_rows'] = $preview_data['import_rows'];
                $data['errors'] = $preview_data['errors'];

                $this->template->load('layout/main', 'penilaian/preview_import', $data);
                return;

            } catch (Exception $e) {
                if (file_exists($file_path)) unlink($file_path);
                $this->session->set_flashdata('error', 'Gagal memproses file Excel: ' . $e->getMessage());
                redirect("penilaian?kelas_id=$kelas_id&mapel_id=$mapel_id&jenis_penilaian=$jenis_penilaian");
                return;
            }
        }

        if ($this->input->post('action') == 'confirm_save') {
            $kelas_id = $this->input->post('kelas_id', TRUE);
            $mapel_id = $this->input->post('mapel_id', TRUE);
            $jenis_penilaian = $this->input->post('jenis_penilaian', TRUE);
            $nama_penilaian = $this->input->post('nama_penilaian', TRUE);
            $file_name = $this->input->post('file_name', TRUE);

            $file_path = './assets/uploads/excel_imports/' . $file_name;
            if (!file_exists($file_path)) {
                $this->session->set_flashdata('error', 'File sesi import tidak ditemukan. Silakan unggah kembali.');
                redirect("penilaian?kelas_id=$kelas_id&mapel_id=$mapel_id&jenis_penilaian=$jenis_penilaian");
                return;
            }

            $active_tp = $this->master_model->get_active_tahun_pelajaran();

            $result = $this->nilaiService->execute_import(
                $file_path,
                $kelas_id,
                $mapel_id,
                $jenis_penilaian,
                $nama_penilaian,
                $active_tp,
                $this->current_user['id']
            );

            if (file_exists($file_path)) unlink($file_path);

            if ($result['status']) {
                $this->session->set_flashdata('success', 'Berhasil mengimpor ' . $result['total_imported'] . ' nilai siswa.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }

            redirect("penilaian?kelas_id=$kelas_id&mapel_id=$mapel_id&jenis_penilaian=$jenis_penilaian");
            return;
        }
    }

    public function import_history() {
        $data['title'] = 'Riwayat Import Nilai Excel';
        $data['history'] = $this->penilaian_model->get_import_history();
        $this->template->load('layout/main', 'penilaian/import_history', $data);
    }

    public function rollback($import_code) {
        $result = $this->nilaiService->rollback_import($import_code);

        if ($result['status']) {
            $this->session->set_flashdata('success', 'Berhasil membatalkan import nilai.');
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }
        redirect('penilaian/import_history');
    }

    public function rekap() {
        $data['title'] = 'Rekap Nilai Siswa';
        $role = $this->current_user['role_code'];
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'tahun_pelajaran_id' => $active_tp['id']
        );

        if (in_array($role, array('guru', 'walikelas', 'waka')) && $this->master_model->get_guru_by_user_id($this->current_user['id'])) {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            $data['list_kelas'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $active_tp['id']);
            $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
        } else {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
        }

        $data['kelas_row'] = $filters['kelas_id'] ? $this->db->get_where('kelas', array('id' => $filters['kelas_id']))->row_array() : NULL;
        $data['mapel_row'] = $filters['mapel_id'] ? $this->db->get_where('mata_pelajaran', array('id' => $filters['mapel_id']))->row_array() : NULL;
        $data['active_tp'] = $active_tp;

        if ($filters['kelas_id'] && $filters['mapel_id']) {
            $siswa = $this->master_model->get_siswa_by_kelas($filters['kelas_id']);
            $categories = $this->penilaian_model->get_categories();
            
            // Get grades matrix
            $matrix = $this->penilaian_model->get_nilai_rekap_matrix($filters);
            $rekap_map = array();
            foreach ($matrix as $m) {
                $rekap_map[$m['siswa_id']][$m['jenis_penilaian']] = $m['rata_nilai'];
            }

            $rekap = array();
            foreach ($siswa as $s) {
                $scores = array();
                $nilai_akhir = 0;
                $total_bobot_aktif = 0;
                
                foreach ($categories as $cat) {
                    $code = $cat['kode_kategori'];
                    $score = isset($rekap_map[$s['id']][$code]) ? (float)$rekap_map[$s['id']][$code] : NULL;
                    $scores[$code] = $score;
                    
                    if ($score !== NULL) {
                        $nilai_akhir += $score * ($cat['bobot'] / 100);
                        $total_bobot_aktif += ($cat['bobot'] / 100);
                    }
                }
                
                if ($total_bobot_aktif > 0) {
                    $nilai_akhir = $nilai_akhir / $total_bobot_aktif;
                } else {
                    $nilai_akhir = 0.00;
                }

                if ($nilai_akhir >= 90) {
                    $predikat = 'A';
                } elseif ($nilai_akhir >= 80) {
                    $predikat = 'B';
                } elseif ($nilai_akhir >= 70) {
                    $predikat = 'C';
                } else {
                    $predikat = 'D';
                }

                $kkm = 75.00;
                $ketuntasan = ($nilai_akhir >= $kkm) ? 'Tuntas' : 'Belum Tuntas';
                $tindak_lanjut = ($nilai_akhir >= $kkm) ? 'Pengayaan' : 'Remedial';

                $rekap[] = array(
                    'nis' => $s['nis'],
                    'nama_lengkap' => $s['nama_lengkap'],
                    'scores' => $scores,
                    'nilai_akhir' => $nilai_akhir,
                    'predikat' => $predikat,
                    'kkm' => $kkm,
                    'ketuntasan' => $ketuntasan,
                    'tindak_lanjut' => $tindak_lanjut
                );
            }

            $data['siswa'] = $siswa;
            $data['categories'] = $categories;
            $data['rekap'] = $rekap;
        } else {
            $data['siswa'] = array();
            $data['categories'] = array();
            $data['rekap'] = array();
        }

        $data['selected_kelas_id'] = $filters['kelas_id'];
        $data['selected_mapel_id'] = $filters['mapel_id'];
        $data['filters'] = $filters;
        $this->template->load('layout/main', 'penilaian/rekap', $data);
    }

    public function export_rekap_excel() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tp_id = $this->input->get('tp_id', TRUE);

        if (!$kelas_id || !$mapel_id || !$tp_id) {
            $this->session->set_flashdata('error', 'Filter tidak lengkap.');
            redirect('penilaian/rekap');
            return;
        }

        $kelas_row = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
        $mapel_row = $this->db->get_where('mata_pelajaran', array('id' => $mapel_id))->row_array();
        $active_tp = $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array();

        $siswa = $this->master_model->get_siswa_by_kelas($kelas_id);
        $categories = $this->penilaian_model->get_categories();
        
        $filters = array('kelas_id' => $kelas_id, 'mapel_id' => $mapel_id, 'tahun_pelajaran_id' => $tp_id);
        $matrix = $this->penilaian_model->get_nilai_rekap_matrix($filters);
        $rekap_map = array();
        foreach ($matrix as $m) {
            $rekap_map[$m['siswa_id']][$m['jenis_penilaian']] = $m['rata_nilai'];
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'REKAPITULASI NILAI RAPOR DIGITAL MADRASAH (RDM)');
        $sheet->setCellValue('A2', 'Kelas: ' . $kelas_row['nama_kelas'] . ' | Mata Pelajaran: ' . $mapel_row['nama_mapel']);
        $sheet->setCellValue('A3', 'Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');

        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'NIS');
        $sheet->setCellValue('C5', 'Nama Lengkap');

        $col_char = 'D';
        foreach ($categories as $cat) {
            $sheet->setCellValue($col_char . '5', str_replace('Nilai ', '', $cat['nama_kategori']));
            $col_char++;
        }

        $sheet->setCellValue($col_char++ . '5', 'Nilai Akhir');
        $sheet->setCellValue($col_char++ . '5', 'Predikat');
        $sheet->setCellValue($col_char++ . '5', 'Ketuntasan');
        $sheet->setCellValue($col_char++ . '5', 'Tindak Lanjut');

        $row_idx = 6;
        $no = 1;
        foreach ($siswa as $s) {
            $sheet->setCellValue('A' . $row_idx, $no++);
            $sheet->setCellValueExplicit('B' . $row_idx, $s['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row_idx, $s['nama_lengkap']);

            $col_char = 'D';
            $nilai_akhir = 0;
            $total_bobot_aktif = 0;
            
            foreach ($categories as $cat) {
                $code = $cat['kode_kategori'];
                $score = isset($rekap_map[$s['id']][$code]) ? (float)$rekap_map[$s['id']][$code] : NULL;
                $sheet->setCellValue($col_char . $row_idx, $score !== NULL ? $score : '-');
                $col_char++;
                
                if ($score !== NULL) {
                    $nilai_akhir += $score * ($cat['bobot'] / 100);
                    $total_bobot_aktif += ($cat['bobot'] / 100);
                }
            }

            if ($total_bobot_aktif > 0) {
                $nilai_akhir = $nilai_akhir / $total_bobot_aktif;
            } else {
                $nilai_akhir = 0.00;
            }

            if ($nilai_akhir >= 90) {
                $predikat = 'A';
            } elseif ($nilai_akhir >= 80) {
                $predikat = 'B';
            } elseif ($nilai_akhir >= 70) {
                $predikat = 'C';
            } else {
                $predikat = 'D';
            }

            $kkm = 75.00;
            $ketuntasan = ($nilai_akhir >= $kkm) ? 'Tuntas' : 'Belum Tuntas';
            $tindak_lanjut = ($nilai_akhir >= $kkm) ? 'Pengayaan' : 'Remedial';

            $sheet->setCellValue($col_char++ . $row_idx, number_format($nilai_akhir, 2));
            $sheet->setCellValue($col_char++ . $row_idx, $predikat);
            $sheet->setCellValue($col_char++ . $row_idx, $ketuntasan);
            $sheet->setCellValue($col_char++ . $row_idx, $tindak_lanjut);
            $row_idx++;
        }

        $last_col = chr(ord($col_char) - 1);
        foreach (range('A', $last_col) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap_Nilai_' . str_replace(' ', '_', $kelas_row['nama_kelas']) . '_' . str_replace(' ', '_', $mapel_row['nama_mapel']) . '.xlsx"');
        $writer->save('php://output');
        exit;
    }

    public function export_rekap_pdf() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tp_id = $this->input->get('tp_id', TRUE);

        if (!$kelas_id || !$mapel_id || !$tp_id) {
            $this->session->set_flashdata('error', 'Filter tidak lengkap.');
            redirect('penilaian/rekap');
            return;
        }

        $kelas_row = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
        
        $wali_kelas = $this->db->select('guru.*')
            ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
            ->get_where('kelas', array('kelas.id' => $kelas_id))->row_array();
            
        $mapel_row = $this->db->select('mata_pelajaran.*, guru.nama_lengkap as nama_guru, guru.nip as nip_guru')
            ->join('guru', 'guru.id = mata_pelajaran.guru_id', 'left')
            ->get_where('mata_pelajaran', array('mata_pelajaran.id' => $mapel_id))->row_array();
            
        $active_tp = $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array();

        $siswa = $this->master_model->get_siswa_by_kelas($kelas_id);
        $categories = $this->penilaian_model->get_categories();
        
        $filters = array('kelas_id' => $kelas_id, 'mapel_id' => $mapel_id, 'tahun_pelajaran_id' => $tp_id);
        $matrix = $this->penilaian_model->get_nilai_rekap_matrix($filters);
        $rekap_map = array();
        foreach ($matrix as $m) {
            $rekap_map[$m['siswa_id']][$m['jenis_penilaian']] = $m['rata_nilai'];
        }

        $rekap = array();
        foreach ($siswa as $s) {
            $scores = array();
            $nilai_akhir = 0;
            $total_bobot_aktif = 0;
            
            foreach ($categories as $cat) {
                $code = $cat['kode_kategori'];
                $score = isset($rekap_map[$s['id']][$code]) ? (float)$rekap_map[$s['id']][$code] : NULL;
                $scores[$code] = $score;
                
                if ($score !== NULL) {
                    $nilai_akhir += $score * ($cat['bobot'] / 100);
                    $total_bobot_aktif += ($cat['bobot'] / 100);
                }
            }
            
            if ($total_bobot_aktif > 0) {
                $nilai_akhir = $nilai_akhir / $total_bobot_aktif;
            } else {
                $nilai_akhir = 0.00;
            }

            if ($nilai_akhir >= 90) {
                $predikat = 'A';
            } elseif ($nilai_akhir >= 80) {
                $predikat = 'B';
            } elseif ($nilai_akhir >= 70) {
                $predikat = 'C';
            } else {
                $predikat = 'D';
            }

            $kkm = 75.00;
            $ketuntasan = ($nilai_akhir >= $kkm) ? 'Tuntas' : 'Belum Tuntas';
            $tindak_lanjut = ($nilai_akhir >= $kkm) ? 'Pengayaan' : 'Remedial';

            $rekap[] = array(
                'nis' => $s['nis'],
                'nama_lengkap' => $s['nama_lengkap'],
                'scores' => $scores,
                'nilai_akhir' => $nilai_akhir,
                'predikat' => $predikat,
                'kkm' => $kkm,
                'ketuntasan' => $ketuntasan,
                'tindak_lanjut' => $tindak_lanjut
            );
        }

        $data['kelas_row'] = $kelas_row;
        $data['wali_kelas'] = $wali_kelas;
        $data['mapel_row'] = $mapel_row;
        $data['active_tp'] = $active_tp;
        $data['categories'] = $categories;
        $data['rekap'] = $rekap;
        $data['title'] = 'Rekap Nilai RDM Kelas ' . $kelas_row['nama_kelas'];

        require_once APPPATH . 'services/LaporanService.php';
        $laporanService = new LaporanService();
        $laporanService->render_pdf('penilaian/rekap_pdf', $data, 'Rekap_Nilai_' . date('Ymd') . '.pdf', 'landscape');
        exit;
    }
}
