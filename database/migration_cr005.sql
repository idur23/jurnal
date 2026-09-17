-- ========================================================
-- DATABASE MIGRATION: CR-005 System Performance & Indexes
-- Website Jurnal Guru Enterprise
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Create System Performance logs table
CREATE TABLE IF NOT EXISTS `sys_performance_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `url` VARCHAR(255) NOT NULL,
  `execution_time` DECIMAL(8,4) NOT NULL, -- in seconds
  `memory_usage` DECIMAL(8,2) NOT NULL, -- in MB
  `query_count` INT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_perf_created` (`created_at`),
  INDEX `idx_perf_time` (`execution_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Create Slow Query logs table
CREATE TABLE IF NOT EXISTS `sys_slow_queries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `query_text` TEXT NOT NULL,
  `execution_time` DECIMAL(8,4) NOT NULL, -- in seconds
  `url` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_slow_created` (`created_at`),
  INDEX `idx_slow_time` (`execution_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Database Indexes Optimization
ALTER TABLE `jurnal_guru` ADD INDEX `idx_jurnal_guru_tp` (`guru_id`, `tahun_pelajaran_id`);
ALTER TABLE `presensi_siswa` ADD INDEX `idx_presensi_lookup` (`presensi_kelas_id`, `status`);
ALTER TABLE `penilaian_siswa` ADD INDEX `idx_penilaian_lookup` (`kelas_id`, `mapel_id`, `jenis_penilaian`);
ALTER TABLE `penilaian_siswa` ADD INDEX `idx_penilaian_siswa` (`siswa_id`, `jenis_penilaian`);
ALTER TABLE `activity_logs` ADD INDEX `idx_logs_lookup` (`user_id`, `created_at`);

SET FOREIGN_KEY_CHECKS = 1;
