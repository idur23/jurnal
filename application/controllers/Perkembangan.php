<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perkembangan extends Guru_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('perkembangan_model');
    }

    public function index() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        if (in_array($role, array('guru', 'walikelas')) && $guru) {
            $allowed_mapels = $this->master_model->get_mapel_by_guru($guru['id'], $active_tp['id']);
            $allowed_mapel_ids = array_column($allowed_mapels, 'id');

            if ($mapel_id && !in_array($mapel_id, $allowed_mapel_ids)) {
                $this->session->set_flashdata('error', 'Akses ditolak: Anda hanya dapat mengakses mapel yang diampu.');
                redirect('perkembangan');
                return;
            }
        }

        if ($this->input->post('action') == 'save_perkembangan') {
            $p_kelas_id = $this->input->post('kelas_id', TRUE);
            $p_mapel_id = $this->input->post('mapel_id', TRUE);
            
            $catatan = $this->input->post('catatan_perkembangan', TRUE);
            $kelebihan = $this->input->post('kelebihan', TRUE);
            $kekurangan = $this->input->post('kekurangan', TRUE);
            $perilaku = $this->input->post('perilaku', TRUE);
            $keaktifan = $this->input->post('keaktifan', TRUE);
            $kedisiplinan = $this->input->post('kedisiplinan', TRUE);
            $motivasi = $this->input->post('motivasi', TRUE);
            $rekomendasi = $this->input->post('rekomendasi', TRUE);

            $guru_id = $guru ? $guru['id'] : 1;

            $batch_data = array();
            if (!empty($catatan) && is_array($catatan)) {
                foreach ($catatan as $siswa_id => $val) {
                    $batch_data[] = array(
                        'tahun_pelajaran_id' => $active_tp['id'],
                        'kelas_id' => $p_kelas_id,
                        'mapel_id' => $p_mapel_id,
                        'siswa_id' => $siswa_id,
                        'guru_id' => $guru_id,
                        'catatan_perkembangan' => $val,
                        'kelebihan' => isset($kelebihan[$siswa_id]) ? $kelebihan[$siswa_id] : '',
                        'kekurangan' => isset($kekurangan[$siswa_id]) ? $kekurangan[$siswa_id] : '',
                        'perilaku' => isset($perilaku[$siswa_id]) ? $perilaku[$siswa_id] : '',
                        'keaktifan' => isset($keaktifan[$siswa_id]) ? $keaktifan[$siswa_id] : '',
                        'kedisiplinan' => isset($kedisiplinan[$siswa_id]) ? $kedisiplinan[$siswa_id] : '',
                        'motivasi' => isset($motivasi[$siswa_id]) ? $motivasi[$siswa_id] : '',
                        'rekomendasi' => isset($rekomendasi[$siswa_id]) ? $rekomendasi[$siswa_id] : ''
                    );
                }
            }

            $saved = $this->perkembangan_model->save_batch_perkembangan($batch_data);
            if ($saved) {
                $this->logger_lib->log('SAVE_PERKEMBANGAN', "Menyimpan perkembangan diri siswa Kelas ID: $p_kelas_id");
                $this->session->set_flashdata('success', 'Catatan perkembangan diri siswa berhasil disimpan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan catatan perkembangan diri.');
            }
            redirect("perkembangan?kelas_id=$p_kelas_id&mapel_id=$p_mapel_id");
            return;
        }

        $data['title'] = 'Perkembangan Diri Siswa';

        if (in_array($role, array('guru', 'walikelas'))) {
            if ($guru) {
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

        $data['selected_kelas_id'] = $kelas_id;
        $data['selected_mapel_id'] = $mapel_id;
        
        $data['siswa'] = array();
        $data['existing_data'] = array();

        if ($kelas_id) {
            $data['siswa'] = $this->master_model->get_siswa_by_kelas($kelas_id);
            if ($mapel_id) {
                $data['existing_data'] = $this->perkembangan_model->get_perkembangan_by_filters($kelas_id, $mapel_id, $active_tp['id']);
            } else {
                $raw_rekap = $this->db->get_where('perkembangan_rekap', array('kelas_id' => $kelas_id, 'tahun_pelajaran_id' => $active_tp['id']))->result_array();
                $rekap_map = array();
                foreach ($raw_rekap as $rr) {
                    $rekap_map[$rr['siswa_id']] = $rr;
                }
                $data['rekap_data'] = $rekap_map;
            }
        }

        $this->template->load('layout/main', 'perkembangan/index', $data);
    }

    public function profil($siswa_id) {
        $siswa_id = (int)$siswa_id;
        $role = $this->current_user['role_code'];
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        // 1. Get Siswa
        $siswa = $this->db->select('siswa.*, kelas.nama_kelas, kelas.tingkat, guru.nama_lengkap as nama_wali, guru.nip as nip_wali, kelas.wali_kelas_id')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
            ->where('siswa.id', $siswa_id)
            ->get('siswa')->row_array();

        if (!$siswa) {
            show_404();
            return;
        }

        // Access check
        if ($role == 'guru') {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            if (!$guru) {
                $this->session->set_flashdata('error', 'Akses ditolak.');
                redirect('dashboard');
                return;
            }
            $allowed_kelas = $this->master_model->get_kelas_by_guru($guru['id'], $active_tp['id']);
            $allowed_kelas_ids = array_column($allowed_kelas, 'id');
            if (!in_array($siswa['kelas_id'], $allowed_kelas_ids)) {
                $this->session->set_flashdata('error', 'Akses ditolak: Anda hanya dapat mengakses siswa kelas binaan/diampu.');
                redirect('perkembangan');
                return;
            }
        } elseif ($role == 'walikelas') {
            $wali_kelas = $this->master_model->get_kelas_by_wali_user_id($this->current_user['id']);
            if (!$wali_kelas || ($wali_kelas['id'] != $siswa['kelas_id'])) {
                $this->session->set_flashdata('error', 'Akses ditolak: Anda hanya dapat mengakses siswa kelas binaan.');
                redirect('dashboard');
                return;
            }
        }

        $data['title'] = 'Profil Perkembangan Siswa';
        $data['siswa'] = $siswa;
        $data['active_tp'] = $active_tp;
        $data['role'] = $role;

        // 2. Fetch subject teacher evaluations
        $data['catatan_mapel'] = $this->perkembangan_model->get_perkembangan_grouped_by_siswa($siswa_id, $active_tp['id']);

        // 3. Fetch homeroom teacher overall rekap
        $data['rekap'] = $this->perkembangan_model->get_rekap_by_siswa($siswa_id, $active_tp['id']);

        // 4. Fetch previous semesters developments
        $data['riwayat_sebelumnya'] = $this->perkembangan_model->get_riwayat_perkembangan_sebelumnya($siswa_id, $active_tp['id']);

        // 5. Presensi summary (Kehadiran) - Single Source of Truth
        $this->db->select('presensi_siswa.status, COUNT(*) as total');
        $this->db->from('presensi_siswa');
        $this->db->join('presensi_kelas', 'presensi_kelas.id = presensi_siswa.presensi_kelas_id');
        $this->db->join('jurnal_guru', 'jurnal_guru.id = presensi_kelas.jurnal_id');
        $this->db->where('presensi_siswa.siswa_id', $siswa_id);
        $this->db->where('jurnal_guru.tahun_pelajaran_id', $active_tp['id']);
        $this->db->group_by('presensi_siswa.status');
        $presensi_raw = $this->db->get()->result_array();

        $presensi = array('Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpa' => 0, 'Dispen' => 0);
        foreach ($presensi_raw as $p) {
            $presensi[$p['status']] = (int)$p['total'];
        }
        $data['presensi'] = $presensi;

        // 6. Penilaian summary (Academic) - Single Source of Truth
        $this->db->select('mata_pelajaran.nama_mapel, AVG(penilaian_siswa.nilai) as rata_nilai');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = penilaian_siswa.mapel_id');
        $this->db->where('penilaian_siswa.siswa_id', $siswa_id);
        $this->db->where('penilaian_siswa.tahun_pelajaran_id', $active_tp['id']);
        $this->db->group_by('penilaian_siswa.mapel_id');
        $data['nilai_summary'] = $this->db->get('penilaian_siswa')->result_array();

        // Calculate overall average academic grade
        $total_nilai = 0;
        $count_mapel = count($data['nilai_summary']);
        foreach ($data['nilai_summary'] as $ns) {
            $total_nilai += $ns['rata_nilai'];
        }
        $data['rata_nilai_total'] = $count_mapel > 0 ? round($total_nilai / $count_mapel, 2) : 0;

        // 7. Non-academic ratings mapping for Chart.js
        $weights = array(
            'Sangat Baik' => 4, 'Sangat Aktif' => 4, 'Sangat Tinggi' => 4, 'Sangat Disiplin' => 4,
            'Baik' => 3, 'Aktif' => 3, 'Tinggi' => 3, 'Disiplin' => 3,
            'Cukup' => 2, 'Cukup Aktif' => 2, 'Sedang' => 2, 'Cukup Disiplin' => 2,
            'Kurang' => 1, 'Pasif' => 1, 'Rendah' => 1, 'Kurang Disiplin' => 1
        );

        $aspek_scores = array('perilaku' => 0, 'keaktifan' => 0, 'kedisiplinan' => 0, 'motivasi' => 0);
        $aspek_counts = array('perilaku' => 0, 'keaktifan' => 0, 'kedisiplinan' => 0, 'motivasi' => 0);

        foreach ($data['catatan_mapel'] as $cm) {
            foreach ($aspek_scores as $aspek => $val) {
                if (!empty($cm[$aspek]) && isset($weights[$cm[$aspek]])) {
                    $aspek_scores[$aspek] += $weights[$cm[$aspek]];
                    $aspek_counts[$aspek]++;
                }
            }
        }

        $chart_data = array();
        foreach ($aspek_scores as $aspek => $val) {
            $chart_data[$aspek] = $aspek_counts[$aspek] > 0 ? round($val / $aspek_counts[$aspek], 2) : 0;
        }
        $data['chart_data'] = $chart_data;

        $this->template->load('layout/main', 'perkembangan/profil', $data);
    }

    public function save_rekap() {
        $role = $this->current_user['role_code'];
        if (!in_array($role, array('admin', 'walikelas', 'guru'))) {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('dashboard');
            return;
        }

        $siswa_id = $this->input->post('siswa_id', TRUE);
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $siswa = $this->db->get_where('siswa', array('id' => $siswa_id))->row_array();

        if (!$siswa) {
            $this->session->set_flashdata('error', 'Siswa tidak ditemukan.');
            redirect('dashboard');
            return;
        }

        if ($role == 'walikelas') {
            $wali_kelas = $this->master_model->get_kelas_by_wali_user_id($this->current_user['id']);
            $wali_id = $wali_kelas ? $wali_kelas['guru_id'] : ($siswa['wali_kelas_id'] ? $siswa['wali_kelas_id'] : 1);
        } elseif ($role == 'guru') {
            $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);
            $wali_id = $guru ? $guru['id'] : ($siswa['wali_kelas_id'] ? $siswa['wali_kelas_id'] : 1);
        } else {
            $wali_id = $siswa['wali_kelas_id'] ? $siswa['wali_kelas_id'] : 1;
        }

        $insert_data = array(
            'tahun_pelajaran_id' => $active_tp['id'],
            'siswa_id' => $siswa_id,
            'kelas_id' => $siswa['kelas_id'],
            'wali_id' => $wali_id,
            'kesimpulan_wali' => $this->input->post('kesimpulan_wali', TRUE),
            'tindak_lanjut' => $this->input->post('tindak_lanjut', TRUE),
            'status_perkembangan' => $this->input->post('status_perkembangan', TRUE)
        );

        $saved = $this->perkembangan_model->save_rekap_perkembangan($insert_data);
        if ($saved) {
            $this->logger_lib->log('SAVE_REKAP_PERKEMBANGAN', "Menyimpan rekap perkembangan siswa ID: $siswa_id");
            $this->session->set_flashdata('success', 'Kesimpulan wali kelas berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan kesimpulan wali kelas.');
        }
        redirect("perkembangan/profil/$siswa_id");
    }
}

