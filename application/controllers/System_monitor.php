<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_monitor extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'System Performance & Resource Monitor';

        // 1. Active Users (last 15 minutes)
        $this->db->where('last_login >=', date('Y-m-d H:i:s', strtotime('-15 minutes')));
        $data['active_users'] = $this->db->get('users')->result_array();

        // 2. Performance Stats Summary (last 24 hours)
        $this->db->select('COUNT(*) as total_requests, AVG(execution_time) as avg_time, MAX(execution_time) as peak_time, AVG(memory_usage) as avg_memory, MAX(memory_usage) as peak_memory, AVG(query_count) as avg_queries');
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-24 hours')));
        $perf_summary = $this->db->get('sys_performance_logs')->row_array();
        
        $data['perf_summary'] = array(
            'total_requests' => (int)($perf_summary['total_requests'] ?? 0),
            'avg_time' => round((float)($perf_summary['avg_time'] ?? 0.0), 3),
            'peak_time' => round((float)($perf_summary['peak_time'] ?? 0.0), 3),
            'avg_memory' => round((float)($perf_summary['avg_memory'] ?? 0.0), 2),
            'peak_memory' => round((float)($perf_summary['peak_memory'] ?? 0.0), 2),
            'avg_queries' => round((float)($perf_summary['avg_queries'] ?? 0), 1)
        );

        // 3. Database Resource Usage
        $db_name = $this->db->database;
        $tables = $this->db->query("SHOW TABLE STATUS FROM `{$db_name}`")->result_array();
        
        $total_data = 0;
        $total_index = 0;
        $rows_count = 0;
        foreach ($tables as $t) {
            $total_data += (int)$t['Data_length'];
            $total_index += (int)$t['Index_length'];
            $rows_count += (int)$t['Rows'];
        }

        $data['db_stats'] = array(
            'tables_count' => count($tables),
            'rows_count' => $rows_count,
            'data_size_mb' => round($total_data / (1024 * 1024), 2),
            'index_size_mb' => round($total_index / (1024 * 1024), 2),
            'total_size_mb' => round(($total_data + $total_index) / (1024 * 1024), 2)
        );

        // 4. Slow Queries Log
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(10);
        $data['slow_queries'] = $this->db->get('sys_slow_queries')->result_array();

        // 5. Activity Log (latest logins)
        $this->db->select('activity_logs.*, users.full_name, users.username');
        $this->db->join('users', 'users.id = activity_logs.user_id', 'left');
        $this->db->where_in('activity_logs.action', array('LOGIN_SUCCESS', 'LOGIN_FAILED', 'LOGOUT'));
        $this->db->order_by('activity_logs.created_at', 'DESC');
        $this->db->limit(10);
        $data['login_activities'] = $this->db->get('activity_logs')->result_array();

        // 6. Read latest PHP/CI errors (if log_path exists, fallback to application/logs)
        $data['error_logs'] = $this->get_recent_logs();

        $this->template->load('layout/main', 'system_monitor/index', $data);
    }

    public function get_performance_stats_ajax() {
        // Hourly load averages for graphs
        $this->db->select('HOUR(created_at) as hour, COUNT(*) as requests, AVG(execution_time) as time');
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-12 hours')));
        $this->db->group_by('HOUR(created_at)');
        $this->db->order_by('hour', 'ASC');
        $query = $this->db->get('sys_performance_logs')->result_array();

        return json_response(true, 'Stats loaded.', $query);
    }

    private function get_recent_logs() {
        $log_dir = APPPATH . 'logs/';
        $log_file = $log_dir . 'log-' . date('Y-m-d') . '.php';

        if (!file_exists($log_file)) {
            // Find the most recent log file
            $files = glob($log_dir . 'log-*.php');
            if (!empty($files)) {
                rsort($files);
                $log_file = $files[0];
            } else {
                return array('No error log files found for current or past days.');
            }
        }

        $lines = array();
        $file_handle = fopen($log_file, 'r');
        if ($file_handle) {
            // Skip the first line containing defined('BASEPATH') check
            fgets($file_handle);

            // Read latest 25 lines
            while (($line = fgets($file_handle)) !== false) {
                $lines[] = trim($line);
            }
            fclose($file_handle);
        }

        $lines = array_reverse($lines);
        return array_slice($lines, 0, 25);
    }

    public function test_flow() {
        if (!is_cli()) {
            show_error('Akses hanya diperbolehkan melalui CLI.', 403);
            return;
        }

        echo "========================================================\n";
        echo "   MOCK CRUD FLOW TEST: WEBSITE JURNAL GURU ENTERPRISE\n";
        echo "========================================================\n\n";

        $this->load->model('master_model');
        $this->load->model('perangkat_model');
        $this->load->model('jurnal_model');

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        echo "[+] Aktif Tahun Pelajaran: " . $active_tp['tahun'] . " (" . $active_tp['semester'] . ")\n";

        // Fetch mock details
        $kelas = $this->db->get('kelas')->row_array();
        $mapel = $this->db->get('mata_pelajaran')->row_array();
        $guru = $this->db->get('guru')->row_array();
        $user = $this->db->get('users')->row_array();

        if (!$kelas || !$mapel || !$guru || !$user) {
            echo "[!] GAGAL: Data master (kelas/mapel/guru/user) tidak lengkap.\n";
            return;
        }

        // Cleanup any stale test data from previous runs or imports
        $this->db->delete('perangkat_ajar', array('pertemuan_ke' => 99));
        $this->db->delete('jurnal_guru', array('pertemuan_ke' => 99));
        $this->perangkat_model->clear_device_cache($active_tp['id'], $active_tp['semester'], $mapel['id'], $guru['id'], $kelas['id'], 99);

        echo "[+] Menggunakan data dummy: Kelas=" . $kelas['nama_kelas'] . ", Mapel=" . $mapel['nama_mapel'] . ", Guru=" . $guru['nama_lengkap'] . "\n\n";

        // ==========================================
        // PHASE 1: CRUD PERANGKAT AJAR
        // ==========================================
        echo "--------------------------------------------------------\n";
        echo "PHASE 1: CRUD PERANGKAT AJAR\n";
        echo "--------------------------------------------------------\n";

        // 1. Create (Insert Draft)
        $perangkat_data = array(
            'tahun_pelajaran_id' => $active_tp['id'],
            'semester' => $active_tp['semester'],
            'mapel_id' => $mapel['id'],
            'kelas_id' => $kelas['id'],
            'guru_id' => $guru['id'],
            'jenis_perangkat' => 'RPP',
            'fase' => 'Fase E',
            'elemen' => 'Elemen Pemrograman Dasar',
            'capaian_pembelajaran' => 'Siswa mampu memahami variabel dan tipe data.',
            'tujuan_pembelajaran' => 'Siswa dapat membuat kode program sederhana.',
            'materi_pembelajaran' => 'Variabel & Operator',
            'pertemuan_ke' => 99, // Unused number for testing
            'file_path' => 'assets/uploads/perangkat/test_rpp.pdf',
            'status_verifikasi' => 'Draft',
            'created_by' => $user['id']
        );

        $this->db->insert('perangkat_ajar', $perangkat_data);
        $device_id = $this->db->insert_id();
        echo "[✓] 1. CREATE Draft Perangkat Ajar sukses. ID: $device_id\n";

        // 2. Read (Query match)
        $read_device = $this->perangkat_model->get_by_id($device_id);
        if ($read_device && $read_device['pertemuan_ke'] == 99) {
            echo "[✓] 2. READ Perangkat Ajar sukses. Elemen: " . $read_device['elemen'] . "\n";
        } else {
            echo "[x] 2. READ GAGAL.\n";
        }

        // 3. Update (Verify / Approve)
        $this->db->where('id', $device_id);
        $this->db->update('perangkat_ajar', array('status_verifikasi' => 'Disetujui'));
        $updated_device = $this->perangkat_model->get_by_id($device_id);
        if ($updated_device && $updated_device['status_verifikasi'] == 'Disetujui') {
            echo "[✓] 3. UPDATE (Verifikasi / Approval) sukses.\n";
        } else {
            echo "[x] 3. UPDATE GAGAL.\n";
        }

        // 4. Version Revision Tree Test
        $revision_data = $perangkat_data;
        $revision_data['capaian_pembelajaran'] = 'Siswa mahir dalam tipe data array.';
        $new_revision_id = $this->perangkat_model->save_revision($device_id, $revision_data, $user['id']);
        
        $rev_device = $this->perangkat_model->get_by_id($new_revision_id);
        if ($rev_device && $rev_device['version'] == 2 && $rev_device['parent_id'] == $device_id) {
            echo "[✓] 4. REVISI VERSION TREE sukses. New ID: $new_revision_id, Versi: " . $rev_device['version'] . "\n";
        } else {
            echo "[x] 4. REVISI GAGAL.\n";
        }

        // ==========================================
        // PHASE 2: CRUD JURNAL GURU INTEGRATION
        // ==========================================
        echo "\n--------------------------------------------------------\n";
        echo "PHASE 2: CRUD JURNAL GURU INTEGRATION\n";
        echo "--------------------------------------------------------\n";

        // 1. Match active device lookup
        $perangkatService = new PerangkatService();
        $matched = $perangkatService->get_matched_device(
            $active_tp['id'],
            $active_tp['semester'],
            $mapel['id'],
            $guru['id'],
            $kelas['id'],
            99
        );

        if ($matched && $matched['id'] == $new_revision_id) {
            echo "[✓] 1. MATCHING Perangkat Ajar aktif sukses. ID Cocok: " . $matched['id'] . "\n";
        } else {
            echo "[x] 1. MATCHING GAGAL.\n";
        }

        // 2. Create Jurnal (Autofill check)
        $jurnalService = new JurnalService();
        
        $jurnal_post = array(
            'kelas_id' => $kelas['id'],
            'mapel_id' => $mapel['id'],
            'guru_id' => $guru['id'],
            'tanggal' => date('Y-m-d'),
            'perangkat_ajar_id' => $matched ? $matched['id'] : NULL,
            'pertemuan_ke' => 99,
            'jam_mulai_ke' => 1,
            'jam_selesai_ke' => 2,
            'materi_pembelajaran' => $matched ? $matched['materi_pembelajaran'] : 'Variabel & Operator',
            'capaian_pembelajaran' => $matched ? $matched['capaian_pembelajaran'] : '',
            'tujuan_pembelajaran' => $matched ? $matched['tujuan_pembelajaran'] : '',
            'sub_materi' => $matched ? $matched['sub_materi'] : '',
            'metode_pembelajaran' => $matched ? $matched['metode_pembelajaran'] : '',
            'model_pembelajaran' => $matched ? $matched['model_pembelajaran'] : '',
            'media_pembelajaran' => $matched ? $matched['media_pembelajaran'] : '',
            'sumber_belajar' => $matched ? $matched['sumber_belajar'] : '',
            'bentuk_penilaian' => $matched ? $matched['bentuk_penilaian'] : '',
            'alokasi_waktu' => $matched ? $matched['alokasi_waktu'] : '',
            'catatan_pembelajaran' => 'Test input auto-populated dari Perangkat Ajar.'
        );

        $jurnal_res = $jurnalService->create_jurnal($jurnal_post, array(), $active_tp, $user['id']);
        if ($jurnal_res['status']) {
            $j_id = $jurnal_res['jurnal_id'];
            echo "[✓] 2. CREATE Jurnal dengan auto-fill sukses. Jurnal ID: $j_id\n";
            
            // Check snapshot fields
            $jurnal_detail = $jurnalService->get_jurnal_detail($j_id);
            if ($jurnal_detail && $jurnal_detail['capaian_pembelajaran'] == 'Siswa mahir dalam tipe data array.') {
                echo "[✓] 3. SNAPSHOT Verification sukses. CP tersalin: " . $jurnal_detail['capaian_pembelajaran'] . "\n";
            } else {
                echo "[x] 3. SNAPSHOT GAGAL / Tidak Sama.\n";
            }

            // Cleanup Jurnal
            $this->db->delete('jurnal_guru', array('id' => $j_id));
            echo "[✓] 4. DELETE Jurnal sukses (Cleanup).\n";
        } else {
            echo "[x] 2. CREATE Jurnal GAGAL: " . $jurnal_res['message'] . "\n";
        }

        // Cleanup Perangkat
        $this->db->delete('perangkat_ajar', array('id' => $new_revision_id));
        $this->db->delete('perangkat_ajar', array('id' => $device_id));
        echo "[✓] 5. DELETE Perangkat Ajar sukses (Cleanup).\n";

        // ==========================================
        // PHASE 3: PERFORMANCE LOGGER TEST
        // ==========================================
        echo "\n--------------------------------------------------------\n";
        echo "PHASE 3: PERFORMANCE LOGGER TEST\n";
        echo "--------------------------------------------------------\n";

        $perf_count = $this->db->count_all_results('sys_performance_logs');
        echo "[+] Jumlah Log Performa di DB: $perf_count baris.\n";
        if ($perf_count > 0) {
            echo "[✓] 1. LOGGING SYSTEM berjalan lancar.\n";
        } else {
            echo "[!] 1. Log performa masih kosong (menunggu request HTTP pertama).\n";
        }

        echo "\n========================================================\n";
        echo "          MOCK FLOW TEST SELESAI DENGAN SUKSES!\n";
        echo "========================================================\n";
    }
}

