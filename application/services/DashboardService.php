<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));
    }

    public function get_dashboard_data($role, $user_id) {
        $cache_key = "dashboard_data_{$role}_{$user_id}";
        
        $cached_data = $this->CI->cache->get($cache_key);
        if ($cached_data !== FALSE) {
            return $cached_data;
        }

        $this->CI->load->model('master_model');
        $this->CI->load->model('jurnal_model');

        $data = array();

        // 1. Core Global Metrics
        $data['total_guru'] = $this->CI->master_model->count_all('guru');
        $data['total_siswa'] = $this->CI->db->where('status_aktif', 1)->count_all_results('siswa');
        $data['total_kelas'] = $this->CI->master_model->count_all('kelas');
        $data['jurnal_today'] = $this->CI->db->where('tanggal', date('Y-m-d'))->count_all_results('jurnal_guru');

        // 2. KBM Stats
        $data['total_jurnal'] = $this->CI->db->count_all_results('jurnal_guru');
        $data['total_presensi_kelas'] = $this->CI->db->count_all_results('presensi_kelas');
        $data['total_presensi_siswa'] = $this->CI->db->count_all_results('presensi_siswa');
        
        $data['pembelajaran_terlaksana'] = $this->CI->db->where('status_pembelajaran', 'Terlaksana')->count_all_results('presensi_kelas');
        $data['pembelajaran_tidak_terlaksana'] = $this->CI->db->where('status_pembelajaran', 'Tidak Terlaksana')->count_all_results('presensi_kelas');

        $data['persen_guru'] = ($data['total_jurnal'] > 0) ? round(($data['pembelajaran_terlaksana'] / $data['total_jurnal']) * 100, 1) : 100.0;
        
        $hadir_siswa = $this->CI->db->where_in('status', array('Hadir', 'Terlambat', 'Dispen'))->count_all_results('presensi_siswa');
        $data['persen_siswa'] = ($data['total_presensi_siswa'] > 0) ? round(($hadir_siswa / $data['total_presensi_siswa']) * 100, 1) : 100.0;

        // 3. User Specific Filters
        $guru_id = NULL;
        $kelas_id = NULL;
        
        if ($role == 'guru') {
            $guru = $this->CI->master_model->get_guru_by_user_id($user_id);
            $guru_id = isset($guru['id']) ? $guru['id'] : 0;
        } elseif ($role == 'walikelas') {
            $kelas = $this->CI->master_model->get_kelas_by_wali_user_id($user_id);
            $kelas_id = isset($kelas['id']) ? $kelas['id'] : 0;
        }

        // 4. Recent Jurnal Activity
        $recent_jurnal = $this->CI->jurnal_model->get_jurnal_filtered(array(
            'guru_id' => $guru_id,
            'kelas_id' => $kelas_id
        ));
        $data['recent_jurnal'] = array_slice($recent_jurnal, 0, 5);

        // 5. Chart Data (Attendance status summary today)
        $this->CI->db->select('status, COUNT(*) as count');
        $this->CI->db->where('tanggal', date('Y-m-d'));
        $this->CI->db->group_by('status');
        $presensi_summary = $this->CI->db->get('presensi_siswa')->result_array();

        $chart_data = array('Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpa' => 0, 'Dispen' => 0);
        foreach ($presensi_summary as $ps) {
            if (isset($chart_data[$ps['status']])) {
                $chart_data[$ps['status']] = (int)$ps['count'];
            }
        }
        $data['presensi_chart'] = $chart_data;

        // Save cache for 5 minutes (300 seconds)
        $this->CI->cache->save($cache_key, $data, 300);

        return $data;
    }

    public function clear_dashboard_cache() {
        // Simple helper to flush cache
        $this->CI->cache->clean();
    }
}
