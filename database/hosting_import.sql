-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: jg_enterprise
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:04:40'),(2,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:05:40'),(3,4,'LOGIN_SUCCESS','User superadmin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:07:34'),(4,4,'UPDATE_SETTINGS','Memperbarui Pengaturan Sistem','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:14:33'),(5,4,'LOGOUT','User superadmin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:14:42'),(6,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:15:02'),(7,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:15:21'),(8,3,'LOGIN_SUCCESS','User wali1 (Wali Kelas) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:15:30'),(9,3,'SAVE_NILAI','Menyimpan nilai Sumatif_PAS (Penilaian Sumatif_PAS) Kelas ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:26:22'),(10,3,'LOGOUT','User wali1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:27:31'),(11,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:27:39'),(12,2,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260720-0001','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:28:10'),(13,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:47:03'),(14,4,'LOGIN_SUCCESS','User superadmin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:47:09'),(15,4,'LOGOUT','User superadmin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:47:51'),(16,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:47:53'),(17,2,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260720-0002','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:48:23'),(18,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:48:49'),(19,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:51:03'),(20,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:59:24'),(21,4,'LOGIN_SUCCESS','User superadmin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 11:59:29'),(22,4,'DELETE_JURNAL','Menghapus Jurnal ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:05:45'),(23,4,'DELETE_JURNAL','Menghapus Jurnal ID: 2','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:05:55'),(24,4,'LOGOUT','User superadmin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:20:15'),(25,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:20:17'),(26,2,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260720-0001','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:22:24'),(27,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:22:33'),(28,3,'LOGIN_SUCCESS','User wali1 (Wali Kelas) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:22:37'),(29,3,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260720-0002','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:34:14'),(30,3,'LOGOUT','User wali1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:35:08'),(31,4,'LOGIN_SUCCESS','User superadmin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:35:25'),(32,4,'UPDATE_SETTINGS','Memperbarui Pengaturan Sistem & Format Laporan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:38:13'),(33,4,'CREATE_TP','Menambah Tahun Pelajaran 2026/2027 (Ganjil)','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:39:10'),(34,4,'ACTIVATE_TP','Mengaktifkan Tahun Pelajaran ID: 3','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:39:17'),(35,4,'ACTIVATE_TP','Mengaktifkan Tahun Pelajaran ID: 2','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:39:20'),(36,4,'ACTIVATE_TP','Mengaktifkan Tahun Pelajaran ID: 3','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:39:24'),(37,4,'DELETE_TP','Menghapus Tahun Pelajaran ID: 2','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:42:40'),(38,4,'DELETE_TP','Menghapus Tahun Pelajaran ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:42:45'),(39,4,'LOGOUT','User superadmin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-20 12:43:09'),(40,4,'LOGIN_SUCCESS','User superadmin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 03:52:36'),(41,4,'LOGOUT','User superadmin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 03:53:47'),(42,3,'LOGIN_SUCCESS','User wali1 (Wali Kelas) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 03:53:52'),(43,3,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260721-0001','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 03:54:32'),(44,3,'LOGOUT','User wali1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 03:54:47'),(45,4,'LOGIN_SUCCESS','User superadmin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 03:54:54'),(46,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 12:53:13'),(47,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 12:56:18'),(48,4,'LOGIN_SUCCESS','User superadmin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-21 12:56:25'),(49,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 11:45:29'),(50,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 11:45:37'),(51,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 11:45:54'),(52,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 11:46:23'),(53,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 11:47:04'),(54,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 11:47:07'),(55,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 11:47:10'),(56,1,'LOGOUT','User admin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 12:53:46'),(57,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 12:54:17'),(58,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 12:54:36'),(59,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 12:55:58'),(60,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 12:56:32'),(61,1,'LOGOUT','User admin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:07:13'),(62,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:07:22'),(63,2,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260722-0001','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:09:00'),(64,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:11:09'),(65,3,'LOGIN_SUCCESS','User wali1 (Wali Kelas) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:11:45'),(66,3,'LOGOUT','User wali1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:18:26'),(67,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:18:32'),(68,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:18:53'),(69,1,'LOGOUT','User admin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:20:26'),(70,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:20:30'),(71,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:38:49'),(72,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:38:54'),(73,1,'LOGOUT','User admin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:49:41'),(74,3,'LOGIN_SUCCESS','User wali1 (Wali Kelas) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 13:49:52'),(75,3,'LOGOUT','User wali1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:21:16'),(76,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:21:19'),(77,1,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260722-0002','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:28:48'),(78,1,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260722-0003','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:31:09'),(79,1,'SAVE_NILAI','Menyimpan nilai catatan (Harian 1) Kelas ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:42:09'),(80,1,'IMPORT_NILAI','Import Excel catatan (Bab 2) Kelas ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:50:47'),(81,1,'LOGOUT','User admin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:55:22'),(82,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:55:27'),(83,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:55:56'),(84,3,'LOGIN_SUCCESS','User wali1 (Wali Kelas) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:56:00'),(85,3,'LOGOUT','User wali1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:56:04'),(86,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:56:06'),(87,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:56:11'),(88,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 14:56:20'),(89,1,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260722-0004','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:11:56'),(90,1,'SAVE_PERKEMBANGAN','Menyimpan perkembangan diri siswa Kelas ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:13:38'),(91,1,'ADD_PROGRAM_WK','Tambah program kelas: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:14:40'),(92,1,'ADD_KOKURIKULER_WK','Tambah kokurikuler: Gaya Hidup Berkelanjutan (Cinta Bumi, Daur Ulang)','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:15:33'),(93,1,'LOGOUT','User admin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:30:20'),(94,3,'LOGIN_SUCCESS','User wali1 (Wali Kelas) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:30:27'),(95,3,'ADD_CASE_WK','Tambah log penanganan siswa ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:32:43'),(96,3,'ADD_CASE_WK','Tambah log penanganan siswa ID: 3','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:34:50'),(97,3,'ADD_CASE_WK','Tambah log penanganan siswa ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:35:11'),(98,3,'ADD_PROGRAM_WK','Tambah program kelas: n','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:37:02'),(99,3,'LOGOUT','User wali1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:45:19'),(100,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-22 15:45:25'),(101,NULL,'LOGIN_FAILED','Percobaan login gagal untuk identity: admin','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 05:36:59'),(102,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 05:37:47'),(103,1,'EDIT_PROGRAM_WK','Edit program kelas ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 05:41:26'),(104,1,'EDIT_CASE_WK','Edit log penanganan siswa ID: 1','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 05:41:46'),(105,1,'LOGOUT','User admin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 06:31:52'),(106,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 06:31:58'),(107,2,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260725-0001','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 06:36:25'),(108,2,'ADD_KARYA','Menambahkan karya: tahu','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 06:42:01'),(109,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 06:43:59'),(110,3,'LOGIN_SUCCESS','User wali1 (Wali Kelas) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 06:45:06'),(111,3,'LOGOUT','User wali1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 06:50:00'),(112,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 06:50:05'),(113,2,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260725-0002','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-25 07:01:09'),(114,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-28 10:45:14'),(115,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-29 13:30:39'),(116,1,'LOGOUT','User admin logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-29 13:31:12'),(117,2,'LOGIN_SUCCESS','User guru1 (Guru Mata Pelajaran) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-29 13:31:15'),(118,NULL,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260729-0002','0.0.0.0','','2026-07-29 13:41:31'),(119,2,'LOGOUT','User guru1 logout.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-29 13:43:04'),(120,1,'LOGIN_SUCCESS','User admin (Administrator) berhasil login.','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-29 13:43:08'),(121,1,'UPDATE_SETTINGS','Memperbarui Pengaturan Sistem & Format Laporan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-29 13:58:36'),(122,NULL,'CREATE_JURNAL','Membuat Jurnal Kode: JRN-20260729-0002','0.0.0.0','','2026-07-29 14:05:38');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru`
--

DROP TABLE IF EXISTS `guru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru`
--

LOCK TABLES `guru` WRITE;
/*!40000 ALTER TABLE `guru` DISABLE KEYS */;
INSERT INTO `guru` VALUES (1,2,'198501012010011001','Budi Santoso','Drs.','M.Pd.','L','081234567890','guru.math@jurnalguru.sch.id','PNS','2026-07-20 18:04:03',NULL),(2,3,'198802022012022002','Siti Rahma','S.Pd.','M.Si.','P','081298765432','wali.x1@jurnalguru.sch.id','PNS','2026-07-20 18:04:03',NULL);
/*!40000 ALTER TABLE `guru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru_mapel`
--

DROP TABLE IF EXISTS `guru_mapel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru_mapel` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guru_mapel_unique` (`guru_id`,`mapel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru_mapel`
--

LOCK TABLES `guru_mapel` WRITE;
/*!40000 ALTER TABLE `guru_mapel` DISABLE KEYS */;
INSERT INTO `guru_mapel` VALUES (1,1,1),(2,2,2);
/*!40000 ALTER TABLE `guru_mapel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `import_nilai_history`
--

DROP TABLE IF EXISTS `import_nilai_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `import_nilai_history`
--

LOCK TABLES `import_nilai_history` WRITE;
/*!40000 ALTER TABLE `import_nilai_history` DISABLE KEYS */;
INSERT INTO `import_nilai_history` VALUES (1,'IMP-1784731847-7666','Template_Nilai_X_A_FIS-P_(1)2.xlsx',3,1,2,'catatan','Bab 2',1,10,'2026-07-22 21:50:47');
/*!40000 ALTER TABLE `import_nilai_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal_pelajaran`
--

DROP TABLE IF EXISTS `jadwal_pelajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal_pelajaran`
--

LOCK TABLES `jadwal_pelajaran` WRITE;
/*!40000 ALTER TABLE `jadwal_pelajaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `jadwal_pelajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jam_pelajaran`
--

DROP TABLE IF EXISTS `jam_pelajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jam_pelajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `jam_ke` tinyint unsigned NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jam_ke` (`jam_ke`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jam_pelajaran`
--

LOCK TABLES `jam_pelajaran` WRITE;
/*!40000 ALTER TABLE `jam_pelajaran` DISABLE KEYS */;
INSERT INTO `jam_pelajaran` VALUES (1,1,'07:45:00','08:20:00','2026-07-20 18:04:03'),(2,2,'07:45:00','08:30:00','2026-07-20 18:04:03'),(3,3,'08:30:00','09:15:00','2026-07-20 18:04:03'),(4,4,'09:30:00','10:15:00','2026-07-20 18:04:03');
/*!40000 ALTER TABLE `jam_pelajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurnal_guru`
--

DROP TABLE IF EXISTS `jurnal_guru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurnal_guru`
--

LOCK TABLES `jurnal_guru` WRITE;
/*!40000 ALTER TABLE `jurnal_guru` DISABLE KEYS */;
INSERT INTO `jurnal_guru` VALUES (5,NULL,'JRN-20260721-0001','2026-07-21',3,5,2,2,'1-4',NULL,'fdx',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bbkj',NULL,NULL,NULL,NULL,'hvj',NULL,NULL,'Submitted',3,'2026-07-21 10:54:32',NULL),(6,NULL,'JRN-20260722-0001','2026-07-22',3,2,1,1,'2-4',NULL,'aa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'aa',NULL,NULL,NULL,NULL,'aa','assets/uploads/jurnal/mockup_kbm.png',NULL,'Submitted',2,'2026-07-22 20:09:00','2026-07-22 21:44:19'),(7,NULL,'JRN-20260722-0002','2026-07-22',3,1,3,1,'1-3',NULL,'asd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'asd',NULL,NULL,NULL,NULL,'asd','assets/uploads/jurnal/arsitektur_mata_lengkap_awam.png',NULL,'Submitted',1,'2026-07-22 21:28:48',NULL),(8,NULL,'JRN-20260722-0003','2026-07-23',3,5,3,1,'2-3',NULL,'aa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'aa',NULL,NULL,NULL,NULL,'aa','assets/uploads/jurnal/arsitektur_mata_lengkap_awam1.png',NULL,'Submitted',1,'2026-07-22 21:31:09',NULL),(9,NULL,'JRN-20260722-0004','2026-07-22',3,7,3,2,'1-4',NULL,'a',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a',NULL,NULL,NULL,NULL,'a','assets/uploads/jurnal/WhatsApp_Image_2026-07-22_at_21_48_31.jpeg',NULL,'Submitted',1,'2026-07-22 22:11:56',NULL),(10,NULL,'JRN-20260725-0001','2026-07-25',3,2,1,1,'1-3',NULL,'fhghghhg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ffhhy',NULL,NULL,NULL,NULL,'makan mie bludak baunya semerbak','assets/uploads/jurnal/Picture1.png',NULL,'Submitted',2,'2026-07-25 13:36:25',NULL),(11,NULL,'JRN-20260725-0002','2026-07-25',3,2,1,1,'1-2',NULL,'gnf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d',NULL,NULL,NULL,NULL,'xf',NULL,NULL,'Submitted',2,'2026-07-25 14:01:09',NULL),(12,2,'JRN-20260729-0001','2026-07-29',3,1,1,1,'1-2',99,'Variabel & Operator','Siswa mahir dalam tipe data array.','Siswa dapat membuat kode program sederhana.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Siswa dapat membuat kode program sederhana.','Test input auto-populated dari Perangkat Ajar.',NULL,NULL,NULL,NULL,NULL,NULL,'Submitted',1,'2026-07-29 20:39:12',NULL);
/*!40000 ALTER TABLE `jurnal_guru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurnal_walikelas`
--

DROP TABLE IF EXISTS `jurnal_walikelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurnal_walikelas`
--

LOCK TABLES `jurnal_walikelas` WRITE;
/*!40000 ALTER TABLE `jurnal_walikelas` DISABLE KEYS */;
INSERT INTO `jurnal_walikelas` VALUES (1,3,1,2,'2026-07-22','1','1','1','Terealisasi','1',NULL,'2026-07-22 22:14:40','2026-07-25 12:41:26'),(2,3,1,2,'2026-07-22','n','j',' j','Belum','j',NULL,'2026-07-22 22:37:02',NULL);
/*!40000 ALTER TABLE `jurnal_walikelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karya_pembelajaran`
--

DROP TABLE IF EXISTS `karya_pembelajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `karya_pembelajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `mapel_id` int unsigned NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tanggal` date NOT NULL,
  `materi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_karya` enum('Foto','Video','PDF','PowerPoint','Word','LKPD','Poster','Produk','Portofolio') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_publikasi` enum('Draft','Publik') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Draft',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `guru_id` (`guru_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `mapel_id` (`mapel_id`),
  CONSTRAINT `karya_pembelajaran_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  CONSTRAINT `karya_pembelajaran_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `karya_pembelajaran_ibfk_3` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karya_pembelajaran`
--

LOCK TABLES `karya_pembelajaran` WRITE;
/*!40000 ALTER TABLE `karya_pembelajaran` DISABLE KEYS */;
INSERT INTO `karya_pembelajaran` VALUES (1,1,2,1,'tahu','sel','2026-07-25','sel','Foto','','Publik','assets/uploads/karya/Picture1.png','2026-07-25 13:42:01',NULL);
/*!40000 ALTER TABLE `karya_pembelajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_penilaian`
--

DROP TABLE IF EXISTS `kategori_penilaian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_penilaian`
--

LOCK TABLES `kategori_penilaian` WRITE;
/*!40000 ALTER TABLE `kategori_penilaian` DISABLE KEYS */;
INSERT INTO `kategori_penilaian` VALUES (1,'catatan','Catatan',7,'sistem',1,'2026-07-22 20:33:48','2026-07-22 21:54:49'),(2,'tugas','Tugas',15,'sistem',1,'2026-07-22 20:33:48','2026-07-22 21:54:49'),(3,'uh','Ulangan Harian',10,'sistem',1,'2026-07-22 20:33:48','2026-07-22 21:54:49'),(4,'sts','STS',15,'sistem',1,'2026-07-22 20:33:48','2026-07-22 21:54:49'),(5,'praktik','Proyek',15,'sistem',1,'2026-07-22 20:33:48','2026-07-22 21:54:49'),(6,'portofolio','Portofolio',15,'sistem',0,'2026-07-22 20:33:48','2026-07-22 21:54:49'),(7,'asas','ASAS',33,'sistem',1,'2026-07-22 21:52:23','2026-07-22 21:54:49'),(8,'sikap','Sikap',5,'sistem',1,'2026-07-22 21:54:49',NULL);
/*!40000 ALTER TABLE `kategori_penilaian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'X-A','X A','10',2,'2026-07-20 18:04:03','2026-07-22 20:33:48'),(2,'X-B','X B','10',1,'2026-07-20 18:04:03','2026-07-22 20:33:48'),(5,'XI-A','XI A','11',2,'2026-07-20 18:29:01','2026-07-22 20:33:48'),(6,'XI-B','XI B','11',1,'2026-07-20 18:29:01','2026-07-22 20:33:48'),(7,'XII-A','XII A','12',2,'2026-07-20 18:29:01','2026-07-22 20:33:48'),(8,'XII-B','XII B','12',1,'2026-07-20 18:29:01','2026-07-22 20:33:48');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kokurikuler`
--

DROP TABLE IF EXISTS `kokurikuler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kokurikuler` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `guru_id` int unsigned NOT NULL,
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
  CONSTRAINT `kokurikuler_ibfk_1` FOREIGN KEY (`tahun_pelajaran_id`) REFERENCES `tahun_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kokurikuler_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kokurikuler_ibfk_3` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kokurikuler`
--

LOCK TABLES `kokurikuler` WRITE;
/*!40000 ALTER TABLE `kokurikuler` DISABLE KEYS */;
INSERT INTO `kokurikuler` VALUES (1,3,1,2,'Gaya Hidup Berkelanjutan (Cinta Bumi, Daur Ulang)','11','1','1','2026-07-22',NULL,NULL,'Draft','1','2026-07-22 22:15:33',NULL);
/*!40000 ALTER TABLE `kokurikuler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_attempts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempt_time` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_attempt_ip_user` (`ip_address`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mata_pelajaran`
--

DROP TABLE IF EXISTS `mata_pelajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mata_pelajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_mapel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_mapel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelompok` enum('Wajib','Peminatan','Muatan Lokal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Wajib',
  `kkm` decimal(5,2) DEFAULT '75.00',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_mapel` (`kode_mapel`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mata_pelajaran`
--

LOCK TABLES `mata_pelajaran` WRITE;
/*!40000 ALTER TABLE `mata_pelajaran` DISABLE KEYS */;
INSERT INTO `mata_pelajaran` VALUES (1,'MAT-W','Matematika Wajib','Wajib',75.00,'2026-07-20 18:04:03',NULL),(2,'FIS-P','Fisika Peminatan','Peminatan',75.00,'2026-07-20 18:04:03',NULL),(3,'BIN-W','Bahasa Indonesia','Wajib',78.00,'2026-07-20 18:04:03',NULL);
/*!40000 ALTER TABLE `mata_pelajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penanganan_siswa`
--

DROP TABLE IF EXISTS `penanganan_siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penanganan_siswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun_pelajaran_id` int unsigned NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `siswa_id` int unsigned NOT NULL,
  `wali_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `permasalahan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('Akademik','Disiplin','Perilaku','Kesehatan','Sosial') COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penanganan_siswa`
--

LOCK TABLES `penanganan_siswa` WRITE;
/*!40000 ALTER TABLE `penanganan_siswa` DISABLE KEYS */;
INSERT INTO `penanganan_siswa` VALUES (1,3,1,1,2,'2026-07-22','.h','Perilaku','pl','pl','pl','assets/uploads/walikelas/Laporan_Jurnal_Guru_Enterprise_.pdf','Selesai','2026-07-22 22:32:43','2026-07-25 12:41:46'),(2,3,1,3,2,'2026-07-22','h','Akademik','u','o','j','assets/uploads/walikelas/Laporan_Jurnal_Guru_Enterprise_1.pdf','Proses','2026-07-22 22:34:50',NULL),(3,3,1,1,2,'2026-07-22','h','Akademik','i','g','u',NULL,'Proses','2026-07-22 22:35:11',NULL);
/*!40000 ALTER TABLE `penanganan_siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penilaian_siswa`
--

DROP TABLE IF EXISTS `penilaian_siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penilaian_siswa`
--

LOCK TABLES `penilaian_siswa` WRITE;
/*!40000 ALTER TABLE `penilaian_siswa` DISABLE KEYS */;
INSERT INTO `penilaian_siswa` VALUES (1,3,1,2,1,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(2,3,1,2,2,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(3,3,1,2,3,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(4,3,1,2,4,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(5,3,1,2,5,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(6,3,1,2,6,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(7,3,1,2,7,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(8,3,1,2,8,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(9,3,1,2,9,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(10,3,1,2,10,1,'catatan','Harian 1',100.00,'',NULL,NULL,NULL,'2026-07-22 21:42:09',NULL),(11,3,1,2,1,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(12,3,1,2,2,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(13,3,1,2,3,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(14,3,1,2,4,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(15,3,1,2,5,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(16,3,1,2,6,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(17,3,1,2,7,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(18,3,1,2,8,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(19,3,1,2,9,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL),(20,3,1,2,10,1,'catatan','Bab 2',100.00,'',NULL,NULL,'IMP-1784731847-7666','2026-07-22 21:50:47',NULL);
/*!40000 ALTER TABLE `penilaian_siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perangkat_ajar`
--

DROP TABLE IF EXISTS `perangkat_ajar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perangkat_ajar`
--

LOCK TABLES `perangkat_ajar` WRITE;
/*!40000 ALTER TABLE `perangkat_ajar` DISABLE KEYS */;
INSERT INTO `perangkat_ajar` VALUES (1,3,'Ganjil',1,1,1,'RPP','Fase E','Elemen Pemrograman Dasar','Siswa mampu memahami variabel dan tipe data.','Siswa dapat membuat kode program sederhana.','Variabel & Operator',NULL,NULL,NULL,NULL,NULL,NULL,NULL,99,'assets/uploads/perangkat/test_rpp.pdf','Disetujui',NULL,1,NULL,0,0,1,'2026-07-29 20:38:51','2026-07-29 20:38:51',NULL,NULL),(2,3,'Ganjil',1,1,1,'RPP','Fase E','Elemen Pemrograman Dasar','Siswa mahir dalam tipe data array.','Siswa dapat membuat kode program sederhana.','Variabel & Operator',NULL,NULL,NULL,NULL,NULL,NULL,NULL,99,'assets/uploads/perangkat/test_rpp.pdf','Menunggu Verifikasi',NULL,2,1,1,0,1,'2026-07-29 13:38:51',NULL,NULL,NULL),(3,3,'Ganjil',1,1,1,'RPP','Fase E','Elemen Pemrograman Dasar','Siswa mampu memahami variabel dan tipe data.','Siswa dapat membuat kode program sederhana.','Variabel & Operator',NULL,NULL,NULL,NULL,NULL,NULL,NULL,99,'assets/uploads/perangkat/test_rpp.pdf','Disetujui',NULL,1,NULL,0,0,1,'2026-07-29 20:39:12','2026-07-29 20:39:12',NULL,NULL),(4,3,'Ganjil',1,1,1,'RPP','Fase E','Elemen Pemrograman Dasar','Siswa mahir dalam tipe data array.','Siswa dapat membuat kode program sederhana.','Variabel & Operator',NULL,NULL,NULL,NULL,NULL,NULL,NULL,99,'assets/uploads/perangkat/test_rpp.pdf','Menunggu Verifikasi',NULL,2,3,1,0,1,'2026-07-29 13:39:12',NULL,NULL,NULL);
/*!40000 ALTER TABLE `perangkat_ajar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perkembangan_rekap`
--

DROP TABLE IF EXISTS `perkembangan_rekap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perkembangan_rekap`
--

LOCK TABLES `perkembangan_rekap` WRITE;
/*!40000 ALTER TABLE `perkembangan_rekap` DISABLE KEYS */;
/*!40000 ALTER TABLE `perkembangan_rekap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perkembangan_siswa`
--

DROP TABLE IF EXISTS `perkembangan_siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perkembangan_siswa`
--

LOCK TABLES `perkembangan_siswa` WRITE;
/*!40000 ALTER TABLE `perkembangan_siswa` DISABLE KEYS */;
INSERT INTO `perkembangan_siswa` VALUES (1,3,1,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(2,3,2,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(3,3,3,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(4,3,4,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(5,3,5,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(6,3,6,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(7,3,7,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(8,3,8,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(9,3,9,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL),(10,3,10,1,3,1,'','','','Baik','Aktif','Disiplin','Tinggi','','2026-07-22 22:13:38',NULL);
/*!40000 ALTER TABLE `perkembangan_siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presensi_kelas`
--

DROP TABLE IF EXISTS `presensi_kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presensi_kelas`
--

LOCK TABLES `presensi_kelas` WRITE;
/*!40000 ALTER TABLE `presensi_kelas` DISABLE KEYS */;
INSERT INTO `presensi_kelas` VALUES (1,5,'2026-07-21','07:45:00','10:15:00',2,2,5,NULL,1,'Terlaksana',NULL,NULL,NULL,'2026-07-28 18:37:51',NULL),(2,6,'2026-07-22','07:45:00','10:15:00',1,1,2,NULL,1,'Terlaksana',NULL,NULL,NULL,'2026-07-28 18:37:51',NULL),(3,7,'2026-07-22','07:45:00','09:15:00',1,3,1,NULL,1,'Terlaksana',NULL,NULL,NULL,'2026-07-28 18:37:51',NULL),(4,8,'2026-07-23','07:45:00','09:15:00',1,3,5,NULL,1,'Terlaksana',NULL,NULL,NULL,'2026-07-28 18:37:51',NULL),(5,9,'2026-07-22','07:45:00','10:15:00',2,3,7,NULL,1,'Terlaksana',NULL,NULL,NULL,'2026-07-28 18:37:51',NULL),(6,10,'2026-07-25','07:45:00','09:15:00',1,1,2,NULL,1,'Terlaksana',NULL,NULL,NULL,'2026-07-28 18:37:51',NULL),(7,11,'2026-07-25','07:45:00','08:30:00',1,1,2,NULL,1,'Terlaksana',NULL,NULL,NULL,'2026-07-28 18:37:51',NULL);
/*!40000 ALTER TABLE `presensi_kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presensi_siswa`
--

DROP TABLE IF EXISTS `presensi_siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presensi_siswa`
--

LOCK TABLES `presensi_siswa` WRITE;
/*!40000 ALTER TABLE `presensi_siswa` DISABLE KEYS */;
INSERT INTO `presensi_siswa` VALUES (31,1,21,'2026-07-21','Hadir','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(32,1,22,'2026-07-21','Hadir','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(33,1,23,'2026-07-21','Alpa','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(34,1,24,'2026-07-21','Hadir','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(35,1,25,'2026-07-21','Hadir','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(36,1,26,'2026-07-21','Hadir','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(37,1,27,'2026-07-21','Sakit','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(38,1,28,'2026-07-21','Hadir','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(39,1,29,'2026-07-21','Dispen','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(40,1,30,'2026-07-21','Hadir','',NULL,'2026-07-21 10:54:32','2026-07-28 18:37:51'),(41,2,11,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(42,2,12,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(43,2,13,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(44,2,14,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(45,2,15,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(46,2,16,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(47,2,17,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(48,2,18,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(49,2,19,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(50,2,20,'2026-07-22','Hadir','',NULL,'2026-07-22 20:09:00','2026-07-28 18:37:51'),(51,3,1,'2026-07-22','Hadir','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(52,3,2,'2026-07-22','Hadir','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(53,3,3,'2026-07-22','Hadir','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(54,3,4,'2026-07-22','Hadir','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(55,3,5,'2026-07-22','Hadir','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(56,3,6,'2026-07-22','Hadir','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(57,3,7,'2026-07-22','Hadir','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(58,3,8,'2026-07-22','Hadir','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(59,3,9,'2026-07-22','Alpa','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(60,3,10,'2026-07-22','Dispen','',NULL,'2026-07-22 21:28:48','2026-07-28 18:37:51'),(61,4,21,'2026-07-23','Izin','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(62,4,22,'2026-07-23','Sakit','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(63,4,23,'2026-07-23','Alpa','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(64,4,24,'2026-07-23','Dispen','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(65,4,25,'2026-07-23','Hadir','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(66,4,26,'2026-07-23','Hadir','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(67,4,27,'2026-07-23','Hadir','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(68,4,28,'2026-07-23','Hadir','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(69,4,29,'2026-07-23','Hadir','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(70,4,30,'2026-07-23','Hadir','',NULL,'2026-07-22 21:31:09','2026-07-28 18:37:51'),(71,5,41,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(72,5,42,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(73,5,43,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(74,5,44,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(75,5,45,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(76,5,46,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(77,5,47,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(78,5,48,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(79,5,49,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(80,5,50,'2026-07-22','Hadir','',NULL,'2026-07-22 22:11:56','2026-07-28 18:37:51'),(81,6,11,'2026-07-25','Hadir','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(82,6,12,'2026-07-25','Hadir','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(83,6,13,'2026-07-25','Alpa','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(84,6,14,'2026-07-25','Alpa','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(85,6,15,'2026-07-25','Dispen','pulang kangen bantal',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(86,6,16,'2026-07-25','Hadir','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(87,6,17,'2026-07-25','Sakit','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(88,6,18,'2026-07-25','Hadir','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(89,6,19,'2026-07-25','Hadir','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(90,6,20,'2026-07-25','Hadir','',NULL,'2026-07-25 13:36:25','2026-07-28 18:37:51'),(91,7,11,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(92,7,12,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(93,7,13,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(94,7,14,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(95,7,15,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(96,7,16,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(97,7,17,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(98,7,18,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(99,7,19,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51'),(100,7,20,'2026-07-25','Hadir','',NULL,'2026-07-25 14:01:09','2026-07-28 18:37:51');
/*!40000 ALTER TABLE `presensi_siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_code` (`role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrator','Full access ke seluruh sistem, master data, dan log','2026-07-20 18:04:03'),(2,'guru','Guru Mata Pelajaran','Akses ke Jurnal Pembelajaran, Presensi, dan Penilaian','2026-07-20 18:04:03'),(3,'walikelas','Wali Kelas','Akses ke Monitoring Kelas, Rekapitulasi Presensi, dan Laporan','2026-07-20 18:04:03'),(4,'kamad','Kepala Madrasah','Monitoring KBM, Kehadiran Kelas, dan Laporan Kepala Madrasah','2026-07-28 18:37:51'),(5,'waka','Waka Kurikulum','Monitoring, evaluasi, dan verifikasi perangkat ajar serta KBM','2026-07-29 20:21:00'),(6,'superadmin','Super Admin','Akses penuh ke seluruh sistem dan konfigurasi internal','2026-07-29 20:21:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ruangan`
--

DROP TABLE IF EXISTS `ruangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ruangan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_ruangan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ruangan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int unsigned DEFAULT '36',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_ruangan` (`kode_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ruangan`
--

LOCK TABLES `ruangan` WRITE;
/*!40000 ALTER TABLE `ruangan` DISABLE KEYS */;
INSERT INTO `ruangan` VALUES (1,'R-101','Ruang Kelas X A',36,'2026-07-20 18:04:03'),(2,'R-LAB-KOMP','Laboratorium Komputer 1',40,'2026-07-20 18:04:03');
/*!40000 ALTER TABLE `ruangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa`
--

LOCK TABLES `siswa` WRITE;
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
INSERT INTO `siswa` VALUES (1,'202510001','0081234501','Ahmad Rizky Pratama','L',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(2,'202510002','0081234502','Anisa Fitriani','P',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(3,'202510003','0081234503','Bayu Putra Nugraha','L',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(4,'202510004','0081234504','Dewi Lestari','P',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(5,'202510005','0081234505','Eko Prasetyo','L',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(6,'202510006','0081234506','Fani Rahmawati','P',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(7,'202510007','0081234507','Gilang Ramadan','L',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(8,'202510008','0081234508','Hani Hidayah','P',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(9,'202510009','0081234509','Irfan Maulana','L',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(10,'202510010','0081234510','Jihan Fahira','P',NULL,NULL,NULL,1,1,'2026-07-20 18:29:01',NULL),(11,'202510011','0081234511','Kharisma Putri','P',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(12,'202510012','0081234512','Lukman Hakim','L',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(13,'202510013','0081234513','Maya Kartika','P',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(14,'202510014','0081234514','Naufal Fikri','L',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(15,'202510015','0081234515','Olivia Sari','P',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(16,'202510016','0081234516','Pandu Wibowo','L',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(17,'202510017','0081234517','Qori Aulia','P',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(18,'202510018','0081234518','Rizky Ramadhan','L',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(19,'202510019','0081234519','Salsabila Syifa','P',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(20,'202510020','0081234520','Taufik Hidayat','L',NULL,NULL,NULL,2,1,'2026-07-20 18:29:01',NULL),(21,'202510021','0081234521','Aditya Pratama','L',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(22,'202510022','0081234522','Bunga Cantika','P',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(23,'202510023','0081234523','Candra Wijaya','L',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(24,'202510024','0081234524','Dina Mariana','P',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(25,'202510025','0081234525','Erlangga Putra','L',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(26,'202510026','0081234526','Fitri Handayani','P',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(27,'202510027','0081234527','Guntur Saputra','L',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(28,'202510028','0081234528','Hesti Anggraini','P',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(29,'202510029','0081234529','Indra Kusuma','L',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(30,'202510030','0081234530','Jessica Putri','P',NULL,NULL,NULL,5,1,'2026-07-20 18:29:01',NULL),(31,'202510031','0081234531','Kevin Sanjaya','L',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(32,'202510032','0081234532','Larasati Wening','P',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(33,'202510033','0081234533','Muhammad Arifin','L',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(34,'202510034','0081234534','Nadia Utami','P',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(35,'202510035','0081234535','Oki Setiawan','L',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(36,'202510036','0081234536','Putri Amelia','P',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(37,'202510037','0081234537','Rafi Ahmad','L',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(38,'202510038','0081234538','Siti Nurhaliza','P',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(39,'202510039','0081234539','Tommy Kurniawan','L',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(40,'202510040','0081234540','Vina Panduwinata','P',NULL,NULL,NULL,6,1,'2026-07-20 18:29:01',NULL),(41,'202510041','0081234541','Alvin Firmansyah','L',NULL,NULL,NULL,7,1,'2026-07-20 18:29:01',NULL),(42,'202510042','0081234542','Bella Safira','P',NULL,NULL,NULL,7,1,'2026-07-20 18:29:01',NULL),(43,'202510043','0081234543','Dhani Ahmad','L',NULL,NULL,NULL,7,1,'2026-07-20 18:29:02',NULL),(44,'202510044','0081234544','Elma Theana','P',NULL,NULL,NULL,7,1,'2026-07-20 18:29:02',NULL),(45,'202510045','0081234545','Fajar Sadboy','L',NULL,NULL,NULL,7,1,'2026-07-20 18:29:02',NULL),(46,'202510046','0081234546','Gisella Anastasia','P',NULL,NULL,NULL,7,1,'2026-07-20 18:29:02',NULL),(47,'202510047','0081234547','Hafiz Akbar','L',NULL,NULL,NULL,7,1,'2026-07-20 18:29:02',NULL),(48,'202510048','0081234548','Intan Nuraini','P',NULL,NULL,NULL,7,1,'2026-07-20 18:29:02',NULL),(49,'202510049','0081234549','Joko Widodo','L',NULL,NULL,NULL,7,1,'2026-07-20 18:29:02',NULL),(50,'202510050','0081234550','Karina Suwandi','P',NULL,NULL,NULL,7,1,'2026-07-20 18:29:02',NULL),(51,'202510051','0081234551','Leo Consul','L',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(52,'202510052','0081234552','Melly Goeslaw','P',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(53,'202510053','0081234553','Nicho Saputra','L',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(54,'202510054','0081234554','Olla Ramlan','P',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(55,'202510055','0081234555','Pasha Ungu','L',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(56,'202510056','0081234556','Raline Shah','P',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(57,'202510057','0081234557','Surya Saputra','L',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(58,'202510058','0081234558','Titi Kamal','P',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(59,'202510059','0081234559','Uus Wijaya','L',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL),(60,'202510060','0081234560','Zaskia Gotik','P',NULL,NULL,NULL,8,1,'2026-07-20 18:29:02',NULL);
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_performance_logs`
--

DROP TABLE IF EXISTS `sys_performance_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_performance_logs`
--

LOCK TABLES `sys_performance_logs` WRITE;
/*!40000 ALTER TABLE `sys_performance_logs` DISABLE KEYS */;
INSERT INTO `sys_performance_logs` VALUES (1,'perangkat_ajar/arsip',0.1271,6.00,3,'2026-07-29 13:36:45'),(2,'perangkat_ajar/arsip',0.1178,6.00,3,'2026-07-29 13:42:58'),(3,'dashboard',0.1219,6.00,12,'2026-07-29 13:43:01'),(4,'login',0.0728,6.00,0,'2026-07-29 13:43:04'),(5,'dashboard',0.0905,6.00,11,'2026-07-29 13:43:08'),(6,'settings',0.0829,6.00,2,'2026-07-29 13:43:10'),(7,'logs',0.0874,6.00,2,'2026-07-29 13:43:24'),(8,'dashboard',0.0969,6.00,11,'2026-07-29 13:43:29'),(9,'dashboard',0.1243,6.00,12,'2026-07-29 13:57:28'),(10,'settings',0.1021,6.00,3,'2026-07-29 13:57:32'),(11,'settings',0.1078,6.00,3,'2026-07-29 13:58:29'),(12,'settings',0.0826,6.00,3,'2026-07-29 13:58:36'),(13,'settings',0.0812,6.00,3,'2026-07-29 13:59:10');
/*!40000 ALTER TABLE `sys_performance_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_slow_queries`
--

DROP TABLE IF EXISTS `sys_slow_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_slow_queries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `query_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `execution_time` decimal(8,4) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_slow_created` (`created_at`),
  KEY `idx_slow_time` (`execution_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_slow_queries`
--

LOCK TABLES `sys_slow_queries` WRITE;
/*!40000 ALTER TABLE `sys_slow_queries` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_slow_queries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'app_name','Jurnal Guru MA Darul Faqih Indonesia','general','Nama Aplikasi Sekolah','2026-07-29 20:58:36'),(2,'app_institution','MA Darul Faqih','general','Nama Sekolah / Institusi','2026-07-20 18:14:33'),(3,'app_logo','assets/static/logo.png','general','Logo Aplikasi',NULL),(4,'app_address','Jl. Gapura 197 Pandanlandung','general','Alamat Sekolah','2026-07-20 18:14:33'),(8,'report_header_title','LAPORAN JURNAL KEGIATAN BELAJAR MENGAJAR (KBM)','general',NULL,NULL),(9,'report_city','Malang','general',NULL,'2026-07-20 19:38:13'),(10,'report_signer_title','Kepala Sekolah','general',NULL,NULL),(11,'report_signer_name','M. Fakhrur Rozi, M.Pd','general',NULL,'2026-07-20 19:38:13'),(12,'report_signer_nip','','general',NULL,'2026-07-20 19:38:13');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tahun_pelajaran`
--

DROP TABLE IF EXISTS `tahun_pelajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tahun_pelajaran`
--

LOCK TABLES `tahun_pelajaran` WRITE;
/*!40000 ALTER TABLE `tahun_pelajaran` DISABLE KEYS */;
INSERT INTO `tahun_pelajaran` VALUES (3,'2026/2027','Ganjil',1,'2026-07-20 19:39:10','2026-07-20 19:39:24');
/*!40000 ALTER TABLE `tahun_pelajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@jurnalguru.sch.id','$2y$10$p5B4W4pJTSUKRtd2q4R74Ords6eRzbjvRLt.mRkqy5yIX8BHF.8K2','Administrator Utama',1,'default.png',1,'2026-07-29 13:43:08','2026-07-20 18:04:03','2026-07-29 20:43:08'),(2,'guru1','guru.math@jurnalguru.sch.id','$2y$10$p5B4W4pJTSUKRtd2q4R74Ords6eRzbjvRLt.mRkqy5yIX8BHF.8K2','Budi Santoso, S.Pd.',2,'default.png',1,'2026-07-29 13:31:15','2026-07-20 18:04:03','2026-07-29 20:31:15'),(3,'wali1','wali.x1@jurnalguru.sch.id','$2y$10$p5B4W4pJTSUKRtd2q4R74Ords6eRzbjvRLt.mRkqy5yIX8BHF.8K2','Siti Rahma, M.Pd.',3,'default.png',1,'2026-07-25 06:45:06','2026-07-20 18:04:03','2026-07-25 13:45:06'),(4,'superadmin','superadmin@jurnalguru.sch.id','$2y$10$p5B4W4pJTSUKRtd2q4R74Ords6eRzbjvRLt.mRkqy5yIX8BHF.8K2','Dr. H. Ahmad Fauzi, M.Ag.',1,'default.png',1,'2026-07-21 12:56:25','2026-07-20 18:06:10','2026-07-28 18:37:51');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-29 21:15:27
