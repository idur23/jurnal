-- ========================================================
-- MIGRATION CR-003: SEPARATION OF CLASS AND STUDENT ATTENDANCE
-- ========================================================

-- 1. Create Role and User for Kepala Madrasah (kamad)
INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`) 
VALUES (4, 'kamad', 'Kepala Madrasah', 'Monitoring KBM, Kehadiran Kelas, dan Laporan Kepala Madrasah')
ON DUPLICATE KEY UPDATE `role_name` = VALUES(`role_name`);

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `is_active`)
VALUES (4, 'kamad', 'kamad@jurnalguru.sch.id', '$2y$10$4.z4zC.bYQ.u5l9GZ1oTje/zZ3W7dGgN34Uu1xYpWbQ8vR1v8E0qO', 'Dr. H. Ahmad Fauzi, M.Ag.', 4, 1)
ON DUPLICATE KEY UPDATE `full_name` = VALUES(`full_name`);

-- 2. Create presensi_kelas Table
CREATE TABLE IF NOT EXISTS `presensi_kelas` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `jurnal_id` INT UNSIGNED NOT NULL UNIQUE,
  `tanggal` DATE NOT NULL,
  `jam_mulai` TIME NOT NULL,
  `jam_selesai` TIME NOT NULL,
  `guru_id` INT UNSIGNED NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `ruangan_id` INT UNSIGNED NULL,
  `pertemuan_ke` INT UNSIGNED NOT NULL DEFAULT 1,
  `status_pembelajaran` ENUM('Terlaksana', 'Tidak Terlaksana', 'Diganti', 'Daring', 'Luring', 'Gabungan Kelas') NOT NULL DEFAULT 'Terlaksana',
  `alasan_tidak_terlaksana` TEXT NULL,
  `dokumentasi` VARCHAR(255) NULL,
  `catatan_guru` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_presensi_kelas_jurnal` FOREIGN KEY (`jurnal_id`) REFERENCES `jurnal_guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_kelas_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_kelas_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_kelas_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_kelas_ruangan` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE SET NULL,
  INDEX `idx_presensi_kelas_tanggal` (`tanggal`),
  INDEX `idx_presensi_kelas_kelas_mapel` (`kelas_id`, `mapel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Modify presensi_siswa Table to prepare for migration
-- Add presensi_kelas_id and bukti_izin columns if they do not exist
SET @dbname = DATABASE();
SET @tablename = 'presensi_siswa';
SET @columnname = 'presensi_kelas_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
   WHERE TABLE_SCHEMA = @dbname 
     AND TABLE_NAME = @tablename 
     AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `presensi_siswa` ADD COLUMN `presensi_kelas_id` INT UNSIGNED NULL AFTER `jurnal_id`'
));
PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @columnname2 = 'bukti_izin';
SET @preparedStatement2 = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
   WHERE TABLE_SCHEMA = @dbname 
     AND TABLE_NAME = @tablename 
     AND COLUMN_NAME = @columnname2) > 0,
  'SELECT 1',
  'ALTER TABLE `presensi_siswa` ADD COLUMN `bukti_izin` VARCHAR(255) NULL AFTER `catatan`'
));
PREPARE stmt2 FROM @preparedStatement2;
EXECUTE stmt2;
DEALLOCATE PREPARE stmt2;

-- Modify ENUM status in presensi_siswa to support 'Terlambat'
ALTER TABLE `presensi_siswa` MODIFY COLUMN `status` ENUM('Hadir', 'Izin', 'Sakit', 'Alpa', 'Terlambat', 'Dispen') NOT NULL DEFAULT 'Hadir';

-- 4. Perform Data Conversion (INSERT presensi_kelas for each existing jurnal_guru)
INSERT IGNORE INTO `presensi_kelas` (`jurnal_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `guru_id`, `mapel_id`, `kelas_id`, `pertemuan_ke`, `status_pembelajaran`, `catatan_guru`)
SELECT 
  jg.id AS jurnal_id, 
  jg.tanggal AS tanggal,
  -- Parse or fallback start time based on jam_ke string (e.g. "1-2" -> Jam 1)
  COALESCE((SELECT jam_mulai FROM jam_pelajaran jp WHERE jp.jam_ke = CAST(SUBSTRING_INDEX(jg.jam_ke, '-', 1) AS UNSIGNED) LIMIT 1), '07:00:00') AS jam_mulai,
  -- Parse or fallback end time based on jam_ke string (e.g. "1-2" -> Jam 2)
  COALESCE((SELECT jam_selesai FROM jam_pelajaran jp WHERE jp.jam_ke = CAST(SUBSTRING_INDEX(jg.jam_ke, '-', -1) AS UNSIGNED) LIMIT 1), '08:30:00') AS jam_selesai,
  jg.guru_id,
  jg.mapel_id,
  jg.kelas_id,
  1 AS pertemuan_ke,
  'Terlaksana' AS status_pembelajaran,
  jg.catatan_pembelajaran AS catatan_guru
FROM `jurnal_guru` jg;

-- Map presensi_siswa rows to new presensi_kelas table
UPDATE `presensi_siswa` ps
JOIN `presensi_kelas` pk ON pk.jurnal_id = ps.jurnal_id
SET ps.presensi_kelas_id = pk.id
WHERE ps.presensi_kelas_id IS NULL;

-- 5. Drop old foreign keys and keys
-- Check and drop FK constraint fk_presensi_jurnal if it exists (for safety)
SET @fk_count = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                 WHERE TABLE_SCHEMA = @dbname 
                   AND TABLE_NAME = @tablename 
                   AND CONSTRAINT_NAME = 'fk_presensi_jurnal');
SET @drop_fk = IF(@fk_count > 0, 'ALTER TABLE `presensi_siswa` DROP FOREIGN KEY `fk_presensi_jurnal`', 'SELECT 1');
PREPARE stmt_fk FROM @drop_fk;
EXECUTE stmt_fk;
DEALLOCATE PREPARE stmt_fk;

-- Check and drop unique key uk_jurnal_siswa if it exists
SET @uk_count = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS 
                 WHERE TABLE_SCHEMA = @dbname 
                   AND TABLE_NAME = @tablename 
                   AND INDEX_NAME = 'uk_jurnal_siswa');
SET @drop_uk = IF(@uk_count > 0, 'ALTER TABLE `presensi_siswa` DROP KEY `uk_jurnal_siswa`', 'SELECT 1');
PREPARE stmt_uk FROM @drop_uk;
EXECUTE stmt_uk;
DEALLOCATE PREPARE stmt_uk;

-- Now drop old jurnal_id and modify presensi_kelas_id to NOT NULL
SET @col_jurnal_count = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
                         WHERE TABLE_SCHEMA = @dbname 
                           AND TABLE_NAME = @tablename 
                           AND COLUMN_NAME = 'jurnal_id');
SET @alter_columns = IF(@col_jurnal_count > 0, 
                        'ALTER TABLE `presensi_siswa` MODIFY COLUMN `presensi_kelas_id` INT UNSIGNED NOT NULL, DROP COLUMN `jurnal_id`', 
                        'ALTER TABLE `presensi_siswa` MODIFY COLUMN `presensi_kelas_id` INT UNSIGNED NOT NULL');
PREPARE stmt_cols FROM @alter_columns;
EXECUTE stmt_cols;
DEALLOCATE PREPARE stmt_cols;

-- Check and add new unique key uk_presensi_kelas_siswa if not exists
SET @uk_new_count = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS 
                     WHERE TABLE_SCHEMA = @dbname 
                       AND TABLE_NAME = @tablename 
                       AND INDEX_NAME = 'uk_presensi_kelas_siswa');
SET @add_uk_new = IF(@uk_new_count = 0, 
                     'ALTER TABLE `presensi_siswa` ADD UNIQUE KEY `uk_presensi_kelas_siswa` (`presensi_kelas_id`, `siswa_id`)', 
                     'SELECT 1');
PREPARE stmt_uk_new FROM @add_uk_new;
EXECUTE stmt_uk_new;
DEALLOCATE PREPARE stmt_uk_new;

-- Check and add new foreign key constraints
SET @fk_new_count = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                     WHERE TABLE_SCHEMA = @dbname 
                       AND TABLE_NAME = @tablename 
                       AND CONSTRAINT_NAME = 'fk_presensi_siswa_kelas');
SET @add_fk_new = IF(@fk_new_count = 0, 
                     'ALTER TABLE `presensi_siswa` ADD CONSTRAINT `fk_presensi_siswa_kelas` FOREIGN KEY (`presensi_kelas_id`) REFERENCES `presensi_kelas` (`id`) ON DELETE CASCADE', 
                     'SELECT 1');
PREPARE stmt_fk_new FROM @add_fk_new;
EXECUTE stmt_fk_new;
DEALLOCATE PREPARE stmt_fk_new;
