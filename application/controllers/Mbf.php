<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'services/BaseService.php';
require_once APPPATH . 'services/MbfService.php';

class Mbf extends Admin_Controller {

    protected $mbfService;

    public function __construct() {
        parent::__construct();
        $this->load->model('mbf_model');
        $this->load->model('master_model');
        $this->mbfService = new MbfService();
    }

    // ========================================================
    // 1. DASHBOARD MBF (ADMIN)
    // ========================================================
    public function index() {
        $data['title'] = 'Dashboard Admin MBF';
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $tp_id = $active_tp ? $active_tp['id'] : NULL;

        $data['active_tp'] = $active_tp;
        $data['stats'] = $this->mbf_model->get_admin_dashboard_stats($tp_id);
        $data['list_mapel'] = $this->mbf_model->get_all_mapel($tp_id);
        $data['list_tentor'] = $this->mbf_model->get_all_tentor();

        $this->template->load('layout/main', 'mbf/admin_dashboard', $data);
    }

    // ========================================================
    // 2. KELOLA TENTOR
    // ========================================================
    public function tentor() {
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $source_type = $this->input->post('source_type', TRUE);

            if ($source_type == 'from_guru') {
                $guru_id = $this->input->post('guru_id', TRUE);
                if (empty($guru_id)) {
                    $this->session->set_flashdata('error', 'Silakan pilih Guru dari daftar.');
                    redirect('mbf/tentor');
                    return;
                }

                $res = $this->mbf_model->save_tentor_from_guru($guru_id);
                if ($res) {
                    $this->logger_lib->log('CREATE_TENTOR', "Menambah Tentor MBF dari Data Guru ID: $guru_id");
                    $this->session->set_flashdata('success', 'Data Tentor MBF dari Guru berhasil ditambahkan.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan Tentor dari Data Guru.');
                }
                redirect('mbf/tentor');
                return;
            } else {
                $nama_lengkap = $this->input->post('nama_lengkap', TRUE);
                $nip          = $this->input->post('nip', TRUE);
                $no_hp        = $this->input->post('no_hp', TRUE);
                $email        = $this->input->post('email', TRUE);
                $username     = $this->input->post('username', TRUE);
                $password     = $this->input->post('password');

                // Form validation
                if (empty($nama_lengkap) || empty($username) || empty($password)) {
                    $this->session->set_flashdata('error', 'Nama, Username, dan Password wajib diisi.');
                    redirect('mbf/tentor');
                    return;
                }

                // Check username uniqueness
                $check_user = $this->db->get_where('users', array('username' => $username))->row_array();
                if ($check_user) {
                    $this->session->set_flashdata('error', 'Username sudah digunakan. Silakan gunakan username lain.');
                    redirect('mbf/tentor');
                    return;
                }

                $data_tentor = array(
                    'nama_lengkap' => $nama_lengkap,
                    'nip'          => $nip,
                    'no_hp'        => $no_hp,
                    'email'        => $email,
                    'is_active'    => 1
                );

                $data_user = array(
                    'username'  => $username,
                    'password'  => $password,
                    'email'     => $email,
                    'is_active' => 1
                );

                $res = $this->mbf_model->save_tentor($data_tentor, $data_user);
                if ($res) {
                    $this->logger_lib->log('CREATE_TENTOR', "Menambah Tentor MBF: $nama_lengkap ($username)");
                    $this->session->set_flashdata('success', 'Data Tentor MBF berhasil ditambahkan.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data Tentor.');
                }
                redirect('mbf/tentor');
                return;
            }

        } elseif ($action == 'edit') {
            $id           = $this->input->post('id', TRUE);
            $nama_lengkap = $this->input->post('nama_lengkap', TRUE);
            $nip          = $this->input->post('nip', TRUE);
            $no_hp        = $this->input->post('no_hp', TRUE);
            $email        = $this->input->post('email', TRUE);
            $username     = $this->input->post('username', TRUE);
            $password     = $this->input->post('password');
            $is_active    = $this->input->post('is_active', TRUE);

            $data_tentor = array(
                'nama_lengkap' => $nama_lengkap,
                'nip'          => $nip,
                'no_hp'        => $no_hp,
                'email'        => $email,
                'is_active'    => ($is_active == 1) ? 1 : 0
            );

            $data_user = array(
                'username'  => $username,
                'is_active' => ($is_active == 1) ? 1 : 0
            );
            if (!empty($password)) {
                $data_user['password'] = $password;
            }

            $res = $this->mbf_model->update_tentor($id, $data_tentor, $data_user);
            if ($res) {
                $this->logger_lib->log('UPDATE_TENTOR', "Memperbarui Tentor MBF ID: $id ($nama_lengkap)");
                $this->session->set_flashdata('success', 'Data Tentor MBF berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data Tentor.');
            }
            redirect('mbf/tentor');

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $res = $this->mbf_model->delete_tentor($id);
            if ($res) {
                $this->logger_lib->log('DELETE_TENTOR', "Menghapus Tentor MBF ID: $id");
                $this->session->set_flashdata('success', 'Data Tentor MBF berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus Tentor MBF.');
            }
            redirect('mbf/tentor');
        }

        $data['title'] = 'Kelola Tentor MBF';
        $data['list_tentor'] = $this->mbf_model->get_all_tentor();
        $data['list_guru']   = $this->mbf_model->get_all_guru_for_tentor();
        $this->template->load('layout/main', 'mbf/tentor_list', $data);
    }

    // ========================================================
    // 3. KELOLA MAPEL MBF
    // ========================================================
    public function mapel() {
        $action = $this->input->post('action', TRUE);
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        if ($action == 'add') {
            $data_insert = array(
                'kode_mapel'         => $this->input->post('kode_mapel', TRUE),
                'nama_mapel'         => $this->input->post('nama_mapel', TRUE),
                'tentor_id'          => $this->input->post('tentor_id', TRUE),
                'tahun_pelajaran_id' => $this->input->post('tahun_pelajaran_id', TRUE) ? $this->input->post('tahun_pelajaran_id', TRUE) : ($active_tp ? $active_tp['id'] : 1),
                'semester'           => $this->input->post('semester', TRUE) ? $this->input->post('semester', TRUE) : 'Ganjil',
                'status'             => 1
            );

            $id = $this->mbf_model->save_mapel($data_insert);
            if ($id) {
                $this->logger_lib->log('CREATE_MAPEL_MBF', 'Menambah Mapel MBF: ' . $data_insert['nama_mapel']);
                $this->session->set_flashdata('success', 'Mapel MBF berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan Mapel MBF.');
            }
            redirect('mbf/mapel');

        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $data_update = array(
                'kode_mapel'         => $this->input->post('kode_mapel', TRUE),
                'nama_mapel'         => $this->input->post('nama_mapel', TRUE),
                'tentor_id'          => $this->input->post('tentor_id', TRUE),
                'tahun_pelajaran_id' => $this->input->post('tahun_pelajaran_id', TRUE),
                'semester'           => $this->input->post('semester', TRUE),
                'status'             => $this->input->post('status', TRUE) ? 1 : 0
            );

            $this->mbf_model->update_mapel($id, $data_update);
            $this->logger_lib->log('UPDATE_MAPEL_MBF', "Memperbarui Mapel MBF ID: $id");
            $this->session->set_flashdata('success', 'Mapel MBF berhasil diperbarui.');
            redirect('mbf/mapel');

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $this->mbf_model->delete_mapel($id);
            $this->logger_lib->log('DELETE_MAPEL_MBF', "Menghapus Mapel MBF ID: $id");
            $this->session->set_flashdata('success', 'Mapel MBF berhasil dihapus.');
            redirect('mbf/mapel');
        }

        $data['title'] = 'Kelola Mapel MBF';
        $data['active_tp'] = $active_tp;
        $data['list_mapel'] = $this->mbf_model->get_all_mapel();
        $data['list_tentor'] = $this->mbf_model->get_all_tentor();
        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();

        $this->template->load('layout/main', 'mbf/mapel_list', $data);
    }

    // ========================================================
    // 4. KELOLA PESERTA MAPEL MBF
    // ========================================================
    public function peserta($mapel_id = NULL) {
        if (!$mapel_id) {
            $this->session->set_flashdata('error', 'Pilih Mapel MBF terlebih dahulu.');
            redirect('mbf/mapel');
            return;
        }

        $mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
        if (!$mapel) {
            $this->session->set_flashdata('error', 'Mapel MBF tidak ditemukan.');
            redirect('mbf/mapel');
            return;
        }

        // Handle POST Save Peserta
        if ($this->input->method() === 'post') {
            $siswa_ids = $this->input->post('siswa_ids');
            $res = $this->mbf_model->save_peserta_batch($mapel_id, $siswa_ids);
            if ($res) {
                $this->logger_lib->log('UPDATE_PESERTA_MBF', "Memperbarui peserta Mapel MBF: " . $mapel['nama_mapel']);
                $this->session->set_flashdata('success', 'Daftar peserta Mapel MBF berhasil disimpan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan peserta Mapel MBF.');
            }
            redirect('mbf/peserta/' . $mapel_id);
            return;
        }

        $data['title'] = 'Kelola Peserta — ' . $mapel['nama_mapel'];
        $data['mapel'] = $mapel;
        $data['list_kelas'] = $this->master_model->get_all_kelas();
        $data['enrolled_ids'] = $this->mbf_model->get_siswa_enrolled_ids($mapel_id);

        // Fetch all active students for selection
        $data['all_siswa'] = $this->db->select('siswa.*, kelas.nama_kelas')
            ->from('siswa')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->where('siswa.status_aktif', 1)
            ->order_by('kelas.nama_kelas', 'ASC')
            ->order_by('siswa.nama_lengkap', 'ASC')
            ->get()->result_array();

        $this->template->load('layout/main', 'mbf/peserta_manage', $data);
    }

    // ========================================================
    // 5. DAFTAR SISWA MBF
    // ========================================================
    public function siswa() {
        $kelas_id  = $this->input->get('kelas_id', TRUE);
        $mapel_id  = $this->input->get('mapel_id', TRUE);
        $tentor_id = $this->input->get('tentor_id', TRUE);
        $tp_id     = $this->input->get('tahun_pelajaran_id', TRUE);
        $search    = $this->input->get('search', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        if (!$tp_id && $active_tp) {
            $tp_id = $active_tp['id'];
        }

        $filters = array(
            'kelas_id'           => $kelas_id,
            'mapel_mbf_id'       => $mapel_id,
            'tentor_id'          => $tentor_id,
            'tahun_pelajaran_id' => $tp_id,
            'search'             => $search
        );

        $data['title'] = 'Daftar Siswa MBF';
        $data['filters'] = $filters;
        $data['active_tp'] = $active_tp;
        $data['list_siswa'] = $this->mbf_model->get_mbf_students_filtered($filters);
        $data['list_kelas'] = $this->master_model->get_all_kelas();
        $data['list_mapel'] = $this->mbf_model->get_all_mapel($tp_id);
        $data['list_tentor'] = $this->mbf_model->get_all_tentor();
        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();

        $this->template->load('layout/main', 'mbf/siswa_list', $data);
    }

    // ========================================================
    // 6. PRESENSI ADMIN MBF
    // ========================================================
    public function presensi() {
        if ($this->input->method() === 'post') {
            $action = $this->input->post('action', TRUE);

            if ($action == 'delete') {
                $id = $this->input->post('id', TRUE);
                $res = $this->mbf_model->delete_presensi($id);
                if ($res) {
                    if (!empty($res['foto_dokumentasi']) && file_exists('./' . $res['foto_dokumentasi'])) {
                        @unlink('./' . $res['foto_dokumentasi']);
                    }
                    $this->logger_lib->log('DELETE_PRESENSI_MBF', "Menghapus Presensi MBF ID: $id");
                    $this->session->set_flashdata('success', 'Data Presensi MBF berhasil dihapus.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menghapus data Presensi MBF.');
                }
                redirect('mbf/presensi');
                return;
            } elseif ($action == 'add' || $action == 'edit') {
                $presensi_id       = $this->input->post('id', TRUE);
                $post_mapel_id     = $this->input->post('mapel_mbf_id', TRUE);
                $post_tanggal      = $this->input->post('tanggal', TRUE);
                $catatan_hdr       = $this->input->post('catatan_header', TRUE);
                $presensi_raw      = $this->input->post('presensi');
                $catatan_raw       = $this->input->post('catatan_siswa');

                $pertemuan_ke      = $this->input->post('pertemuan_ke', TRUE);
                $status_sesi       = $this->input->post('status_sesi', TRUE);
                $nama_mapel_custom = $this->input->post('nama_mapel_custom', TRUE);
                $ruangan           = $this->input->post('ruangan', TRUE);
                $jam_mulai         = $this->input->post('jam_mulai', TRUE);
                $jam_selesai       = $this->input->post('jam_selesai', TRUE);
                $materi_pembahasan = $this->input->post('materi_pembahasan', TRUE);
                $catatan_tentor    = $this->input->post('catatan_tentor', TRUE);

                $foto_path = NULL;
                if (!empty($_FILES['foto_dokumentasi']['name'])) {
                    if (!is_dir('./assets/uploads/mbf_jurnal/')) {
                        mkdir('./assets/uploads/mbf_jurnal/', 0777, TRUE);
                    }

                    $config['upload_path']   = './assets/uploads/mbf_jurnal/';
                    $config['allowed_types'] = 'jpg|jpeg|png|webp';
                    $config['max_size']      = 3072;
                    $config['file_name']     = 'jurnal_mbf_' . $post_mapel_id . '_' . time();

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('foto_dokumentasi')) {
                        $upload_data = $this->upload->data();
                        $foto_path = 'assets/uploads/mbf_jurnal/' . $upload_data['file_name'];

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

                $res = $this->mbf_model->save_presensi_batch($post_mapel_id, $post_tanggal, $catatan_hdr, $presensi_batch, $this->current_user['id'], $jurnal_extra, $presensi_id);

                if ($res) {
                    $this->logger_lib->log('SAVE_PRESENSI_MBF', "Menyimpan Presensi MBF Mapel ID: $post_mapel_id Tanggal: $post_tanggal");
                    $this->session->set_flashdata('success', 'Data Presensi MBF berhasil disimpan.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menyimpan data Presensi MBF.');
                }

                redirect('mbf/presensi');
                return;
            }
        }

        $mapel_id  = $this->input->get('mapel_id', TRUE);
        $tentor_id = $this->input->get('tentor_id', TRUE);
        $tp_id     = $this->input->get('tahun_pelajaran_id', TRUE);
        $tgl_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tgl_seles = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        if (!$tp_id && $active_tp) {
            $tp_id = $active_tp['id'];
        }

        $filters = array(
            'mapel_mbf_id'       => $mapel_id,
            'tentor_id'          => $tentor_id,
            'tahun_pelajaran_id' => $tp_id,
            'tanggal_mulai'      => $tgl_mulai,
            'tanggal_selesai'    => $tgl_seles
        );

        $data['title'] = 'Data Presensi MBF';
        $data['filters'] = $filters;
        $data['active_tp'] = $active_tp;
        $data['logs'] = $this->mbf_model->get_presensi_filtered($filters);
        $data['list_mapel'] = $this->mbf_model->get_all_mapel($tp_id);
        $data['list_tentor'] = $this->mbf_model->get_all_tentor();
        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();

        $this->template->load('layout/main', 'mbf/presensi_admin', $data);
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
    // 7. REKAP PRESENSI MBF
    // ========================================================
    public function rekap() {
        $type      = $this->input->get('type', TRUE) ? $this->input->get('type', TRUE) : 'mapel';
        $mapel_id  = $this->input->get('mapel_id', TRUE);
        $siswa_id  = $this->input->get('siswa_id', TRUE);
        $tentor_id = $this->input->get('tentor_id', TRUE);
        $bulan     = $this->input->get('bulan', TRUE);
        $tp_id     = $this->input->get('tahun_pelajaran_id', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        if (!$tp_id && $active_tp) {
            $tp_id = $active_tp['id'];
        }

        $filters = array(
            'tahun_pelajaran_id' => $tp_id,
            'bulan'              => $bulan
        );

        $data['title'] = 'Rekapitulasi Presensi MBF';
        $data['type'] = $type;
        $data['filters'] = array_merge($filters, array(
            'mapel_id'  => $mapel_id,
            'siswa_id'  => $siswa_id,
            'tentor_id' => $tentor_id
        ));
        $data['active_tp'] = $active_tp;
        $data['list_mapel'] = $this->mbf_model->get_all_mapel($tp_id);
        $data['list_tentor'] = $this->mbf_model->get_all_tentor();
        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();
        $data['list_siswa'] = $this->master_model->get_all_siswa();

        if ($type == 'mapel' && $mapel_id) {
            $data['rekap_data'] = $this->mbf_model->get_rekap_per_mapel($mapel_id, $filters);
            $data['selected_mapel'] = $this->mbf_model->get_mapel_by_id($mapel_id);
        } elseif ($type == 'siswa' && $siswa_id) {
            $data['rekap_data'] = $this->mbf_model->get_rekap_per_siswa($siswa_id, $filters);
            $data['selected_siswa'] = $this->db->get_where('siswa', array('id' => $siswa_id))->row_array();
        } elseif ($type == 'tentor' && $tentor_id) {
            $data['rekap_data'] = $this->mbf_model->get_rekap_per_tentor($tentor_id, $filters);
            $data['selected_tentor'] = $this->mbf_model->get_tentor_by_id($tentor_id);
        } else {
            $data['rekap_data'] = array();
        }

        $this->template->load('layout/main', 'mbf/rekap_admin', $data);
    }

    // ========================================================
    // 8. LAPORAN MBF (PDF, EXCEL, PRINT)
    // ========================================================
    public function laporan() {
        $data['title'] = 'Laporan Presensi MBF';
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $data['active_tp'] = $active_tp;
        $data['list_mapel'] = $this->mbf_model->get_all_mapel($active_tp ? $active_tp['id'] : NULL);
        $data['list_tentor'] = $this->mbf_model->get_all_tentor();
        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();

        $this->template->load('layout/main', 'mbf/laporan_admin', $data);
    }

    public function export_pdf() {
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tp_id    = $this->input->get('tahun_pelajaran_id', TRUE);

        $active_tp = $tp_id ? $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array() : $this->master_model->get_active_tahun_pelajaran();
        if (!$mapel_id) {
            show_error('Pilih Mapel MBF terlebih dahulu.', 400);
            return;
        }

        $mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
        $rekap = $this->mbf_model->get_rekap_per_mapel($mapel_id);

        $data['mapel'] = $mapel;
        $data['rekap'] = $rekap;
        $data['active_tp'] = $active_tp;
        $data['title'] = 'LAPORAN PRESENSI MBF — ' . strtoupper($mapel['nama_mapel']);
        $data['settings'] = $this->mbfService->get_report_settings();

        $this->mbfService->render_pdf('mbf/pdf_rekap_mapel', $data, 'Laporan_MBF_' . str_replace(' ', '_', $mapel['nama_mapel']) . '_' . date('Ymd') . '.pdf', 'landscape');
    }

    public function export_excel() {
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tp_id    = $this->input->get('tahun_pelajaran_id', TRUE);

        $active_tp = $tp_id ? $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array() : $this->master_model->get_active_tahun_pelajaran();
        if (!$mapel_id) {
            show_error('Pilih Mapel MBF terlebih dahulu.', 400);
            return;
        }

        $this->mbfService->generate_rekap_excel($mapel_id, array(), $active_tp);
    }

    public function print_rekap() {
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tp_id    = $this->input->get('tahun_pelajaran_id', TRUE);

        $active_tp = $tp_id ? $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array() : $this->master_model->get_active_tahun_pelajaran();
        if (!$mapel_id) {
            show_error('Pilih Mapel MBF terlebih dahulu.', 400);
            return;
        }

        $mapel = $this->mbf_model->get_mapel_by_id($mapel_id);
        $rekap = $this->mbf_model->get_rekap_per_mapel($mapel_id);

        $data['mapel'] = $mapel;
        $data['rekap'] = $rekap;
        $data['active_tp'] = $active_tp;
        $data['title'] = 'LAPORAN PRESENSI MBF';
        $data['settings'] = $this->mbfService->get_report_settings();

        $this->load->view('mbf/print_rekap', $data);
    }
}
