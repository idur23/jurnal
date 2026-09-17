<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_hook {

    public function log_performance() {
        $CI =& get_instance();
        
        // Skip logging for CLI requests
        if (is_cli()) {
            return;
        }

        // Avoid logging requests to system performance monitor itself to prevent infinite DB loops
        $current_url = current_url();
        if (strpos($current_url, 'system_monitor') !== FALSE || strpos($current_url, 'get_performance_stats_ajax') !== FALSE) {
            return;
        }

        // Check if database library is loaded
        if (!isset($CI->db)) {
            return;
        }

        // Get metrics
        $elapsed_time = $CI->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
        if (empty($elapsed_time)) {
            $elapsed_time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        }
        $elapsed_time = (float) $elapsed_time;

        $memory_usage = round(memory_get_peak_usage(true) / (1024 * 1024), 2); // Peak memory in MB
        $query_count = count($CI->db->queries);

        // 1. Log Slow Queries (threshold: 0.5s)
        if (isset($CI->db->queries) && is_array($CI->db->queries)) {
            foreach ($CI->db->queries as $index => $query_text) {
                if (isset($CI->db->query_times[$index])) {
                    $query_time = (float) $CI->db->query_times[$index];
                    if ($query_time > 0.5) {
                        // Log slow query
                        $slow_data = array(
                            'query_text' => $query_text,
                            'execution_time' => $query_time,
                            'url' => uri_string(),
                            'created_at' => date('Y-m-d H:i:s')
                        );
                        $CI->db->insert('sys_slow_queries', $slow_data);
                    }
                }
            }
        }

        // 2. Log System Performance Metrics
        $performance_data = array(
            'url' => uri_string() ? uri_string() : '/',
            'execution_time' => $elapsed_time,
            'memory_usage' => $memory_usage,
            'query_count' => $query_count,
            'created_at' => date('Y-m-d H:i:s')
        );

        $CI->db->insert('sys_performance_logs', $performance_data);
    }
}
