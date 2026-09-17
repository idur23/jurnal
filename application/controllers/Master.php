<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Master extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    // --- 1. Tahun Pelajaran ---
    public function tahun_pelajaran() {
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $tahun = $this->input->post('tahun', TRUE);
            $semester = $this->input->post('semester', TRUE);
            $this->db->insert('tahun_pelajaran', array(
                'tahun' => $tahun,
                'semester' => $semester,
                'is_active' => 0
            ));
            $this->logger_lib->log('CREATE_TP', "Menambah Tahun Pelajaran $tahun ($semester)");
            $this->session->set_flashdata('success', 'Tahun Pelajaran berhasil ditambahkan.');
            redirect('master/tahun_pelajaran');

        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $tahun = $this->input->post('tahun', TRUE);
            $semester = $this->input->post('semester', TRUE);
            $this->db->where('id', $id);
            $this->db->update('tahun_pelajaran', array(
                'tahun' => $tahun,
                'semester' => $semester
            ));
            $this->logger_lib->log('UPDATE_TP', "Memperbarui Tahun Pelajaran ID: $id");
            $this->session->set_flashdata('success', 'Tahun Pelajaran berhasil diperbarui.');
            redirect('master/tahun_pelajaran');

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $tp = $this->db->get_where('tahun_pelajaran', array('id' => $id))->row_array();
            if ($tp) {
                if ($tp['is_active'] == 1) {
                    $this->session->set_flashdata('error', 'Gagal: Tahun Pelajaran yang sedang aktif tidak dapat dihapus. Aktifkan TP lain terlebih dahulu.');
                } else {
                    $this->db->where('id', $id);
                    $this->db->delete('tahun_pelajaran');
                    $this->logger_lib->log('DELETE_TP', "Menghapus Tahun Pelajaran ID: $id");
                    $this->session->set_flashdata('success', 'Tahun Pelajaran berhasil dihapus.');
                }
            }
            redirect('master/tahun_pelajaran');

        } elseif ($action == 'set_active') {
            $id = $this->input->post('id', TRUE);
            $this->master_model->set_active_tahun_pelajaran($id);
            $this->logger_lib->log('ACTIVATE_TP', "Mengaktifkan Tahun Pelajaran ID: $id");
            $this->session->set_flashdata('success', 'Status Tahun Pelajaran Aktif telah diperbarui.');
            redirect('master/tahun_pelajaran');
        }

        $data['title'] = 'Master Tahun Pelajaran';
        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();
        $this->template->load('layout/main', 'master/tahun_pelajaran', $data);
    }

    // --- 2. Data Kelas ---
    public function kelas() {
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $data_insert = array(
                'kode_kelas' => $this->input->post('kode_kelas', TRUE),
                'nama_kelas' => $this->input->post('nama_kelas', TRUE),
                'tingkat' => $this->input->post('tingkat', TRUE),
                'wali_kelas_id' => $this->input->post('wali_kelas_id', TRUE) ? $this->input->post('wali_kelas_id', TRUE) : NULL
            );
            $this->db->insert('kelas', $data_insert);
            $this->logger_lib->log('CREATE_KELAS', 'Menambah kelas: ' . $data_insert['nama_kelas']);
            $this->session->set_flashdata('success', 'Data Kelas berhasil ditambahkan.');
            redirect('master/kelas');

        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $data_update = array(
                'kode_kelas' => $this->input->post('kode_kelas', TRUE),
                'nama_kelas' => $this->input->post('nama_kelas', TRUE),
                'tingkat' => $this->input->post('tingkat', TRUE),
                'wali_kelas_id' => $this->input->post('wali_kelas_id', TRUE) ? $this->input->post('wali_kelas_id', TRUE) : NULL
            );
            $this->db->where('id', $id);
            $this->db->update('kelas', $data_update);
            $this->logger_lib->log('UPDATE_KELAS', 'Memperbarui kelas ID: ' . $id);
            $this->session->set_flashdata('success', 'Data Kelas berhasil diperbarui.');
            redirect('master/kelas');

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $this->db->where('id', $id);
            $this->db->delete('kelas');
            $this->logger_lib->log('DELETE_KELAS', 'Menghapus kelas ID: ' . $id);
            $this->session->set_flashdata('success', 'Data Kelas berhasil dihapus.');
            redirect('master/kelas');
        }

        $data['title'] = 'Master Data Kelas';
        $data['list_kelas'] = $this->master_model->get_all_kelas();
        $data['list_guru'] = $this->master_model->get_all_guru();
        $this->template->load('layout/main', 'master/kelas', $data);
    }

    // --- 3. Mata Pelajaran ---
    public function mapel() {
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $kelas_ids = $this->input->post('kelas_ids', TRUE);
            $first_kelas_id = (!empty($kelas_ids) && is_array($kelas_ids)) ? $kelas_ids[0] : NULL;

            $data_insert = array(
                'kode_mapel' => $this->input->post('kode_mapel', TRUE),
                'nama_mapel' => $this->input->post('nama_mapel', TRUE),
                'kelompok' => $this->input->post('kelompok', TRUE),
                'kkm' => $this->input->post('kkm', TRUE),
                'guru_id' => $this->input->post('guru_id', TRUE) ? $this->input->post('guru_id', TRUE) : NULL,
                'kelas_id' => $first_kelas_id,
                'semester' => $this->input->post('semester', TRUE),
                'tahun_pelajaran_id' => $this->input->post('tahun_pelajaran_id', TRUE) ? $this->input->post('tahun_pelajaran_id', TRUE) : NULL,
                'status' => $this->input->post('status', TRUE) ? $this->input->post('status', TRUE) : 'Aktif'
            );
            $this->db->insert('mata_pelajaran', $data_insert);
            $mapel_id = $this->db->insert_id();

            $this->master_model->save_mapel_kelas($mapel_id, $kelas_ids);

            $this->logger_lib->log('CREATE_MAPEL', 'Menambah Mapel: ' . $data_insert['nama_mapel']);
            $this->session->set_flashdata('success', 'Mata Pelajaran berhasil ditambahkan.');
            redirect('master/mapel');

        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $kelas_ids = $this->input->post('kelas_ids', TRUE);
            $first_kelas_id = (!empty($kelas_ids) && is_array($kelas_ids)) ? $kelas_ids[0] : NULL;

            $data_update = array(
                'kode_mapel' => $this->input->post('kode_mapel', TRUE),
                'nama_mapel' => $this->input->post('nama_mapel', TRUE),
                'kelompok' => $this->input->post('kelompok', TRUE),
                'kkm' => $this->input->post('kkm', TRUE),
                'guru_id' => $this->input->post('guru_id', TRUE) ? $this->input->post('guru_id', TRUE) : NULL,
                'kelas_id' => $first_kelas_id,
                'semester' => $this->input->post('semester', TRUE),
                'tahun_pelajaran_id' => $this->input->post('tahun_pelajaran_id', TRUE) ? $this->input->post('tahun_pelajaran_id', TRUE) : NULL,
                'status' => $this->input->post('status', TRUE) ? $this->input->post('status', TRUE) : 'Aktif'
            );
            $this->db->where('id', $id);
            $this->db->update('mata_pelajaran', $data_update);

            $this->master_model->save_mapel_kelas($id, $kelas_ids);

            $this->logger_lib->log('UPDATE_MAPEL', 'Memperbarui Mapel ID: ' . $id);
            $this->session->set_flashdata('success', 'Mata Pelajaran berhasil diperbarui.');
            redirect('master/mapel');

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $this->db->where('id', $id);
            $this->db->delete('mata_pelajaran');
            $this->logger_lib->log('DELETE_MAPEL', 'Menghapus Mapel ID: ' . $id);
            $this->session->set_flashdata('success', 'Mata Pelajaran berhasil dihapus.');
            redirect('master/mapel');
        }

        $data['title'] = 'Master Mata Pelajaran';
        $list_mapel = $this->db->select('mata_pelajaran.*, guru.nama_lengkap as nama_guru, kelas.nama_kelas, tahun_pelajaran.tahun as tahun_pelajaran')
            ->join('guru', 'guru.id = mata_pelajaran.guru_id', 'left')
            ->join('kelas', 'kelas.id = mata_pelajaran.kelas_id', 'left')
            ->join('tahun_pelajaran', 'tahun_pelajaran.id = mata_pelajaran.tahun_pelajaran_id', 'left')
            ->get('mata_pelajaran')->result_array();

        foreach ($list_mapel as &$m) {
            $m['kelas_ids'] = $this->master_model->get_kelas_ids_by_mapel($m['id']);
            if (empty($m['kelas_ids']) && !empty($m['kelas_id'])) {
                $m['kelas_ids'] = array((int)$m['kelas_id']);
            }
            $m['list_kelas_nama'] = array();
            if (!empty($m['kelas_ids'])) {
                $this->db->where_in('id', $m['kelas_ids']);
                $this->db->order_by('nama_kelas', 'ASC');
                $kelases = $this->db->get('kelas')->result_array();
                foreach ($kelases as $k) {
                    $m['list_kelas_nama'][] = $k['nama_kelas'];
                }
            }
        }

        $data['list_mapel'] = $list_mapel;
        $data['list_guru'] = $this->master_model->get_all_guru();
        $data['list_kelas'] = $this->master_model->get_all_kelas();
        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();
        $this->template->load('layout/main', 'master/mapel', $data);
    }


    // --- 4. Data Guru FULL CRUD & Multi-Mapel ---
    public function guru() {
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $nip = $this->input->post('nip', TRUE);
            $nama = $this->input->post('nama_lengkap', TRUE);
            $email = $this->input->post('email', TRUE);
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password');
            $mapel_ids = $this->input->post('mapel_ids', TRUE);

            // 1. Create User Account
            $user_data = array(
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'full_name' => $nama,
                'role_id' => $this->input->post('role_id', TRUE) ? $this->input->post('role_id', TRUE) : 2,
                'is_active' => 1
            );
            $this->db->insert('users', $user_data);
            $user_id = $this->db->insert_id();

            // 2. Create Guru Profile
            $guru_data = array(
                'user_id' => $user_id,
                'nip' => $nip,
                'nama_lengkap' => $nama,
                'gelar_depan' => $this->input->post('gelar_depan', TRUE),
                'gelar_belakang' => $this->input->post('gelar_belakang', TRUE),
                'jk' => $this->input->post('jk', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE),
                'email' => $email,
                'status_kepegawaian' => $this->input->post('status_kepegawaian', TRUE)
            );
            $this->db->insert('guru', $guru_data);
            $guru_id = $this->db->insert_id();

            // 3. Save Multi-Mapel Mapping
            $this->master_model->save_guru_mapel($guru_id, $mapel_ids);

            $this->logger_lib->log('CREATE_GURU', "Menambah Guru: $nama ($nip)");
            $this->session->set_flashdata('success', 'Data Guru & Pengampuan Mapel berhasil dibuat.');
            redirect('master/guru');

        } elseif ($action == 'edit') {
            $guru_id = $this->input->post('id', TRUE);
            $mapel_ids = $this->input->post('mapel_ids', TRUE);
            $guru = $this->db->get_where('guru', array('id' => $guru_id))->row_array();

            if ($guru) {
                $nama = $this->input->post('nama_lengkap', TRUE);
                $nip = $this->input->post('nip', TRUE);
                $email = $this->input->post('email', TRUE);

                $guru_update = array(
                    'nip' => $nip,
                    'nama_lengkap' => $nama,
                    'gelar_depan' => $this->input->post('gelar_depan', TRUE),
                    'gelar_belakang' => $this->input->post('gelar_belakang', TRUE),
                    'jk' => $this->input->post('jk', TRUE),
                    'no_hp' => $this->input->post('no_hp', TRUE),
                    'email' => $email,
                    'status_kepegawaian' => $this->input->post('status_kepegawaian', TRUE)
                );
                $this->db->where('id', $guru_id);
                $this->db->update('guru', $guru_update);

                // Save Multi-Mapel Mapping
                $this->master_model->save_guru_mapel($guru_id, $mapel_ids);

                $is_active_input = ($this->input->post('is_active', TRUE) == '1') ? 1 : 0;
                $role_id_input = $this->input->post('role_id', TRUE) ? $this->input->post('role_id', TRUE) : 2;
                $username_input = trim($this->input->post('username', TRUE));
                $password_input = $this->input->post('password');

                // Update / Create Linked User Account
                if (!empty($guru['user_id'])) {
                    // Update Existing Account
                    $user_update = array(
                        'full_name' => $nama,
                        'email' => $email,
                        'role_id' => $role_id_input,
                        'is_active' => $is_active_input
                    );
                    if (!empty($username_input)) {
                        $user_update['username'] = $username_input;
                    }
                    if (!empty($password_input)) {
                        $user_update['password'] = password_hash($password_input, PASSWORD_DEFAULT);
                    }
                    $this->db->where('id', $guru['user_id']);
                    $this->db->update('users', $user_update);
                } else {
                    // Create New User Account & Link to Guru Profile
                    $username_gen = !empty($username_input) ? $username_input : (!empty($email) ? strtok($email, '@') : 'guru_' . $nip);
                    
                    // Check unique username
                    $chk = $this->db->get_where('users', array('username' => $username_gen))->row_array();
                    if ($chk) {
                        $username_gen = $username_gen . '_' . rand(10, 99);
                    }

                    $password_gen = !empty($password_input) ? $password_input : ('guru' . $nip);

                    $user_data = array(
                        'username' => $username_gen,
                        'email' => $email,
                        'password' => password_hash($password_gen, PASSWORD_DEFAULT),
                        'full_name' => $nama,
                        'role_id' => $role_id_input,
                        'is_active' => $is_active_input
                    );
                    $this->db->insert('users', $user_data);
                    $new_user_id = $this->db->insert_id();

                    // Link user_id to guru record
                    $this->db->where('id', $guru_id);
                    $this->db->update('guru', array('user_id' => $new_user_id));
                }

                $this->logger_lib->log('UPDATE_GURU', "Memperbarui Data Guru: $nama");
                $this->session->set_flashdata('success', 'Data Guru & Pengampuan Mapel berhasil diperbarui.');
            }
            redirect('master/guru');

        } elseif ($action == 'delete') {
            $guru_id = $this->input->post('id', TRUE);
            $guru = $this->db->get_where('guru', array('id' => $guru_id))->row_array();
            if ($guru) {
                if (!empty($guru['user_id'])) {
                    $this->db->where('id', $guru['user_id']);
                    $this->db->delete('users');
                }
                $this->db->where('id', $guru_id);
                $this->db->delete('guru');
                $this->logger_lib->log('DELETE_GURU', "Menghapus Data Guru ID: $guru_id");
                $this->session->set_flashdata('success', 'Data Guru berhasil dihapus.');
            }
            redirect('master/guru');
        }

        $data['title'] = 'Master Data Guru';
        $data['list_guru'] = $this->master_model->get_all_guru();
        $data['list_mapel'] = $this->master_model->get_all_mapel();
        $data['list_roles'] = $this->db->get('roles')->result_array();
        $this->template->load('layout/main', 'master/guru', $data);
    }

    // --- 5. Data Siswa FULL CRUD + Filter Angkatan & Kelas + Import/Export ---
    public function siswa() {
        $action = $this->input->post('action', TRUE);
        $selected_tingkat = $this->input->get('tingkat', TRUE);
        $selected_kelas = $this->input->get('kelas_id', TRUE);

        $query_params = array();
        if ($selected_tingkat) $query_params['tingkat'] = $selected_tingkat;
        if ($selected_kelas) $query_params['kelas_id'] = $selected_kelas;
        $redirect_url = 'master/siswa' . (!empty($query_params) ? '?' . http_build_query($query_params) : '');

        if ($action == 'add') {
            $data_insert = array(
                'nis' => $this->input->post('nis', TRUE),
                'nisn' => $this->input->post('nisn', TRUE),
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'jk' => $this->input->post('jk', TRUE),
                'kelas_id' => $this->input->post('kelas_id', TRUE),
                'status_aktif' => 1
            );
            $this->db->insert('siswa', $data_insert);
            $this->logger_lib->log('CREATE_SISWA', 'Menambah Siswa: ' . $data_insert['nama_lengkap']);
            $this->session->set_flashdata('success', 'Data Siswa berhasil ditambahkan.');
            redirect($redirect_url);

        } elseif ($action == 'edit') {
            $siswa_id = $this->input->post('id', TRUE);
            $data_update = array(
                'nis' => $this->input->post('nis', TRUE),
                'nisn' => $this->input->post('nisn', TRUE),
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'jk' => $this->input->post('jk', TRUE),
                'kelas_id' => $this->input->post('kelas_id', TRUE),
                'status_aktif' => $this->input->post('status_aktif', TRUE)
            );
            $this->db->where('id', $siswa_id);
            $this->db->update('siswa', $data_update);

            $this->logger_lib->log('UPDATE_SISWA', "Memperbarui Siswa: {$data_update['nama_lengkap']}");
            $this->session->set_flashdata('success', 'Data Siswa berhasil diperbarui.');
            redirect($redirect_url);

        } elseif ($action == 'delete') {
            $siswa_id = $this->input->post('id', TRUE);
            $this->db->where('id', $siswa_id);
            $this->db->delete('siswa');

            $this->logger_lib->log('DELETE_SISWA', "Menghapus Siswa ID: $siswa_id");
            $this->session->set_flashdata('success', 'Data Siswa berhasil dihapus.');
            redirect($redirect_url);
        }

        $data['title'] = 'Master Data Siswa';
        $data['selected_tingkat'] = $selected_tingkat;
        $data['selected_kelas'] = $selected_kelas;
        $data['list_siswa'] = $this->master_model->get_all_siswa($selected_kelas, $selected_tingkat);
        $data['list_kelas'] = $this->master_model->get_all_kelas();
        $this->template->load('layout/main', 'master/siswa', $data);
    }

    public function export_siswa() {
        $selected_tingkat = $this->input->get('tingkat', TRUE);
        $selected_kelas = $this->input->get('kelas_id', TRUE);
        $list_siswa = $this->master_model->get_all_siswa($selected_kelas, $selected_tingkat);

        $tag = ($selected_tingkat ? "angkatan_$selected_tingkat" : "semua_angkatan") . ($selected_kelas ? "_kelas_$selected_kelas" : "");
        $filename = "data_siswa_" . $tag . "_" . date('Ymd_His') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, array('NO', 'NIS', 'NISN', 'NAMA LENGKAP', 'JK', 'ANGKATAN/TINGKAT', 'KELAS', 'STATUS'));

        $no = 1;
        foreach ($list_siswa as $s) {
            fputcsv($output, array(
                $no++,
                $s['nis'],
                $s['nisn'],
                $s['nama_lengkap'],
                $s['jk'],
                'Kelas ' . $s['tingkat'],
                $s['nama_kelas'],
                ($s['status_aktif'] == 1 ? 'Aktif' : 'Non-Aktif')
            ));
        }
        fclose($output);
        exit;
    }

    public function export_siswa_excel() {
        $selected_kelas  = $this->input->get('kelas_id', TRUE);
        $selected_tingkat = $this->input->get('tingkat', TRUE);
        $list_siswa = $this->master_model->get_all_siswa($selected_kelas, $selected_tingkat);

        $label_filter = '';
        if ($selected_kelas) {
            $kelas_row = $this->db->get_where('kelas', array('id' => $selected_kelas))->row_array();
            $label_filter = $kelas_row ? $kelas_row['nama_kelas'] : 'Filter Kelas';
        } elseif ($selected_tingkat) {
            $label_filter = 'Kelas ' . $selected_tingkat;
        } else {
            $label_filter = 'Semua Kelas';
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'DATA SISWA — ' . strtoupper($label_filter));
        $sheet->setCellValue('A2', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'NIS', 'NISN', 'Nama Lengkap', 'JK', 'Angkatan/Tingkat', 'Kelas', 'Status');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '4', $h);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $col++;
        }

        $row_idx = 5;
        $no = 1;
        foreach ($list_siswa as $s) {
            $sheet->setCellValue('A' . $row_idx, $no++);
            $sheet->setCellValueExplicit('B' . $row_idx, $s['nis'],  \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $row_idx, $s['nisn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row_idx, $s['nama_lengkap']);
            $sheet->setCellValue('E' . $row_idx, $s['jk']);
            $sheet->setCellValue('F' . $row_idx, 'Kelas ' . $s['tingkat']);
            $sheet->setCellValue('G' . $row_idx, $s['nama_kelas']);
            $sheet->setCellValue('H' . $row_idx, ($s['status_aktif'] == 1 ? 'Aktif' : 'Non-Aktif'));
            $row_idx++;
        }

        foreach (range('A', 'H') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Data_Siswa_' . str_replace(' ', '_', $label_filter) . '_' . date('Ymd') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    public function export_siswa_pdf() {
        $selected_kelas   = $this->input->get('kelas_id', TRUE);
        $selected_tingkat = $this->input->get('tingkat', TRUE);
        $list_siswa = $this->master_model->get_all_siswa($selected_kelas, $selected_tingkat);

        $label_filter = '';
        if ($selected_kelas) {
            $kelas_row = $this->db->get_where('kelas', array('id' => $selected_kelas))->row_array();
            $label_filter = $kelas_row ? $kelas_row['nama_kelas'] : 'Filter Kelas';
        } elseif ($selected_tingkat) {
            $label_filter = 'Kelas ' . $selected_tingkat;
        } else {
            $label_filter = 'Semua Kelas';
        }

        $settings_raw = $this->db->get('system_settings')->result_array();
        $settings = array();
        foreach ($settings_raw as $sr) {
            $settings[$sr['setting_key']] = $sr['setting_value'];
        }

        $data = array(
            'title'        => 'Data Siswa — ' . $label_filter,
            'label_filter' => $label_filter,
            'list_siswa'   => $list_siswa,
            'settings'     => $settings
        );

        require_once APPPATH . 'services/LaporanService.php';
        $laporanService = new LaporanService();
        $laporanService->render_pdf('master/siswa_pdf', $data, 'Data_Siswa_' . date('Ymd') . '.pdf', 'portrait');
        exit;
    }


    public function print_siswa() {
        $selected_kelas   = $this->input->get('kelas_id', TRUE);
        $selected_tingkat = $this->input->get('tingkat', TRUE);
        $list_siswa = $this->master_model->get_all_siswa($selected_kelas, $selected_tingkat);

        $label_filter = '';
        if ($selected_kelas) {
            $kelas_row = $this->db->get_where('kelas', array('id' => $selected_kelas))->row_array();
            $label_filter = $kelas_row ? $kelas_row['nama_kelas'] : 'Filter Kelas';
        } elseif ($selected_tingkat) {
            $label_filter = 'Kelas ' . $selected_tingkat;
        } else {
            $label_filter = 'Semua Kelas';
        }

        $settings_raw = $this->db->get('system_settings')->result_array();
        $settings = array();
        foreach ($settings_raw as $sr) {
            $settings[$sr['setting_key']] = $sr['setting_value'];
        }

        $data = array(
            'title'        => 'Data Siswa — ' . $label_filter,
            'label_filter' => $label_filter,
            'list_siswa'   => $list_siswa,
            'settings'     => $settings
        );

        $this->load->view('master/siswa_print', $data);
    }

    public function download_template_siswa() {
        $filename = "template_import_siswa.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, array('NIS', 'NISN', 'NAMA LENGKAP', 'JK', 'NAMA KELAS'));
        fputcsv($output, array('1001', '0012345678', 'Budi Prasetyo', 'L', 'X IPA 1'));
        fputcsv($output, array('1002', '0012345679', 'Siti Aminah', 'P', 'X IPA 1'));
        fclose($output);
        exit;
    }

    public function import_siswa() {
        if (!empty($_FILES['file_csv']['name'])) {
            $filename = $_FILES['file_csv']['tmp_name'];
            $file = fopen($filename, 'r');

            $all_kelas = $this->master_model->get_all_kelas();
            $kelas_map = array();
            foreach ($all_kelas as $k) {
                $kelas_map[strtoupper(trim($k['nama_kelas']))] = $k['id'];
                $kelas_map[strtoupper(trim($k['kode_kelas']))] = $k['id'];
            }

            $success_count = 0;
            $row_index = 0;

            while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
                $row_index++;
                if ($row_index == 1) continue; // Skip header

                if (count($row) >= 5) {
                    $nis = trim($row[0]);
                    $nisn = trim($row[1]);
                    $nama = trim($row[2]);
                    $jk = strtoupper(trim($row[3]));
                    $nama_kelas = strtoupper(trim($row[4]));

                    if (!empty($nis) && !empty($nama)) {
                        $kelas_id = isset($kelas_map[$nama_kelas]) ? $kelas_map[$nama_kelas] : ($this->input->post('default_kelas_id', TRUE) ? $this->input->post('default_kelas_id', TRUE) : 1);

                        // Check duplicate NIS
                        $existing = $this->db->get_where('siswa', array('nis' => $nis))->row_array();
                        if (!$existing) {
                            $this->db->insert('siswa', array(
                                'nis' => $nis,
                                'nisn' => $nisn,
                                'nama_lengkap' => $nama,
                                'jk' => ($jk == 'P' ? 'P' : 'L'),
                                'kelas_id' => $kelas_id,
                                'status_aktif' => 1
                            ));
                            $success_count++;
                        }
                    }
                }
            }
            fclose($file);

            $this->logger_lib->log('IMPORT_SISWA', "Meng-import $success_count data siswa dari CSV.");
            $this->session->set_flashdata('success', "Berhasil meng-import $success_count data siswa baru.");
        } else {
            $this->session->set_flashdata('error', "Gagal mengunggah berkas CSV.");
        }
        redirect('master/siswa');
    }

    // --- 6. Data Ruangan ---
    public function ruangan() {
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $data_insert = array(
                'kode_ruangan' => $this->input->post('kode_ruangan', TRUE),
                'nama_ruangan' => $this->input->post('nama_ruangan', TRUE),
                'kapasitas' => $this->input->post('kapasitas', TRUE)
            );
            $this->db->insert('ruangan', $data_insert);
            $this->session->set_flashdata('success', 'Data Ruangan berhasil ditambahkan.');
            redirect('master/ruangan');

        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $data_update = array(
                'kode_ruangan' => $this->input->post('kode_ruangan', TRUE),
                'nama_ruangan' => $this->input->post('nama_ruangan', TRUE),
                'kapasitas' => $this->input->post('kapasitas', TRUE)
            );
            $this->db->where('id', $id);
            $this->db->update('ruangan', $data_update);
            $this->session->set_flashdata('success', 'Data Ruangan berhasil diperbarui.');
            redirect('master/ruangan');

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $this->db->where('id', $id);
            $this->db->delete('ruangan');
            $this->session->set_flashdata('success', 'Data Ruangan berhasil dihapus.');
            redirect('master/ruangan');
        }

        $data['title'] = 'Master Data Ruangan';
        $data['list_ruangan'] = $this->master_model->get_all_ruangan();
        $this->template->load('layout/main', 'master/ruangan', $data);
    }

    // --- 7. Jam Pelajaran ---
    public function jam_pelajaran() {
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $data_insert = array(
                'jam_ke' => $this->input->post('jam_ke', TRUE),
                'jam_mulai' => $this->input->post('jam_mulai', TRUE),
                'jam_selesai' => $this->input->post('jam_selesai', TRUE)
            );
            $this->db->insert('jam_pelajaran', $data_insert);
            $this->session->set_flashdata('success', 'Data Jam Pelajaran berhasil ditambahkan.');
            redirect('master/jam_pelajaran');

        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $data_update = array(
                'jam_ke' => $this->input->post('jam_ke', TRUE),
                'jam_mulai' => $this->input->post('jam_mulai', TRUE),
                'jam_selesai' => $this->input->post('jam_selesai', TRUE)
            );
            $this->db->where('id', $id);
            $this->db->update('jam_pelajaran', $data_update);
            $this->session->set_flashdata('success', 'Data Jam Pelajaran berhasil diperbarui.');
            redirect('master/jam_pelajaran');

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $this->db->where('id', $id);
            $this->db->delete('jam_pelajaran');
            $this->session->set_flashdata('success', 'Data Jam Pelajaran berhasil dihapus.');
            redirect('master/jam_pelajaran');
        }

        $data['title'] = 'Master Jam Pelajaran';
        $data['list_jam'] = $this->master_model->get_all_jam();
        $this->template->load('layout/main', 'master/jam_pelajaran', $data);
    }

    // --- 8. Jadwal Pelajaran ---
    public function jadwal() {
        $action = $this->input->post('action', TRUE);

        if ($action == 'add') {
            $active_tp = $this->master_model->get_active_tahun_pelajaran();
            $data_insert = array(
                'tahun_pelajaran_id' => $active_tp['id'],
                'kelas_id' => $this->input->post('kelas_id', TRUE),
                'mapel_id' => $this->input->post('mapel_id', TRUE),
                'guru_id' => $this->input->post('guru_id', TRUE),
                'ruangan_id' => $this->input->post('ruangan_id', TRUE) ? $this->input->post('ruangan_id', TRUE) : NULL,
                'hari' => $this->input->post('hari', TRUE),
                'jam_mulai_ke' => $this->input->post('jam_mulai_ke', TRUE),
                'jam_selesai_ke' => $this->input->post('jam_selesai_ke', TRUE)
            );
            $this->db->insert('jadwal_pelajaran', $data_insert);
            $this->session->set_flashdata('success', 'Jadwal Pelajaran berhasil ditambahkan.');
            redirect('master/jadwal');

        } elseif ($action == 'edit') {
            $id = $this->input->post('id', TRUE);
            $data_update = array(
                'kelas_id' => $this->input->post('kelas_id', TRUE),
                'mapel_id' => $this->input->post('mapel_id', TRUE),
                'guru_id' => $this->input->post('guru_id', TRUE),
                'ruangan_id' => $this->input->post('ruangan_id', TRUE) ? $this->input->post('ruangan_id', TRUE) : NULL,
                'hari' => $this->input->post('hari', TRUE),
                'jam_mulai_ke' => $this->input->post('jam_mulai_ke', TRUE),
                'jam_selesai_ke' => $this->input->post('jam_selesai_ke', TRUE)
            );
            $this->db->where('id', $id);
            $this->db->update('jadwal_pelajaran', $data_update);
            $this->session->set_flashdata('success', 'Jadwal Pelajaran berhasil diperbarui.');
            redirect('master/jadwal');

        } elseif ($action == 'delete') {
            $id = $this->input->post('id', TRUE);
            $this->db->where('id', $id);
            $this->db->delete('jadwal_pelajaran');
            $this->session->set_flashdata('success', 'Jadwal Pelajaran berhasil dihapus.');
            redirect('master/jadwal');
        }

        $data['title'] = 'Jadwal Pelajaran';
        $data['list_jadwal'] = $this->master_model->get_all_jadwal();
        $data['list_kelas'] = $this->master_model->get_all_kelas();
        $data['list_mapel'] = $this->master_model->get_all_mapel();
        $data['list_guru'] = $this->master_model->get_all_guru();
        $data['list_ruangan'] = $this->master_model->get_all_ruangan();
        $this->template->load('layout/main', 'master/jadwal', $data);
    }

    // --- GENERIC EXCEL IMPORT / EXPORT FOR MASTER DATA ---
    public function export_excel($module) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        switch ($module) {
            case 'tahun_pelajaran':
                $sheet->setCellValue('A1', 'Tahun Pelajaran');
                $sheet->setCellValue('B1', 'Semester');
                $sheet->setCellValue('C1', 'Status Aktif (1=Aktif, 0=Tidak)');
                
                $data = $this->db->get('tahun_pelajaran')->result_array();
                $row = 2;
                foreach ($data as $d) {
                    $sheet->setCellValue('A' . $row, $d['tahun']);
                    $sheet->setCellValue('B' . $row, $d['semester']);
                    $sheet->setCellValue('C' . $row, $d['is_active']);
                    $row++;
                }
                $filename = 'Master_Tahun_Pelajaran.xlsx';
                break;
                
            case 'kelas':
                $sheet->setCellValue('A1', 'Kode Kelas');
                $sheet->setCellValue('B1', 'Nama Kelas');
                $sheet->setCellValue('C1', 'Tingkat (10/11/12)');
                $sheet->setCellValue('D1', 'NIP Wali Kelas');
                
                $this->db->select('kelas.*, guru.nip as nip_wali');
                $this->db->join('guru', 'guru.id = kelas.wali_kelas_id', 'left');
                $data = $this->db->get('kelas')->result_array();
                $row = 2;
                foreach ($data as $d) {
                    $sheet->setCellValue('A' . $row, $d['kode_kelas']);
                    $sheet->setCellValue('B' . $row, $d['nama_kelas']);
                    $sheet->setCellValue('C' . $row, $d['tingkat']);
                    $sheet->setCellValue('D' . $row, $d['nip_wali'] ?? '');
                    $row++;
                }
                $filename = 'Master_Data_Kelas.xlsx';
                break;
                
            case 'ruangan':
                $sheet->setCellValue('A1', 'Kode Ruangan');
                $sheet->setCellValue('B1', 'Nama Ruangan');
                $sheet->setCellValue('C1', 'Kapasitas');
                
                $data = $this->db->get('ruangan')->result_array();
                $row = 2;
                foreach ($data as $d) {
                    $sheet->setCellValue('A' . $row, $d['kode_ruangan']);
                    $sheet->setCellValue('B' . $row, $d['nama_ruangan']);
                    $sheet->setCellValue('C' . $row, $d['kapasitas']);
                    $row++;
                }
                $filename = 'Master_Data_Ruangan.xlsx';
                break;
                
            case 'mapel':
                $sheet->setCellValue('A1', 'Kode Mapel');
                $sheet->setCellValue('B1', 'Nama Mata Pelajaran');
                $sheet->setCellValue('C1', 'Kelompok (Wajib/Peminatan/Muatan Lokal)');
                $sheet->setCellValue('D1', 'KKM');
                $sheet->setCellValue('E1', 'NIP Guru Pengampu');
                $sheet->setCellValue('F1', 'Kode Kelas');
                $sheet->setCellValue('G1', 'Semester (Ganjil/Genap)');
                $sheet->setCellValue('H1', 'Tahun Pelajaran (Format: 2025/2026)');
                $sheet->setCellValue('I1', 'Status (Aktif/Non-Aktif)');
                
                $this->db->select('mata_pelajaran.*, guru.nip as nip_guru, kelas.kode_kelas, tahun_pelajaran.tahun as tahun_pelajaran');
                $this->db->join('guru', 'guru.id = mata_pelajaran.guru_id', 'left');
                $this->db->join('kelas', 'kelas.id = mata_pelajaran.kelas_id', 'left');
                $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = mata_pelajaran.tahun_pelajaran_id', 'left');
                $data = $this->db->get('mata_pelajaran')->result_array();
                
                $row = 2;
                foreach ($data as $d) {
                    $sheet->setCellValue('A' . $row, $d['kode_mapel']);
                    $sheet->setCellValue('B' . $row, $d['nama_mapel']);
                    $sheet->setCellValue('C' . $row, $d['kelompok']);
                    $sheet->setCellValue('D' . $row, $d['kkm']);
                    $sheet->setCellValueExplicit('E' . $row, $d['nip_guru'] ?? '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('F' . $row, $d['kode_kelas'] ?? '');
                    $sheet->setCellValue('G' . $row, $d['semester'] ?? 'Ganjil');
                    $sheet->setCellValue('H' . $row, $d['tahun_pelajaran'] ?? '');
                    $sheet->setCellValue('I' . $row, $d['status'] ?? 'Aktif');
                    $row++;
                }
                $filename = 'Master_Mata_Pelajaran.xlsx';
                break;
                
            case 'jam_pelajaran':
                $sheet->setCellValue('A1', 'Jam Ke');
                $sheet->setCellValue('B1', 'Jam Mulai (HH:MM)');
                $sheet->setCellValue('C1', 'Jam Selesai (HH:MM)');
                
                $data = $this->db->get('jam_pelajaran')->result_array();
                $row = 2;
                foreach ($data as $d) {
                    $sheet->setCellValue('A' . $row, $d['jam_ke']);
                    $sheet->setCellValue('B' . $row, date('H:i', strtotime($d['jam_mulai'])));
                    $sheet->setCellValue('C' . $row, date('H:i', strtotime($d['jam_selesai'])));
                    $row++;
                }
                $filename = 'Master_Jam_Pelajaran.xlsx';
                break;
                
            case 'guru':
                $sheet->setCellValue('A1', 'NIP');
                $sheet->setCellValue('B1', 'Nama Lengkap');
                $sheet->setCellValue('C1', 'Username');
                $sheet->setCellValue('D1', 'Password (kosongkan jika tidak diganti)');
                $sheet->setCellValue('E1', 'Gelar Depan');
                $sheet->setCellValue('F1', 'Gelar Belakang');
                $sheet->setCellValue('G1', 'Jenis Kelamin (L/P)');
                $sheet->setCellValue('H1', 'No HP');
                $sheet->setCellValue('I1', 'Email');
                $sheet->setCellValue('J1', 'Status Kepegawaian (PNS/PPPK/GTY/GTT/Honorer)');
                $sheet->setCellValue('K1', 'Status Guru (Aktif/Non-Aktif)');
                $sheet->setCellValue('L1', 'Role (Guru/Wali Kelas/Waka Kurikulum/Kepala Madrasah)');
                $sheet->setCellValue('M1', 'Mata Pelajaran Diampu (Pisahkan dengan koma, contoh: MAT-W,FIS-P)');
                
                $data = $this->master_model->get_all_guru();
                $row = 2;
                foreach ($data as $d) {
                    $role_name = 'Guru';
                    if (!empty($d['user_id'])) {
                        $usr = $this->db->select('users.*, roles.role_name')
                            ->join('roles', 'roles.id = users.role_id')
                            ->get_where('users', array('users.id' => $d['user_id']))->row_array();
                        if ($usr) {
                            $role_name = $usr['role_name'];
                        }
                    }
                    
                    $mapels = $this->db->select('mata_pelajaran.kode_mapel')
                        ->join('mata_pelajaran', 'mata_pelajaran.id = guru_mapel.mapel_id')
                        ->get_where('guru_mapel', array('guru_mapel.guru_id' => $d['id']))->result_array();
                    $mapel_codes = implode(',', array_column($mapels, 'kode_mapel'));

                    $sheet->setCellValueExplicit('A' . $row, $d['nip'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('B' . $row, $d['nama_lengkap']);
                    $sheet->setCellValue('C' . $row, $d['username'] ?? '');
                    $sheet->setCellValue('D' . $row, '');
                    $sheet->setCellValue('E' . $row, $d['gelar_depan'] ?? '');
                    $sheet->setCellValue('F' . $row, $d['gelar_belakang'] ?? '');
                    $sheet->setCellValue('G' . $row, $d['jk']);
                    $sheet->setCellValue('H' . $row, $d['no_hp'] ?? '');
                    $sheet->setCellValue('I' . $row, $d['email'] ?? '');
                    $sheet->setCellValue('J' . $row, $d['status_kepegawaian'] ?? '');
                    $sheet->setCellValue('K' . $row, ($d['is_active'] ?? 1) == 1 ? 'Aktif' : 'Non-Aktif');
                    $sheet->setCellValue('L' . $row, $role_name);
                    $sheet->setCellValue('M' . $row, $mapel_codes);
                    $row++;
                }
                $filename = 'Master_Data_Guru.xlsx';
                break;
                
            case 'siswa':
                $sheet->setCellValue('A1', 'NIS');
                $sheet->setCellValue('B1', 'NISN');
                $sheet->setCellValue('C1', 'Nama Lengkap');
                $sheet->setCellValue('D1', 'Jenis Kelamin (L/P)');
                $sheet->setCellValue('E1', 'Tempat Lahir');
                $sheet->setCellValue('F1', 'Tanggal Lahir (YYYY-MM-DD)');
                $sheet->setCellValue('G1', 'Alamat');
                $sheet->setCellValue('H1', 'Kode Kelas');
                $sheet->setCellValue('I1', 'Status Aktif (1=Aktif, 0=Tidak)');
                
                $this->db->select('siswa.*, kelas.kode_kelas');
                $this->db->join('kelas', 'kelas.id = siswa.kelas_id');
                $data = $this->db->get('siswa')->result_array();
                $row = 2;
                foreach ($data as $d) {
                    $sheet->setCellValueExplicit('A' . $row, $d['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('B' . $row, $d['nisn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('C' . $row, $d['nama_lengkap']);
                    $sheet->setCellValue('D' . $row, $d['jk']);
                    $sheet->setCellValue('E' . $row, $d['tempat_lahir'] ?? '');
                    $sheet->setCellValue('F' . $row, $d['regular_lahir'] ?? $d['tanggal_lahir'] ?? '');
                    $sheet->setCellValue('G' . $row, $d['alamat'] ?? '');
                    $sheet->setCellValue('H' . $row, $d['kode_kelas']);
                    $sheet->setCellValue('I' . $row, $d['status_aktif']);
                    $row++;
                }
                $filename = 'Master_Data_Siswa.xlsx';
                break;
                
            case 'jadwal':
                $sheet->setCellValue('A1', 'Tahun Pelajaran (Format: 2025/2026)');
                $sheet->setCellValue('B1', 'Semester (Ganjil/Genap)');
                $sheet->setCellValue('C1', 'Kode Kelas');
                $sheet->setCellValue('D1', 'Kode Mapel');
                $sheet->setCellValue('E1', 'NIP Guru');
                $sheet->setCellValue('F1', 'Kode Ruangan');
                $sheet->setCellValue('G1', 'Hari (Senin/Selasa/Rabu/Kamis/Jumat/Sabtu)');
                $sheet->setCellValue('H1', 'Jam Mulai Ke (Angka)');
                $sheet->setCellValue('I1', 'Jam Selesai Ke (Angka)');
                
                $this->db->select('jadwal_pelajaran.*, tahun_pelajaran.tahun, tahun_pelajaran.semester, kelas.kode_kelas, mata_pelajaran.kode_mapel, guru.nip as nip_guru, ruangan.kode_ruangan');
                $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = jadwal_pelajaran.tahun_pelajaran_id');
                $this->db->join('kelas', 'kelas.id = jadwal_pelajaran.kelas_id');
                $this->db->join('mata_pelajaran', 'mata_pelajaran.id = jadwal_pelajaran.mapel_id');
                $this->db->join('guru', 'guru.id = jadwal_pelajaran.guru_id');
                $this->db->join('ruangan', 'ruangan.id = jadwal_pelajaran.ruangan_id', 'left');
                $data = $this->db->get('jadwal_pelajaran')->result_array();
                $row = 2;
                foreach ($data as $d) {
                    $sheet->setCellValue('A' . $row, $d['tahun']);
                    $sheet->setCellValue('B' . $row, $d['semester']);
                    $sheet->setCellValue('C' . $row, $d['kode_kelas']);
                    $sheet->setCellValue('D' . $row, $d['kode_mapel']);
                    $sheet->setCellValueExplicit('E' . $row, $d['nip_guru'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('F' . $row, $d['kode_ruangan'] ?? '');
                    $sheet->setCellValue('G' . $row, $d['hari']);
                    $sheet->setCellValue('H' . $row, $d['jam_mulai_ke']);
                    $sheet->setCellValue('I' . $row, $d['jam_selesai_ke']);
                    $row++;
                }
                $filename = 'Master_Jadwal_Pelajaran.xlsx';
                break;
                
            default:
                show_404();
                return;
        }

        // Auto size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function import_excel($module) {
        if (empty($_FILES['excel_file']['name'])) {
            $this->session->set_flashdata('error', 'Silakan pilih file Excel terlebih dahulu.');
            redirect('master/' . $module);
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
            redirect('master/' . $module);
            return;
        }

        $upload_data = $this->upload->data();
        $file_path = './assets/uploads/excel_imports/' . $upload_data['file_name'];

        if ($module == 'guru' || $module == 'mapel') {
            try {
                $spreadsheet = IOFactory::load($file_path);
                $sheet = $spreadsheet->getActiveSheet();
                $highest_row = $sheet->getHighestRow();
                
                $preview_rows = array();
                $duplicate_count = 0;
                $valid_count = 0;
                $invalid_count = 0;
                
                if ($module == 'guru') {
                    for ($row = 2; $row <= $highest_row; $row++) {
                        $nip = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $username = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                        $password = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                        $gelar_d = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                        $gelar_b = trim($sheet->getCell('F' . $row)->getValue() ?? '');
                        $jk = strtoupper(trim($sheet->getCell('G' . $row)->getValue() ?? ''));
                        $no_hp = trim($sheet->getCell('H' . $row)->getValue() ?? '');
                        $email = trim($sheet->getCell('I' . $row)->getValue() ?? '');
                        $status_kepegawaian = trim($sheet->getCell('J' . $row)->getValue() ?? 'PNS');
                        $status_aktif = trim($sheet->getCell('K' . $row)->getValue() ?? 'Aktif');
                        $role_name = trim($sheet->getCell('L' . $row)->getValue() ?? 'Guru');
                        $mapel_codes_raw = trim($sheet->getCell('M' . $row)->getValue() ?? '');

                        if ($nip === '' && $nama === '') continue;

                        $row_errors = array();
                        if ($nip === '') $row_errors[] = 'NIP/NUPTK tidak boleh kosong.';
                        if ($nama === '') $row_errors[] = 'Nama Lengkap tidak boleh kosong.';
                        if ($username === '') {
                            $row_errors[] = 'Username tidak boleh kosong.';
                        } elseif (preg_match('/\s/', $username)) {
                            $row_errors[] = 'Username tidak boleh mengandung spasi.';
                        } else {
                            $existing_user = $this->db->get_where('users', array('username' => $username))->row_array();
                            if ($existing_user) {
                                $row_errors[] = "Username '$username' sudah terdaftar.";
                                $duplicate_count++;
                            }
                        }
                        if ($jk !== 'L' && $jk !== 'P') $row_errors[] = 'Jenis Kelamin harus L atau P.';
                        
                        $role = $this->db->get_where('roles', array('role_name' => $role_name))->row_array();
                        if (!$role) {
                            $role = $this->db->get_where('roles', array('role_code' => strtolower(str_replace(' ', '', $role_name))))->row_array();
                            if (!$role) {
                                $row_errors[] = "Role '$role_name' tidak valid.";
                            }
                        }

                        $mapel_ids = array();
                        if ($mapel_codes_raw !== '') {
                            $codes = explode(',', $mapel_codes_raw);
                            foreach ($codes as $code) {
                                $code = trim($code);
                                $mp = $this->db->get_where('mata_pelajaran', array('kode_mapel' => $code))->row_array();
                                if ($mp) {
                                    $mapel_ids[] = $mp['id'];
                                } else {
                                    $row_errors[] = "Mata Pelajaran '$code' tidak ditemukan.";
                                }
                            }
                        }

                        if (empty($row_errors)) {
                            $valid_count++;
                        } else {
                            $invalid_count++;
                        }

                        $preview_rows[] = array(
                            'row_num' => $row,
                            'nip' => $nip,
                            'nama' => $nama,
                            'username' => $username,
                            'password' => $password,
                            'gelar_depan' => $gelar_d,
                            'gelar_belakang' => $gelar_b,
                            'jk' => $jk,
                            'no_hp' => $no_hp,
                            'email' => $email,
                            'status_kepegawaian' => $status_kepegawaian,
                            'status_aktif' => $status_aktif,
                            'role_name' => $role_name,
                            'role_id' => $role ? $role['id'] : NULL,
                            'mapel_codes' => $mapel_codes_raw,
                            'mapel_ids' => $mapel_ids,
                            'errors' => $row_errors
                        );
                    }
                } else {
                    for ($row = 2; $row <= $highest_row; $row++) {
                        $kode = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $kelompok = trim($sheet->getCell('C' . $row)->getValue() ?? 'Wajib');
                        $kkm = trim($sheet->getCell('D' . $row)->getValue() ?? '75.00');
                        $nip_guru = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                        $kode_kelas = trim($sheet->getCell('F' . $row)->getValue() ?? '');
                        $semester = trim($sheet->getCell('G' . $row)->getValue() ?? 'Ganjil');
                        $tahun_tp = trim($sheet->getCell('H' . $row)->getValue() ?? '');
                        $status = trim($sheet->getCell('I' . $row)->getValue() ?? 'Aktif');

                        if ($kode === '' && $nama === '') continue;

                        $row_errors = array();
                        if ($kode === '') $row_errors[] = 'Kode Mapel tidak boleh kosong.';
                        if ($nama === '') $row_errors[] = 'Nama Mapel tidak boleh kosong.';
                        if ($semester !== 'Ganjil' && $semester !== 'Genap') $row_errors[] = 'Semester harus Ganjil atau Genap.';
                        if ($status !== 'Aktif' && $status !== 'Non-Aktif') $row_errors[] = 'Status harus Aktif atau Non-Aktif.';

                        $guru_id = NULL;
                        if ($nip_guru !== '') {
                            $guru = $this->db->get_where('guru', array('nip' => $nip_guru))->row_array();
                            if ($guru) {
                                $guru_id = $guru['id'];
                            } else {
                                $row_errors[] = "Guru dengan NIP '$nip_guru' tidak terdaftar.";
                            }
                        }

                        $kelas_id = NULL;
                        if ($kode_kelas !== '') {
                            $kelas = $this->db->get_where('kelas', array('kode_kelas' => $kode_kelas))->row_array();
                            if ($kelas) {
                                $kelas_id = $kelas['id'];
                            } else {
                                $row_errors[] = "Kelas dengan Kode '$kode_kelas' tidak ditemukan.";
                            }
                        }

                        $tp_id = NULL;
                        if ($tahun_tp !== '') {
                            $tp = $this->db->get_where('tahun_pelajaran', array('tahun' => $tahun_tp, 'semester' => $semester))->row_array();
                            if ($tp) {
                                $tp_id = $tp['id'];
                            } else {
                                $row_errors[] = "Tahun Pelajaran '$tahun_tp' untuk semester '$semester' tidak ditemukan.";
                            }
                        }

                        if (empty($row_errors)) {
                            $valid_count++;
                        } else {
                            $invalid_count++;
                        }

                        $preview_rows[] = array(
                            'row_num' => $row,
                            'kode_mapel' => $kode,
                            'nama_mapel' => $nama,
                            'kelompok' => $kelompok,
                            'kkm' => $kkm,
                            'nip_guru' => $nip_guru,
                            'guru_id' => $guru_id,
                            'kode_kelas' => $kode_kelas,
                            'kelas_id' => $kelas_id,
                            'semester' => $semester,
                            'tahun_tp' => $tahun_tp,
                            'tahun_pelajaran_id' => $tp_id,
                            'status' => $status,
                            'errors' => $row_errors
                        );
                    }
                }

                $data['title'] = 'Preview Import Excel';
                $data['module'] = $module;
                $data['file_name'] = $upload_data['file_name'];
                $data['preview_rows'] = $preview_rows;
                $data['summary'] = array(
                    'total' => count($preview_rows),
                    'valid' => $valid_count,
                    'invalid' => $invalid_count,
                    'duplicate' => $duplicate_count
                );

                $this->template->load('layout/main', 'master/preview_import', $data);
                return;

            } catch (Exception $e) {
                if (file_exists($file_path)) unlink($file_path);
                $this->session->set_flashdata('error', 'Gagal memproses file Excel: ' . $e->getMessage());
                redirect('master/' . $module);
                return;
            }
        }

        try {
            $spreadsheet = IOFactory::load($file_path);
            $sheet = $spreadsheet->getActiveSheet();
            $highest_row = $sheet->getHighestRow();
            $success_count = 0;
            $error_count = 0;

            $this->db->trans_begin();

            for ($row = 2; $row <= $highest_row; $row++) {
                switch ($module) {
                    case 'tahun_pelajaran':
                        $tahun = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $semester = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $is_active = trim($sheet->getCell('C' . $row)->getValue() ?? '0');
                        
                        if ($tahun === '' || $semester === '') continue 2;
                        
                        $existing = $this->db->get_where('tahun_pelajaran', array('tahun' => $tahun, 'semester' => $semester))->row_array();
                        $data_save = array('tahun' => $tahun, 'semester' => $semester, 'is_active' => $is_active);
                        
                        if ($existing) {
                            $this->db->where('id', $existing['id']);
                            $this->db->update('tahun_pelajaran', $data_save);
                        } else {
                            $this->db->insert('tahun_pelajaran', $data_save);
                        }
                        $success_count++;
                        break;

                    case 'kelas':
                        $kode = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $tingkat = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                        $nip_wali = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                        
                        if ($kode === '' || $nama === '' || $tingkat === '') continue 2;
                        
                        $wali_id = NULL;
                        if ($nip_wali !== '') {
                            $guru = $this->db->get_where('guru', array('nip' => $nip_wali))->row_array();
                            if ($guru) $wali_id = $guru['id'];
                        }
                        
                        $existing = $this->db->get_where('kelas', array('kode_kelas' => $kode))->row_array();
                        $data_save = array('kode_kelas' => $kode, 'nama_kelas' => $nama, 'tingkat' => $tingkat, 'wali_kelas_id' => $wali_id);
                        
                        if ($existing) {
                            $this->db->where('id', $existing['id']);
                            $this->db->update('kelas', $data_save);
                        } else {
                            $this->db->insert('kelas', $data_save);
                        }
                        $success_count++;
                        break;

                    case 'ruangan':
                        $kode = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $kapasitas = trim($sheet->getCell('C' . $row)->getValue() ?? '36');
                        
                        if ($kode === '' || $nama === '') continue 2;
                        
                        $existing = $this->db->get_where('ruangan', array('kode_ruangan' => $kode))->row_array();
                        $data_save = array('kode_ruangan' => $kode, 'nama_ruangan' => $nama, 'kapasitas' => $kapasitas);
                        
                        if ($existing) {
                            $this->db->where('id', $existing['id']);
                            $this->db->update('ruangan', $data_save);
                        } else {
                            $this->db->insert('ruangan', $data_save);
                        }
                        $success_count++;
                        break;

                    case 'mapel':
                        $kode = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $kelompok = trim($sheet->getCell('C' . $row)->getValue() ?? 'Wajib');
                        $kkm = trim($sheet->getCell('D' . $row)->getValue() ?? '75.00');
                        
                        if ($kode === '' || $nama === '') continue 2;
                        
                        $existing = $this->db->get_where('mata_pelajaran', array('kode_mapel' => $kode))->row_array();
                        $data_save = array('kode_mapel' => $kode, 'nama_mapel' => $nama, 'kelompok' => $kelompok, 'kkm' => $kkm);
                        
                        if ($existing) {
                            $this->db->where('id', $existing['id']);
                            $this->db->update('mata_pelajaran', $data_save);
                        } else {
                            $this->db->insert('mata_pelajaran', $data_save);
                        }
                        $success_count++;
                        break;

                    case 'jam_pelajaran':
                        $jam_ke = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $jam_mulai = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $jam_selesai = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                        
                        if ($jam_ke === '' || $jam_mulai === '' || $jam_selesai === '') continue 2;
                        
                        $existing = $this->db->get_where('jam_pelajaran', array('jam_ke' => $jam_ke))->row_array();
                        $data_save = array('jam_ke' => $jam_ke, 'jam_mulai' => $jam_mulai, 'jam_selesai' => $jam_selesai);
                        
                        if ($existing) {
                            $this->db->where('id', $existing['id']);
                            $this->db->update('jam_pelajaran', $data_save);
                        } else {
                            $this->db->insert('jam_pelajaran', $data_save);
                        }
                        $success_count++;
                        break;

                    case 'guru':
                        $nip = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $gelar_d = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                        $gelar_b = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                        $jk = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                        $no_hp = trim($sheet->getCell('F' . $row)->getValue() ?? '');
                        $email = trim($sheet->getCell('G' . $row)->getValue() ?? '');
                        $status = trim($sheet->getCell('H' . $row)->getValue() ?? 'PNS');
                        
                        if ($nip === '' || $nama === '' || $jk === '') continue 2;
                        
                        $existing = $this->db->get_where('guru', array('nip' => $nip))->row_array();
                        $data_save = array(
                            'nip' => $nip,
                            'nama_lengkap' => $nama,
                            'gelar_depan' => $gelar_d !== '' ? $gelar_d : NULL,
                            'gelar_belakang' => $gelar_b !== '' ? $gelar_b : NULL,
                            'jk' => $jk,
                            'no_hp' => $no_hp !== '' ? $no_hp : NULL,
                            'email' => $email !== '' ? $email : NULL,
                            'status_kepegawaian' => $status
                        );
                        
                        if ($existing) {
                            $this->db->where('id', $existing['id']);
                            $this->db->update('guru', $data_save);
                        } else {
                            $this->db->insert('guru', $data_save);
                        }
                        $success_count++;
                        break;

                    case 'siswa':
                        $nis = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $nisn = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $nama = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                        $jk = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                        $tempat = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                        $tanggal = trim($sheet->getCell('F' . $row)->getValue() ?? '');
                        $alamat = trim($sheet->getCell('G' . $row)->getValue() ?? '');
                        $kode_kelas = trim($sheet->getCell('H' . $row)->getValue() ?? '');
                        $status = trim($sheet->getCell('I' . $row)->getValue() ?? '1');
                        
                        if ($nis === '' || $nisn === '' || $nama === '' || $kode_kelas === '') continue 2;
                        
                        $kelas = $this->db->get_where('kelas', array('kode_kelas' => $kode_kelas))->row_array();
                        if (!$kelas) {
                            $error_count++;
                            continue 2;
                        }
                        
                        $existing = $this->db->get_where('siswa', array('nis' => $nis))->row_array();
                        $data_save = array(
                            'nis' => $nis,
                            'nisn' => $nisn,
                            'nama_lengkap' => $nama,
                            'jk' => $jk,
                            'tempat_lahir' => $tempat !== '' ? $tempat : NULL,
                            'tanggal_lahir' => $tanggal !== '' ? $tanggal : NULL,
                            'alamat' => $alamat !== '' ? $alamat : NULL,
                            'kelas_id' => $kelas['id'],
                            'status_aktif' => $status
                        );
                        
                        if ($existing) {
                            $this->db->where('id', $existing['id']);
                            $this->db->update('siswa', $data_save);
                        } else {
                            $this->db->insert('siswa', $data_save);
                        }
                        $success_count++;
                        break;

                    case 'jadwal':
                        $tahun = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                        $semester = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                        $kode_kelas = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                        $kode_mapel = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                        $nip_guru = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                        $kode_ruang = trim($sheet->getCell('F' . $row)->getValue() ?? '');
                        $hari = trim($sheet->getCell('G' . $row)->getValue() ?? '');
                        $jam_mulai = trim($sheet->getCell('H' . $row)->getValue() ?? '');
                        $jam_selesai = trim($sheet->getCell('I' . $row)->getValue() ?? '');
                        
                        if ($tahun === '' || $semester === '' || $kode_kelas === '' || $kode_mapel === '' || $nip_guru === '' || $hari === '' || $jam_mulai === '' || $jam_selesai === '') continue 2;
                        
                        $tp = $this->db->get_where('tahun_pelajaran', array('tahun' => $tahun, 'semester' => $semester))->row_array();
                        $kelas = $this->db->get_where('kelas', array('kode_kelas' => $kode_kelas))->row_array();
                        $mapel = $this->db->get_where('mata_pelajaran', array('kode_mapel' => $kode_mapel))->row_array();
                        $guru = $this->db->get_where('guru', array('nip' => $nip_guru))->row_array();
                        $ruang = $kode_ruang !== '' ? $this->db->get_where('ruangan', array('kode_ruangan' => $kode_ruang))->row_array() : NULL;
                        
                        if (!$tp || !$kelas || !$mapel || !$guru) {
                            $error_count++;
                            continue 2;
                        }
                        
                        $data_save = array(
                            'tahun_pelajaran_id' => $tp['id'],
                            'kelas_id' => $kelas['id'],
                            'mapel_id' => $mapel['id'],
                            'guru_id' => $guru['id'],
                            'ruangan_id' => $ruang ? $ruang['id'] : NULL,
                            'hari' => $hari,
                            'jam_mulai_ke' => $jam_mulai,
                            'jam_selesai_ke' => $jam_selesai
                        );
                        
                        $existing = $this->db->get_where('jadwal_pelajaran', array(
                            'tahun_pelajaran_id' => $tp['id'],
                            'kelas_id' => $kelas['id'],
                            'hari' => $hari,
                            'jam_mulai_ke' => $jam_mulai
                        ))->row_array();
                        
                        if ($existing) {
                            $this->db->where('id', $existing['id']);
                            $this->db->update('jadwal_pelajaran', $data_save);
                        } else {
                            $this->db->insert('jadwal_pelajaran', $data_save);
                        }
                        $success_count++;
                        break;
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal memproses transaksi import.');
            } else {
                $this->db->trans_commit();
                $msg = "Import berhasil! $success_count baris data disimpan.";
                if ($error_count > 0) {
                    $msg .= " Namun terdapat $error_count baris dilewati karena kegagalan resolusi relasi data (ref data).";
                }
                $this->session->set_flashdata('success', $msg);
            }

        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Error memproses Excel: ' . $e->getMessage());
        }

        unlink($file_path);
        redirect('master/' . $module);
    }

    public function confirm_import($module) {
        $file_name = $this->input->post('file_name', TRUE);
        $file_path = './assets/uploads/excel_imports/' . $file_name;
        
        if (!file_exists($file_path)) {
            $this->session->set_flashdata('error', 'File sesi import tidak ditemukan. Silakan unggah kembali.');
            redirect('master/' . $module);
            return;
        }

        try {
            $spreadsheet = IOFactory::load($file_path);
            $sheet = $spreadsheet->getActiveSheet();
            $highest_row = $sheet->getHighestRow();
            $success_count = 0;
            $error_count = 0;

            $this->db->trans_begin();

            for ($row = 2; $row <= $highest_row; $row++) {
                if ($module == 'guru') {
                    $nip = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                    $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                    $username = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                    $password = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                    $gelar_d = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                    $gelar_b = trim($sheet->getCell('F' . $row)->getValue() ?? '');
                    $jk = strtoupper(trim($sheet->getCell('G' . $row)->getValue() ?? ''));
                    $no_hp = trim($sheet->getCell('H' . $row)->getValue() ?? '');
                    $email = trim($sheet->getCell('I' . $row)->getValue() ?? '');
                    $status_kepegawaian = trim($sheet->getCell('J' . $row)->getValue() ?? 'PNS');
                    $status_aktif = trim($sheet->getCell('K' . $row)->getValue() ?? 'Aktif');
                    $role_name = trim($sheet->getCell('L' . $row)->getValue() ?? 'Guru');
                    $mapel_codes_raw = trim($sheet->getCell('M' . $row)->getValue() ?? '');

                    if ($nip === '' && $nama === '') continue;

                    if ($nip === '' || $nama === '' || $username === '' || preg_match('/\s/', $username)) {
                        $error_count++;
                        continue;
                    }

                    $existing_user = $this->db->get_where('users', array('username' => $username))->row_array();
                    $existing_guru = $this->db->get_where('guru', array('nip' => $nip))->row_array();

                    $role = $this->db->get_where('roles', array('role_name' => $role_name))->row_array();
                    if (!$role) {
                        $role = $this->db->get_where('roles', array('role_code' => strtolower(str_replace(' ', '', $role_name))))->row_array();
                        if (!$role) {
                            $error_count++;
                            continue;
                        }
                    }

                    $mapel_ids = array();
                    $mapel_err = false;
                    if ($mapel_codes_raw !== '') {
                        $codes = explode(',', $mapel_codes_raw);
                        foreach ($codes as $code) {
                            $code = trim($code);
                            $mp = $this->db->get_where('mata_pelajaran', array('kode_mapel' => $code))->row_array();
                            if ($mp) {
                                $mapel_ids[] = $mp['id'];
                            } else {
                                $mapel_err = true;
                            }
                        }
                    }
                    if ($mapel_err) {
                        $error_count++;
                        continue;
                    }

                    $is_active_val = ($status_aktif == 'Aktif') ? 1 : 0;

                    $user_id = NULL;
                    if ($existing_guru && !empty($existing_guru['user_id'])) {
                        $user_id = $existing_guru['user_id'];
                        $user_update = array(
                            'full_name' => $nama,
                            'email' => $email,
                            'role_id' => $role['id'],
                            'is_active' => $is_active_val
                        );
                        if ($password !== '') {
                            $user_update['password'] = password_hash($password, PASSWORD_DEFAULT);
                        }
                        $this->db->where('id', $user_id);
                        $this->db->update('users', $user_update);
                    } else {
                        if ($existing_user) {
                            $error_count++;
                            continue;
                        }
                        $pass_val = ($password !== '') ? $password : '123456';
                        $user_insert = array(
                            'username' => $username,
                            'email' => $email,
                            'password' => password_hash($pass_val, PASSWORD_DEFAULT),
                            'full_name' => $nama,
                            'role_id' => $role['id'],
                            'is_active' => $is_active_val
                        );
                        $this->db->insert('users', $user_insert);
                        $user_id = $this->db->insert_id();
                    }

                    $guru_data = array(
                        'user_id' => $user_id,
                        'nip' => $nip,
                        'nama_lengkap' => $nama,
                        'gelar_depan' => $gelar_d !== '' ? $gelar_d : NULL,
                        'gelar_belakang' => $gelar_b !== '' ? $gelar_b : NULL,
                        'jk' => $jk,
                        'no_hp' => $no_hp !== '' ? $no_hp : NULL,
                        'email' => $email !== '' ? $email : NULL,
                        'status_kepegawaian' => $status_kepegawaian
                    );

                    $guru_id = NULL;
                    if ($existing_guru) {
                        $guru_id = $existing_guru['id'];
                        $this->db->where('id', $guru_id);
                        $this->db->update('guru', $guru_data);
                    } else {
                        $this->db->insert('guru', $guru_data);
                        $guru_id = $this->db->insert_id();
                    }

                    $this->master_model->save_guru_mapel($guru_id, $mapel_ids);
                    $success_count++;

                } else {
                    $kode = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                    $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                    $kelompok = trim($sheet->getCell('C' . $row)->getValue() ?? 'Wajib');
                    $kkm = trim($sheet->getCell('D' . $row)->getValue() ?? '75.00');
                    $nip_guru = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                    $kode_kelas = trim($sheet->getCell('F' . $row)->getValue() ?? '');
                    $semester = trim($sheet->getCell('G' . $row)->getValue() ?? 'Ganjil');
                    $tahun_tp = trim($sheet->getCell('H' . $row)->getValue() ?? '');
                    $status = trim($sheet->getCell('I' . $row)->getValue() ?? 'Aktif');

                    if ($kode === '' && $nama === '') continue;

                    if ($kode === '' || $nama === '' || ($semester !== 'Ganjil' && $semester !== 'Genap') || ($status !== 'Aktif' && $status !== 'Non-Aktif')) {
                        $error_count++;
                        continue;
                    }

                    $guru_id = NULL;
                    if ($nip_guru !== '') {
                        $guru = $this->db->get_where('guru', array('nip' => $nip_guru))->row_array();
                        if ($guru) {
                            $guru_id = $guru['id'];
                        } else {
                            $error_count++;
                            continue;
                        }
                    }

                    $kelas_id = NULL;
                    if ($kode_kelas !== '') {
                        $kelas = $this->db->get_where('kelas', array('kode_kelas' => $kode_kelas))->row_array();
                        if ($kelas) {
                            $kelas_id = $kelas['id'];
                        } else {
                            $error_count++;
                            continue;
                        }
                    }

                    $tp_id = NULL;
                    if ($tahun_tp !== '') {
                        $tp = $this->db->get_where('tahun_pelajaran', array('tahun' => $tahun_tp, 'semester' => $semester))->row_array();
                        if ($tp) {
                            $tp_id = $tp['id'];
                        } else {
                            $error_count++;
                            continue;
                        }
                    }

                    $existing = $this->db->get_where('mata_pelajaran', array('kode_mapel' => $kode))->row_array();
                    $data_save = array(
                        'kode_mapel' => $kode,
                        'nama_mapel' => $nama,
                        'kelompok' => $kelompok,
                        'kkm' => $kkm,
                        'guru_id' => $guru_id,
                        'kelas_id' => $kelas_id,
                        'semester' => $semester,
                        'tahun_pelajaran_id' => $tp_id,
                        'status' => $status
                    );

                    if ($existing) {
                        $this->db->where('id', $existing['id']);
                        $this->db->update('mata_pelajaran', $data_save);
                    } else {
                        $this->db->insert('mata_pelajaran', $data_save);
                    }
                    $success_count++;
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal memproses transaksi import.');
            } else {
                $this->db->trans_commit();
                $msg = "Import data berhasil! $success_count baris data disimpan.";
                if ($error_count > 0) {
                    $msg .= " Namun terdapat $error_count baris dilewati karena validasi gagal.";
                }
                $this->session->set_flashdata('success', $msg);
            }

        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Error memproses data import: ' . $e->getMessage());
        }

        if (file_exists($file_path)) unlink($file_path);
        redirect('master/' . $module);
    }
}
