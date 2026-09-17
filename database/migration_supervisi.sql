/* ============================================================ */
/* MIGRATION SUPERVISI AKADEMIK                                 */
/* Role Kepala Madrasah & Waka Kurikulum                        */
/* ============================================================ */

SET FOREIGN_KEY_CHECKS = 0;

/* 1. Ensure Roles Exist */
INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`) 
VALUES (4, 'kamad', 'Kepala Madrasah', 'Monitoring KBM, Kehadiran Kelas, dan Supervisi Akademik')
ON DUPLICATE KEY UPDATE `role_name` = 'Kepala Madrasah', `description` = 'Monitoring KBM, Kehadiran Kelas, dan Supervisi Akademik';

INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`) 
VALUES (5, 'waka', 'Waka Kurikulum', 'Monitoring, evaluasi, verifikasi perangkat ajar, dan supervisi akademik')
ON DUPLICATE KEY UPDATE `role_name` = 'Waka Kurikulum', `description` = 'Monitoring, evaluasi, verifikasi perangkat ajar, dan supervisi akademik';

/* 2. Create Master Form Table */
CREATE TABLE IF NOT EXISTS `supervisi_form` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_form` VARCHAR(20) NOT NULL UNIQUE,
  `nama_form` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `supervisi_form` (`id`, `kode_form`, `nama_form`, `deskripsi`) VALUES
(1, 'FORM_1', 'FORM 1: ADMINISTRASI GURU (PERENCANAAN PEMBELAJARAN)', 'Pemeriksaan kelengkapan dokumen administrasi pembelajaran guru'),
(2, 'FORM_2', 'FORM 2: SUPERVISI RPP / MODUL AJAR (PERENCANAAN PEMBELAJARAN)', 'Pemeriksaan komponen RPP / Modul Ajar guru'),
(3, 'FORM_3', 'FORM 3: SUPERVISI PEMBELAJARAN (OBSERVASI KELAS)', 'Observasi pelaksanaan pembelajaran di kelas secara langsung'),
(4, 'FORM_4', 'FORM 4: SUPERVISI PENILAIAN (PROSES DAN HASIL BELAJAR PESERTA DIDIK)', 'Pemeriksaan kelengkapan instrumen dan dokumen penilaian hasil belajar')
ON DUPLICATE KEY UPDATE `nama_form` = VALUES(`nama_form`), `deskripsi` = VALUES(`deskripsi`);

/* 3. Create Master Indikator Table */
CREATE TABLE IF NOT EXISTS `supervisi_indikator` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `form_id` INT UNSIGNED NOT NULL,
  `sub_bagian` VARCHAR(255) NULL,
  `nomor_urut` INT NOT NULL,
  `kode_indikator` VARCHAR(50) NULL,
  `nama_indikator` TEXT NOT NULL,
  `is_required` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`form_id`) REFERENCES `supervisi_form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* Populate Form 1 Indikator */
INSERT INTO `supervisi_indikator` (`id`, `form_id`, `sub_bagian`, `nomor_urut`, `kode_indikator`, `nama_indikator`) VALUES
(1, 1, 'Administrasi Perencanaan', 1, 'F1_01', 'Kalender Pendidikan'),
(2, 1, 'Administrasi Perencanaan', 2, 'F1_02', 'Program Tahunan'),
(3, 1, 'Administrasi Perencanaan', 3, 'F1_03', 'Program Semester'),
(4, 1, 'Administrasi Perencanaan', 4, 'F1_04', 'Silabus (Khusus untuk kelas 12)'),
(5, 1, 'Administrasi Perencanaan', 5, 'F1_05', 'Rencana Pelaksanaan Pembelajaran/Modul Ajar'),
(6, 1, 'Administrasi Perencanaan', 6, 'F1_06', 'Jadwal Tatap Muka'),
(7, 1, 'Administrasi Perencanaan', 7, 'F1_07', 'Agenda Harian'),
(8, 1, 'Administrasi Perencanaan', 8, 'F1_08', 'Daftar Nilai (Sikap, Pengetahuan, dan Keterampilan)'),
(9, 1, 'Administrasi Perencanaan', 9, 'F1_09', 'Kriteria Ketuntasan Minimal'),
(10, 1, 'Administrasi Perencanaan', 10, 'F1_10', 'Absensi Siswa'),
(11, 1, 'Administrasi Perencanaan', 11, 'F1_11', 'Buku Pegangan Guru'),
(12, 1, 'Administrasi Perencanaan', 12, 'F1_12', 'Buku Teks Siswa')
ON DUPLICATE KEY UPDATE `form_id` = VALUES(`form_id`), `sub_bagian` = VALUES(`sub_bagian`), `nomor_urut` = VALUES(`nomor_urut`), `kode_indikator` = VALUES(`kode_indikator`), `nama_indikator` = VALUES(`nama_indikator`);

/* Populate Form 2 Indikator */
INSERT INTO `supervisi_indikator` (`id`, `form_id`, `sub_bagian`, `nomor_urut`, `kode_indikator`, `nama_indikator`) VALUES
(13, 2, 'Komponen Modul/RPP', 1, 'F2_01', 'Identitas Madrasah'),
(14, 2, 'Komponen Modul/RPP', 2, 'F2_02', 'Capaian Pembelajaran'),
(15, 2, 'Komponen Modul/RPP', 3, 'F2_03', 'Alur Tujuan Pembelajaran'),
(16, 2, 'Komponen Modul/RPP', 4, 'F2_04', 'Indikator Ketercapaian Tujuan Pembelajaran'),
(17, 2, 'Komponen Modul/RPP', 5, 'F2_05', 'Tujuan Pembelajaran'),
(18, 2, 'Komponen Modul/RPP', 6, 'F2_06', 'Materi Pembelajaran'),
(19, 2, 'Komponen Modul/RPP', 7, 'F2_07', 'Pendekatan, Model, dan Metode'),
(20, 2, 'Komponen Modul/RPP', 8, 'F2_08a', 'Kegiatan Pembelajaran - Pendahuluan'),
(21, 2, 'Komponen Modul/RPP', 9, 'F2_08b', 'Kegiatan Pembelajaran - Kegiatan inti'),
(22, 2, 'Komponen Modul/RPP', 10, 'F2_08c', 'Kegiatan Pembelajaran - Penutup'),
(23, 2, 'Komponen Modul/RPP', 11, 'F2_09a', 'Penilaian Pembelajaran, Remedial, dan Pengayaan - Teknik penilaian'),
(24, 2, 'Komponen Modul/RPP', 12, 'F2_09b', 'Penilaian Pembelajaran, Remedial, dan Pengayaan - Instrumen penilaian'),
(25, 2, 'Komponen Modul/RPP', 13, 'F2_09c', 'Penilaian Pembelajaran, Remedial, dan Pengayaan - Pembelajaran, remedial, dan pengayaan'),
(26, 2, 'Komponen Modul/RPP', 14, 'F2_10', 'Media/alat'),
(27, 2, 'Komponen Modul/RPP', 15, 'F2_11', 'Bahan'),
(28, 2, 'Komponen Modul/RPP', 16, 'F2_12', 'Sumber belajar')
ON DUPLICATE KEY UPDATE `form_id` = VALUES(`form_id`), `sub_bagian` = VALUES(`sub_bagian`), `nomor_urut` = VALUES(`nomor_urut`), `kode_indikator` = VALUES(`kode_indikator`), `nama_indikator` = VALUES(`nama_indikator`);

/* Populate Form 3 Indikator */
INSERT INTO `supervisi_indikator` (`id`, `form_id`, `sub_bagian`, `nomor_urut`, `kode_indikator`, `nama_indikator`) VALUES
(29, 3, 'A. Kegiatan Pendahuluan', 1, 'F3_A01', 'Melakukan apersepsi dan motivasi'),
(30, 3, 'A. Kegiatan Pendahuluan', 2, 'F3_A02', 'Menyiapkan fisik dan psikis peserta dalam mengawali kegiatan pembelajaran'),
(31, 3, 'A. Kegiatan Pendahuluan', 3, 'F3_A03', 'Mengaitkan materi pembelajaran sekarang dengan pengalaman peserta didik dalam perjalanan menuju sekolah atau dengan tema sebelumnya'),
(32, 3, 'A. Kegiatan Pendahuluan', 4, 'F3_A04', 'Mengajukan pertanyaan yang ada keterkaitan dengan tema yang dibelajarkan'),
(33, 3, 'A. Kegiatan Pendahuluan', 5, 'F3_A05', 'Mengajak peserta didik berdinamika melakukan sesuatu kegiatan yang terkait dengan materi'),
(34, 3, 'B.1 Guru Menguasai Materi yang Diajarkan', 6, 'F3_B101', 'Kemampuan menyesuaikan materi dengan tujuan pembelajaran'),
(35, 3, 'B.1 Guru Menguasai Materi yang Diajarkan', 7, 'F3_B102', 'Kemampuan mengaitkan materi dengan pengetahuan lain yang diintegrasikan secara relevan dengan perkembangan, Iptek, dan kehidupan nyata'),
(36, 3, 'B.1 Guru Menguasai Materi yang Diajarkan', 8, 'F3_B103', 'Menyajikan materi dalam tema secara sistematis dan gradasi (dari yang mudah ke sulit, dari konkret ke abstrak)'),
(37, 3, 'B.2 Guru Menerapkan Strategi Pembelajaran yang Mendidik', 9, 'F3_B201', 'Melaksanakan pembelajaran sesuai dengan kompetensi yang akan dicapai'),
(38, 3, 'B.2 Guru Menerapkan Strategi Pembelajaran yang Mendidik', 10, 'F3_B202', 'Melakukan pembelajaran secara urut'),
(39, 3, 'B.2 Guru Menerapkan Strategi Pembelajaran yang Mendidik', 11, 'F3_B203', 'Menguasai kelas dengan baik'),
(40, 3, 'B.2 Guru Menerapkan Strategi Pembelajaran yang Mendidik', 12, 'F3_B204', 'Melaksanakan pembelajaran yang bersifat kontekstual'),
(41, 3, 'B.2 Guru Menerapkan Strategi Pembelajaran yang Mendidik', 13, 'F3_B205', 'Melaksanakan pembelajaran yang memungkinkan tumbuhnya kebiasaan positif (nurturant effect)'),
(42, 3, 'B.2 Guru Menerapkan Strategi Pembelajaran yang Mendidik', 14, 'F3_B206', 'Melaksanakan pembelajaran sesuai dengan alokasi waktu yang direncanakan'),
(43, 3, 'B.3 Guru Menerapkan Pendekatan Saintifik', 15, 'F3_B301', 'Menyajikan topik atau materi yang mendorong peserta didik melakukan kegiatan mengamati'),
(44, 3, 'B.3 Guru Menerapkan Pendekatan Saintifik', 16, 'F3_B302', 'Memancing peserta didik untuk bertanya'),
(45, 3, 'B.3 Guru Menerapkan Pendekatan Saintifik', 17, 'F3_B303', 'Menyajikan kegiatan yang mendorong peserta didik untuk mengumpulkan informasi atau data'),
(46, 3, 'B.3 Guru Menerapkan Pendekatan Saintifik', 18, 'F3_B304', 'Menyajikan kegiatan yang mendorong peserta didik untuk mengasosiasikan/mengolah informasi'),
(47, 3, 'B.3 Guru Menerapkan Pendekatan Saintifik', 19, 'F3_B305', 'Menyajikan kegiatan yang mendorong peserta didik untuk terampil mengomunikasikan hasil secara lisan maupun tertulis'),
(48, 3, 'B.4 Aspek yang Diamati', 20, 'F3_B401', 'Memancing peserta didik untuk bertanya'),
(49, 3, 'B.4 Aspek yang Diamati', 21, 'F3_B402', 'Menyajikan kegiatan yang mendorong peserta didik untuk mengumpulkan informasi/data'),
(50, 3, 'B.4 Aspek yang Diamati', 22, 'F3_B403', 'Menyajikan kegiatan yang mendorong peserta didik untuk mengasosiasikan/mengolah informasi'),
(51, 3, 'B.4 Aspek yang Diamati', 23, 'F3_B404', 'Menyajikan kegiatan yang mendorong peserta didik untuk terampil mengomunikasikan hasil secara lisan maupun tertulis'),
(52, 3, 'B.5 Guru Melaksanakan Penilaian Autentik', 24, 'F3_B501', 'Mengamati sikap dan perilaku peserta didik dalam mengikuti pelajaran'),
(53, 3, 'B.5 Guru Melaksanakan Penilaian Autentik', 25, 'F3_B502', 'Melakukan penilaian keterampilan peserta didik dalam melakukan aktivitas individu/kelompok'),
(54, 3, 'B.5 Guru Melaksanakan Penilaian Autentik', 26, 'F3_B503', 'Mendokumentasikan hasil pengamatan sikap perilaku dan keterampilan peserta didik'),
(55, 3, 'B.6 Guru Memanfaatkan Sumber Belajar/Media Dalam Pembelajaran', 27, 'F3_B601', 'Menunjukkan keterampilan dalam pemanfaatan sumber belajar'),
(56, 3, 'B.6 Guru Memanfaatkan Sumber Belajar/Media Dalam Pembelajaran', 28, 'F3_B602', 'Menunjukkan keterampilan dalam penggunaan media pembelajaran'),
(57, 3, 'B.6 Guru Memanfaatkan Sumber Belajar/Media Dalam Pembelajaran', 29, 'F3_B603', 'Menghasilkan media pembelajaran yang menarik'),
(58, 3, 'B.6 Guru Memanfaatkan Sumber Belajar/Media Dalam Pembelajaran', 30, 'F3_B604', 'Melibatkan peserta didik dalam pemanfaatan sumber belajar'),
(59, 3, 'B.6 Guru Memanfaatkan Sumber Belajar/Media Dalam Pembelajaran', 31, 'F3_B605', 'Melibatkan peserta didik dalam pemanfaatan media pembelajaran'),
(60, 3, 'B.7 Guru Memicu/Memelihara Keterlibatan Peserta Didik', 32, 'F3_B701', 'Menumbuhkan partisipasi aktif peserta didik melalui interaksi guru, peserta didik, dan sumber belajar'),
(61, 3, 'B.7 Guru Memicu/Memelihara Keterlibatan Peserta Didik', 33, 'F3_B702', 'Merespons positif partisipasi peserta didik'),
(62, 3, 'B.7 Guru Memicu/Memelihara Keterlibatan Peserta Didik', 34, 'F3_B703', 'Menunjukkan sikap terbuka terhadap respons peserta didik'),
(63, 3, 'B.7 Guru Memicu/Memelihara Keterlibatan Peserta Didik', 35, 'F3_B704', 'Menunjukkan hubungan pribadi yang kondusif'),
(64, 3, 'B.7 Guru Memicu/Memelihara Keterlibatan Peserta Didik', 36, 'F3_B705', 'Menumbuhkan keceriaan dan antusiasme peserta didik dalam pembelajaran'),
(65, 3, 'B.8 Guru Menggunakan Bahasa yang Benar dan Tepat', 37, 'F3_B801', 'Menggunakan bahasa lisan secara jelas dan lancar'),
(66, 3, 'B.8 Guru Menggunakan Bahasa yang Benar dan Tepat', 38, 'F3_B802', 'Menggunakan bahasa tulis yang baik dan benar'),
(67, 3, 'B.8 Guru Menggunakan Bahasa yang Benar dan Tepat', 39, 'F3_B803', 'Menyampaikan pesan dan gaya yang sesuai'),
(68, 3, 'C. Kegiatan Penutup', 40, 'F3_C101', 'Melakukan refleksi secara efektif'),
(69, 3, 'C. Kegiatan Penutup', 41, 'F3_C102', 'Memberikan tindak lanjut')
ON DUPLICATE KEY UPDATE `form_id` = VALUES(`form_id`), `sub_bagian` = VALUES(`sub_bagian`), `nomor_urut` = VALUES(`nomor_urut`), `kode_indikator` = VALUES(`kode_indikator`), `nama_indikator` = VALUES(`nama_indikator`);

/* Populate Form 4 Indikator */
INSERT INTO `supervisi_indikator` (`id`, `form_id`, `sub_bagian`, `nomor_urut`, `kode_indikator`, `nama_indikator`) VALUES
(70, 4, 'Instrumen Penilaian', 1, 'F4_01', 'Buku Nilai'),
(71, 4, 'Instrumen Penilaian', 2, 'F4_02a', 'Melakukan Tes - Penilaian Harian (PH)'),
(72, 4, 'Instrumen Penilaian', 3, 'F4_02b', 'Melakukan Tes - Penilaian Tengah Semester (PTS)'),
(73, 4, 'Instrumen Penilaian', 4, 'F4_02c', 'Melakukan Tes - Penilaian Akhir Semester (PAS)'),
(74, 4, 'Instrumen Penilaian', 5, 'F4_02d', 'Melakukan Tes - Penilaian Akhir Tahun (PAT)'),
(75, 4, 'Instrumen Penilaian', 6, 'F4_03a', 'Penilaian Pengetahuan - Tes tulis'),
(76, 4, 'Instrumen Penilaian', 7, 'F4_03b', 'Penilaian Pengetahuan - Tes lisan'),
(77, 4, 'Instrumen Penilaian', 8, 'F4_03c', 'Penilaian Pengetahuan - Penugasan'),
(78, 4, 'Instrumen Penilaian', 9, 'F4_03d', 'Penilaian Pengetahuan - Pengolahan Nilai Pengetahuan'),
(79, 4, 'Instrumen Penilaian', 10, 'F4_03e', 'Penilaian Pengetahuan - Deskripsi Nilai Pengetahuan'),
(80, 4, 'Instrumen Penilaian', 11, 'F4_04a', 'Penilaian Keterampilan - Unjuk kerja/praktik/kinerja/projek/produk/portofolio'),
(81, 4, 'Instrumen Penilaian', 12, 'F4_04b', 'Penilaian Keterampilan - Pengolahan Nilai Keterampilan'),
(82, 4, 'Instrumen Penilaian', 13, 'F4_04c', 'Penilaian Keterampilan - Deskripsi Nilai Keterampilan'),
(83, 4, 'Instrumen Penilaian', 14, 'F4_05a', 'Penilaian Sikap - Observasi/penilaian diri/penilaian antar peserta didik'),
(84, 4, 'Instrumen Penilaian', 15, 'F4_05b', 'Penilaian Sikap - Pengolahan Nilai Sikap'),
(85, 4, 'Instrumen Penilaian', 16, 'F4_05c', 'Penilaian Sikap - Deskripsi Nilai Sikap'),
(86, 4, 'Instrumen Penilaian', 17, 'F4_06', 'Remedial'),
(87, 4, 'Instrumen Penilaian', 18, 'F4_07', 'Pengayaan'),
(88, 4, 'Instrumen Penilaian', 19, 'F4_08', 'Analisis PH, PTS, PAS, dan PAT'),
(89, 4, 'Instrumen Penilaian', 20, 'F4_09', 'Bank Soal')
ON DUPLICATE KEY UPDATE `form_id` = VALUES(`form_id`), `sub_bagian` = VALUES(`sub_bagian`), `nomor_urut` = VALUES(`nomor_urut`), `kode_indikator` = VALUES(`kode_indikator`), `nama_indikator` = VALUES(`nama_indikator`);

/* 4. Create Main Supervisi Table */
CREATE TABLE IF NOT EXISTS `supervisi` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `uuid` VARCHAR(36) NOT NULL UNIQUE,
  `guru_id` INT UNSIGNED NOT NULL,
  `supervisor_id` INT UNSIGNED NOT NULL,
  `supervisor_role` VARCHAR(50) NOT NULL,
  `mapel_id` INT UNSIGNED NOT NULL,
  `kelas_id` INT UNSIGNED NOT NULL,
  `tahun_pelajaran_id` INT UNSIGNED NOT NULL,
  `semester` VARCHAR(20) DEFAULT 'Ganjil',
  `form_id` INT UNSIGNED NOT NULL,
  `tahap` VARCHAR(50) DEFAULT 'Tahap 1',
  `tanggal_supervisi` DATE NOT NULL,
  `jam_mulai` TIME NULL,
  `jam_selesai` TIME NULL,
  `status` ENUM('BELUM DIMULAI', 'DRAFT', 'DALAM PROSES', 'SELESAI') DEFAULT 'DRAFT',
  `jumlah_skor` INT DEFAULT 0,
  `skor_maksimal` INT DEFAULT 0,
  `nilai_akhir` DECIMAL(5,2) DEFAULT 0.00,
  `catatan_analisis` TEXT NULL,
  `tindak_lanjut` TEXT NULL,
  `saran` TEXT NULL,
  `status_tindak_lanjut` ENUM('Belum Ditindaklanjuti', 'Dalam Proses', 'Selesai') DEFAULT 'Belum Ditindaklanjuti',
  `respon_guru` TEXT NULL,
  `respon_at` DATETIME NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_sup_guru` (`guru_id`),
  INDEX `idx_sup_supervisor` (`supervisor_id`),
  INDEX `idx_sup_mapel` (`mapel_id`),
  INDEX `idx_sup_kelas` (`kelas_id`),
  INDEX `idx_sup_form` (`form_id`),
  INDEX `idx_sup_status` (`status`),
  FOREIGN KEY (`form_id`) REFERENCES `supervisi_form` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* 5. Create Supervisi Detail Table */
CREATE TABLE IF NOT EXISTS `supervisi_detail` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `supervisi_id` INT UNSIGNED NOT NULL,
  `indikator_id` INT UNSIGNED NOT NULL,
  `skor` TINYINT DEFAULT 0,
  `catatan_item` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`supervisi_id`) REFERENCES `supervisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`indikator_id`) REFERENCES `supervisi_indikator` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* 6. Create Supervisi Histori Table */
CREATE TABLE IF NOT EXISTS `supervisi_histori` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `supervisi_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `user_role` VARCHAR(50) NOT NULL,
  `activity` VARCHAR(255) NOT NULL,
  `data_before` LONGTEXT NULL,
  `data_after` LONGTEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`supervisi_id`) REFERENCES `supervisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* 7. Create Supervisi Notifikasi Table */
CREATE TABLE IF NOT EXISTS `supervisi_notifikasi` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `supervisi_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`supervisi_id`) REFERENCES `supervisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
