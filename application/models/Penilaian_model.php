<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_model extends MY_Model {
    protected $table = 'penilaian_siswa';

    public function __construct() {
        parent::__construct();
    }

    // Get active categories from database
    public function get_categories() {
        $this->db->where('is_active', 1);
        $this->db->order_by('id', 'ASC');
        return $this->db->get('kategori_penilaian')->result_array();
    }

    public function get_category_by_code($code) {
        return $this->db->get_where('kategori_penilaian', array('kode_kategori' => $code))->row_array();
    }

    public function get_nilai_by_kelas_mapel($kelas_id, $mapel_id, $jenis_penilaian = NULL) {
        $this->db->select('penilaian_siswa.*, siswa.nis, siswa.nama_lengkap, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->join('siswa', 'siswa.id = penilaian_siswa.siswa_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = penilaian_siswa.mapel_id');
        $this->db->join('kelas', 'kelas.id = penilaian_siswa.kelas_id');
        $this->db->where('penilaian_siswa.kelas_id', $kelas_id);
        $this->db->where('penilaian_siswa.mapel_id', $mapel_id);

        if ($jenis_penilaian) {
            $this->db->where('penilaian_siswa.jenis_penilaian', $jenis_penilaian);
        }

        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_nilai_by_filters($kelas_id, $mapel_id, $jenis_penilaian = NULL) {
        $raw = $this->get_nilai_by_kelas_mapel($kelas_id, $mapel_id, $jenis_penilaian);
        $result = array();
        foreach ($raw as $r) {
            $result[$r['siswa_id']] = $r;
        }
        return $result;
    }

    public function save_batch_nilai($nilai_data) {
        $this->db->trans_begin();

        foreach ($nilai_data as $n) {
            $where = array(
                'tahun_pelajaran_id' => $n['tahun_pelajaran_id'],
                'kelas_id' => $n['kelas_id'],
                'mapel_id' => $n['mapel_id'],
                'siswa_id' => $n['siswa_id'],
                'jenis_penilaian' => $n['jenis_penilaian'],
                'nama_penilaian' => $n['nama_penilaian']
            );
            $existing = $this->db->get_where($this->table, $where)->row_array();

            $update_data = array(
                'nilai' => $n['nilai'],
                'catatan' => $n['catatan'],
                'guru_id' => $n['guru_id']
            );

            if (isset($n['file_portofolio'])) {
                $update_data['file_portofolio'] = $n['file_portofolio'];
            }
            if (isset($n['rubrik_penilaian'])) {
                $update_data['rubrik_penilaian'] = $n['rubrik_penilaian'];
            }
            if (isset($n['import_code'])) {
                $update_data['import_code'] = $n['import_code'];
            }

            if ($existing) {
                $this->db->where('id', $existing['id']);
                $this->db->update($this->table, $update_data);
            } else {
                $insert_data = array_merge($n, $update_data);
                $this->db->insert($this->table, $insert_data);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    // --- Import History & Rollback ---
    public function get_import_history($kelas_id = NULL, $mapel_id = NULL) {
        $this->db->select('import_nilai_history.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, users.full_name as nama_pengunggah');
        $this->db->join('kelas', 'kelas.id = import_nilai_history.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = import_nilai_history.mapel_id');
        $this->db->join('users', 'users.id = import_nilai_history.imported_by');
        
        if ($kelas_id) {
            $this->db->where('import_nilai_history.kelas_id', $kelas_id);
        }
        if ($mapel_id) {
            $this->db->where('import_nilai_history.mapel_id', $mapel_id);
        }
        
        $this->db->order_by('import_nilai_history.id', 'DESC');
        return $this->db->get('import_nilai_history')->result_array();
    }

    public function rollback_import($import_code) {
        $this->db->trans_begin();

        // 1. Delete matching marks from penilaian_siswa
        $this->db->where('import_code', $import_code);
        $this->db->delete($this->table);

        // 2. Delete history record
        $this->db->where('import_code', $import_code);
        $this->db->delete('import_nilai_history');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    // --- Rekap Nilai Lengkap ---
    public function get_rekap_nilai($kelas_id, $mapel_id, $tp_id) {
        // Fetch all students in the class
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('status_aktif', 1);
        $this->db->order_by('nama_lengkap', 'ASC');
        $siswa = $this->db->get('siswa')->result_array();

        // Fetch subject KKM
        $mapel = $this->db->get_where('mata_pelajaran', array('id' => $mapel_id))->row_array();
        $kkm = isset($mapel['kkm']) ? (float)$mapel['kkm'] : 75.00;

        // Fetch active categories
        $categories = $this->get_categories();

        // Fetch all marks for this class, subject, and year
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('mapel_id', $mapel_id);
        $this->db->where('tahun_pelajaran_id', $tp_id);
        $marks = $this->db->get($this->table)->result_array();

        // Group marks by student and category
        $grouped_marks = array();
        foreach ($marks as $m) {
            $grouped_marks[$m['siswa_id']][$m['jenis_penilaian']][] = (float)$m['nilai'];
        }

        $rekap = array();
        foreach ($siswa as $s) {
            $row = array(
                'siswa_id' => $s['id'],
                'nis' => $s['nis'],
                'nama_lengkap' => $s['nama_lengkap'],
                'kkm' => $kkm,
                'scores' => array()
            );

            $weighted_sum = 0;
            $weight_sum = 0;

            foreach ($categories as $cat) {
                $code = $cat['kode_kategori'];
                $weight = (int)$cat['bobot'];

                $student_cat_scores = isset($grouped_marks[$s['id']][$code]) ? $grouped_marks[$s['id']][$code] : array();
                
                if (!empty($student_cat_scores)) {
                    $avg = array_sum($student_cat_scores) / count($student_cat_scores);
                    $row['scores'][$code] = round($avg, 2);
                    $weighted_sum += ($avg * $weight);
                    $weight_sum += $weight;
                } else {
                    $row['scores'][$code] = NULL;
                }
            }

            // Calculate Final Score (Nilai Akhir)
            $nilai_akhir = 0;
            if ($weight_sum > 0) {
                $nilai_akhir = round($weighted_sum / $weight_sum, 2);
            }
            $row['nilai_akhir'] = $nilai_akhir;

            // Predicate
            if ($nilai_akhir >= 90) {
                $row['predikat'] = 'A';
                $row['keterangan_predikat'] = 'Sangat Baik';
            } elseif ($nilai_akhir >= 80) {
                $row['predikat'] = 'B';
                $row['keterangan_predikat'] = 'Baik';
            } elseif ($nilai_akhir >= 70) {
                $row['predikat'] = 'C';
                $row['keterangan_predikat'] = 'Cukup';
            } else {
                $row['predikat'] = 'D';
                $row['keterangan_predikat'] = 'Kurang';
            }

            // Ketuntasan & Follow up (Remedial / Pengayaan)
            if ($nilai_akhir >= $kkm) {
                $row['ketuntasan'] = 'Tuntas';
                $row['tindak_lanjut'] = 'Pengayaan';
            } else {
                $row['ketuntasan'] = 'Belum Tuntas';
                $row['tindak_lanjut'] = 'Remedial';
            }

            $rekap[] = $row;
        }

        return $rekap;
    }

    public function get_nilai_filtered($filters = array()) {
        if (!empty($filters)) {
            $this->db->where($filters);
        }
        return $this->db->get($this->table)->result_array();
    }

    public function get_nilai_rekap_matrix($filters) {
        $this->db->select('siswa_id, jenis_penilaian, AVG(nilai) as rata_nilai');
        $this->db->from($this->table);
        $this->db->where('kelas_id', $filters['kelas_id']);
        $this->db->where('mapel_id', $filters['mapel_id']);
        $this->db->where('tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        $this->db->group_by(array('siswa_id', 'jenis_penilaian'));
        return $this->db->get()->result_array();
    }
}

