-- ========================================================
-- DATABASE MIGRATION: CR-007 Poin Keaktifan Siswa
-- Website Jurnal Guru Enterprise
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `jurnal_poin_keaktifan` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `jurnal_id` INT UNSIGNED NOT NULL,
  `siswa_id` INT UNSIGNED NOT NULL,
  `guru_id` INT UNSIGNED NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `tanggal` DATE NOT NULL,
  `poin` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_jpk_jurnal` FOREIGN KEY (`jurnal_id`) REFERENCES `jurnal_guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jpk_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jpk_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jpk_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jpk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_jurnal_siswa` (`jurnal_id`, `siswa_id`),
  INDEX `idx_jpk_tanggal` (`tanggal`),
  INDEX `idx_jpk_siswa_tgl` (`siswa_id`, `tanggal`),
  INDEX `idx_jpk_kelas_tgl` (`kelas_id`, `tanggal`),
  INDEX `idx_jpk_guru_tgl` (`guru_id`, `tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
