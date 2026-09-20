-- ========================================================
-- DATABASE STRUCTURE UPDATE: MONITORING & BACKUP MODULE
-- Database Name: jg_enterprise
-- Created Date: 2026-09-20 12:54:20
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- Structure for table: sys_slow_queries
CREATE TABLE IF NOT EXISTS `sys_slow_queries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `query_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `execution_time` decimal(8,4) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_slow_created` (`created_at`),
  KEY `idx_slow_time` (`execution_time`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Structure for table: sys_performance_logs
CREATE TABLE IF NOT EXISTS `sys_performance_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `execution_time` decimal(8,4) NOT NULL,
  `memory_usage` decimal(8,2) NOT NULL,
  `query_count` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_perf_created` (`created_at`),
  KEY `idx_perf_time` (`execution_time`)
) ENGINE=InnoDB AUTO_INCREMENT=4466 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Structure for table: system_settings
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Structure for table: activity_logs
CREATE TABLE IF NOT EXISTS `activity_logs` (
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
) ENGINE=InnoDB AUTO_INCREMENT=1195 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
