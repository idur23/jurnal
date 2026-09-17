-- ========================================================
-- DATABASE MIGRATION: CR-006 Multi-Kelas Mata Pelajaran
-- Website Jurnal Guru Enterprise
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `mapel_kelas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `mapel_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  KEY `fk_mk_mapel` (`mapel_id`),
  KEY `fk_mk_kelas` (`kelas_id`),
  CONSTRAINT `fk_mk_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migrate existing kelas_id assignments into mapel_kelas
INSERT INTO `mapel_kelas` (`mapel_id`, `kelas_id`)
SELECT `id`, `kelas_id` FROM `mata_pelajaran`
WHERE `kelas_id` IS NOT NULL AND `kelas_id` > 0 ON DUPLICATE KEY UPDATE kelas_id=VALUES(kelas_id);

CREATE TABLE IF NOT EXISTS `google_drive_sync` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `local_path` VARCHAR(255) NOT NULL UNIQUE,
  `relative_path` VARCHAR(255) NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_size` BIGINT NOT NULL DEFAULT 0,
  `mime_type` VARCHAR(100) NOT NULL,
  `drive_file_id` VARCHAR(255) NULL,
  `drive_folder_id` VARCHAR(255) NULL,
  `file_hash` VARCHAR(64) NULL,
  `original_file_size` BIGINT NOT NULL DEFAULT 0,
  `compressed_file_size` BIGINT NOT NULL DEFAULT 0,
  `compression_ratio` FLOAT NOT NULL DEFAULT 0,
  `is_compressed` TINYINT(1) NOT NULL DEFAULT 0,
  `compression_quality` INT NOT NULL DEFAULT 100,
  `status` ENUM('SYNCHRONIZED', 'PENDING', 'FAILED', 'LOCAL_MISSING') NOT NULL DEFAULT 'PENDING',
  `last_synced_at` DATETIME NULL,
  `error_message` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_gds_status` (`status`),
  INDEX `idx_gds_relpath` (`relative_path`),
  INDEX `idx_gds_compressed` (`is_compressed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


SET FOREIGN_KEY_CHECKS = 1;

