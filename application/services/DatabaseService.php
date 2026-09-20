<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'services/BaseService.php';

class DatabaseService extends BaseService {

    private $backup_dir;

    public function __construct() {
        parent::__construct();
        $this->backup_dir = FCPATH . 'database/backups/';
        if (!is_dir($this->backup_dir)) {
            @mkdir($this->backup_dir, 0755, TRUE);
        }
    }

    /**
     * Get MySQL server and connection status details
     */
    public function get_server_status() {
        $db_name = $this->CI->db->database;
        $hostname = $this->CI->db->hostname;
        
        $version_q = $this->CI->db->query("SELECT VERSION() as ver")->row_array();
        $version = $version_q['ver'] ?? 'Unknown';

        // Fetch Global Status metrics
        $status_raw = $this->CI->db->query("SHOW GLOBAL STATUS WHERE Variable_name IN ('Uptime', 'Threads_connected', 'Open_tables', 'Questions', 'Slow_queries', 'Max_used_connections')")->result_array();
        $status_map = array();
        foreach ($status_raw as $s) {
            $status_map[$s['Variable_name']] = $s['Value'];
        }

        // Calculate Uptime formatted
        $uptime_sec = (int)($status_map['Uptime'] ?? 0);
        $days = floor($uptime_sec / 86400);
        $hours = floor(($uptime_sec % 86400) / 3600);
        $minutes = floor(($uptime_sec % 3600) / 60);
        $uptime_str = "{$days}d {$hours}h {$minutes}m";

        $charset_q = $this->CI->db->query("SELECT @@character_set_database as charset, @@collation_database as collation")->row_array();

        return array(
            'database_name' => $db_name,
            'hostname' => $hostname ? $hostname : 'localhost',
            'version' => $version,
            'uptime' => $uptime_str,
            'uptime_seconds' => $uptime_sec,
            'threads_connected' => (int)($status_map['Threads_connected'] ?? 0),
            'open_tables' => (int)($status_map['Open_tables'] ?? 0),
            'queries_total' => (int)($status_map['Questions'] ?? 0),
            'slow_queries' => (int)($status_map['Slow_queries'] ?? 0),
            'max_used_connections' => (int)($status_map['Max_used_connections'] ?? 0),
            'charset' => $charset_q['charset'] ?? 'utf8mb4',
            'collation' => $charset_q['collation'] ?? 'utf8mb4_unicode_ci'
        );
    }

    /**
     * Get Database capacity and health overview metrics
     */
    public function get_capacity_metrics() {
        $db_name = $this->CI->db->database;
        $tables = $this->CI->db->query("SHOW TABLE STATUS FROM `{$db_name}`")->result_array();

        $total_data = 0;
        $total_index = 0;
        $total_rows = 0;
        $total_free = 0;
        $fragmented_tables = 0;

        foreach ($tables as $t) {
            $data_len = (int)($t['Data_length'] ?? 0);
            $idx_len = (int)($t['Index_length'] ?? 0);
            $data_free = (int)($t['Data_free'] ?? 0);
            $rows = (int)($t['Rows'] ?? 0);

            $total_data += $data_len;
            $total_index += $idx_len;
            $total_free += $data_free;
            $total_rows += $rows;

            if ($data_free > 0) {
                $fragmented_tables++;
            }
        }

        return array(
            'tables_count' => count($tables),
            'total_rows' => $total_rows,
            'data_size_mb' => round($total_data / (1024 * 1024), 2),
            'index_size_mb' => round($total_index / (1024 * 1024), 2),
            'total_size_mb' => round(($total_data + $total_index) / (1024 * 1024), 2),
            'overhead_mb' => round($total_free / (1024 * 1024), 2),
            'fragmented_tables_count' => $fragmented_tables
        );
    }

    /**
     * Get detailed list of all tables with breakdown
     */
    public function get_tables_detail() {
        $db_name = $this->CI->db->database;
        $tables = $this->CI->db->query("SHOW TABLE STATUS FROM `{$db_name}`")->result_array();
        $result = array();

        foreach ($tables as $t) {
            $data_len = (int)($t['Data_length'] ?? 0);
            $idx_len = (int)($t['Index_length'] ?? 0);
            $data_free = (int)($t['Data_free'] ?? 0);
            $total_bytes = $data_len + $idx_len;

            $result[] = array(
                'name' => $t['Name'],
                'engine' => $t['Engine'] ?? 'InnoDB',
                'rows' => (int)($t['Rows'] ?? 0),
                'data_size' => $this->format_bytes($data_len),
                'index_size' => $this->format_bytes($idx_len),
                'total_size' => $this->format_bytes($total_bytes),
                'total_bytes' => $total_bytes,
                'data_free' => $this->format_bytes($data_free),
                'has_overhead' => ($data_free > 0),
                'collation' => $t['Collation'] ?? '-',
                'auto_increment' => $t['Auto_increment'] ?? '-',
                'update_time' => !empty($t['Update_time']) ? date('Y-m-d H:i:s', strtotime($t['Update_time'])) : '-'
            );
        }

        return $result;
    }

    /**
     * Get active MySQL process list
     */
    public function get_process_list() {
        try {
            return $this->CI->db->query("SHOW FULL PROCESSLIST")->result_array();
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Get Slow Queries Log
     */
    public function get_slow_queries($limit = 15) {
        if ($this->CI->db->table_exists('sys_slow_queries')) {
            $this->CI->db->order_by('created_at', 'DESC');
            $this->CI->db->limit($limit);
            return $this->CI->db->get('sys_slow_queries')->result_array();
        }
        return array();
    }

    /**
     * Get list of database backup files stored in database/backups/
     */
    public function get_backup_files() {
        $files = array();
        if (!is_dir($this->backup_dir)) {
            return $files;
        }

        $dir_files = scandir($this->backup_dir);
        foreach ($dir_files as $f) {
            if ($f === '.' || $f === '..' || $f === '.htaccess' || $f === 'index.html') {
                continue;
            }

            $filepath = $this->backup_dir . $f;
            if (is_file($filepath)) {
                $ext = pathinfo($f, PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), array('sql', 'zip', 'gz'))) {
                    $bytes = filesize($filepath);
                    $mtime = filemtime($filepath);

                    $files[] = array(
                        'filename' => $f,
                        'filepath' => $filepath,
                        'size_bytes' => $bytes,
                        'size_formatted' => $this->format_bytes($bytes),
                        'extension' => strtoupper($ext),
                        'created_at' => date('Y-m-d H:i:s', $mtime),
                        'timestamp' => $mtime
                    );
                }
            }
        }

        // Sort by timestamp DESC (newest first)
        usort($files, function($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        return $files;
    }

    /**
     * Create database backup SQL or ZIP
     */
    public function create_backup($include_data = TRUE, $compress_zip = FALSE) {
        $db_name = $this->CI->db->database;
        $timestamp = date('Y-m-d_H-i-s');
        
        $this->CI->load->dbutil();

        $prefs = array(
            'format' => $compress_zip ? 'zip' : 'txt',
            'filename' => "backup_{$db_name}_{$timestamp}.sql",
            'add_drop' => TRUE,
            'add_insert' => $include_data,
            'newline' => "\n"
        );

        $backup_raw = $this->CI->dbutil->backup($prefs);

        $ext = $compress_zip ? 'zip' : 'sql';
        $filename = "backup_{$db_name}_{$timestamp}.{$ext}";
        $filepath = $this->backup_dir . $filename;

        if (!$compress_zip) {
            // Prepend foreign key checks disable for smooth restore
            $header = "-- ========================================================\n";
            $header .= "-- Database Backup: {$db_name}\n";
            $header .= "-- Created Date: " . date('Y-m-d H:i:s') . "\n";
            $header .= "-- Server Version: " . $this->CI->db->query("SELECT VERSION() as ver")->row()->ver . "\n";
            $header .= "-- ========================================================\n\n";
            $header .= "SET FOREIGN_KEY_CHECKS = 0;\n";
            $header .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n\n";

            $footer = "\n\nSET FOREIGN_KEY_CHECKS = 1;\n";
            
            $final_content = $header . $backup_raw . $footer;
            $saved = file_put_contents($filepath, $final_content);
        } else {
            $saved = file_put_contents($filepath, $backup_raw);
        }

        if ($saved !== FALSE) {
            return array(
                'status' => true,
                'message' => "Backup database '{$filename}' berhasil dibuat.",
                'filename' => $filename,
                'filepath' => $filepath,
                'size' => $this->format_bytes(filesize($filepath))
            );
        } else {
            return array(
                'status' => false,
                'message' => 'Gagal menyimpan file backup ke folder server.'
            );
        }
    }

    /**
     * Delete backup file safely
     */
    public function delete_backup_file($filename) {
        $clean_filename = basename($filename);
        $filepath = $this->backup_dir . $clean_filename;

        if (file_exists($filepath) && is_file($filepath)) {
            if (@unlink($filepath)) {
                return array('status' => true, 'message' => "File backup '{$clean_filename}' berhasil dihapus.");
            } else {
                return array('status' => false, 'message' => "Gagal menghapus file '{$clean_filename}'. Periksa hak akses file.");
            }
        }

        return array('status' => false, 'message' => "File backup '{$clean_filename}' tidak ditemukan.");
    }

    /**
     * Restore Database from local SQL file path
     */
    public function restore_from_file($filepath) {
        if (!file_exists($filepath)) {
            return array('status' => false, 'message' => 'File dump SQL tidak ditemukan.');
        }

        // If file is zip, unzip it first
        $ext = pathinfo($filepath, PATHINFO_EXTENSION);
        $sql_filepath = $filepath;
        $temp_unzip = null;

        if (strtolower($ext) === 'zip') {
            if (!class_exists('ZipArchive')) {
                return array('status' => false, 'message' => 'Ekstensi PHP ZipArchive tidak aktif pada server ini.');
            }
            $zip = new ZipArchive();
            if ($zip->open($filepath) === TRUE) {
                $extract_path = $this->backup_dir . 'temp_restore_' . time() . '/';
                @mkdir($extract_path, 0755, TRUE);
                $zip->extractTo($extract_path);
                $zip->close();

                $extracted_files = glob($extract_path . '*.sql');
                if (!empty($extracted_files)) {
                    $sql_filepath = $extracted_files[0];
                    $temp_unzip = $extract_path;
                } else {
                    return array('status' => false, 'message' => 'File .sql tidak ditemukan di dalam arsip ZIP.');
                }
            } else {
                return array('status' => false, 'message' => 'Gagal membuka file ZIP backup.');
            }
        }

        $sql_content = file_get_contents($sql_filepath);

        // Cleanup temp unzipped directory if created
        if ($temp_unzip && is_dir($temp_unzip)) {
            array_map('unlink', glob("{$temp_unzip}*.*"));
            @rmdir($temp_unzip);
        }

        if (empty(trim($sql_content))) {
            return array('status' => false, 'message' => 'File backup SQL kosong.');
        }

        // Execute SQL Queries line by line
        $this->CI->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->CI->db->query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';");

        $queries = $this->split_sql_file($sql_content);
        $success_count = 0;
        $error_count = 0;
        $error_messages = array();

        foreach ($queries as $query) {
            $q = trim($query);
            if (!empty($q)) {
                try {
                    $this->CI->db->query($q);
                    $success_count++;
                } catch (Exception $e) {
                    $error_count++;
                    if (count($error_messages) < 5) {
                        $error_messages[] = $e->getMessage();
                    }
                }
            }
        }

        $this->CI->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        if ($error_count == 0) {
            return array(
                'status' => true,
                'message' => "Proses Restore Database BERHASIL! ({$success_count} kueri dieksekusi tanpa error)."
            );
        } else {
            return array(
                'status' => true,
                'message' => "Proses Restore Selesai dengan beberapa catatan: {$success_count} kueri sukses, {$error_count} kueri gagal. Detail error: " . implode(' | ', $error_messages)
            );
        }
    }

    /**
     * Helper to split SQL string into array of single statements
     */
    private function split_sql_file($sql) {
        // Strip comments
        $sql = preg_replace('/^--.*$/m', '', $sql);
        $sql = preg_replace('/^\/\*!.*?\*\/;/m', '', $sql);

        $queries = array();
        $query = '';
        $in_string = false;
        $string_char = '';

        $len = strlen($sql);
        for ($i = 0; $i < $len; $i++) {
            $char = $sql[$i];

            if ($in_string) {
                if ($char === $string_char && ($i == 0 || $sql[$i - 1] !== '\\')) {
                    $in_string = false;
                }
                $query .= $char;
            } else {
                if ($char === "'" || $char === '"') {
                    $in_string = true;
                    $string_char = $char;
                    $query .= $char;
                } elseif ($char === ';') {
                    if (trim($query) !== '') {
                        $queries[] = $query;
                    }
                    $query = '';
                } else {
                    $query .= $char;
                }
            }
        }

        if (trim($query) !== '') {
            $queries[] = $query;
        }

        return $queries;
    }

    /**
     * Maintenance: Optimize single or all tables
     */
    public function optimize_table($table_name = null) {
        if (!empty($table_name)) {
            $clean_table = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
            $res = $this->CI->db->query("OPTIMIZE TABLE `{$clean_table}`")->row_array();
            return array('status' => true, 'message' => "Tabel '{$clean_table}' berhasil di-optimize.", 'detail' => $res);
        } else {
            $db_name = $this->CI->db->database;
            $tables = $this->CI->db->query("SHOW TABLE STATUS FROM `{$db_name}`")->result_array();
            $count = 0;

            foreach ($tables as $t) {
                if ((int)($t['Data_free'] ?? 0) > 0) {
                    $this->CI->db->query("OPTIMIZE TABLE `{$t['Name']}`");
                    $count++;
                }
            }

            return array('status' => true, 'message' => "Proses optimasi selesai. Total {$count} tabel berhasil di-optimize.");
        }
    }

    /**
     * Maintenance: Check table integrity
     */
    public function check_table($table_name) {
        $clean_table = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
        $res = $this->CI->db->query("CHECK TABLE `{$clean_table}`")->result_array();
        return array('status' => true, 'data' => $res);
    }

    /**
     * Maintenance: Repair table
     */
    public function repair_table($table_name) {
        $clean_table = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
        $res = $this->CI->db->query("REPAIR TABLE `{$clean_table}`")->result_array();
        return array('status' => true, 'data' => $res);
    }

    /**
     * Helper to format bytes to human readable string
     */
    public function format_bytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
