-- ========================================================
-- DATABASE SCHEMA: Website Jurnal Guru Enterprise
-- Engine: MySQL (InnoDB, utf8mb4_unicode_ci)
-- PHP / Framework: PHP 8.x / CodeIgniter 3 MVC
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `login_attempts`;
DROP TABLE IF EXISTS `activity_logs`;
DROP TABLE IF EXISTS `system_settings`;
DROP TABLE IF EXISTS `penilaian_siswa`;
DROP TABLE IF EXISTS `presensi_siswa`;
DROP TABLE IF EXISTS `jurnal_guru`;
DROP TABLE IF EXISTS `jadwal_pelajaran`;
DROP TABLE IF EXISTS `siswa`;
DROP TABLE IF EXISTS `guru`;
DROP TABLE IF EXISTS `jam_pelajaran`;
DROP TABLE IF EXISTS `mata_pelajaran`;
DROP TABLE IF EXISTS `ruangan`;
DROP TABLE IF EXISTS `kelas`;
DROP TABLE IF EXISTS `tahun_pelajaran`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`;

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- 1. Table Roles
-- --------------------------------------------------------
CREATE TABLE `roles` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `role_code` VARCHAR(30) NOT NULL UNIQUE,
  `role_name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`) VALUES
(1, 'admin', 'Administrator', 'Full access ke seluruh sistem, master data, dan log'),
(2, 'guru', 'Guru Mata Pelajaran', 'Akses ke Jurnal Pembelajaran, Presensi, dan Penilaian'),
(3, 'walikelas', 'Wali Kelas', 'Akses ke Monitoring Kelas, Rekapitulasi Presensi, dan Laporan');

-- --------------------------------------------------------
-- 2. Table Users
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `role_id` INT UNSIGNED NOT NULL,
  `avatar` VARCHAR(255) DEFAULT 'default.png',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password Default: Admin@12345 (Argon2id/Bcrypt)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `is_active`) VALUES
(1, 'admin', 'admin@jurnalguru.sch.id', '$2y$10$4.z4zC.bYQ.u5l9GZ1oTje/zZ3W7dGgN34Uu1xYpWbQ8vR1v8E0qO', 'Administrator Utama', 1, 1),
(2, 'guru1', 'guru.math@jurnalguru.sch.id', '$2y$10$4.z4zC.bYQ.u5l9GZ1oTje/zZ3W7dGgN34Uu1xYpWbQ8vR1v8E0qO', 'Budi Santoso, S.Pd.', 2, 1),
(3, 'wali1', 'wali.x1@jurnalguru.sch.id', '$2y$10$4.z4zC.bYQ.u5l9GZ1oTje/zZ3W7dGgN34Uu1xYpWbQ8vR1v8E0qO', 'Siti Rahma, M.Pd.', 3, 1);

-- --------------------------------------------------------
-- 3. Table Tahun Pelajaran
-- --------------------------------------------------------
CREATE TABLE `tahun_pelajaran` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun` VARCHAR(20) NOT NULL, -- Contoh: 2025/2026
  `semester` ENUM('Ganjil', 'Genap') NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_tp_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tahun_pelajaran` (`id`, `tahun`, `semester`, `is_active`) VALUES
(1, '2025/2026', 'Ganjil', 1),
(2, '2025/2026', 'Genap', 0);

-- --------------------------------------------------------
-- 4. Table Guru
-- --------------------------------------------------------
CREATE TABLE `guru` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NULL UNIQUE,
  `nip` VARCHAR(30) NOT NULL UNIQUE,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `gelar_depan` VARCHAR(20) NULL,
  `gelar_belakang` VARCHAR(20) NULL,
  `jk` ENUM('L', 'P') NOT NULL,
  `no_hp` VARCHAR(20) NULL,
  `email` VARCHAR(100) NULL,
  `status_kepegawaian` VARCHAR(50) DEFAULT 'PNS',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_guru_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`) VALUES
(1, 2, '198501012010011001', 'Budi Santoso', 'Drs.', 'M.Pd.', 'L', '081234567890', 'guru.math@jurnalguru.sch.id'),
(2, 3, '198802022012022002', 'Siti Rahma', 'S.Pd.', 'M.Si.', 'P', '081298765432', 'wali.x1@jurnalguru.sch.id');

-- --------------------------------------------------------
-- 5. Table Kelas
-- --------------------------------------------------------
CREATE TABLE `kelas` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_kelas` VARCHAR(20) NOT NULL UNIQUE,
  `nama_kelas` VARCHAR(50) NOT NULL,
  `tingkat` ENUM('10', '11', '12') NOT NULL,
  `wali_kelas_id` INT UNSIGNED NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_kelas_walikelas` FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `tingkat`, `wali_kelas_id`) VALUES
(1, 'X-IPA-1', 'X IPA 1', '10', 2),
(2, 'X-IPA-2', 'X IPA 2', '10', 1);

-- --------------------------------------------------------
-- 6. Table Ruangan
-- --------------------------------------------------------
CREATE TABLE `ruangan` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_ruangan` VARCHAR(20) NOT NULL UNIQUE,
  `nama_ruangan` VARCHAR(50) NOT NULL,
  `kapasitas` INT UNSIGNED DEFAULT 36,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ruangan` (`id`, `kode_ruangan`, `nama_ruangan`, `kapasitas`) VALUES
(1, 'R-101', 'Ruang Kelas X IPA 1', 36),
(2, 'R-LAB-KOMP', 'Laboratorium Komputer 1', 40);

-- --------------------------------------------------------
-- 7. Table Mata Pelajaran
-- --------------------------------------------------------
CREATE TABLE `mata_pelajaran` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_mapel` VARCHAR(20) NOT NULL UNIQUE,
  `nama_mapel` VARCHAR(100) NOT NULL,
  `kelompok` ENUM('Wajib', 'Peminatan', 'Muatan Lokal') NOT NULL DEFAULT 'Wajib',
  `kkm` DECIMAL(5,2) DEFAULT 75.00,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`) VALUES
(1, 'MAT-W', 'Matematika Wajib', 'Wajib', 75.00),
(2, 'FIS-P', 'Fisika Peminatan', 'Peminatan', 75.00),
(3, 'BIN-W', 'Bahasa Indonesia', 'Wajib', 78.00);

-- --------------------------------------------------------
-- 8. Table Jam Pelajaran
-- --------------------------------------------------------
CREATE TABLE `jam_pelajaran` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `jam_ke` TINYINT UNSIGNED NOT NULL UNIQUE,
  `jam_mulai` TIME NOT NULL,
  `jam_selesai` TIME NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`) VALUES
(1, 1, '07:00:00', '07:45:00'),
(2, 2, '07:45:00', '08:30:00'),
(3, 3, '08:30:00', '09:15:00'),
(4, 4, '09:30:00', '10:15:00');

-- --------------------------------------------------------
-- 9. Table Siswa
-- --------------------------------------------------------
CREATE TABLE `siswa` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nis` VARCHAR(30) NOT NULL UNIQUE,
  `nisn` VARCHAR(30) NOT NULL UNIQUE,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `jk` ENUM('L', 'P') NOT NULL,
  `tempat_lahir` VARCHAR(50) NULL,
  `tanggal_lahir` DATE NULL,
  `alamat` TEXT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `status_aktif` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_siswa_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX `idx_siswa_kelas` (`kelas_id`),
  INDEX `idx_siswa_status` (`status_aktif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `kelas_id`, `status_aktif`) VALUES
(1, '202510001', '0081234501', 'Ahmad Rizky Pratama', 'L', 1, 1),
(2, '202510002', '0081234502', 'Anisa Fitriani', 'P', 1, 1),
(3, '202510003', '0081234503', 'Bayu Putra Nugraha', 'L', 1, 1),
(4, '202510004', '0081234504', 'Dewi Lestari', 'P', 1, 1);

-- --------------------------------------------------------
-- 10. Table Jadwal Pelajaran
-- --------------------------------------------------------
CREATE TABLE `jadwal_pelajaran` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `guru_id` INT UNSIGNED NOT NULL,
  `ruangan_id` INT UNSIGNED NULL,
  `hari` ENUM('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu') NOT NULL,
  `jam_mulai_ke` TINYINT UNSIGNED NOT NULL,
  `jam_selesai_ke` TINYINT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_jadwal_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jadwal_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jadwal_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jadwal_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jadwal_ruangan` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`) VALUES
(1, 1, 1, 1, 1, 1, 'Senin', 1, 2),
(2, 1, 1, 2, 2, 2, 'Senin', 3, 4);

-- --------------------------------------------------------
-- 11. Table Jurnal Guru
-- --------------------------------------------------------
CREATE TABLE `jurnal_guru` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_jurnal` VARCHAR(30) NOT NULL UNIQUE,
  `tanggal` DATE NOT NULL,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `guru_id` INT UNSIGNED NOT NULL,
  `jam_ke` VARCHAR(20) NOT NULL, -- Misal: "1-2"
  `materi_pembelajaran` TEXT NOT NULL,
  `indikator_tp` TEXT NULL,
  `catatan_pembelajaran` TEXT NULL,
  `hambatan_solusi` TEXT NULL,
  `status` ENUM('Draft', 'Submitted', 'Validated') NOT NULL DEFAULT 'Submitted',
  `created_by` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_jurnal_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jurnal_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jurnal_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jurnal_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jurnal_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  INDEX `idx_jurnal_tanggal` (`tanggal`),
  INDEX `idx_jurnal_kelas_mapel` (`kelas_id`, `mapel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 12. Table Presensi Siswa
-- --------------------------------------------------------
CREATE TABLE `presensi_siswa` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `jurnal_id` INT UNSIGNED NOT NULL,
  `siswa_id` INT UNSIGNED NOT NULL,
  `tanggal` DATE NOT NULL,
  `status` ENUM('Hadir', 'Izin', 'Sakit', 'Alpa', 'Dispen') NOT NULL DEFAULT 'Hadir',
  `catatan` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_presensi_jurnal` FOREIGN KEY (`jurnal_id`) REFERENCES `jurnal_guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_jurnal_siswa` (`jurnal_id`, `siswa_id`),
  INDEX `idx_presensi_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 13. Table Penilaian Siswa
-- --------------------------------------------------------
CREATE TABLE `penilaian_siswa` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `siswa_id` INT UNSIGNED NOT NULL,
  `guru_id` INT UNSIGNED NOT NULL,
  `jenis_penilaian` ENUM('Formatif', 'Sumatif_PTS', 'Sumatif_PAS', 'Sikap') NOT NULL,
  `nama_penilaian` VARCHAR(100) NOT NULL, -- Misal: "UH 1 Matriks", "PTS Semester Ganjil"
  `nilai` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `catatan` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_nilai_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nilai_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nilai_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nilai_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nilai_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 14. Table Activity Logs (Audit Trail)
-- --------------------------------------------------------
CREATE TABLE `activity_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NULL,
  `action` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `user_agent` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  INDEX `idx_log_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 15. Table System Settings
-- --------------------------------------------------------
CREATE TABLE `system_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(50) NOT NULL UNIQUE,
  `setting_value` TEXT NOT NULL,
  `setting_group` VARCHAR(50) NOT NULL DEFAULT 'general',
  `description` VARCHAR(255) NULL,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `system_settings` (`setting_key`, `setting_value`, `setting_group`, `description`) VALUES
('app_name', 'Jurnal Guru Enterprise', 'general', 'Nama Aplikasi Sekolah'),
('app_institution', 'SMA Negeri Enterprise 1', 'general', 'Nama Sekolah / Institusi'),
('app_logo', 'assets/static/logo.png', 'general', 'Logo Aplikasi'),
('app_address', 'Jl. Edukasi No. 1, Kota Enterprise', 'general', 'Alamat Sekolah');

-- --------------------------------------------------------
-- 16. Table Login Attempts (Security Rate Limiter)
-- --------------------------------------------------------
CREATE TABLE `login_attempts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `ip_address` VARCHAR(45) NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `attempt_time` INT UNSIGNED NOT NULL,
  INDEX `idx_attempt_ip_user` (`ip_address`, `username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
