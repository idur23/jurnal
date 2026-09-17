<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensikelas extends Guru_Controller {

    protected $presensiService;

    public function __construct() {
        parent::__construct();
        $this->presensiService = new PresensiService();
    }

    public function index() {
        $data['title'] = 'Presensi Kelas';
        $role = $this->current_user['role_code'];
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'status_pembelajaran' => $this->input->get('status_pembelajaran', TRUE),
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

        $data['list_presensi_kelas'] = $this->presensiService->get_presensi_kelas_list($filters);
        $data['filters'] = $filters;

        $this->template->load('layout/main', 'presensikelas/index', $data);
    }

    public function add($jurnal_id) {
        $this->load->model('jurnal_model');
        $jurnal = $this->jurnal_model->get_jurnal_detail($jurnal_id);
        if (!$jurnal) {
            $this->session->set_flashdata('error', 'Jurnal Mengajar tidak ditemukan.');
            redirect('jurnal');
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('status_pembelajaran', 'Status Pembelajaran', 'required');
            $this->form_validation->set_rules('pertemuan_ke', 'Pertemuan Ke', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $result = $this->presensiService->create_presensi_kelas($jurnal_id, $this->input->post(NULL, TRUE), $_FILES);
                
                if ($result['status']) {
                    $this->session->set_flashdata('success', 'Presensi Kelas berhasil disimpan! Silakan lanjutkan mengisi Presensi Kehadiran Siswa.');
                    redirect('presensi/input/' . $result['presensi_kelas_id']);
                    return;
                } else {
                    $this->session->set_flashdata('error', $result['message']);
                    redirect('jurnal');
                    return;
                }
            }
        }

        $data['title'] = 'Buat Presensi Kelas';
        $data['jurnal'] = $jurnal;
        $data['list_ruangan'] = $this->db->get('ruangan')->result_array();

        // Auto-select ruangan dari jadwal_pelajaran berdasarkan kelas, mapel, dan guru
        $scheduled_ruangan_id = NULL;
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        if ($active_tp) {
            $jadwal = $this->db
                ->select('jadwal_pelajaran.ruangan_id')
                ->from('jadwal_pelajaran')
                ->where('jadwal_pelajaran.kelas_id', $jurnal['kelas_id'])
                ->where('jadwal_pelajaran.mapel_id', $jurnal['mapel_id'])
                ->where('jadwal_pelajaran.guru_id', $jurnal['guru_id'])
                ->where('jadwal_pelajaran.tahun_pelajaran_id', $active_tp['id'])
                ->where('jadwal_pelajaran.ruangan_id IS NOT NULL', NULL, FALSE)
                ->limit(1)
                ->get()
                ->row_array();
            if ($jadwal && !empty($jadwal['ruangan_id'])) {
                $scheduled_ruangan_id = $jadwal['ruangan_id'];
            }
        }
        $data['scheduled_ruangan_id'] = $scheduled_ruangan_id;

        $this->template->load('layout/main', 'presensikelas/add', $data);

    }

    public function edit($id) {
        $presensi_kelas = $this->presensiService->get_presensi_kelas_detail($id);
        if (!$presensi_kelas) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('status_pembelajaran', 'Status Pembelajaran', 'required');
            $this->form_validation->set_rules('pertemuan_ke', 'Pertemuan Ke', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $result = $this->presensiService->update_presensi_kelas($id, $this->input->post(NULL, TRUE), $_FILES);
                
                if ($result['status']) {
                    $this->session->set_flashdata('success', 'Presensi Kelas berhasil diubah.');
                    redirect('presensikelas');
                    return;
                } else {
                    $this->session->set_flashdata('error', $result['message']);
                }
            }
        }

        $data['title'] = 'Edit Presensi Kelas';
        $data['pk'] = $presensi_kelas;
        $data['list_ruangan'] = $this->db->get('ruangan')->result_array();

        $this->template->load('layout/main', 'presensikelas/edit', $data);
    }

    public function delete($id) {
        if ($this->presensiService->delete_presensi_kelas($id)) {
            $this->session->set_flashdata('success', 'Presensi Kelas dan kehadiran siswa terkait berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus Presensi Kelas.');
        }
        redirect('presensikelas');
    }
}
