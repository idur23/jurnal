-- ========================================================
-- DATABASE MIGRATION: CR-002 Perkembangan Diri & Jurnal Penanganan
-- Website Jurnal Guru Enterprise
-- ========================================================

CREATE TABLE IF NOT EXISTS `perkembangan_rekap` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `siswa_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `wali_id` INT UNSIGNED NOT NULL,
  `kesimpulan_wali` TEXT NULL,
  `tindak_lanjut` TEXT NULL,
  `status_perkembangan` ENUM('Sangat Baik', 'Baik', 'Cukup', 'Kurang') NOT NULL DEFAULT 'Baik',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`wali_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_perkembangan_rekap` (`tahun_pelajaran_id`, `siswa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
