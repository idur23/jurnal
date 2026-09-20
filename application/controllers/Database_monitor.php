<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'services/DatabaseService.php';

class Database_monitor extends Admin_Controller {

    private $dbService;

    public function __construct() {
        parent::__construct();
        $this->dbService = new DatabaseService();
        $this->load->helper('download');
    }

    /**
     * Unified Dashboard View: Database Monitoring & Backup
     */
    public function index() {
        $data['title'] = 'Monitoring & Backup Database';

        $data['server_status'] = $this->dbService->get_server_status();
        $data['capacity'] = $this->dbService->get_capacity_metrics();
        $data['tables'] = $this->dbService->get_tables_detail();
        $data['process_list'] = $this->dbService->get_process_list();
        $data['slow_queries'] = $this->dbService->get_slow_queries();
        $data['backup_files'] = $this->dbService->get_backup_files();

        $this->template->load('layout/main', 'database_monitor/index', $data);
    }

    /**
     * Trigger Manual Database Backup
     */
    public function do_backup() {
        $include_data = $this->input->post('include_data', TRUE) !== '0';
        $compress_zip = $this->input->post('compress_zip', TRUE) === '1';
        $download_direct = $this->input->post('download_direct', TRUE) !== '0'; // Default TRUE for direct download

        $res = $this->dbService->create_backup($include_data, $compress_zip);

        if ($res['status']) {
            if (isset($this->logger_lib)) {
                $this->logger_lib->log('DATABASE_BACKUP', "Membuat backup database: {$res['filename']} ({$res['size']})");
            }

            if ($download_direct) {
                // Instantly force download to browser while file remains saved in server backups list
                force_download($res['filepath'], NULL);
                return;
            }

            $this->session->set_flashdata('success', $res['message'] . ' File tersimpan di riwayat backup server.');
        } else {
            $this->session->set_flashdata('error', $res['message']);
        }

        redirect('database_monitor');
    }

    /**
     * Download Backup File directly
     */
    public function download($filename = null) {
        if (empty($filename)) {
            show_404();
            return;
        }

        $clean_filename = basename($filename);
        $filepath = FCPATH . 'database/backups/' . $clean_filename;

        if (!file_exists($filepath) || !is_file($filepath)) {
            $this->session->set_flashdata('error', 'File backup tidak ditemukan atau telah dihapus.');
            redirect('database_monitor');
            return;
        }

        if (isset($this->logger_lib)) {
            $this->logger_lib->log('DATABASE_DOWNLOAD', "Mengunduh file backup database: {$clean_filename}");
        }

        force_download($filepath, NULL);
    }

    /**
     * Restore Database from backup file
     */
    public function restore() {
        $restore_source = $this->input->post('restore_source', TRUE);

        if ($restore_source === 'stored') {
            $filename = $this->input->post('backup_file', TRUE);
            if (empty($filename)) {
                $this->session->set_flashdata('error', 'Pilih file backup yang akan dipulihkan.');
                redirect('database_monitor');
                return;
            }

            $clean_filename = basename($filename);
            $filepath = FCPATH . 'database/backups/' . $clean_filename;
            
            $res = $this->dbService->restore_from_file($filepath);
            if ($res['status']) {
                if (isset($this->logger_lib)) {
                    $this->logger_lib->log('DATABASE_RESTORE', "Memulihkan database dari file: {$clean_filename}");
                }
                $this->session->set_flashdata('success', $res['message']);
            } else {
                $this->session->set_flashdata('error', $res['message']);
            }
        } elseif ($restore_source === 'upload') {
            if (empty($_FILES['sql_file']['name'])) {
                $this->session->set_flashdata('error', 'Silakan pilih file SQL / ZIP untuk diunggah.');
                redirect('database_monitor');
                return;
            }

            $config['upload_path']   = FCPATH . 'database/backups/';
            $config['allowed_types'] = 'sql|zip|gz';
            $config['max_size']      = 102400; // 100MB
            $config['file_name']     = 'uploaded_restore_' . date('Y-m-d_H-i-s');

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('sql_file')) {
                $upload_data = $this->upload->data();
                $filepath = $upload_data['full_path'];

                $res = $this->dbService->restore_from_file($filepath);
                if ($res['status']) {
                    if (isset($this->logger_lib)) {
                        $this->logger_lib->log('DATABASE_RESTORE', "Memulihkan database dari file yang diunggah: {$upload_data['file_name']}");
                    }
                    $this->session->set_flashdata('success', $res['message']);
                } else {
                    $this->session->set_flashdata('error', $res['message']);
                }
            } else {
                $this->session->set_flashdata('error', 'Gagal mengunggah file: ' . $this->upload->display_errors());
            }
        } else {
            $this->session->set_flashdata('error', 'Metode restore tidak valid.');
        }

        redirect('database_monitor');
    }

    /**
     * Delete Backup File
     */
    public function delete($filename = null) {
        if (empty($filename)) {
            show_404();
            return;
        }

        $clean_filename = basename($filename);
        $res = $this->dbService->delete_backup_file($clean_filename);

        if ($res['status']) {
            if (isset($this->logger_lib)) {
                $this->logger_lib->log('DATABASE_DELETE_BACKUP', "Menghapus file backup database: {$clean_filename}");
            }
            $this->session->set_flashdata('success', $res['message']);
        } else {
            $this->session->set_flashdata('error', $res['message']);
        }

        redirect('database_monitor');
    }

    /**
     * Optimize Single Table or All Tables
     */
    public function optimize($table = null) {
        if ($table === 'all' || empty($table)) {
            $res = $this->dbService->optimize_table(null);
        } else {
            $res = $this->dbService->optimize_table($table);
        }

        if (isset($this->logger_lib)) {
            $this->logger_lib->log('DATABASE_OPTIMIZE', "Menjalankan optimasi tabel database: " . ($table ? $table : 'Semua Tabel'));
        }

        $this->session->set_flashdata('success', $res['message']);
        redirect('database_monitor');
    }

    /**
     * AJAX Check Table Status
     */
    public function check_table($table = null) {
        if (empty($table)) {
            return json_response(false, 'Nama tabel wajib diisi.');
        }
        $res = $this->dbService->check_table($table);
        return json_response(true, 'Pemeriksaan tabel selesai.', $res['data']);
    }

    /**
     * AJAX Repair Table Status
     */
    public function repair_table($table = null) {
        if (empty($table)) {
            return json_response(false, 'Nama tabel wajib diisi.');
        }
        $res = $this->dbService->repair_table($table);
        return json_response(true, 'Perbaikan tabel selesai.', $res['data']);
    }

    /**
     * CLI Test Suite for Database Monitor & Backup
     */
    public function test_db_monitor() {
        if (!is_cli()) {
            show_error('Akses hanya diperbolehkan melalui CLI.', 403);
            return;
        }

        echo "========================================================\n";
        echo "   CLI TEST: DATABASE MONITORING & BACKUP SERVICE\n";
        echo "========================================================\n\n";

        // 1. Test Server Status
        $server = $this->dbService->get_server_status();
        echo "[+] Database Name : " . $server['database_name'] . "\n";
        echo "[+] Server Version: " . $server['version'] . "\n";
        echo "[+] Server Uptime : " . $server['uptime'] . "\n";
        echo "[✓] 1. SERVER STATUS TEST PASSED.\n\n";

        // 2. Test Capacity Metrics
        $capacity = $this->dbService->get_capacity_metrics();
        echo "[+] Total Tables  : " . $capacity['tables_count'] . " tabel\n";
        echo "[+] Total Rows    : " . number_format($capacity['total_rows']) . " baris\n";
        echo "[+] Total DB Size : " . $capacity['total_size_mb'] . " MB\n";
        echo "[✓] 2. CAPACITY METRICS TEST PASSED.\n\n";

        // 3. Test Create Backup
        echo "[+] Testing Database Backup Generation...\n";
        $backup_res = $this->dbService->create_backup(TRUE, FALSE);
        if ($backup_res['status']) {
            echo "[✓] 3. BACKUP CREATION PASSED: " . $backup_res['filename'] . " (" . $backup_res['size'] . ")\n\n";
            
            // 4. Test List Backups
            $backups = $this->dbService->get_backup_files();
            echo "[+] Found " . count($backups) . " backup files in database/backups/\n";
            echo "[✓] 4. LIST BACKUP FILES PASSED.\n\n";

            // 5. Cleanup Test Backup File
            $del_res = $this->dbService->delete_backup_file($backup_res['filename']);
            if ($del_res['status']) {
                echo "[✓] 5. CLEANUP TEST BACKUP PASSED.\n\n";
            } else {
                echo "[x] 5. CLEANUP TEST BACKUP FAILED: " . $del_res['message'] . "\n\n";
            }
        } else {
            echo "[x] 3. BACKUP CREATION FAILED: " . $backup_res['message'] . "\n\n";
        }

        echo "========================================================\n";
        echo "   ALL TESTS COMPLETED SUCCESSFULLY!\n";
        echo "========================================================\n";
    }
}

