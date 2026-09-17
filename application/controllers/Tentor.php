<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'services/BaseService.php';
require_once APPPATH . 'services/MbfService.php';

class Tentor extends Tentor_Controller {

    protected $mbfService;
    protected $current_tentor;

    public function __construct() {
        parent::__construct();
        $this->load->model('mbf_model');
        $this->load->model('master_model');
        $this->mbfService = new MbfService();

        // Get logged in tentor record
        $user_id = $this->current_user['id'];
        $this->current_tentor = $this->mbf_model->get_tentor_by_user_id($user_id);

        if (!$this->current_tentor && !in_array($this->current_user['role_code'], array('admin', 'superadmin'))) {
            show_error('Akun Anda belum terhubung dengan data Tentor MBF. Silakan hubungi Administrator.', 403, 'Akses Ditolak');
            exit;
        }
    }

    // ========================================================
    // 1. DASHBOARD TENTOR MBF
    // ========================================================
    public function index() {
        $data['title'] = 'Dashboard Tentor MBF';
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $tp_id = $active_tp ? $active_tp['id'] : NULL;

        $data['tentor'] = $this->current_tentor;
        $data['active_tp'] = $active_tp;
        $data['stats'] = $this->mbf_model->get_tentor_dashboard_stats($tentor_id, $tp_id);

        $this->template->load('layout/main', 'tentor/dashboard', $data);
    }

    // ========================================================
    // 2. MAPEL MBF SAYA
    // ========================================================
    public function mapel() {
        $data['title'] = 'Mapel MBF Saya';
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $data['tentor'] = $this->current_tentor;
        $data['active_tp'] = $active_tp;
        $data['list_mapel'] = $this->mbf_model->get_mapel_by_tentor($tentor_id, $active_tp ? $active_tp['id'] : NULL);

        $this->template->load('layout/main', 'tentor/mapel', $data);
    }

    // ========================================================
    // 3. PESERTA MAPEL SAYA
    // ========================================================
    public function peserta() {
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $mapel_list = $this->mbf_model->get_mapel_by_tentor($tentor_id, $active_tp ? $active_tp['id'] : NULL);

        if (!$mapel_id && !empty($mapel_list)) {
            $mapel_id = $mapel_list[0]['id'];
        }

        $selected_mapel = NULL;
        $peserta_list = array();
        if ($mapel_id) {
            $selected_mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
            // Verify tentor owns this mapel
            if ($selected_mapel && $selected_mapel['tentor_id'] == $tentor_id) {
                $peserta_list = $this->mbf_model->get_peserta_by_mapel($mapel_id);
            }
        }

        $data['title'] = 'Peserta Mapel MBF Saya';
        $data['mapel_list'] = $mapel_list;
        $data['selected_mapel'] = $selected_mapel;
        $data['peserta_list'] = $peserta_list;

        $this->template->load('layout/main', 'tentor/peserta', $data);
    }

    // ========================================================
    // 4. PRESENSI SISWA MBF (TOUCH-FRIENDLY)
    // ========================================================
    public function presensi() {
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $mapel_list = $this->mbf_model->get_mapel_by_tentor($tentor_id, $active_tp ? $active_tp['id'] : NULL);

        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tanggal  = $this->input->get('tanggal', TRUE) ? $this->input->get('tanggal', TRUE) : date('Y-m-d');

        if (!$mapel_id && !empty($mapel_list)) {
            $mapel_id = $mapel_list[0]['id'];
        }

        // Handle POST Submission
        if ($this->input->method() === 'post') {
            $post_mapel_id = $this->input->post('mapel_mbf_id', TRUE);
            $post_tanggal  = $this->input->post('tanggal', TRUE);
            $catatan_hdr   = $this->input->post('catatan_header', TRUE);
            $presensi_raw  = $this->input->post('presensi'); // array: [siswa_id => status]
            $catatan_raw   = $this->input->post('catatan_siswa'); // array: [siswa_id => text]

            // Jurnal Extra Fields matching Image 2
            $pertemuan_ke      = $this->input->post('pertemuan_ke', TRUE);
            $status_sesi       = $this->input->post('status_sesi', TRUE);
            $nama_mapel_custom = $this->input->post('nama_mapel_custom', TRUE);
            $ruangan           = $this->input->post('ruangan', TRUE);
            $jam_mulai         = $this->input->post('jam_mulai', TRUE);
            $jam_selesai       = $this->input->post('jam_selesai', TRUE);
            $materi_pembahasan = $this->input->post('materi_pembahasan', TRUE);
            $catatan_tentor    = $this->input->post('catatan_tentor', TRUE);

            // Handle Photo Upload
            $foto_path = NULL;
            if (!empty($_FILES['foto_dokumentasi']['name'])) {
                if (!is_dir('./assets/uploads/mbf_jurnal/')) {
                    mkdir('./assets/uploads/mbf_jurnal/', 0777, TRUE);
                }

                $config['upload_path']   = './assets/uploads/mbf_jurnal/';
                $config['allowed_types'] = 'jpg|jpeg|png|webp';
                $config['max_size']      = 3072; // 3MB
                $config['file_name']     = 'jurnal_mbf_' . $post_mapel_id . '_' . time();

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto_dokumentasi')) {
                    $upload_data = $this->upload->data();
                    $foto_path = 'assets/uploads/mbf_jurnal/' . $upload_data['file_name'];

                    // Sync uploaded photo automatically to Google Drive
                    $this->load->helper('gdrive');
                    gdrive_sync_file($upload_data['full_path']);
                }
            }

            $jurnal_extra = array(
                'pertemuan_ke'      => $pertemuan_ke,
                'status_sesi'       => $status_sesi,
                'nama_mapel_custom' => $nama_mapel_custom,
                'ruangan'           => $ruangan,
                'jam_mulai'         => $jam_mulai,
                'jam_selesai'       => $jam_selesai,
                'materi_pembahasan' => $materi_pembahasan,
                'catatan_tentor'    => $catatan_tentor,
                'foto_dokumentasi'  => $foto_path
            );

            // Verify tentor owns this mapel
            $chk_mapel = $this->mbf_model->get_mapel_by_id($post_mapel_id);
            if (!$chk_mapel || ($chk_mapel['tentor_id'] != $tentor_id && !in_array($this->current_user['role_code'], array('admin', 'superadmin')))) {
                $this->session->set_flashdata('error', 'Akses ditolak: Mapel MBF bukan milik Anda.');
                redirect('tentor/presensi');
                return;
            }

            $presensi_batch = array();
            if (is_array($presensi_raw)) {
                foreach ($presensi_raw as $s_id => $st) {
                    $presensi_batch[] = array(
                        'siswa_id' => $s_id,
                        'status'   => $st,
                        'catatan'  => isset($catatan_raw[$s_id]) ? $catatan_raw[$s_id] : NULL
                    );
                }
            }

            $res = $this->mbf_model->save_presensi_batch($post_mapel_id, $post_tanggal, $catatan_hdr, $presensi_batch, $this->current_user['id'], $jurnal_extra);

            if ($res) {
                $this->logger_lib->log('SAVE_PRESENSI_MBF', "Menyimpan Jurnal & Presensi MBF Mapel ID: $post_mapel_id Tanggal: $post_tanggal");
                $this->session->set_flashdata('success', 'Jurnal & Presensi MBF berhasil disimpan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan Jurnal & Presensi MBF.');
            }

            redirect('tentor/presensi?mapel_id=' . $post_mapel_id . '&tanggal=' . $post_tanggal);
            return;
        }

        $selected_mapel = NULL;
        $peserta = array();
        $presensi_data = array('header' => NULL, 'details' => array());

        if ($mapel_id) {
            $selected_mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
            if ($selected_mapel && $selected_mapel['tentor_id'] == $tentor_id) {
                $peserta = $this->mbf_model->get_peserta_by_mapel($mapel_id);
                $presensi_data = $this->mbf_model->get_presensi_by_mapel_tanggal($mapel_id, $tanggal);
            }
        }

        $data['title'] = 'Presensi Siswa MBF';
        $data['mapel_list'] = $mapel_list;
        $data['selected_mapel'] = $selected_mapel;
        $data['tanggal'] = $tanggal;
        $data['peserta'] = $peserta;
        $data['presensi_header'] = $presensi_data['header'];
        $data['presensi_details'] = $presensi_data['details'];

        $this->template->load('layout/main', 'tentor/presensi', $data);
    }

    // ========================================================
    // 5. REKAP PRESENSI TENTOR
    // ========================================================
    public function rekap() {
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $mapel_id = $this->input->get('mapel_id', TRUE);
        $bulan    = $this->input->get('bulan', TRUE);

        $mapel_list = $this->mbf_model->get_mapel_by_tentor($tentor_id, $active_tp ? $active_tp['id'] : NULL);
        if (!$mapel_id && !empty($mapel_list)) {
            $mapel_id = $mapel_list[0]['id'];
        }

        $rekap_data = array();
        $selected_mapel = NULL;

        if ($mapel_id) {
            $selected_mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
            if ($selected_mapel && $selected_mapel['tentor_id'] == $tentor_id) {
                $rekap_data = $this->mbf_model->get_rekap_per_mapel($mapel_id, array('bulan' => $bulan));
            }
        }

        $data['title'] = 'Rekap Presensi MBF Saya';
        $data['mapel_list'] = $mapel_list;
        $data['selected_mapel'] = $selected_mapel;
        $data['rekap_data'] = $rekap_data;
        $data['bulan'] = $bulan;
        $data['active_tp'] = $active_tp;

        $this->template->load('layout/main', 'tentor/rekap', $data);
    }

    // ========================================================
    // 6. LAPORAN TENTOR
    // ========================================================
    public function laporan() {
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $mapel_list = $this->mbf_model->get_mapel_by_tentor($tentor_id, $active_tp ? $active_tp['id'] : NULL);

        $data['title'] = 'Laporan Presensi MBF Saya';
        $data['mapel_list'] = $mapel_list;
        $data['active_tp'] = $active_tp;

        $this->template->load('layout/main', 'tentor/laporan', $data);
    }

    public function export_pdf() {
        $mapel_id  = $this->input->get('mapel_id', TRUE);
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
        if (!$mapel || $mapel['tentor_id'] != $tentor_id) {
            show_error('Akses ditolak atau Mapel MBF tidak ditemukan.', 403);
            return;
        }

        $rekap = $this->mbf_model->get_rekap_per_mapel($mapel_id);

        $data['mapel'] = $mapel;
        $data['rekap'] = $rekap;
        $data['active_tp'] = $active_tp;
        $data['title'] = 'LAPORAN PRESENSI MBF — ' . strtoupper($mapel['nama_mapel']);
        $data['settings'] = $this->mbfService->get_report_settings();

        $this->mbfService->render_pdf('mbf/pdf_rekap_mapel', $data, 'Laporan_MBF_' . str_replace(' ', '_', $mapel['nama_mapel']) . '_' . date('Ymd') . '.pdf', 'landscape');
    }

    public function export_excel() {
        $mapel_id  = $this->input->get('mapel_id', TRUE);
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
        if (!$mapel || $mapel['tentor_id'] != $tentor_id) {
            show_error('Akses ditolak atau Mapel MBF tidak ditemukan.', 403);
            return;
        }

        $this->mbfService->generate_rekap_excel($mapel_id, array(), $active_tp);
    }

    public function print_rekap() {
        $mapel_id  = $this->input->get('mapel_id', TRUE);
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
        if (!$mapel || $mapel['tentor_id'] != $tentor_id) {
            show_error('Akses ditolak atau Mapel MBF tidak ditemukan.', 403);
            return;
        }

        $rekap = $this->mbf_model->get_rekap_per_mapel($mapel_id);

        $data['mapel'] = $mapel;
        $data['rekap'] = $rekap;
        $data['active_tp'] = $active_tp;
        $data['title'] = 'LAPORAN PRESENSI MBF';
        $data['settings'] = $this->mbfService->get_report_settings();

        $this->load->view('mbf/print_rekap', $data);
    }

    public function get_peserta_json($mapel_id) {
        $peserta = $this->mbf_model->get_peserta_by_mapel($mapel_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($peserta));
    }

    public function get_presensi_json($id) {
        $data = $this->mbf_model->get_presensi_by_id($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    // ========================================================
    // 7. PROFIL TENTOR
    // ========================================================
    public function profil() {
        $user_id = $this->current_user['id'];
        $tentor_id = $this->current_tentor ? $this->current_tentor['id'] : 0;

        if ($this->input->method() === 'post') {
            $nama_lengkap = $this->input->post('nama_lengkap', TRUE);
            $no_hp        = $this->input->post('no_hp', TRUE);
            $email        = $this->input->post('email', TRUE);
            $new_password = $this->input->post('new_password');

            $data_tentor = array(
                'nama_lengkap' => $nama_lengkap,
                'no_hp'        => $no_hp,
                'email'        => $email
            );

            $data_user = array();
            if (!empty($new_password)) {
                $data_user['password'] = $new_password;
            }

            $this->mbf_model->update_tentor($tentor_id, $data_tentor, $data_user);

            // Update session
            $session_user = $this->session->userdata('user_session');
            $session_user['full_name'] = $nama_lengkap;
            $this->session->set_userdata('user_session', $session_user);

            $this->session->set_flashdata('success', 'Profil Anda berhasil diperbarui.');
            redirect('tentor/profil');
            return;
        }

        $data['title'] = 'Profil Saya';
        $data['tentor'] = $this->mbf_model->get_tentor_by_id($tentor_id);
        $data['user'] = $this->current_user;

        $this->template->load('layout/main', 'tentor/profil', $data);
    }
}
