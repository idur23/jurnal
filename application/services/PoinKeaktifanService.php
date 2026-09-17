<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PoinKeaktifanService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('poin_keaktifan_model');
        $this->CI->load->model('jurnal_model');
        $this->CI->load->model('master_model');
    }

    /**
     * Get journal context and student point list with authorization checks
     */
    public function get_journal_with_points($jurnal_id, $user_id, $role) {
        $jurnal = $this->CI->jurnal_model->get_jurnal_detail($jurnal_id);
        if (!$jurnal) {
            return array('status' => false, 'message' => 'Data Jurnal Pembelajaran tidak ditemukan.');
        }

        // Authorization check
        if (in_array($role, array('guru', 'walikelas'))) {
            $guru = $this->CI->master_model->get_guru_by_user_id($user_id);
            if ($guru && $jurnal['guru_id'] != $guru['id']) {
                // If wali kelas, check if it's their class
                $wali_kelas = $this->CI->master_model->get_kelas_by_wali_user_id($user_id);
                if (!$wali_kelas || $wali_kelas['id'] != $jurnal['kelas_id']) {
                    return array('status' => false, 'message' => 'Anda tidak memiliki hak akses untuk mengelola poin keaktifan jurnal ini.');
                }
            }
        }

        $students = $this->CI->poin_keaktifan_model->get_poin_by_jurnal($jurnal_id, $jurnal['kelas_id']);

        return array(
            'status' => true,
            'jurnal' => $jurnal,
            'students' => $students
        );
    }

    /**
     * Adjust student point (+1 or -1) with strict server-side validation
     */
    public function adjust_student_point($jurnal_id, $siswa_id, $action, $user_id, $role) {
        if (!in_array($action, array('add', 'sub'))) {
            return array('status' => false, 'message' => 'Aksi pengubahan poin tidak valid.');
        }

        $jurnal = $this->CI->jurnal_model->get_jurnal_detail($jurnal_id);
        if (!$jurnal) {
            return array('status' => false, 'message' => 'Jurnal tidak ditemukan.');
        }

        // Security check: teacher access
        if (in_array($role, array('guru', 'walikelas'))) {
            $guru = $this->CI->master_model->get_guru_by_user_id($user_id);
            if ($guru && $jurnal['guru_id'] != $guru['id']) {
                $wali_kelas = $this->CI->master_model->get_kelas_by_wali_user_id($user_id);
                if (!$wali_kelas || $wali_kelas['id'] != $jurnal['kelas_id']) {
                    return array('status' => false, 'message' => 'Akses ditolak. Anda hanya dapat mengubah poin pada jurnal mengajar atau kelas bimbingan Anda.');
                }
            }
        }

        // Security check: ensure student belongs to the class of the journal
        $siswa = $this->CI->db->get_where('siswa', array('id' => $siswa_id, 'status_aktif' => 1))->row_array();
        if (!$siswa) {
            return array('status' => false, 'message' => 'Data siswa tidak ditemukan.');
        }
        if ($siswa['kelas_id'] != $jurnal['kelas_id']) {
            return array('status' => false, 'message' => 'Siswa tidak terdaftar di kelas jurnal ini.');
        }

        // Execute point update
        $new_poin = $this->CI->poin_keaktifan_model->adjust_poin(
            $jurnal['id'],
            $siswa['id'],
            $action,
            $jurnal['guru_id'],
            $jurnal['mapel_id'],
            $jurnal['kelas_id'],
            $jurnal['tanggal']
        );

        return array(
            'status' => true,
            'message' => 'Poin keaktifan ' . $siswa['nama_lengkap'] . ' berhasil ' . ($action === 'add' ? 'ditambahkan' : 'dikurangi') . '.',
            'siswa_id' => $siswa['id'],
            'new_poin' => $new_poin
        );
    }

    /**
     * Generate Excel export of point recap
     */
    public function generate_excel_rekap($filters, $active_tp) {
        $rekap = $this->CI->poin_keaktifan_model->get_rekap_bulanan($filters);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $bulan_names = array(
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        $bulan_num = !empty($filters['bulan']) ? (int)$filters['bulan'] : (int)date('m');
        $tahun_num = !empty($filters['tahun']) ? (int)$filters['tahun'] : (int)date('Y');

        $sheet->setCellValue('A1', 'REKAPITULASI POIN KEAKTIFAN SISWA');
        $sheet->setCellValue('A2', 'Periode: ' . $bulan_names[$bulan_num] . ' ' . $tahun_num);
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'NIS', 'Nama Siswa', 'JK', 'Kelas', 'Total Sesi Aktif', 'Total Poin Keaktifan');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '5', $h);
            $sheet->getStyle($col . '5')->getFont()->setBold(true);
            $col++;
        }

        $row_index = 6;
        $no = 1;
        foreach ($rekap as $r) {
            $sheet->setCellValue('A' . $row_index, $no++);
            $sheet->setCellValue('B' . $row_index, $r['nis']);
            $sheet->setCellValue('C' . $row_index, $r['nama_lengkap']);
            $sheet->setCellValue('D' . $row_index, $r['jk']);
            $sheet->setCellValue('E' . $row_index, $r['nama_kelas']);
            $sheet->setCellValue('F' . $row_index, $r['total_sesi_aktif']);
            $sheet->setCellValue('G' . $row_index, $r['total_poin']);
            $row_index++;
        }

        foreach (range('A', 'G') as $col_id) {
            $sheet->getColumnDimension($col_id)->setAutoSize(true);
        }

        $filename = 'rekap-poin-keaktifan-' . $bulan_num . '-' . $tahun_num . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
