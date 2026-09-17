-- ========================================================
-- MIGRATION SQL UPDATE — MODUL MBF & ROLE TENTOR
-- Enterprise Jurnal Guru
-- Generated: 2026-09-09 13:26:34
-- ========================================================

-- 1. TAMBAH ROLE TENTOR (JIKA BELUM ADA)
INSERT INTO `roles` (`role_code`, `role_name`, `description`, `created_at`)
SELECT 'tentor', 'Tentor MBF', 'Role khusus Pengajar/Tentor Modul MBF', NOW()
WHERE NOT EXISTS (SELECT 1 FROM `roles` WHERE `role_code` = 'tentor');

-- Table: `tentor`
CREATE TABLE IF NOT EXISTS `tentor` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `guru_id` int unsigned DEFAULT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `idx_tentor_active` (`is_active`),
  KEY `fk_tentor_guru` (`guru_id`),
  CONSTRAINT `fk_tentor_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_tentor_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: `mapel_mbf`
CREATE TABLE IF NOT EXISTS `mapel_mbf` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_mapel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_mapel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tentor_id` int unsigned NOT NULL,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ganjil',
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_mapel_mbf_tentor` (`tentor_id`),
  KEY `idx_mapel_mbf_tp` (`tahun_pelajaran_id`),
  KEY `idx_mapel_mbf_status` (`status`),
  CONSTRAINT `fk_mapel_mbf_tentor` FOREIGN KEY (`tentor_id`) REFERENCES `tentor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mapel_mbf_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: `peserta_mapel_mbf`
CREATE TABLE IF NOT EXISTS `peserta_mapel_mbf` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mapel_mbf_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_mapel_siswa` (`mapel_mbf_id`,`siswa_id`),
  KEY `idx_peserta_mapel` (`mapel_mbf_id`),
  KEY `idx_peserta_siswa` (`siswa_id`),
  CONSTRAINT `fk_peserta_mapel_mbf` FOREIGN KEY (`mapel_mbf_id`) REFERENCES `mapel_mbf` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_peserta_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: `presensi_mbf`
CREATE TABLE IF NOT EXISTS `presensi_mbf` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mapel_mbf_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `pertemuan_ke` int unsigned DEFAULT '1',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_by` int unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status_sesi` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'Selesai',
  `nama_mapel_custom` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruangan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `materi_pembahasan` text COLLATE utf8mb4_unicode_ci,
  `catatan_tentor` text COLLATE utf8mb4_unicode_ci,
  `foto_dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_mapel_tanggal` (`mapel_mbf_id`,`tanggal`),
  KEY `fk_presensi_mbf_user` (`created_by`),
  KEY `idx_presensi_mbf_tanggal` (`tanggal`),
  KEY `idx_presensi_mbf_mapel` (`mapel_mbf_id`),
  CONSTRAINT `fk_presensi_mbf_mapel` FOREIGN KEY (`mapel_mbf_id`) REFERENCES `mapel_mbf` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_presensi_mbf_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: `presensi_mbf_detail`
CREATE TABLE IF NOT EXISTS `presensi_mbf_detail` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `presensi_mbf_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alpa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hadir',
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_presensi_siswa_mbf` (`presensi_mbf_id`,`siswa_id`),
  KEY `idx_detail_status_mbf` (`status`),
  KEY `idx_detail_siswa_mbf` (`siswa_id`),
  CONSTRAINT `fk_detail_presensi_mbf` FOREIGN KEY (`presensi_mbf_id`) REFERENCES `presensi_mbf` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_detail_siswa_mbf` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. PENAMBAHAN KOLOM JURNAL MBF KE TABEL presensi_mbf (JIKA TABEL SUDAH ADA SEBELUMNYA)
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `pertemuan_ke` int unsigned DEFAULT '1';
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `status_sesi` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'Selesai';
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `nama_mapel_custom` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL;
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `ruangan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL;
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `jam_mulai` time DEFAULT NULL;
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `jam_selesai` time DEFAULT NULL;
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `materi_pembahasan` text COLLATE utf8mb4_unicode_ci;
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `catatan_tentor` text COLLATE utf8mb4_unicode_ci;
ALTER TABLE `presensi_mbf` ADD COLUMN IF NOT EXISTS `foto_dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL;


