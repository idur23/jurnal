<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class NilaiService extends BaseService {

    public function __construct() {
        parent::__construct();
        $this->CI->load->model('penilaian_model');
        $this->CI->load->model('master_model');
    }

    /**
     * Save student grades via normal form input (with transactions and file upload)
     */
    public function save_nilai($post_data, $files, $active_tp, $current_user_id) {
        $kelas_id = $post_data['kelas_id'];
        $mapel_id = $post_data['mapel_id'];
        $jenis_penilaian = $post_data['jenis_penilaian'];
        $nama_penilaian = $post_data['nama_penilaian'];
        
        $nilai_input = isset($post_data['nilai']) ? $post_data['nilai'] : array();
        $catatan_input = isset($post_data['catatan']) ? $post_data['catatan'] : array();
        $rubrik_input = isset($post_data['rubrik_penilaian']) ? $post_data['rubrik_penilaian'] : array();

        $guru_id = $this->resolve_guru_id($current_user_id, $mapel_id, $kelas_id);

        $this->trans_begin();

        try {
            // Upload portfolios files if required
            $uploaded_files = array();
            if ($jenis_penilaian == 'portofolio' && !empty($files)) {
                if (!is_dir('./assets/uploads/portofolio/')) {
                    mkdir('./assets/uploads/portofolio/', 0777, TRUE);
                }

                $config['upload_path']   = './assets/uploads/portofolio/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|ppt|pptx|zip|rar|mp4|mkv';
                $config['max_size']      = 10240; // 10MB
                $this->CI->load->library('upload');

                foreach ($files as $input_name => $file_info) {
                    if (strpos($input_name, 'file_portofolio_') === 0 && !empty($file_info['name'])) {
                        $siswa_id = str_replace('file_portofolio_', '', $input_name);
                        
                        $ext = pathinfo($file_info['name'], PATHINFO_EXTENSION);
                        $config['file_name'] = 'PF_' . $kelas_id . '_' . $siswa_id . '_' . time() . '.' . $ext;

                        $this->CI->upload->initialize($config);

                        if ($this->CI->upload->do_upload($input_name)) {
                            $upload_data = $this->CI->upload->data();
                            $uploaded_files[$siswa_id] = 'assets/uploads/portofolio/' . $upload_data['file_name'];
                        }
                    }
                }
            }

            // Loop through students and prepare insert/update list
            $batch_data = array();
            foreach ($nilai_input as $siswa_id => $val) {
                if ($val === '') continue; // Skip blank values

                $clean_nilai = max(0.00, min(100.00, (float)$val));

                $data_row = array(
                    'tahun_pelajaran_id' => $active_tp['id'],
                    'kelas_id' => $kelas_id,
                    'mapel_id' => $mapel_id,
                    'siswa_id' => $siswa_id,
                    'guru_id' => $guru_id,
                    'jenis_penilaian' => $jenis_penilaian,
                    'nama_penilaian' => $nama_penilaian,
                    'nilai' => $clean_nilai,
                    'catatan' => isset($catatan_input[$siswa_id]) ? $catatan_input[$siswa_id] : NULL
                );

                // Re-use portfolio if uploaded
                if (isset($uploaded_files[$siswa_id])) {
                    $data_row['file_portofolio'] = $uploaded_files[$siswa_id];
                }

                // Practice assessment rubrics
                if ($jenis_penilaian == 'praktik' && isset($rubrik_input[$siswa_id])) {
                    $data_row['rubrik_penilaian'] = $rubrik_input[$siswa_id];
                }

                // Delete existing grades for this specific student session
                $this->CI->db->where('tahun_pelajaran_id', $active_tp['id']);
                $this->CI->db->where('kelas_id', $kelas_id);
                $this->CI->db->where('mapel_id', $mapel_id);
                $this->CI->db->where('siswa_id', $siswa_id);
                $this->CI->db->where('jenis_penilaian', $jenis_penilaian);
                $this->CI->db->where('nama_penilaian', $nama_penilaian);
                $this->CI->db->delete('penilaian_siswa');

                $batch_data[] = $data_row;
            }

            if (!empty($batch_data)) {
                $this->CI->db->insert_batch('penilaian_siswa', $batch_data);
            }

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Terjadi kesalahan database saat menyimpan nilai.');
            } else {
                $this->trans_commit();
                $this->CI->logger_lib->log('SAVE_NILAI', "Input Nilai $jenis_penilaian ($nama_penilaian) Kelas ID: $kelas_id");
                return array('status' => true);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * Parse spreadsheet file and present preview analysis
     */
    public function preview_import($file_path, $kelas_id) {
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        $highest_row = $sheet->getHighestRow();

        $import_rows = array();
        $errors = array();

        // Get valid students in class
        $siswa_list = $this->CI->master_model->get_siswa_by_kelas($kelas_id);
        $siswa_nis_map = array_column($siswa_list, 'id', 'nis');

        for ($row = 7; $row <= $highest_row; $row++) {
            $nis = trim($sheet->getCell('A' . $row)->getValue() ?? '');
            $nama = trim($sheet->getCell('B' . $row)->getValue() ?? '');
            $nilai = trim($sheet->getCell('C' . $row)->getValue() ?? '');
            $catatan = trim($sheet->getCell('D' . $row)->getValue() ?? '');

            if ($nis === '' && $nama === '') continue; // Skip empty rows

            $row_err = array();
            $siswa_id = isset($siswa_nis_map[$nis]) ? $siswa_nis_map[$nis] : NULL;

            if (!$siswa_id) {
                $row_err[] = "NIS '$nis' tidak terdaftar di kelas ini.";
            }

            if ($nilai === '' || !is_numeric($nilai) || (float)$nilai < 0 || (float)$nilai > 100) {
                $row_err[] = "Nilai '$nilai' harus berupa angka 0 - 100.";
            }

            if (!empty($row_err)) {
                $errors[] = array(
                    'row' => $row,
                    'nis' => $nis,
                    'nama' => $nama,
                    'nilai' => $nilai,
                    'catatan' => $catatan,
                    'message' => implode('; ', $row_err)
                );
            }

            $import_rows[] = array(
                'siswa_id' => $siswa_id,
                'nis' => $nis,
                'nama' => $nama,
                'nilai' => (float)$nilai,
                'catatan' => $catatan
            );
        }

        return array(
            'import_rows' => $import_rows,
            'errors' => $errors
        );
    }

    /**
     * Perform the transaction import write
     */
    public function execute_import($file_path, $kelas_id, $mapel_id, $jenis_penilaian, $nama_penilaian, $active_tp, $current_user_id) {
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        $highest_row = $sheet->getHighestRow();

        $guru_id = $this->resolve_guru_id($current_user_id, $mapel_id, $kelas_id);

        $siswa_list = $this->CI->master_model->get_siswa_by_kelas($kelas_id);
        $siswa_nis_map = array_column($siswa_list, 'id', 'nis');

        $import_code = 'IMP-' . time() . '-' . rand(1000, 9999);
        $batch_data = array();

        for ($row = 7; $row <= $highest_row; $row++) {
            $nis = trim($sheet->getCell('A' . $row)->getValue() ?? '');
            $nilai = trim($sheet->getCell('C' . $row)->getValue() ?? '');
            $catatan = trim($sheet->getCell('D' . $row)->getValue() ?? '');

            if ($nis === '') continue;

            $siswa_id = isset($siswa_nis_map[$nis]) ? $siswa_nis_map[$nis] : NULL;
            if ($siswa_id && $nilai !== '') {
                $batch_data[] = array(
                    'tahun_pelajaran_id' => $active_tp['id'],
                    'kelas_id' => $kelas_id,
                    'mapel_id' => $mapel_id,
                    'siswa_id' => $siswa_id,
                    'guru_id' => $guru_id,
                    'jenis_penilaian' => $jenis_penilaian,
                    'nama_penilaian' => $nama_penilaian,
                    'nilai' => max(0.0, min(100.0, (float)$nilai)),
                    'catatan' => $catatan,
                    'import_code' => $import_code
                );
            }
        }

        if (empty($batch_data)) {
            return array('status' => false, 'message' => 'Tidak ada data nilai valid yang diimpor.');
        }

        $this->trans_begin();

        try {
            // Delete existing records with matching keys before batch insert to prevent duplication
            foreach ($batch_data as $row) {
                $this->CI->db->where('tahun_pelajaran_id', $row['tahun_pelajaran_id']);
                $this->CI->db->where('kelas_id', $row['kelas_id']);
                $this->CI->db->where('mapel_id', $row['mapel_id']);
                $this->CI->db->where('siswa_id', $row['siswa_id']);
                $this->CI->db->where('jenis_penilaian', $row['jenis_penilaian']);
                $this->CI->db->where('nama_penilaian', $row['nama_penilaian']);
                $this->CI->db->delete('penilaian_siswa');
            }

            // Save grades batch
            $this->CI->penilaian_model->save_batch_nilai($batch_data);

            // Save Import History
            $this->CI->db->insert('import_nilai_history', array(
                'import_code' => $import_code,
                'file_name' => basename($file_path),
                'tahun_pelajaran_id' => $active_tp['id'],
                'kelas_id' => $kelas_id,
                'mapel_id' => $mapel_id,
                'jenis_penilaian' => $jenis_penilaian,
                'nama_penilaian' => $nama_penilaian,
                'imported_by' => $current_user_id,
                'total_records' => count($batch_data)
            ));

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal menulis nilai ke database.');
            } else {
                $this->trans_commit();
                $this->CI->logger_lib->log('IMPORT_NILAI', "Import Excel $jenis_penilaian ($nama_penilaian) Kelas ID: $kelas_id. Code: $import_code");
                return array('status' => true, 'total_imported' => count($batch_data));
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * Rollback grades imported under import_code
     */
    public function rollback_import($import_code) {
        $history = $this->CI->db->get_where('import_nilai_history', array('import_code' => $import_code))->row_array();
        if (!$history) {
            return array('status' => false, 'message' => 'Riwayat import tidak ditemukan.');
        }

        $this->trans_begin();

        try {
            // Delete ratings
            $this->CI->db->where('import_code', $import_code);
            $this->CI->db->delete('penilaian_siswa');

            // Delete history entry
            $this->CI->db->where('import_code', $import_code);
            $this->CI->db->delete('import_nilai_history');

            if ($this->trans_status() === FALSE) {
                $this->trans_rollback();
                return array('status' => false, 'message' => 'Gagal membatalkan transaksi import.');
            } else {
                $this->trans_commit();
                
                // Delete actual import file if it exists
                $file = './assets/uploads/excel_imports/' . $history['file_name'];
                if (file_exists($file)) {
                    unlink($file);
                }

                $this->CI->logger_lib->log('ROLLBACK_NILAI', "Membatalkan Import Code: $import_code");
                return array('status' => true);
            }
        } catch (Exception $e) {
            $this->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * Resolve valid guru_id for grade insertion (prevents FK constraint errors when admin inputs grades)
     */
    private function resolve_guru_id($current_user_id, $mapel_id = NULL, $kelas_id = NULL) {
        $guru = $this->CI->master_model->get_guru_by_user_id($current_user_id);
        if (!empty($guru['id'])) {
            return $guru['id'];
        }

        // 1. Try finding teacher for mapel & kelas in jadwal_pelajaran
        if ($mapel_id && $kelas_id) {
            $jd = $this->CI->db->select('guru_id')
                               ->where('kelas_id', $kelas_id)
                               ->where('mapel_id', $mapel_id)
                               ->get('jadwal_pelajaran')
                               ->row_array();
            if (!empty($jd['guru_id'])) {
                return $jd['guru_id'];
            }
        }

        // 2. Try finding teacher in mata_pelajaran or guru_mapel
        if ($mapel_id) {
            $mp = $this->CI->db->select('guru_id')
                               ->where('id', $mapel_id)
                               ->get('mata_pelajaran')
                               ->row_array();
            if (!empty($mp['guru_id'])) {
                return $mp['guru_id'];
            }

            $gm = $this->CI->db->select('guru_id')
                               ->where('mapel_id', $mapel_id)
                               ->get('guru_mapel')
                               ->row_array();
            if (!empty($gm['guru_id'])) {
                return $gm['guru_id'];
            }
        }

        // 3. Fallback to any valid teacher from guru table
        $first_guru = $this->CI->db->select('id')->order_by('id', 'ASC')->limit(1)->get('guru')->row_array();
        if (!empty($first_guru['id'])) {
            return $first_guru['id'];
        }

        return NULL;
    }
}
