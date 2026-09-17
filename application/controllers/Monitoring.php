<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends Kamad_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('presensikelas_model');
    }

    public function index() {
        $data['title'] = 'Monitoring KBM & Kehadiran Kelas';
        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $filters = array(
            'kelas_id' => $this->input->get('kelas_id', TRUE),
            'mapel_id' => $this->input->get('mapel_id', TRUE),
            'guru_id' => $this->input->get('guru_id', TRUE),
            'status_pembelajaran' => $this->input->get('status_pembelajaran', TRUE),
            'tanggal_mulai' => $this->input->get('tanggal_mulai', TRUE),
            'tanggal_selesai' => $this->input->get('tanggal_selesai', TRUE),
            'tahun_pelajaran_id' => $active_tp['id']
        );

        $data['list_kelas'] = $this->master_model->get_all_kelas();
        $data['list_mapel'] = $this->master_model->get_all_mapel();
        $data['list_guru'] = $this->master_model->get_all_guru();

        $logs = $this->presensikelas_model->get_all_with_relations($filters);
        
        // Enrich logs with student presence counts
        foreach ($logs as &$log) {
            $this->db->select('status, COUNT(*) as count');
            $this->db->where('presensi_kelas_id', $log['id']);
            $this->db->group_by('status');
            $counts = $this->db->get('presensi_siswa')->result_array();

            $log['hadir_count'] = 0;
            $log['sakit_count'] = 0;
            $log['izin_count'] = 0;
            $log['alpa_count'] = 0;
            $log['terlambat_count'] = 0;
            $log['dispen_count'] = 0;
            $log['total_count'] = 0;

            foreach ($counts as $c) {
                $status = strtolower($c['status']);
                if ($status == 'hadir') $log['hadir_count'] = (int)$c['count'];
                elseif ($status == 'sakit') $log['sakit_count'] = (int)$c['count'];
                elseif ($status == 'izin') $log['izin_count'] = (int)$c['count'];
                elseif ($status == 'alpa' || $status == 'alpha') $log['alpa_count'] = (int)$c['count'];
                elseif ($status == 'terlambat') $log['terlambat_count'] = (int)$c['count'];
                elseif ($status == 'dispen') $log['dispen_count'] = (int)$c['count'];

                $log['total_count'] += (int)$c['count'];
            }
        }

        $data['logs'] = $logs;
        $data['filters'] = $filters;

        // Visual stats for monitoring header
        $data['total_jurnal'] = $this->db->count_all_results('jurnal_guru');
        $data['total_presensi_kelas'] = $this->db->count_all_results('presensi_kelas');
        $data['terlaksana_count'] = $this->db->where('status_pembelajaran', 'Terlaksana')->count_all_results('presensi_kelas');
        $data['tidak_terlaksana_count'] = $this->db->where('status_pembelajaran', 'Tidak Terlaksana')->count_all_results('presensi_kelas');
        
        $hadir_siswa = $this->db->where_in('status', array('Hadir', 'Terlambat', 'Dispen'))->count_all_results('presensi_siswa');
        $total_siswa = $this->db->count_all_results('presensi_siswa');
        $data['siswa_attendance_rate'] = ($total_siswa > 0) ? round(($hadir_siswa / $total_siswa) * 100, 1) : 100.0;

        $this->template->load('layout/main', 'monitoring/index', $data);
    }
}
