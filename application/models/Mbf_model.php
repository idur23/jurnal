<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbf_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_mbf_schema();
    }

    /**
     * Automatic Schema Initialization & Verification for MBF Module
     */
    public function ensure_mbf_schema() {
        // Table: tentor
        if (!$this->db->table_exists('tentor')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `tentor` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int unsigned DEFAULT NULL,
              `guru_id` int unsigned DEFAULT NULL,
              `nip` varchar(30) DEFAULT NULL,
              `nama_lengkap` varchar(100) NOT NULL,
              `no_hp` varchar(20) DEFAULT NULL,
              `email` varchar(100) DEFAULT NULL,
              `is_active` tinyint(1) DEFAULT '1',
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              UNIQUE KEY `user_id` (`user_id`),
              KEY `idx_tentor_active` (`is_active`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Table: mapel_mbf
        if (!$this->db->table_exists('mapel_mbf')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `mapel_mbf` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `kode_mapel` varchar(30) NOT NULL,
              `nama_mapel` varchar(100) NOT NULL,
              `tentor_id` int unsigned NOT NULL,
              `tahun_pelajaran_id` int unsigned NOT NULL,
              `semester` enum('Ganjil','Genap') NOT NULL DEFAULT 'Ganjil',
              `status` tinyint(1) DEFAULT '1',
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Table: peserta_mapel_mbf
        if (!$this->db->table_exists('peserta_mapel_mbf')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `peserta_mapel_mbf` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `mapel_mbf_id` int unsigned NOT NULL,
              `siswa_id` int unsigned NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              UNIQUE KEY `uk_mapel_siswa` (`mapel_mbf_id`,`siswa_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Table: presensi_mbf
        if (!$this->db->table_exists('presensi_mbf')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `presensi_mbf` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `mapel_mbf_id` int unsigned NOT NULL,
              `tanggal` date NOT NULL,
              `pertemuan_ke` int unsigned DEFAULT '1',
              `catatan` text,
              `created_by` int unsigned NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
              `status_sesi` varchar(30) DEFAULT 'Selesai',
              `nama_mapel_custom` varchar(150) DEFAULT NULL,
              `ruangan` varchar(100) DEFAULT NULL,
              `jam_mulai` time DEFAULT NULL,
              `jam_selesai` time DEFAULT NULL,
              `materi_pembahasan` text,
              `catatan_tentor` text,
              `foto_dokumentasi` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `uk_mapel_tanggal` (`mapel_mbf_id`,`tanggal`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        } else {
            // Ensure all columns exist in presensi_mbf
            $fields = array(
                'pertemuan_ke'      => "INT DEFAULT 1",
                'status_sesi'        => "VARCHAR(30) DEFAULT 'Selesai'",
                'nama_mapel_custom' => "VARCHAR(150) NULL",
                'ruangan'           => "VARCHAR(100) NULL",
                'jam_mulai'         => "TIME NULL",
                'jam_selesai'       => "TIME NULL",
                'materi_pembahasan' => "TEXT NULL",
                'catatan_tentor'    => "TEXT NULL",
                'foto_dokumentasi'  => "VARCHAR(255) NULL"
            );
            foreach ($fields as $col => $col_def) {
                if (!$this->db->field_exists($col, 'presensi_mbf')) {
                    $this->db->query("ALTER TABLE `presensi_mbf` ADD COLUMN `$col` $col_def;");
                }
            }
        }

        // Table: presensi_mbf_detail
        if (!$this->db->table_exists('presensi_mbf_detail')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `presensi_mbf_detail` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `presensi_mbf_id` int unsigned NOT NULL,
              `siswa_id` int unsigned NOT NULL,
              `status` enum('Hadir','Izin','Sakit','Alpa') NOT NULL DEFAULT 'Hadir',
              `catatan` varchar(255) DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              UNIQUE KEY `uk_presensi_siswa_mbf` (`presensi_mbf_id`,`siswa_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Role: tentor
        $role_check = $this->db->get_where('roles', array('role_code' => 'tentor'))->row_array();
        if (!$role_check) {
            $this->db->insert('roles', array(
                'role_code' => 'tentor',
                'role_name' => 'Tentor MBF',
                'description' => 'Role khusus Pengajar/Tentor Modul MBF',
                'created_at' => date('Y-m-d H:i:s')
            ));
        }
    }

    // ========================================================
    // 1. TENTOR MANAGEMENT
    // ========================================================

    public function get_all_tentor() {
        $this->db->select('tentor.*, users.username, users.is_active as user_active, (SELECT COUNT(*) FROM mapel_mbf WHERE mapel_mbf.tentor_id = tentor.id) as total_mapel');
        $this->db->from('tentor');
        $this->db->join('users', 'users.id = tentor.user_id', 'left');
        $this->db->order_by('tentor.nama_lengkap', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_tentor_by_id($id) {
        $this->db->select('tentor.*, users.username, users.email as user_email, users.is_active as user_active');
        $this->db->from('tentor');
        $this->db->join('users', 'users.id = tentor.user_id', 'left');
        $this->db->where('tentor.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_tentor_by_user_id($user_id) {
        return $this->db->get_where('tentor', array('user_id' => $user_id))->row_array();
    }

    public function get_all_guru_for_tentor() {
        $this->db->select('guru.*, users.username');
        $this->db->from('guru');
        $this->db->join('users', 'users.id = guru.user_id', 'left');
        $this->db->order_by('guru.nama_lengkap', 'ASC');
        return $this->db->get()->result_array();
    }

    public function save_tentor_from_guru($guru_id) {
        $guru = $this->db->get_where('guru', array('id' => $guru_id))->row_array();
        if (!$guru) return FALSE;

        // Check if already registered as tentor
        $existing = $this->db->get_where('tentor', array('guru_id' => $guru_id))->row_array();
        if ($existing) {
            return $existing['id'];
        }

        $data_tentor = array(
            'guru_id'      => $guru['id'],
            'user_id'      => $guru['user_id'] ? $guru['user_id'] : NULL,
            'nip'          => $guru['nip'],
            'nama_lengkap' => $guru['nama_lengkap'],
            'no_hp'        => $guru['no_hp'],
            'email'        => $guru['email'],
            'is_active'    => 1
        );

        $this->db->insert('tentor', $data_tentor);
        return $this->db->insert_id();
    }

    public function save_tentor($data_tentor, $data_user = NULL) {
        $this->db->trans_start();

        $user_id = NULL;
        if (!empty($data_user)) {
            // Get role_id for 'tentor'
            $role = $this->db->get_where('roles', array('role_code' => 'tentor'))->row_array();
            $role_id = $role ? $role['id'] : 1;

            $insert_user = array(
                'username'  => $data_user['username'],
                'email'     => !empty($data_user['email']) ? $data_user['email'] : $data_user['username'] . '@mbf.sch.id',
                'password'  => password_hash($data_user['password'], PASSWORD_BCRYPT),
                'full_name' => $data_tentor['nama_lengkap'],
                'role_id'   => $role_id,
                'is_active' => isset($data_user['is_active']) ? $data_user['is_active'] : 1
            );
            $this->db->insert('users', $insert_user);
            $user_id = $this->db->insert_id();
        }

        $data_tentor['user_id'] = $user_id;
        $this->db->insert('tentor', $data_tentor);
        $tentor_id = $this->db->insert_id();

        $this->db->trans_complete();
        return $this->db->trans_status() ? $tentor_id : FALSE;
    }

    public function update_tentor($id, $data_tentor, $data_user = NULL) {
        $this->db->trans_start();

        $tentor = $this->get_tentor_by_id($id);
        if ($tentor && $tentor['user_id']) {
            $user_id = $tentor['user_id'];
            if (!empty($data_user)) {
                $update_user = array(
                    'full_name' => $data_tentor['nama_lengkap']
                );
                if (!empty($data_user['username'])) {
                    $update_user['username'] = $data_user['username'];
                }
                if (!empty($data_user['password'])) {
                    $update_user['password'] = password_hash($data_user['password'], PASSWORD_BCRYPT);
                }
                if (isset($data_user['is_active'])) {
                    $update_user['is_active'] = $data_user['is_active'];
                }

                $this->db->where('id', $user_id);
                $this->db->update('users', $update_user);
            }
        } elseif (!empty($data_user) && !empty($data_user['username'])) {
            // Create user account if not exists
            $role = $this->db->get_where('roles', array('role_code' => 'tentor'))->row_array();
            $role_id = $role ? $role['id'] : 1;

            $insert_user = array(
                'username'  => $data_user['username'],
                'email'     => !empty($data_user['email']) ? $data_user['email'] : $data_user['username'] . '@mbf.sch.id',
                'password'  => password_hash($data_user['password'], PASSWORD_BCRYPT),
                'full_name' => $data_tentor['nama_lengkap'],
                'role_id'   => $role_id,
                'is_active' => isset($data_user['is_active']) ? $data_user['is_active'] : 1
            );
            $this->db->insert('users', $insert_user);
            $data_tentor['user_id'] = $this->db->insert_id();
        }

        $this->db->where('id', $id);
        $this->db->update('tentor', $data_tentor);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_tentor($id) {
        $this->db->trans_start();

        $tentor = $this->get_tentor_by_id($id);
        if ($tentor) {
            $this->db->where('id', $id);
            $this->db->delete('tentor');

            if ($tentor['user_id']) {
                $this->db->where('id', $tentor['user_id']);
                $this->db->delete('users');
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // ========================================================
    // 2. MAPEL MBF MANAGEMENT
    // ========================================================

    public function get_all_mapel($tp_id = NULL, $semester = NULL) {
        $this->db->select('mapel_mbf.*, tentor.nama_lengkap as nama_tentor, tahun_pelajaran.tahun, tahun_pelajaran.semester as tp_semester, (SELECT COUNT(*) FROM peserta_mapel_mbf WHERE peserta_mapel_mbf.mapel_mbf_id = mapel_mbf.id) as total_peserta');
        $this->db->from('mapel_mbf');
        $this->db->join('tentor', 'tentor.id = mapel_mbf.tentor_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = mapel_mbf.tahun_pelajaran_id');

        if ($tp_id) {
            $this->db->where('mapel_mbf.tahun_pelajaran_id', $tp_id);
        }
        if ($semester) {
            $this->db->where('mapel_mbf.semester', $semester);
        }

        $this->db->order_by('mapel_mbf.nama_mapel', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_mapel_by_id($id) {
        $this->db->select('mapel_mbf.*, tentor.nama_lengkap as nama_tentor, tahun_pelajaran.tahun, tahun_pelajaran.semester as tp_semester, (SELECT COUNT(*) FROM peserta_mapel_mbf WHERE peserta_mapel_mbf.mapel_mbf_id = mapel_mbf.id) as total_peserta');
        $this->db->from('mapel_mbf');
        $this->db->join('tentor', 'tentor.id = mapel_mbf.tentor_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = mapel_mbf.tahun_pelajaran_id');
        $this->db->where('mapel_mbf.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_mapel_by_tentor($tentor_id, $tp_id = NULL, $semester = NULL) {
        $this->db->select('mapel_mbf.*, tentor.nama_lengkap as nama_tentor, tahun_pelajaran.tahun, tahun_pelajaran.semester as tp_semester, (SELECT COUNT(*) FROM peserta_mapel_mbf WHERE peserta_mapel_mbf.mapel_mbf_id = mapel_mbf.id) as total_peserta');
        $this->db->from('mapel_mbf');
        $this->db->join('tentor', 'tentor.id = mapel_mbf.tentor_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = mapel_mbf.tahun_pelajaran_id');
        $this->db->where('mapel_mbf.tentor_id', $tentor_id);

        if ($tp_id) {
            $this->db->where('mapel_mbf.tahun_pelajaran_id', $tp_id);
        }
        if ($semester) {
            $this->db->where('mapel_mbf.semester', $semester);
        }

        $this->db->order_by('mapel_mbf.nama_mapel', 'ASC');
        return $this->db->get()->result_array();
    }

    public function save_mapel($data) {
        $this->db->insert('mapel_mbf', $data);
        return $this->db->insert_id();
    }

    public function update_mapel($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('mapel_mbf', $data);
    }

    public function delete_mapel($id) {
        $this->db->where('id', $id);
        return $this->db->delete('mapel_mbf');
    }

    // ========================================================
    // 3. PESERTA MAPEL MBF
    // ========================================================

    public function get_peserta_by_mapel($mapel_mbf_id) {
        $this->db->select('siswa.*, IFNULL(kelas.nama_kelas, "-") as nama_kelas, kelas.kode_kelas, peserta_mapel_mbf.created_at as enrolled_at');
        $this->db->from('peserta_mapel_mbf');
        $this->db->join('siswa', 'siswa.id = peserta_mapel_mbf.siswa_id');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id', 'left');
        $this->db->where('peserta_mapel_mbf.mapel_mbf_id', $mapel_mbf_id);
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_siswa_enrolled_ids($mapel_mbf_id) {
        $this->db->select('siswa_id');
        $this->db->from('peserta_mapel_mbf');
        $this->db->where('mapel_mbf_id', $mapel_mbf_id);
        $query = $this->db->get()->result_array();
        return array_column($query, 'siswa_id');
    }

    public function save_peserta_batch($mapel_mbf_id, $siswa_ids) {
        $this->db->trans_start();

        // Get currently enrolled
        $existing_ids = $this->get_siswa_enrolled_ids($mapel_mbf_id);

        $siswa_ids = is_array($siswa_ids) ? array_map('intval', $siswa_ids) : array();

        // Determine to delete
        $to_delete = array_diff($existing_ids, $siswa_ids);
        if (!empty($to_delete)) {
            $this->db->where('mapel_mbf_id', $mapel_mbf_id);
            $this->db->where_in('siswa_id', $to_delete);
            $this->db->delete('peserta_mapel_mbf');
        }

        // Determine to insert
        $to_insert = array_diff($siswa_ids, $existing_ids);
        if (!empty($to_insert)) {
            $batch_data = array();
            foreach ($to_insert as $s_id) {
                $batch_data[] = array(
                    'mapel_mbf_id' => $mapel_mbf_id,
                    'siswa_id'     => $s_id
                );
            }
            $this->db->insert_batch('peserta_mapel_mbf', $batch_data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_mbf_students_filtered($filters = array()) {
        $this->db->select('siswa.*, kelas.nama_kelas, GROUP_CONCAT(DISTINCT mapel_mbf.nama_mapel SEPARATOR ", ") as daftar_mapel, GROUP_CONCAT(DISTINCT tentor.nama_lengkap SEPARATOR ", ") as daftar_tentor');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id');
        $this->db->join('peserta_mapel_mbf', 'peserta_mapel_mbf.siswa_id = siswa.id');
        $this->db->join('mapel_mbf', 'mapel_mbf.id = peserta_mapel_mbf.mapel_mbf_id');
        $this->db->join('tentor', 'tentor.id = mapel_mbf.tentor_id');

        if (!empty($filters['kelas_id'])) {
            $this->db->where('siswa.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['mapel_mbf_id'])) {
            $this->db->where('peserta_mapel_mbf.mapel_mbf_id', $filters['mapel_mbf_id']);
        }
        if (!empty($filters['tentor_id'])) {
            $this->db->where('mapel_mbf.tentor_id', $filters['tentor_id']);
        }
        if (!empty($filters['tahun_pelajaran_id'])) {
            $this->db->where('mapel_mbf.tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        }
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start();
            $this->db->like('siswa.nama_lengkap', $s);
            $this->db->or_like('siswa.nis', $s);
            $this->db->or_like('siswa.nisn', $s);
            $this->db->group_end();
        }

        $this->db->where('siswa.status_aktif', 1);
        $this->db->group_by('siswa.id');
        $this->db->order_by('siswa.nama_lengkap', 'ASC');

        return $this->db->get()->result_array();
    }

    // ========================================================
    // 4. PRESENSI MBF
    // ========================================================

    public function get_presensi_by_mapel_tanggal($mapel_mbf_id, $tanggal) {
        $header = $this->db->get_where('presensi_mbf', array(
            'mapel_mbf_id' => $mapel_mbf_id,
            'tanggal'      => $tanggal
        ))->row_array();

        $details_map = array();
        if ($header) {
            $details = $this->db->get_where('presensi_mbf_detail', array('presensi_mbf_id' => $header['id']))->result_array();
            foreach ($details as $d) {
                $details_map[$d['siswa_id']] = $d;
            }
        }

        return array(
            'header'  => $header,
            'details' => $details_map
        );
    }

    public function get_presensi_by_id($id) {
        $this->db->select('presensi_mbf.*, mapel_mbf.nama_mapel, mapel_mbf.kode_mapel, mapel_mbf.tentor_id, tentor.nama_lengkap as nama_tentor');
        $this->db->from('presensi_mbf');
        $this->db->join('mapel_mbf', 'mapel_mbf.id = presensi_mbf.mapel_mbf_id');
        $this->db->join('tentor', 'tentor.id = mapel_mbf.tentor_id');
        $this->db->where('presensi_mbf.id', $id);
        $header = $this->db->get()->row_array();

        if (!$header) return NULL;

        $this->db->select('presensi_mbf_detail.*, siswa.nama_lengkap as nama_siswa, siswa.nis, siswa.nisn, kelas.nama_kelas');
        $this->db->from('presensi_mbf_detail');
        $this->db->join('siswa', 'siswa.id = presensi_mbf_detail.siswa_id');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id', 'left');
        $this->db->where('presensi_mbf_detail.presensi_mbf_id', $id);
        $this->db->order_by('siswa.nama_lengkap', 'ASC');
        $details = $this->db->get()->result_array();

        $header['details'] = $details;
        return $header;
    }

    public function delete_presensi($id) {
        $header = $this->db->get_where('presensi_mbf', array('id' => $id))->row_array();
        if (!$header) return FALSE;

        $this->db->trans_start();
        $this->db->where('presensi_mbf_id', $id);
        $this->db->delete('presensi_mbf_detail');

        $this->db->where('id', $id);
        $this->db->delete('presensi_mbf');
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            return $header;
        }
        return FALSE;
    }

    public function save_presensi_batch($mapel_mbf_id, $tanggal, $catatan_header, $presensi_list, $user_id, $jurnal_extra = array(), $presensi_id = NULL) {
        $this->db->trans_start();

        // 1. Find or Create Header
        $existing = NULL;
        if (!empty($presensi_id)) {
            $existing = $this->db->get_where('presensi_mbf', array('id' => $presensi_id))->row_array();
        }
        if (!$existing) {
            $existing = $this->db->get_where('presensi_mbf', array(
                'mapel_mbf_id' => $mapel_mbf_id,
                'tanggal'      => $tanggal
            ))->row_array();
        }

        $header_data = array(
            'mapel_mbf_id' => $mapel_mbf_id,
            'tanggal'      => $tanggal,
            'catatan'      => $catatan_header,
            'updated_at'   => date('Y-m-d H:i:s')
        );

        if (!empty($jurnal_extra['pertemuan_ke'])) {
            $header_data['pertemuan_ke'] = (int)$jurnal_extra['pertemuan_ke'];
        }
        if (!empty($jurnal_extra['status_sesi'])) {
            $header_data['status_sesi'] = $jurnal_extra['status_sesi'];
        }
        if (isset($jurnal_extra['nama_mapel_custom'])) {
            $header_data['nama_mapel_custom'] = $jurnal_extra['nama_mapel_custom'];
        }
        if (isset($jurnal_extra['ruangan'])) {
            $header_data['ruangan'] = $jurnal_extra['ruangan'];
        }
        if (!empty($jurnal_extra['jam_mulai'])) {
            $header_data['jam_mulai'] = $jurnal_extra['jam_mulai'];
        }
        if (!empty($jurnal_extra['jam_selesai'])) {
            $header_data['jam_selesai'] = $jurnal_extra['jam_selesai'];
        }
        if (isset($jurnal_extra['materi_pembahasan'])) {
            $header_data['materi_pembahasan'] = $jurnal_extra['materi_pembahasan'];
        }
        if (isset($jurnal_extra['catatan_tentor'])) {
            $header_data['catatan_tentor'] = $jurnal_extra['catatan_tentor'];
        }
        if (!empty($jurnal_extra['foto_dokumentasi'])) {
            $header_data['foto_dokumentasi'] = $jurnal_extra['foto_dokumentasi'];
        }

        if ($existing) {
            $presensi_mbf_id = $existing['id'];
            $this->db->where('id', $presensi_mbf_id);
            $this->db->update('presensi_mbf', $header_data);
        } else {
            if (empty($header_data['pertemuan_ke'])) {
                $count_prev = $this->db->where('mapel_mbf_id', $mapel_mbf_id)->count_all_results('presensi_mbf');
                $header_data['pertemuan_ke'] = $count_prev + 1;
            }
            $header_data['created_by'] = $user_id;
            $header_data['created_at'] = date('Y-m-d H:i:s');

            $this->db->insert('presensi_mbf', $header_data);
            $presensi_mbf_id = $this->db->insert_id();
        }

        // 2. Save Detail Status for each student
        foreach ($presensi_list as $item) {
            $siswa_id = (int)$item['siswa_id'];
            $status   = !empty($item['status']) ? $item['status'] : 'Hadir';
            $catatan  = !empty($item['catatan']) ? $item['catatan'] : NULL;

            // Check if existing detail row
            $ex_detail = $this->db->get_where('presensi_mbf_detail', array(
                'presensi_mbf_id' => $presensi_mbf_id,
                'siswa_id'        => $siswa_id
            ))->row_array();

            if ($ex_detail) {
                $this->db->where('id', $ex_detail['id']);
                $this->db->update('presensi_mbf_detail', array(
                    'status'     => $status,
                    'catatan'    => $catatan,
                    'updated_at' => date('Y-m-d H:i:s')
                ));
            } else {
                $this->db->insert('presensi_mbf_detail', array(
                    'presensi_mbf_id' => $presensi_mbf_id,
                    'siswa_id'        => $siswa_id,
                    'status'          => $status,
                    'catatan'         => $catatan
                ));
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_presensi_filtered($filters = array()) {
        $this->db->select('presensi_mbf.*, mapel_mbf.nama_mapel, mapel_mbf.kode_mapel, tentor.nama_lengkap as nama_tentor,
            (SELECT COUNT(*) FROM presensi_mbf_detail WHERE presensi_mbf_id = presensi_mbf.id AND status = "Hadir") as count_hadir,
            (SELECT COUNT(*) FROM presensi_mbf_detail WHERE presensi_mbf_id = presensi_mbf.id AND status = "Izin") as count_izin,
            (SELECT COUNT(*) FROM presensi_mbf_detail WHERE presensi_mbf_id = presensi_mbf.id AND status = "Sakit") as count_sakit,
            (SELECT COUNT(*) FROM presensi_mbf_detail WHERE presensi_mbf_id = presensi_mbf.id AND status = "Alpa") as count_alpa');
        $this->db->from('presensi_mbf');
        $this->db->join('mapel_mbf', 'mapel_mbf.id = presensi_mbf.mapel_mbf_id');
        $this->db->join('tentor', 'tentor.id = mapel_mbf.tentor_id');

        if (!empty($filters['mapel_mbf_id'])) {
            $this->db->where('presensi_mbf.mapel_mbf_id', $filters['mapel_mbf_id']);
        }
        if (!empty($filters['tentor_id'])) {
            $this->db->where('mapel_mbf.tentor_id', $filters['tentor_id']);
        }
        if (!empty($filters['tahun_pelajaran_id'])) {
            $this->db->where('mapel_mbf.tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        }
        if (!empty($filters['tanggal_mulai'])) {
            $this->db->where('presensi_mbf.tanggal >=', $filters['tanggal_mulai']);
        }
        if (!empty($filters['tanggal_selesai'])) {
            $this->db->where('presensi_mbf.tanggal <=', $filters['tanggal_selesai']);
        }

        $this->db->order_by('presensi_mbf.tanggal', 'DESC');
        return $this->db->get()->result_array();
    }

    // ========================================================
    // 5. REKAP PRESENSI MBF
    // ========================================================

    public function get_rekap_per_mapel($mapel_mbf_id, $filters = array()) {
        $peserta = $this->get_peserta_by_mapel($mapel_mbf_id);
        if (empty($peserta)) return array();

        $siswa_ids = array_column($peserta, 'id');

        $this->db->select('presensi_mbf_detail.siswa_id, presensi_mbf_detail.status, COUNT(*) as total');
        $this->db->from('presensi_mbf_detail');
        $this->db->join('presensi_mbf', 'presensi_mbf.id = presensi_mbf_detail.presensi_mbf_id');
        $this->db->where('presensi_mbf.mapel_mbf_id', $mapel_mbf_id);
        $this->db->where_in('presensi_mbf_detail.siswa_id', $siswa_ids);

        if (!empty($filters['tanggal_mulai'])) {
            $this->db->where('presensi_mbf.tanggal >=', $filters['tanggal_mulai']);
        }
        if (!empty($filters['tanggal_selesai'])) {
            $this->db->where('presensi_mbf.tanggal <=', $filters['tanggal_selesai']);
        }
        if (!empty($filters['bulan'])) {
            $this->db->where('MONTH(presensi_mbf.tanggal)', $filters['bulan']);
        }

        $this->db->group_by('presensi_mbf_detail.siswa_id, presensi_mbf_detail.status');
        $query = $this->db->get()->result_array();

        $rekap_map = array();
        foreach ($peserta as $s) {
            $rekap_map[$s['id']] = array(
                'siswa'      => $s,
                'Hadir'      => 0,
                'Izin'       => 0,
                'Sakit'      => 0,
                'Alpa'       => 0,
                'total'      => 0,
                'persentase' => 100.0
            );
        }

        foreach ($query as $row) {
            $s_id = $row['siswa_id'];
            $status = $row['status'];
            if (isset($rekap_map[$s_id])) {
                $rekap_map[$s_id][$status] = (int)$row['total'];
            }
        }

        foreach ($rekap_map as $s_id => &$r) {
            $tot = $r['Hadir'] + $r['Izin'] + $r['Sakit'] + $r['Alpa'];
            $r['total'] = $tot;
            $r['persentase'] = ($tot > 0) ? round(($r['Hadir'] / $tot) * 100, 1) : 100.0;
        }

        return array_values($rekap_map);
    }

    public function get_rekap_per_siswa($siswa_id, $filters = array()) {
        $this->db->select('mapel_mbf.id as mapel_id, mapel_mbf.nama_mapel, tentor.nama_lengkap as nama_tentor, presensi_mbf_detail.status, COUNT(*) as total');
        $this->db->from('presensi_mbf_detail');
        $this->db->join('presensi_mbf', 'presensi_mbf.id = presensi_mbf_detail.presensi_mbf_id');
        $this->db->join('mapel_mbf', 'mapel_mbf.id = presensi_mbf.mapel_mbf_id');
        $this->db->join('tentor', 'tentor.id = mapel_mbf.tentor_id');
        $this->db->where('presensi_mbf_detail.siswa_id', $siswa_id);

        if (!empty($filters['tahun_pelajaran_id'])) {
            $this->db->where('mapel_mbf.tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        }

        $this->db->group_by('mapel_mbf.id, presensi_mbf_detail.status');
        $query = $this->db->get()->result_array();

        $rekap_map = array();
        foreach ($query as $r) {
            $m_id = $r['mapel_id'];
            if (!isset($rekap_map[$m_id])) {
                $rekap_map[$m_id] = array(
                    'mapel_id'   => $m_id,
                    'nama_mapel' => $r['nama_mapel'],
                    'nama_tentor'=> $r['nama_tentor'],
                    'Hadir'      => 0,
                    'Izin'       => 0,
                    'Sakit'      => 0,
                    'Alpa'       => 0,
                    'total'      => 0,
                    'persentase' => 100.0
                );
            }
            $rekap_map[$m_id][$r['status']] = (int)$r['total'];
        }

        foreach ($rekap_map as &$r) {
            $tot = $r['Hadir'] + $r['Izin'] + $r['Sakit'] + $r['Alpa'];
            $r['total'] = $tot;
            $r['persentase'] = ($tot > 0) ? round(($r['Hadir'] / $tot) * 100, 1) : 100.0;
        }

        return array_values($rekap_map);
    }

    public function get_rekap_per_tentor($tentor_id, $filters = array()) {
        $mapel_list = $this->get_mapel_by_tentor($tentor_id, $filters['tahun_pelajaran_id'] ?? NULL);
        $result = array();

        foreach ($mapel_list as $m) {
            $rekap_mapel = $this->get_rekap_per_mapel($m['id'], $filters);
            $total_hadir = array_sum(array_column($rekap_mapel, 'Hadir'));
            $total_izin = array_sum(array_column($rekap_mapel, 'Izin'));
            $total_sakit = array_sum(array_column($rekap_mapel, 'Sakit'));
            $total_alpa = array_sum(array_column($rekap_mapel, 'Alpa'));
            $grand_total = $total_hadir + $total_izin + $total_sakit + $total_alpa;
            $avg_pct = ($grand_total > 0) ? round(($total_hadir / $grand_total) * 100, 1) : 100.0;

            $result[] = array(
                'mapel'         => $m,
                'total_siswa'   => count($rekap_mapel),
                'total_hadir'   => $total_hadir,
                'total_izin'    => $total_izin,
                'total_sakit'   => $total_sakit,
                'total_alpa'    => $total_alpa,
                'avg_persentase'=> $avg_pct
            );
        }

        return $result;
    }

    // ========================================================
    // 6. DASHBOARD STATS
    // ========================================================

    public function get_admin_dashboard_stats($tp_id = NULL) {
        $data = array();
        $data['total_tentor'] = $this->db->where('is_active', 1)->count_all_results('tentor');

        if ($tp_id) {
            $this->db->where('tahun_pelajaran_id', $tp_id);
        }
        $data['total_mapel'] = $this->db->count_all_results('mapel_mbf');

        $this->db->select('COUNT(DISTINCT siswa_id) as total');
        if ($tp_id) {
            $this->db->join('mapel_mbf', 'mapel_mbf.id = peserta_mapel_mbf.mapel_mbf_id');
            $this->db->where('mapel_mbf.tahun_pelajaran_id', $tp_id);
        }
        $row_s = $this->db->get('peserta_mapel_mbf')->row_array();
        $data['total_siswa_mbf'] = $row_s ? (int)$row_s['total'] : 0;

        if ($tp_id) {
            $this->db->join('mapel_mbf', 'mapel_mbf.id = peserta_mapel_mbf.mapel_mbf_id');
            $this->db->where('mapel_mbf.tahun_pelajaran_id', $tp_id);
        }
        $data['total_peserta'] = $this->db->count_all_results('peserta_mapel_mbf');

        // Presensi hari ini
        $this->db->select('status, COUNT(*) as count');
        $this->db->from('presensi_mbf_detail');
        $this->db->join('presensi_mbf', 'presensi_mbf.id = presensi_mbf_detail.presensi_mbf_id');
        $this->db->where('presensi_mbf.tanggal', date('Y-m-d'));
        $this->db->group_by('status');
        $today_raw = $this->db->get()->result_array();

        $today_map = array('Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpa' => 0);
        foreach ($today_raw as $tr) {
            if (isset($today_map[$tr['status']])) {
                $today_map[$tr['status']] = (int)$tr['count'];
            }
        }
        $data['kehadiran_hari_ini'] = $today_map;

        return $data;
    }

    public function get_tentor_dashboard_stats($tentor_id, $tp_id = NULL) {
        $data = array();

        $mapel_list = $this->get_mapel_by_tentor($tentor_id, $tp_id);
        $data['total_mapel'] = count($mapel_list);
        $mapel_ids = array_column($mapel_list, 'id');

        if (!empty($mapel_ids)) {
            $this->db->select('COUNT(DISTINCT siswa_id) as total');
            $this->db->where_in('mapel_mbf_id', $mapel_ids);
            $row_s = $this->db->get('peserta_mapel_mbf')->row_array();
            $data['total_siswa'] = $row_s ? (int)$row_s['total'] : 0;

            // Pertemuan Bulan Ini
            $this->db->where_in('mapel_mbf_id', $mapel_ids);
            $this->db->where('MONTH(tanggal)', date('n'));
            $this->db->where('YEAR(tanggal)', date('Y'));
            $data['pertemuan_bulan_ini'] = $this->db->count_all_results('presensi_mbf');

            // Kehadiran Hari ini
            $this->db->select('status, COUNT(*) as count');
            $this->db->from('presensi_mbf_detail');
            $this->db->join('presensi_mbf', 'presensi_mbf.id = presensi_mbf_detail.presensi_mbf_id');
            $this->db->where_in('presensi_mbf.mapel_mbf_id', $mapel_ids);
            $this->db->where('presensi_mbf.tanggal', date('Y-m-d'));
            $this->db->group_by('status');
            $today_raw = $this->db->get()->result_array();

            $today_map = array('Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpa' => 0);
            foreach ($today_raw as $tr) {
                if (isset($today_map[$tr['status']])) {
                    $today_map[$tr['status']] = (int)$tr['count'];
                }
            }
            $data['kehadiran_hari_ini'] = $today_map;

            // Recent Presensi
            $this->db->select('presensi_mbf.*, mapel_mbf.nama_mapel,
                (SELECT COUNT(*) FROM presensi_mbf_detail WHERE presensi_mbf_id = presensi_mbf.id AND status = "Hadir") as count_hadir');
            $this->db->from('presensi_mbf');
            $this->db->join('mapel_mbf', 'mapel_mbf.id = presensi_mbf.mapel_mbf_id');
            $this->db->where_in('presensi_mbf.mapel_mbf_id', $mapel_ids);
            $this->db->order_by('presensi_mbf.tanggal', 'DESC');
            $this->db->limit(5);
            $data['recent_presensi'] = $this->db->get()->result_array();

        } else {
            $data['total_siswa'] = 0;
            $data['pertemuan_bulan_ini'] = 0;
            $data['kehadiran_hari_ini'] = array('Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpa' => 0);
            $data['recent_presensi'] = array();
        }

        $data['mapel_list'] = $mapel_list;
        return $data;
    }
}
