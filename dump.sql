-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for admin_db
CREATE DATABASE IF NOT EXISTS `admin_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `admin_db`;

-- Dumping structure for table admin_db.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `nm_admin` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `admin_id_user_unique` (`id_user`),
  CONSTRAINT `admin_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.admin: ~2 rows (approximately)
INSERT INTO `admin` (`id_admin`, `id_user`, `nm_admin`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Budi Yono', '2026-10-06 20:04:05', '2026-10-07 08:56:36'),
	(2, 2, 'Siti Rahma', '2026-10-06 20:04:05', '2026-10-07 08:56:36');

-- Dumping structure for table admin_db.audit_log
CREATE TABLE IF NOT EXISTS `audit_log` (
  `id_audit` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned DEFAULT NULL,
  `aktivitas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entitas_terkait` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_referensi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_audit`),
  KEY `audit_log_id_user_foreign` (`id_user`),
  CONSTRAINT `audit_log_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.audit_log: ~24 rows (approximately)
INSERT INTO `audit_log` (`id_audit`, `id_user`, `aktivitas`, `entitas_terkait`, `id_referensi`, `waktu`, `keterangan`) VALUES
	(1, 1, 'login', 'User', '1', '2026-10-11 09:23:47', NULL),
	(2, 2, 'login', 'User', '2', '2026-10-11 09:36:28', NULL),
	(3, 2, 'ubah_hak_akses', 'Role', '2', '2026-10-11 09:37:58', NULL),
	(4, 2, 'logout', 'User', '2', '2026-10-11 09:38:09', NULL),
	(5, 1, 'login', 'User', '1', '2026-10-11 09:38:36', NULL),
	(6, 1, 'logout', 'User', '1', '2026-10-11 09:38:57', NULL),
	(7, 1, 'login', 'User', '1', '2026-10-11 09:56:39', NULL),
	(8, 1, 'login', 'User', '1', '2026-10-15 06:38:52', NULL),
	(9, 1, 'logout', 'User', '1', '2026-10-15 06:39:32', NULL),
	(10, 1, 'login', 'User', '1', '2026-10-15 06:40:20', NULL),
	(11, 1, 'logout', 'User', '1', '2026-10-15 06:41:24', NULL),
	(12, 2, 'login_gagal', 'User', NULL, '2026-10-29 04:49:01', 'Login gagal: AN002'),
	(13, 2, 'login', 'User', '2', '2026-10-29 04:49:10', NULL),
	(14, 1, 'login', 'User', '1', '2026-10-29 04:52:22', NULL),
	(15, 1, 'logout', 'User', '1', '2026-10-29 04:52:57', NULL),
	(16, 1, 'login', 'User', '1', '2026-10-29 06:50:43', NULL),
	(17, 1, 'logout', 'User', '1', '2026-10-29 06:50:52', NULL),
	(18, 1, 'login', 'User', '1', '2026-10-29 06:59:50', NULL),
	(19, 1, 'login', 'User', '1', '2026-10-29 07:02:58', NULL),
	(20, 1, 'login', 'User', '1', '2026-11-04 06:29:55', NULL),
	(21, 1, 'login', 'User', '1', '2026-11-04 07:24:59', NULL),
	(22, 1, 'ubah', 'KonfigSistem', '4', '2026-11-04 07:25:13', 'ubah KonfigSistem #4'),
	(23, 1, 'ubah', 'KonfigSistem', '3', '2026-11-04 07:25:21', 'ubah KonfigSistem #3'),
	(24, 1, 'ekspor_laporan', 'Laporan', '2026-10-06_2026-11-04', '2026-11-04 07:25:57', NULL),
	(25, 1, 'logout', 'User', '1', '2026-11-04 07:28:45', NULL),
	(26, 2, 'login', 'User', '2', '2026-11-05 06:27:46', NULL);

-- Dumping structure for table admin_db.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.cache: ~11 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-sesi_terakhir_18', 'i:1791711007;', 1791714607),
	('laravel-cache-sesi_terakhir_19', 'i:1791711489;', 1791715089),
	('laravel-cache-sesi_terakhir_20', 'i:1791711537;', 1791715137),
	('laravel-cache-sesi_terakhir_21', 'i:1791712613;', 1791716213),
	('laravel-cache-sesi_terakhir_22', 'i:1792046372;', 1792049972),
	('laravel-cache-sesi_terakhir_23', 'i:1792046484;', 1792050084),
	('laravel-cache-sesi_terakhir_24', 'i:1793249363;', 1793252963),
	('laravel-cache-sesi_terakhir_25', 'i:1793249577;', 1793253177),
	('laravel-cache-sesi_terakhir_26', 'i:1793256652;', 1793260252),
	('laravel-cache-sesi_terakhir_29', 'i:1793773809;', 1793777409),
	('laravel-cache-sesi_terakhir_30', 'i:1793777325;', 1793780925);

-- Dumping structure for table admin_db.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.cache_locks: ~0 rows (approximately)

-- Dumping structure for table admin_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table admin_db.hak_akses
CREATE TABLE IF NOT EXISTS `hak_akses` (
  `id_akses` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_role` bigint unsigned NOT NULL,
  `nm_fitur` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lihat` tinyint(1) NOT NULL DEFAULT '0',
  `tambah` tinyint(1) NOT NULL DEFAULT '0',
  `ubah` tinyint(1) NOT NULL DEFAULT '0',
  `hapus` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_akses`),
  UNIQUE KEY `hak_akses_id_role_nm_fitur_unique` (`id_role`,`nm_fitur`),
  CONSTRAINT `hak_akses_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.hak_akses: ~39 rows (approximately)
INSERT INTO `hak_akses` (`id_akses`, `id_role`, `nm_fitur`, `lihat`, `tambah`, `ubah`, `hapus`, `created_at`, `updated_at`) VALUES
	(1, 1, 'dashboard', 1, 1, 1, 1, NULL, NULL),
	(2, 1, 'manajemen_user', 1, 1, 1, 1, NULL, NULL),
	(3, 1, 'role_hak_akses', 1, 1, 1, 1, NULL, NULL),
	(4, 1, 'konfigurasi_sistem', 1, 1, 1, 1, NULL, NULL),
	(5, 1, 'audit_log', 1, 0, 0, 0, NULL, NULL),
	(6, 1, 'operator', 1, 1, 1, 1, NULL, NULL),
	(7, 1, 'pengemudi', 1, 1, 1, 1, NULL, NULL),
	(8, 1, 'charging_station', 1, 1, 1, 1, NULL, NULL),
	(9, 1, 'charger', 1, 1, 1, 1, NULL, NULL),
	(10, 1, 'tarif', 1, 1, 1, 1, NULL, NULL),
	(11, 1, 'perbaikan', 1, 1, 1, 1, NULL, NULL),
	(12, 1, 'kendaraan', 1, 1, 1, 1, NULL, NULL),
	(13, 1, 'sesi_charge', 1, 1, 1, 1, NULL, NULL),
	(14, 1, 'transaksi', 1, 1, 1, 1, NULL, NULL),
	(15, 1, 'keluhan', 1, 1, 1, 1, NULL, NULL),
	(16, 1, 'notifikasi', 1, 1, 1, 1, NULL, NULL),
	(17, 2, 'dashboard', 1, 0, 0, 0, NULL, NULL),
	(18, 2, 'charging_station', 1, 0, 1, 0, NULL, NULL),
	(19, 2, 'charger', 1, 1, 1, 1, NULL, NULL),
	(20, 2, 'tarif', 1, 1, 1, 1, NULL, NULL),
	(21, 2, 'perbaikan', 1, 1, 1, 0, NULL, NULL),
	(22, 2, 'keluhan', 1, 0, 1, 0, NULL, NULL),
	(23, 2, 'notifikasi', 1, 0, 0, 0, NULL, NULL),
	(24, 3, 'dashboard', 1, 0, 0, 0, NULL, NULL),
	(25, 3, 'kendaraan', 1, 1, 1, 1, NULL, NULL),
	(26, 3, 'sesi_charge', 1, 1, 0, 0, NULL, NULL),
	(27, 3, 'transaksi', 1, 1, 0, 0, NULL, NULL),
	(28, 3, 'keluhan', 1, 1, 0, 0, NULL, NULL),
	(29, 3, 'notifikasi', 1, 0, 0, 0, NULL, NULL),
	(30, 2, 'audit_log', 0, 0, 0, 0, NULL, NULL),
	(31, 2, 'kendaraan', 0, 0, 0, 0, NULL, NULL),
	(32, 2, 'konfigurasi_sistem', 0, 0, 0, 0, NULL, NULL),
	(33, 2, 'manajemen_user', 0, 0, 0, 0, NULL, NULL),
	(34, 2, 'operator', 0, 0, 0, 0, NULL, NULL),
	(35, 2, 'pengemudi', 0, 0, 0, 0, NULL, NULL),
	(36, 2, 'role_hak_akses', 0, 0, 0, 0, NULL, NULL),
	(37, 2, 'sesi_charge', 0, 0, 0, 0, NULL, NULL),
	(38, 2, 'transaksi', 0, 0, 0, 0, NULL, NULL),
	(39, 1, 'laporan', 1, 0, 0, 0, NULL, NULL);

-- Dumping structure for table admin_db.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.jobs: ~0 rows (approximately)

-- Dumping structure for table admin_db.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.job_batches: ~0 rows (approximately)

-- Dumping structure for table admin_db.konfig_sistem
CREATE TABLE IF NOT EXISTS `konfig_sistem` (
  `id_konfig` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nm_konfig` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` text COLLATE utf8mb4_unicode_ci,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_konfig`),
  UNIQUE KEY `konfig_sistem_nm_konfig_unique` (`nm_konfig`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.konfig_sistem: ~4 rows (approximately)
INSERT INTO `konfig_sistem` (`id_konfig`, `nm_konfig`, `nilai`, `deskripsi`, `created_at`, `updated_at`) VALUES
	(1, 'nama_aplikasi', 'Admin RPL', 'Nama yang tampil di header', '2026-11-04 00:13:41', '2026-11-04 00:13:41'),
	(2, 'timeout_sesi_menit', '10', 'Batas sesi tidak aktif (menit)', '2026-11-04 00:13:41', '2026-11-04 00:13:41'),
	(3, 'maks_percobaan_login', '3', 'Maksimal percobaan login gagal', '2026-11-04 00:13:41', '2026-11-04 00:25:21'),
	(4, 'mode_pemeliharaan', '0', '1 = aktif, 0 = nonaktif', '2026-11-04 00:13:41', '2026-11-04 00:13:41');

-- Dumping structure for table admin_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0000_01_01_000000_create_roles_table', 1),
	(2, '0001_01_01_000000_create_users_table', 1),
	(3, '0001_01_01_000001_create_cache_table', 1),
	(4, '0001_01_01_000002_create_jobs_table', 1),
	(5, '2026_09_28_033022_create_personal_access_tokens_table', 1),
	(6, '2026_09_29_093903_create_admins_table', 1),
	(7, '2026_09_30_023749_create_hak__akses_table', 1),
	(8, '2026_09_30_074144_create_audit__logs_table', 1),
	(9, '2026_09_30_074154_create_konfig__logs_table', 1),
	(10, '2026_09_30_074235_create_notifikasis_table', 1),
	(11, '2026_09_30_201411_create_sessions_table', 1),
	(12, '2026_10_07_025205_create_pengemudi_table', 1);

-- Dumping structure for table admin_db.notifikasi
CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id_notif` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `jenis` enum('Selesai','Pending','Gagal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_baca` tinyint(1) NOT NULL DEFAULT '0',
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notif`),
  KEY `notifikasi_id_user_foreign` (`id_user`),
  CONSTRAINT `notifikasi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.notifikasi: ~0 rows (approximately)

-- Dumping structure for table admin_db.pengemudi
CREATE TABLE IF NOT EXISTS `pengemudi` (
  `id_pengemudi` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `nm_pengemudi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengemudi`),
  UNIQUE KEY `pengemudi_id_user_unique` (`id_user`),
  UNIQUE KEY `pengemudi_email_unique` (`email`),
  UNIQUE KEY `pengemudi_no_hp_unique` (`no_hp`),
  CONSTRAINT `pengemudi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.pengemudi: ~0 rows (approximately)
INSERT INTO `pengemudi` (`id_pengemudi`, `id_user`, `nm_pengemudi`, `email`, `no_hp`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Rafael', 'rafael@gmail.com', '081234567890', '2026-10-06 20:04:05', '2026-10-07 08:56:36');

-- Dumping structure for table admin_db.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.personal_access_tokens: ~21 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'admin', '6273add43b4965a090bb4e7ad335dd67f6951e63645f1504ebd5ecc8877d3d03', '["*"]', NULL, NULL, '2026-10-07 07:41:09', '2026-10-07 07:41:09'),
	(2, 'App\\Models\\User', 2, 'admin', 'ba91421b18f42964077ef5adb05811beb057994dad09eba812e8923708c12715', '["*"]', NULL, NULL, '2026-10-07 07:42:15', '2026-10-07 07:42:15'),
	(3, 'App\\Models\\User', 1, 'admin', 'efeb7f8aec27ca764691a1f0594c3e4064b7cf1ea3375bc3abc6f8aa775522e7', '["*"]', NULL, NULL, '2026-10-07 08:05:50', '2026-10-07 08:05:50'),
	(4, 'App\\Models\\User', 2, 'admin', 'f7b295367d1d49dae7166e6428a2b2731838bcd327c50974385245d8e58e1df0', '["*"]', NULL, NULL, '2026-10-07 08:07:46', '2026-10-07 08:07:46'),
	(5, 'App\\Models\\User', 1, 'admin', 'b7eee7c80ec7669d7d4ae2dc257684fb7d9ab3bcdd66fee825899af777bc1c29', '["*"]', NULL, NULL, '2026-10-07 08:10:28', '2026-10-07 08:10:28'),
	(6, 'App\\Models\\User', 1, 'admin', '30e9e4703af6fb20d2fd12ac6816104a30c1eb2d32a3cb6716019adece1792bf', '["*"]', NULL, NULL, '2026-10-07 08:10:46', '2026-10-07 08:10:46'),
	(7, 'App\\Models\\User', 1, 'admin', '6ba9a49fcf1a7057060e0b369611f4e23013a438ab1f8c3f955a7001f396efe7', '["*"]', NULL, NULL, '2026-10-07 08:17:21', '2026-10-07 08:17:21'),
	(8, 'App\\Models\\User', 2, 'admin', 'd6a0b55074301ff2e19789ec1c019ab3bba1a306a0c7d24648bd0eed5504a483', '["*"]', '2026-10-07 08:22:08', NULL, '2026-10-07 08:21:42', '2026-10-07 08:22:08'),
	(9, 'App\\Models\\User', 1, 'admin', 'b19f36bfc113e8f1772d9e878ebf28942068c06a47abf4ec01d40bd8ff3b5bfb', '["*"]', '2026-10-07 08:30:01', NULL, '2026-10-07 08:29:49', '2026-10-07 08:30:01'),
	(10, 'App\\Models\\User', 1, 'admin', 'abc0f25c927d8336ecbf6ca572f59e78cb3243be7690d9a93d53228c044c01ac', '["*"]', '2026-10-07 08:33:19', NULL, '2026-10-07 08:32:52', '2026-10-07 08:33:19'),
	(11, 'App\\Models\\User', 1, 'test-admin', 'e1b2ab9184af4f4d39ee5500182063e513f544f37f2e3b15168f07e87f57d17e', '["*"]', '2026-10-07 09:15:05', NULL, '2026-10-07 09:06:51', '2026-10-07 09:15:05'),
	(12, 'App\\Models\\User', 4, 'test-pengemudi', '76998f8eab3ef2bcd4a593d6436d8a3ec4b389165a171339c1c440bf4f8543ab', '["*"]', '2026-10-07 09:17:17', NULL, '2026-10-07 09:07:37', '2026-10-07 09:17:17'),
	(13, 'App\\Models\\User', 3, 'test-operator', '32e50ae134369c813ea08a3ed779f0af5c78005d9eadce7062d7863813fddcd9', '["*"]', '2026-10-07 09:13:02', NULL, '2026-10-07 09:08:04', '2026-10-07 09:13:02'),
	(14, 'App\\Models\\User', 1, 'admin', 'aba082ae492d5be33e911b6e150c18a52120665548bd609a50f63853cb2bf6b9', '["*"]', '2026-10-11 00:44:19', NULL, '2026-10-11 00:44:02', '2026-10-11 00:44:19'),
	(15, 'App\\Models\\User', 1, 'admin', 'bc32833e4596add55abe4d9d33d5dad61eb31a1159890f14de32518f1a517fc9', '["*"]', '2026-10-11 00:45:26', NULL, '2026-10-11 00:45:23', '2026-10-11 00:45:26'),
	(16, 'App\\Models\\User', 2, 'admin', '46169114d1ac961158aef27f4cb615050ef1201a5030a5107f6fa51dd33d16ca', '["*"]', NULL, NULL, '2026-10-11 00:46:46', '2026-10-11 00:46:46'),
	(17, 'App\\Models\\User', 1, 'admin', '4e99a3fcf09f715b804f6cb401a879d80b9928ecc1f853e0c7646d9223b3c05e', '["*"]', NULL, NULL, '2026-10-11 01:22:57', '2026-10-11 01:22:57'),
	(18, 'App\\Models\\User', 1, 'admin', '44b445fa27f35ceb25b195380f23ea9610137766da40514ed638ac7fe8ad50a2', '["*"]', '2026-10-11 02:30:07', NULL, '2026-10-11 02:23:47', '2026-10-11 02:30:07'),
	(21, 'App\\Models\\User', 1, 'admin', '82b882bfb48119f18c2da33629a62271e225442dcb19ba90d303cd02c9352755', '["*"]', '2026-10-11 02:56:53', NULL, '2026-10-11 02:56:39', '2026-10-11 02:56:53'),
	(24, 'App\\Models\\User', 2, 'admin', '071b8cb609019c084b43e4921957cb29ba0dad6b6bb424fabc21c6c05840d892', '["*"]', '2026-10-28 21:49:23', NULL, '2026-10-28 21:49:11', '2026-10-28 21:49:23'),
	(29, 'App\\Models\\User', 1, 'admin', '80398c2086d334f73a94d6da7b25d79a2f676cfd50b1db07cd156beba84ae149', '["*"]', '2026-11-03 23:30:09', NULL, '2026-11-03 23:29:57', '2026-11-03 23:30:09');

-- Dumping structure for table admin_db.role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nma_role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `role_nma_role_unique` (`nma_role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.role: ~3 rows (approximately)
INSERT INTO `role` (`id_role`, `nma_role`, `status`) VALUES
	(1, 'admin', 'aktif'),
	(2, 'operator', 'aktif'),
	(3, 'pengemudi', 'aktif');

-- Dumping structure for table admin_db.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.sessions: ~7 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('8smSobH6w7ZlvKGgolnIaqYdDk3kIoroYqVtsvb5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.144.1 Chrome/150.0.7871.250 Electron/43.8.3 Safari/537.36', 'eyJfdG9rZW4iOiJ2S2htT3JSTVpxQ01SeE9pNFZSR2REajJudzA3T1MyRVZzRXBoeEU1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1793861043),
	('9JN82Tpc0BVipEca8yrM4XnoSPihg7d2p1qHkAjR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.141.0 Chrome/150.0.7871.250 Electron/43.7.7 Safari/537.36', 'eyJfdG9rZW4iOiJLQ090MU5sa1d4NVF1UU03Rmt0OE9aSmhpdnkwQ0tJeE16QjBuRHR2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1792046484),
	('cigGIrfFzCeqDS3pzMslKHcYNOXhMhe6h8Xopsip', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.143.1 Chrome/150.0.7871.250 Electron/43.7.7 Safari/537.36', 'eyJfdG9rZW4iOiJTTFA3R2p4VXNWSTFkWVF2akhhMWVDUWwyS0dCcVpjajlKejZxeFZKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1793773775),
	('Q4NOeKadI3XWK4eVmC7TrFd3ukoXTQM3o8jPRJjF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.141.0 Chrome/150.0.7871.250 Electron/43.7.7 Safari/537.36', 'eyJfdG9rZW4iOiJPR3VwSlVSUkJGNXBiUGlyUW1MUGJ4bkU2WlRscHdRQUd2eGl6c2k2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1792046305),
	('QgyzJtdyFUpF97y59dNzfyDMKZpDfonKqfJr8Gav', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.140.0 Chrome/150.0.7871.250 Electron/43.7.3 Safari/537.36', 'eyJfdG9rZW4iOiIxcHJiWXplYW9YVXpNWGpPTW9oV0hjS29GN3FDdVA3ZmpIZ3pvMW1UIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvdXNlciIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1791712612),
	('VyfcrotCPHQCsWR0B9XpbgnM1NHG8SLqkPIp5vMX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.143.1 Chrome/150.0.7871.250 Electron/43.7.7 Safari/537.36', 'eyJfdG9rZW4iOiJ3d3poMHl6UERVM21FR2J3dkRUcEN4cFlIUjNZUFlReWpuU0c2YkF3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1793258582),
	('Wt2jVzRr7hZQYQXUZ5gskXfbKHOTwPMNyam1jtyn', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.144.1 Chrome/150.0.7871.250 Electron/43.8.3 Safari/537.36', 'eyJfdG9rZW4iOiJxQkRtOW5XZ1NRN0VzTlFvbm9aYm9KMTFhblNKaFdCZHFiQ3IweFluIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1793777325);

-- Dumping structure for table admin_db.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_role` bigint unsigned NOT NULL,
  `identifier` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_identifier_unique` (`identifier`),
  KEY `user_id_role_foreign` (`id_role`),
  CONSTRAINT `user_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table admin_db.user: ~4 rows (approximately)
INSERT INTO `user` (`id_user`, `id_role`, `identifier`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 1, 'AN001', '$2y$12$9JvmQtyOvAnRO/MM32G5BOLfjSxMhaLowppCxFuPtiIcncUyP/1OS', 'aktif', NULL, '2026-10-06 20:04:03', '2026-10-07 08:56:35'),
	(2, 1, 'AN002', '$2y$12$D1KJQEw0cn4grjgK/cri.eO61OGLGOgko/aJPONQgyOBfala.1Fmq', 'aktif', NULL, '2026-10-06 20:04:03', '2026-10-07 08:56:35'),
	(3, 2, 'OP001', '$2y$12$1SXZhknMNrFnCbikgPMTVOGRVcYT7GH2gkFPgTRRXnY9WNVep/uMS', 'aktif', NULL, '2026-10-06 20:04:03', '2026-10-07 08:56:35'),
	(4, 3, 'rafael', '$2y$12$ocMksFo0n.sakO4nYOtoNO/kHiR9gU227PBb0jWNzSb.iSeEzqqqa', 'aktif', NULL, '2026-10-06 20:04:03', '2026-10-07 08:56:35');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
