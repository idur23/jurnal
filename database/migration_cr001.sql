-- ========================================================
-- DATABASE MIGRATION: CR-001 Integrasi RDM & Modul Wali Kelas
-- Website Jurnal Guru Enterprise
-- ========================================================

-- 1. Penamaan Rombel (IPA 1 / IPA 2 menjadi A / B)
UPDATE `kelas` SET `kode_kelas` = REPLACE(`kode_kelas`, 'IPA-1', 'A'), `nama_kelas` = REPLACE(`nama_kelas`, 'IPA 1', 'A') WHERE `kode_kelas` LIKE '%IPA-1%';
UPDATE `kelas` SET `kode_kelas` = REPLACE(`kode_kelas`, 'IPA-2', 'B'), `nama_kelas` = REPLACE(`nama_kelas`, 'IPA 2', 'B') WHERE `kode_kelas` LIKE '%IPA-2%';
UPDATE `ruangan` SET `nama_ruangan` = REPLACE(`nama_ruangan`, 'IPA 1', 'A') WHERE `nama_ruangan` LIKE '%IPA 1%';
UPDATE `ruangan` SET `nama_ruangan` = REPLACE(`nama_ruangan`, 'IPA 2', 'B') WHERE `nama_ruangan` LIKE '%IPA 2%';

-- 2. Modifikasi Tabel Penilaian Siswa (Dynamic Categories & File Uploads)
ALTER TABLE `penilaian_siswa` MODIFY COLUMN `jenis_penilaian` VARCHAR(50) NOT NULL;
ALTER TABLE `penilaian_siswa` ADD COLUMN `file_portofolio` VARCHAR(255) NULL AFTER `catatan`;
ALTER TABLE `penilaian_siswa` ADD COLUMN `rubrik_penilaian` TEXT NULL AFTER `file_portofolio`;
ALTER TABLE `penilaian_siswa` ADD COLUMN `import_code` VARCHAR(50) NULL AFTER `rubrik_penilaian`;

-- 3. Tabel Kategori Penilaian (Dinamis & Bobot)
CREATE TABLE IF NOT EXISTS `kategori_penilaian` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_kategori` VARCHAR(50) NOT NULL UNIQUE,
  `nama_kategori` VARCHAR(100) NOT NULL,
  `bobot` INT NOT NULL DEFAULT 10,
  `tipe` ENUM('sistem', 'custom') NOT NULL DEFAULT 'custom',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seeding Default RDM Categories
INSERT INTO `kategori_penilaian` (`kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`) VALUES
('catatan', 'Catatan', 7, 'sistem', 1),
('tugas', 'Tugas', 15, 'sistem', 1),
('uh', 'Ulangan Harian', 10, 'sistem', 1),
('praktik', 'Proyek', 15, 'sistem', 1),
('sikap', 'Sikap', 5, 'sistem', 1),
('sts', 'STS', 15, 'sistem', 1),
('asas', 'ASAS', 33, 'sistem', 1),
('portofolio', 'Portofolio', 15, 'sistem', 0)
ON DUPLICATE KEY UPDATE 
  `nama_kategori` = VALUES(`nama_kategori`),
  `bobot` = VALUES(`bobot`),
  `is_active` = VALUES(`is_active`);

-- 4. Tabel Riwayat Import Nilai
CREATE TABLE IF NOT EXISTS `import_nilai_history` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `import_code` VARCHAR(50) NOT NULL UNIQUE,
  `file_name` VARCHAR(255) NOT NULL,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `jenis_penilaian` VARCHAR(50) NOT NULL,
  `nama_penilaian` VARCHAR(100) NOT NULL,
  `imported_by` INT UNSIGNED NOT NULL,
  `total_records` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`imported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabel Perkembangan Diri Siswa (3NF)
CREATE TABLE IF NOT EXISTS `perkembangan_siswa` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `siswa_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `guru_id` INT UNSIGNED NOT NULL,
  `catatan_perkembangan` TEXT NULL,
  `kelebihan` TEXT NULL,
  `kekurangan` TEXT NULL,
  `perilaku` TEXT NULL,
  `keaktifan` TEXT NULL,
  `kedisiplinan` TEXT NULL,
  `motivasi` TEXT NULL,
  `rekomendasi` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_perkembangan_siswa` (`tahun_pelajaran_id`, `siswa_id`, `mapel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabel Karya Pembelajaran
CREATE TABLE IF NOT EXISTS `karya_pembelajaran` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `guru_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NULL,
  `tanggal` DATE NOT NULL,
  `materi` VARCHAR(255) NOT NULL,
  `jenis_karya` ENUM('Foto', 'Video', 'PDF', 'PowerPoint', 'Word', 'LKPD', 'Poster', 'Produk', 'Portofolio') NOT NULL,
  `tags` VARCHAR(255) NULL,
  `status_publikasi` ENUM('Draft', 'Publik') NOT NULL DEFAULT 'Draft',
  `file_path` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabel Jurnal Wali Kelas
CREATE TABLE IF NOT EXISTS `jurnal_walikelas` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `wali_id` INT UNSIGNED NOT NULL,
  `tanggal` DATE NOT NULL,
  `program` VARCHAR(255) NOT NULL,
  `target` TEXT NULL,
  `pelaksanaan` TEXT NULL,
  `status` ENUM('Terealisasi', 'Belum') NOT NULL DEFAULT 'Belum',
  `catatan` TEXT NULL,
  `dokumentasi` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`wali_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabel Jurnal Penanganan Siswa
CREATE TABLE IF NOT EXISTS `penanganan_siswa` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `siswa_id` INT UNSIGNED NOT NULL,
  `wali_id` INT UNSIGNED NOT NULL,
  `tanggal` DATE NOT NULL,
  `permasalahan` TEXT NOT NULL,
  `kategori` ENUM('Akademik', 'Disiplin', 'Perilaku', 'Kesehatan', 'Sosial') NOT NULL,
  `tindakan` TEXT NULL,
  `hasil` TEXT NULL,
  `rencana_tindak_lanjut` TEXT NULL,
  `dokumentasi` VARCHAR(255) NULL,
  `status` ENUM('Selesai', 'Proses', 'Monitoring') NOT NULL DEFAULT 'Proses',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`wali_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tabel Modul Kokurikuler
CREATE TABLE IF NOT EXISTS `kokurikuler` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `guru_id` INT UNSIGNED NOT NULL,
  `tema` VARCHAR(255) NOT NULL,
  `sub_tema` VARCHAR(255) NOT NULL,
  `aktivitas` TEXT NOT NULL,
  `tujuan` TEXT NOT NULL,
  `tanggal` DATE NOT NULL,
  `dokumentasi` VARCHAR(255) NULL,
  `catatan` TEXT NULL,
  `status` ENUM('Draft', 'Terlaksana') NOT NULL DEFAULT 'Draft',
  `output` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Tambahan Dokumentasi Jurnal KBM Guru
ALTER TABLE `jurnal_guru` ADD COLUMN `file_dokumentasi` VARCHAR(255) NULL AFTER `hambatan_solusi`;
