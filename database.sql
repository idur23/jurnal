-- Database dump for jg_enterprise
-- Created at 2026-08-31 02:47:49

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_log_created` (`created_at`),
  KEY `idx_logs_lookup` (`user_id`,`created_at`),
  CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=535 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('1', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:04:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('2', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:05:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('3', '4', 'LOGIN_SUCCESS', 'User superadmin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:07:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('4', '4', 'UPDATE_SETTINGS', 'Memperbarui Pengaturan Sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:14:33');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('5', '4', 'LOGOUT', 'User superadmin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:14:42');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('6', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:15:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('7', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:15:21');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('8', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:15:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('9', NULL, 'SAVE_NILAI', 'Menyimpan nilai Sumatif_PAS (Penilaian Sumatif_PAS) Kelas ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:26:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('10', NULL, 'LOGOUT', 'User wali1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:27:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('11', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:27:39');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('12', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260720-0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:28:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('13', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:47:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('14', '4', 'LOGIN_SUCCESS', 'User superadmin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:47:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('15', '4', 'LOGOUT', 'User superadmin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:47:51');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('16', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:47:53');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('17', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260720-0002', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:48:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('18', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:48:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('19', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:51:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('20', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:59:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('21', '4', 'LOGIN_SUCCESS', 'User superadmin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 11:59:29');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('22', '4', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:05:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('23', '4', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:05:55');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('24', '4', 'LOGOUT', 'User superadmin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:20:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('25', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:20:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('26', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260720-0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:22:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('27', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:22:33');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('28', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:22:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('29', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260720-0002', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:34:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('30', NULL, 'LOGOUT', 'User wali1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:35:08');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('31', '4', 'LOGIN_SUCCESS', 'User superadmin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:35:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('32', '4', 'UPDATE_SETTINGS', 'Memperbarui Pengaturan Sistem & Format Laporan', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:38:13');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('33', '4', 'CREATE_TP', 'Menambah Tahun Pelajaran 2026/2027 (Ganjil)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:39:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('34', '4', 'ACTIVATE_TP', 'Mengaktifkan Tahun Pelajaran ID: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:39:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('35', '4', 'ACTIVATE_TP', 'Mengaktifkan Tahun Pelajaran ID: 2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:39:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('36', '4', 'ACTIVATE_TP', 'Mengaktifkan Tahun Pelajaran ID: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:39:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('37', '4', 'DELETE_TP', 'Menghapus Tahun Pelajaran ID: 2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:42:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('38', '4', 'DELETE_TP', 'Menghapus Tahun Pelajaran ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:42:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('39', '4', 'LOGOUT', 'User superadmin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-20 12:43:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('40', '4', 'LOGIN_SUCCESS', 'User superadmin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 03:52:36');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('41', '4', 'LOGOUT', 'User superadmin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 03:53:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('42', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 03:53:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('43', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260721-0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 03:54:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('44', NULL, 'LOGOUT', 'User wali1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 03:54:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('45', '4', 'LOGIN_SUCCESS', 'User superadmin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 03:54:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('46', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 12:53:13');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('47', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 12:56:18');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('48', '4', 'LOGIN_SUCCESS', 'User superadmin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-21 12:56:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('49', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 11:45:29');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('50', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 11:45:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('51', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 11:45:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('52', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 11:46:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('53', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 11:47:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('54', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 11:47:07');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('55', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 11:47:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('56', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 12:53:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('57', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 12:54:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('58', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 12:54:36');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('59', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 12:55:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('60', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 12:56:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('61', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:07:13');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('62', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:07:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('63', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260722-0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:09:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('64', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:11:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('65', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:11:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('66', NULL, 'LOGOUT', 'User wali1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:18:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('67', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:18:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('68', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:18:53');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('69', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:20:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('70', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:20:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('71', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:38:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('72', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:38:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('73', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:49:41');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('74', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 13:49:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('75', NULL, 'LOGOUT', 'User wali1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:21:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('76', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:21:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('77', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260722-0002', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:28:48');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('78', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260722-0003', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:31:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('79', '1', 'SAVE_NILAI', 'Menyimpan nilai catatan (Harian 1) Kelas ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:42:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('80', '1', 'IMPORT_NILAI', 'Import Excel catatan (Bab 2) Kelas ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:50:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('81', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:55:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('82', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:55:27');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('83', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:55:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('84', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:56:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('85', NULL, 'LOGOUT', 'User wali1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:56:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('86', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:56:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('87', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:56:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('88', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 14:56:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('89', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260722-0004', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:11:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('90', '1', 'SAVE_PERKEMBANGAN', 'Menyimpan perkembangan diri siswa Kelas ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:13:38');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('91', '1', 'ADD_PROGRAM_WK', 'Tambah program kelas: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:14:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('92', '1', 'ADD_KOKURIKULER_WK', 'Tambah kokurikuler: Gaya Hidup Berkelanjutan (Cinta Bumi, Daur Ulang)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:15:33');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('93', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:30:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('94', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:30:27');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('95', NULL, 'ADD_CASE_WK', 'Tambah log penanganan siswa ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:32:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('96', NULL, 'ADD_CASE_WK', 'Tambah log penanganan siswa ID: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:34:50');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('97', NULL, 'ADD_CASE_WK', 'Tambah log penanganan siswa ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:35:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('98', NULL, 'ADD_PROGRAM_WK', 'Tambah program kelas: n', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:37:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('99', NULL, 'LOGOUT', 'User wali1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:45:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('100', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-22 15:45:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('101', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 05:36:59');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('102', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 05:37:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('103', '1', 'EDIT_PROGRAM_WK', 'Edit program kelas ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 05:41:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('104', '1', 'EDIT_CASE_WK', 'Edit log penanganan siswa ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 05:41:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('105', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 06:31:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('106', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 06:31:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('107', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260725-0001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 06:36:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('108', NULL, 'ADD_KARYA', 'Menambahkan karya: tahu', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 06:42:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('109', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 06:43:59');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('110', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 06:45:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('111', NULL, 'LOGOUT', 'User wali1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 06:50:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('112', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 06:50:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('113', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260725-0002', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-25 07:01:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('114', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-28 10:45:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('115', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-29 13:30:39');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('116', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-29 13:31:12');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('117', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-29 13:31:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('118', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260729-0002', '0.0.0.0', '', '2026-07-29 13:41:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('119', NULL, 'LOGOUT', 'User guru1 logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-29 13:43:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('120', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-29 13:43:08');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('121', '1', 'UPDATE_SETTINGS', 'Memperbarui Pengaturan Sistem & Format Laporan', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-29 13:58:36');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('122', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260729-0002', '0.0.0.0', '', '2026-07-29 14:05:38');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('123', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2001:448a:50a0:d511:2046:f736:469c:5ded', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-31 20:29:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('124', '1', 'LOGOUT', 'User admin logout.', '2001:448a:50a0:d511:2046:f736:469c:5ded', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-31 20:30:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('125', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2001:448a:50a0:d511:2046:f736:469c:5ded', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-31 20:30:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('126', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X B Mapel: Matematika Wajib', '140.213.52.248', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-31 21:01:57');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('127', '1', 'SAVE_NILAI', 'Input Nilai praktik (Bab 1) Kelas ID: 1', '140.213.52.248', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-31 21:02:36');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('128', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '223.25.110.253', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36', '2026-07-31 21:04:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('129', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '223.25.110.253', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36', '2026-07-31 21:04:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('130', '1', 'LOGOUT', 'User admin logout.', '223.25.110.253', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36', '2026-07-31 21:05:59');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('131', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '223.25.110.253', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36', '2026-07-31 21:07:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('132', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 10:51:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('133', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260807-0001', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 10:58:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('134', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 9 untuk Jurnal: JRN-20260807-0001', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 10:59:12');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('135', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X A Mapel: Bahasa Indonesia', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:01:12');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('136', '1', 'LOGOUT', 'User admin logout.', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:17:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('137', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: superadmin', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:18:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('138', '4', 'LOGIN_SUCCESS', 'User superadmin (Administrator) berhasil login.', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:18:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('139', '4', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260807-0002', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:20:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('140', '4', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 10 untuk Jurnal: JRN-20260807-0002', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:21:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('141', '4', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X B Mapel: Fisika Peminatan', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:21:50');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('142', '4', 'LOGOUT', 'User superadmin logout.', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:22:27');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('143', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:23:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('144', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260807-0003', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:25:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('145', NULL, 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 11 untuk Jurnal: JRN-20260807-0003', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:25:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('146', NULL, 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: XI B Mapel: Matematika Wajib', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:26:07');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('147', NULL, 'LOGOUT', 'User guru1 logout.', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:28:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('148', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:29:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('149', NULL, 'CREATE_PROGRAM_KELAS', 'Membuat Program Kelas: tes', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:30:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('150', NULL, 'CREATE_PENANGANAN', 'Membuat Jurnal Penanganan Siswa ID: 1', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:33:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('151', NULL, 'CREATE_PENANGANAN', 'Membuat Jurnal Penanganan Siswa ID: 5', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:34:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('152', NULL, 'CREATE_KOKURIKULER', 'Membuat Aktivitas Kokurikuler Tema: Kewirausahaan (Hidup Hemat/Produktif)', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:36:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('153', NULL, 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260807-0004', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:41:33');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('154', NULL, 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 12 untuk Jurnal: JRN-20260807-0004', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:42:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('155', NULL, 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X A Mapel: Fisika Peminatan', '158.140.163.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-07 11:42:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('156', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '158.140.163.95', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 11:14:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('157', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '114.8.228.197', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 11:14:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('158', NULL, 'EDIT_KARYA', 'Mengedit karya ID: 1', '158.140.163.95', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 11:21:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('159', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '114.8.228.197', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 11:36:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('160', NULL, 'LOGIN_SUCCESS', 'User guru1 (Guru Mata Pelajaran) berhasil login.', '110.136.89.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 14:38:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('161', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '110.136.89.40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 14:39:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('162', '1', 'VERIFY_PERANGKAT', 'Memproses Verifikasi Perangkat ID: 4 -> Status: Disetujui', '110.136.89.40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 14:45:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('163', NULL, 'IMPORT_NILAI', 'Import Excel praktik (proyek SKI (mind mapping)) Kelas ID: 2. Code: IMP-1786608376-6814', '110.136.89.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 15:06:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('164', NULL, 'IMPORT_NILAI', 'Import Excel praktik (proyek SKI (mind mapping)) Kelas ID: 2. Code: IMP-1786608435-5875', '110.136.89.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 15:07:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('165', NULL, 'SAVE_NILAI', 'Input Nilai praktik (proyek SKI (mind mapping)) Kelas ID: 2', '110.136.89.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 15:08:41');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('166', NULL, 'SAVE_NILAI', 'Input Nilai praktik (proyek SKI (mind mapping)) Kelas ID: 2', '110.136.89.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 15:09:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('167', NULL, 'SAVE_NILAI', 'Input Nilai uh (Ulangan Harian Fikih Bab 1-3) Kelas ID: 2', '110.136.89.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 15:17:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('168', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 15:25:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('169', NULL, 'REVISE_PERANGKAT', 'Membuat Revisi/Versi Baru Perangkat ID: 4 -> New ID: 9', '110.136.89.241', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 15:58:08');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('170', '1', 'UPDATE_SETTINGS', 'Memperbarui Pengaturan Sistem & Format Laporan', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:13:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('171', NULL, 'UPDATE_PRESENSI_KELAS', 'Mengubah Presensi Kelas ID: 7', '110.136.89.241', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 16:15:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('172', '1', 'LOGOUT', 'User admin logout.', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:16:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('173', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: wali1', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:16:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('174', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: wali2', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:16:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('175', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:17:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('176', '1', 'LOGOUT', 'User admin logout.', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:17:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('177', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: wali2', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:17:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('178', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:18:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('179', '1', 'LOGOUT', 'User admin logout.', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:18:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('180', NULL, 'LOGIN_SUCCESS', 'User wali1 (Wali Kelas) berhasil login.', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:18:48');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('181', NULL, 'LOGOUT', 'User wali1 logout.', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:33:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('182', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '110.136.89.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:33:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('183', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 1', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:34:55');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('184', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:35:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('185', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:35:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('186', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:35:48');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('187', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:36:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('188', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:36:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('189', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 2', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:38:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('190', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abi Lazkar Amar Ma\'rufi', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:38:55');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('191', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Amin Adimas Putra', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:39:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('192', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Muhammad Ahsan Thoriq', '110.136.89.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-13 16:40:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('193', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:06:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('194', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:07:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('195', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:07:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('196', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:07:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('197', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:38:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('198', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:39:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('199', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:40:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('200', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abi Lazkar Amar Ma\'rufi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:42:41');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('201', '1', 'LOGOUT', 'User admin logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:42:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('202', NULL, 'LOGIN_SUCCESS', 'User rufi (Guru Mata Pelajaran) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:42:50');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('203', NULL, 'LOGOUT', 'User rufi logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:42:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('204', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 12:43:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('205', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 19:49:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('206', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abi Lazkar Amar Ma\'rufi', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 19:50:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('207', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:17:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('208', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:17:55');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('209', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: guru1', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:18:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('210', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: wali1', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:18:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('211', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:18:48');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('212', '1', 'LOGOUT', 'User admin logout.', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 20:19:35');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('213', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 20:20:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('214', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: Admin@123', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:20:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('215', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin@12345', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:21:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('216', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: Admin@12345', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:21:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('217', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:23:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('218', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:23:38');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('219', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abi Lazkar Amar Ma\'rufi', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:24:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('220', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Amin Adimas Putra', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:25:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('221', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Arsy Bintang Ramadhani', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:25:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('222', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Elmiatun Nafiah', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:25:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('223', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Fakhrur Rozi', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:26:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('224', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 21', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:26:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('225', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Hanindria Haura Dzikra Fitranti', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:26:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('226', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Lazatin \'Aniqoh', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:26:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('227', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: M. Alifudin Ikhsan', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:27:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('228', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Muhammad Ahsan Thoriq', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:27:57');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('229', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 20', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:28:07');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('230', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Nilnaminach Ziyadatul ΓÇÿIshma', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:28:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('231', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Nur Arifah Dzul QoΓÇÖdah', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:28:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('232', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Nur Indah Agustina', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:28:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('233', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Pratiwi Nur Zamzani', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:28:57');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('234', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Rudy Cahya Kumala', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:29:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('235', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Siti Aminatuz Zuhroh', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:29:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('236', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Thalita Syahda Raniah', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:29:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('237', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 20:31:39');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('238', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260814-0001', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 20:39:41');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('239', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 20:40:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('240', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260814-0002', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 20:40:42');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('241', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 20:41:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('242', '1', 'DELETE_MAPEL', 'Menghapus Mapel ID: 4', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 20:42:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('243', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 20:42:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('244', '1', 'CREATE_MAPEL', 'Menambah Mapel: Informatika', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 20:43:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('245', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260814-0003', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 20:43:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('246', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 20:44:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('247', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260814-0004', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 20:45:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('248', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 20:45:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('249', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260814-0005', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 20:45:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('250', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 20:45:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('251', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 21:14:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('252', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 22', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 21:14:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('253', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 21', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 21:14:29');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('254', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 20', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 21:14:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('255', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 23', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 21:14:39');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('256', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 19', '118.99.126.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-14 21:14:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('257', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: admin', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 21:16:12');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('258', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-14 21:16:27');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('259', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260814-0001', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 21:20:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('260', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 13 untuk Jurnal: JRN-20260814-0001', '2400:9800:7c2:3401:f84c:c441:e372:8a90', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-14 21:20:33');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('261', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: guru1', '158.140.163.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-15 16:36:36');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('262', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 1', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:16:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('263', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 2', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:16:51');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('264', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 5', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:17:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('265', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 6', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:17:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('266', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 7', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:17:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('267', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 8', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:17:50');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('268', '1', 'DELETE_MAPEL', 'Menghapus Mapel ID: 1', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:20:39');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('269', '1', 'DELETE_MAPEL', 'Menghapus Mapel ID: 2', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:20:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('270', '1', 'DELETE_MAPEL', 'Menghapus Mapel ID: 3', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:20:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('271', '1', 'DELETE_MAPEL', 'Menghapus Mapel ID: 5', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:20:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('272', '1', 'CREATE_MAPEL', 'Menambah Mapel: Bahasa Arab', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-15 20:22:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('273', '1', 'CREATE_MAPEL', 'Menambah Mapel: KIMIA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:22:51');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('274', '1', 'CREATE_MAPEL', 'Menambah Mapel: EKONOMI', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:23:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('275', '1', 'CREATE_MAPEL', 'Menambah Mapel: SENI RUPA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:24:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('276', '1', 'CREATE_MAPEL', 'Menambah Mapel: BAHASA ARAB', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:25:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('277', '1', 'CREATE_MAPEL', 'Menambah Mapel: SENI RUPA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:25:33');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('278', '1', 'CREATE_MAPEL', 'Menambah Mapel: PPKn', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:26:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('279', '1', 'CREATE_MAPEL', 'Menambah Mapel: BAHASA INDONESIA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:26:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('280', '1', 'CREATE_MAPEL', 'Menambah Mapel: SENI RUPA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:27:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('281', '1', 'CREATE_MAPEL', 'Menambah Mapel: PPKn', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:28:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('282', '1', 'CREATE_MAPEL', 'Menambah Mapel: BIOLOGI', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:29:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('283', '1', 'CREATE_MAPEL', 'Menambah Mapel: ASWAJA PROGRESIF', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:30:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('284', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 17', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:30:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('285', '1', 'CREATE_MAPEL', 'Menambah Mapel: PAI TERPADU', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:31:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('286', '1', 'CREATE_MAPEL', 'Menambah Mapel: MATEMATIKA WAJIB', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:32:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('287', '1', 'CREATE_MAPEL', 'Menambah Mapel: MATEMATIKA PEMINATAN', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:36:28');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('288', '1', 'CREATE_MAPEL', 'Menambah Mapel: FISIKA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:36:51');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('289', '1', 'CREATE_MAPEL', 'Menambah Mapel: INFORMATIKA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:37:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('290', '1', 'CREATE_MAPEL', 'Menambah Mapel: KODING AI', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:38:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('291', '1', 'CREATE_MAPEL', 'Menambah Mapel: BAHASA INDONESIA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:39:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('292', '1', 'CREATE_MAPEL', 'Menambah Mapel: BAHASA INGGRIS', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:39:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('293', '1', 'CREATE_MAPEL', 'Menambah Mapel: ASWAJA PROGRESIF', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:40:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('294', '1', 'CREATE_MAPEL', 'Menambah Mapel: PAI TERPADU', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:40:48');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('295', '1', 'CREATE_MAPEL', 'Menambah Mapel: IPS TERPADU', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:41:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('296', '1', 'CREATE_MAPEL', 'Menambah Mapel: SEJARAH INDONESIA', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:41:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('297', '1', 'CREATE_MAPEL', 'Menambah Mapel: PPKn', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:42:13');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('298', '1', 'CREATE_MAPEL', 'Menambah Mapel: PJOK', '2400:9800:9b1:dbde:57ad:7a9f:87f9:5159', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Safari/537.36', '2026-08-15 20:42:36');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('299', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:9b3:1901:6e9d:1601:b171:9aca', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-16 15:16:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('300', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:16:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('301', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:16:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('302', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 25', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:22:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('303', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:23:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('304', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 14 untuk Jurnal: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:23:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('305', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: XI A Mapel: IPS TERPADU', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:23:57');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('306', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 26', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:24:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('307', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:25:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('308', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 27', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:48:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('309', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:49:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('310', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 15 untuk Jurnal: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:49:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('311', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: XI A Mapel: ASWAJA PROGRESIF', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:49:24');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('312', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 28', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:50:08');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('313', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:51:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('314', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 16 untuk Jurnal: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:51:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('315', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X B Mapel: ASWAJA PROGRESIF', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:51:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('316', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 29', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:53:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('317', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:54:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('318', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 17 untuk Jurnal: JRN-20260817-0001', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:54:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('319', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: XII A Mapel: BAHASA ARAB', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 19:54:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('320', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260817-0002', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 20:02:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('321', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 18 untuk Jurnal: JRN-20260817-0002', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 20:03:22');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('322', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X B Mapel: Bahasa Arab', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 20:03:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('323', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 31', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 20:03:57');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('324', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 30', '180.248.34.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-17 20:04:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('325', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:ca0:a53f:e6bf:da42:6c1c:fcce', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-17 20:52:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('326', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260817-0001', '182.4.133.86', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-17 20:54:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('327', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 19 untuk Jurnal: JRN-20260817-0001', '2400:9800:ca0:a53f:e6bf:da42:6c1c:fcce', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-17 20:54:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('328', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X B Mapel: ASWAJA PROGRESIF', '2400:9800:ca0:a53f:e6bf:da42:6c1c:fcce', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-17 20:54:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('329', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:9b2:a61f:4787:2156:1f72:2142', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', '2026-08-17 21:06:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('330', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '114.8.227.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-18 14:39:36');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('331', '1', 'UPDATE_SETTINGS', 'Memperbarui Pengaturan Sistem & Format Laporan', '114.8.227.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-18 14:49:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('332', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:9b1:adf5:73df:63fb:8777:ef02', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-08-20 11:21:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('333', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '110.136.89.122', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-20 19:38:51');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('334', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-21 10:04:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('335', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '2400:9800:ca0:12f:fcdb:3b95:9a58:7571', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-23 19:32:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('336', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260823-0001', '2400:9800:ca0:12f:fcdb:3b95:9a58:7571', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-23 19:32:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('337', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 33', '2400:9800:ca0:12f:fcdb:3b95:9a58:7571', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-23 19:33:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('338', '1', 'DELETE_JURNAL', 'Menghapus Jurnal ID: 32', '2400:9800:ca0:12f:fcdb:3b95:9a58:7571', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-23 19:33:35');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('339', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 09:02:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('340', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260824-0001', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 09:04:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('341', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 20 untuk Jurnal: JRN-20260824-0001', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 09:05:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('342', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X A Mapel: ASWAJA PROGRESIF', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 09:05:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('343', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 7', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 09:09:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('344', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 6', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 09:10:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('345', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 7', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 09:10:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('346', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 8', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 10:58:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('347', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 9', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 10:58:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('348', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 10', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 10:59:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('349', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 11', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 10:59:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('350', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 12', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:00:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('351', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 13', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:01:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('352', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 14', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:01:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('353', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 15', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:04:53');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('354', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 16', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:05:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('355', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 17', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:11:42');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('356', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 19', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:16:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('357', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 20', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:16:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('358', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 21', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:17:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('359', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 22', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:17:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('360', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 23', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:18:13');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('361', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 24', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:19:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('362', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 25', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:19:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('363', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 28', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:19:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('364', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 29', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:21:28');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('365', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 30', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:23:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('366', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 31', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:23:28');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('367', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 27', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:24:18');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('368', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 26', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:24:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('369', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 18', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:25:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('370', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:26:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('371', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abi Lazkar Amar Ma\'rufi', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:26:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('372', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:28:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('373', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:30:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('374', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Amin Adimas Putra', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:32:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('375', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Arsy Bintang Ramadhani', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:35:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('376', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Elmiatun Nafiah', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:38:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('377', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:38:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('378', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abi Lazkar Amar Ma\'rufi', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:38:28');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('379', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Fakhrur Rozi', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:38:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('380', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Hanindria Haura Dzikra Fitranti', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:39:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('381', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Lazatin \'Aniqoh', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:39:29');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('382', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: M. Alifudin Ikhsan', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:40:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('383', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Muhammad Ahsan Thoriq', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:40:57');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('384', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Nilnaminach Ziyadatul ΓÇÿIshma', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:41:28');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('385', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Nur Arifah Dzul QoΓÇÖdah', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:42:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('386', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Nur Indah Agustina', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:43:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('387', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Pratiwi Nur Zamzani', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:44:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('388', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Muhammad Ahsan Thoriq', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:44:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('389', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Rudy Cahya Kumala', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:44:42');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('390', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Siti Aminatuz Zuhroh', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:45:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('391', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Thalita Syahda Raniah', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:45:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('392', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 11:49:55');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('393', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:01:08');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('394', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abi Lazkar Amar Ma\'rufi', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:01:21');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('395', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Amin Adimas Putra', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:01:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('396', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Amin Adimas Putra', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:02:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('397', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Abdul Madjid Wafa', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:02:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('398', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 8', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:03:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('399', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 12', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:03:39');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('400', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 6', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:03:42');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('401', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 15', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:03:48');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('402', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 9', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:03:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('403', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 3', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('404', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 7', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('405', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 10', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('406', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 14', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('407', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 5', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('408', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 13', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('409', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 18', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:29');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('410', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 4', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('411', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 11', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:39');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('412', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 16', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('413', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 19', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:48');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('414', '1', 'DELETE_GURU', 'Menghapus Data Guru ID: 17', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:04:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('415', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 6', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:06:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('416', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 7', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:07:00');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('417', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 8', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:07:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('418', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 9', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:07:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('419', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 10', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:07:41');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('420', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 12', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:07:51');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('421', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 11', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:08:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('422', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 13', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:08:35');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('423', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 14', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:39:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('424', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 15', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:41:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('425', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 16', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:42:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('426', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 17', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:42:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('427', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 8', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:43:12');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('428', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 18', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:43:25');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('429', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 19', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:43:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('430', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 20', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:44:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('431', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 21', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:44:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('432', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 22', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:45:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('433', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 23', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:45:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('434', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 24', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:45:29');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('435', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 25', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:45:40');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('436', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 26', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:46:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('437', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 27', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:46:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('438', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 28', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:46:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('439', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 29', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:46:51');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('440', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 30', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:47:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('441', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 31', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:47:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('442', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 1', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:58:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('443', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 2', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:58:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('444', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 5', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:58:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('445', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 6', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:00:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('446', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 7', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:00:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('447', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 8', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:01:08');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('448', '1', 'UPDATE_KELAS', 'Memperbarui kelas ID: 8', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:01:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('449', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Nilnaminach Ziyadatul \'Ishma', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:02:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('450', '1', 'UPDATE_GURU', 'Memperbarui Data Guru: Nur Arifah Dzul Qo\'dah', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:02:39');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('451', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260824-0001', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:13:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('452', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 21 untuk Jurnal: JRN-20260824-0001', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:13:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('453', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X A Mapel: ASWAJA PROGRESIF', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:13:57');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('454', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260824-0002', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:15:07');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('455', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 22 untuk Jurnal: JRN-20260824-0002', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:15:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('456', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X B Mapel: ASWAJA PROGRESIF', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:16:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('457', '1', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260824-0003', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:17:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('458', '1', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 23 untuk Jurnal: JRN-20260824-0003', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:17:17');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('459', '1', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: XI A Mapel: Bahasa Arab', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:17:42');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('460', '29', 'LOGIN_SUCCESS', 'User fakhrurrozi0496 (Kepala Madrasah) berhasil login.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:44:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('461', '29', 'LOGOUT', 'User fakhrurrozi0496 logout.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:51:47');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('462', '25', 'LOGIN_SUCCESS', 'User rufi (Wali Kelas) berhasil login.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:52:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('463', '25', 'LOGOUT', 'User rufi logout.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:55:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('464', '35', 'LOGIN_SUCCESS', 'User dzulqodah06 (Guru Mata Pelajaran) berhasil login.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:55:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('465', '35', 'LOGOUT', 'User dzulqodah06 logout.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:56:18');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('466', '36', 'LOGIN_SUCCESS', 'User nurindaha97 (Waka Kurikulum) berhasil login.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:56:55');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('467', '28', 'LOGIN_SUCCESS', 'User n.elmiatun (Wali Kelas) berhasil login.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:04:38');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('468', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 25', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:12:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('469', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 25', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:13:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('470', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 25', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:13:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('471', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 25', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:13:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('472', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 25', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:13:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('473', '28', 'LOGOUT', 'User n.elmiatun logout.', '158.140.163.64', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:15:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('474', '28', 'LOGIN_SUCCESS', 'User n.elmiatun (Wali Kelas) berhasil login.', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:17:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('475', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 6', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:18:32');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('476', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 7', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:18:50');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('477', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 8', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:19:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('478', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 9', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:19:44');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('479', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 10', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:20:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('480', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 11', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:20:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('481', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 12', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:21:04');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('482', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 13', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:21:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('483', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 14', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:21:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('484', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 15', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:21:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('485', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 16', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:22:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('486', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 17', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:22:41');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('487', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 18', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:23:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('488', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 19', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:23:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('489', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 20', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:23:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('490', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 21', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:23:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('491', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 22', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:24:21');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('492', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 23', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:24:35');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('493', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 24', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:24:56');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('494', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 26', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:25:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('495', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 27', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:25:30');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('496', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 28', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:26:02');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('497', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 29', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:26:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('498', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 30', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:26:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('499', '1', 'UPDATE_MAPEL', 'Memperbarui Mapel ID: 31', '2400:9800:ca0:348e:61cf:5439:4810:4c48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 14:26:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('500', '1', 'LOGOUT', 'User admin logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:07:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('501', '29', 'LOGIN_SUCCESS', 'User fakhrurrozi0496 (Kepala Madrasah) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:07:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('502', '29', 'LOGOUT', 'User fakhrurrozi0496 logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:07:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('503', '36', 'LOGIN_SUCCESS', 'User nurindaha97 (Waka Kurikulum) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:08:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('504', '36', 'LOGOUT', 'User nurindaha97 logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:08:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('505', '29', 'LOGIN_SUCCESS', 'User fakhrurrozi0496 (Kepala Madrasah) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:08:51');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('506', '29', 'LOGOUT', 'User fakhrurrozi0496 logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:11:10');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('507', '36', 'LOGIN_SUCCESS', 'User nurindaha97 (Waka Kurikulum) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:11:13');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('508', '36', 'LOGOUT', 'User nurindaha97 logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:11:58');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('509', NULL, 'LOGIN_FAILED', 'Percobaan login gagal untuk identity: madjidwafa25', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:12:01');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('510', '24', 'LOGIN_SUCCESS', 'User madjidwafa25 (Wali Kelas) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:12:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('511', '24', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260824-0004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:20:13');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('512', '24', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 24 untuk Jurnal: JRN-20260824-0004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:21:29');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('513', '24', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X A Mapel: PJOK', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:21:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('514', '24', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260824-0005', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:26:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('515', '24', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 25 untuk Jurnal: JRN-20260824-0005', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:26:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('516', '24', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X B Mapel: PJOK', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:26:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('517', '24', 'LOGOUT', 'User madjidwafa25 logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:27:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('518', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:27:21');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('519', '1', 'LOGOUT', 'User admin logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:30:14');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('520', '30', 'LOGIN_SUCCESS', 'User hhauradf25 (Super Admin) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:30:19');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('521', '30', 'UPDATE_SETTINGS', 'Memperbarui Pengaturan Sistem & Format Laporan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:47:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('522', '30', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260824-0006', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:56:38');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('523', '30', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 26 untuk Jurnal: JRN-20260824-0006', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:56:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('524', '30', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: XI B Mapel: KODING AI', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 12:56:50');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('525', '30', 'LOGOUT', 'User hhauradf25 logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:23:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('526', '24', 'LOGIN_SUCCESS', 'User madjidwafa25 (Wali Kelas) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:37:07');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('527', '24', 'LOGOUT', 'User madjidwafa25 logout.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:37:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('528', '38', 'LOGIN_SUCCESS', 'User cahyakumala2002 (Guru Mata Pelajaran) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:37:37');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('529', '38', 'CREATE_JURNAL', 'Membuat Jurnal Kode: JRN-20260824-0007', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:45:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('530', '38', 'CREATE_PRESENSI_KELAS', 'Membuat Presensi Kelas ID: 27 untuk Jurnal: JRN-20260824-0007', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:46:08');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('531', '38', 'INPUT_PRESENSI_SISWA', 'Menginput presensi siswa untuk Kelas: X B Mapel: INFORMATIKA', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-24 13:46:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('532', '30', 'LOGIN_SUCCESS', 'User hhauradf25 (Super Admin) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-29 12:06:18');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('533', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-29 12:17:12');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES ('534', '1', 'LOGIN_SUCCESS', 'User admin (Administrator) berhasil login.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-31 02:11:52');

DROP TABLE IF EXISTS `google_drive_sync`;
CREATE TABLE `google_drive_sync` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `local_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relative_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint NOT NULL DEFAULT '0',
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drive_file_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drive_folder_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_hash` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('SYNCHRONIZED','PENDING','FAILED','LOCAL_MISSING') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `last_synced_at` datetime DEFAULT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `original_file_size` bigint NOT NULL DEFAULT '0',
  `compressed_file_size` bigint NOT NULL DEFAULT '0',
  `compression_ratio` float NOT NULL DEFAULT '0',
  `is_compressed` tinyint(1) NOT NULL DEFAULT '0',
  `compression_quality` int NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `local_path` (`local_path`),
  KEY `idx_gds_status` (`status`),
  KEY `idx_gds_relpath` (`relative_path`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('1', 'assets/uploads/presensikelas/PK_DOC_23_1786968749.png', 'presensikelas/PK_DOC_23_1786968749.png', 'PK_DOC_23_1786968749.png', '212731', 'image/png', '1MNzy0lYaGj-I-1CpVHGE9Bg5LOsiUvmC', '1pC1kVGgj8A9M-2blwYjTpPy3ZPQ5xB1z', '86a850da97501fd2a1ebeb0f4cdea43c18f4faf05947fccf5c04a28aea81e1a8', 'SYNCHRONIZED', '2026-08-24 12:49:54', NULL, '2026-08-17 19:49:37', '2026-08-24 19:49:54', '212731', '138501', '34.9', '1', '85');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('2', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_11_1786968733.png', 'jurnal/JRN_DOC_20262027_Ganjil_11_1786968733.png', 'JRN_DOC_20262027_Ganjil_11_1786968733.png', '227150', 'image/png', '1oggw5JrC75x0h54dQ_A0z6tBRkTBsNaJ', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', 'cda651df4b4cf6b82d9a559192f802bf3fcdba1880cb3160ae479e8eb834cb23', 'SYNCHRONIZED', '2026-08-17 19:49:41', NULL, '2026-08-17 19:49:41', '2026-08-24 19:54:08', '392231', '227150', '42.1', '1', '85');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('3', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_12_1786970935.png', 'jurnal/JRN_DOC_20262027_Ganjil_12_1786970935.png', 'JRN_DOC_20262027_Ganjil_12_1786970935.png', '244653', 'image/png', '1FtxUFlrx98mVczTiWDbSq7COUCL3A05b', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', 'f60f0c7749e61accc381e0ac9d2c19fd1d1ab8cc9d5189c17990501be7ebb9cf', 'SYNCHRONIZED', '2026-08-17 19:49:45', NULL, '2026-08-17 19:49:45', '2026-08-24 19:54:08', '0', '0', '0', '0', '100');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('4', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_8_1786971059.png', 'jurnal/JRN_DOC_20262027_Ganjil_8_1786971059.png', 'JRN_DOC_20262027_Ganjil_8_1786971059.png', '244653', 'image/png', '1MhLVP6bSc2XlwiQmSPWr0ucMS19SKWIj', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', 'f60f0c7749e61accc381e0ac9d2c19fd1d1ab8cc9d5189c17990501be7ebb9cf', 'SYNCHRONIZED', '2026-08-17 19:51:31', NULL, '2026-08-17 19:51:31', '2026-08-24 19:54:08', '0', '0', '0', '0', '100');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('5', 'assets/uploads/presensikelas/PK_DOC_30_1786971276.png', 'presensikelas/PK_DOC_30_1786971276.png', 'PK_DOC_30_1786971276.png', '212731', 'image/png', '1T-i4nxmyyGoTdl1y7flFYql7KgqQxZHk', '1pC1kVGgj8A9M-2blwYjTpPy3ZPQ5xB1z', '86a850da97501fd2a1ebeb0f4cdea43c18f4faf05947fccf5c04a28aea81e1a8', 'SYNCHRONIZED', '2026-08-17 19:54:40', NULL, '2026-08-17 19:54:40', '2026-08-24 19:54:08', '0', '0', '0', '0', '100');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('6', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_15_1786971462.png', 'jurnal/JRN_DOC_20262027_Ganjil_15_1786971462.png', 'JRN_DOC_20262027_Ganjil_15_1786971462.png', '345417', 'image/png', '1h9cfYUJvXtVudXJwY1kMdrsDHTF8BWXS', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', '11ffa84f97b602d09e42bbfece0d5506d16aa6cf872895a7cfecf4d35afe2809', 'SYNCHRONIZED', '2026-08-17 20:01:37', NULL, '2026-08-17 20:01:37', '2026-08-24 19:54:08', '0', '0', '0', '0', '100');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('7', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_9_1786971752.png', 'jurnal/JRN_DOC_20262027_Ganjil_9_1786971752.png', 'JRN_DOC_20262027_Ganjil_9_1786971752.png', '1113088', 'image/png', '14KfvWVon_aHM_O-aEKwWgIbK9eXMHWnP', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', '39b0387dc7a4f9f486ad7ec7af3f7f00e5abd5a669ecc2065ad61300a5c33751', 'SYNCHRONIZED', '2026-08-17 20:02:37', NULL, '2026-08-17 20:02:37', '2026-08-24 19:54:08', '0', '0', '0', '0', '100');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('8', 'assets/uploads/presensikelas/PK_DOC_31_1786971799.png', 'presensikelas/PK_DOC_31_1786971799.png', 'PK_DOC_31_1786971799.png', '3350', 'image/png', '1BJE-UmuNJwFjiqNwvp49y8dOnT2sGLD4', '1pC1kVGgj8A9M-2blwYjTpPy3ZPQ5xB1z', '048dbb78383bb39f7fe9166c6a2b8787ed462b464678be0b3278fe40cb376b78', 'SYNCHRONIZED', '2026-08-17 20:03:22', NULL, '2026-08-17 20:03:22', '2026-08-24 19:54:08', '0', '0', '0', '0', '100');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('9', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_9_1787488360.jpg', 'jurnal/JRN_DOC_20262027_Ganjil_9_1787488360.jpg', 'JRN_DOC_20262027_Ganjil_9_1787488360.jpg', '510798', 'image/jpeg', '1BSE5p5kDapahleqO7bKIB7kLJxz0hX33', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', '706faa7b9925fa2bda981972dbed30efce07c029462c82679d7184a398cb5f70', 'SYNCHRONIZED', '2026-08-23 19:32:44', NULL, '2026-08-23 19:32:44', '2026-08-24 19:54:08', '2535047', '510798', '79.9', '1', '85');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('10', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_22_1787574003.jpg', 'jurnal/JRN_DOC_20262027_Ganjil_22_1787574003.jpg', 'JRN_DOC_20262027_Ganjil_22_1787574003.jpg', '510798', 'image/jpeg', '1L4g6NU39swbc7syRso2ezU7OE4eJ8ygm', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', '456f9d6d72a0931f4b982546341615dc78a98a762f59dad83a0a4ca041411e52', 'SYNCHRONIZED', '2026-08-24 12:20:13', NULL, '2026-08-24 19:20:13', '2026-08-24 19:54:08', '2535047', '510798', '79.9', '1', '85');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('11', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_22_1787574355.png', 'jurnal/JRN_DOC_20262027_Ganjil_22_1787574355.png', 'JRN_DOC_20262027_Ganjil_22_1787574355.png', '159357', 'image/png', '1dfAieIrE1O3xhGIL2kcO2_Clk8V-6bcY', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', '0bb4450e7e286518bba44b3eebbf0549fa7b8ada54f063e2d7b9c75422057320', 'SYNCHRONIZED', '2026-08-24 12:26:05', NULL, '2026-08-24 19:26:05', '2026-08-24 19:54:08', '354632', '159357', '55.1', '1', '65');
INSERT INTO `google_drive_sync` (`id`, `local_path`, `relative_path`, `file_name`, `file_size`, `mime_type`, `drive_file_id`, `drive_folder_id`, `file_hash`, `status`, `last_synced_at`, `error_message`, `created_at`, `updated_at`, `original_file_size`, `compressed_file_size`, `compression_ratio`, `is_compressed`, `compression_quality`) VALUES ('12', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_28_1787576188.png', 'jurnal/JRN_DOC_20262027_Ganjil_28_1787576188.png', 'JRN_DOC_20262027_Ganjil_28_1787576188.png', '132004', 'image/png', '1hbW_tyAb8aJvuQtnUXcBDzEu9Y1aZESS', '1w8AqsaylEvxkPU8p03-ebHZzBZ2TNTjT', '345ef0291e151399e92e5d208a1b45bc3212a21f114800db23ecc50de853a54d', 'SYNCHRONIZED', '2026-08-24 12:56:38', NULL, '2026-08-24 19:56:38', '2026-08-24 19:56:38', '132004', '132004', '0', '0', '100');

DROP TABLE IF EXISTS `guru`;
CREATE TABLE `guru` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar_depan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar_belakang` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jk` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kepegawaian` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'PNS',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip` (`nip`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk_guru_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('22', '24', '006', 'Abdul Madjid Wafa', NULL, 'S.Pd', 'L', '087754100872', 'madjidwafa25@gmail.com', 'GTT', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('23', '25', '010', 'Abi Lazkar Amar Ma\'rufi', NULL, 'S.Pd', 'L', '085100933336', 'rufiabi@gmail.com', 'GTT', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('24', '26', '004', 'Amin Adimas Putra', NULL, 'S.M', 'L', '0895341413115', 'adimasptra20@gmail.com', 'GTY', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('25', '27', '013', 'Arsy Bintang Ramadhani', NULL, 'S.Si', 'L', '089678432398', 'arsybintangramadhani@gmail.com', 'GTT', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('26', '28', '007', 'Elmiatun Nafiah', NULL, 'S.S., M.Pd', 'P', '082333569564', 'n.elmiatun@gmail.com', 'GTT', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('27', '29', '001', 'Fakhrur Rozi', NULL, 'S.Pd., Gr., M.Pd.', 'L', '085731447473', 'fakhrurrozi0496@gmail.com', 'GTY', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('28', '30', '005', 'Hanindria Haura Dzikra Fitranti', NULL, 'S.Pd', 'P', '085645890411', 'hhauradf25@gmail.com', 'PNS', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('29', '31', '008', 'Lazatin \'Aniqoh', NULL, 'S.Mat, M.Pd', 'P', '089608804987', 'lazatina97@gmail.com', 'GTT', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('30', '32', '012', 'M. Alifudin Ikhsan', NULL, 'S.Pd., Gr., M.Pd', 'L', '085645236525', 'um.alifudin93@gmail.com', 'GTT', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('31', '33', '003', 'Muhammad Ahsan Thoriq', NULL, 'M.Pd', 'L', '085730857585', 'ahsan.thoriq31@gmail.com', 'GTT', '2026-08-24 12:05:16', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('32', '34', '011', 'Nilnaminach Ziyadatul \'Ishma', '', 'S.Pd', 'P', '082229772324', 'nilnalminach452@gmail.com', 'GTT', '2026-08-24 12:05:16', '2026-08-24 13:02:16');
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('33', '35', '016', 'Nur Arifah Dzul Qo\'dah', '', 'M.Pd', 'P', '085731114737', 'dzulqodah06@gmail.com', 'GTT', '2026-08-24 12:05:16', '2026-08-24 13:02:39');
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('34', '36', '002', 'Nur Indah Agustina', 'Dr.', 'M.Pd', 'P', '085785519654', 'nurindaha97@gmail.com', 'GTY', '2026-08-24 12:05:17', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('35', '37', '009', 'Pratiwi Nur Zamzani', NULL, 'S.Pd., Gr., M.Pd', 'P', '081216380552', 'zamzanip@gmail.com', 'GTT', '2026-08-24 12:05:17', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('36', '38', '014', 'Rudy Cahya Kumala', NULL, 'S.Kom', 'L', '089673472054', 'cahyakumala2002@gmail.com', 'GTT', '2026-08-24 12:05:17', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('37', '39', '017', 'Siti Aminatuz Zuhroh', NULL, 'S.Pd', 'P', '081232613293', 'zuhrohamina0@gmail.com', 'GTT', '2026-08-24 12:05:17', NULL);
INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_lengkap`, `gelar_depan`, `gelar_belakang`, `jk`, `no_hp`, `email`, `status_kepegawaian`, `created_at`, `updated_at`) VALUES ('38', '40', '015', 'Thalita Syahda Raniah', NULL, 'S.Pd', 'P', '081228884571', 'thalitasr7@gmail.com', 'GTT', '2026-08-24 12:05:17', NULL);

DROP TABLE IF EXISTS `guru_mapel`;
CREATE TABLE `guru_mapel` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guru_mapel_unique` (`guru_id`,`mapel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('1', '1', '1');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('2', '2', '2');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('21', '3', '6');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('29', '4', '7');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('33', '5', '10');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('34', '5', '11');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('47', '6', '8');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('48', '6', '9');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('49', '8', '31');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('17', '9', '25');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('23', '10', '19');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('22', '10', '20');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('30', '11', '13');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('32', '11', '14');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('31', '11', '15');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('43', '12', '17');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('44', '12', '18');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('26', '13', '16');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('24', '14', '12');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('16', '15', '21');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('35', '16', '22');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('36', '16', '23');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('40', '17', '24');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('27', '18', '26');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('28', '18', '27');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('37', '19', '28');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('39', '19', '29');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('38', '19', '30');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('50', '22', '31');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('51', '23', '17');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('52', '23', '18');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('53', '24', '8');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('54', '24', '9');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('55', '25', '21');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('56', '26', '25');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('57', '27', '6');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('58', '29', '19');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('59', '29', '20');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('79', '29', '32');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('60', '30', '12');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('61', '31', '10');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('62', '31', '11');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('76', '32', '16');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('77', '33', '26');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('78', '33', '27');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('66', '34', '7');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('67', '35', '13');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('68', '35', '14');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('69', '35', '15');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('70', '36', '22');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('71', '36', '23');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('72', '37', '28');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('73', '37', '29');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('74', '37', '30');
INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`) VALUES ('75', '38', '24');

DROP TABLE IF EXISTS `import_nilai_history`;
CREATE TABLE `import_nilai_history` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `import_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `jenis_penilaian` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penilaian` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imported_by` int unsigned NOT NULL,
  `total_records` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `import_code` (`import_code`),
  KEY `imported_by` (`imported_by`),
  CONSTRAINT `import_nilai_history_ibfk_1` FOREIGN KEY (`imported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `import_nilai_history` (`id`, `import_code`, `file_name`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `jenis_penilaian`, `nama_penilaian`, `imported_by`, `total_records`, `created_at`) VALUES ('1', 'IMP-1784731847-7666', 'Template_Nilai_X_A_FIS-P_(1)2.xlsx', '3', '1', '2', 'catatan', 'Bab 2', '1', '10', '2026-07-22 21:50:47');

DROP TABLE IF EXISTS `jadwal_pelajaran`;
CREATE TABLE `jadwal_pelajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `guru_id` int unsigned NOT NULL,
  `ruangan_id` int unsigned DEFAULT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai_ke` tinyint unsigned NOT NULL,
  `jam_selesai_ke` tinyint unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_jadwal_tp` (`tahun_pelajaran_id`),
  KEY `fk_jadwal_kelas` (`kelas_id`),
  KEY `fk_jadwal_mapel` (`mapel_id`),
  KEY `fk_jadwal_guru` (`guru_id`),
  KEY `fk_jadwal_ruangan` (`ruangan_id`),
  CONSTRAINT `fk_jadwal_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jadwal_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jadwal_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jadwal_ruangan` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_jadwal_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('3', '3', '1', '7', '34', '3', 'Senin', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('4', '3', '1', '28', '37', '3', 'Senin', '3', '5', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('5', '3', '1', '22', '36', '3', 'Senin', '6', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('6', '3', '1', '16', '32', '3', 'Senin', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('7', '3', '1', '27', '33', '3', 'Selasa', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('8', '3', '1', '30', '37', '3', 'Selasa', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('9', '3', '1', '13', '35', '3', 'Selasa', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('10', '3', '1', '10', '31', '3', 'Selasa', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('11', '3', '1', '21', '25', '3', 'Rabu', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('12', '3', '1', '10', '31', '3', 'Rabu', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('13', '3', '1', '27', '33', '3', 'Rabu', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('14', '3', '1', '32', '29', '3', 'Rabu', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('15', '3', '1', '8', '24', '3', 'Kamis', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('16', '3', '1', '28', '37', '3', 'Kamis', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('17', '3', '1', '19', '29', '3', 'Kamis', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('18', '3', '1', '9', '24', '3', 'Kamis', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('19', '3', '1', '31', '22', '3', 'Jumat', '1', '3', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('20', '3', '1', '25', '26', '3', 'Jumat', '4', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('21', '3', '1', '17', '23', '3', 'Jumat', '7', '8', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('22', '3', '2', '27', '33', '6', 'Senin', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('23', '3', '2', '16', '32', '6', 'Senin', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('24', '3', '2', '7', '34', '6', 'Senin', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('25', '3', '2', '28', '37', '6', 'Senin', '7', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('26', '3', '2', '21', '25', '6', 'Selasa', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('27', '3', '2', '8', '24', '6', 'Selasa', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('28', '3', '2', '10', '31', '6', 'Selasa', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('29', '3', '2', '19', '29', '6', 'Selasa', '7', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('30', '3', '2', '22', '36', '6', 'Rabu', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('31', '3', '2', '17', '23', '6', 'Rabu', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('32', '3', '2', '13', '35', '6', 'Rabu', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('33', '3', '2', '10', '31', '6', 'Rabu', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('34', '3', '2', '30', '37', '6', 'Kamis', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('35', '3', '2', '27', '33', '6', 'Kamis', '3', '5', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('36', '3', '2', '9', '24', '6', 'Kamis', '6', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('37', '3', '2', '28', '37', '6', 'Kamis', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('38', '3', '2', '25', '26', '6', 'Jumat', '1', '3', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('39', '3', '2', '31', '22', '6', 'Jumat', '4', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('40', '3', '2', '32', '29', '6', 'Jumat', '7', '8', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('41', '3', '5', '19', '29', '4', 'Senin', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('42', '3', '5', '26', '33', '4', 'Senin', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('43', '3', '5', '13', '35', '4', 'Senin', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('44', '3', '5', '21', '25', '4', 'Senin', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('45', '3', '5', '31', '22', '4', 'Selasa', '1', '3', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('46', '3', '5', '16', '32', '4', 'Selasa', '4', '5', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('47', '3', '5', '8', '24', '4', 'Selasa', '6', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('48', '3', '5', '7', '34', '4', 'Selasa', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('49', '3', '5', '7', '34', '4', 'Rabu', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('50', '3', '5', '29', '37', '4', 'Rabu', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('51', '3', '5', '18', '23', '4', 'Rabu', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('52', '3', '5', '14', '35', '4', 'Rabu', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('53', '3', '5', '10', '31', '4', 'Kamis', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('54', '3', '5', '15', '35', '4', 'Kamis', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('55', '3', '5', '25', '26', '4', 'Kamis', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('56', '3', '5', '21', '25', '4', 'Kamis', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('57', '3', '5', '18', '23', '4', 'Jumat', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('58', '3', '5', '20', '29', '4', 'Jumat', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('59', '3', '5', '16', '32', '4', 'Jumat', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('60', '3', '5', '23', '36', '4', 'Jumat', '7', '8', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('61', '3', '6', '21', '25', '7', 'Senin', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('62', '3', '6', '7', '34', '7', 'Senin', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('63', '3', '6', '25', '26', '7', 'Senin', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('64', '3', '6', '8', '24', '7', 'Senin', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('65', '3', '6', '18', '23', '7', 'Selasa', '1', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('66', '3', '6', '31', '22', '7', 'Selasa', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('67', '3', '6', '29', '37', '7', 'Selasa', '7', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('68', '3', '6', '15', '35', '7', 'Selasa', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('69', '3', '6', '19', '29', '7', 'Rabu', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('70', '3', '6', '14', '35', '7', 'Rabu', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('71', '3', '6', '29', '37', '7', 'Rabu', '5', '5', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('72', '3', '6', '7', '34', '7', 'Rabu', '6', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('73', '3', '6', '21', '25', '7', 'Rabu', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('74', '3', '6', '16', '32', '7', 'Kamis', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('75', '3', '6', '10', '31', '7', 'Kamis', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('76', '3', '6', '13', '35', '7', 'Kamis', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('77', '3', '6', '18', '23', '7', 'Kamis', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('78', '3', '6', '20', '29', '7', 'Jumat', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('79', '3', '6', '16', '32', '7', 'Jumat', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('80', '3', '6', '23', '36', '7', 'Jumat', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('81', '3', '6', '26', '33', '7', 'Jumat', '7', '8', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('82', '3', '7', '12', '30', '5', 'Senin', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('83', '3', '7', '19', '29', '5', 'Senin', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('84', '3', '7', '24', '38', '5', 'Senin', '5', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('85', '3', '7', '27', '33', '5', 'Senin', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('86', '3', '7', '6', '27', '5', 'Selasa', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('87', '3', '7', '25', '26', '5', 'Selasa', '3', '5', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('88', '3', '7', '21', '25', '5', 'Selasa', '6', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('89', '3', '7', '16', '32', '5', 'Selasa', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('90', '3', '7', '31', '22', '5', 'Rabu', '1', '3', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('91', '3', '7', '7', '34', '5', 'Rabu', '4', '5', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('92', '3', '7', '16', '32', '5', 'Rabu', '6', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('93', '3', '7', '29', '37', '5', 'Rabu', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('94', '3', '7', '7', '34', '5', 'Kamis', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('95', '3', '7', '17', '23', '5', 'Kamis', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('96', '3', '7', '23', '36', '5', 'Kamis', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('97', '3', '7', '27', '33', '5', 'Kamis', '7', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('98', '3', '7', '8', '24', '5', 'Jumat', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('99', '3', '7', '11', '31', '5', 'Jumat', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('100', '3', '7', '20', '29', '5', 'Jumat', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('101', '3', '7', '21', '25', '5', 'Jumat', '7', '8', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('102', '3', '8', '24', '38', '8', 'Senin', '1', '3', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('103', '3', '8', '21', '25', '8', 'Senin', '4', '5', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('104', '3', '8', '27', '33', '8', 'Senin', '6', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('105', '3', '8', '19', '29', '8', 'Senin', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('106', '3', '8', '12', '30', '8', 'Selasa', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('107', '3', '8', '10', '31', '8', 'Selasa', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('108', '3', '8', '7', '34', '8', 'Selasa', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('109', '3', '8', '25', '26', '8', 'Selasa', '7', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('110', '3', '8', '27', '33', '8', 'Rabu', '1', '3', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('111', '3', '8', '31', '22', '8', 'Rabu', '4', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('112', '3', '8', '29', '37', '8', 'Rabu', '7', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('113', '3', '8', '16', '32', '8', 'Rabu', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('114', '3', '8', '20', '29', '8', 'Kamis', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('115', '3', '8', '7', '34', '8', 'Kamis', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('116', '3', '8', '17', '23', '8', 'Kamis', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('117', '3', '8', '29', '37', '8', 'Kamis', '7', '7', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('118', '3', '8', '23', '36', '8', 'Kamis', '8', '9', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('119', '3', '8', '21', '25', '8', 'Jumat', '1', '2', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('120', '3', '8', '8', '24', '8', 'Jumat', '3', '4', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('121', '3', '8', '11', '31', '8', 'Jumat', '5', '6', '2026-08-31 09:35:31', NULL);
INSERT INTO `jadwal_pelajaran` (`id`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `ruangan_id`, `hari`, `jam_mulai_ke`, `jam_selesai_ke`, `created_at`, `updated_at`) VALUES ('122', '3', '8', '16', '32', '8', 'Jumat', '7', '8', '2026-08-31 09:35:31', NULL);

DROP TABLE IF EXISTS `jam_pelajaran`;
CREATE TABLE `jam_pelajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `jam_ke` tinyint unsigned NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jam_ke` (`jam_ke`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('1', '1', '07:45:00', '08:20:00', '2026-07-20 18:04:03');
INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('2', '2', '08:20:00', '08:55:00', '2026-07-20 18:04:03');
INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('3', '3', '08:55:00', '09:30:00', '2026-07-20 18:04:03');
INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('4', '4', '09:30:00', '10:15:00', '2026-07-20 18:04:03');
INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('5', '5', '10:25:00', '11:00:00', '2026-08-15 20:45:17');
INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('6', '7', '11:35:00', '12:10:00', '2026-08-15 20:45:50');
INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('7', '6', '11:00:00', '11:35:00', '2026-08-15 20:46:43');
INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('8', '8', '12:25:00', '13:00:00', '2026-08-15 20:47:11');
INSERT INTO `jam_pelajaran` (`id`, `jam_ke`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES ('9', '9', '13:00:00', '13:35:00', '2026-08-15 20:47:43');

DROP TABLE IF EXISTS `jurnal_guru`;
CREATE TABLE `jurnal_guru` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `perangkat_ajar_id` int unsigned DEFAULT NULL,
  `kode_jurnal` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `guru_id` int unsigned NOT NULL,
  `jam_ke` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertemuan_ke` int unsigned DEFAULT NULL,
  `materi_pembelajaran` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `capaian_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `tujuan_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `sub_materi` text COLLATE utf8mb4_unicode_ci,
  `metode_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `model_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `media_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `sumber_belajar` text COLLATE utf8mb4_unicode_ci,
  `bentuk_penilaian` text COLLATE utf8mb4_unicode_ci,
  `alokasi_waktu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indikator_tp` text COLLATE utf8mb4_unicode_ci,
  `catatan_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `refleksi_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `kendala` text COLLATE utf8mb4_unicode_ci,
  `solusi` text COLLATE utf8mb4_unicode_ci,
  `hambatan_solusi` text COLLATE utf8mb4_unicode_ci,
  `file_dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Draft','Submitted','Validated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Submitted',
  `created_by` int unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_jurnal` (`kode_jurnal`),
  KEY `fk_jurnal_tp` (`tahun_pelajaran_id`),
  KEY `fk_jurnal_mapel` (`mapel_id`),
  KEY `fk_jurnal_user` (`created_by`),
  KEY `idx_jurnal_tanggal` (`tanggal`),
  KEY `idx_jurnal_kelas_mapel` (`kelas_id`,`mapel_id`),
  KEY `fk_jurnal_perangkat` (`perangkat_ajar_id`),
  KEY `idx_jurnal_guru_tp` (`guru_id`,`tahun_pelajaran_id`),
  CONSTRAINT `fk_jurnal_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jurnal_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jurnal_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jurnal_perangkat` FOREIGN KEY (`perangkat_ajar_id`) REFERENCES `perangkat_ajar` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_jurnal_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jurnal_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `jurnal_guru` (`id`, `perangkat_ajar_id`, `kode_jurnal`, `tanggal`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `jam_ke`, `pertemuan_ke`, `materi_pembelajaran`, `capaian_pembelajaran`, `tujuan_pembelajaran`, `sub_materi`, `metode_pembelajaran`, `model_pembelajaran`, `media_pembelajaran`, `sumber_belajar`, `bentuk_penilaian`, `alokasi_waktu`, `indikator_tp`, `catatan_pembelajaran`, `refleksi_pembelajaran`, `kendala`, `solusi`, `hambatan_solusi`, `file_dokumentasi`, `file_video`, `status`, `created_by`, `created_at`, `updated_at`) VALUES ('35', NULL, 'JRN-20260824-0001', '2026-08-24', '3', '1', '17', '23', '1-2', '1', 'YTYY', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'Submitted', '1', '2026-08-24 13:13:03', NULL);
INSERT INTO `jurnal_guru` (`id`, `perangkat_ajar_id`, `kode_jurnal`, `tanggal`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `jam_ke`, `pertemuan_ke`, `materi_pembelajaran`, `capaian_pembelajaran`, `tujuan_pembelajaran`, `sub_materi`, `metode_pembelajaran`, `model_pembelajaran`, `media_pembelajaran`, `sumber_belajar`, `bentuk_penilaian`, `alokasi_waktu`, `indikator_tp`, `catatan_pembelajaran`, `refleksi_pembelajaran`, `kendala`, `solusi`, `hambatan_solusi`, `file_dokumentasi`, `file_video`, `status`, `created_by`, `created_at`, `updated_at`) VALUES ('36', NULL, 'JRN-20260824-0002', '2026-08-23', '3', '2', '26', '23', '3', '2', 'YTYY', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'Submitted', '1', '2026-08-24 13:15:07', NULL);
INSERT INTO `jurnal_guru` (`id`, `perangkat_ajar_id`, `kode_jurnal`, `tanggal`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `jam_ke`, `pertemuan_ke`, `materi_pembelajaran`, `capaian_pembelajaran`, `tujuan_pembelajaran`, `sub_materi`, `metode_pembelajaran`, `model_pembelajaran`, `media_pembelajaran`, `sumber_belajar`, `bentuk_penilaian`, `alokasi_waktu`, `indikator_tp`, `catatan_pembelajaran`, `refleksi_pembelajaran`, `kendala`, `solusi`, `hambatan_solusi`, `file_dokumentasi`, `file_video`, `status`, `created_by`, `created_at`, `updated_at`) VALUES ('37', NULL, 'JRN-20260824-0003', '2026-08-22', '3', '5', '6', '31', '5-6', '3', 'YTYY', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'Submitted', '1', '2026-08-24 13:17:04', NULL);
INSERT INTO `jurnal_guru` (`id`, `perangkat_ajar_id`, `kode_jurnal`, `tanggal`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `jam_ke`, `pertemuan_ke`, `materi_pembelajaran`, `capaian_pembelajaran`, `tujuan_pembelajaran`, `sub_materi`, `metode_pembelajaran`, `model_pembelajaran`, `media_pembelajaran`, `sumber_belajar`, `bentuk_penilaian`, `alokasi_waktu`, `indikator_tp`, `catatan_pembelajaran`, `refleksi_pembelajaran`, `kendala`, `solusi`, `hambatan_solusi`, `file_dokumentasi`, `file_video`, `status`, `created_by`, `created_at`, `updated_at`) VALUES ('38', NULL, 'JRN-20260824-0004', '2026-08-24', '3', '1', '31', '22', '1-3', '1', 'asd', 'ad', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd | asd', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_22_1787574003.jpg', NULL, 'Submitted', '24', '2026-08-24 19:20:13', NULL);
INSERT INTO `jurnal_guru` (`id`, `perangkat_ajar_id`, `kode_jurnal`, `tanggal`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `jam_ke`, `pertemuan_ke`, `materi_pembelajaran`, `capaian_pembelajaran`, `tujuan_pembelajaran`, `sub_materi`, `metode_pembelajaran`, `model_pembelajaran`, `media_pembelajaran`, `sumber_belajar`, `bentuk_penilaian`, `alokasi_waktu`, `indikator_tp`, `catatan_pembelajaran`, `refleksi_pembelajaran`, `kendala`, `solusi`, `hambatan_solusi`, `file_dokumentasi`, `file_video`, `status`, `created_by`, `created_at`, `updated_at`) VALUES ('39', NULL, 'JRN-20260824-0005', '2026-08-24', '3', '2', '31', '22', '4-6', '1', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd | asd', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_22_1787574355.png', NULL, 'Submitted', '24', '2026-08-24 19:26:05', NULL);
INSERT INTO `jurnal_guru` (`id`, `perangkat_ajar_id`, `kode_jurnal`, `tanggal`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `jam_ke`, `pertemuan_ke`, `materi_pembelajaran`, `capaian_pembelajaran`, `tujuan_pembelajaran`, `sub_materi`, `metode_pembelajaran`, `model_pembelajaran`, `media_pembelajaran`, `sumber_belajar`, `bentuk_penilaian`, `alokasi_waktu`, `indikator_tp`, `catatan_pembelajaran`, `refleksi_pembelajaran`, `kendala`, `solusi`, `hambatan_solusi`, `file_dokumentasi`, `file_video`, `status`, `created_by`, `created_at`, `updated_at`) VALUES ('40', NULL, 'JRN-20260824-0006', '2026-08-24', '3', '6', '23', '28', '1-2', '1', 'asd', 'asd', 'asd', 'ad', 'asd', 'asd', 'ad', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'ad', 'asd | ad', 'assets/uploads/jurnal/JRN_DOC_20262027_Ganjil_28_1787576188.png', NULL, 'Submitted', '30', '2026-08-24 19:56:38', NULL);
INSERT INTO `jurnal_guru` (`id`, `perangkat_ajar_id`, `kode_jurnal`, `tanggal`, `tahun_pelajaran_id`, `kelas_id`, `mapel_id`, `guru_id`, `jam_ke`, `pertemuan_ke`, `materi_pembelajaran`, `capaian_pembelajaran`, `tujuan_pembelajaran`, `sub_materi`, `metode_pembelajaran`, `model_pembelajaran`, `media_pembelajaran`, `sumber_belajar`, `bentuk_penilaian`, `alokasi_waktu`, `indikator_tp`, `catatan_pembelajaran`, `refleksi_pembelajaran`, `kendala`, `solusi`, `hambatan_solusi`, `file_dokumentasi`, `file_video`, `status`, `created_by`, `created_at`, `updated_at`) VALUES ('41', NULL, 'JRN-20260824-0007', '2026-08-24', '3', '2', '22', '36', '1-2', '1', 'ad', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', '', '', '', '', NULL, NULL, NULL, 'Submitted', '38', '2026-08-24 20:45:05', NULL);

DROP TABLE IF EXISTS `jurnal_poin_keaktifan`;
CREATE TABLE `jurnal_poin_keaktifan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `jurnal_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `guru_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `poin` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_jurnal_siswa` (`jurnal_id`,`siswa_id`),
  KEY `fk_jpk_mapel` (`mapel_id`),
  KEY `idx_jpk_tanggal` (`tanggal`),
  KEY `idx_jpk_siswa_tgl` (`siswa_id`,`tanggal`),
  KEY `idx_jpk_kelas_tgl` (`kelas_id`,`tanggal`),
  KEY `idx_jpk_guru_tgl` (`guru_id`,`tanggal`),
  CONSTRAINT `fk_jpk_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jpk_jurnal` FOREIGN KEY (`jurnal_id`) REFERENCES `jurnal_guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jpk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jpk_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_jpk_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `jurnal_poin_keaktifan` (`id`, `jurnal_id`, `siswa_id`, `guru_id`, `mapel_id`, `kelas_id`, `tanggal`, `poin`, `created_at`, `updated_at`) VALUES ('1', '39', '322', '22', '31', '2', '2026-08-24', '1', '2026-08-24 12:27:00', NULL);
INSERT INTO `jurnal_poin_keaktifan` (`id`, `jurnal_id`, `siswa_id`, `guru_id`, `mapel_id`, `kelas_id`, `tanggal`, `poin`, `created_at`, `updated_at`) VALUES ('2', '39', '329', '22', '31', '2', '2026-08-24', '1', '2026-08-24 12:27:02', NULL);
INSERT INTO `jurnal_poin_keaktifan` (`id`, `jurnal_id`, `siswa_id`, `guru_id`, `mapel_id`, `kelas_id`, `tanggal`, `poin`, `created_at`, `updated_at`) VALUES ('3', '41', '321', '36', '22', '2', '2026-08-24', '1', '2026-08-24 13:50:16', NULL);
INSERT INTO `jurnal_poin_keaktifan` (`id`, `jurnal_id`, `siswa_id`, `guru_id`, `mapel_id`, `kelas_id`, `tanggal`, `poin`, `created_at`, `updated_at`) VALUES ('4', '41', '323', '36', '22', '2', '2026-08-24', '2', '2026-08-24 13:50:17', '2026-08-24 13:50:19');

DROP TABLE IF EXISTS `jurnal_walikelas`;
CREATE TABLE `jurnal_walikelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `wali_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` text COLLATE utf8mb4_unicode_ci,
  `pelaksanaan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Terealisasi','Belum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tahun_pelajaran_id` (`tahun_pelajaran_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `wali_id` (`wali_id`),
  CONSTRAINT `jurnal_walikelas_ibfk_1` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jurnal_walikelas_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jurnal_walikelas_ibfk_3` FOREIGN KEY (`wali_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `karya_pembelajaran`;
CREATE TABLE `karya_pembelajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `siswa_id` int unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tanggal` date NOT NULL,
  `materi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_karya` enum('Foto','Video','PDF','PowerPoint','Word','LKPD','Poster','Produk','Portofolio') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_publikasi` enum('Draft','Publik') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Draft',
  `status` enum('Draft','Submitted','Reviewed','Need Revision','Approved','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Draft',
  `version` int unsigned NOT NULL DEFAULT '1',
  `parent_id` int unsigned DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `catatan_revisi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `guru_id` (`guru_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `mapel_id` (`mapel_id`),
  KEY `fk_karya_siswa` (`siswa_id`),
  CONSTRAINT `fk_karya_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `karya_pembelajaran_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `karya_pembelajaran_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `karya_pembelajaran_ibfk_3` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kategori_penilaian`;
CREATE TABLE `kategori_penilaian` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` int NOT NULL DEFAULT '10',
  `tipe` enum('sistem','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'custom',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_kategori` (`kode_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kategori_penilaian` (`id`, `kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'catatan', 'Catatan', '7', 'sistem', '1', '2026-07-22 20:33:48', '2026-07-22 21:54:49');
INSERT INTO `kategori_penilaian` (`id`, `kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'tugas', 'Tugas', '15', 'sistem', '1', '2026-07-22 20:33:48', '2026-07-22 21:54:49');
INSERT INTO `kategori_penilaian` (`id`, `kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'uh', 'Ulangan Harian', '10', 'sistem', '1', '2026-07-22 20:33:48', '2026-07-22 21:54:49');
INSERT INTO `kategori_penilaian` (`id`, `kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'sts', 'STS', '15', 'sistem', '1', '2026-07-22 20:33:48', '2026-07-22 21:54:49');
INSERT INTO `kategori_penilaian` (`id`, `kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`, `created_at`, `updated_at`) VALUES ('5', 'praktik', 'Proyek', '15', 'sistem', '1', '2026-07-22 20:33:48', '2026-07-22 21:54:49');
INSERT INTO `kategori_penilaian` (`id`, `kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`, `created_at`, `updated_at`) VALUES ('6', 'portofolio', 'Portofolio', '15', 'sistem', '0', '2026-07-22 20:33:48', '2026-07-22 21:54:49');
INSERT INTO `kategori_penilaian` (`id`, `kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`, `created_at`, `updated_at`) VALUES ('7', 'asas', 'ASAS', '33', 'sistem', '1', '2026-07-22 21:52:23', '2026-07-22 21:54:49');
INSERT INTO `kategori_penilaian` (`id`, `kode_kategori`, `nama_kategori`, `bobot`, `tipe`, `is_active`, `created_at`, `updated_at`) VALUES ('8', 'sikap', 'Sikap', '5', 'sistem', '1', '2026-07-22 21:54:49', NULL);

DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('10','11','12') COLLATE utf8mb4_unicode_ci NOT NULL,
  `wali_kelas_id` int unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_kelas` (`kode_kelas`),
  KEY `fk_kelas_walikelas` (`wali_kelas_id`),
  CONSTRAINT `fk_kelas_walikelas` FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `tingkat`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES ('1', 'X-A', 'X A', '10', '22', '2026-07-20 18:04:03', '2026-08-24 12:58:19');
INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `tingkat`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES ('2', 'X-B', 'X B', '10', '26', '2026-07-20 18:04:03', '2026-08-24 12:58:30');
INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `tingkat`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES ('5', 'XI-A', 'XI A', '11', '29', '2026-07-20 18:29:01', '2026-08-24 12:58:45');
INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `tingkat`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES ('6', 'XI-B', 'XI B', '11', '35', '2026-07-20 18:29:01', '2026-08-24 13:00:15');
INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `tingkat`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES ('7', 'XII-A', 'XII A', '12', '23', '2026-07-20 18:29:01', '2026-08-24 13:00:45');
INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `tingkat`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES ('8', 'XII-B', 'XII B', '12', '32', '2026-07-20 18:29:01', '2026-08-24 13:01:08');

DROP TABLE IF EXISTS `kokurikuler`;
CREATE TABLE `kokurikuler` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `guru_id` int unsigned NOT NULL,
  `siswa_id` int unsigned DEFAULT NULL,
  `tema` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_tema` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktivitas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Draft','Terlaksana') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Draft',
  `output` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tahun_pelajaran_id` (`tahun_pelajaran_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `guru_id` (`guru_id`),
  KEY `fk_koku_siswa` (`siswa_id`),
  CONSTRAINT `fk_koku_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `kokurikuler_ibfk_1` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kokurikuler_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kokurikuler_ibfk_3` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempt_time` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_attempt_ip_user` (`ip_address`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('13', '158.140.163.95', 'superadmin', '1786076296');
INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('16', '110.136.89.128', 'wali2', '1786612618');
INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('17', '110.136.89.128', 'wali2', '1786612676');
INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('22', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'guru1', '1786713491');
INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('23', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'wali1', '1786713502');
INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('25', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Admin@123', '1786713640');
INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('26', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'admin@12345', '1786713661');
INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('27', '2400:9800:7c2:1e4a:62fe:bae9:f8b1:1913', 'Admin@12345', '1786713709');
INSERT INTO `login_attempts` (`id`, `ip_address`, `username`, `attempt_time`) VALUES ('30', '158.140.163.82', 'guru1', '1786786596');

DROP TABLE IF EXISTS `mapel_kelas`;
CREATE TABLE `mapel_kelas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mapel_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mk_mapel` (`mapel_id`),
  KEY `fk_mk_kelas` (`kelas_id`),
  CONSTRAINT `fk_mk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mk_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=372 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('276', '25', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('277', '25', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('278', '25', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('279', '25', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('280', '25', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('281', '25', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('282', '6', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('283', '6', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('284', '7', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('285', '7', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('286', '7', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('287', '7', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('288', '7', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('289', '7', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('290', '8', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('291', '8', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('292', '8', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('293', '8', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('294', '8', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('295', '8', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('296', '9', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('297', '9', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('298', '10', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('299', '10', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('300', '10', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('301', '10', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('302', '11', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('303', '11', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('304', '12', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('305', '12', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('306', '13', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('307', '13', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('308', '13', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('309', '13', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('310', '14', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('311', '14', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('312', '15', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('313', '15', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('314', '16', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('315', '16', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('316', '16', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('317', '16', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('318', '16', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('319', '16', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('320', '17', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('321', '17', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('322', '17', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('323', '17', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('324', '18', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('325', '18', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('326', '19', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('327', '19', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('328', '19', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('329', '19', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('330', '19', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('331', '19', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('332', '20', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('333', '20', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('334', '20', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('335', '20', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('336', '20', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('337', '20', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('338', '21', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('339', '21', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('340', '21', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('341', '21', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('342', '21', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('343', '21', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('344', '22', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('345', '22', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('346', '23', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('347', '23', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('348', '23', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('349', '23', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('350', '24', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('351', '24', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('352', '26', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('353', '26', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('354', '27', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('355', '27', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('356', '27', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('357', '27', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('358', '28', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('359', '28', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('360', '29', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('361', '29', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('362', '29', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('363', '29', '8');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('364', '30', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('365', '30', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('366', '31', '1');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('367', '31', '2');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('368', '31', '5');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('369', '31', '6');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('370', '31', '7');
INSERT INTO `mapel_kelas` (`id`, `mapel_id`, `kelas_id`) VALUES ('371', '31', '8');

DROP TABLE IF EXISTS `mata_pelajaran`;
CREATE TABLE `mata_pelajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_mapel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_mapel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelompok` enum('Wajib','Peminatan','Muatan Lokal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Wajib',
  `kkm` decimal(5,2) DEFAULT '75.00',
  `guru_id` int unsigned DEFAULT NULL,
  `kelas_id` int unsigned DEFAULT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ganjil',
  `tahun_pelajaran_id` int unsigned DEFAULT NULL,
  `status` enum('Aktif','Non-Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_mapel` (`kode_mapel`),
  KEY `fk_mapel_guru` (`guru_id`),
  KEY `fk_mapel_kelas` (`kelas_id`),
  KEY `fk_mapel_tp` (`tahun_pelajaran_id`),
  CONSTRAINT `fk_mapel_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_mapel_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_mapel_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('6', 'ARB 1', 'Bahasa Arab', 'Wajib', '70.00', '27', '5', 'Ganjil', '3', 'Aktif', '2026-08-15 20:22:02', '2026-08-24 14:18:32');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('7', 'KIM', 'KIMIA', 'Wajib', '70.00', '34', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:22:51', '2026-08-24 14:18:50');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('8', 'EKO', 'EKONOMI', 'Wajib', '70.00', '24', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:23:24', '2026-08-24 14:19:05');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('9', 'SR 1', 'SENI RUPA', 'Wajib', '70.00', '24', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:24:25', '2026-08-24 14:19:44');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('10', 'ARB 2', 'BAHASA ARAB', 'Wajib', '70.00', '31', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:25:04', '2026-08-24 14:20:01');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('11', 'SR 2', 'SENI RUPA', 'Wajib', '70.00', '31', '7', 'Ganjil', '3', 'Aktif', '2026-08-15 20:25:33', '2026-08-24 14:20:30');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('12', 'PP 1', 'PPKn', 'Wajib', '70.00', '30', '7', 'Ganjil', '3', 'Aktif', '2026-08-15 20:26:17', '2026-08-24 14:21:04');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('13', 'BIN 1', 'BAHASA INDONESIA', 'Wajib', '70.00', '35', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:26:54', '2026-08-24 14:21:23');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('14', 'SR 3', 'SENI RUPA', 'Wajib', '70.00', '35', '5', 'Ganjil', '3', 'Aktif', '2026-08-15 20:27:20', '2026-08-24 14:21:37');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('15', 'PP 2', 'PPKn', 'Wajib', '70.00', '35', '5', 'Ganjil', '3', 'Aktif', '2026-08-15 20:28:03', '2026-08-24 14:21:52');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('16', 'BIO', 'BIOLOGI', 'Wajib', '70.00', '32', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:29:00', '2026-08-24 14:22:16');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('17', 'AP 1', 'ASWAJA PROGRESIF', 'Muatan Lokal', '70.00', '23', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:30:03', '2026-08-24 14:22:41');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('18', 'PAI TP 1', 'PAI TERPADU', 'Wajib', '70.00', '23', '5', 'Ganjil', '3', 'Aktif', '2026-08-15 20:31:10', '2026-08-24 14:23:03');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('19', 'MAT WJB', 'MATEMATIKA WAJIB', 'Wajib', '70.00', '29', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:32:34', '2026-08-24 14:23:20');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('20', 'MAT TP', 'MATEMATIKA PEMINATAN', 'Wajib', '70.00', '29', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:36:28', '2026-08-24 14:23:37');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('21', 'FIS', 'FISIKA', 'Wajib', '70.00', '25', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:36:51', '2026-08-24 14:23:54');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('22', 'INFOR', 'INFORMATIKA', 'Wajib', '70.00', '36', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:37:26', '2026-08-24 14:24:21');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('23', 'KOD AI', 'KODING AI', 'Wajib', '70.00', '36', '5', 'Ganjil', '3', 'Aktif', '2026-08-15 20:38:06', '2026-08-24 14:24:35');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('24', 'BIN 2', 'BAHASA INDONESIA', 'Wajib', '70.00', '38', '7', 'Ganjil', '3', 'Aktif', '2026-08-15 20:39:03', '2026-08-24 14:24:56');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('25', 'BING', 'BAHASA INGGRIS', 'Wajib', '70.00', '26', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:39:31', '2026-08-24 14:12:58');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('26', 'AP 2', 'ASWAJA PROGRESIF', 'Muatan Lokal', '70.00', '33', '5', 'Ganjil', '3', 'Aktif', '2026-08-15 20:40:15', '2026-08-24 14:25:10');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('27', 'PAI TP 2', 'PAI TERPADU', 'Wajib', '70.00', '33', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:40:48', '2026-08-24 14:25:30');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('28', 'IPS TP', 'IPS TERPADU', 'Wajib', '70.00', '37', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:41:16', '2026-08-24 14:26:02');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('29', 'SI', 'SEJARAH INDONESIA', 'Wajib', '70.00', '37', '5', 'Ganjil', '3', 'Aktif', '2026-08-15 20:41:45', '2026-08-24 14:26:20');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('30', 'PP 3', 'PPKn', 'Wajib', '70.00', '37', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:42:13', '2026-08-24 14:26:34');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('31', 'PJOK', 'PJOK', 'Wajib', '70.00', '22', '1', 'Ganjil', '3', 'Aktif', '2026-08-15 20:42:36', '2026-08-24 14:26:46');
INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `kelompok`, `kkm`, `guru_id`, `kelas_id`, `semester`, `tahun_pelajaran_id`, `status`, `created_at`, `updated_at`) VALUES ('32', 'KWU', 'KEWIRAUSAHAAN', 'Wajib', '70.00', '29', '1', 'Ganjil', '3', 'Aktif', '2026-08-31 09:35:31', NULL);

DROP TABLE IF EXISTS `penanganan_siswa`;
CREATE TABLE `penanganan_siswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `wali_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `permasalahan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('Akademik','Disiplin','Perilaku','Kesehatan','Sosial') COLLATE utf8mb4_unicode_ci NOT NULL,
  `poin` int NOT NULL DEFAULT '0',
  `tindakan` text COLLATE utf8mb4_unicode_ci,
  `hasil` text COLLATE utf8mb4_unicode_ci,
  `rencana_tindak_lanjut` text COLLATE utf8mb4_unicode_ci,
  `dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Selesai','Proses','Monitoring') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Proses',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tahun_pelajaran_id` (`tahun_pelajaran_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `wali_id` (`wali_id`),
  CONSTRAINT `penanganan_siswa_ibfk_1` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penanganan_siswa_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penanganan_siswa_ibfk_3` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penanganan_siswa_ibfk_4` FOREIGN KEY (`wali_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `penilaian_siswa`;
CREATE TABLE `penilaian_siswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `guru_id` int unsigned NOT NULL,
  `jenis_penilaian` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penilaian` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` decimal(5,2) NOT NULL DEFAULT '0.00',
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_portofolio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rubrik_penilaian` text COLLATE utf8mb4_unicode_ci,
  `import_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_nilai_tp` (`tahun_pelajaran_id`),
  KEY `fk_nilai_mapel` (`mapel_id`),
  KEY `fk_nilai_guru` (`guru_id`),
  KEY `idx_penilaian_lookup` (`kelas_id`,`mapel_id`,`jenis_penilaian`),
  KEY `idx_penilaian_siswa` (`siswa_id`,`jenis_penilaian`),
  CONSTRAINT `fk_nilai_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nilai_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nilai_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nilai_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nilai_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `perangkat_ajar`;
CREATE TABLE `perangkat_ajar` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `guru_id` int unsigned NOT NULL,
  `jenis_perangkat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fase` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `elemen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capaian_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `tujuan_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `materi_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `sub_materi` text COLLATE utf8mb4_unicode_ci,
  `metode_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `model_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `media_pembelajaran` text COLLATE utf8mb4_unicode_ci,
  `sumber_belajar` text COLLATE utf8mb4_unicode_ci,
  `bentuk_penilaian` text COLLATE utf8mb4_unicode_ci,
  `alokasi_waktu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pertemuan_ke` int unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('Draft','Menunggu Verifikasi','Disetujui','Revisi','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Draft',
  `catatan_revisi` text COLLATE utf8mb4_unicode_ci,
  `version` int unsigned NOT NULL DEFAULT '1',
  `parent_id` int unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `verified_by` int unsigned DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_perangkat_mapel` (`mapel_id`),
  KEY `fk_perangkat_kelas` (`kelas_id`),
  KEY `fk_perangkat_guru` (`guru_id`),
  KEY `fk_perangkat_creator` (`created_by`),
  KEY `fk_perangkat_verifier` (`verified_by`),
  KEY `idx_perangkat_lookup` (`tahun_pelajaran_id`,`semester`,`mapel_id`,`guru_id`,`kelas_id`,`pertemuan_ke`),
  KEY `idx_perangkat_status` (`status_verifikasi`),
  KEY `idx_perangkat_active` (`is_active`,`is_archived`),
  CONSTRAINT `fk_perangkat_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_tp` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_perangkat_verifier` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `perkembangan_rekap`;
CREATE TABLE `perkembangan_rekap` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `wali_id` int unsigned NOT NULL,
  `kesimpulan_wali` text COLLATE utf8mb4_unicode_ci,
  `tindak_lanjut` text COLLATE utf8mb4_unicode_ci,
  `status_perkembangan` enum('Sangat Baik','Baik','Cukup','Kurang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_perkembangan_rekap` (`tahun_pelajaran_id`,`siswa_id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `wali_id` (`wali_id`),
  CONSTRAINT `perkembangan_rekap_ibfk_1` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perkembangan_rekap_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perkembangan_rekap_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perkembangan_rekap_ibfk_4` FOREIGN KEY (`wali_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `perkembangan_siswa`;
CREATE TABLE `perkembangan_siswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `guru_id` int unsigned NOT NULL,
  `catatan_perkembangan` text COLLATE utf8mb4_unicode_ci,
  `kelebihan` text COLLATE utf8mb4_unicode_ci,
  `kekurangan` text COLLATE utf8mb4_unicode_ci,
  `perilaku` text COLLATE utf8mb4_unicode_ci,
  `keaktifan` text COLLATE utf8mb4_unicode_ci,
  `kedisiplinan` text COLLATE utf8mb4_unicode_ci,
  `motivasi` text COLLATE utf8mb4_unicode_ci,
  `rekomendasi` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_perkembangan_siswa` (`tahun_pelajaran_id`,`siswa_id`,`mapel_id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `mapel_id` (`mapel_id`),
  KEY `guru_id` (`guru_id`),
  CONSTRAINT `perkembangan_siswa_ibfk_1` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perkembangan_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perkembangan_siswa_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perkembangan_siswa_ibfk_4` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perkembangan_siswa_ibfk_5` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `presensi_kelas`;
CREATE TABLE `presensi_kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `jurnal_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `guru_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `ruangan_id` int unsigned DEFAULT NULL,
  `pertemuan_ke` int unsigned NOT NULL DEFAULT '1',
  `status_pembelajaran` enum('Terlaksana','Tidak Terlaksana','Diganti','Daring','Luring','Gabungan Kelas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Terlaksana',
  `alasan_tidak_terlaksana` text COLLATE utf8mb4_unicode_ci,
  `dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_guru` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jurnal_id` (`jurnal_id`),
  KEY `fk_presensi_kelas_guru` (`guru_id`),
  KEY `fk_presensi_kelas_mapel` (`mapel_id`),
  KEY `fk_presensi_kelas_ruangan` (`ruangan_id`),
  KEY `idx_presensi_kelas_tanggal` (`tanggal`),
  KEY `idx_presensi_kelas_kelas_mapel` (`kelas_id`,`mapel_id`),
  CONSTRAINT `fk_presensi_kelas_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_kelas_jurnal` FOREIGN KEY (`jurnal_id`) REFERENCES `jurnal_guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_kelas_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_kelas_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_kelas_ruangan` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `presensi_kelas` (`id`, `jurnal_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `guru_id`, `mapel_id`, `kelas_id`, `ruangan_id`, `pertemuan_ke`, `status_pembelajaran`, `alasan_tidak_terlaksana`, `dokumentasi`, `catatan_guru`, `created_at`, `updated_at`) VALUES ('21', '35', '2026-08-24', '07:45:00', '08:55:00', '23', '17', '1', '3', '1', 'Terlaksana', NULL, NULL, '', '2026-08-24 13:13:31', NULL);
INSERT INTO `presensi_kelas` (`id`, `jurnal_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `guru_id`, `mapel_id`, `kelas_id`, `ruangan_id`, `pertemuan_ke`, `status_pembelajaran`, `alasan_tidak_terlaksana`, `dokumentasi`, `catatan_guru`, `created_at`, `updated_at`) VALUES ('22', '36', '2026-08-23', '08:55:00', '09:30:00', '23', '26', '2', '4', '2', 'Terlaksana', NULL, NULL, '', '2026-08-24 13:15:23', NULL);
INSERT INTO `presensi_kelas` (`id`, `jurnal_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `guru_id`, `mapel_id`, `kelas_id`, `ruangan_id`, `pertemuan_ke`, `status_pembelajaran`, `alasan_tidak_terlaksana`, `dokumentasi`, `catatan_guru`, `created_at`, `updated_at`) VALUES ('23', '37', '2026-08-22', '10:25:00', '11:35:00', '31', '6', '5', NULL, '2', 'Terlaksana', NULL, NULL, '', '2026-08-24 13:17:17', NULL);
INSERT INTO `presensi_kelas` (`id`, `jurnal_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `guru_id`, `mapel_id`, `kelas_id`, `ruangan_id`, `pertemuan_ke`, `status_pembelajaran`, `alasan_tidak_terlaksana`, `dokumentasi`, `catatan_guru`, `created_at`, `updated_at`) VALUES ('24', '38', '2026-08-24', '07:45:00', '09:30:00', '22', '31', '1', '3', '1', 'Terlaksana', NULL, NULL, '', '2026-08-24 19:21:29', NULL);
INSERT INTO `presensi_kelas` (`id`, `jurnal_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `guru_id`, `mapel_id`, `kelas_id`, `ruangan_id`, `pertemuan_ke`, `status_pembelajaran`, `alasan_tidak_terlaksana`, `dokumentasi`, `catatan_guru`, `created_at`, `updated_at`) VALUES ('25', '39', '2026-08-24', '09:30:00', '11:35:00', '22', '31', '2', '6', '1', 'Terlaksana', NULL, NULL, '', '2026-08-24 19:26:43', NULL);
INSERT INTO `presensi_kelas` (`id`, `jurnal_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `guru_id`, `mapel_id`, `kelas_id`, `ruangan_id`, `pertemuan_ke`, `status_pembelajaran`, `alasan_tidak_terlaksana`, `dokumentasi`, `catatan_guru`, `created_at`, `updated_at`) VALUES ('26', '40', '2026-08-24', '07:45:00', '08:55:00', '28', '23', '6', '7', '1', 'Terlaksana', NULL, NULL, '', '2026-08-24 19:56:45', NULL);
INSERT INTO `presensi_kelas` (`id`, `jurnal_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `guru_id`, `mapel_id`, `kelas_id`, `ruangan_id`, `pertemuan_ke`, `status_pembelajaran`, `alasan_tidak_terlaksana`, `dokumentasi`, `catatan_guru`, `created_at`, `updated_at`) VALUES ('27', '41', '2026-08-24', '07:45:00', '08:55:00', '36', '22', '2', '6', '1', 'Terlaksana', NULL, NULL, '', '2026-08-24 20:46:08', NULL);

DROP TABLE IF EXISTS `presensi_siswa`;
CREATE TABLE `presensi_siswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `presensi_kelas_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alpa','Terlambat','Dispen') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hadir',
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_izin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_presensi_kelas_siswa` (`presensi_kelas_id`,`siswa_id`),
  KEY `fk_presensi_siswa` (`siswa_id`),
  KEY `idx_presensi_status` (`status`),
  KEY `idx_presensi_lookup` (`presensi_kelas_id`,`status`),
  CONSTRAINT `fk_presensi_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presensi_siswa_kelas` FOREIGN KEY (`presensi_kelas_id`) REFERENCES `presensi_kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=471 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('324', '21', '301', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('325', '21', '302', '2026-08-24', 'Sakit', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('326', '21', '303', '2026-08-24', 'Izin', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('327', '21', '304', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('328', '21', '305', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('329', '21', '306', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('330', '21', '307', '2026-08-24', 'Sakit', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('331', '21', '308', '2026-08-24', 'Alpa', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('332', '21', '309', '2026-08-24', 'Terlambat', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('333', '21', '310', '2026-08-24', 'Sakit', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('334', '21', '311', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('335', '21', '312', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('336', '21', '313', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('337', '21', '314', '2026-08-24', 'Izin', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('338', '21', '315', '2026-08-24', 'Sakit', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('339', '21', '316', '2026-08-24', 'Terlambat', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('340', '21', '317', '2026-08-24', 'Alpa', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('341', '21', '318', '2026-08-24', 'Izin', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('342', '21', '319', '2026-08-24', 'Terlambat', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('343', '21', '320', '2026-08-24', 'Terlambat', '', NULL, '2026-08-24 13:13:57', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('344', '22', '321', '2026-08-23', 'Izin', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('345', '22', '322', '2026-08-23', 'Hadir', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('346', '22', '323', '2026-08-23', 'Sakit', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('347', '22', '324', '2026-08-23', 'Izin', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('348', '22', '325', '2026-08-23', 'Hadir', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('349', '22', '326', '2026-08-23', 'Sakit', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('350', '22', '327', '2026-08-23', 'Terlambat', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('351', '22', '328', '2026-08-23', 'Terlambat', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('352', '22', '329', '2026-08-23', 'Alpa', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('353', '22', '330', '2026-08-23', 'Izin', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('354', '22', '331', '2026-08-23', 'Sakit', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('355', '22', '332', '2026-08-23', 'Alpa', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('356', '22', '333', '2026-08-23', 'Alpa', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('357', '22', '334', '2026-08-23', 'Terlambat', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('358', '22', '335', '2026-08-23', 'Terlambat', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('359', '22', '336', '2026-08-23', 'Izin', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('360', '22', '337', '2026-08-23', 'Hadir', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('361', '22', '338', '2026-08-23', 'Hadir', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('362', '22', '339', '2026-08-23', 'Hadir', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('363', '22', '340', '2026-08-23', 'Hadir', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('364', '22', '341', '2026-08-23', 'Hadir', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('365', '22', '342', '2026-08-23', 'Hadir', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('366', '22', '343', '2026-08-23', 'Terlambat', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('367', '22', '344', '2026-08-23', 'Izin', '', NULL, '2026-08-24 13:16:02', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('368', '23', '345', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('369', '23', '346', '2026-08-22', 'Alpa', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('370', '23', '347', '2026-08-22', 'Alpa', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('371', '23', '348', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('372', '23', '349', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('373', '23', '350', '2026-08-22', 'Izin', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('374', '23', '352', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('375', '23', '354', '2026-08-22', 'Izin', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('376', '23', '357', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('377', '23', '358', '2026-08-22', 'Sakit', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('378', '23', '360', '2026-08-22', 'Terlambat', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('379', '23', '362', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('380', '23', '361', '2026-08-22', 'Izin', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('381', '23', '363', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('382', '23', '364', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('383', '23', '365', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('384', '23', '366', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('385', '23', '367', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('386', '23', '368', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('387', '23', '369', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('388', '23', '370', '2026-08-22', 'Izin', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('389', '23', '371', '2026-08-22', 'Sakit', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('390', '23', '372', '2026-08-22', 'Terlambat', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('391', '23', '375', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('392', '23', '376', '2026-08-22', 'Alpa', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('393', '23', '378', '2026-08-22', 'Izin', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('394', '23', '379', '2026-08-22', 'Hadir', '', NULL, '2026-08-24 13:17:42', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('395', '24', '301', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('396', '24', '302', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('397', '24', '303', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('398', '24', '304', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('399', '24', '305', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('400', '24', '306', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('401', '24', '307', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('402', '24', '308', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('403', '24', '309', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('404', '24', '310', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('405', '24', '311', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('406', '24', '312', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('407', '24', '313', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('408', '24', '314', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('409', '24', '315', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('410', '24', '316', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('411', '24', '317', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('412', '24', '318', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('413', '24', '319', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('414', '24', '320', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:21:34', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('415', '25', '321', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('416', '25', '322', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('417', '25', '323', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('418', '25', '324', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('419', '25', '325', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('420', '25', '326', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('421', '25', '327', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('422', '25', '328', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('423', '25', '329', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('424', '25', '330', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('425', '25', '331', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('426', '25', '332', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('427', '25', '333', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('428', '25', '334', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('429', '25', '335', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('430', '25', '336', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('431', '25', '337', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('432', '25', '338', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('433', '25', '339', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('434', '25', '340', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('435', '25', '341', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('436', '25', '342', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('437', '25', '343', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('438', '25', '344', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:26:49', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('439', '26', '351', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:56:50', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('440', '26', '353', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:56:50', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('441', '26', '355', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:56:50', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('442', '26', '356', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:56:50', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('443', '26', '359', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:56:50', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('444', '26', '373', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:56:50', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('445', '26', '374', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:56:50', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('446', '26', '377', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 19:56:50', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('447', '27', '321', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('448', '27', '322', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('449', '27', '323', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('450', '27', '324', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('451', '27', '325', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('452', '27', '326', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('453', '27', '327', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('454', '27', '328', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('455', '27', '329', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('456', '27', '330', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('457', '27', '331', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('458', '27', '332', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('459', '27', '333', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('460', '27', '334', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('461', '27', '335', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('462', '27', '336', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('463', '27', '337', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('464', '27', '338', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('465', '27', '339', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('466', '27', '340', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('467', '27', '341', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('468', '27', '342', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('469', '27', '343', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);
INSERT INTO `presensi_siswa` (`id`, `presensi_kelas_id`, `siswa_id`, `tanggal`, `status`, `catatan`, `bukti_izin`, `created_at`, `updated_at`) VALUES ('470', '27', '344', '2026-08-24', 'Hadir', '', NULL, '2026-08-24 20:46:43', NULL);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_code` (`role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`, `created_at`) VALUES ('1', 'admin', 'Administrator', 'Full access ke seluruh sistem, master data, dan log', '2026-07-20 18:04:03');
INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`, `created_at`) VALUES ('2', 'guru', 'Guru Mata Pelajaran', 'Akses ke Jurnal Pembelajaran, Presensi, dan Penilaian', '2026-07-20 18:04:03');
INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`, `created_at`) VALUES ('3', 'walikelas', 'Wali Kelas', 'Akses ke Monitoring Kelas, Rekapitulasi Presensi, dan Laporan', '2026-07-20 18:04:03');
INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`, `created_at`) VALUES ('4', 'kamad', 'Kepala Madrasah', 'Monitoring KBM, Kehadiran Kelas, dan Laporan Kepala Madrasah', '2026-07-28 18:37:51');
INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`, `created_at`) VALUES ('5', 'waka', 'Waka Kurikulum', 'Monitoring, evaluasi, dan verifikasi perangkat ajar serta KBM', '2026-07-29 20:21:00');
INSERT INTO `roles` (`id`, `role_code`, `role_name`, `description`, `created_at`) VALUES ('6', 'superadmin', 'Super Admin', 'Akses penuh ke seluruh sistem dan konfigurasi internal', '2026-07-29 20:21:00');

DROP TABLE IF EXISTS `ruangan`;
CREATE TABLE `ruangan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_ruangan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ruangan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int unsigned DEFAULT '36',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_ruangan` (`kode_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ruangan` (`id`, `kode_ruangan`, `nama_ruangan`, `kapasitas`, `created_at`) VALUES ('3', 'R1', 'Kelas X - A', '20', '2026-08-15 20:13:04');
INSERT INTO `ruangan` (`id`, `kode_ruangan`, `nama_ruangan`, `kapasitas`, `created_at`) VALUES ('4', 'R2', 'Kelas XI - A', '27', '2026-08-15 20:13:43');
INSERT INTO `ruangan` (`id`, `kode_ruangan`, `nama_ruangan`, `kapasitas`, `created_at`) VALUES ('5', 'R3', 'Kelas XII - A', '27', '2026-08-15 20:14:34');
INSERT INTO `ruangan` (`id`, `kode_ruangan`, `nama_ruangan`, `kapasitas`, `created_at`) VALUES ('6', 'R4', 'Kelas X - B', '24', '2026-08-15 20:15:11');
INSERT INTO `ruangan` (`id`, `kode_ruangan`, `nama_ruangan`, `kapasitas`, `created_at`) VALUES ('7', 'R5', 'Kelas XI - B', '8', '2026-08-15 20:15:49');
INSERT INTO `ruangan` (`id`, `kode_ruangan`, `nama_ruangan`, `kapasitas`, `created_at`) VALUES ('8', 'R6', 'Kelas XII - B', '14', '2026-08-15 20:16:12');

DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nis` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jk` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kelas_id` int unsigned NOT NULL,
  `status_aktif` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nis` (`nis`),
  UNIQUE KEY `nisn` (`nisn`),
  KEY `idx_siswa_kelas` (`kelas_id`),
  KEY `idx_siswa_status` (`status_aktif`),
  CONSTRAINT `fk_siswa_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=421 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('301', '2605001', '0114088231', 'ADZKHAN MUHAMMAD KAISAN AR RAHID', 'L', 'Malang', '2011-06-20', 'Jl. L.A Sucipto Gang Makam - Perum Grand Pesona Pandanwangi D10 Blimbing Malang, Pandanwangi, Blimbing, Kota Malang, 65126', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('302', '2605002', '3104310307', 'AHMAD DZAKY ALMER', 'L', 'Malang', '2010-06-06', 'Jl. Welirang No. 59 RT 05 RW 02 Kepanjen, Kepanjen, Kepanjen, Malang, 65163', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('303', '2605003', '0117293135', 'AHZA ZAFEER ARFA', 'L', 'Malang', '2011-06-11', 'Jl Jaya Srani II/7D/75, Sekarpuro, Pakis, Malang, 65154', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('304', '2605004', '0104024026', 'AZAM RISQULLAH HANIF', 'L', 'Malang', '2010-07-10', 'Jl. Kapiworo No.58 RT.02 RW.12, Mangliawan, Pakis, Malang, 65154', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('305', '2605005', '0111993614', 'AZKASSYANO ZAKI PAMBUDI', 'L', 'Malang', '2011-04-10', 'Perum griya sejahtera lpk III jl joko seger no 11, Pandanlandung, Wagir, Malang, 65147', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('306', '2605006', '3118285530', 'BIHUBBILLAH SALMAN MUQODDAS', 'L', 'Malang', '2011-01-25', 'Desa Pandansari, Pandansari, Poncokusumo, Malang, 65157', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('307', '2605007', '3103875809', 'HAWARI AHMAD WISANGGENI', 'L', 'Batu', '2010-12-16', 'Jl. Pronoyudho 42 Rt : 01 Rw: 02, DADAPREJO, JUNREJO, Kota Batu, 65323', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('308', '2605008', '0104436963', 'HAZEL FULVIAN AL FIRAS SANDRY ATMAJA', 'L', 'Malang', '2010-06-18', 'Jl Pelabuhan Tanjung Perak RT 3 RW 1 No 123 Bakalan Krajan, Bakalan Krajan, Sukun, Malang, 65148', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('309', '2605009', '0102783116', 'MAULANA SYIHABUDDIN ALMAHIY', 'L', 'Malang', '2010-08-27', 'Jalan Manggar I no 7 RT 01 RW 10, Lowokwaru, Lowokwaru, Malang, 65141', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('310', '2605010', '3115719169', 'MOCH NIDZOM MAULANA', 'L', 'Magelang', '2011-04-07', 'Jl. Sudimoro 15 B RT 06 RW 05, Mojolangu, Lowokwaru, Kota Malang, 65142', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('311', '2605011', '3107122162', 'MOHAMMAD HUSNI MUBAROK', 'L', 'Malang', '2010-06-20', 'Tawangsari RT 03 RW 01 Ngasem, Ngasem, Ngajum, Malang, 65164', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('312', '2605012', '0109836101', 'MUHAMMAD ABDULLAH', 'L', 'Malang', '2010-04-27', 'JL. Gatot Subroto gg 2 no 591 RT. 2 RW .1, Sukoharjo, Klojen, Kota Malang, 65118', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('313', '2605013', '0119465751', 'MUHAMMAD ALI HANAFIAH', 'L', 'Malang', '2011-02-01', 'Jl. Dusun Jaten RT 02 RW 04 Jedong, Jedong, Wagir, Malang, 65158', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('314', '2605014', '3116108842', 'MUHAMMAD AZAM AMRULLAH', 'L', 'Sidoarjo', '2011-02-19', 'Dusun Kedayon RT 014 RW 004 Desa Sumput, Sumput, Sidoarjo, Sidoarjo, 61218', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('315', '2605015', '0103870160', 'MUHAMMAD FAKHRUL WUJUD', 'L', 'Malang', '2010-11-09', 'Jalan Bareng Kulon VI/936 A, Bareng, Klojen, Malang, 65116', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('316', '2605016', '3112785689', 'MUHAMMAD KENZIE KAYANA RAMADHAN', 'L', 'Malang', '2011-08-03', 'JL Teluk Bayur 179 RT I RW 8 Pandanwangi, Pandanwangi, Blimbing, Kota Malang, 65124', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('317', '2605017', '0118473827', 'NAJWAN GHAZY SABILILLAH', 'L', 'Malang', '2011-06-15', 'Jl. Dieng Atas RT.04 RW.01 Dsn. Sumberjo, Kalisongo, Dau, Malang, 65151', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('318', '2605018', '3110478270', 'RAHMAT MULYA ALAMSYAH', 'L', 'Malang', '2011-01-22', 'Jl. Luhur RT. 04 RW. 05 Penarukan Kepanjen Malang, Penarukan, Kepanjen, Malang, 65163', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('319', '2605019', '0101730998', 'REYHAAN ATHAR EVANSYAH', 'L', 'Malang', '2010-10-10', 'Perum. Griyo Muslim B13\nJl. Raya tebo selatan rt. 06 rw. 07\nMulyorejo Sukun Malang, Mulyorejo, Sukun, Kota malang, --', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('320', '2605020', '0102801938', 'SATRIA ABDIE NURUL FADHIL', 'L', 'Malang', '2010-07-06', 'Perum Sekarpuro Residence C11A, jl Wijaya Kusuma, Pakis, Sekarpuro, Pakis, Malang, 65154', '1', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('321', '2605021', '0107321462', 'AGATHA ANINDYA SAFAIRA', 'P', 'MALANG', '2010-10-31', 'JL BANDULAN X / 438 RT 03 / RW 01, BANDULAN, SUKUN, KOTA MALANG, 65146', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('322', '2605022', '0104211740', 'AINI RATU KASIH', 'P', 'Malang', '2010-12-25', 'Jl. Kalijogo Rt. 15 Rw. 03 , Dusun Santren, Pandanlandung, Wagir, Malang, 65158', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('323', '2605023', '3110113725', 'AMIRAH HANIN MUFIDAH', 'P', 'Malang', '2011-01-24', 'JL. Cokroaminoto IV / 118 Kota Malang, Klojen, Klojen, Kota Malang, 65111', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('324', '2605024', '0116197891', 'AULYA NABILAH QURROTAΓÇÖAINI', 'P', 'malang', '2011-03-06', 'jl. regulo rt.17 rw.02, cepokomulyo, cepokomulyo, kepanjen, malang, 65163', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('325', '2605025', '3114122274', 'AURA KHOIRUN NISA', 'P', 'SURABAYA', '2012-03-06', 'KALIANAK TIMUR LEBAR 9, RT 004/ RW 007, MOROKREMBANGAN, KREMBANGAN, SURABAYA, 60178', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('326', '2605026', '0117886606', 'ELCEE ZAYNE SAFWA NURANI', 'P', 'Malang', '2011-04-10', 'Dsn Krajan, Ds Sepanjang, Kec Gondanglegi Kab Malang, Sepanjang, Gondanglegi, Malang, 65174', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('327', '2605027', '3103346631', 'FATICHA MAJIDA LIRABBIHA', 'P', 'MALANG', '2010-11-05', 'Jl. Zaenal Zakse gg 6 No. 2302 RT. 08 RW. 05, Jodipan, JODIPAN, BLIMBING, KOTA MALANG, 65127', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('328', '2605028', '0114007306', 'GHINA JIHAN FARIZAH LAKEISHA', 'P', 'BIMA', '2010-04-29', 'JLN. MELATI 03 KEL.LILIBA, LILIBA, OEBOBO, KOTA KUPANG, 85111', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('329', '2605029', '0101295919', 'ILEN ARTA', 'P', 'Malang', '2010-07-08', 'JL. Sekolahan Rt. 12 Rw 03 Dusun Santren Pandanlandung, Pandanlandung, Wagir, Malang, 65158', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('330', '2605030', '3119048223', 'IMRO\'ATUL CHUSNA', 'P', 'Malang', '2011-05-22', 'Jl. Gapuro pandan Landung RT 16 RW 04, Pandan Landung, Wagir, Malang, 65158', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('331', '2605031', '0115307336', 'KHANSA HASNA AMALIA', 'P', 'Malang', '2011-04-02', 'Jl .srigunting no 13 RT 06 RW 08, Tanjung rejo, Sukun, Kota Malang, 65147', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('332', '2605032', '0109942983', 'KIRANIA ZAHRA ANJANI', 'P', 'Malang', '2010-07-03', 'Perumahan Sukun Pondok Indah Blok K-16, Bandungrejosari, Sukun, Malang, 65148', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('333', '2605033', '3103483301', 'MAR\'AH QONITATILLAH', 'P', 'Malang', '2010-09-05', 'Jl.Tebo Tengah Gg Masjid No. 91B RT. 08  RW. 01, Mulyorejo, Sukun, Kota Malang, 65147', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('334', '2605034', '0111953065', 'MUTIARA WAHIDAH FATMA', 'P', 'Sidoarjo', '2011-04-11', 'Kademangan RT 010 RW 004, Jemirahan, Jabon, Sidoarjo, 61276', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('335', '2605035', '0105796822', 'NABILA TSAMAAROH ALHASYIM', 'P', 'Malang', '2010-11-27', 'Jl.Akordion II no.197, Tunggul Wulung, Lowokwaru, Kota Malang, 65143', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('336', '2605036', '0118039502', 'NATHA RASENDRIYA SULIHANTO', 'P', 'Malang', '2011-06-16', 'Jl Danau Sentani Utara VIII/H3 1-19, Rt 005/012, Desa Madyopuro, Madyopuro, Kedungkandang, Malang, Jawa Timur, 65138', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('337', '2605037', '0106573274', 'NUR RAHMATUS SYA\'BANI', 'P', 'Malang', '2010-08-07', 'Jl. Bunga songgolangit no 50 RT.3 RW 12, Tulusrejo, Lowokwaru, Kota Malang, 65141', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('338', '2605038', '0114051587', 'QUEENSYA KEYLA ARSY', 'P', 'Malang', '2011-02-10', 'Jl. Sidodadi no 16 RT. 06 RW. 03, Ngadilangkung Kepanjen, Ngadilangkung, Kepanjen, Malang, 65163', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('339', '2605039', '0115322531', 'ROUDLOH SUFFA NABAWI', 'P', 'LUMAJANG', '2011-04-11', 'Dusun manggisan\nRt 10\nRw 04\nDesa tamanayu, Desa tamanayu, PRONOJIWO, LUMAJANG, 67374', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('340', '2605040', '3118252799', 'SABRINA ALFI RAMADINA HARIYANTO', 'P', 'Lumajang', '2011-03-02', 'Mulyoarjo RT 015/ RW 006 Pronojiwo Kabupaten Lumajang, PRONOJIWO, PRONOJIWO, LUMAJANG, 67374', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('341', '2605041', '0111214573', 'SAFINA ANINDITA ARROYYAN', 'P', 'MALANG', '2011-02-10', 'JL.ONTOSENO 1 NO.5 POLEHAN MALANG, KELURAHAN POLEHAN, BLIMBING, KOTA MALANG, 65121', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('342', '2605042', '0115379856', 'SYAFIRA ALYA AKMALIA HARYANTO', 'P', 'Lumajang', '2011-03-02', 'Mulyoarjo RT 015/ RW 006 Pronojiwo Kabupaten Lumajang, Pronojiwo, Pronojiwo, Lumajang, 67374', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('343', '2605043', '0104996028', 'SYAUQEENA ILA SALSABILA', 'P', 'Malang', '2010-10-01', 'Dusun blobo rt 001 / rw 002, Sukoraharjo, Kepanjen, Malang, 65163', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('344', '2605044', '0112694183', 'WAFIRA SAHASIKA AN NAJAH', 'P', 'Malang', '2011-03-09', 'Jl. Sumedang No 20, KEPANJEN, KEPANJEN, MALANG, 65163', '2', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('345', '2505001', '0107405562', 'ABDULLAH SHOLEH MUBAROK', 'L', 'Malang', '2010-03-17', 'Jalan Kolonel Sugiono Gang 5 nomor 515 RT 1 RW 3, Mergosono, Kedungkandang, Malang, 65134', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('346', '2505002', '0109617044', 'AHMAD BAHR EL-HISYAM ISMAIL', 'L', 'Malang', '0000-00-00', 'Jl. Embong Brantas 1550/1553 RT 01 RW 06 Kidul Dalem Kec. Klojen Kota Malang, Kidul Dalem, Klojen, Kota Malang, 65119', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('347', '2505003', '3098137371', 'AHMAD FAKHRI BASYIRUDIN', 'L', 'Malang', '2009-12-25', 'Jl. Kauman IVA/635 RT.03 RW.03, Kelurahan Kauman, Klojen, Kota Malang, 65119', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('348', '2505004', '0091684639', 'AHMAD MUMTAZA AL KAUTSAR', 'L', 'MALANG', '2009-07-31', 'Jl. KH Malik Dalam RT 2/ RW 4, Buring, Kedungkandang, Malang, 65136', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('349', '2505005', '0105584396', 'AHMAD WILY AZKA FAUZI', 'L', 'Situbondo', '2010-05-28', 'Jl.trebungan Rt.01 Rw. 01,Dusun Krajan, Sumber pinang, Mlandingan, Situbondo, 68353', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('350', '2505006', '0108153857', 'AKBAR RAMADANI LONGDONG', 'L', 'Malang', '2010-08-09', 'MT Hariono,Balikpapan Kota, DAMAI, BALIKPAPAN KOTA, BALIKPAPAN KOTA, -', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('351', '2505007', '3098907852', 'ALYA NAFISA ARRAHMAH', 'P', 'Malang', '2009-12-06', 'Jl. A. Yani 23 Kepanjen, Kepanjen, Kepanjen, Malang, 65163', '6', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('352', '2505008', '3101076686', 'ALZAM NUR ROHMAN', 'L', 'Malang', '2010-02-02', 'Jl. Gunung Jati 10 Rt19. Rw. 05, Dusun Pandan selatan, Pandanlandung, Wagir, Malang, 65158', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('353', '2505009', '0103093177', 'AZZANI USWATUN HASANAH', 'P', 'Malang', '2010-04-08', 'jl. I. R. Rais rt04, rw 07, bareng, klojen, malang, 65116', '6', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('354', '2505010', '0099601812', 'BARRUR ROSHIEN ISHOMY', 'L', 'Malang', '2009-03-14', 'Jl Gadang Gang IV no 7 RT 7 RW 7 Gadang Malang, Gadang, Sukun, Kota Malang, 65149', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('355', '2505011', '0101151754', 'DENIS WIJIANTI', 'P', 'Malang', '2010-03-01', 'Griya taman Landung b6, Pandang landung, Wagir, Kabupaten malang, 65158', '6', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('356', '2505012', '0094070440', 'FATIMAH HIBATUZ ZAMAN', 'P', 'Malang', '2009-02-06', 'Jl. Bareng Kulon GG 6/ no.936 A RT 04 RW 04, Bareng, Klojen, Kota Malang, 65116', '6', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('357', '2505013', '0092208664', 'HABIBURRAHMAN IEDUL AKBAR', 'L', 'Sridadi', '2009-11-25', 'Sridadi, malapari rt 01, Sridadi, Muara Bulian, Batanghari, 36613', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('358', '2505014', '3102801710', 'IKLIIL MUKTASHIIM ASHIIL', 'L', 'Bekasi', '2010-05-06', 'Jln Kelapa Kopyor no 7 Rt. 001 Rw 010, Sumber Jaya, Tambun Selatan, Bekasi, 17510', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('359', '2505015', '0092534257', 'KEISHA NEILA ZHAFIRAH INA ARTANTI', 'P', 'Malang', '2009-03-24', 'JL. LAKS MARTADINATA, kota lama, kedungkandang, malang, 56136', '6', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('360', '2505016', '0097799301', 'M. ABDAN SYAKURO', 'L', 'Pasuruan', '2009-10-04', 'Dsn Mantung Rt.01 Rw.06, Ngabab, Pujon, Malang, 65391', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('361', '2505017', '0095473093', 'M.SA\'DAN ASHFA RAMADHAN', 'L', 'Malang', '2009-08-30', 'Jl. Tirto Rt. 03.Rw.05 Pagedangan, Pagedangan, Turen, Malang, 65175', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('362', '2505018', '3106255572', 'M. SON TAQDIR AULADY EL KARIM', 'L', 'Malang', '2010-03-10', 'Jl. Sultan Agung 119 RT. 11 RW.03, KEPANJEN, KEPANJEN, MALANG, 65163', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('363', '2505019', '0106173938', 'MOCHAMMAD HARUN SHAFA', 'L', 'Malang', '2010-02-04', 'DSN. Nampes RT/RW 02/02 Desa Baturetno, Baturetno, Singosari, Malang, 65153', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('364', '2505020', '3094478708', 'MUCHAMMAD CHAMIM ABDHILLAH', 'L', 'Malang', '2009-08-07', 'Jl muharto vI Rt 08 Rw 07 jodipan blimbing kota malang, Jodipan, Blimbing, Kota malang, 65127', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('365', '2505021', '0094161065', 'MUHAMMAD ALIFFARABY ALHAQ', 'L', 'Malang', '2009-11-27', 'Perumahan Graha Balearjosari no 34 JL Pahlawan RT09 RW03 Malang, Balearjosari, Blimbing, Malang, 65126', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('366', '2505022', '0108995908', 'MUHAMMAD AZAM AULADZUL FAZA', 'L', 'Malang', '2010-01-30', 'Jl Kalijogo Rt.06 Rw. 02 pandan landung, Pandanlandung, Wagir, Malang, 65158', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('367', '2505023', '0092230446', 'MUHAMMAD AZKA PRASETYA', 'L', 'Malang', '2009-08-04', 'Jalan Anggrek Garuda 39, Jatimulyo, Lowokwaru, Kota Malang, 65141', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('368', '2505024', '0096587488', 'MUHAMMAD FAHRI ALDIANSYAH', 'L', 'Malang', '2009-03-07', 'Tanjungrejo sukun, tanjungrejo, Sukun, Malang, 56147', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('369', '2505025', '0108945915', 'MUHAMMAD KRISAN FAIQ AL-HISYAM', 'L', 'Malang', '2010-02-25', 'Jl. Gapuro RT 17 RW 04, Pandanlandung, Wagir, Malang, 65158', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('370', '2505026', '0103874686', 'MUHAMMAD NAUFAL ZUL FADLI', 'L', 'Malang', '2010-03-04', 'Jl. dr Cipto RT.007 RW 10, Desa Bedali, Lawang, Malang, 65215', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('371', '2505027', '0094935735', 'MUHAMMAD NAZRIL ARDIANSYAH', 'L', 'Sidoarjo', '2009-02-12', 'Kalidawir Rt 002 Rw 001 Kalidawir Tanggulangin, Kalidawir, Tanggulangin, Sidoarjo, 0000', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('372', '2505028', '0092177185', 'MUHAMMAD ZAKI ALIFUDIN', 'L', 'Malang', '2009-09-22', 'Jl.Terusan Mergan Ry 19/10A RT04 RW11, Tanjung Rejo, Sukun, Malang, 65147', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('373', '2505029', '0095854573', 'NADHIFA REZQY AULIA', 'P', 'MALANG', '2009-10-29', 'Dsn Sumberbendo RT. 009 RW. 002 Lolawang, Lolawang, Ngoro, Mojokerto, 61385', '6', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('374', '2505030', '3109870121', 'NAFILATUL KHUSNA', 'P', 'Malang', '2010-10-14', 'Jl Kol Sugiono VIII/69 RT 12, RW 01, Kelurahan Ciptomulyo, Ciptomulyo, Sukun, Kota Malang, 65148', '6', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('375', '2505031', '0099750689', 'NAJWAN HIBATULLAH MAHWA FAAZA', 'L', 'Lumajang', '2009-09-23', 'Jl. Raya Dampit-Lumajang, RT.001/RW.001, Kalibening, Pronojiwo, Pronojiwo, Lumajang, 67374', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('376', '2505032', '0099184745', 'NAUFAL AKBAR RAGIL PRANANDA', 'L', 'Malang', '2009-11-20', 'Jl. Bayam 40, RT.04/RW.02, Bumiayu, Kedungkandang, Kota Malang, 65135', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('377', '2505033', '0094893400', 'QUEENSHA AZALEA AUFA AR RAHID', 'P', 'MALANG', '2009-11-24', 'Jl. LA.Sucipto Gang Makam - Perum Grand Pesona Pandanwangi D10, Pandanwangi, Blimbing, Malang, 65126', '6', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('378', '2505034', '0109815490', 'TEGUH ARI ARMANSYAH', 'L', 'Malang', '2010-01-01', 'Jl Terusan Lowokdoro no 12  Rt.10.   Rw.04, Kebonsari, Sukun, Kota Malang, 65149', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('379', '2505035', '3092207901', 'WINAR LAGA SASMITO', 'L', 'SIDOARJO', '2009-10-22', 'Dsn kalangan Ds. Jatikalang Rt.02 Rw. 01, JATIKALANG, KRIAN, SIDOARJO, 61262', '5', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('380', '2405001', '0095478523', 'ACHMAD SULTHON', 'L', 'MALANG', '2009-03-09', 'JL.BARENG KARTINI 3C NO 116 B,KAUMAN,KLOJEN,KOTA MALANG,RT 04/RW 08, RT 4, RW 8, KAUMAN, KLOJEN, KOTA MALANG, JAWA TIMUR, 65119', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('381', '2405002', '0082756906', 'AHMAD DIRLY ZAMACHSARI', 'L', 'MALANG', '2008-05-29', 'JL. SIMPANG GAPURO RT 15 RW 03 DESA PANDANLANDUNG,KECAMATAN WAGIR, KABUPATEN MALANG, RT 15, RW 3, PANDANLANDUNG, WAGIR, MALANG, JAWA TIMUR, 65058', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('382', '2405003', '0097461659', 'AHMAD ROIHAN PUTRA PERMANA', 'L', 'MALANG', '2009-03-03', 'JL. GAPURA RT.16 RW.04 PANDANLANDUNG, WAGIR, RT 16, RW 4, PANDANLANDUNG, WAGIR, MALANG, JAWA TIMUR, 65158', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('383', '2405004', '0087962733', 'AURELIA RAFADITA EKA SANTOSO', 'P', 'BATAM', '2008-10-11', 'JL.SUKUN GEMPOL RT 16 RW 09 KELURAHAN TANJUNGREJO KECAMATAN SUKUN, RT 16, RW 9, TANJUNGREJO, SUKUN, KOTA MALANG, JAWA TIMUR, 65147', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('384', '2405005', '0097819859', 'AZHERINE FIIRIYAL BILQIS', 'P', 'MALANG', '2009-04-27', 'JL. SIDOMULYO LL RT 06 RW 02 SUDIMORO BULULAWANG MALANG, RT 6, RW 2, SUDIMORO, BULULAWANG, MALANG, JAWA TIMUR, 65171', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('385', '2405006', '0087661953', 'DIVA AGUSTA PUTRI SEJATI', 'P', 'MALANG', '2008-08-16', 'JL. GAPURA RT.16 RW.04 PANDANLANDUNG, WAGIR, RT 16, RW 4, PANDANLANDUNG, WAGIR, MALANG, JAWA TIMUR, 65158', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('386', '2405007', '0081426813', 'FADHIL IYONI DAVA ANARGYA', 'L', 'BLITAR', '2008-07-25', 'JL KENARI/DESA PLOSOARANG/SANANKULON/BLITAR, PLOSOARANG, SANAN KULON, BLITAR, JAWA TIMUR, 66151', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('387', '2405008', '3083464531', 'FARIS AL GHAZI', 'L', 'LUMAJANG', '2008-10-17', 'JALAN RAYA PRONOJIWO , KALIBENING RT 04 RW 02 DESA PRONOJIWO, KEC. PRONOJIWO, KAB. LUMAJANG, RT 4, RW 2, PRONOJIWO, PRONOJIWO, LUMAJANG, JAWA TIMUR, 67374', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('388', '2405009', '0085744658', 'FIROSYATIL AULIA\'', 'P', 'MALANG', '2008-12-19', 'JALAN BROMO, KELURAHAN ORO - ORO DOWO, KECAMATAN KLOJEN, KABUPATEN MALANG, RT 04 RW 09, RT 4, RW 9, ORO - ORO DOWO, KLOJEN, KOTA MALANG, JAWA TIMUR, 65112', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('389', '2405010', '0091424546', 'MOHAMMAD HAFIZ AL FAIRUZ', 'L', 'MALANG', '2009-08-11', 'PERUM GRIYA KARTIKA BLOK J NO 35 RT 25 RW 05 CEMANDI SEDATI KAB SIDOARJO, RT 25, RW 5, PAKIS, SAWAHAN, MALANG, JAWA TIMUR, 61263', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('390', '2405011', '0082658476', 'M HAFNI HAMID ADZ-DZAHABI', 'L', 'SIDOARJO', '2008-11-18', 'DESA GLAGAHARUM RT.016 RW.004 KECAMATAN PORONG KABUPATEN SIDOARJO JATIM, RT 16, RW 4, GLAGAHARUM, PORONG, SIDOARJO, JAWA TIMUR, 61274', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('391', '2405012', '0088001828', 'MUCHAMMAD RAZIF FACHRUDIN', 'L', 'MALANG', '2008-10-30', 'JL. MT HARYONO 12 NO.1157/N RT.03 RW.05, DINOYO - LOWOKWARU, RT 3, RW 5, DINOYO, LOWOKWARU, KOTA MALANG, JAWA TIMUR, 65144', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('392', '2405013', '0094004945', 'MUHAMMAD ABDULLOH ARVERARI', 'L', 'MALANG', '2009-05-30', 'JL. ZAENAL ZAKSE II/29 RT.002 RW.004, RT 2, RW 4, JODIPAN, BLIMBING, KOTA MALANG, JAWA TIMUR, 0', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('393', '2405014', '3091237266', 'MUHAMMAD ABYAN AZZAM', 'L', 'MALANG', '2009-07-12', 'JL EFFENDI 60 RT 10 RW 01 KEPANJEN MALANG, RT 10, RW 1, CEMOROKANDANG, KEDUNGKANDANG, KOTA MALANG, JAWA TIMUR, 65163', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('394', '2405015', '3090315668', 'MUHAMMAD FAKHRI RADITYO', 'L', 'BONTANG', '2009-02-22', 'JL SAMPURNA PERUM PURI CEMARA INDAH B-14 RT07 / RW 03 KEL CEMOROKANDANG KEC KEDUNGKANDANG KOTA MALANG, RT 7, RW 3, CEMOROKANDANG, KEDUNGKANDANG, KOTA MALANG, JAWA TIMUR, 65138', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('395', '2405016', '0088453371', 'MUHAMMAD FATHUR ROZZI', 'L', 'MALANG', '2008-04-16', 'JLN. MUHARTO, RT 08, RE 07, JODIPAN, BLIMBING, KOTA MALANG, RT 8, RW 7, JODIPAN, BLIMBING, KOTA MALANG, JAWA TIMUR, 65127', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('396', '2405017', '3093934992', 'MUHAMMAD FAUZUL MUBAROK', 'L', 'MALANG', '2009-03-11', 'JALAN JAKSA AGUNG SUPRAPTO II/NO.278, KELURAHAN SAMAAN, KECAMATAN KLOJEN, KOTA MALANG, RT.07/RW.03, RT 7, RW 3, SAMAAN, KLOJEN, KOTA MALANG, JAWA TIMUR, 65112', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('397', '2405018', '3089704653', 'MUHAMMAD GHULAM SALIM ASYROFI', 'L', 'SIDOARJO', '2008-11-17', 'RT 14 RW 03 GLAGAH ARUM PORONG SIDOARJO, RT 14, RW 3, GLAGAHARUM, PORONG, SIDOARJO, JAWA TIMUR, 61274', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('398', '2405019', '0088726621', 'MUHAMMAD HANAN ZUHRUF', 'L', 'MALANG', '2008-06-13', 'PERUM BUMI KEPUH PERMAI B-35 KEL. BANDUNGREJOSARI KEC. SUKUN KOTA MALANG RT. 06 RW.10, RT 6, RW 10, BANDUNGREJOSARI, SUKUN, KOTA MALANG, JAWA TIMUR, 65147', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('399', '2405020', '0091189344', 'MUHAMMAD ILHAM MARIYANTO', 'L', 'MALANG', '2009-02-17', 'JL. S. SUPRIADI 2A/27 RT 06 RW 03 KEL SUKUN KEC SUKUN KOTA MALANG, RT 6, RW 3, SUKUN, SUKUN, KOTA MALANG, JAWA TIMUR, 65147', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('400', '2405021', '0095644799', 'MUHAMMAD IRSYAD SYARIEF. A', 'L', 'MALANG', '2009-02-02', 'JL. MARTOREJO GG. LILY RT 07 RW 02 KEL. DADAPREJO KEC. JUNREJO KOTA BATU, RT 7, RW 2, MOJOLANGU, LOWOKWARU, KOTA MALANG, JAWA TIMUR, 65323', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('401', '2405022', '0095909340', 'MUHAMMAD JAMAL ISTHOKHRY', 'L', 'KEDIRI', '2009-01-23', 'JALAN RAYA GADANG GANG2 NO.20 RT.11 RW.07, RT 11, RW 7, GADANG, SUKUN, KOTA MALANG, JAWA TIMUR, 65149', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('402', '2405023', '0089654096', 'MUHAMMAD MAULANA', 'L', 'MALANG', '2008-06-17', 'JL. KLAYATAN I/33 RT.005 RW.001, RT 5, RW 1, BANDUNGREJOSARI, SUKUN, KOTA MALANG, JAWA TIMUR, 0', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('403', '2405024', '3087525288', 'MUHAMMAD NURULLAH', 'L', 'MALANG', '2008-12-29', 'GATOT SUBROTO GG 2 NO 591, SUKOHARJO, KLOJEN, KOTA MALANG, JAWA TIMUR, 65118', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('404', '2405025', '3090955292', 'MUHAMMAD RAMADHAN', 'L', 'MALANG', '2009-09-10', 'KL. ARIF MARGONO VIII /07 KEL. KASIN KEC. KLOJEN MALANG, RT 8, RW 7, KASIN, KLOJEN, KOTA MALANG, JAWA TIMUR, 65117', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('405', '2405026', '0087271204', 'MUHAMMAD RIDHO', 'L', 'MALANG', '2008-05-19', 'JLN IKAN PIRANHA ATAS/ TUNJUNG SEKAR/ LOWOK WARU /KOTA MALANG, RT 06 RW 01, RT 6, RW 1, TUNJUNG SEKAR, LOWOK WARU, KOTA MALANG, JAWA TIMUR, 65142', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('406', '2405027', '0093794238', 'MUHAMMAD WALDAN VIDI AN NAFI\'', 'L', 'MALANG', '2009-01-25', 'JL.JANTI BARAT BLOK / 100, BANDUNGREJOSARI, SUKUN, KOTA MALANG, JAWA TIMUR, 65148', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('407', '2405028', '0099849653', 'MUHAMMAD WILDAN VIDI AN NAFI\'', 'L', 'MALANG', '2009-01-25', 'JL.JANTI BARAT BLOK A/ 100, BANDUNGREJOSARI, SUKUN, KOTA MALANG, JAWA TIMUR, 65148', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('408', '2405029', '0088515103', 'NABILA LAILIYAH RUSDI', 'P', 'MALANG', '2008-02-10', 'JLN.PALEMBANG RT 16 KEL.GUNUNG TELIHAN KEC.BONTANG BARAT, RT 16, GUNUNG TELIHAN, BONTANG BARAT, KALIMANTAN TIMUR, KALIMANTAN TIMUR, 75313', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('409', '2405030', '0089115450', 'NAYAKA RAJENDRA PRATAMA', 'L', 'MALANG', '2008-11-17', 'JL. BANDULAN VII/514, RT 7 RW 7, KEL. BANDULAN, KEC. SUKUN, KOTA MALANG, RT 7, RW 7, BANDULAN, SUKUN, KOTA MALANG, JAWA TIMUR, 65146', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('410', '2405031', '0097399921', 'NURIYATUL AAQILAH', 'P', 'MALANG', '2009-07-18', 'JL. MERGAN RAYA III/33, TANJUNGREJO, SUKUN, KOTA MALANG, 008/006, RT 8, RW 6, TANJUNG REJO, SUKUN, KOTA MALANG, JAWA TIMUR, 65147', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('411', '2405032', '0096439020', 'QOTRUN NADA', 'P', 'MALANG', '2009-08-02', 'JL. RAYA 123, R 01 RW 09, KELURAHAN PAGENTAN, KECAMATAN SINGOSARI, KABUPATEN MALANG,, RT 1, RW 9, PAGETAN, SINGOSARI, MALANG, JAWA TIMUR, 65153', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('412', '2405033', '0097927687', 'RAFI SAYID MUSTOFA', 'L', 'SURABAYA', '2009-01-10', 'JL. JERUK NO 130 RT3 RW2 LAKARSANTRI SURABAYA, RT 3, RW 2, JERUK, LAKASANTRI, KOTA SURABAYA, JAWA TIMUR, 60212', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('413', '2405034', '3082377096', 'RAFIFATUL AZIZAH', 'P', 'MALANG', '2008-09-26', 'JL.BANDULAN V/745 B KEL BANDULAN KEC SUKUN KOTA MALANG, BANDULAN, SUKUN, KOTA MALANG, JAWA TIMUR, 61546', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('414', '2405035', '0083227884', 'RAISAH FATIHATURRIZQIYAH', 'P', 'MALANG', '2008-05-17', 'JL.RAYA BANDULAN NO.108 RT 01 RW 02 KE.SUKUN MALANG, RT 1, RW 2, BANDULAN, SUKUN, KOTA MALANG, JAWA TIMUR, 65146', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('415', '2405036', '0084993599', 'SATRYA ATHA PRATAMA', 'L', 'MALANG', '2008-08-19', 'JALAN SIMPANG RANUGRATI SELATAN1/14 RT 05 RW 06 SAWOJAJAR MALANG, RT 5, RW 6, SAWOJAJAR, KEDUNGKANDANG, KOTA MALANG, JAWA TIMUR, 65139', '7', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('416', '2405037', '0094888147', 'SOFI MAULIDIA', 'P', 'JOMBANG', '2009-04-06', 'JL. KEBONSARI 5/172A KELURAHAN KEBONSARI KECAMATAN SUKUN KOTA MALANG RT04 RW02, RT 4, RW 2, KEBONSARI, SUKUN, KOTA MALANG, JAWA TIMUR, 65149', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('417', '2405038', '0086705747', 'SYARIFAH FATHIMAH HUBUURUZ ZAHRO', 'P', 'MALANG', '2008-08-13', 'PERUMAHAN KARANGDUREN PERMAI BLOK J-16, RT.07 RW.07 DESA KARANGDUREN KECAMATAN PAKISAJI KAB.MALANG, RT 7, RW 7, KARANGDUREN, PAKISAJI, MALANG, JAWA TIMUR, 65162', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('418', '2405039', '0094288413', 'ZAHWA AZ ZAHRA', 'P', 'MALANG', '2009-11-12', 'JL.KEBALEN WETAN GANG 8 NO 7 RT 13 RW 01 KEL.KOTALAMA KEC.KEDUNGKANDANG KOTA MALANG, RT 13, RW 1, KOTA LAMA, KEDUNGKANDANG, KOTA MALANG, JAWA TIMUR, 65136', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('419', '2405040', '0093640433', 'ZASKY DWI AULIA PUTRI', 'P', 'JOMBANG', '2009-03-20', 'JL. KESATRIAN TENIS NO.18 RT.01 RW.09 KELURAHAN KESATRIAN KECAMATAN BLIMBING MALANG, RT 1, RW 9, KESATRIAN, BLIMBING, KOTA MALANG, JAWA TIMUR, 65121', '8', '1', '2026-08-13 16:11:02', NULL);
INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama_lengkap`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kelas_id`, `status_aktif`, `created_at`, `updated_at`) VALUES ('420', '2405041', '0095339647', 'ZELDA AURELLIA RAHMA', 'P', 'MALANG', '2009-06-22', 'JALAN GAPURO PANDANLANDUNG KECAMATAN WAGIR KABUPATEN MALANG RT/RW 18/04, RT 18, RW 4, PANDANLANDUNG, WAGIR, MALANG, JAWA TIMUR, 65158', '8', '1', '2026-08-13 16:11:02', NULL);

DROP TABLE IF EXISTS `sys_performance_logs`;
CREATE TABLE `sys_performance_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `execution_time` decimal(8,4) NOT NULL,
  `memory_usage` decimal(8,2) NOT NULL,
  `query_count` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_perf_created` (`created_at`),
  KEY `idx_perf_time` (`execution_time`)
) ENGINE=InnoDB AUTO_INCREMENT=1685 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1', 'perangkat_ajar/arsip', '0.1271', '6.00', '3', '2026-07-29 13:36:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('2', 'perangkat_ajar/arsip', '0.1178', '6.00', '3', '2026-07-29 13:42:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('3', 'dashboard', '0.1219', '6.00', '12', '2026-07-29 13:43:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('4', 'login', '0.0728', '6.00', '0', '2026-07-29 13:43:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('5', 'dashboard', '0.0905', '6.00', '11', '2026-07-29 13:43:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('6', 'settings', '0.0829', '6.00', '2', '2026-07-29 13:43:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('7', 'logs', '0.0874', '6.00', '2', '2026-07-29 13:43:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('8', 'dashboard', '0.0969', '6.00', '11', '2026-07-29 13:43:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('9', 'dashboard', '0.1243', '6.00', '12', '2026-07-29 13:57:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('10', 'settings', '0.1021', '6.00', '3', '2026-07-29 13:57:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('11', 'settings', '0.1078', '6.00', '3', '2026-07-29 13:58:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('12', 'settings', '0.0826', '6.00', '3', '2026-07-29 13:58:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('13', 'settings', '0.0812', '6.00', '3', '2026-07-29 13:59:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('14', '/', '0.0381', '8.00', '1', '2026-07-31 20:29:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('15', 'dashboard', '0.0111', '8.00', '12', '2026-07-31 20:29:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('16', 'dashboard', '0.0079', '8.00', '12', '2026-07-31 20:30:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('17', 'jurnal', '0.0110', '8.00', '6', '2026-07-31 20:30:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('18', 'login', '0.0023', '8.00', '1', '2026-07-31 20:30:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('19', 'dashboard', '0.0051', '8.00', '12', '2026-07-31 20:30:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('20', 'master/guru', '0.0096', '8.00', '8', '2026-07-31 20:31:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('21', 'master/jadwal', '0.0064', '8.00', '11', '2026-07-31 20:31:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('22', 'dashboard', '0.0109', '8.00', '12', '2026-07-31 21:00:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('23', 'jurnal', '0.0120', '8.00', '6', '2026-07-31 21:01:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('24', 'jurnal/add', '0.0058', '8.00', '11', '2026-07-31 21:01:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('25', 'jurnal', '0.0060', '8.00', '6', '2026-07-31 21:01:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('26', 'jurnal/jadwal', '0.0052', '8.00', '4', '2026-07-31 21:01:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('27', 'presensikelas', '0.0072', '8.00', '6', '2026-07-31 21:01:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('28', 'presensi/input/7', '0.0064', '8.00', '5', '2026-07-31 21:01:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('29', 'presensi', '0.0079', '8.00', '13', '2026-07-31 21:01:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('30', 'login', '0.0143', '8.00', '1', '2026-07-31 21:02:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('31', 'penilaian', '0.0077', '8.00', '7', '2026-07-31 21:02:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('32', 'penilaian', '0.0065', '8.00', '10', '2026-07-31 21:02:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('33', 'penilaian', '0.0059', '8.00', '10', '2026-07-31 21:02:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('34', 'penilaian', '0.0052', '8.00', '11', '2026-07-31 21:02:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('35', 'login', '0.0042', '8.00', '1', '2026-07-31 21:03:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('36', 'login', '0.0032', '8.00', '1', '2026-07-31 21:04:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('37', 'dashboard', '0.0075', '8.00', '12', '2026-07-31 21:04:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('38', 'jurnal', '0.0069', '8.00', '6', '2026-07-31 21:04:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('39', 'jurnal/add', '0.0066', '8.00', '11', '2026-07-31 21:04:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('40', 'jurnal/jadwal', '0.0053', '8.00', '4', '2026-07-31 21:04:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('41', 'presensikelas', '0.0057', '8.00', '6', '2026-07-31 21:05:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('42', 'presensikelas/edit/7', '0.0066', '8.00', '4', '2026-07-31 21:05:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('43', 'presensikelas', '0.0052', '8.00', '6', '2026-07-31 21:05:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('44', 'presensi/input/7', '0.0062', '8.00', '5', '2026-07-31 21:05:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('45', 'penilaian', '0.0058', '8.00', '7', '2026-07-31 21:05:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('46', 'penilaian/rekap', '0.0041', '8.00', '5', '2026-07-31 21:05:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('47', 'login', '0.0035', '8.00', '1', '2026-07-31 21:05:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('48', 'dashboard', '0.0123', '8.00', '13', '2026-07-31 21:07:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('49', 'jurnal', '0.0103', '8.00', '10', '2026-07-31 21:08:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('50', 'jurnal/add', '0.0076', '8.00', '15', '2026-07-31 21:08:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('51', 'perkembangan', '0.0415', '8.00', '12', '2026-07-31 21:10:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('52', 'karya', '0.0064', '8.00', '10', '2026-07-31 21:10:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('53', 'perkembangan', '0.0069', '8.00', '12', '2026-07-31 21:10:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('54', 'karya', '0.0046', '8.00', '10', '2026-07-31 21:10:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('55', 'perangkat_ajar', '0.0135', '8.00', '11', '2026-07-31 21:10:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('56', 'perangkat_ajar/revisi', '0.0055', '8.00', '4', '2026-07-31 21:10:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('57', 'perangkat_ajar/arsip', '0.0054', '8.00', '4', '2026-07-31 21:10:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('58', 'perangkat_ajar/upload', '0.0051', '8.00', '9', '2026-07-31 21:11:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('59', 'perangkat_ajar', '0.0083', '8.00', '11', '2026-07-31 21:11:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('60', 'presensikelas', '0.0111', '8.00', '10', '2026-07-31 21:11:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('61', 'karya', '0.0051', '8.00', '10', '2026-07-31 21:11:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('62', 'dashboard', '0.0073', '8.00', '13', '2026-07-31 21:11:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('63', 'jurnal/add', '0.0074', '8.00', '15', '2026-07-31 21:11:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('64', 'dashboard', '0.0053', '8.00', '13', '2026-07-31 21:11:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('65', 'jurnal', '0.0058', '8.00', '10', '2026-07-31 21:11:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('66', 'jurnal/jadwal', '0.0042', '8.00', '5', '2026-07-31 21:12:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('67', 'presensikelas', '0.0056', '8.00', '10', '2026-07-31 21:12:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('68', 'presensi', '0.0067', '8.00', '15', '2026-07-31 21:12:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('69', 'perkembangan', '0.0046', '8.00', '12', '2026-07-31 21:12:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('70', 'karya', '0.0043', '8.00', '10', '2026-07-31 21:12:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('71', 'dashboard', '0.0058', '8.00', '13', '2026-07-31 21:12:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('72', 'jurnal', '0.0066', '8.00', '10', '2026-07-31 21:12:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('73', 'jurnal/add', '0.0057', '8.00', '15', '2026-07-31 21:12:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('74', 'login', '0.0053', '8.00', '1', '2026-07-31 23:31:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('75', 'login', '0.0033', '8.00', '1', '2026-07-31 23:32:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('76', 'login', '0.0410', '8.00', '1', '2026-07-31 23:34:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('77', '/', '0.0397', '8.00', '1', '2026-08-01 00:00:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('78', '/', '0.0448', '8.00', '1', '2026-08-01 01:41:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('79', '/', '0.0542', '8.00', '1', '2026-08-01 02:39:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('80', '/', '0.0676', '4.00', '1', '2026-08-01 03:50:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('81', '/', '0.0413', '4.00', '1', '2026-08-01 04:44:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('82', '/', '0.0384', '4.00', '1', '2026-08-01 06:10:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('83', '/', '0.0480', '4.00', '1', '2026-08-01 09:30:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('84', '/', '0.0028', '2.00', '1', '2026-08-01 09:30:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('85', '/', '0.0402', '4.00', '1', '2026-08-01 09:50:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('86', '/', '0.0484', '4.00', '1', '2026-08-01 19:54:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('87', '/', '0.0398', '4.00', '1', '2026-08-01 20:07:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('88', '/', '0.0521', '4.00', '1', '2026-08-01 21:53:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('89', '/', '0.0385', '4.00', '1', '2026-08-01 22:05:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('90', '/', '0.0384', '4.00', '1', '2026-08-01 22:27:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('91', '/', '0.0587', '4.00', '1', '2026-08-02 01:45:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('92', '/', '0.0531', '4.00', '1', '2026-08-02 05:58:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('93', '/', '0.0532', '4.00', '1', '2026-08-02 05:58:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('94', '/', '0.0564', '4.00', '1', '2026-08-02 07:21:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('95', '/', '0.0466', '4.00', '1', '2026-08-02 14:48:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('96', '/', '0.0448', '4.00', '1', '2026-08-02 15:02:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('97', '/', '0.0448', '4.00', '1', '2026-08-02 15:04:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('98', '/', '0.0033', '2.00', '1', '2026-08-02 15:04:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('99', '/', '0.0383', '4.00', '1', '2026-08-02 21:55:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('100', '/', '0.0499', '4.00', '1', '2026-08-03 01:04:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('101', '/', '0.0392', '4.00', '1', '2026-08-03 03:36:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('102', '/', '0.0395', '4.00', '1', '2026-08-03 04:09:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('103', '/', '0.0394', '4.00', '1', '2026-08-03 05:22:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('104', '/', '0.0029', '2.00', '1', '2026-08-03 05:23:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('105', '/', '0.1200', '4.00', '1', '2026-08-03 07:03:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('106', '/', '0.0468', '4.00', '1', '2026-08-03 10:21:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('107', '/', '0.0031', '2.00', '1', '2026-08-03 10:21:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('108', '/', '0.0493', '4.00', '1', '2026-08-03 13:59:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('109', '/', '0.0399', '4.00', '1', '2026-08-03 14:01:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('110', '/', '0.0468', '4.00', '1', '2026-08-03 19:27:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('111', '/', '0.0055', '2.00', '1', '2026-08-03 19:27:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('112', '/', '0.0383', '4.00', '1', '2026-08-03 19:52:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('113', '/', '0.0391', '4.00', '1', '2026-08-03 20:25:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('114', '/', '0.0395', '4.00', '1', '2026-08-03 20:52:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('115', '/', '0.0379', '4.00', '1', '2026-08-03 21:21:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('116', 'login', '0.0398', '4.00', '1', '2026-08-03 22:12:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('117', '/', '0.0402', '4.00', '1', '2026-08-03 23:33:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('118', '/', '0.0507', '4.00', '1', '2026-08-04 00:37:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('119', '/', '0.0391', '4.00', '1', '2026-08-04 03:42:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('120', '/', '0.0434', '4.00', '1', '2026-08-04 03:47:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('121', 'login', '0.0392', '4.00', '1', '2026-08-04 03:55:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('122', '/', '0.0394', '4.00', '1', '2026-08-04 08:02:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('123', '/', '0.0412', '4.00', '1', '2026-08-04 11:06:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('124', '/', '0.0049', '2.00', '1', '2026-08-04 11:07:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('125', '/', '0.0393', '4.00', '1', '2026-08-04 11:33:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('126', '/', '0.0044', '2.00', '1', '2026-08-04 11:33:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('127', '/', '0.0047', '2.00', '1', '2026-08-04 11:33:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('128', '/', '0.0048', '2.00', '1', '2026-08-04 11:34:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('129', '/', '0.0459', '4.00', '1', '2026-08-04 11:43:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('130', '/', '0.0390', '4.00', '1', '2026-08-04 11:57:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('131', '/', '0.0496', '4.00', '1', '2026-08-04 12:33:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('132', '/', '0.0034', '2.00', '1', '2026-08-04 12:33:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('133', '/', '0.0447', '4.00', '1', '2026-08-04 15:48:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('134', 'login', '0.0402', '4.00', '1', '2026-08-04 18:36:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('135', '/', '0.0409', '4.00', '1', '2026-08-04 19:12:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('136', '/', '0.0414', '4.00', '1', '2026-08-04 22:51:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('137', '/', '0.0490', '4.00', '1', '2026-08-05 00:31:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('138', '/', '0.0451', '8.00', '1', '2026-08-05 04:42:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('139', '/', '0.0047', '8.00', '1', '2026-08-05 04:43:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('140', '/', '0.0404', '8.00', '1', '2026-08-05 07:01:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('141', '/', '0.0463', '8.00', '1', '2026-08-05 09:01:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('142', '/', '0.0413', '8.00', '1', '2026-08-05 12:53:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('143', '/', '0.0426', '8.00', '1', '2026-08-05 14:36:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('144', '/', '0.0393', '8.00', '1', '2026-08-05 15:25:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('145', '/', '0.0453', '8.00', '1', '2026-08-05 16:25:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('146', '/', '0.0306', '2.00', '1', '2026-08-05 19:40:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('147', '/', '0.0395', '4.00', '1', '2026-08-05 19:54:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('148', '/', '0.0409', '4.00', '1', '2026-08-05 21:04:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('149', '/', '0.0419', '8.00', '1', '2026-08-05 23:42:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('150', '/', '0.0500', '8.00', '1', '2026-08-06 01:05:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('151', '/', '0.0420', '4.00', '1', '2026-08-06 04:10:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('152', '/', '0.0383', '4.00', '1', '2026-08-06 04:26:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('153', '/', '0.0430', '4.00', '1', '2026-08-06 05:33:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('154', '/', '0.0438', '4.00', '1', '2026-08-06 06:10:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('155', '/', '0.0395', '4.00', '1', '2026-08-06 09:47:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('156', '/', '0.0588', '4.00', '1', '2026-08-06 13:43:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('157', '/', '0.0410', '4.00', '1', '2026-08-06 14:33:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('158', '/', '0.0443', '4.00', '1', '2026-08-06 17:20:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('159', '/', '0.0520', '4.00', '1', '2026-08-06 17:28:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('160', '/', '0.0047', '2.00', '1', '2026-08-06 17:28:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('161', 'login', '0.0039', '2.00', '1', '2026-08-06 17:29:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('162', 'login', '0.0041', '2.00', '1', '2026-08-06 17:29:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('163', 'login', '0.0037', '2.00', '1', '2026-08-06 17:29:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('164', '/', '0.0310', '2.00', '1', '2026-08-06 19:15:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('165', '/', '0.0542', '8.00', '1', '2026-08-06 20:57:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('166', '/', '0.0441', '8.00', '1', '2026-08-06 21:09:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('167', '/', '0.0595', '4.00', '1', '2026-08-07 02:15:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('168', '/', '0.0553', '4.00', '1', '2026-08-07 04:20:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('169', '/', '0.0031', '2.00', '1', '2026-08-07 04:20:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('170', '/', '0.0496', '4.00', '1', '2026-08-07 07:48:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('171', '/', '0.0477', '8.00', '1', '2026-08-07 10:11:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('172', '/', '0.0390', '8.00', '1', '2026-08-07 10:51:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('173', 'dashboard', '0.0196', '8.00', '12', '2026-08-07 10:51:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('174', 'jurnal/add', '0.0143', '8.00', '11', '2026-08-07 10:52:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('175', 'dashboard', '0.0079', '8.00', '12', '2026-08-07 10:52:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('176', 'jurnal/add', '0.0061', '8.00', '11', '2026-08-07 10:52:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('177', 'presensikelas/add/15', '0.0084', '8.00', '4', '2026-08-07 10:58:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('178', 'presensi/input/9', '0.0070', '8.00', '5', '2026-08-07 10:59:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('179', 'presensi', '0.0464', '8.00', '14', '2026-08-07 11:00:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('180', 'presensi/input/9', '0.1630', '8.00', '5', '2026-08-07 11:01:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('181', 'presensi', '0.0058', '8.00', '14', '2026-08-07 11:01:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('182', 'presensi', '0.0068', '8.00', '8', '2026-08-07 11:01:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('183', 'presensi/input/3', '0.0062', '8.00', '5', '2026-08-07 11:01:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('184', 'presensi', '0.0060', '8.00', '14', '2026-08-07 11:01:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('185', 'presensi/input/1', '0.0045', '8.00', '5', '2026-08-07 11:01:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('186', 'presensi', '0.0065', '8.00', '14', '2026-08-07 11:01:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('187', 'presensi/input/1', '0.0050', '8.00', '5', '2026-08-07 11:02:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('188', 'presensi', '0.0056', '8.00', '14', '2026-08-07 11:02:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('189', 'presensi/input/3', '0.0048', '8.00', '5', '2026-08-07 11:02:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('190', 'dashboard', '0.0065', '8.00', '12', '2026-08-07 11:02:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('191', 'jurnal/add', '0.0110', '8.00', '11', '2026-08-07 11:02:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('192', 'jurnal/add', '0.0461', '8.00', '11', '2026-08-07 11:06:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('193', 'dashboard', '0.0104', '8.00', '12', '2026-08-07 11:17:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('194', 'settings', '0.0071', '8.00', '3', '2026-08-07 11:17:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('195', 'login', '0.0030', '8.00', '1', '2026-08-07 11:17:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('196', 'login', '0.0033', '8.00', '1', '2026-08-07 11:18:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('197', 'dashboard', '0.0066', '8.00', '12', '2026-08-07 11:18:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('198', 'jurnal/add', '0.0098', '8.00', '11', '2026-08-07 11:19:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('199', 'presensikelas/add/16', '0.0063', '8.00', '4', '2026-08-07 11:20:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('200', 'presensi/input/10', '0.0067', '8.00', '5', '2026-08-07 11:21:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('201', 'presensi', '0.0080', '8.00', '15', '2026-08-07 11:21:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('202', 'dashboard', '0.0073', '8.00', '12', '2026-08-07 11:22:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('203', 'jurnal/add', '0.0055', '8.00', '11', '2026-08-07 11:22:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('204', 'login', '0.0026', '8.00', '1', '2026-08-07 11:22:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('205', 'dashboard', '0.0073', '8.00', '13', '2026-08-07 11:23:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('206', 'jurnal/add', '0.0079', '8.00', '15', '2026-08-07 11:23:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('207', 'presensikelas/add/17', '0.0042', '8.00', '4', '2026-08-07 11:25:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('208', 'presensi/input/11', '0.0043', '8.00', '5', '2026-08-07 11:25:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('209', 'presensi', '0.0071', '8.00', '17', '2026-08-07 11:26:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('210', 'presensi/rekap', '0.0064', '8.00', '6', '2026-08-07 11:26:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('211', 'presensi/rekap', '0.0084', '8.00', '7', '2026-08-07 11:26:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('212', 'presensi', '0.0125', '8.00', '17', '2026-08-07 11:27:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('213', 'login', '0.0033', '8.00', '1', '2026-08-07 11:28:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('214', 'dashboard', '0.0093', '8.00', '13', '2026-08-07 11:29:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('215', 'walikelas/program_kelas', '0.0102', '8.00', '5', '2026-08-07 11:29:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('216', 'walikelas/program_kelas', '0.0038', '8.00', '5', '2026-08-07 11:30:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('217', 'walikelas/program_kelas', '0.0063', '8.00', '5', '2026-08-07 11:31:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('218', 'dashboard', '0.0068', '8.00', '13', '2026-08-07 11:31:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('219', 'walikelas/program_kelas', '0.0422', '8.00', '5', '2026-08-07 11:33:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('220', 'dashboard', '0.0079', '8.00', '13', '2026-08-07 11:33:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('221', 'walikelas/penanganan_siswa', '0.0092', '8.00', '10', '2026-08-07 11:33:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('222', 'walikelas/penanganan_siswa', '0.0065', '8.00', '10', '2026-08-07 11:33:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('223', 'walikelas/penanganan_siswa', '0.0052', '8.00', '10', '2026-08-07 11:34:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('224', 'walikelas/penanganan_siswa', '0.0078', '8.00', '10', '2026-08-07 11:34:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('225', 'walikelas/kokurikuler', '0.0083', '8.00', '5', '2026-08-07 11:35:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('226', 'walikelas/kokurikuler', '0.0043', '8.00', '5', '2026-08-07 11:36:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('227', 'walikelas/kokurikuler', '0.0054', '8.00', '5', '2026-08-07 11:36:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('228', 'jurnal', '0.0097', '8.00', '10', '2026-08-07 11:37:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('229', 'laporan', '0.0133', '8.00', '17', '2026-08-07 11:37:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('230', 'presensikelas', '0.0096', '8.00', '10', '2026-08-07 11:37:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('231', 'presensikelas', '0.0086', '8.00', '10', '2026-08-07 11:37:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('232', 'jurnal', '0.0082', '8.00', '10', '2026-08-07 11:37:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('233', 'jurnal/add', '0.0086', '8.00', '15', '2026-08-07 11:37:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('234', 'presensikelas/add/18', '0.0075', '8.00', '4', '2026-08-07 11:41:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('235', 'presensi/input/12', '0.0059', '8.00', '5', '2026-08-07 11:42:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('236', 'presensi', '0.0068', '8.00', '14', '2026-08-07 11:42:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('237', '/', '0.0389', '8.00', '1', '2026-08-07 11:55:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('238', '/', '0.0549', '8.00', '1', '2026-08-07 15:59:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('239', '/', '0.0392', '8.00', '1', '2026-08-07 16:08:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('240', '/', '0.0398', '8.00', '1', '2026-08-07 19:32:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('241', '/', '0.0431', '8.00', '1', '2026-08-07 21:57:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('242', '/', '0.0386', '8.00', '1', '2026-08-07 22:23:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('243', '/', '0.0440', '8.00', '1', '2026-08-07 23:12:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('244', '/', '0.0383', '8.00', '1', '2026-08-07 23:26:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('245', '/', '0.0393', '8.00', '1', '2026-08-07 23:34:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('246', '/', '0.2684', '8.00', '1', '2026-08-08 02:29:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('247', '/', '0.0467', '8.00', '1', '2026-08-08 03:32:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('248', '/', '0.0410', '8.00', '1', '2026-08-08 06:32:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('249', '/', '0.0445', '8.00', '1', '2026-08-08 11:22:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('250', '/', '0.0444', '8.00', '1', '2026-08-08 15:44:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('251', '/', '0.0565', '8.00', '1', '2026-08-08 19:22:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('252', '/', '0.0381', '8.00', '1', '2026-08-08 20:31:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('253', '/', '0.0377', '8.00', '1', '2026-08-08 21:07:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('254', '/', '0.0490', '8.00', '1', '2026-08-08 23:14:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('255', '/', '0.0573', '4.00', '1', '2026-08-09 01:04:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('256', '/', '0.0396', '4.00', '1', '2026-08-09 04:05:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('257', '/', '0.0378', '4.00', '1', '2026-08-09 04:11:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('258', '/', '0.0405', '4.00', '1', '2026-08-09 09:11:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('259', '/', '0.0381', '4.00', '1', '2026-08-09 09:16:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('260', '/', '0.0470', '4.00', '1', '2026-08-09 13:44:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('261', '/', '0.0435', '4.00', '1', '2026-08-09 15:50:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('262', '/', '0.0412', '4.00', '1', '2026-08-09 16:54:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('263', '/', '0.0385', '4.00', '1', '2026-08-09 17:57:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('264', '/', '0.0570', '4.00', '1', '2026-08-09 18:03:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('265', '/', '0.0422', '4.00', '1', '2026-08-09 18:39:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('266', '/', '0.0469', '4.00', '1', '2026-08-09 21:51:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('267', '/', '0.0505', '4.00', '1', '2026-08-10 02:34:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('268', 'login', '0.0382', '4.00', '1', '2026-08-10 03:03:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('269', '/', '0.0395', '4.00', '1', '2026-08-10 04:03:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('270', '/', '0.0364', '2.00', '1', '2026-08-10 04:40:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('271', '/', '0.0290', '2.00', '1', '2026-08-10 04:58:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('272', '/', '0.0462', '4.00', '1', '2026-08-10 07:52:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('273', '/', '0.0407', '4.00', '1', '2026-08-10 08:30:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('274', '/', '0.0053', '2.00', '1', '2026-08-10 08:31:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('275', '/', '0.0389', '4.00', '1', '2026-08-10 09:07:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('276', '/', '0.0649', '4.00', '1', '2026-08-10 12:12:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('277', '/', '0.0653', '4.00', '1', '2026-08-10 13:19:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('278', '/', '0.0474', '4.00', '1', '2026-08-10 14:58:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('279', '/', '0.0411', '4.00', '1', '2026-08-10 17:21:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('280', '/', '0.0290', '2.00', '1', '2026-08-10 18:30:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('281', '/', '0.0053', '2.00', '1', '2026-08-10 18:30:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('282', '/', '0.0385', '4.00', '1', '2026-08-10 21:14:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('283', '/', '0.0468', '4.00', '1', '2026-08-11 02:53:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('284', '/', '0.0386', '4.00', '1', '2026-08-11 02:58:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('285', 'login', '0.0384', '4.00', '1', '2026-08-11 03:10:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('286', '/', '0.0422', '4.00', '1', '2026-08-11 08:38:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('287', '/', '0.0640', '4.00', '1', '2026-08-11 11:22:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('288', '/', '0.0388', '4.00', '1', '2026-08-11 12:54:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('289', '/', '0.0476', '4.00', '1', '2026-08-11 16:45:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('290', '/', '0.0426', '4.00', '1', '2026-08-11 20:05:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('291', '/', '0.0459', '4.00', '1', '2026-08-11 20:35:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('292', '/', '0.0355', '2.00', '1', '2026-08-11 23:33:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('293', '/', '0.0388', '10.00', '1', '2026-08-12 01:11:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('294', '/', '0.0530', '4.00', '1', '2026-08-12 05:00:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('295', '/', '0.0396', '10.00', '1', '2026-08-12 07:17:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('296', '/', '0.0314', '6.00', '1', '2026-08-12 09:24:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('297', '/', '0.0380', '4.00', '1', '2026-08-12 11:33:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('298', '/', '0.0443', '10.00', '1', '2026-08-12 15:51:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('299', '/', '0.0462', '4.00', '1', '2026-08-12 19:27:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('300', '/', '0.0564', '10.00', '1', '2026-08-12 22:57:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('301', '/', '0.0416', '10.00', '1', '2026-08-12 23:29:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('302', '/', '0.0422', '6.00', '1', '2026-08-13 00:20:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('303', '/', '0.0382', '4.00', '1', '2026-08-13 01:04:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('304', '/', '0.0430', '4.00', '1', '2026-08-13 02:07:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('305', '/', '0.0484', '4.00', '1', '2026-08-13 03:58:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('306', '/', '0.0399', '4.00', '1', '2026-08-13 04:12:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('307', '/', '0.0471', '4.00', '1', '2026-08-13 06:09:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('308', '/', '0.0648', '4.00', '1', '2026-08-13 10:41:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('309', 'login', '0.0466', '4.00', '1', '2026-08-13 11:13:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('310', 'dashboard', '0.0160', '2.00', '13', '2026-08-13 11:14:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('311', 'login', '0.0046', '2.00', '1', '2026-08-13 11:14:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('312', 'jurnal', '0.0122', '2.00', '10', '2026-08-13 11:14:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('313', 'jurnal', '0.0057', '2.00', '10', '2026-08-13 11:14:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('314', 'login', '0.0031', '2.00', '1', '2026-08-13 11:14:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('315', 'login', '0.0029', '2.00', '1', '2026-08-13 11:14:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('316', 'dashboard', '0.0071', '2.00', '13', '2026-08-13 11:15:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('317', 'jurnal', '0.0079', '2.00', '10', '2026-08-13 11:15:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('318', 'jurnal/jadwal', '0.0068', '2.00', '5', '2026-08-13 11:16:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('319', 'presensikelas', '0.0097', '2.00', '10', '2026-08-13 11:16:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('320', 'presensi', '0.0109', '2.00', '17', '2026-08-13 11:16:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('321', 'presensikelas', '0.0049', '2.00', '10', '2026-08-13 11:16:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('322', 'presensi', '0.0074', '2.00', '17', '2026-08-13 11:16:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('323', 'presensikelas', '0.0056', '2.00', '10', '2026-08-13 11:17:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('324', 'presensi/input/11', '0.0058', '2.00', '5', '2026-08-13 11:17:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('325', 'presensi', '0.0078', '2.00', '17', '2026-08-13 11:17:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('326', 'penilaian', '0.0099', '2.00', '13', '2026-08-13 11:17:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('327', 'karya', '0.0096', '2.00', '10', '2026-08-13 11:17:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('328', 'penilaian', '0.0052', '2.00', '13', '2026-08-13 11:17:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('329', 'perkembangan', '0.0082', '2.00', '12', '2026-08-13 11:17:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('330', 'karya', '0.0044', '2.00', '10', '2026-08-13 11:17:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('331', 'karya', '0.0092', '2.00', '10', '2026-08-13 11:20:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('332', 'karya', '0.0053', '2.00', '10', '2026-08-13 11:21:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('333', 'karya', '0.0046', '2.00', '10', '2026-08-13 11:22:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('334', 'perangkat_ajar/upload', '0.0129', '2.00', '9', '2026-08-13 11:23:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('335', 'perangkat_ajar/daftar', '0.0075', '2.00', '10', '2026-08-13 11:24:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('336', 'perangkat_ajar/detail/4', '0.0051', '2.00', '5', '2026-08-13 11:24:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('337', 'perangkat_ajar/daftar', '0.0067', '2.00', '10', '2026-08-13 11:24:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('338', 'perangkat_ajar/detail/4', '0.0063', '2.00', '5', '2026-08-13 11:24:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('339', 'perangkat_ajar', '0.0101', '2.00', '11', '2026-08-13 11:25:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('340', 'perangkat_ajar/upload', '0.0210', '2.00', '9', '2026-08-13 11:25:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('341', 'login', '0.0382', '4.00', '1', '2026-08-13 11:36:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('342', 'dashboard', '0.0103', '2.00', '12', '2026-08-13 11:36:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('343', 'jurnal/add', '0.0101', '2.00', '11', '2026-08-13 11:37:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('344', 'jurnal', '0.0054', '2.00', '6', '2026-08-13 11:37:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('345', 'jurnal/jadwal', '0.0064', '2.00', '4', '2026-08-13 11:37:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('346', 'presensikelas', '0.0601', '4.00', '6', '2026-08-13 11:40:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('347', 'karya', '0.0468', '4.00', '7', '2026-08-13 12:11:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('348', 'karya', '0.0484', '4.00', '7', '2026-08-13 13:12:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('349', '/', '0.0382', '4.00', '1', '2026-08-13 13:55:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('350', '/', '0.2451', '4.00', '1', '2026-08-13 14:33:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('351', 'login', '0.0038', '2.00', '1', '2026-08-13 14:38:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('352', 'karya', '0.0081', '2.00', '7', '2026-08-13 14:38:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('353', 'dashboard', '0.0082', '2.00', '13', '2026-08-13 14:38:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('354', '/', '0.0046', '2.00', '1', '2026-08-13 14:39:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('355', 'dashboard', '0.0056', '2.00', '12', '2026-08-13 14:39:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('356', 'dashboard', '0.0073', '2.00', '12', '2026-08-13 14:39:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('357', 'jurnal', '0.0114', '2.00', '6', '2026-08-13 14:40:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('358', 'jurnal', '0.0103', '2.00', '10', '2026-08-13 14:40:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('359', 'jurnal', '0.0080', '2.00', '6', '2026-08-13 14:40:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('360', 'jurnal/detail/16', '0.0083', '2.00', '5', '2026-08-13 14:42:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('361', 'jurnal', '0.0056', '2.00', '10', '2026-08-13 14:42:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('362', 'jurnal', '0.0050', '2.00', '6', '2026-08-13 14:42:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('363', 'jurnal/jadwal', '0.0050', '2.00', '4', '2026-08-13 14:42:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('364', 'presensikelas', '0.0075', '2.00', '6', '2026-08-13 14:42:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('365', 'perangkat_ajar', '0.0085', '2.00', '11', '2026-08-13 14:42:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('366', 'perangkat_ajar/upload', '0.0080', '2.00', '11', '2026-08-13 14:43:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('367', 'jurnal/jadwal', '0.0051', '2.00', '5', '2026-08-13 14:43:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('368', 'perangkat_ajar/daftar', '0.0264', '2.00', '11', '2026-08-13 14:43:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('369', 'perangkat_ajar/verifikasi/4', '0.0056', '2.00', '5', '2026-08-13 14:43:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('370', 'presensikelas', '0.0074', '2.00', '10', '2026-08-13 14:43:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('371', 'jurnal', '0.0056', '2.00', '10', '2026-08-13 14:43:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('372', 'perangkat_ajar/verifikasi', '0.0063', '2.00', '3', '2026-08-13 14:45:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('373', 'jurnal/detail/18', '0.0090', '2.00', '5', '2026-08-13 14:45:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('374', 'perangkat_ajar/upload', '0.0062', '2.00', '11', '2026-08-13 14:45:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('375', 'jurnal', '0.0063', '2.00', '6', '2026-08-13 14:45:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('376', 'perangkat_ajar/daftar', '0.0213', '2.00', '11', '2026-08-13 14:45:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('377', 'jurnal/jadwal', '0.0073', '2.00', '4', '2026-08-13 14:45:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('378', 'master/jadwal', '0.0129', '2.00', '11', '2026-08-13 14:46:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('379', 'master/jadwal', '0.0059', '2.00', '11', '2026-08-13 14:46:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('380', 'jurnal/jadwal', '0.0049', '2.00', '4', '2026-08-13 14:46:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('381', 'presensikelas', '0.0075', '2.00', '6', '2026-08-13 14:46:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('382', 'presensikelas', '0.0057', '2.00', '6', '2026-08-13 14:46:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('383', 'presensi/input/12', '0.0064', '2.00', '5', '2026-08-13 14:46:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('384', 'presensi/input/12', '0.0045', '2.00', '5', '2026-08-13 14:46:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('385', 'presensikelas', '0.0050', '2.00', '6', '2026-08-13 14:46:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('386', 'penilaian', '0.0091', '2.00', '7', '2026-08-13 14:46:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('387', 'jurnal', '0.0088', '2.00', '10', '2026-08-13 14:46:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('388', 'presensikelas/edit/11', '0.0045', '2.00', '4', '2026-08-13 14:46:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('389', 'jurnal/jadwal', '0.0056', '2.00', '5', '2026-08-13 14:46:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('390', 'jurnal', '0.0052', '2.00', '10', '2026-08-13 14:46:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('391', 'presensikelas', '0.0048', '2.00', '6', '2026-08-13 14:47:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('392', 'penilaian/rekap', '0.0187', '2.00', '5', '2026-08-13 14:47:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('393', 'penilaian/import_history', '0.0066', '2.00', '3', '2026-08-13 14:47:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('394', 'master/mapel', '0.0052', '2.00', '3', '2026-08-13 14:47:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('395', 'jurnal/detail/17', '0.0048', '2.00', '5', '2026-08-13 14:47:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('396', 'jurnal', '0.0080', '2.00', '10', '2026-08-13 14:48:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('397', 'jurnal/detail/17', '0.0070', '2.00', '5', '2026-08-13 14:48:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('398', 'jurnal', '0.0075', '2.00', '10', '2026-08-13 14:48:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('399', 'jurnal/jadwal', '0.0060', '2.00', '5', '2026-08-13 14:49:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('400', 'presensikelas', '0.0053', '2.00', '10', '2026-08-13 14:49:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('401', 'presensikelas/edit/11', '0.0039', '2.00', '4', '2026-08-13 14:49:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('402', 'presensikelas', '0.0465', '4.00', '10', '2026-08-13 14:52:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('403', 'master/jam_pelajaran', '0.0088', '2.00', '3', '2026-08-13 14:52:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('404', 'master/guru', '0.0080', '2.00', '9', '2026-08-13 14:53:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('405', 'presensi/input/7', '0.0104', '2.00', '5', '2026-08-13 14:54:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('406', 'presensi', '0.0077', '2.00', '17', '2026-08-13 14:54:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('407', 'presensi/input/7', '0.0050', '2.00', '5', '2026-08-13 14:54:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('408', 'presensikelas', '0.0054', '2.00', '10', '2026-08-13 14:54:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('409', 'presensi/input/10', '0.0059', '2.00', '5', '2026-08-13 14:54:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('410', 'presensikelas', '0.0059', '2.00', '10', '2026-08-13 14:54:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('411', 'master/siswa', '0.0076', '4.00', '4', '2026-08-13 14:54:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('412', 'master/jadwal', '0.0083', '2.00', '11', '2026-08-13 14:55:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('413', 'presensi/input/10', '0.0078', '2.00', '5', '2026-08-13 14:55:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('414', 'presensikelas', '0.0077', '2.00', '10', '2026-08-13 14:55:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('415', 'presensi', '0.0093', '2.00', '17', '2026-08-13 14:56:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('416', 'presensikelas', '0.0079', '2.00', '10', '2026-08-13 14:56:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('417', 'presensi', '0.0067', '2.00', '17', '2026-08-13 14:56:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('418', 'presensi', '0.0451', '4.00', '17', '2026-08-13 14:58:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('419', 'presensi/input/11', '0.0076', '2.00', '5', '2026-08-13 14:59:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('420', 'presensi', '0.0107', '2.00', '17', '2026-08-13 15:00:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('421', 'presensi/input/11', '0.0046', '2.00', '5', '2026-08-13 15:00:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('422', 'presensi', '0.0099', '2.00', '17', '2026-08-13 15:00:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('423', 'presensikelas', '0.0059', '2.00', '10', '2026-08-13 15:00:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('424', 'presensi/input/10', '0.0046', '2.00', '5', '2026-08-13 15:00:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('425', 'presensikelas', '0.0107', '2.00', '10', '2026-08-13 15:00:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('426', 'presensikelas', '0.0056', '2.00', '10', '2026-08-13 15:00:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('427', 'presensi', '0.0117', '2.00', '17', '2026-08-13 15:00:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('428', 'presensi/input/10', '0.0042', '2.00', '5', '2026-08-13 15:00:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('429', 'presensi', '0.0086', '2.00', '17', '2026-08-13 15:00:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('430', 'penilaian', '0.0101', '2.00', '13', '2026-08-13 15:01:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('431', 'penilaian', '0.0113', '2.00', '16', '2026-08-13 15:01:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('432', 'penilaian/import', '0.1467', '4.00', '5', '2026-08-13 15:06:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('433', 'penilaian', '0.0103', '2.00', '16', '2026-08-13 15:06:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('434', 'penilaian/import', '0.0171', '2.00', '5', '2026-08-13 15:07:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('435', 'penilaian', '0.0066', '2.00', '16', '2026-08-13 15:07:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('436', 'penilaian', '0.0061', '2.00', '16', '2026-08-13 15:07:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('437', 'penilaian', '0.0076', '2.00', '16', '2026-08-13 15:07:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('438', 'penilaian', '0.0106', '2.00', '17', '2026-08-13 15:08:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('439', 'penilaian', '0.0062', '2.00', '17', '2026-08-13 15:08:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('440', 'penilaian', '0.0079', '2.00', '17', '2026-08-13 15:09:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('441', 'penilaian', '0.0062', '2.00', '16', '2026-08-13 15:09:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('442', 'penilaian/rekap', '0.0704', '4.00', '10', '2026-08-13 15:11:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('443', 'karya', '0.0072', '2.00', '7', '2026-08-13 15:11:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('444', 'master/jadwal', '0.0091', '2.00', '11', '2026-08-13 15:11:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('445', 'penilaian/rekap', '0.0092', '2.00', '15', '2026-08-13 15:11:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('446', 'master/jadwal', '0.0056', '2.00', '11', '2026-08-13 15:12:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('447', 'penilaian/rekap', '0.0068', '2.00', '15', '2026-08-13 15:12:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('448', 'master/jadwal', '0.0060', '2.00', '11', '2026-08-13 15:12:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('449', 'master/jadwal', '0.0046', '2.00', '11', '2026-08-13 15:12:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('450', 'dashboard', '0.0090', '2.00', '13', '2026-08-13 15:12:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('451', 'perkembangan', '0.0364', '2.00', '12', '2026-08-13 15:13:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('452', 'penilaian/rekap', '0.0045', '2.00', '10', '2026-08-13 15:13:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('453', 'master/mapel', '0.0053', '2.00', '3', '2026-08-13 15:13:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('454', 'penilaian/rekap', '0.0099', '2.00', '15', '2026-08-13 15:13:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('455', 'penilaian/rekap', '0.0333', '2.00', '15', '2026-08-13 15:15:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('456', 'penilaian/rekap', '0.0119', '2.00', '15', '2026-08-13 15:15:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('457', 'penilaian/import_history', '0.0066', '2.00', '3', '2026-08-13 15:15:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('458', 'master/guru', '0.0081', '2.00', '9', '2026-08-13 15:15:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('459', 'penilaian/rekap', '0.0069', '2.00', '10', '2026-08-13 15:16:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('460', 'penilaian', '0.0062', '2.00', '13', '2026-08-13 15:16:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('461', 'penilaian', '0.0101', '2.00', '16', '2026-08-13 15:16:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('462', 'master/mapel', '0.0061', '2.00', '3', '2026-08-13 15:17:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('463', 'penilaian', '0.0084', '2.00', '17', '2026-08-13 15:17:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('464', 'master/guru', '0.0060', '2.00', '9', '2026-08-13 15:17:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('465', 'penilaian/rekap', '0.0071', '2.00', '10', '2026-08-13 15:17:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('466', 'penilaian/rekap', '0.0069', '2.00', '15', '2026-08-13 15:17:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('467', 'perkembangan', '0.0096', '2.00', '12', '2026-08-13 15:18:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('468', 'penilaian/import_history', '0.0042', '2.00', '3', '2026-08-13 15:18:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('469', 'perkembangan', '0.0093', '2.00', '12', '2026-08-13 15:19:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('470', 'perkembangan', '0.0094', '2.00', '14', '2026-08-13 15:19:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('471', 'perkembangan/profil/11', '0.0117', '2.00', '12', '2026-08-13 15:19:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('472', 'perkembangan', '0.0091', '2.00', '14', '2026-08-13 15:20:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('473', 'perkembangan', '0.0060', '2.00', '14', '2026-08-13 15:20:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('474', 'karya', '0.0103', '2.00', '10', '2026-08-13 15:20:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('475', '/', '0.0515', '4.00', '1', '2026-08-13 15:24:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('476', 'dashboard', '0.0095', '2.00', '12', '2026-08-13 15:25:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('477', 'jurnal', '0.0127', '2.00', '6', '2026-08-13 15:25:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('478', 'dashboard', '0.0067', '2.00', '12', '2026-08-13 15:25:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('479', 'master/siswa', '0.0112', '4.00', '4', '2026-08-13 15:25:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('480', 'master/jadwal', '0.0065', '2.00', '11', '2026-08-13 15:26:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('481', 'master/siswa', '0.0049', '2.00', '4', '2026-08-13 15:26:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('482', 'master/siswa', '0.0090', '2.00', '4', '2026-08-13 15:27:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('483', 'monitoring', '0.0109', '2.00', '28', '2026-08-13 15:28:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('484', 'laporan', '0.0143', '2.00', '14', '2026-08-13 15:28:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('485', 'logs', '0.0056', '2.00', '3', '2026-08-13 15:28:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('486', 'settings', '0.0062', '2.00', '3', '2026-08-13 15:29:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('487', 'jurnal', '0.0054', '2.00', '6', '2026-08-13 15:29:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('488', 'karya', '0.0065', '2.00', '7', '2026-08-13 15:29:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('489', 'master/tahun_pelajaran', '0.0038', '2.00', '3', '2026-08-13 15:29:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('490', 'karya', '0.0050', '2.00', '10', '2026-08-13 15:29:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('491', 'master/kelas', '0.0081', '2.00', '8', '2026-08-13 15:30:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('492', 'karya', '0.0057', '2.00', '10', '2026-08-13 15:30:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('493', 'master/guru', '0.0067', '2.00', '9', '2026-08-13 15:30:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('494', 'master/siswa', '0.0086', '2.00', '4', '2026-08-13 15:31:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('495', 'master/kelas', '0.0043', '2.00', '8', '2026-08-13 15:31:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('496', 'master/ruangan', '0.0042', '2.00', '3', '2026-08-13 15:31:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('497', 'master/mapel', '0.0038', '2.00', '3', '2026-08-13 15:32:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('498', 'master/jam_pelajaran', '0.0056', '2.00', '3', '2026-08-13 15:33:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('499', 'master/guru', '0.0074', '2.00', '9', '2026-08-13 15:34:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('500', 'perangkat_ajar', '0.0105', '2.00', '11', '2026-08-13 15:36:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('501', 'perangkat_ajar/upload', '0.0059', '2.00', '9', '2026-08-13 15:36:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('502', 'master/siswa', '0.0107', '2.00', '4', '2026-08-13 15:36:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('503', 'master/jadwal', '0.0078', '2.00', '11', '2026-08-13 15:37:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('504', 'monitoring', '0.0114', '2.00', '28', '2026-08-13 15:38:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('505', 'laporan', '0.0079', '2.00', '14', '2026-08-13 15:38:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('506', 'laporan/print_jurnal', '0.0094', '2.00', '17', '2026-08-13 15:38:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('507', 'laporan/print_jurnal', '0.0067', '2.00', '7', '2026-08-13 15:39:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('508', 'presensi', '0.0088', '2.00', '9', '2026-08-13 15:39:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('509', 'laporan', '0.0075', '2.00', '14', '2026-08-13 15:39:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('510', 'laporan/print_jurnal', '0.0098', '2.00', '7', '2026-08-13 15:40:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('511', 'perangkat_ajar/upload', '0.0078', '2.00', '9', '2026-08-13 15:40:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('512', 'logs', '0.0069', '2.00', '3', '2026-08-13 15:41:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('513', 'perangkat_ajar/upload', '0.0054', '2.00', '9', '2026-08-13 15:41:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('514', 'perkembangan', '0.0081', '2.00', '6', '2026-08-13 15:41:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('515', 'penilaian', '0.0089', '2.00', '7', '2026-08-13 15:42:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('516', 'penilaian/rekap', '0.0054', '2.00', '5', '2026-08-13 15:42:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('517', 'penilaian/rekap', '0.0093', '2.00', '10', '2026-08-13 15:42:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('518', 'perangkat_ajar/daftar', '0.0057', '2.00', '10', '2026-08-13 15:42:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('519', 'penilaian/import_history', '0.0044', '2.00', '3', '2026-08-13 15:42:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('520', 'penilaian', '0.0058', '2.00', '7', '2026-08-13 15:42:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('521', 'presensikelas', '0.0058', '2.00', '6', '2026-08-13 15:42:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('522', 'perangkat_ajar/revisi', '0.0505', '4.00', '4', '2026-08-13 15:47:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('523', 'perangkat_ajar/daftar', '0.0066', '2.00', '10', '2026-08-13 15:47:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('524', 'perangkat_ajar/detail/4', '0.0075', '2.00', '5', '2026-08-13 15:48:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('525', 'perangkat_ajar/daftar', '0.0068', '2.00', '10', '2026-08-13 15:49:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('526', 'perangkat_ajar/daftar', '0.0050', '2.00', '10', '2026-08-13 15:49:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('527', 'perangkat_ajar/detail/4', '0.0047', '2.00', '5', '2026-08-13 15:49:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('528', 'perangkat_ajar/daftar', '0.0043', '2.00', '10', '2026-08-13 15:49:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('529', 'jurnal', '0.0116', '2.00', '6', '2026-08-13 15:51:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('530', 'jurnal/jadwal', '0.0040', '2.00', '4', '2026-08-13 15:51:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('531', 'jurnal', '0.0055', '2.00', '6', '2026-08-13 15:51:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('532', 'perangkat_ajar/detail/4', '0.0067', '2.00', '5', '2026-08-13 15:52:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('533', 'perangkat_ajar/daftar', '0.0056', '2.00', '10', '2026-08-13 15:52:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('534', 'perangkat_ajar/detail/4', '0.0056', '2.00', '5', '2026-08-13 15:52:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('535', 'perangkat_ajar/upload/4', '0.0062', '2.00', '10', '2026-08-13 15:52:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('536', 'perangkat_ajar/daftar', '0.0051', '2.00', '10', '2026-08-13 15:52:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('537', 'jurnal/add', '0.0075', '2.00', '11', '2026-08-13 15:53:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('538', 'dashboard', '0.0082', '2.00', '12', '2026-08-13 15:54:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('539', 'perangkat_ajar/upload', '0.0055', '2.00', '9', '2026-08-13 15:54:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('540', 'jurnal', '0.0066', '2.00', '6', '2026-08-13 15:54:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('541', 'jurnal/jadwal', '0.0045', '2.00', '4', '2026-08-13 15:54:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('542', 'presensikelas', '0.0068', '2.00', '6', '2026-08-13 15:54:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('543', 'presensi', '0.0078', '2.00', '17', '2026-08-13 15:54:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('544', 'penilaian', '0.0072', '2.00', '7', '2026-08-13 15:55:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('545', 'penilaian/rekap', '0.0052', '2.00', '5', '2026-08-13 15:55:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('546', 'penilaian/import_history', '0.0045', '2.00', '3', '2026-08-13 15:55:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('547', 'perkembangan', '0.0065', '2.00', '6', '2026-08-13 15:55:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('548', 'karya', '0.0082', '2.00', '7', '2026-08-13 15:55:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('549', 'karya', '0.0040', '2.00', '7', '2026-08-13 15:55:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('550', 'jurnal', '0.0054', '2.00', '6', '2026-08-13 15:55:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('551', 'jurnal/jadwal', '0.0041', '2.00', '4', '2026-08-13 15:55:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('552', 'logs', '0.0077', '2.00', '3', '2026-08-13 15:56:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('553', 'laporan', '0.0127', '2.00', '14', '2026-08-13 15:56:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('554', 'presensi', '0.0066', '2.00', '9', '2026-08-13 15:56:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('555', 'presensi/rekap', '0.0030', '2.00', '4', '2026-08-13 15:56:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('556', 'presensi/rekap', '0.0049', '2.00', '5', '2026-08-13 15:56:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('557', 'presensi/print_rekap', '0.0047', '2.00', '4', '2026-08-13 15:56:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('558', 'perangkat_ajar/daftar', '0.0044', '2.00', '10', '2026-08-13 15:57:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('559', 'perangkat_ajar/daftar', '0.0042', '2.00', '10', '2026-08-13 15:57:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('560', 'perangkat_ajar/upload', '0.0046', '2.00', '9', '2026-08-13 15:57:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('561', 'presensi/rekap', '0.0044', '2.00', '4', '2026-08-13 15:57:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('562', 'master/siswa', '0.0093', '4.00', '4', '2026-08-13 15:57:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('563', 'presensi', '0.0063', '2.00', '9', '2026-08-13 15:57:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('564', 'laporan', '0.0064', '2.00', '14', '2026-08-13 15:57:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('565', 'perangkat_ajar/daftar', '0.0051', '2.00', '10', '2026-08-13 15:57:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('566', 'master/siswa', '0.0078', '4.00', '4', '2026-08-13 15:57:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('567', 'perangkat_ajar/revisi', '0.0047', '2.00', '4', '2026-08-13 15:57:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('568', 'perangkat_ajar/detail/4', '0.0045', '2.00', '5', '2026-08-13 15:57:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('569', 'master/siswa', '0.0061', '4.00', '4', '2026-08-13 15:57:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('570', 'master/siswa', '0.0041', '2.00', '4', '2026-08-13 15:57:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('571', 'perangkat_ajar/upload/4', '0.0059', '2.00', '10', '2026-08-13 15:57:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('572', 'perangkat_ajar/daftar', '0.0047', '2.00', '10', '2026-08-13 15:58:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('573', 'master/siswa', '0.0088', '4.00', '4', '2026-08-13 15:58:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('574', 'perangkat_ajar/upload', '0.0068', '2.00', '9', '2026-08-13 15:58:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('575', 'master/siswa', '0.0040', '2.00', '4', '2026-08-13 15:58:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('576', 'master/siswa', '0.0049', '2.00', '4', '2026-08-13 15:58:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('577', 'perangkat_ajar/daftar', '0.0047', '2.00', '10', '2026-08-13 15:58:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('578', 'master/guru', '0.0060', '2.00', '9', '2026-08-13 15:58:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('579', 'perangkat_ajar/upload', '0.0045', '2.00', '9', '2026-08-13 15:58:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('580', 'master/guru', '0.0041', '2.00', '9', '2026-08-13 15:58:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('581', 'perangkat_ajar/daftar', '0.0045', '2.00', '10', '2026-08-13 15:58:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('582', 'perangkat_ajar/revisi', '0.0042', '2.00', '4', '2026-08-13 15:59:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('583', 'perangkat_ajar/detail/9', '0.0044', '2.00', '5', '2026-08-13 15:59:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('584', 'master/mapel', '0.0042', '2.00', '3', '2026-08-13 15:59:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('585', 'perangkat_ajar/daftar', '0.0045', '2.00', '10', '2026-08-13 15:59:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('586', 'perangkat_ajar/revisi', '0.0065', '2.00', '4', '2026-08-13 15:59:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('587', 'perangkat_ajar/daftar', '0.0046', '2.00', '10', '2026-08-13 15:59:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('588', 'perangkat_ajar/detail/9', '0.0042', '2.00', '5', '2026-08-13 16:00:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('589', 'perangkat_ajar/detail/9', '0.0092', '2.00', '5', '2026-08-13 16:00:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('590', 'perangkat_ajar', '0.0090', '2.00', '11', '2026-08-13 16:00:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('591', 'perangkat_ajar/upload', '0.0055', '2.00', '9', '2026-08-13 16:00:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('592', 'perangkat_ajar/daftar', '0.0059', '2.00', '10', '2026-08-13 16:00:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('593', 'perangkat_ajar/upload', '0.0046', '2.00', '9', '2026-08-13 16:00:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('594', 'perangkat_ajar/daftar', '0.0065', '2.00', '10', '2026-08-13 16:00:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('595', 'perangkat_ajar/upload', '0.0046', '2.00', '9', '2026-08-13 16:00:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('596', 'perangkat_ajar/daftar', '0.0054', '2.00', '10', '2026-08-13 16:01:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('597', 'perangkat_ajar/upload', '0.0049', '2.00', '9', '2026-08-13 16:01:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('598', 'perangkat_ajar/daftar', '0.0045', '2.00', '10', '2026-08-13 16:01:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('599', 'perangkat_ajar/revisi', '0.0059', '2.00', '4', '2026-08-13 16:01:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('600', 'perangkat_ajar/detail/4', '0.0077', '2.00', '5', '2026-08-13 16:01:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('601', 'perangkat_ajar', '0.0089', '2.00', '11', '2026-08-13 16:02:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('602', 'perangkat_ajar/upload', '0.0046', '2.00', '9', '2026-08-13 16:02:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('603', 'perangkat_ajar/daftar', '0.0049', '2.00', '10', '2026-08-13 16:02:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('604', 'master/mapel', '0.0036', '2.00', '3', '2026-08-13 16:02:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('605', 'perangkat_ajar/revisi', '0.0042', '2.00', '4', '2026-08-13 16:02:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('606', 'perangkat_ajar/index', '0.0066', '2.00', '11', '2026-08-13 16:02:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('607', 'master/jam_pelajaran', '0.0040', '2.00', '3', '2026-08-13 16:03:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('608', 'master/jadwal', '0.0072', '2.00', '11', '2026-08-13 16:03:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('609', 'master/jadwal', '0.0048', '2.00', '11', '2026-08-13 16:03:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('610', 'perangkat_ajar/upload', '0.0083', '2.00', '9', '2026-08-13 16:03:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('611', 'perangkat_ajar/daftar', '0.0065', '2.00', '10', '2026-08-13 16:03:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('612', 'perangkat_ajar/revisi', '0.0052', '2.00', '4', '2026-08-13 16:03:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('613', 'perangkat_ajar/arsip', '0.0050', '2.00', '4', '2026-08-13 16:03:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('614', 'laporan', '0.0102', '2.00', '18', '2026-08-13 16:04:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('615', 'laporan/print_jurnal', '0.0464', '4.00', '5', '2026-08-13 16:05:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('616', 'laporan', '0.0097', '2.00', '18', '2026-08-13 16:06:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('617', 'presensi', '0.0084', '2.00', '11', '2026-08-13 16:06:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('618', 'presensi/input/3', '0.0062', '2.00', '5', '2026-08-13 16:06:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('619', 'presensi', '0.0067', '2.00', '17', '2026-08-13 16:06:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('620', 'master/siswa', '0.0117', '2.00', '4', '2026-08-13 16:07:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('621', 'presensi/rekap', '0.0042', '2.00', '6', '2026-08-13 16:07:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('622', 'presensi/rekap', '0.0059', '2.00', '7', '2026-08-13 16:07:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('623', 'master/siswa', '0.0066', '4.00', '4', '2026-08-13 16:07:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('624', 'laporan', '0.0085', '2.00', '18', '2026-08-13 16:07:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('625', 'presensi', '0.0050', '2.00', '11', '2026-08-13 16:07:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('626', 'presensi/input/3', '0.0050', '2.00', '5', '2026-08-13 16:07:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('627', 'presensi', '0.0061', '2.00', '17', '2026-08-13 16:07:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('628', 'laporan', '0.0088', '2.00', '18', '2026-08-13 16:07:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('629', 'master/guru', '0.0079', '2.00', '9', '2026-08-13 16:09:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('630', 'master/siswa', '0.0045', '2.00', '4', '2026-08-13 16:09:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('631', 'master/siswa', '0.0043', '2.00', '4', '2026-08-13 16:09:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('632', 'master/siswa', '0.0033', '2.00', '4', '2026-08-13 16:09:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('633', 'master/jadwal', '0.0066', '2.00', '11', '2026-08-13 16:09:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('634', 'dashboard', '0.0089', '2.00', '13', '2026-08-13 16:09:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('635', 'laporan', '0.0077', '2.00', '18', '2026-08-13 16:09:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('636', 'master/guru', '0.0051', '2.00', '9', '2026-08-13 16:09:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('637', 'laporan/print_jurnal', '0.0050', '2.00', '5', '2026-08-13 16:10:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('638', 'master/siswa', '0.0063', '2.00', '4', '2026-08-13 16:10:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('639', 'master/jadwal', '0.0078', '2.00', '11', '2026-08-13 16:10:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('640', 'master/siswa', '0.0057', '2.00', '4', '2026-08-13 16:10:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('641', 'master/siswa', '0.0066', '4.00', '4', '2026-08-13 16:11:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('642', 'laporan/print_jurnal', '0.0100', '2.00', '7', '2026-08-13 16:11:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('643', 'settings', '0.0061', '2.00', '3', '2026-08-13 16:11:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('644', 'settings', '0.0049', '2.00', '3', '2026-08-13 16:13:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('645', 'laporan', '0.0106', '2.00', '14', '2026-08-13 16:13:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('646', 'presensikelas', '0.0107', '2.00', '10', '2026-08-13 16:14:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('647', 'presensikelas/edit/7', '0.0082', '2.00', '4', '2026-08-13 16:14:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('648', 'presensikelas', '0.0055', '2.00', '10', '2026-08-13 16:15:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('649', 'presensikelas/edit/7', '0.0045', '2.00', '4', '2026-08-13 16:15:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('650', 'presensi/print_rekap', '0.0079', '2.00', '4', '2026-08-13 16:15:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('651', 'laporan/print_jurnal', '0.0047', '2.00', '7', '2026-08-13 16:15:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('652', 'presensikelas', '0.0066', '2.00', '10', '2026-08-13 16:15:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('653', 'laporan/print_jurnal', '0.0076', '2.00', '17', '2026-08-13 16:15:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('654', 'karya', '0.0052', '2.00', '7', '2026-08-13 16:15:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('655', 'login', '0.0029', '2.00', '1', '2026-08-13 16:16:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('656', 'penilaian/rekap', '0.0107', '2.00', '10', '2026-08-13 16:16:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('657', 'login', '0.0027', '2.00', '1', '2026-08-13 16:16:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('658', 'penilaian/rekap', '0.0077', '2.00', '15', '2026-08-13 16:16:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('659', 'login', '0.0035', '2.00', '1', '2026-08-13 16:16:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('660', 'dashboard', '0.0072', '2.00', '12', '2026-08-13 16:17:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('661', 'dashboard', '0.0065', '2.00', '12', '2026-08-13 16:17:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('662', 'dashboard', '0.0068', '2.00', '13', '2026-08-13 16:17:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('663', 'dashboard', '0.0081', '2.00', '12', '2026-08-13 16:17:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('664', 'dashboard', '0.0057', '2.00', '12', '2026-08-13 16:17:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('665', 'penilaian/rekap', '0.0062', '2.00', '10', '2026-08-13 16:17:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('666', 'login', '0.0029', '2.00', '1', '2026-08-13 16:17:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('667', 'penilaian/rekap', '0.0073', '2.00', '15', '2026-08-13 16:17:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('668', 'login', '0.0026', '2.00', '1', '2026-08-13 16:17:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('669', 'dashboard', '0.0072', '2.00', '12', '2026-08-13 16:18:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('670', 'master/guru', '0.0099', '2.00', '9', '2026-08-13 16:18:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('671', 'login', '0.0032', '2.00', '1', '2026-08-13 16:18:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('672', 'dashboard', '0.0053', '2.00', '13', '2026-08-13 16:18:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('673', 'karya', '0.0049', '2.00', '10', '2026-08-13 16:18:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('674', 'jurnal', '0.0099', '2.00', '10', '2026-08-13 16:19:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('675', 'jurnal/detail/18', '0.0051', '2.00', '5', '2026-08-13 16:19:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('676', 'jurnal', '0.0076', '2.00', '10', '2026-08-13 16:20:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('677', 'jurnal/jadwal', '0.0073', '2.00', '5', '2026-08-13 16:20:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('678', 'presensikelas', '0.0066', '2.00', '10', '2026-08-13 16:20:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('679', 'presensi', '0.0066', '2.00', '14', '2026-08-13 16:21:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('680', 'laporan', '0.0530', '4.00', '17', '2026-08-13 16:22:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('681', 'jurnal/jadwal', '0.0085', '2.00', '5', '2026-08-13 16:22:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('682', 'presensikelas', '0.0080', '2.00', '10', '2026-08-13 16:22:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('683', 'presensi', '0.0081', '2.00', '14', '2026-08-13 16:22:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('684', 'walikelas', '0.0110', '2.00', '7', '2026-08-13 16:23:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('685', 'walikelas/program_kelas', '0.0047', '2.00', '5', '2026-08-13 16:23:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('686', 'walikelas/penanganan_siswa', '0.0068', '2.00', '10', '2026-08-13 16:23:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('687', 'walikelas/kokurikuler', '0.0051', '2.00', '5', '2026-08-13 16:23:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('688', 'laporan', '0.0079', '2.00', '17', '2026-08-13 16:23:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('689', 'walikelas', '0.0435', '4.00', '7', '2026-08-13 16:25:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('690', 'walikelas/program_kelas', '0.0042', '2.00', '5', '2026-08-13 16:25:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('691', 'walikelas/penanganan_siswa', '0.0086', '2.00', '10', '2026-08-13 16:26:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('692', 'walikelas/kokurikuler', '0.0048', '4.00', '5', '2026-08-13 16:27:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('693', 'walikelas/penanganan_siswa', '0.0435', '4.00', '10', '2026-08-13 16:29:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('694', 'walikelas/kokurikuler', '0.0072', '2.00', '5', '2026-08-13 16:29:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('695', 'walikelas', '0.0071', '2.00', '7', '2026-08-13 16:29:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('696', 'walikelas/program_kelas', '0.0045', '2.00', '5', '2026-08-13 16:29:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('697', 'walikelas/penanganan_siswa', '0.0079', '2.00', '10', '2026-08-13 16:29:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('698', 'walikelas/kokurikuler', '0.0069', '2.00', '5', '2026-08-13 16:30:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('699', 'walikelas/penanganan_siswa', '0.0083', '2.00', '10', '2026-08-13 16:31:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('700', 'login', '0.0035', '2.00', '1', '2026-08-13 16:33:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('701', 'dashboard', '0.0094', '2.00', '12', '2026-08-13 16:33:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('702', 'jurnal', '0.0079', '2.00', '6', '2026-08-13 16:33:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('703', 'jurnal/jadwal', '0.0043', '2.00', '4', '2026-08-13 16:33:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('704', 'presensikelas', '0.0077', '2.00', '6', '2026-08-13 16:33:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('705', 'jurnal/jadwal', '0.0038', '2.00', '4', '2026-08-13 16:33:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('706', 'jurnal', '0.0049', '2.00', '6', '2026-08-13 16:33:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('707', 'jurnal/jadwal', '0.0056', '2.00', '4', '2026-08-13 16:33:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('708', 'presensikelas', '0.0059', '2.00', '6', '2026-08-13 16:33:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('709', 'presensi', '0.0077', '2.00', '17', '2026-08-13 16:33:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('710', 'penilaian', '0.0124', '2.00', '7', '2026-08-13 16:33:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('711', 'penilaian', '0.0062', '2.00', '10', '2026-08-13 16:34:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('712', 'penilaian/rekap', '0.0041', '2.00', '5', '2026-08-13 16:34:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('713', 'penilaian/import_history', '0.0048', '2.00', '3', '2026-08-13 16:34:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('714', 'perkembangan', '0.0064', '2.00', '6', '2026-08-13 16:34:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('715', 'master/guru', '0.0115', '2.00', '9', '2026-08-13 16:34:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('716', 'master/guru', '0.0076', '2.00', '26', '2026-08-13 16:34:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('717', 'master/guru', '0.0070', '2.00', '24', '2026-08-13 16:34:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('718', 'master/guru', '0.0072', '2.00', '24', '2026-08-13 16:35:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('719', 'master/guru', '0.0070', '2.00', '24', '2026-08-13 16:35:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('720', 'master/guru', '0.0057', '2.00', '24', '2026-08-13 16:35:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('721', 'master/guru', '0.0065', '2.00', '24', '2026-08-13 16:36:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('722', 'master/mapel', '0.0053', '2.00', '3', '2026-08-13 16:36:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('723', 'master/guru', '0.0071', '2.00', '24', '2026-08-13 16:36:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('724', 'master/guru', '0.0072', '2.00', '24', '2026-08-13 16:36:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('725', 'laporan', '0.0152', '2.00', '29', '2026-08-13 16:37:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('726', 'settings', '0.0059', '2.00', '3', '2026-08-13 16:37:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('727', 'master/kelas', '0.0100', '2.00', '23', '2026-08-13 16:38:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('728', 'master/guru', '0.0068', '2.00', '24', '2026-08-13 16:38:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('729', 'master/guru', '0.0075', '2.00', '22', '2026-08-13 16:38:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('730', 'master/guru', '0.0086', '2.00', '22', '2026-08-13 16:38:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('731', 'master/guru', '0.0082', '2.00', '22', '2026-08-13 16:39:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('732', 'master/guru', '0.0080', '2.00', '22', '2026-08-13 16:40:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('733', 'master/kelas', '0.0064', '2.00', '21', '2026-08-13 16:40:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('734', '/', '0.2204', '6.00', '1', '2026-08-14 11:55:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('735', '/', '0.0605', '6.00', '1', '2026-08-14 11:56:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('736', '/', '0.0673', '6.00', '1', '2026-08-14 12:03:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('737', '/', '0.0671', '6.00', '1', '2026-08-14 12:04:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('738', '/', '0.0794', '6.00', '1', '2026-08-14 12:06:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('739', 'login', '0.0572', '6.00', '1', '2026-08-14 12:06:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('740', 'dashboard', '0.1069', '6.00', '13', '2026-08-14 12:07:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('741', 'login', '0.0689', '6.00', '1', '2026-08-14 12:07:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('742', 'dashboard', '0.0689', '6.00', '13', '2026-08-14 12:07:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('743', 'login', '0.0671', '6.00', '1', '2026-08-14 12:38:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('744', 'dashboard', '0.0832', '6.00', '13', '2026-08-14 12:38:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('745', 'master/guru', '0.0863', '8.00', '25', '2026-08-14 12:38:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('746', 'master/guru', '0.0834', '8.00', '26', '2026-08-14 12:39:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('747', 'master/guru', '0.0944', '8.00', '26', '2026-08-14 12:39:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('748', 'master/guru', '0.1101', '8.00', '26', '2026-08-14 12:40:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('749', 'master/guru', '0.0696', '8.00', '26', '2026-08-14 12:40:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('750', 'master/guru', '0.0791', '8.00', '27', '2026-08-14 12:42:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('751', 'login', '0.0591', '6.00', '1', '2026-08-14 12:42:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('752', 'dashboard', '0.0770', '6.00', '14', '2026-08-14 12:42:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('753', 'login', '0.0568', '6.00', '1', '2026-08-14 12:42:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('754', 'dashboard', '0.0885', '6.00', '3', '2026-08-14 12:43:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('755', 'master/guru', '0.0735', '8.00', '27', '2026-08-14 12:43:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('756', 'login', '0.0059', '2.00', '1', '2026-08-14 19:49:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('757', 'dashboard', '0.0080', '2.00', '13', '2026-08-14 19:49:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('758', 'master/guru', '0.0076', '2.00', '27', '2026-08-14 19:49:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('759', 'master/guru', '0.0081', '2.00', '27', '2026-08-14 19:50:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('760', '/', '0.0408', '4.00', '1', '2026-08-14 20:17:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('761', 'login', '0.0025', '2.00', '1', '2026-08-14 20:17:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('762', 'login', '0.0025', '2.00', '1', '2026-08-14 20:17:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('763', 'login', '0.0025', '2.00', '1', '2026-08-14 20:18:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('764', 'login', '0.0023', '2.00', '1', '2026-08-14 20:18:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('765', 'login', '0.0023', '2.00', '1', '2026-08-14 20:18:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('766', 'dashboard', '0.0103', '2.00', '13', '2026-08-14 20:19:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('767', 'login', '0.0026', '2.00', '1', '2026-08-14 20:19:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('768', 'login', '0.0045', '2.00', '1', '2026-08-14 20:20:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('769', 'dashboard', '0.0046', '2.00', '3', '2026-08-14 20:20:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('770', 'master/guru', '0.0157', '4.00', '27', '2026-08-14 20:20:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('771', 'login', '0.0023', '2.00', '1', '2026-08-14 20:20:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('772', 'login', '0.0023', '2.00', '1', '2026-08-14 20:21:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('773', 'master/guru', '0.0085', '2.00', '27', '2026-08-14 20:21:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('774', 'login', '0.0036', '2.00', '1', '2026-08-14 20:21:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('775', 'login', '0.0031', '2.00', '1', '2026-08-14 20:23:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('776', 'dashboard', '0.0065', '2.00', '3', '2026-08-14 20:23:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('777', 'dashboard', '0.0057', '2.00', '3', '2026-08-14 20:24:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('778', 'master/guru', '0.0202', '4.00', '27', '2026-08-14 20:24:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('779', 'master/guru', '0.0101', '2.00', '27', '2026-08-14 20:24:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('780', 'master/guru', '0.0106', '2.00', '27', '2026-08-14 20:25:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('781', 'master/guru', '0.0083', '2.00', '27', '2026-08-14 20:25:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('782', 'master/guru', '0.0077', '2.00', '27', '2026-08-14 20:25:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('783', 'master/guru', '0.0079', '2.00', '27', '2026-08-14 20:26:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('784', 'master/guru', '0.0069', '2.00', '26', '2026-08-14 20:26:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('785', 'master/guru', '0.0072', '2.00', '26', '2026-08-14 20:26:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('786', 'master/guru', '0.0061', '2.00', '26', '2026-08-14 20:26:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('787', 'master/guru', '0.0086', '2.00', '26', '2026-08-14 20:27:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('788', 'master/guru', '0.0099', '2.00', '26', '2026-08-14 20:27:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('789', 'master/guru', '0.0083', '2.00', '26', '2026-08-14 20:27:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('790', 'master/guru', '0.0071', '2.00', '25', '2026-08-14 20:28:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('791', 'master/guru', '0.0074', '2.00', '25', '2026-08-14 20:28:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('792', 'master/guru', '0.0071', '2.00', '25', '2026-08-14 20:28:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('793', 'master/guru', '0.0060', '2.00', '25', '2026-08-14 20:28:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('794', 'master/guru', '0.0086', '2.00', '25', '2026-08-14 20:28:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('795', 'master/guru', '0.0101', '2.00', '25', '2026-08-14 20:29:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('796', 'master/guru', '0.0086', '2.00', '25', '2026-08-14 20:29:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('797', 'master/guru', '0.0083', '2.00', '25', '2026-08-14 20:29:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('798', '/', '0.0050', '2.00', '1', '2026-08-14 20:30:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('799', 'master/guru', '0.0129', '2.00', '25', '2026-08-14 20:30:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('800', 'master/guru', '0.0096', '2.00', '25', '2026-08-14 20:31:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('801', 'master/siswa', '0.0100', '4.00', '5', '2026-08-14 20:31:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('802', 'login', '0.0052', '2.00', '1', '2026-08-14 20:32:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('803', 'master/siswa', '0.0085', '4.00', '5', '2026-08-14 20:32:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('804', 'master/siswa', '0.0058', '2.00', '5', '2026-08-14 20:32:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('805', 'master/siswa', '0.0063', '2.00', '5', '2026-08-14 20:32:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('806', 'laporan', '0.0213', '2.00', '30', '2026-08-14 20:33:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('807', 'laporan', '0.0142', '2.00', '30', '2026-08-14 20:37:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('808', 'jurnal', '0.0147', '2.00', '7', '2026-08-14 20:37:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('809', 'walikelas/penanganan_siswa', '0.0133', '2.00', '12', '2026-08-14 20:38:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('810', 'walikelas/rekap_pelanggaran', '0.0097', '2.00', '7', '2026-08-14 20:38:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('811', 'jurnal/add', '0.0088', '2.00', '27', '2026-08-14 20:38:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('812', 'laporan', '0.0088', '6.00', '30', '2026-08-14 20:38:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('813', 'login', '0.0044', '2.00', '1', '2026-08-14 20:38:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('814', 'dashboard', '0.0080', '2.00', '13', '2026-08-14 20:39:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('815', 'laporan', '0.0090', '2.00', '30', '2026-08-14 20:39:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('816', 'login', '0.0023', '2.00', '1', '2026-08-14 20:39:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('817', 'dashboard', '0.0058', '2.00', '13', '2026-08-14 20:40:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('818', 'jurnal/add', '0.0086', '2.00', '27', '2026-08-14 20:40:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('819', 'login', '0.0024', '2.00', '1', '2026-08-14 20:40:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('820', 'login', '0.0031', '2.00', '1', '2026-08-14 20:41:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('821', 'dashboard', '0.0061', '2.00', '13', '2026-08-14 20:41:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('822', 'master/mapel', '0.0079', '2.00', '26', '2026-08-14 20:41:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('823', 'master/tahun_pelajaran', '0.0039', '2.00', '4', '2026-08-14 20:41:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('824', 'master/mapel', '0.0079', '2.00', '26', '2026-08-14 20:42:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('825', 'master/mapel', '0.0080', '2.00', '26', '2026-08-14 20:42:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('826', 'dashboard', '0.0035', '2.00', '3', '2026-08-14 20:42:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('827', 'jurnal/add', '0.0094', '2.00', '27', '2026-08-14 20:42:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('828', 'master/mapel', '0.0066', '2.00', '26', '2026-08-14 20:43:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('829', 'login', '0.0022', '2.00', '1', '2026-08-14 20:43:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('830', 'dashboard', '0.0068', '2.00', '13', '2026-08-14 20:44:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('831', 'jurnal/add', '0.0073', '2.00', '27', '2026-08-14 20:44:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('832', 'login', '0.0025', '2.00', '1', '2026-08-14 20:45:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('833', 'login', '0.0071', '2.00', '1', '2026-08-14 20:45:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('834', 'dashboard', '0.0074', '2.00', '13', '2026-08-14 20:45:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('835', 'jurnal', '0.0079', '2.00', '7', '2026-08-14 20:45:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('836', 'jurnal/add', '0.0094', '2.00', '27', '2026-08-14 20:45:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('837', 'login', '0.0025', '2.00', '1', '2026-08-14 20:45:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('838', 'dashboard', '0.0073', '2.00', '13', '2026-08-14 20:45:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('839', 'login', '0.0061', '2.00', '1', '2026-08-14 21:14:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('840', 'dashboard', '0.0104', '2.00', '13', '2026-08-14 21:14:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('841', 'jurnal/jadwal', '0.0073', '2.00', '5', '2026-08-14 21:14:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('842', 'jurnal', '0.0047', '2.00', '7', '2026-08-14 21:14:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('843', 'jurnal', '0.0084', '2.00', '7', '2026-08-14 21:14:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('844', 'jurnal', '0.0056', '2.00', '7', '2026-08-14 21:14:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('845', 'jurnal', '0.0041', '2.00', '7', '2026-08-14 21:14:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('846', 'jurnal', '0.0083', '2.00', '7', '2026-08-14 21:14:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('847', 'jurnal', '0.0046', '2.00', '7', '2026-08-14 21:14:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('848', '/', '0.0046', '2.00', '1', '2026-08-14 21:15:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('849', 'login', '0.0030', '2.00', '1', '2026-08-14 21:16:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('850', 'dashboard', '0.0060', '2.00', '13', '2026-08-14 21:16:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('851', 'laporan', '0.0150', '2.00', '30', '2026-08-14 21:16:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('852', 'login', '0.0030', '2.00', '1', '2026-08-14 21:17:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('853', 'laporan', '0.0087', '2.00', '30', '2026-08-14 21:17:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('854', 'jurnal', '0.0442', '4.00', '7', '2026-08-14 21:19:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('855', 'jurnal/add', '0.0108', '2.00', '27', '2026-08-14 21:19:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('856', 'presensikelas/add/24', '0.0077', '2.00', '7', '2026-08-14 21:20:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('857', 'presensi/input/13', '0.0065', '2.00', '6', '2026-08-14 21:20:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('858', 'dashboard', '0.0062', '2.00', '13', '2026-08-14 21:22:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('859', 'master/ruangan', '0.0094', '2.00', '4', '2026-08-14 21:22:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('860', '/', '0.0044', '2.00', '1', '2026-08-14 21:23:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('861', '/', '0.0575', '2.00', '1', '2026-08-15 03:10:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('862', '/', '0.0383', '4.00', '1', '2026-08-15 03:42:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('863', '/', '0.0532', '2.00', '1', '2026-08-15 07:14:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('864', '/', '0.0287', '2.00', '1', '2026-08-15 07:47:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('865', 'login', '0.0451', '4.00', '1', '2026-08-15 08:07:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('866', '/', '0.0444', '4.00', '1', '2026-08-15 09:16:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('867', '/', '0.0453', '4.00', '1', '2026-08-15 09:40:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('868', '/', '0.0383', '4.00', '1', '2026-08-15 10:23:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('869', '/', '0.0046', '2.00', '1', '2026-08-15 10:24:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('870', '/', '0.0567', '4.00', '1', '2026-08-15 12:00:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('871', 'login', '0.0396', '4.00', '1', '2026-08-15 13:07:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('872', '/', '0.0391', '4.00', '1', '2026-08-15 13:43:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('873', '/', '0.0389', '4.00', '1', '2026-08-15 14:05:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('874', '/', '0.0413', '4.00', '1', '2026-08-15 15:22:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('875', 'login', '0.0389', '4.00', '1', '2026-08-15 16:36:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('876', 'login', '0.0024', '2.00', '1', '2026-08-15 16:36:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('877', '/', '0.0452', '4.00', '1', '2026-08-15 17:48:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('878', '/', '0.0381', '4.00', '1', '2026-08-15 18:55:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('879', 'master/ruangan', '0.3558', '2.00', '4', '2026-08-15 18:56:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('880', 'master/ruangan', '0.0042', '2.00', '4', '2026-08-15 18:56:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('881', '/', '0.0378', '4.00', '1', '2026-08-15 18:58:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('882', 'dashboard', '0.0179', '2.00', '13', '2026-08-15 20:12:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('883', 'master/ruangan', '0.0089', '2.00', '4', '2026-08-15 20:12:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('884', 'master/ruangan', '0.0049', '2.00', '4', '2026-08-15 20:13:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('885', 'master/ruangan', '0.0034', '2.00', '4', '2026-08-15 20:13:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('886', 'master/ruangan', '0.0030', '2.00', '4', '2026-08-15 20:13:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('887', 'master/ruangan', '0.0057', '2.00', '4', '2026-08-15 20:13:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('888', 'master/ruangan', '0.0038', '2.00', '4', '2026-08-15 20:14:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('889', 'master/ruangan', '0.0041', '2.00', '4', '2026-08-15 20:14:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('890', 'master/ruangan', '0.0048', '2.00', '4', '2026-08-15 20:15:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('891', 'master/ruangan', '0.0039', '2.00', '4', '2026-08-15 20:15:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('892', 'master/ruangan', '0.0035', '2.00', '4', '2026-08-15 20:16:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('893', 'master/kelas', '0.0116', '2.00', '24', '2026-08-15 20:16:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('894', 'master/kelas', '0.0083', '2.00', '24', '2026-08-15 20:16:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('895', 'master/kelas', '0.0064', '2.00', '24', '2026-08-15 20:16:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('896', 'master/kelas', '0.0068', '2.00', '24', '2026-08-15 20:17:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('897', 'master/kelas', '0.0064', '2.00', '24', '2026-08-15 20:17:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('898', 'master/kelas', '0.0064', '2.00', '24', '2026-08-15 20:17:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('899', 'master/kelas', '0.0064', '2.00', '24', '2026-08-15 20:17:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('900', 'master/guru', '0.0082', '2.00', '25', '2026-08-15 20:17:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('901', 'master/mapel', '0.0127', '2.00', '26', '2026-08-15 20:18:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('902', 'master/mapel', '0.0105', '2.00', '26', '2026-08-15 20:20:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('903', 'master/mapel', '0.0070', '2.00', '26', '2026-08-15 20:20:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('904', 'master/mapel', '0.0061', '2.00', '26', '2026-08-15 20:20:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('905', 'master/mapel', '0.0060', '2.00', '26', '2026-08-15 20:20:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('906', 'master/mapel', '0.0073', '2.00', '26', '2026-08-15 20:22:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('907', 'login', '0.0046', '2.00', '1', '2026-08-15 20:22:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('908', 'master/mapel', '0.0081', '2.00', '26', '2026-08-15 20:22:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('909', 'master/mapel', '0.0068', '2.00', '26', '2026-08-15 20:22:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('910', 'master/mapel', '0.0070', '2.00', '26', '2026-08-15 20:23:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('911', 'master/mapel', '0.0072', '2.00', '26', '2026-08-15 20:24:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('912', 'master/mapel', '0.0118', '2.00', '26', '2026-08-15 20:25:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('913', 'master/mapel', '0.0096', '2.00', '26', '2026-08-15 20:25:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('914', 'master/mapel', '0.0076', '2.00', '26', '2026-08-15 20:26:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('915', 'master/mapel', '0.0076', '2.00', '26', '2026-08-15 20:26:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('916', 'master/mapel', '0.0092', '2.00', '26', '2026-08-15 20:27:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('917', 'master/mapel', '0.0075', '2.00', '26', '2026-08-15 20:28:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('918', 'master/mapel', '0.0080', '2.00', '26', '2026-08-15 20:29:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('919', 'master/mapel', '0.0126', '2.00', '26', '2026-08-15 20:30:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('920', 'master/mapel', '0.0093', '2.00', '26', '2026-08-15 20:30:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('921', 'master/mapel', '0.0094', '2.00', '26', '2026-08-15 20:31:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('922', 'master/mapel', '0.0092', '2.00', '26', '2026-08-15 20:32:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('923', 'master/mapel', '0.0114', '2.00', '26', '2026-08-15 20:32:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('924', 'dashboard', '0.0098', '2.00', '13', '2026-08-15 20:33:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('925', 'master/mapel', '0.0082', '2.00', '26', '2026-08-15 20:34:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('926', 'login', '0.0047', '2.00', '1', '2026-08-15 20:35:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('927', 'master/mapel', '0.0118', '2.00', '26', '2026-08-15 20:35:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('928', 'master/mapel', '0.0075', '2.00', '26', '2026-08-15 20:36:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('929', 'master/mapel', '0.0113', '2.00', '26', '2026-08-15 20:36:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('930', 'master/mapel', '0.0087', '2.00', '26', '2026-08-15 20:37:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('931', 'master/mapel', '0.0101', '2.00', '26', '2026-08-15 20:38:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('932', 'master/mapel', '0.0081', '2.00', '26', '2026-08-15 20:39:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('933', 'master/mapel', '0.0089', '2.00', '26', '2026-08-15 20:39:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('934', 'master/mapel', '0.0086', '2.00', '26', '2026-08-15 20:40:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('935', 'master/mapel', '0.0099', '2.00', '26', '2026-08-15 20:40:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('936', 'master/mapel', '0.0085', '2.00', '26', '2026-08-15 20:41:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('937', 'master/mapel', '0.0082', '2.00', '26', '2026-08-15 20:41:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('938', 'master/mapel', '0.0119', '2.00', '26', '2026-08-15 20:42:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('939', 'master/mapel', '0.0082', '2.00', '26', '2026-08-15 20:42:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('940', 'master/jam_pelajaran', '0.0067', '2.00', '4', '2026-08-15 20:43:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('941', 'master/jam_pelajaran', '0.0033', '2.00', '4', '2026-08-15 20:44:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('942', 'master/jam_pelajaran', '0.0036', '2.00', '4', '2026-08-15 20:44:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('943', 'master/jam_pelajaran', '0.0034', '2.00', '4', '2026-08-15 20:44:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('944', 'master/jam_pelajaran', '0.0037', '2.00', '4', '2026-08-15 20:45:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('945', 'master/jam_pelajaran', '0.0047', '2.00', '4', '2026-08-15 20:45:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('946', 'master/jam_pelajaran', '0.0036', '2.00', '4', '2026-08-15 20:46:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('947', 'master/jam_pelajaran', '0.0059', '2.00', '4', '2026-08-15 20:46:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('948', 'master/jam_pelajaran', '0.0045', '2.00', '4', '2026-08-15 20:47:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('949', 'master/jam_pelajaran', '0.0037', '2.00', '4', '2026-08-15 20:47:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('950', 'master/kelas', '0.0082', '2.00', '24', '2026-08-15 20:47:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('951', 'master/ruangan', '0.0039', '2.00', '4', '2026-08-15 20:47:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('952', 'master/jadwal', '0.0099', '2.00', '27', '2026-08-15 20:48:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('953', 'jurnal', '0.0489', '4.00', '7', '2026-08-15 20:49:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('954', 'jurnal/add', '0.0077', '2.00', '27', '2026-08-15 20:49:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('955', '/', '0.0448', '4.00', '1', '2026-08-15 21:31:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('956', '/', '0.0037', '2.00', '1', '2026-08-15 21:32:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('957', '/', '0.0962', '4.00', '1', '2026-08-16 01:39:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('958', 'login', '0.0433', '4.00', '1', '2026-08-16 06:46:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('959', '/', '0.0391', '4.00', '1', '2026-08-16 06:56:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('960', '/', '0.0404', '4.00', '1', '2026-08-16 11:40:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('961', '/', '0.0445', '4.00', '1', '2026-08-16 14:41:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('962', '/', '0.0384', '4.00', '1', '2026-08-16 14:50:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('963', '/', '0.0392', '4.00', '1', '2026-08-16 15:04:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('964', '/', '0.0391', '4.00', '1', '2026-08-16 15:15:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('965', 'dashboard', '0.0212', '2.00', '13', '2026-08-16 15:16:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('966', 'master/mapel', '0.0224', '4.00', '26', '2026-08-16 15:16:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('967', 'login', '0.0030', '2.00', '1', '2026-08-16 15:16:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('968', 'master/mapel', '0.0090', '2.00', '26', '2026-08-16 15:16:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('969', 'master/jam_pelajaran', '0.0055', '2.00', '4', '2026-08-16 15:16:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('970', 'master/jadwal', '0.0077', '2.00', '27', '2026-08-16 15:16:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('971', '/', '0.0395', '4.00', '1', '2026-08-16 16:07:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('972', '/', '0.0576', '4.00', '1', '2026-08-16 20:02:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('973', '/', '0.0372', '4.00', '1', '2026-08-16 23:48:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('974', '/', '0.0702', '4.00', '1', '2026-08-17 00:04:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('975', '/', '0.0846', '4.00', '1', '2026-08-17 00:09:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('976', '/', '0.0385', '4.00', '1', '2026-08-17 00:14:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('977', '/', '0.0024', '2.00', '1', '2026-08-17 00:14:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('978', '/', '0.0387', '4.00', '1', '2026-08-17 00:20:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('979', '/', '0.0390', '4.00', '1', '2026-08-17 00:20:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('980', 'login', '0.0381', '4.00', '1', '2026-08-17 00:34:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('981', '/', '0.0385', '4.00', '1', '2026-08-17 00:36:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('982', '/', '0.0381', '4.00', '1', '2026-08-17 03:14:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('983', '/', '0.0376', '4.00', '1', '2026-08-17 04:17:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('984', 'login', '0.0424', '2.00', '1', '2026-08-17 08:10:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('985', '/', '0.1026', '2.00', '1', '2026-08-17 10:43:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('986', '/', '0.0402', '4.00', '1', '2026-08-17 11:32:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('987', '/', '0.0392', '4.00', '1', '2026-08-17 15:55:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('988', '/', '0.0408', '4.00', '1', '2026-08-17 19:15:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('989', 'dashboard', '0.0142', '2.00', '13', '2026-08-17 19:16:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('990', 'jurnal', '0.0092', '2.00', '7', '2026-08-17 19:16:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('991', 'jurnal/add', '0.0076', '2.00', '27', '2026-08-17 19:16:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('992', 'presensikelas/add/25', '0.0077', '2.00', '7', '2026-08-17 19:16:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('993', 'jurnal', '0.0464', '4.00', '7', '2026-08-17 19:22:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('994', 'jurnal', '0.0045', '2.00', '7', '2026-08-17 19:22:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('995', 'jurnal/add', '0.0098', '2.00', '27', '2026-08-17 19:22:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('996', 'presensikelas/add/26', '0.0070', '2.00', '7', '2026-08-17 19:23:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('997', 'presensi/input/14', '0.0087', '2.00', '6', '2026-08-17 19:23:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('998', 'presensi', '0.0054', '2.00', '8', '2026-08-17 19:23:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('999', 'jurnal', '0.0060', '2.00', '7', '2026-08-17 19:24:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1000', 'jurnal/detail/26', '0.0051', '2.00', '6', '2026-08-17 19:24:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1001', 'jurnal', '0.0049', '2.00', '7', '2026-08-17 19:24:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1002', 'jurnal', '0.0041', '2.00', '7', '2026-08-17 19:24:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1003', 'jurnal/add', '0.0081', '2.00', '27', '2026-08-17 19:24:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1004', 'presensikelas/add/27', '0.0068', '2.00', '7', '2026-08-17 19:25:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1005', 'dashboard', '0.0080', '2.00', '13', '2026-08-17 19:25:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1006', 'dashboard', '0.0033', '2.00', '3', '2026-08-17 19:25:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1007', '/', '0.0438', '4.00', '1', '2026-08-17 19:40:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1008', 'dashboard', '0.0451', '4.00', '13', '2026-08-17 19:48:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1009', 'jurnal', '0.0068', '2.00', '7', '2026-08-17 19:48:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1010', 'jurnal', '0.0071', '2.00', '7', '2026-08-17 19:48:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1011', 'google_drive_sync', '0.4790', '2.00', '11', '2026-08-17 19:48:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1012', 'jurnal', '0.0058', '2.00', '7', '2026-08-17 19:48:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1013', 'jurnal/add', '0.0077', '2.00', '27', '2026-08-17 19:48:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1014', 'presensikelas/add/28', '0.0069', '2.00', '7', '2026-08-17 19:49:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1015', 'presensi/input/15', '0.0069', '2.00', '6', '2026-08-17 19:49:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1016', 'presensi', '0.0058', '2.00', '8', '2026-08-17 19:49:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1017', 'google_drive_sync', '0.4254', '2.00', '11', '2026-08-17 19:49:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1018', 'google_drive_sync', '0.4679', '2.00', '11', '2026-08-17 19:49:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1019', 'jurnal', '0.0056', '2.00', '7', '2026-08-17 19:49:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1020', 'jurnal/detail/28', '0.0053', '2.00', '6', '2026-08-17 19:49:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1021', 'jurnal', '0.0067', '2.00', '7', '2026-08-17 19:50:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1022', 'jurnal', '0.0051', '2.00', '7', '2026-08-17 19:50:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1023', 'jurnal/add', '0.0134', '2.00', '27', '2026-08-17 19:50:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1024', 'presensikelas/add/29', '0.0070', '2.00', '7', '2026-08-17 19:51:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1025', 'presensi/input/16', '0.0059', '2.00', '6', '2026-08-17 19:51:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1026', 'presensi', '0.0058', '2.00', '8', '2026-08-17 19:51:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1027', 'google_drive_sync', '0.5037', '2.00', '11', '2026-08-17 19:51:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1028', 'google_drive_sync', '0.4736', '2.00', '11', '2026-08-17 19:51:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1029', 'jurnal', '0.0445', '4.00', '7', '2026-08-17 19:53:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1030', 'jurnal', '0.0041', '2.00', '7', '2026-08-17 19:53:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1031', 'jurnal/add', '0.0095', '2.00', '27', '2026-08-17 19:53:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1032', 'presensikelas/add/30', '0.0075', '2.00', '7', '2026-08-17 19:54:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1033', 'presensi/input/17', '0.0066', '2.00', '6', '2026-08-17 19:54:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1034', 'presensi', '0.0050', '2.00', '8', '2026-08-17 19:54:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1035', 'presensi', '0.0438', '4.00', '8', '2026-08-17 20:01:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1036', 'google_drive_sync', '0.4597', '2.00', '11', '2026-08-17 20:01:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1037', 'jurnal', '0.0083', '2.00', '7', '2026-08-17 20:01:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1038', 'jurnal/add', '0.0085', '2.00', '27', '2026-08-17 20:01:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1039', 'presensikelas/add/31', '0.0064', '2.00', '7', '2026-08-17 20:02:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1040', 'presensi/input/18', '0.0058', '2.00', '6', '2026-08-17 20:03:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1041', 'presensi', '0.0051', '2.00', '9', '2026-08-17 20:03:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1042', 'jurnal', '0.0054', '2.00', '7', '2026-08-17 20:03:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1043', 'jurnal', '0.0056', '2.00', '7', '2026-08-17 20:03:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1044', 'jurnal', '0.0062', '2.00', '7', '2026-08-17 20:04:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1045', 'jurnal', '0.0515', '4.00', '7', '2026-08-17 20:12:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1046', 'google_drive_sync', '0.5737', '2.00', '13', '2026-08-17 20:12:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1047', 'google_drive_sync', '0.4554', '4.00', '12', '2026-08-17 20:13:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1048', 'google_drive_sync', '0.4855', '4.00', '12', '2026-08-17 20:13:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1049', '/', '0.0405', '4.00', '1', '2026-08-17 20:51:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1050', 'dashboard', '0.0094', '2.00', '13', '2026-08-17 20:52:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1051', 'jurnal/add', '0.0108', '2.00', '27', '2026-08-17 20:52:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1052', 'presensikelas/add/32', '0.0081', '2.00', '7', '2026-08-17 20:54:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1053', 'presensi/input/19', '0.0062', '2.00', '6', '2026-08-17 20:54:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1054', 'presensi', '0.0060', '2.00', '8', '2026-08-17 20:54:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1055', 'presensi', '0.0054', '2.00', '8', '2026-08-17 20:54:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1056', 'presensi/rekap', '0.0042', '2.00', '5', '2026-08-17 20:54:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1057', 'presensi/rekap', '0.0513', '4.00', '6', '2026-08-17 20:56:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1058', 'master/jadwal', '0.0163', '2.00', '27', '2026-08-17 20:56:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1059', 'master/jam_pelajaran', '0.0043', '2.00', '4', '2026-08-17 20:56:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1060', 'jurnal/jadwal', '0.0108', '2.00', '5', '2026-08-17 20:57:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1061', 'presensikelas', '0.0073', '2.00', '7', '2026-08-17 20:57:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1062', 'presensikelas', '0.0071', '2.00', '7', '2026-08-17 20:57:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1063', 'presensi', '0.0068', '2.00', '8', '2026-08-17 20:57:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1064', 'presensi', '0.0062', '2.00', '8', '2026-08-17 20:57:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1065', 'karya', '0.0067', '2.00', '8', '2026-08-17 20:57:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1066', 'perkembangan', '0.0077', '2.00', '7', '2026-08-17 20:58:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1067', 'monitoring', '0.0098', '2.00', '34', '2026-08-17 20:58:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1068', 'laporan', '0.0123', '2.00', '30', '2026-08-17 20:58:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1069', 'laporan/print_jurnal', '0.0068', '2.00', '7', '2026-08-17 20:58:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1070', 'presensi', '0.0046', '2.00', '7', '2026-08-17 20:58:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1071', 'presensi/rekap', '0.0035', '2.00', '5', '2026-08-17 20:58:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1072', 'presensi', '0.0075', '2.00', '7', '2026-08-17 20:58:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1073', 'presensi/rekap', '0.0036', '2.00', '5', '2026-08-17 20:58:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1074', 'presensi/rekap', '0.0047', '2.00', '6', '2026-08-17 20:58:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1075', 'presensi/rekap', '0.0052', '2.00', '6', '2026-08-17 20:58:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1076', 'presensi/print_rekap', '0.0092', '2.00', '5', '2026-08-17 20:58:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1077', 'presensi/rekap', '0.0045', '2.00', '6', '2026-08-17 20:58:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1078', 'presensi/rekap', '0.0050', '2.00', '5', '2026-08-17 20:59:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1079', 'presensi', '0.0061', '2.00', '7', '2026-08-17 20:59:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1080', 'laporan', '0.0091', '2.00', '30', '2026-08-17 20:59:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1081', '/', '0.0468', '4.00', '1', '2026-08-17 21:06:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1082', 'dashboard', '0.0140', '2.00', '13', '2026-08-17 21:06:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1083', 'settings', '0.0054', '2.00', '4', '2026-08-17 21:06:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1084', '/', '2.2140', '4.00', '1', '2026-08-18 00:03:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1085', 'login', '3.8185', '4.00', '1', '2026-08-18 00:06:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1086', '/', '0.7119', '4.00', '1', '2026-08-18 00:18:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1087', '/', '0.0408', '4.00', '1', '2026-08-18 00:41:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1088', '/', '0.0390', '4.00', '1', '2026-08-18 01:34:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1089', '/', '0.0388', '10.00', '1', '2026-08-18 04:38:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1090', '/', '0.0386', '10.00', '1', '2026-08-18 06:48:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1091', '/', '0.0518', '10.00', '1', '2026-08-18 11:29:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1092', 'login', '0.0480', '10.00', '1', '2026-08-18 14:39:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1093', 'dashboard', '0.0145', '2.00', '13', '2026-08-18 14:39:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1094', 'jurnal', '0.0114', '4.00', '7', '2026-08-18 14:41:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1095', 'jurnal/jadwal', '0.0052', '4.00', '5', '2026-08-18 14:41:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1096', 'presensikelas', '0.0076', '2.00', '7', '2026-08-18 14:41:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1097', 'presensi', '0.0086', '2.00', '8', '2026-08-18 14:41:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1098', 'master/jam_pelajaran', '0.0121', '4.00', '4', '2026-08-18 14:41:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1099', 'master/mapel', '0.0180', '2.00', '60', '2026-08-18 14:41:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1100', 'master/jadwal', '0.0087', '4.00', '27', '2026-08-18 14:42:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1101', 'laporan', '0.0158', '4.00', '30', '2026-08-18 14:43:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1102', 'laporan/print_jurnal', '0.0063', '4.00', '7', '2026-08-18 14:43:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1103', 'laporan/print_jurnal', '0.0064', '4.00', '7', '2026-08-18 14:43:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1104', 'master/guru', '0.0097', '4.00', '25', '2026-08-18 14:44:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1105', 'master/siswa', '0.0579', '6.00', '5', '2026-08-18 14:48:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1106', 'logs', '0.0081', '4.00', '4', '2026-08-18 14:48:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1107', 'logs', '0.0045', '2.00', '4', '2026-08-18 14:48:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1108', 'logs', '0.0064', '4.00', '4', '2026-08-18 14:48:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1109', 'google_drive_sync', '0.4912', '2.00', '12', '2026-08-18 14:48:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1110', 'laporan', '0.0148', '4.00', '30', '2026-08-18 14:48:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1111', 'settings', '0.0054', '4.00', '4', '2026-08-18 14:48:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1112', 'settings', '0.0033', '2.00', '4', '2026-08-18 14:49:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1113', 'monitoring', '0.0102', '2.00', '34', '2026-08-18 14:49:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1114', 'laporan', '0.0083', '4.00', '30', '2026-08-18 14:49:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1115', 'laporan/print_jurnal', '0.0076', '2.00', '7', '2026-08-18 14:49:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1116', 'presensi', '0.0074', '4.00', '7', '2026-08-18 14:49:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1117', 'presensi/rekap', '0.0048', '2.00', '5', '2026-08-18 14:49:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1118', 'presensi', '0.0053', '4.00', '8', '2026-08-18 14:49:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1119', 'presensi/rekap', '0.0038', '2.00', '5', '2026-08-18 14:49:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1120', 'presensi/rekap', '0.0054', '2.00', '6', '2026-08-18 14:49:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1121', 'presensi/rekap', '0.0041', '4.00', '5', '2026-08-18 14:50:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1122', '/', '0.0378', '10.00', '1', '2026-08-18 15:35:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1123', '/', '0.0026', '6.00', '1', '2026-08-18 15:35:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1124', '/', '0.0396', '10.00', '1', '2026-08-18 15:53:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1125', '/', '0.0382', '10.00', '1', '2026-08-18 17:39:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1126', '/', '0.0393', '10.00', '1', '2026-08-18 19:33:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1127', '/', '0.0382', '10.00', '1', '2026-08-18 20:10:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1128', '/', '0.0405', '10.00', '1', '2026-08-18 23:48:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1129', '/', '0.0624', '4.00', '1', '2026-08-19 02:31:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1130', '/', '0.0387', '10.00', '1', '2026-08-19 06:25:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1131', '/', '0.0487', '10.00', '1', '2026-08-19 11:01:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1132', '/', '0.0475', '4.00', '1', '2026-08-19 14:29:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1133', '/', '0.0460', '4.00', '1', '2026-08-19 14:59:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1134', '/', '0.0356', '2.00', '1', '2026-08-19 18:29:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1135', '/', '0.0386', '4.00', '1', '2026-08-19 19:00:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1136', '/', '0.0472', '4.00', '1', '2026-08-19 22:18:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1137', '/', '0.0404', '4.00', '1', '2026-08-19 22:55:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1138', '/', '0.0469', '4.00', '1', '2026-08-20 01:07:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1139', '/', '0.1725', '6.00', '1', '2026-08-20 04:33:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1140', '/', '0.0417', '10.00', '1', '2026-08-20 05:24:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1141', '/', '0.0438', '4.00', '1', '2026-08-20 06:54:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1142', '/', '0.0446', '4.00', '1', '2026-08-20 09:49:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1143', '/', '0.0385', '4.00', '1', '2026-08-20 10:01:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1144', '/', '0.0405', '4.00', '1', '2026-08-20 11:21:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1145', 'dashboard', '0.8942', '2.00', '13', '2026-08-20 11:21:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1146', 'master/guru', '0.0176', '4.00', '25', '2026-08-20 11:22:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1147', '/', '0.0475', '4.00', '1', '2026-08-20 14:08:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1148', '/', '0.0493', '4.00', '1', '2026-08-20 18:11:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1149', '/', '0.0624', '4.00', '1', '2026-08-20 19:04:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1150', '/', '0.0040', '2.00', '1', '2026-08-20 19:04:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1151', '/', '0.0382', '4.00', '1', '2026-08-20 19:38:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1152', 'dashboard', '0.0106', '2.00', '13', '2026-08-20 19:38:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1153', 'poinkeaktifan', '0.0208', '2.00', '38', '2026-08-20 19:38:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1154', 'master/guru', '0.0526', '4.00', '25', '2026-08-20 20:01:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1155', '/', '0.0443', '4.00', '1', '2026-08-20 21:59:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1156', '/', '0.0537', '4.00', '1', '2026-08-20 22:58:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1157', '/', '0.0734', '4.00', '1', '2026-08-21 04:15:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1158', '/', '0.0489', '4.00', '1', '2026-08-21 09:05:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1159', '/', '0.0398', '4.00', '1', '2026-08-21 10:04:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1160', 'dashboard', '0.0167', '2.00', '13', '2026-08-21 10:04:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1161', 'master/siswa', '0.0161', '4.00', '5', '2026-08-21 10:04:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1162', '/', '0.0418', '4.00', '1', '2026-08-21 10:18:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1163', '/', '0.0552', '4.00', '1', '2026-08-21 13:13:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1164', '/', '0.0394', '4.00', '1', '2026-08-21 13:31:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1165', '/', '0.0498', '4.00', '1', '2026-08-21 17:18:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1166', '/', '0.0466', '4.00', '1', '2026-08-21 17:58:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1167', '/', '0.0377', '4.00', '1', '2026-08-21 21:13:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1168', '/', '0.0410', '4.00', '1', '2026-08-21 23:29:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1169', '/', '0.0496', '10.00', '1', '2026-08-22 03:02:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1170', '/', '0.0558', '10.00', '1', '2026-08-22 05:02:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1171', '/', '0.0459', '4.00', '1', '2026-08-22 09:08:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1172', '/', '0.0393', '4.00', '1', '2026-08-22 09:39:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1173', '/', '0.0448', '4.00', '1', '2026-08-22 11:56:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1174', '/', '0.0445', '4.00', '1', '2026-08-22 13:18:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1175', '/', '0.0421', '4.00', '1', '2026-08-22 13:42:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1176', '/', '0.0391', '4.00', '1', '2026-08-22 14:19:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1177', '/', '0.0388', '4.00', '1', '2026-08-22 14:21:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1178', '/', '0.0393', '4.00', '1', '2026-08-22 14:26:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1179', '/', '0.0450', '4.00', '1', '2026-08-22 17:51:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1180', '/', '0.0402', '4.00', '1', '2026-08-22 18:57:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1181', '/', '0.0419', '4.00', '1', '2026-08-22 20:52:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1182', '/', '0.0390', '4.00', '1', '2026-08-22 21:31:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1183', '/', '0.0384', '4.00', '1', '2026-08-22 21:53:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1184', '/', '0.0384', '10.00', '1', '2026-08-23 01:50:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1185', '/', '0.0431', '10.00', '1', '2026-08-23 06:34:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1186', '/', '0.0379', '10.00', '1', '2026-08-23 08:19:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1187', '/', '0.0372', '10.00', '1', '2026-08-23 09:31:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1188', '/', '0.0383', '10.00', '1', '2026-08-23 11:12:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1189', '/', '0.0433', '4.00', '1', '2026-08-23 13:55:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1190', '/', '0.0382', '6.00', '1', '2026-08-23 14:31:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1191', '/', '0.0373', '4.00', '1', '2026-08-23 14:47:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1192', '/', '0.0381', '10.00', '1', '2026-08-23 15:25:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1193', '/', '0.0428', '10.00', '1', '2026-08-23 15:44:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1194', '/', '0.0386', '10.00', '1', '2026-08-23 16:04:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1195', '/', '0.0047', '2.00', '1', '2026-08-23 16:05:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1196', '/', '0.0338', '6.00', '1', '2026-08-23 18:25:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1197', '/', '0.0380', '10.00', '1', '2026-08-23 19:26:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1198', 'dashboard', '0.0222', '6.00', '13', '2026-08-23 19:32:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1199', 'google_drive_sync', '0.5022', '2.00', '12', '2026-08-23 19:32:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1200', 'jurnal', '0.0090', '4.00', '7', '2026-08-23 19:32:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1201', 'jurnal/detail/32', '0.0090', '4.00', '7', '2026-08-23 19:32:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1202', 'jurnal', '0.0048', '2.00', '7', '2026-08-23 19:32:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1203', 'jurnal/add', '0.0081', '2.00', '27', '2026-08-23 19:32:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1204', 'presensikelas/add/33', '0.0076', '4.00', '7', '2026-08-23 19:32:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1205', 'jurnal/add', '0.0091', '4.00', '27', '2026-08-23 19:33:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1206', 'jurnal', '0.0045', '4.00', '7', '2026-08-23 19:33:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1207', 'jurnal', '0.0052', '2.00', '7', '2026-08-23 19:33:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1208', 'presensikelas', '0.0079', '2.00', '7', '2026-08-23 19:33:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1209', 'jurnal', '0.0058', '4.00', '7', '2026-08-23 19:33:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1210', 'jurnal', '0.0043', '4.00', '7', '2026-08-23 19:33:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1211', 'jurnal', '0.0043', '4.00', '7', '2026-08-23 19:33:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1212', '/', '0.0029', '2.00', '1', '2026-08-23 19:33:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1213', 'dashboard', '0.0136', '6.00', '13', '2026-08-23 19:35:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1214', 'dashboard', '0.0110', '6.00', '13', '2026-08-23 20:32:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1215', 'google_drive_sync', '0.4798', '4.00', '12', '2026-08-23 20:32:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1216', '/', '0.0393', '10.00', '1', '2026-08-23 23:10:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1217', '/', '0.0386', '10.00', '1', '2026-08-23 23:58:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1218', '/', '0.0589', '6.00', '1', '2026-08-24 00:06:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1219', '/', '0.0338', '6.00', '1', '2026-08-24 00:56:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1220', '/', '0.0387', '2.00', '1', '2026-08-24 04:46:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1221', '/', '0.0330', '4.00', '1', '2026-08-24 05:41:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1222', '/', '0.0397', '10.00', '1', '2026-08-24 06:20:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1223', '/', '0.0384', '10.00', '1', '2026-08-24 07:42:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1224', '/', '0.0384', '10.00', '1', '2026-08-24 07:42:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1225', '/', '0.0390', '10.00', '1', '2026-08-24 09:02:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1226', 'dashboard', '0.0119', '2.00', '13', '2026-08-24 09:02:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1227', 'jurnal/add', '0.0128', '4.00', '27', '2026-08-24 09:02:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1228', 'presensikelas/add/34', '0.0091', '2.00', '7', '2026-08-24 09:04:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1229', 'presensi/input/20', '0.0073', '2.00', '6', '2026-08-24 09:05:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1230', 'presensi', '0.0054', '2.00', '8', '2026-08-24 09:05:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1231', 'laporan', '0.0138', '4.00', '30', '2026-08-24 09:05:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1232', 'laporan/print_jurnal', '0.0060', '4.00', '7', '2026-08-24 09:06:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1233', 'presensi', '0.0069', '4.00', '8', '2026-08-24 09:06:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1234', 'presensi/rekap', '0.0044', '2.00', '5', '2026-08-24 09:06:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1235', 'presensi/rekap', '0.0046', '4.00', '6', '2026-08-24 09:06:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1236', 'presensi/print_rekap', '0.0046', '4.00', '5', '2026-08-24 09:06:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1237', 'presensi/rekap', '0.0049', '4.00', '6', '2026-08-24 09:06:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1238', 'presensi/print_rekap', '0.0041', '4.00', '5', '2026-08-24 09:06:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1239', 'presensi/rekap', '0.0076', '4.00', '6', '2026-08-24 09:06:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1240', 'presensi/print_rekap', '0.0043', '4.00', '5', '2026-08-24 09:07:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1241', 'laporan', '0.0103', '2.00', '30', '2026-08-24 09:07:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1242', 'presensikelas', '0.0068', '2.00', '7', '2026-08-24 09:08:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1243', 'presensi/input/20', '0.0063', '2.00', '6', '2026-08-24 09:08:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1244', 'presensi', '0.0069', '2.00', '8', '2026-08-24 09:08:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1245', 'jurnal/jadwal', '0.0068', '2.00', '5', '2026-08-24 09:09:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1246', 'presensikelas', '0.0053', '2.00', '7', '2026-08-24 09:09:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1247', 'master/kelas', '0.0126', '2.00', '24', '2026-08-24 09:09:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1248', 'master/ruangan', '0.0039', '2.00', '4', '2026-08-24 09:09:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1249', 'master/mapel', '0.0169', '2.00', '60', '2026-08-24 09:09:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1250', 'master/mapel', '0.0120', '2.00', '60', '2026-08-24 09:09:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1251', 'master/mapel', '0.0171', '2.00', '60', '2026-08-24 09:10:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1252', 'master/mapel', '0.0166', '2.00', '61', '2026-08-24 09:10:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1253', 'karya', '0.0438', '10.00', '8', '2026-08-24 09:44:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1254', '/', '0.0386', '10.00', '1', '2026-08-24 10:19:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1255', 'master/kelas', '0.0502', '4.00', '24', '2026-08-24 10:39:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1256', 'master/ruangan', '0.0037', '2.00', '4', '2026-08-24 10:39:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1257', 'master/mapel', '0.0126', '2.00', '61', '2026-08-24 10:39:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1258', 'master/jam_pelajaran', '0.0440', '10.00', '4', '2026-08-24 10:45:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1259', 'master/guru', '0.0084', '6.00', '25', '2026-08-24 10:45:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1260', 'master/jadwal', '0.0080', '4.00', '27', '2026-08-24 10:45:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1261', 'master/mapel', '0.0190', '2.00', '61', '2026-08-24 10:46:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1262', 'master/mapel', '0.0150', '6.00', '62', '2026-08-24 10:58:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1263', 'master/mapel', '0.0131', '2.00', '63', '2026-08-24 10:58:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1264', '/', '0.0038', '2.00', '1', '2026-08-24 10:58:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1265', 'master/mapel', '0.0129', '2.00', '64', '2026-08-24 10:59:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1266', 'master/mapel', '0.0126', '2.00', '64', '2026-08-24 10:59:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1267', 'master/mapel', '0.0125', '2.00', '64', '2026-08-24 11:00:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1268', 'master/mapel', '0.0167', '2.00', '65', '2026-08-24 11:01:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1269', 'master/mapel', '0.0131', '2.00', '65', '2026-08-24 11:01:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1270', 'master/mapel', '0.0206', '6.00', '65', '2026-08-24 11:04:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1271', 'master/mapel', '0.0143', '2.00', '66', '2026-08-24 11:05:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1272', 'master/mapel', '0.0171', '6.00', '67', '2026-08-24 11:11:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1273', 'master/mapel', '0.0224', '6.00', '68', '2026-08-24 11:16:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1274', 'master/mapel', '0.0137', '2.00', '69', '2026-08-24 11:16:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1275', 'master/mapel', '0.0149', '2.00', '70', '2026-08-24 11:17:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1276', 'master/mapel', '0.0147', '2.00', '71', '2026-08-24 11:17:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1277', 'master/mapel', '0.0179', '2.00', '72', '2026-08-24 11:18:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1278', 'master/mapel', '0.0145', '2.00', '72', '2026-08-24 11:19:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1279', 'master/mapel', '0.0182', '2.00', '73', '2026-08-24 11:19:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1280', 'master/mapel', '0.0163', '2.00', '74', '2026-08-24 11:19:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1281', 'master/mapel', '0.0149', '2.00', '75', '2026-08-24 11:21:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1282', 'master/mapel', '0.0166', '6.00', '75', '2026-08-24 11:23:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1283', 'master/mapel', '0.0197', '2.00', '76', '2026-08-24 11:23:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1284', 'master/mapel', '0.0249', '2.00', '77', '2026-08-24 11:24:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1285', 'master/mapel', '0.0177', '2.00', '77', '2026-08-24 11:24:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1286', 'master/mapel', '0.0219', '2.00', '78', '2026-08-24 11:25:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1287', 'master/jam_pelajaran', '0.0058', '2.00', '4', '2026-08-24 11:25:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1288', 'master/guru', '0.0102', '2.00', '25', '2026-08-24 11:25:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1289', 'master/guru', '0.0094', '2.00', '25', '2026-08-24 11:26:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1290', 'master/guru', '0.0071', '2.00', '25', '2026-08-24 11:26:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1291', 'master/guru', '0.0092', '6.00', '25', '2026-08-24 11:28:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1292', 'master/guru', '0.0152', '6.00', '25', '2026-08-24 11:30:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1293', 'master/guru', '0.0119', '6.00', '26', '2026-08-24 11:32:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1294', 'master/guru', '0.0113', '6.00', '27', '2026-08-24 11:35:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1295', 'master/guru', '0.0111', '6.00', '28', '2026-08-24 11:38:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1296', 'master/guru', '0.0077', '2.00', '28', '2026-08-24 11:38:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1297', 'master/guru', '0.0071', '2.00', '28', '2026-08-24 11:38:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1298', 'master/guru', '0.0077', '2.00', '29', '2026-08-24 11:38:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1299', 'master/guru', '0.0092', '2.00', '29', '2026-08-24 11:39:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1300', 'master/guru', '0.0088', '2.00', '30', '2026-08-24 11:39:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1301', 'master/guru', '0.0089', '2.00', '31', '2026-08-24 11:40:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1302', 'master/guru', '0.0094', '2.00', '32', '2026-08-24 11:40:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1303', 'master/guru', '0.0085', '2.00', '33', '2026-08-24 11:41:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1304', 'master/guru', '0.0105', '6.00', '34', '2026-08-24 11:42:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1305', 'master/guru', '0.0093', '2.00', '35', '2026-08-24 11:43:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1306', 'master/guru', '0.0122', '2.00', '36', '2026-08-24 11:44:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1307', 'master/guru', '0.0119', '2.00', '36', '2026-08-24 11:44:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1308', 'master/guru', '0.0099', '2.00', '37', '2026-08-24 11:44:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1309', 'master/guru', '0.0096', '2.00', '38', '2026-08-24 11:45:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1310', 'master/guru', '0.0097', '2.00', '39', '2026-08-24 11:45:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1311', 'master/guru', '0.0134', '6.00', '39', '2026-08-24 11:49:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1312', 'master/import_excel/guru', '0.1472', '10.00', '63', '2026-08-24 11:53:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1313', 'master/guru', '0.0132', '6.00', '39', '2026-08-24 11:53:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1314', 'master/guru', '0.0150', '6.00', '39', '2026-08-24 12:01:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1315', 'master/guru', '0.0141', '2.00', '39', '2026-08-24 12:01:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1316', 'master/guru', '0.0097', '2.00', '39', '2026-08-24 12:01:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1317', 'master/guru', '0.0085', '2.00', '39', '2026-08-24 12:02:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1318', 'master/guru', '0.0163', '2.00', '39', '2026-08-24 12:02:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1319', 'master/guru', '0.0139', '6.00', '37', '2026-08-24 12:03:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1320', 'master/guru', '0.0128', '2.00', '35', '2026-08-24 12:03:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1321', 'master/guru', '0.0115', '2.00', '33', '2026-08-24 12:03:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1322', 'master/guru', '0.0079', '2.00', '31', '2026-08-24 12:03:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1323', 'master/guru', '0.0106', '2.00', '29', '2026-08-24 12:03:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1324', 'master/guru', '0.0092', '2.00', '27', '2026-08-24 12:04:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1325', 'master/guru', '0.0081', '2.00', '26', '2026-08-24 12:04:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1326', 'master/guru', '0.0101', '2.00', '24', '2026-08-24 12:04:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1327', 'master/guru', '0.0088', '2.00', '22', '2026-08-24 12:04:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1328', 'master/guru', '0.0093', '2.00', '20', '2026-08-24 12:04:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1329', 'master/guru', '0.0074', '2.00', '18', '2026-08-24 12:04:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1330', 'master/guru', '0.0064', '2.00', '16', '2026-08-24 12:04:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1331', 'master/guru', '0.0075', '2.00', '14', '2026-08-24 12:04:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1332', 'master/guru', '0.0071', '2.00', '12', '2026-08-24 12:04:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1333', 'master/guru', '0.0066', '2.00', '10', '2026-08-24 12:04:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1334', 'master/guru', '0.0041', '2.00', '8', '2026-08-24 12:04:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1335', 'master/guru', '0.0053', '2.00', '6', '2026-08-24 12:04:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1336', 'master/import_excel/guru', '0.1528', '4.00', '63', '2026-08-24 12:05:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1337', 'master/guru', '0.0101', '2.00', '39', '2026-08-24 12:05:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1338', 'master/siswa', '0.0100', '4.00', '5', '2026-08-24 12:05:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1339', 'master/jadwal', '0.0133', '4.00', '41', '2026-08-24 12:06:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1340', 'master/mapel', '0.0200', '4.00', '92', '2026-08-24 12:06:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1341', 'master/mapel', '0.0177', '2.00', '92', '2026-08-24 12:06:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1342', 'master/mapel', '0.0158', '2.00', '92', '2026-08-24 12:07:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1343', 'master/mapel', '0.0202', '2.00', '92', '2026-08-24 12:07:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1344', 'master/mapel', '0.0177', '2.00', '92', '2026-08-24 12:07:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1345', 'master/mapel', '0.0159', '2.00', '92', '2026-08-24 12:07:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1346', 'master/mapel', '0.0173', '2.00', '92', '2026-08-24 12:07:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1347', 'master/mapel', '0.0184', '2.00', '92', '2026-08-24 12:08:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1348', 'master/mapel', '0.0219', '2.00', '92', '2026-08-24 12:08:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1349', 'master/guru', '0.0117', '2.00', '39', '2026-08-24 12:08:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1350', 'master/siswa', '0.0501', '12.00', '5', '2026-08-24 12:37:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1351', 'master/jadwal', '0.0121', '6.00', '41', '2026-08-24 12:37:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1352', 'master/siswa', '0.0083', '4.00', '5', '2026-08-24 12:38:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1353', 'master/jam_pelajaran', '0.0054', '2.00', '4', '2026-08-24 12:38:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1354', 'master/guru', '0.0193', '2.00', '39', '2026-08-24 12:38:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1355', 'master/ruangan', '0.0039', '2.00', '4', '2026-08-24 12:39:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1356', 'master/mapel', '0.0211', '4.00', '92', '2026-08-24 12:39:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1357', 'master/mapel', '0.0189', '2.00', '92', '2026-08-24 12:39:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1358', 'master/mapel', '0.0199', '6.00', '92', '2026-08-24 12:41:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1359', 'master/mapel', '0.0244', '2.00', '92', '2026-08-24 12:42:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1360', 'master/mapel', '0.0227', '2.00', '92', '2026-08-24 12:42:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1361', 'master/mapel', '0.0187', '2.00', '92', '2026-08-24 12:43:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1362', 'master/mapel', '0.0181', '2.00', '92', '2026-08-24 12:43:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1363', 'master/mapel', '0.0186', '2.00', '92', '2026-08-24 12:43:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1364', 'master/mapel', '0.0181', '2.00', '92', '2026-08-24 12:44:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1365', 'master/mapel', '0.0184', '2.00', '92', '2026-08-24 12:44:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1366', 'master/mapel', '0.0265', '2.00', '92', '2026-08-24 12:45:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1367', 'master/mapel', '0.0182', '2.00', '92', '2026-08-24 12:45:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1368', 'master/mapel', '0.0218', '2.00', '92', '2026-08-24 12:45:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1369', 'master/mapel', '0.0202', '2.00', '92', '2026-08-24 12:45:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1370', 'master/mapel', '0.0187', '2.00', '92', '2026-08-24 12:46:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1371', 'master/mapel', '0.0229', '2.00', '92', '2026-08-24 12:46:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1372', 'master/mapel', '0.0183', '2.00', '92', '2026-08-24 12:46:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1373', 'master/mapel', '0.0212', '2.00', '92', '2026-08-24 12:46:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1374', 'master/mapel', '0.0177', '2.00', '92', '2026-08-24 12:47:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1375', 'master/mapel', '0.0163', '2.00', '92', '2026-08-24 12:47:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1376', 'master/jam_pelajaran', '0.0058', '2.00', '4', '2026-08-24 12:47:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1377', 'master/tahun_pelajaran', '0.0044', '2.00', '4', '2026-08-24 12:47:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1378', 'monitoring', '0.0142', '2.00', '47', '2026-08-24 12:47:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1379', 'monitoring', '0.0131', '2.00', '47', '2026-08-24 12:48:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1380', 'laporan', '0.0152', '2.00', '44', '2026-08-24 12:48:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1381', 'logs', '0.0067', '2.00', '4', '2026-08-24 12:48:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1382', 'jurnal/jadwal', '0.0100', '2.00', '5', '2026-08-24 12:48:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1383', 'jurnal', '0.0066', '2.00', '7', '2026-08-24 12:48:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1384', 'jurnal/jadwal', '0.0047', '2.00', '5', '2026-08-24 12:48:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1385', 'presensikelas', '0.0073', '2.00', '7', '2026-08-24 12:48:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1386', 'laporan', '0.0581', '10.00', '44', '2026-08-24 12:55:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1387', 'master/jadwal', '0.0209', '2.00', '41', '2026-08-24 12:55:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1388', 'master/mapel', '0.0209', '4.00', '92', '2026-08-24 12:56:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1389', 'master/kelas', '0.0108', '2.00', '38', '2026-08-24 12:57:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1390', 'master/mapel', '0.0200', '2.00', '92', '2026-08-24 12:57:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1391', 'master/jam_pelajaran', '0.0057', '2.00', '4', '2026-08-24 12:57:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1392', 'master/guru', '0.0113', '2.00', '39', '2026-08-24 12:57:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1393', 'master/kelas', '0.0102', '2.00', '38', '2026-08-24 12:58:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1394', 'master/kelas', '0.2143', '2.00', '38', '2026-08-24 12:58:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1395', 'master/kelas', '0.0078', '2.00', '38', '2026-08-24 12:58:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1396', 'master/kelas', '0.0102', '2.00', '38', '2026-08-24 12:58:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1397', 'master/kelas', '0.0132', '6.00', '38', '2026-08-24 13:00:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1398', 'master/kelas', '0.0100', '2.00', '38', '2026-08-24 13:00:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1399', 'master/kelas', '0.0086', '2.00', '38', '2026-08-24 13:01:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1400', 'master/guru', '0.0104', '4.00', '39', '2026-08-24 13:01:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1401', 'master/guru', '0.0095', '2.00', '39', '2026-08-24 13:02:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1402', 'master/guru', '0.0138', '2.00', '39', '2026-08-24 13:02:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1403', 'walikelas', '0.0503', '10.00', '10', '2026-08-24 13:04:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1404', 'perangkat_ajar', '0.0131', '2.00', '12', '2026-08-24 13:04:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1405', 'jurnal/jadwal', '0.0066', '2.00', '5', '2026-08-24 13:04:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1406', 'presensikelas', '0.0075', '2.00', '7', '2026-08-24 13:04:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1407', 'presensikelas', '0.0051', '2.00', '7', '2026-08-24 13:04:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1408', 'presensikelas', '0.0080', '2.00', '7', '2026-08-24 13:04:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1409', 'presensikelas', '0.0054', '2.00', '7', '2026-08-24 13:05:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1410', 'presensikelas', '0.0089', '2.00', '7', '2026-08-24 13:06:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1411', 'laporan', '0.0194', '2.00', '44', '2026-08-24 13:06:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1412', 'master/jadwal', '0.0162', '2.00', '41', '2026-08-24 13:07:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1413', 'master/siswa', '0.0082', '4.00', '5', '2026-08-24 13:07:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1414', 'jurnal', '0.0055', '2.00', '7', '2026-08-24 13:07:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1415', 'jurnal/add', '0.0096', '2.00', '41', '2026-08-24 13:07:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1416', 'jurnal/add', '0.0114', '2.00', '41', '2026-08-24 13:08:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1417', 'presensikelas/add/35', '0.0089', '2.00', '7', '2026-08-24 13:13:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1418', 'presensi/input/21', '0.0078', '2.00', '6', '2026-08-24 13:13:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1419', 'presensi', '0.0068', '2.00', '8', '2026-08-24 13:13:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1420', 'jurnal', '0.0066', '2.00', '7', '2026-08-24 13:14:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1421', 'jurnal/detail/35', '0.0088', '2.00', '7', '2026-08-24 13:14:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1422', 'jurnal', '0.0066', '2.00', '7', '2026-08-24 13:14:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1423', 'jurnal/add', '0.0097', '2.00', '41', '2026-08-24 13:14:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1424', 'presensikelas/add/36', '0.0054', '2.00', '7', '2026-08-24 13:15:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1425', 'presensi/input/22', '0.0045', '2.00', '6', '2026-08-24 13:15:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1426', 'presensi', '0.0049', '2.00', '9', '2026-08-24 13:16:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1427', 'jurnal', '0.0072', '2.00', '7', '2026-08-24 13:16:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1428', 'jurnal/add', '0.0123', '2.00', '41', '2026-08-24 13:16:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1429', 'presensikelas/add/37', '0.0050', '2.00', '7', '2026-08-24 13:17:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1430', 'presensi/input/23', '0.0040', '2.00', '6', '2026-08-24 13:17:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1431', 'presensi', '0.0055', '2.00', '10', '2026-08-24 13:17:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1432', 'laporan', '0.0185', '2.00', '44', '2026-08-24 13:18:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1433', 'laporan/print_jurnal', '0.0085', '2.00', '9', '2026-08-24 13:19:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1434', 'presensi', '0.0507', '10.00', '8', '2026-08-24 13:22:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1435', 'presensi/rekap', '0.0055', '2.00', '5', '2026-08-24 13:22:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1436', 'presensi/rekap', '0.0070', '2.00', '6', '2026-08-24 13:22:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1437', 'presensi/rekap', '0.0440', '10.00', '6', '2026-08-24 13:25:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1438', 'settings', '0.0050', '6.00', '4', '2026-08-24 13:25:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1439', 'google_drive_sync', '0.5261', '4.00', '12', '2026-08-24 13:28:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1440', 'dashboard', '0.0124', '2.00', '13', '2026-08-24 13:28:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1441', 'jurnal', '0.0100', '2.00', '7', '2026-08-24 13:28:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1442', 'jurnal/detail/35', '0.0510', '10.00', '7', '2026-08-24 13:30:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1443', 'perkembangan', '0.0106', '2.00', '7', '2026-08-24 13:30:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1444', 'laporan', '0.0217', '2.00', '44', '2026-08-24 13:30:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1445', 'laporan', '0.0549', '10.00', '44', '2026-08-24 13:41:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1446', 'settings', '0.0044', '6.00', '4', '2026-08-24 13:41:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1447', 'master/guru', '0.0177', '4.00', '39', '2026-08-24 13:42:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1448', 'login', '0.0071', '6.00', '1', '2026-08-24 13:43:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1449', 'dashboard', '0.0094', '2.00', '13', '2026-08-24 13:44:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1450', 'dashboard', '0.0033', '2.00', '3', '2026-08-24 13:45:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1451', 'dashboard', '0.0047', '2.00', '3', '2026-08-24 13:45:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1452', 'presensi', '0.0093', '4.00', '10', '2026-08-24 13:45:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1453', 'dashboard', '0.0046', '4.00', '3', '2026-08-24 13:45:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1454', 'dashboard', '0.0033', '2.00', '3', '2026-08-24 13:45:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1455', 'master/jadwal', '0.0543', '10.00', '41', '2026-08-24 13:49:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1456', 'jurnal', '0.0144', '2.00', '7', '2026-08-24 13:50:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1457', 'dashboard', '0.0090', '2.00', '13', '2026-08-24 13:50:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1458', 'master/jadwal', '0.0110', '2.00', '41', '2026-08-24 13:51:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1459', 'login', '0.0038', '2.00', '1', '2026-08-24 13:51:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1460', 'dashboard', '0.0055', '2.00', '14', '2026-08-24 13:52:26');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1461', 'presensikelas', '0.0084', '2.00', '11', '2026-08-24 13:52:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1462', 'dashboard', '0.0033', '2.00', '3', '2026-08-24 13:52:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1463', 'presensikelas', '0.0081', '2.00', '11', '2026-08-24 13:52:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1464', 'presensi', '0.0079', '2.00', '13', '2026-08-24 13:52:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1465', 'dashboard', '0.0039', '2.00', '3', '2026-08-24 13:53:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1466', 'master/guru', '0.0526', '10.00', '39', '2026-08-24 13:54:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1467', 'login', '0.0027', '2.00', '1', '2026-08-24 13:55:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1468', 'dashboard', '0.0097', '2.00', '14', '2026-08-24 13:55:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1469', 'jurnal', '0.0087', '2.00', '12', '2026-08-24 13:55:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1470', 'presensikelas', '0.0079', '2.00', '12', '2026-08-24 13:55:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1471', 'jurnal', '0.0062', '2.00', '12', '2026-08-24 13:55:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1472', 'login', '0.0025', '2.00', '1', '2026-08-24 13:56:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1473', 'dashboard', '0.0082', '2.00', '13', '2026-08-24 13:56:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1474', 'master/guru', '0.0501', '10.00', '39', '2026-08-24 14:01:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1475', 'laporan/print_jurnal', '0.0603', '10.00', '9', '2026-08-24 14:01:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1476', 'master/guru', '0.0504', '10.00', '39', '2026-08-24 14:02:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1477', 'login', '0.0064', '2.00', '1', '2026-08-24 14:04:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1478', 'dashboard', '0.0088', '2.00', '14', '2026-08-24 14:04:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1479', 'penilaian', '0.0122', '4.00', '14', '2026-08-24 14:04:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1480', 'penilaian/rekap', '0.0476', '10.00', '11', '2026-08-24 14:06:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1481', 'penilaian', '0.0060', '6.00', '14', '2026-08-24 14:06:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1482', 'penilaian/import_history', '0.0462', '10.00', '4', '2026-08-24 14:11:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1483', 'penilaian/rekap', '0.0060', '6.00', '11', '2026-08-24 14:11:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1484', 'penilaian', '0.0070', '4.00', '14', '2026-08-24 14:11:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1485', 'master/jam_pelajaran', '0.0112', '4.00', '4', '2026-08-24 14:12:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1486', 'master/mapel', '0.0183', '2.00', '92', '2026-08-24 14:12:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1487', 'master/mapel', '0.0193', '2.00', '92', '2026-08-24 14:13:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1488', 'penilaian', '0.0059', '2.00', '14', '2026-08-24 14:13:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1489', 'penilaian', '0.0069', '2.00', '14', '2026-08-24 14:13:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1490', 'penilaian', '0.0072', '2.00', '14', '2026-08-24 14:13:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1491', 'penilaian', '0.0068', '2.00', '14', '2026-08-24 14:13:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1492', 'penilaian/rekap', '0.0048', '2.00', '11', '2026-08-24 14:13:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1493', 'presensikelas', '0.0089', '2.00', '11', '2026-08-24 14:13:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1494', 'presensi', '0.0064', '2.00', '11', '2026-08-24 14:13:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1495', 'perkembangan', '0.0109', '2.00', '13', '2026-08-24 14:14:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1496', 'login', '0.0032', '2.00', '1', '2026-08-24 14:15:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1497', 'dashboard', '0.0111', '2.00', '14', '2026-08-24 14:17:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1498', 'penilaian', '0.0095', '2.00', '14', '2026-08-24 14:17:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1499', 'master/mapel', '0.0288', '6.00', '92', '2026-08-24 14:18:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1500', 'master/mapel', '0.0224', '2.00', '92', '2026-08-24 14:18:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1501', 'master/mapel', '0.0179', '2.00', '92', '2026-08-24 14:19:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1502', 'master/mapel', '0.0201', '2.00', '92', '2026-08-24 14:19:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1503', 'master/mapel', '0.0208', '2.00', '92', '2026-08-24 14:20:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1504', 'master/mapel', '0.0247', '2.00', '92', '2026-08-24 14:20:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1505', 'master/mapel', '0.0194', '2.00', '92', '2026-08-24 14:21:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1506', 'master/mapel', '0.0237', '2.00', '92', '2026-08-24 14:21:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1507', 'master/mapel', '0.0200', '2.00', '92', '2026-08-24 14:21:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1508', 'master/mapel', '0.0186', '2.00', '92', '2026-08-24 14:21:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1509', 'master/mapel', '0.0177', '2.00', '92', '2026-08-24 14:22:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1510', 'master/mapel', '0.0174', '2.00', '92', '2026-08-24 14:22:41');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1511', 'master/mapel', '0.0188', '2.00', '92', '2026-08-24 14:23:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1512', 'master/mapel', '0.0186', '2.00', '92', '2026-08-24 14:23:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1513', 'master/mapel', '0.0232', '2.00', '92', '2026-08-24 14:23:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1514', 'master/mapel', '0.0188', '2.00', '92', '2026-08-24 14:23:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1515', 'master/mapel', '0.0194', '2.00', '92', '2026-08-24 14:24:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1516', 'master/mapel', '0.0182', '2.00', '92', '2026-08-24 14:24:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1517', 'master/mapel', '0.0227', '2.00', '92', '2026-08-24 14:24:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1518', 'master/mapel', '0.0188', '2.00', '92', '2026-08-24 14:25:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1519', 'master/mapel', '0.0184', '2.00', '92', '2026-08-24 14:25:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1520', 'master/mapel', '0.0213', '2.00', '92', '2026-08-24 14:26:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1521', 'master/mapel', '0.0202', '2.00', '92', '2026-08-24 14:26:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1522', 'master/mapel', '0.0177', '2.00', '92', '2026-08-24 14:26:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1523', 'master/mapel', '0.0250', '2.00', '92', '2026-08-24 14:26:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1524', '/', '0.0396', '10.00', '1', '2026-08-24 14:59:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1525', '/', '0.0374', '10.00', '1', '2026-08-24 16:38:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1526', '/', '0.0398', '10.00', '1', '2026-08-24 18:05:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1527', '/', '0.0060', '2.00', '1', '2026-08-24 18:06:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1528', '/', '0.0286', '6.00', '1', '2026-08-24 18:57:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1529', 'google_drive_sync', '0.7303', '6.00', '12', '2026-08-24 12:02:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1530', 'jurnal', '0.0943', '6.00', '7', '2026-08-24 12:02:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1531', 'jurnal/jadwal', '0.0780', '6.00', '5', '2026-08-24 12:02:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1532', 'presensikelas', '0.0819', '6.00', '7', '2026-08-24 12:02:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1533', 'master/guru', '0.0906', '8.00', '39', '2026-08-24 12:06:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1534', 'login', '0.0596', '6.00', '1', '2026-08-24 12:07:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1535', 'dashboard', '0.0754', '6.00', '13', '2026-08-24 12:07:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1536', 'login', '0.0771', '6.00', '1', '2026-08-24 12:07:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1537', 'dashboard', '0.0882', '6.00', '13', '2026-08-24 12:08:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1538', 'login', '0.0597', '6.00', '1', '2026-08-24 12:08:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1539', 'dashboard', '0.0858', '6.00', '3', '2026-08-24 12:08:51');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1540', 'dashboard', '0.0663', '6.00', '3', '2026-08-24 12:09:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1541', 'dashboard', '0.0669', '6.00', '3', '2026-08-24 12:09:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1542', 'dashboard', '0.0882', '6.00', '3', '2026-08-24 12:11:04');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1543', 'jurnal', '0.0694', '6.00', '7', '2026-08-24 12:11:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1544', 'jurnal/jadwal', '0.0684', '6.00', '5', '2026-08-24 12:11:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1545', 'presensikelas', '0.0845', '6.00', '7', '2026-08-24 12:11:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1546', 'presensi', '0.0836', '6.00', '10', '2026-08-24 12:11:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1547', 'login', '0.0582', '6.00', '1', '2026-08-24 12:11:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1548', 'dashboard', '0.0650', '6.00', '3', '2026-08-24 12:11:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1549', 'jurnal', '0.0834', '6.00', '12', '2026-08-24 12:11:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1550', 'jurnal/jadwal', '0.0690', '6.00', '6', '2026-08-24 12:11:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1551', 'presensikelas', '0.0674', '6.00', '12', '2026-08-24 12:11:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1552', 'presensi', '0.0909', '6.00', '12', '2026-08-24 12:11:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1553', 'login', '0.0574', '6.00', '1', '2026-08-24 12:11:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1554', 'login', '0.0832', '6.00', '1', '2026-08-24 12:12:01');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1555', 'dashboard', '0.0774', '6.00', '14', '2026-08-24 12:12:09');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1556', 'jurnal/add', '0.0846', '6.00', '45', '2026-08-24 12:12:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1557', 'dashboard', '0.0665', '6.00', '3', '2026-08-24 12:13:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1558', 'dashboard', '0.0903', '6.00', '14', '2026-08-24 12:17:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1559', 'jurnal', '0.0729', '6.00', '13', '2026-08-24 12:17:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1560', 'jurnal/add', '0.1081', '6.00', '47', '2026-08-24 12:17:31');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1561', 'jurnal/jadwal', '0.0688', '6.00', '6', '2026-08-24 12:17:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1562', 'walikelas', '0.0857', '6.00', '8', '2026-08-24 12:17:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1563', 'walikelas', '0.0498', '6.00', '8', '2026-08-24 12:19:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1564', 'jurnal', '0.0846', '6.00', '11', '2026-08-24 12:19:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1565', 'jurnal/add', '0.0841', '6.00', '45', '2026-08-24 12:19:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1566', 'presensikelas/add/38', '0.0629', '8.00', '7', '2026-08-24 12:20:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1567', 'presensi/input/24', '0.0694', '6.00', '6', '2026-08-24 12:21:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1568', 'presensi', '0.0800', '6.00', '14', '2026-08-24 12:21:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1569', 'dashboard', '0.0949', '6.00', '14', '2026-08-24 12:21:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1570', 'jurnal', '0.0951', '8.00', '11', '2026-08-24 12:25:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1571', 'jurnal/add', '0.0841', '8.00', '45', '2026-08-24 12:25:30');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1572', 'presensikelas/add/39', '0.0685', '8.00', '7', '2026-08-24 12:26:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1573', 'presensi/input/25', '0.0699', '6.00', '6', '2026-08-24 12:26:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1574', 'presensi', '0.0884', '8.00', '15', '2026-08-24 12:26:49');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1575', 'jurnal', '0.0726', '6.00', '11', '2026-08-24 12:26:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1576', 'poinkeaktifan/input/39', '0.0845', '6.00', '6', '2026-08-24 12:26:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1577', 'poinkeaktifan', '0.0933', '8.00', '57', '2026-08-24 12:27:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1578', 'login', '0.0762', '6.00', '1', '2026-08-24 12:27:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1579', 'dashboard', '0.0865', '6.00', '13', '2026-08-24 12:27:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1580', 'laporan', '0.0828', '6.00', '44', '2026-08-24 12:28:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1581', 'laporan/print_jurnal', '0.0851', '10.00', '11', '2026-08-24 12:29:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1582', 'login', '0.0633', '6.00', '1', '2026-08-24 12:30:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1583', 'dashboard', '0.0737', '6.00', '13', '2026-08-24 12:30:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1584', 'laporan', '0.0793', '8.00', '44', '2026-08-24 12:30:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1585', 'laporan', '0.0961', '10.00', '44', '2026-08-24 12:33:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1586', 'laporan', '0.0814', '10.00', '44', '2026-08-24 12:36:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1587', 'laporan', '0.0793', '12.00', '44', '2026-08-24 12:38:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1588', 'settings', '0.0603', '10.00', '4', '2026-08-24 12:39:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1589', 'laporan', '0.0783', '10.00', '44', '2026-08-24 12:39:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1590', 'laporan', '0.0950', '10.00', '44', '2026-08-24 12:40:42');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1591', 'laporan', '0.1001', '6.00', '44', '2026-08-24 12:41:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1592', 'presensi', '0.0930', '16.00', '9', '2026-08-24 12:43:53');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1593', 'presensi/rekap', '0.0707', '10.00', '5', '2026-08-24 12:43:55');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1594', 'presensi/rekap', '0.0663', '8.00', '6', '2026-08-24 12:43:58');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1595', 'presensi/rekap', '0.0630', '6.00', '5', '2026-08-24 12:44:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1596', 'presensi/rekap', '0.0759', '6.00', '6', '2026-08-24 12:44:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1597', 'presensi/print_rekap', '0.0729', '6.00', '5', '2026-08-24 12:44:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1598', 'presensi/rekap', '0.0813', '6.00', '5', '2026-08-24 12:44:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1599', 'presensi', '0.0687', '6.00', '9', '2026-08-24 12:44:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1600', 'laporan', '0.1016', '6.00', '44', '2026-08-24 12:44:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1601', 'google_drive_sync', '0.8594', '10.00', '14', '2026-08-24 12:45:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1602', 'settings', '0.0654', '8.00', '6', '2026-08-24 12:45:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1603', 'settings', '0.0647', '14.00', '6', '2026-08-24 12:47:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1604', 'laporan', '0.0800', '10.00', '46', '2026-08-24 12:47:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1605', 'logs', '0.0693', '22.00', '6', '2026-08-24 12:49:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1606', 'google_drive_sync', '0.9225', '14.00', '14', '2026-08-24 12:49:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1607', 'google_drive_sync', '0.8895', '8.00', '14', '2026-08-24 12:49:57');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1608', 'google_drive_sync', '0.7240', '6.00', '14', '2026-08-24 12:55:25');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1609', 'jurnal', '0.0727', '22.00', '9', '2026-08-24 12:55:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1610', 'jurnal/detail/39', '0.0781', '14.00', '10', '2026-08-24 12:55:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1611', 'jurnal', '0.0733', '10.00', '9', '2026-08-24 12:55:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1612', 'jurnal/add', '0.1027', '8.00', '43', '2026-08-24 12:55:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1613', 'presensikelas/add/40', '0.0910', '6.00', '9', '2026-08-24 12:56:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1614', 'presensi/input/26', '0.0646', '6.00', '8', '2026-08-24 12:56:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1615', 'presensi', '0.0710', '6.00', '15', '2026-08-24 12:56:50');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1616', 'jurnal', '0.0735', '6.00', '9', '2026-08-24 12:58:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1617', 'jurnal/detail/40', '0.0792', '6.00', '10', '2026-08-24 12:58:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1618', 'jurnal', '0.1103', '6.00', '9', '2026-08-24 12:58:23');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1619', 'jurnal/add', '0.2122', '6.00', '43', '2026-08-24 12:58:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1620', 'jurnal', '0.0856', '6.00', '9', '2026-08-24 12:58:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1621', 'jurnal/detail/40', '0.1273', '6.00', '10', '2026-08-24 12:59:03');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1622', 'jurnal', '0.0969', '6.00', '9', '2026-08-24 12:59:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1623', 'dashboard', '0.0759', '6.00', '15', '2026-08-24 13:23:40');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1624', 'login', '0.0734', '6.00', '2', '2026-08-24 13:23:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1625', 'login', '0.0733', '6.00', '2', '2026-08-24 13:24:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1626', 'dashboard', '0.0817', '6.00', '16', '2026-08-24 13:37:07');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1627', 'dashboard', '0.0871', '6.00', '5', '2026-08-24 13:37:14');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1628', 'login', '0.0839', '6.00', '2', '2026-08-24 13:37:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1629', 'dashboard', '0.0841', '6.00', '16', '2026-08-24 13:37:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1630', 'jurnal/add', '0.1006', '6.00', '47', '2026-08-24 13:40:45');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1631', 'presensikelas/add/41', '0.0784', '6.00', '9', '2026-08-24 13:45:05');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1632', 'presensi/input/27', '0.0664', '6.00', '8', '2026-08-24 13:46:08');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1633', 'presensi', '0.0704', '6.00', '16', '2026-08-24 13:46:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1634', 'jurnal', '0.0754', '6.00', '13', '2026-08-24 13:47:11');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1635', 'poinkeaktifan/input/41', '0.0736', '6.00', '8', '2026-08-24 13:48:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1636', 'poinkeaktifan', '0.1109', '8.00', '59', '2026-08-24 13:50:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1637', 'penilaian', '0.0888', '6.00', '18', '2026-08-24 13:51:36');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1638', 'presensikelas', '0.0679', '6.00', '15', '2026-08-24 13:52:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1639', 'penilaian', '0.0926', '6.00', '18', '2026-08-24 13:52:38');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1640', 'presensikelas', '0.0877', '6.00', '15', '2026-08-24 13:52:43');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1641', 'penilaian', '0.0745', '6.00', '18', '2026-08-24 13:54:28');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1642', 'penilaian', '0.0744', '6.00', '21', '2026-08-24 13:54:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1643', 'penilaian/rekap', '0.0708', '6.00', '15', '2026-08-24 13:56:34');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1644', 'penilaian/rekap', '0.0705', '6.00', '20', '2026-08-24 13:56:39');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1645', 'perkembangan', '0.0858', '6.00', '17', '2026-08-24 13:57:33');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1646', 'perkembangan', '0.0747', '6.00', '19', '2026-08-24 13:58:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1647', 'karya', '0.0713', '6.00', '15', '2026-08-24 13:58:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1648', 'perangkat_ajar', '0.0755', '6.00', '14', '2026-08-24 14:01:27');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1649', 'laporan', '0.0938', '6.00', '52', '2026-08-24 14:02:24');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1650', '/', '0.2119', '6.00', '2', '2026-08-29 12:05:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1651', '/', '0.0603', '6.00', '2', '2026-08-29 12:06:15');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1652', 'dashboard', '0.1295', '6.00', '15', '2026-08-29 12:06:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1653', 'google_drive_sync', '0.6454', '6.00', '14', '2026-08-29 12:06:22');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1654', 'google_drive_sync', '1.7185', '6.00', '14', '2026-08-29 12:10:17');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1655', 'google_drive_sync', '0.6783', '6.00', '14', '2026-08-29 12:11:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1656', 'google_drive_sync', '0.5871', '6.00', '14', '2026-08-29 12:12:06');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1657', 'google_drive_sync', '0.5895', '6.00', '14', '2026-08-29 12:12:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1658', 'google_drive_sync', '2.2308', '6.00', '14', '2026-08-29 12:14:46');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1659', 'login', '0.0909', '6.00', '2', '2026-08-29 12:17:00');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1660', 'dashboard', '0.1108', '6.00', '15', '2026-08-29 12:17:12');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1661', 'google_drive_sync', '0.6611', '6.00', '14', '2026-08-29 12:17:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1662', 'google_drive_sync', '2.6332', '6.00', '14', '2026-08-29 12:19:20');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1663', 'google_drive_sync', '0.9414', '6.00', '14', '2026-08-29 12:19:37');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1664', 'google_drive_sync', '1.0030', '6.00', '14', '2026-08-29 12:20:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1665', 'google_drive_sync', '4.8663', '6.00', '14', '2026-08-29 12:20:18');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1666', 'google_drive_sync', '0.9513', '6.00', '14', '2026-08-29 12:21:32');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1667', 'google_drive_sync', '1.0039', '6.00', '14', '2026-08-29 12:21:44');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1668', 'jurnal', '0.0805', '6.00', '9', '2026-08-29 12:21:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1669', 'jurnal', '0.0759', '6.00', '9', '2026-08-29 12:24:56');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1670', 'jurnal/edit/41', '0.1000', '6.00', '44', '2026-08-29 12:24:59');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1671', 'jurnal/edit/41', '0.0920', '6.00', '44', '2026-08-29 12:27:29');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1672', 'jurnal/edit/41', '0.1072', '6.00', '44', '2026-08-29 12:28:02');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1673', 'jurnal/edit/41', '0.0807', '6.00', '44', '2026-08-29 12:28:16');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1674', 'jurnal/edit/41', '0.1075', '6.00', '44', '2026-08-29 12:28:54');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1675', '/', '0.2520', '6.00', '2', '2026-08-31 02:11:48');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1676', 'dashboard', '0.1164', '6.00', '15', '2026-08-31 02:11:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1677', 'presensi', '0.0804', '6.00', '16', '2026-08-31 02:12:10');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1678', 'jurnal', '0.0807', '6.00', '9', '2026-08-31 02:12:19');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1679', 'jurnal/edit/41', '0.0968', '6.00', '44', '2026-08-31 02:12:21');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1680', 'dashboard', '0.1051', '6.00', '15', '2026-08-31 02:29:47');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1681', 'master/jadwal', '0.0910', '6.00', '43', '2026-08-31 02:29:52');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1682', 'master/guru', '0.0785', '8.00', '41', '2026-08-31 02:32:13');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1683', 'master/jadwal', '0.0844', '6.00', '43', '2026-08-31 02:39:35');
INSERT INTO `sys_performance_logs` (`id`, `url`, `execution_time`, `memory_usage`, `query_count`, `created_at`) VALUES ('1684', 'master/jadwal', '0.0915', '12.00', '43', '2026-08-31 02:46:16');

DROP TABLE IF EXISTS `sys_slow_queries`;
CREATE TABLE `sys_slow_queries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `query_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `execution_time` decimal(8,4) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_slow_created` (`created_at`),
  KEY `idx_slow_time` (`execution_time`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sys_slow_queries` (`id`, `query_text`, `execution_time`, `url`, `created_at`) VALUES ('1', 'SELECT *\nFROM `system_settings`', '0.8790', '', '2026-08-18 00:02:59');
INSERT INTO `sys_slow_queries` (`id`, `query_text`, `execution_time`, `url`, `created_at`) VALUES ('2', 'SELECT *\nFROM `system_settings`', '2.8646', 'login', '2026-08-18 00:06:56');

DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE `system_settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('1', 'app_name', 'Jurnal Guru MA Darul Faqih Indonesia', 'general', 'Nama Aplikasi Sekolah', '2026-07-29 20:58:36');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('2', 'app_institution', 'MA Darul Faqih', 'general', 'Nama Sekolah / Institusi', '2026-07-20 18:14:33');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('3', 'app_logo', 'assets/img/logo_1787575626.png', 'general', 'Logo Aplikasi', '2026-08-24 19:47:06');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('4', 'app_address', 'Jl. Gapura 197 Pandanlandung', 'general', 'Alamat Sekolah', '2026-07-20 18:14:33');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('8', 'report_header_title', 'LAPORAN JURNAL KEGIATAN BELAJAR MENGAJAR (KBM)', 'general', NULL, NULL);
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('9', 'report_city', 'Malang', 'general', NULL, '2026-07-20 19:38:13');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('10', 'report_signer_title', 'Kepala Sekolah', 'general', NULL, NULL);
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('11', 'report_signer_name', 'M. Fakhrur Rozi, M.Pd', 'general', NULL, '2026-07-20 19:38:13');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('12', 'report_signer_nip', '', 'general', NULL, '2026-07-20 19:38:13');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('13', 'app_logo_left', 'assets/img/logo_left_1787575626.png', 'general', NULL, '2026-08-24 19:47:06');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('14', 'app_logo_right', 'assets/img/logo_right_1787575626.jpg', 'general', NULL, '2026-08-24 19:47:06');
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES ('15', 'app_favicon', 'assets/img/favicon_1787575626.png', 'general', NULL, NULL);

DROP TABLE IF EXISTS `tahun_pelajaran`;
CREATE TABLE `tahun_pelajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tp_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tahun_pelajaran` (`id`, `tahun`, `semester`, `is_active`, `created_at`, `updated_at`) VALUES ('3', '2026/2027', 'Ganjil', '1', '2026-07-20 19:39:10', '2026-07-20 19:39:24');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int unsigned NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default.png',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_users_role` (`role_id`),
  CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('1', 'admin', 'admin@jurnalguru.sch.id', '$2y$10$p5B4W4pJTSUKRtd2q4R74Ords6eRzbjvRLt.mRkqy5yIX8BHF.8K2', 'Administrator Utama', '1', 'default.png', '1', '2026-08-31 02:11:52', '2026-07-20 18:04:03', '2026-08-31 09:11:52');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('4', 'superadmin', 'superadmin@jurnalguru.sch.id', '$2y$10$p5B4W4pJTSUKRtd2q4R74Ords6eRzbjvRLt.mRkqy5yIX8BHF.8K2', 'Dr. H. Ahmad Fauzi, M.Ag.', '1', 'default.png', '1', '2026-08-07 11:18:52', '2026-07-20 18:06:10', '2026-08-07 11:18:52');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('24', 'madjidwafa25', 'madjidwafa25@gmail.com', '$2y$10$qU7FBEnzHdldD5rkWIQtZuIqlNgtD8DyPNakCbWZgJa18FgPJ23XS', 'Abdul Madjid Wafa', '3', 'default.png', '1', '2026-08-24 13:37:07', '2026-08-24 12:05:16', '2026-08-24 20:37:07');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('25', 'rufi', 'rufiabi@gmail.com', '$2y$10$Q0rHuiJGRaK5zZ1EbHiKSOEGtoKIaMCKmIVOc4m3/4v6Eq5oQGEvq', 'Abi Lazkar Amar Ma\'rufi', '3', 'default.png', '1', '2026-08-24 13:52:26', '2026-08-24 12:05:16', '2026-08-24 13:52:26');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('26', 'adimasptra20', 'adimasptra20@gmail.com', '$2y$10$v5GPh6jSXz9NbRXinaDAO.MaQ4rWTyppiG9dUIB0ioW3315GKhhe6', 'Amin Adimas Putra', '2', 'default.png', '1', NULL, '2026-08-24 12:05:16', NULL);
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('27', 'arsybintangramadhani', 'arsybintangramadhani@gmail.com', '$2y$10$Q/EPcEXsVKiJL8AtLCjhBe4b86EUoXZd5o2ZfFPAAMGsGBpgQmZcq', 'Arsy Bintang Ramadhani', '2', 'default.png', '1', NULL, '2026-08-24 12:05:16', NULL);
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('28', 'n.elmiatun', 'n.elmiatun@gmail.com', '$2y$10$UPkbaUlgqcegP4WFyN7s2OPW85aG02oTtxF0jxN1f4h2dhuOesoGe', 'Elmiatun Nafiah', '3', 'default.png', '1', '2026-08-24 14:17:11', '2026-08-24 12:05:16', '2026-08-24 14:17:11');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('29', 'fakhrurrozi0496', 'fakhrurrozi0496@gmail.com', '$2y$10$gLRJX3m26BJq7HXN0ancneHXLLUH/nwzCUFupcA.UH.rsxmU1LHvS', 'Fakhrur Rozi', '4', 'default.png', '1', '2026-08-24 12:08:51', '2026-08-24 12:05:16', '2026-08-24 19:08:51');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('30', 'hhauradf25', 'hhauradf25@gmail.com', '$2y$10$hPyXpa5roFdyey2G9NSU6.7ajPIcAyE.fcBKuymvId2MT3YQoFZ.m', 'Hanindria Haura Dzikra Fitranti', '6', 'default.png', '1', '2026-08-29 12:06:18', '2026-08-24 12:05:16', '2026-08-29 19:06:18');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('31', 'lazatina97', 'lazatina97@gmail.com', '$2y$10$B7.HdlgxQn/XI6nHmGjOOOsmx.v8ZioVv2O7AISWigsxbPfTt/qju', 'Lazatin \'Aniqoh', '3', 'default.png', '1', NULL, '2026-08-24 12:05:16', NULL);
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('32', 'um.alifudin93', 'um.alifudin93@gmail.com', '$2y$10$UCghhUyK5zj1M4V0Ge1jsuFaDhhKfKA.EEblPQPIJJeWl35uR0rCS', 'M. Alifudin Ikhsan', '2', 'default.png', '1', NULL, '2026-08-24 12:05:16', NULL);
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('33', 'ahsan.thoriq31', 'ahsan.thoriq31@gmail.com', '$2y$10$wisWEmwXg7xTZzjT4KmtbuhjzsqdR5WAyMwjBPs0Q.y5Oe5Y6F8wu', 'Muhammad Ahsan Thoriq', '2', 'default.png', '1', NULL, '2026-08-24 12:05:16', NULL);
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('34', 'nilnalminach452', 'nilnalminach452@gmail.com', '$2y$10$78494tmG7Bcsfb/h.j7fGOdAfDa180g6KifO3THFw2lXiQKb6O1uK', 'Nilnaminach Ziyadatul \'Ishma', '3', 'default.png', '1', NULL, '2026-08-24 12:05:16', '2026-08-24 13:02:16');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('35', 'dzulqodah06', 'dzulqodah06@gmail.com', '$2y$10$cacQmcSIwyt/C.RnSVlRFeloSdQw3mYO/LuHNiP2jdkGKMSGBlLB6', 'Nur Arifah Dzul Qo\'dah', '2', 'default.png', '1', '2026-08-24 13:55:19', '2026-08-24 12:05:16', '2026-08-24 13:55:19');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('36', 'nurindaha97', 'nurindaha97@gmail.com', '$2y$10$5vWXi4axIzj5iGlJAOmPL.1K3JjtNNbwP0O4OCoUDc1YZXC32HOZS', 'Nur Indah Agustina', '5', 'default.png', '1', '2026-08-24 12:11:13', '2026-08-24 12:05:17', '2026-08-24 19:11:13');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('37', 'zamzanip', 'zamzanip@gmail.com', '$2y$10$ASVXXJ32LB77FI.nAULrXuRKuk4xqueWjjZzHsohBryIcU75XBhSa', 'Pratiwi Nur Zamzani', '3', 'default.png', '1', NULL, '2026-08-24 12:05:17', NULL);
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('38', 'cahyakumala2002', 'cahyakumala2002@gmail.com', '$2y$10$cLJ07hNyeO.VuUvlaEVKCu9gs58ZB35Fr23OKYB3aBRpzC82gZwoa', 'Rudy Cahya Kumala', '2', 'default.png', '1', '2026-08-24 13:37:37', '2026-08-24 12:05:17', '2026-08-24 20:37:37');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('39', 'zuhrohamina0', 'zuhrohamina0@gmail.com', '$2y$10$PUVZcmJmlUB7hHu7MviO9uCfHvXPwHFZ0H9ZdF/0TC1dqZ3.AfyCG', 'Siti Aminatuz Zuhroh', '2', 'default.png', '1', NULL, '2026-08-24 12:05:17', NULL);
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role_id`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('40', 'thalitasr7', 'thalitasr7@gmail.com', '$2y$10$imlFmgwNc72Z8VO0PcsfFeTNvGNClCQnOsVKDVX/cL84HgoHIfHYC', 'Thalita Syahda Raniah', '2', 'default.png', '1', NULL, '2026-08-24 12:05:17', NULL);

SET FOREIGN_KEY_CHECKS=1;
