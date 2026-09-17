<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('json_response')) {
    function json_response($status = true, $message = '', $data = array(), $http_code = 200) {
        $ci =& get_instance();
        $ci->output
            ->set_status_header($http_code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(array(
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'csrf_token' => $ci->security->get_csrf_hash()
            ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
            ->_display();
        exit;
    }
}

if (!function_exists('format_indo_date')) {
    function format_indo_date($date) {
        if (empty($date) || $date == '0000-00-00') return '-';
        $bulan = array(
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        $split = explode('-', $date);
        if (count($split) < 3) return $date;
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }
}

if (!function_exists('get_badge_presensi')) {
    function get_badge_presensi($status) {
        switch ($status) {
            case 'Hadir':
                return '<span class="badge bg-success-lt text-success fw-bold">Hadir</span>';
            case 'Izin':
                return '<span class="badge bg-info-lt text-info fw-bold">Izin</span>';
            case 'Sakit':
                return '<span class="badge bg-warning-lt text-warning fw-bold">Sakit</span>';
            case 'Alpa':
                return '<span class="badge bg-danger-lt text-danger fw-bold">Alpa</span>';
            case 'Dispen':
                return '<span class="badge bg-purple-lt text-purple fw-bold">Dispen</span>';
            default:
                return '<span class="badge bg-secondary-lt text-secondary">-</span>';
        }
    }
}

if (!function_exists('get_badge_jurnal_status')) {
    function get_badge_jurnal_status($status) {
        switch ($status) {
            case 'Submitted':
                return '<span class="badge bg-blue-lt text-blue"><i class="ti ti-check me-1"></i>Tersimpan</span>';
            case 'Validated':
                return '<span class="badge bg-green-lt text-green"><i class="ti ti-circle-check me-1"></i>Tervalidasi</span>';
            case 'Draft':
                return '<span class="badge bg-yellow-lt text-yellow"><i class="ti ti-clock me-1"></i>Draft</span>';
            default:
                return '<span class="badge bg-secondary-lt">-</span>';
        }
    }
}

if (!function_exists('get_image_base64')) {
    function get_image_base64($path) {
        if (empty($path)) return '';
        $full_path = FCPATH . $path;
        if (file_exists($full_path) && is_file($full_path)) {
            $type = pathinfo($full_path, PATHINFO_EXTENSION);
            $data = file_get_contents($full_path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return '';
    }
}

