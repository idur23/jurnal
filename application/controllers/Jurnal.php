<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal extends Guru_Controller {

    protected $jurnalService;
    protected $perangkatService;

    public function __construct() {
        parent::__construct();
        $this->jurnalService = new JurnalService();
        $this->perangkatService = new PerangkatService();
    }

    public function index() {
        $data['title'] = 'Jurnal Guru & Kegiatan KBM';
        $role = $this->current_user['role_code'];
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'tanggal_mulai' => $this->input->get('tanggal_mulai', TRUE),
            'tanggal_selesai' => $this->input->get('tanggal_selesai', TRUE)
        );

        if (in_array($role, array('guru', 'walikelas', 'waka'))) {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            if ($guru) {
                $filters['guru_id'] = $guru['id'];
                $data['list_kelas'] = $this->master_model->get_kelas_by_guru($guru['id'], $active_tp['id']);
                $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
            } else {
                $data['list_kelas'] = $this->master_model->get_all_kelas();
                $data['list_mapel'] = $this->master_model->get_all_mapel();
            }
        } else {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
        }

        $data['list_jurnal'] = $this->jurnalService->get_jurnal_list($filters);
        $data['filters'] = $filters;

        $this->template->load('layout/main', 'jurnal/index', $data);
    }

    public function add() {
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];

        if ($this->input->post()) {
            $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
            $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
            $this->form_validation->set_rules('materi_pembelajaran', 'Materi Pembelajaran', 'required');

            if ($this->form_validation->run() == TRUE) {
                $result = $this->jurnalService->create_jurnal(
                    $this->input->post(NULL, TRUE), 
                    $_FILES, 
                    $active_tp, 
                    $this->current_user['id']
                );

                if ($result['status']) {
                    $this->session->set_flashdata('success', 'Jurnal Pembelajaran berhasil disimpan! Silakan lanjutkan dengan mengisi Presensi Kelas.');
                    redirect('presensikelas/add/' . $result['jurnal_id']);
                    return;
                } else {
                    $this->session->set_flashdata('error', $result['message']);
                }
            }
        }

        $data['title'] = 'Input Jurnal Pembelajaran Baru';

        // Preload query string values for schedule integration
        $data['pre_kelas_id'] = $this->input->get('kelas_id', TRUE);
        $data['pre_mapel_id'] = $this->input->get('mapel_id', TRUE);
        $data['pre_pertemuan_ke'] = $this->input->get('pertemuan_ke', TRUE);
        $data['pre_jam_mulai_ke'] = $this->input->get('jam_mulai_ke', TRUE);
        $data['pre_jam_selesai_ke'] = $this->input->get('jam_selesai_ke', TRUE);

        if (in_array($role, array('guru', 'walikelas', 'waka'))) {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            if ($guru) {
                $data['list_kelas'] = $this->master_model->get_kelas_by_guru($guru['id'], $active_tp['id']);
                $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
                $data['guru_id'] = $guru['id'];
            } else {
                $data['list_kelas'] = $this->master_model->get_all_kelas();
                $data['list_mapel'] = $this->master_model->get_all_mapel();
                $data['guru_id'] = 0;
            }
        } else {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
            $data['guru_id'] = $this->input->get('guru_id', TRUE) ? $this->input->get('guru_id', TRUE) : 0;
        }

        $data['list_guru'] = $this->master_model->get_all_guru();
        $data['list_jam'] = $this->master_model->get_all_jam();

        $this->template->load('layout/main', 'jurnal/add', $data);
    }

    public function edit($id) {
        $jurnal = $this->jurnalService->get_jurnal_detail($id);
        if (!$jurnal) {
            show_404();
        }

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];

        if ($this->input->post()) {
            $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
            $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
            $this->form_validation->set_rules('materi_pembelajaran', 'Materi Pembelajaran', 'required');

            if ($this->form_validation->run() == TRUE) {
                $result = $this->jurnalService->update_jurnal(
                    $id,
                    $this->input->post(NULL, TRUE), 
                    $_FILES, 
                    $active_tp, 
                    $this->current_user['id']
                );

                if ($result['status']) {
                    $this->session->set_flashdata('success', 'Jurnal Pembelajaran berhasil diperbarui!');
                    redirect('jurnal');
                    return;
                } else {
                    $this->session->set_flashdata('error', $result['message']);
                }
            }
        }

        $data['title'] = 'Edit Jurnal Pembelajaran - ' . $jurnal['kode_jurnal'];
        $data['jurnal'] = $jurnal;

        // Parse jam_ke string into jam_mulai & jam_selesai
        $jam_parts = explode('-', $jurnal['jam_ke']);
        $data['jam_mulai_ke'] = isset($jam_parts[0]) ? (int)$jam_parts[0] : 1;
        $data['jam_selesai_ke'] = isset($jam_parts[1]) ? (int)$jam_parts[1] : $data['jam_mulai_ke'];

        if (in_array($role, array('guru', 'walikelas', 'waka'))) {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            if ($guru) {
                $data['list_kelas'] = $this->master_model->get_kelas_by_guru($guru['id'], $active_tp['id']);
                $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
                $data['guru_id'] = $guru['id'];
            } else {
                $data['list_kelas'] = $this->master_model->get_all_kelas();
                $data['list_mapel'] = $this->master_model->get_all_mapel();
                $data['guru_id'] = $jurnal['guru_id'];
            }
        } else {
            $data['list_kelas'] = $this->master_model->get_all_kelas();
            $data['list_mapel'] = $this->master_model->get_all_mapel();
            $data['guru_id'] = $jurnal['guru_id'];
        }

        $data['list_guru'] = $this->master_model->get_all_guru();
        $data['list_jam'] = $this->master_model->get_all_jam();

        $this->template->load('layout/main', 'jurnal/edit', $data);
    }

    public function jadwal() {
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        
        $data['title'] = 'Jadwal Mengajar Anda';
        
        if (in_array($role, array('guru', 'walikelas', 'waka'))) {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            if ($guru) {
                $this->db->select('jadwal_pelajaran.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, ruangan.nama_ruangan');
                $this->db->join('kelas', 'kelas.id = jadwal_pelajaran.kelas_id');
                $this->db->join('mata_pelajaran', 'mata_pelajaran.id = jadwal_pelajaran.mapel_id');
                $this->db->join('ruangan', 'ruangan.id = jadwal_pelajaran.ruangan_id', 'left');
                $this->db->where('jadwal_pelajaran.guru_id', $guru['id']);
                $this->db->where('jadwal_pelajaran.tahun_pelajaran_id', $active_tp['id']);
                $this->db->order_by('FIELD(jadwal_pelajaran.hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu")');
                $this->db->order_by('jadwal_pelajaran.jam_mulai_ke', 'ASC');
                $data['schedules'] = $this->db->get('jadwal_pelajaran')->result_array();
            } else {
                $data['schedules'] = array();
            }
        } else {
            // Admin, Kamad
            $data['schedules'] = $this->master_model->get_all_jadwal($active_tp['id']);
        }
        
        $this->template->load('layout/main', 'jurnal/jadwal', $data);
    }

    public function get_perangkat_ajax() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $pertemuan_ke = $this->input->get('pertemuan_ke', TRUE);
        
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
        $guru_id = $guru ? $guru['id'] : $this->input->get('guru_id', TRUE);

        if (!$kelas_id || !$mapel_id || !$pertemuan_ke || !$guru_id) {
            return json_response(false, 'Parameter pencarian tidak lengkap.');
        }

        $device = $this->perangkatService->get_matched_device(
            $active_tp['id'],
            $active_tp['semester'],
            $mapel_id,
            $guru_id,
            $kelas_id,
            $pertemuan_ke
        );

        if (!$device) {
            return json_response(false, 'Perangkat Ajar belum tersedia untuk KBM ini.');
        }

        $this->load->model('perangkat_model');
        $versions = $this->perangkat_model->get_version_history($device['id']);
        
        $response_data = array(
            'device' => $device,
            'versions' => $versions,
            'warning' => ($device['status_verifikasi'] != 'Disetujui') ? 'Perangkat Ajar belum diverifikasi/disetujui (Status: ' . $device['status_verifikasi'] . '). Tetap gunakan?' : null
        );

        return json_response(true, 'Perangkat Ajar ditemukan.', $response_data);
    }

    public function detail($id) {
        $jurnal = $this->jurnalService->get_jurnal_detail($id);
        if (!$jurnal) {
            show_404();
        }

        $this->load->model('presensikelas_model');
        $this->load->model('poin_keaktifan_model');
        $data['title'] = 'Detail Jurnal ' . $jurnal['kode_jurnal'];
        $data['jurnal'] = $jurnal;
        $data['presensi_kelas'] = $this->presensikelas_model->get_by_jurnal($id);
        $data['presensi'] = $this->presensi_model->get_presensi_by_jurnal($id);
        $data['poin_siswa'] = $this->poin_keaktifan_model->get_poin_by_jurnal($id, $jurnal['kelas_id']);

        $this->template->load('layout/main', 'jurnal/detail', $data);
    }

    public function get_siswa_ajax() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        if (!$kelas_id) {
            return json_response(false, 'Parameter Kelas ID wajib diisi');
        }

        $siswa = $this->master_model->get_siswa_by_kelas($kelas_id);
        return json_response(true, 'Data siswa berhasil dimuat', $siswa);
    }

    public function delete($id) {
        if ($this->jurnalService->delete_jurnal($id)) {
            $this->session->set_flashdata('success', 'Jurnal berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jurnal.');
        }
        redirect('jurnal');
    }

    /**
     * AJAX Endpoint: Ambil Detail Rencana Pelaksanaan (Perangkat Ajar) untuk Auto-fill Form Jurnal
     */
    public function get_rencana_detail_ajax() {
        @ini_set('display_errors', 0);
        @error_reporting(0);

        $id = $this->input->get_post('id', TRUE);
        $ids = $this->input->get_post('ids', TRUE);

        if (empty($id) && empty($ids)) {
            $id = $this->input->get_post('perangkat_id', TRUE);
        }

        $id_list = array();
        if (!empty($ids)) {
            if (is_array($ids)) {
                $id_list = $ids;
            } else {
                $id_list = explode(',', $ids);
            }
        } elseif (!empty($id)) {
            $id_list = array($id);
        }

        $id_list = array_filter(array_map('intval', $id_list));

        if (empty($id_list)) {
            echo json_encode(array('success' => false, 'message' => 'Parameter ID Rencana Pelaksanaan wajib diisi'));
            exit;
        }

        // First check in dedicated table rencana_pelaksanaan
        $this->db->select('rencana_pelaksanaan.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = rencana_pelaksanaan.mapel_id', 'left');
        $this->db->join('kelas', 'kelas.id = rencana_pelaksanaan.kelas_id', 'left');
        $this->db->where_in('rencana_pelaksanaan.id', $id_list);
        $list = $this->db->get('rencana_pelaksanaan')->result_array();

        if (empty($list)) {
            // Fallback to legacy/perangkat_ajar table
            $this->db->select('perangkat_ajar.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
            $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id', 'left');
            $this->db->join('kelas', 'kelas.id = perangkat_ajar.kelas_id', 'left');
            $this->db->where_in('perangkat_ajar.id', $id_list);
            $list = $this->db->get('perangkat_ajar')->result_array();
        }

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        if (!empty($list)) {
            // Helper to combine text values from all items without duplicates
            $combine_text = function($field_name, $separator = '; ') use ($list) {
                $unique_vals = array();
                foreach ($list as $item) {
                    if (!empty($item[$field_name])) {
                        $parts = explode(',', $item[$field_name]);
                        foreach ($parts as $p) {
                            $trimmed = trim($p);
                            if ($trimmed !== '' && !in_array($trimmed, $unique_vals)) {
                                $unique_vals[] = $trimmed;
                            }
                        }
                    }
                }
                return implode($separator, $unique_vals);
            };

            $first = $list[0];
            $combined = array(
                'id'                   => implode(',', array_column($list, 'id')),
                'materi_pembelajaran'  => $combine_text('materi_pembelajaran', '; '),
                'sub_materi'           => $combine_text('sub_materi', '; '),
                'capaian_pembelajaran' => $combine_text('capaian_pembelajaran', "\n"),
                'tujuan_pembelajaran'  => $combine_text('tujuan_pembelajaran', "\n"),
                'metode_pembelajaran'  => $combine_text('metode_pembelajaran', ', '),
                'model_pembelajaran'   => $combine_text('model_pembelajaran', ', '),
                'media_pembelajaran'   => $combine_text('media_pembelajaran', ', '),
                'sumber_belajar'       => $combine_text('sumber_belajar', ', '),
                'bentuk_penilaian'     => $combine_text('bentuk_penilaian', ', '),
                'alokasi_waktu'        => $first['alokasi_waktu'] ?? '',
                'file_path'            => $first['file_path'] ?? '',
                'jenis_perangkat'      => $first['jenis_perangkat'] ?? 'Perangkat Ajar',
                'fase'                 => $first['fase'] ?? '',
                'pertemuan_ke'         => $first['pertemuan_ke'] ?? 1
            );

            echo json_encode(array('success' => true, 'data' => $combined, 'items' => $list));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Rencana Pelaksanaan tidak ditemukan'));
        }
        exit;
    }
}
