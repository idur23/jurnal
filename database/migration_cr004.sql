-- ========================================================
-- DATABASE MIGRATION: CR-004 Modul Perangkat Ajar & Integrasi Jurnal
-- Website Jurnal Guru Enterprise
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Insert/Update Waka Kurikulum and Super Admin roles if they do not exist
INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`) VALUES
(5, 'waka', 'Waka Kurikulum', 'Monitoring, evaluasi, dan verifikasi perangkat ajar serta KBM'),
(6, 'superadmin', 'Super Admin', 'Akses penuh ke seluruh sistem dan konfigurasi internal')
ON DUPLICATE KEY UPDATE `role_name` = VALUES(`role_name`), `description` = VALUES(`description`);

-- 2. Create Perangkat Ajar table
CREATE TABLE IF NOT EXISTS `perangkat_ajar` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `semester` ENUM('Ganjil', 'Genap') NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `guru_id` INT UNSIGNED NOT NULL,
  `jenis_perangkat` VARCHAR(50) NOT NULL, -- Modul Ajar, ATP, Prota, Promes, Silabus, RPP, Bahan Ajar, LKPD, Media Pembelajaran, Bank Soal, Kisi-kisi, Rubrik Penilaian
  `fase` VARCHAR(10) NULL,
  `elemen` VARCHAR(255) NULL,
  `capaian_pembelajaran` TEXT NULL,
  `tujuan_pembelajaran` TEXT NULL,
  `materi_pembelajaran` TEXT NULL,
  `sub_materi` TEXT NULL,
  `metode_pembelajaran` TEXT NULL,
  `model_pembelajaran` TEXT NULL,
  `media_pembelajaran` TEXT NULL,
  `sumber_belajar` TEXT NULL,
  `bentuk_penilaian` TEXT NULL,
  `alokasi_waktu` VARCHAR(50) NULL,
  `pertemuan_ke` INT UNSIGNED NOT NULL,
  `file_path` VARCHAR(255) NULL,
  `status_verifikasi` ENUM('Draft', 'Menunggu Verifikasi', 'Disetujui', 'Revisi', 'Ditolak') NOT NULL DEFAULT 'Draft',
  `catatan_revisi` TEXT NULL,
  `version` INT UNSIGNED NOT NULL DEFAULT 1,
  `parent_id` INT UNSIGNED NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `is_archived` TINYINT(1) NOT NULL DEFAULT 0,
  `created_by` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  `verified_by` INT UNSIGNED NULL,
  `verified_at` DATETIME NULL,
  CONSTRAINT `fk_perangkat_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_verifier` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  INDEX `idx_perangkat_lookup` (`tahun_pelajaran_id`, `semester`, `mapel_id`, `guru_id`, `kelas_id`, `pertemuan_ke`),
  INDEX `idx_perangkat_status` (`status_verifikasi`),
  INDEX `idx_perangkat_active` (`is_active`, `is_archived`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Modify Jurnal Guru to hold Perangkat Ajar Snapshot
ALTER TABLE `jurnal_guru`
  ADD COLUMN `perangkat_ajar_id` INT UNSIGNED NULL AFTER `id`,
  ADD COLUMN `pertemuan_ke` INT UNSIGNED NULL AFTER `jam_ke`,
  ADD COLUMN `capaian_pembelajaran` TEXT NULL AFTER `materi_pembelajaran`,
  ADD COLUMN `tujuan_pembelajaran` TEXT NULL AFTER `capaian_pembelajaran`,
  ADD COLUMN `sub_materi` TEXT NULL AFTER `tujuan_pembelajaran`,
  ADD COLUMN `metode_pembelajaran` TEXT NULL AFTER `sub_materi`,
  ADD COLUMN `model_pembelajaran` TEXT NULL AFTER `metode_pembelajaran`,
  ADD COLUMN `media_pembelajaran` TEXT NULL AFTER `model_pembelajaran`,
  ADD COLUMN `sumber_belajar` TEXT NULL AFTER `media_pembelajaran`,
  ADD COLUMN `bentuk_penilaian` TEXT NULL AFTER `sumber_belajar`,
  ADD COLUMN `alokasi_waktu` VARCHAR(50) NULL AFTER `bentuk_penilaian`,
  ADD COLUMN `refleksi_pembelajaran` TEXT NULL AFTER `catatan_pembelajaran`,
  ADD COLUMN `kendala` TEXT NULL AFTER `refleksi_pembelajaran`,
  ADD COLUMN `solusi` TEXT NULL AFTER `kendala`,
  ADD COLUMN `file_video` VARCHAR(255) NULL AFTER `file_dokumentasi`,
  ADD CONSTRAINT `fk_jurnal_perangkat` FOREIGN KEY (`perangkat_ajar_id`) REFERENCES `perangkat_ajar` (`id`) ON DELETE SET NULL;

SET FOREIGN_KEY_CHECKS = 1;
