-- ========================================================
-- MIGRATION CR008: Modul MBF & Role Tentor
-- Engine: MySQL (InnoDB, utf8mb4_unicode_ci)
-- PHP / Framework: PHP 8.x / CodeIgniter 3 MVC
-- ========================================================

-- 1. Insert Role 'tentor' if not exists
INSERT INTO `roles` (`role_code`, `role_name`, `description`)
SELECT 'tentor', 'Tentor MBF', 'Akses khusus kegiatan MBF (Mapel MBF, Peserta Mapel MBF, Presensi MBF)'
WHERE NOT EXISTS (SELECT 1 FROM `roles` WHERE `role_code` = 'tentor');

-- 2. Table Tentor
CREATE TABLE IF NOT EXISTS `tentor` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NULL UNIQUE,
  `guru_id` INT UNSIGNED NULL,
  `nip` VARCHAR(30) NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `no_hp` VARCHAR(20) NULL,
  `email` VARCHAR(100) NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_tentor_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_tentor_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX `idx_tentor_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Table Mapel MBF
CREATE TABLE IF NOT EXISTS `mapel_mbf` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_mapel` VARCHAR(30) NOT NULL,
  `nama_mapel` VARCHAR(100) NOT NULL,
  `tentor_id` INT UNSIGNED NOT NULL,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `semester` ENUM('Ganjil', 'Genap') NOT NULL DEFAULT 'Ganjil',
  `status` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_mapel_mbf_tentor` FOREIGN KEY (`tentor_id`) REFERENCES `tentor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mapel_mbf_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX `idx_mapel_mbf_tentor` (`tentor_id`),
  INDEX `idx_mapel_mbf_tp` (`tahun_pelajaran_id`),
  INDEX `idx_mapel_mbf_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Table Peserta Mapel MBF
CREATE TABLE IF NOT EXISTS `peserta_mapel_mbf` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `mapel_mbf_id` INT UNSIGNED NOT NULL,
  `siswa_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_mapel_siswa` (`mapel_mbf_id`, `siswa_id`),
  CONSTRAINT `fk_peserta_mapel_mbf` FOREIGN KEY (`mapel_mbf_id`) REFERENCES `mapel_mbf` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_peserta_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX `idx_peserta_mapel` (`mapel_mbf_id`),
  INDEX `idx_peserta_siswa` (`siswa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Table Presensi MBF Header
CREATE TABLE IF NOT EXISTS `presensi_mbf` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `mapel_mbf_id` INT UNSIGNED NOT NULL,
  `tanggal` DATE NOT NULL,
  `pertemuan_ke` INT UNSIGNED DEFAULT 1,
  `catatan` TEXT NULL,
  `created_by` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_mapel_tanggal` (`mapel_mbf_id`, `tanggal`),
  CONSTRAINT `fk_presensi_mbf_mapel` FOREIGN KEY (`mapel_mbf_id`) REFERENCES `mapel_mbf` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_presensi_mbf_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX `idx_presensi_mbf_tanggal` (`tanggal`),
  INDEX `idx_presensi_mbf_mapel` (`mapel_mbf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Table Presensi MBF Detail
CREATE TABLE IF NOT EXISTS `presensi_mbf_detail` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `presensi_mbf_id` INT UNSIGNED NOT NULL,
  `siswa_id` INT UNSIGNED NOT NULL,
  `status` ENUM('Hadir', 'Izin', 'Sakit', 'Alpa') NOT NULL DEFAULT 'Hadir',
  `catatan` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_presensi_siswa_mbf` (`presensi_mbf_id`, `siswa_id`),
  CONSTRAINT `fk_detail_presensi_mbf` FOREIGN KEY (`presensi_mbf_id`) REFERENCES `presensi_mbf` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_detail_siswa_mbf` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX `idx_detail_status_mbf` (`status`),
  INDEX `idx_detail_siswa_mbf` (`siswa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
