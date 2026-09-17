-- =================================================================
-- SCRIPT UPDATE DATABASE LENGKAP (GOOGLE DRIVE SYNC & PERANGKAT AJAR)
-- Jurnal Guru MA Darul Faqih Indonesia
-- =================================================================

-- 1. Buat Tabel `google_drive_sync` (Jika belum ada)
CREATE TABLE IF NOT EXISTS `google_drive_sync` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `local_path` VARCHAR(255) NOT NULL,
  `drive_file_id` VARCHAR(255) NULL,
  `file_type` VARCHAR(50) DEFAULT 'media',
  `status` ENUM('PENDING', 'SYNCHRONIZED', 'FAILED', 'LOCAL_MISSING') DEFAULT 'PENDING',
  `error_message` TEXT NULL,
  `last_synced_at` DATETIME NULL,
  `original_file_size` BIGINT NOT NULL DEFAULT 0,
  `compressed_file_size` BIGINT NOT NULL DEFAULT 0,
  `compression_ratio` FLOAT NOT NULL DEFAULT 0,
  `is_compressed` TINYINT(1) NOT NULL DEFAULT 0,
  `compression_quality` INT NOT NULL DEFAULT 100,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_local_path` (`local_path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Buat Tabel Baru `rencana_pelaksanaan`
CREATE TABLE IF NOT EXISTS `rencana_pelaksanaan` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tambah Kolom `kelas_ids` pada Tabel `perangkat_ajar` (Jika belum ada)
SET @dbname = DATABASE();
SET @tablename = "perangkat_ajar";

SET @columnname = "kelas_ids";
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  "SELECT 1",
  "ALTER TABLE `perangkat_ajar` ADD COLUMN `kelas_ids` TEXT NULL AFTER `kelas_id`;"
));
PREPARE addColumn FROM @preparedStatement;
EXECUTE addColumn;
DEALLOCATE PREPARE addColumn;

-- 4. Tambah Kolom `rencana_ids` pada Tabel `perangkat_ajar` (Jika belum ada)
SET @columnname = "rencana_ids";
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  "SELECT 1",
  "ALTER TABLE `perangkat_ajar` ADD COLUMN `rencana_ids` TEXT NULL AFTER `kelas_ids`;"
));
PREPARE addColumn FROM @preparedStatement;
EXECUTE addColumn;
DEALLOCATE PREPARE addColumn;

-- Selesai
