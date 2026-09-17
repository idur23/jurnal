<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perangkat_model extends MY_Model {
    protected $table = 'perangkat_ajar';

    public function __construct() {
        parent::__construct();
        // Load cache driver
        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));
        $this->ensure_rencana_table();
    }

    private function ensure_rencana_table() {
        if (!$this->db->table_exists('rencana_pelaksanaan')) {
            $sql = "CREATE TABLE IF NOT EXISTS `rencana_pelaksanaan` (
              `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `perangkat_ajar_id` INT UNSIGNED NULL,
              `guru_id` INT UNSIGNED NOT NULL,
              `mapel_id` INT UNSIGNED NOT NULL,
              `kelas_id` INT UNSIGNED NULL,
              `kelas_ids` TEXT NULL,
              `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
              `semester` VARCHAR(20) DEFAULT 'Ganjil',
              `elemen` VARCHAR(255) NULL,
              `materi_pembelajaran` TEXT NULL,
              `sub_materi` TEXT NULL,
              `capaian_pembelajaran` TEXT NULL,
              `tujuan_pembelajaran` TEXT NOT NULL,
              `metode_pembelajaran` TEXT NULL,
              `model_pembelajaran` TEXT NULL,
              `media_pembelajaran` TEXT NULL,
              `sumber_belajar` TEXT NULL,
              `bentuk_penilaian` TEXT NULL,
              `alokasi_waktu` VARCHAR(100) NULL,
              `pertemuan_ke` INT DEFAULT 1,
              `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
              `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              INDEX `idx_rp_guru` (`guru_id`),
              INDEX `idx_rp_mapel` (`mapel_id`),
              INDEX `idx_rp_kelas` (`kelas_id`),
              INDEX `idx_rp_tp` (`tahun_pelajaran_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            @$this->db->query($sql);
        }
    }

    public function get_by_id($id) {
        $this->db->select('perangkat_ajar.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, tahun_pelajaran.tahun, tahun_pelajaran.semester as tp_semester');
        $this->db->join('kelas', 'kelas.id = perangkat_ajar.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id');
        $this->db->join('guru', 'guru.id = perangkat_ajar.guru_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = perangkat_ajar.tahun_pelajaran_id');
        $this->db->where('perangkat_ajar.id', $id);
        return $this->db->get($this->table)->row_array();
    }

    /**
     * Get active/current devices with relations
     */
    public function get_all_with_relations($filters = array(), $limit = NULL, $offset = NULL) {
        $this->db->select('perangkat_ajar.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, tahun_pelajaran.tahun, tahun_pelajaran.semester as tp_semester');
        $this->db->join('kelas', 'kelas.id = perangkat_ajar.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id');
        $this->db->join('guru', 'guru.id = perangkat_ajar.guru_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = perangkat_ajar.tahun_pelajaran_id');

        $this->apply_filters($filters);

        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('perangkat_ajar.id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    public function count_filtered($filters = array()) {
        $this->db->join('kelas', 'kelas.id = perangkat_ajar.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id');
        $this->db->join('guru', 'guru.id = perangkat_ajar.guru_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = perangkat_ajar.tahun_pelajaran_id');

        $this->apply_filters($filters);
        return $this->db->count_all_results($this->table);
    }

    private function apply_filters($filters) {
        if (!empty($filters['id'])) {
            $this->db->where('perangkat_ajar.id', $filters['id']);
        }
        if (!empty($filters['guru_id'])) {
            $this->db->where('perangkat_ajar.guru_id', $filters['guru_id']);
        }
        if (!empty($filters['kelas_id'])) {
            $this->db->where('perangkat_ajar.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['mapel_id'])) {
            $this->db->where('perangkat_ajar.mapel_id', $filters['mapel_id']);
        }
        if (!empty($filters['semester'])) {
            $this->db->where('perangkat_ajar.semester', $filters['semester']);
        }
        if (!empty($filters['tahun_pelajaran_id'])) {
            $this->db->where('perangkat_ajar.tahun_pelajaran_id', $filters['tahun_pelajaran_id']);
        }
        if (!empty($filters['status_verifikasi'])) {
            $this->db->where('perangkat_ajar.status_verifikasi', $filters['status_verifikasi']);
        }
        if (!empty($filters['jenis_perangkat'])) {
            $this->db->where('perangkat_ajar.jenis_perangkat', $filters['jenis_perangkat']);
        }
        if (isset($filters['is_active'])) {
            $this->db->where('perangkat_ajar.is_active', $filters['is_active']);
        } else {
            $this->db->where('perangkat_ajar.is_active', 1);
        }
        if (isset($filters['is_archived'])) {
            $this->db->where('perangkat_ajar.is_archived', $filters['is_archived']);
        } else {
            $this->db->where('perangkat_ajar.is_archived', 0);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start();
            $this->db->like('perangkat_ajar.materi_pembelajaran', $search);
            $this->db->or_like('perangkat_ajar.sub_materi', $search);
            $this->db->or_like('perangkat_ajar.tujuan_pembelajaran', $search);
            $this->db->or_like('perangkat_ajar.jenis_perangkat', $search);
            $this->db->or_like('guru.nama_lengkap', $search);
            $this->db->or_like('mata_pelajaran.nama_mapel', $search);
            $this->db->group_end();
        }
    }

    /**
     * Find a teaching device with caching for performance
     */
    public function get_matched_device($tp_id, $semester, $mapel_id, $guru_id, $kelas_id, $pertemuan_ke) {
        $cache_key = "device_match_{$tp_id}_{$semester}_{$mapel_id}_{$guru_id}_{$kelas_id}_{$pertemuan_ke}";
        
        // Attempt to fetch from cache
        $cached_data = $this->cache->get($cache_key);
        if ($cached_data !== FALSE) {
            return $cached_data;
        }

        // Database lookup
        $this->db->where('tahun_pelajaran_id', $tp_id);
        $this->db->where('semester', $semester);
        $this->db->where('mapel_id', $mapel_id);
        $this->db->where('guru_id', $guru_id);
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('pertemuan_ke', $pertemuan_ke);
        $this->db->where('is_active', 1);
        $this->db->where('is_archived', 0);
        $this->db->order_by('version', 'DESC');
        $device = $this->db->get($this->table)->row_array();

        if ($device) {
            // Save to cache for 10 minutes (600s)
            $this->cache->save($cache_key, $device, 600);
        }

        return $device;
    }

    /**
     * Clear matching cache
     */
    public function clear_device_cache($tp_id, $semester, $mapel_id, $guru_id, $kelas_id, $pertemuan_ke) {
        $cache_key = "device_match_{$tp_id}_{$semester}_{$mapel_id}_{$guru_id}_{$kelas_id}_{$pertemuan_ke}";
        $this->cache->delete($cache_key);
    }

    /**
     * Fetch version history tree
     */
    public function get_version_history($id) {
        $device = $this->db->get_where($this->table, array('id' => $id))->row_array();
        if (!$device) {
            return array();
        }

        $parent_id = $device['parent_id'] ? $device['parent_id'] : $device['id'];

        $this->db->select('perangkat_ajar.*, users.full_name as creator_name');
        $this->db->join('users', 'users.id = perangkat_ajar.created_by');
        $this->db->group_start();
        $this->db->where('perangkat_ajar.id', $parent_id);
        $this->db->or_where('perangkat_ajar.parent_id', $parent_id);
        $this->db->group_end();
        $this->db->order_by('perangkat_ajar.version', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Save revised device as a new version
     */
    public function save_revision($id, $data, $created_by) {
        $original = $this->db->get_where($this->table, array('id' => $id))->row_array();
        if (!$original) {
            return FALSE;
        }

        $parent_id = $original['parent_id'] ? $original['parent_id'] : $original['id'];
        $next_version = $original['version'] + 1;

        // Set previous versions to is_active = 0
        $this->db->where('id', $parent_id)->or_where('parent_id', $parent_id);
        $this->db->update($this->table, array('is_active' => 0));

        // Insert new version
        $new_device = array_merge($original, $data, array(
            'id' => NULL,
            'version' => $next_version,
            'parent_id' => $parent_id,
            'is_active' => 1,
            'status_verifikasi' => 'Menunggu Verifikasi', // Resets verification status on revision
            'catatan_revisi' => NULL,
            'created_by' => $created_by,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => NULL,
            'verified_by' => NULL,
            'verified_at' => NULL
        ));

        $this->db->insert($this->table, $new_device);
        $new_id = $this->db->insert_id();

        // Clear cache
        $this->clear_device_cache($original['tahun_pelajaran_id'], $original['semester'], $original['mapel_id'], $original['guru_id'], $original['kelas_id'], $original['pertemuan_ke']);

        return $new_id;
    }

    /**
     * Get records for DataTables serverside processing
     */
    public function get_datatables($params, $filters) {
        $this->db->select('perangkat_ajar.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, tahun_pelajaran.tahun, tahun_pelajaran.semester as tp_semester');
        $this->db->join('kelas', 'kelas.id = perangkat_ajar.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id');
        $this->db->join('guru', 'guru.id = perangkat_ajar.guru_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = perangkat_ajar.tahun_pelajaran_id');

        $this->apply_filters($filters);

        // Global Search
        if (!empty($params['search']['value'])) {
            $search = $params['search']['value'];
            $this->db->group_start();
            $this->db->like('perangkat_ajar.jenis_perangkat', $search);
            $this->db->or_like('mata_pelajaran.nama_mapel', $search);
            $this->db->or_like('kelas.nama_kelas', $search);
            $this->db->or_like('guru.nama_lengkap', $search);
            $this->db->or_like('perangkat_ajar.semester', $search);
            $this->db->group_end();
        }

        // Sorting
        $columns_order = array(
            0 => 'perangkat_ajar.jenis_perangkat',
            1 => 'mata_pelajaran.nama_mapel',
            2 => 'kelas.nama_kelas',
            3 => 'guru.nama_lengkap',
            4 => 'perangkat_ajar.semester',
            5 => 'perangkat_ajar.version',
            6 => 'perangkat_ajar.status_verifikasi'
        );

        if (isset($params['order'][0]['column']) && isset($columns_order[$params['order'][0]['column']])) {
            $order_col = $columns_order[$params['order'][0]['column']];
            $order_dir = $params['order'][0]['dir'];
            $this->db->order_by($order_col, $order_dir);
        } else {
            $this->db->order_by('perangkat_ajar.id', 'DESC');
        }

        // Pagination
        if (isset($params['length']) && $params['length'] != -1) {
            $this->db->limit($params['length'], $params['start'] ?? 0);
        }

        return $this->db->get($this->table)->result_array();
    }

    /**
     * Count records matching filter and search
     */
    public function count_datatables_filtered($params, $filters) {
        $this->db->join('kelas', 'kelas.id = perangkat_ajar.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id');
        $this->db->join('guru', 'guru.id = perangkat_ajar.guru_id');
        $this->db->join('tahun_pelajaran', 'tahun_pelajaran.id = perangkat_ajar.tahun_pelajaran_id');

        $this->apply_filters($filters);

        // Global Search
        if (!empty($params['search']['value'])) {
            $search = $params['search']['value'];
            $this->db->group_start();
            $this->db->like('perangkat_ajar.jenis_perangkat', $search);
            $this->db->or_like('mata_pelajaran.nama_mapel', $search);
            $this->db->or_like('kelas.nama_kelas', $search);
            $this->db->or_like('guru.nama_lengkap', $search);
            $this->db->or_like('perangkat_ajar.semester', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results($this->table);
    }

    /**
     * Get list of revised teaching devices
     */
    public function get_devices_with_revisions($filters = array()) {
        $this->db->select('perangkat_ajar.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru');
        $this->db->join('kelas', 'kelas.id = perangkat_ajar.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = perangkat_ajar.mapel_id');
        $this->db->join('guru', 'guru.id = perangkat_ajar.guru_id');

        if (!empty($filters['guru_id'])) {
            $this->db->where('perangkat_ajar.guru_id', $filters['guru_id']);
        }

        // We only want devices that are revisions (version > 1) or have a parent_id
        $this->db->group_start();
        $this->db->where('perangkat_ajar.version >', 1);
        $this->db->or_where('perangkat_ajar.parent_id IS NOT NULL');
        $this->db->group_end();

        $this->db->where('perangkat_ajar.is_archived', 0);
        $this->db->order_by('perangkat_ajar.created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }
}
