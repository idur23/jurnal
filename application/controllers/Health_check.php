<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Health_check extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_cli()) {
            show_error('Akses hanya diperbolehkan melalui CLI.', 403);
            return;
        }
    }

    public function index() {
        echo "========================================================\n";
        echo "   SYSTEM HEALTH CHECK & AUDIT: JURNAL GURU ENTERPRISE\n";
        echo "========================================================\n\n";

        $has_error = false;

        // 1. PHP Environment Checks
        echo "[1] Checking Environment...\n";
        $php_version = PHP_VERSION;
        echo "  - PHP Version: $php_version ";
        if (version_compare($php_version, '8.1.0', '>=')) {
            echo "[PASS]\n";
        } else {
            echo "[WARNING] PHP Version is lower than 8.1.0\n";
        }

        $extensions = ['mysqli', 'mbstring', 'gd', 'zip', 'json', 'curl'];
        foreach ($extensions as $ext) {
            echo "  - Extension '$ext': ";
            if (extension_loaded($ext)) {
                echo "[PASS]\n";
            } else {
                echo "[FAIL]\n";
                $has_error = true;
            }
        }
        echo "\n";

        // 2. Database Connectivity & Table Check
        echo "[2] Checking Database Connectivity...\n";
        try {
            $this->load->database();
            if ($this->db->initialize()) {
                echo "  - DB Connection: [PASS] (" . $this->db->database . ")\n";
                
                $required_tables = [
                    'users', 'kelas', 'mata_pelajaran', 'guru', 'siswa', 
                    'tahun_pelajaran', 'perangkat_ajar', 'jurnal_guru', 
                    'presensi_kelas', 'presensi_siswa', 'penilaian_siswa', 
                    'kategori_penilaian', 'sys_performance_logs', 'activity_logs', 
                    'system_settings'
                ];

                foreach ($required_tables as $table) {
                    echo "  - Table '$table': ";
                    if ($this->db->table_exists($table)) {
                        echo "[PASS]\n";
                    } else {
                        echo "[FAIL]\n";
                        $has_error = true;
                    }
                }
            } else {
                echo "  - DB Connection: [FAIL]\n";
                $has_error = true;
            }
        } catch (Exception $e) {
            echo "  - DB Connection Error: [FAIL] (" . $e->getMessage() . ")\n";
            $has_error = true;
        }
        echo "\n";

        // 3. Models Loading Check
        echo "[3] Checking Models Loading...\n";
        $models = [
            'Jurnal_model' => 'jurnal_model',
            'Karya_model' => 'karya_model',
            'Log_model' => 'log_model',
            'Master_model' => 'master_model',
            'Penilaian_model' => 'penilaian_model',
            'Perangkat_model' => 'perangkat_model',
            'Perkembangan_model' => 'perkembangan_model',
            'Presensi_model' => 'presensi_model',
            'Presensikelas_model' => 'presensikelas_model',
            'User_model' => 'user_model',
            'Walikelas_model' => 'walikelas_model'
        ];

        foreach ($models as $class_name => $load_name) {
            echo "  - Model '$class_name': ";
            try {
                $this->load->model($load_name);
                if (isset($this->$load_name) && is_object($this->$load_name)) {
                    echo "[PASS]\n";
                } else {
                    echo "[FAIL] (Not instantiated)\n";
                    $has_error = true;
                }
            } catch (Exception $e) {
                echo "[FAIL] (" . $e->getMessage() . ")\n";
                $has_error = true;
            }
        }
        echo "\n";

        // 4. Services Loading Check
        echo "[4] Checking Services Loading...\n";
        $services = [
            'AuthService',
            'BaseService',
            'DashboardService',
            'JurnalService',
            'LaporanService',
            'NilaiService',
            'PerangkatService',
            'PerkembanganService',
            'PresensiService',
            'WaliKelasService'
        ];

        foreach ($services as $service) {
            echo "  - Service '$service': ";
            if (class_exists($service)) {
                echo "[PASS]\n";
            } else {
                echo "[FAIL]\n";
                $has_error = true;
            }
        }
        echo "\n";

        // 5. Controller Syntax & Existence Check
        echo "[5] Linting Controllers...\n";
        $controllers = glob(APPPATH . 'controllers/*.php');
        foreach ($controllers as $controller) {
            $name = basename($controller);
            echo "  - Controller '$name': ";
            
            $output = [];
            $retval = 0;
            exec("c:\\laragon\\bin\\php\\php-8.3.30-Win32-vs16-x64\\php.exe -l " . escapeshellarg($controller), $output, $retval);
            if ($retval === 0) {
                echo "[PASS]\n";
            } else {
                echo "[FAIL] (Syntax error)\n";
                $has_error = true;
            }
        }
        echo "\n";

        // Summary
        echo "========================================================\n";
        if ($has_error) {
            echo "     STATUS: HEALTH CHECK FAILED WITH SOME ERRORS!\n";
        } else {
            echo "     STATUS: HEALTH CHECK PASSED SUCCESSFULLY!\n";
        }
        echo "========================================================\n";
    }
}
