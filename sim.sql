-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mini_simrs
CREATE DATABASE IF NOT EXISTS `mini_simrs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mini_simrs`;

-- Dumping structure for table mini_simrs.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table mini_simrs.maintenance
CREATE TABLE IF NOT EXISTS `maintenance` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `perangkat_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('perbaikan','perawatan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','dikerjakan','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintenance_perangkat_id_foreign` (`perangkat_id`),
  KEY `maintenance_user_id_foreign` (`user_id`),
  CONSTRAINT `maintenance_perangkat_id_foreign` FOREIGN KEY (`perangkat_id`) REFERENCES `perangkat` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintenance_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.maintenance: ~0 rows (approximately)

-- Dumping structure for table mini_simrs.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2024_01_01_000001_add_role_to_users_table', 1),
	(6, '2024_01_01_000002_create_ruangan_table', 1),
	(7, '2024_01_01_000003_create_perangkat_table', 1),
	(8, '2024_01_01_000004_create_maintenance_table', 1),
	(9, '2024_01_01_000005_create_peminjaman_table', 1);

-- Dumping structure for table mini_simrs.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table mini_simrs.peminjaman
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `perangkat_id` bigint unsigned NOT NULL,
  `nama_peminjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_kerja` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dipinjam',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjaman_perangkat_id_foreign` (`perangkat_id`),
  CONSTRAINT `peminjaman_perangkat_id_foreign` FOREIGN KEY (`perangkat_id`) REFERENCES `perangkat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.peminjaman: ~0 rows (approximately)

-- Dumping structure for table mini_simrs.perangkat
CREATE TABLE IF NOT EXISTS `perangkat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('pc','laptop','printer','monitor','server','network','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruangan_id` bigint unsigned NOT NULL,
  `kondisi` enum('baik','rusak_ringan','rusak_berat','tidak_aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `tanggal_pembelian` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `perangkat_serial_number_unique` (`serial_number`),
  KEY `perangkat_ruangan_id_foreign` (`ruangan_id`),
  CONSTRAINT `perangkat_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.perangkat: ~10 rows (approximately)
INSERT INTO `perangkat` (`id`, `nama`, `jenis`, `merk`, `serial_number`, `ruangan_id`, `kondisi`, `tanggal_pembelian`, `created_at`, `updated_at`) VALUES
	(1, 'PC Pendaftaran 01', 'pc', 'Lenovo ThinkCentre', 'LNV-PC-001', 7, 'baik', '2023-03-15', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(2, 'Laptop Dokter ICU', 'laptop', 'Dell Latitude 5540', 'DLL-LP-001', 1, 'baik', '2023-06-20', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(3, 'Printer Farmasi', 'printer', 'Epson L3210', 'EPS-PR-001', 4, 'baik', '2023-01-10', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(4, 'Monitor Radiologi PACS', 'monitor', 'LG 27UK850', 'LG-MN-001', 3, 'baik', '2022-11-05', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(5, 'Server Utama RS', 'server', 'HPE ProLiant DL380', 'HPE-SV-001', 6, 'baik', '2022-08-01', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(6, 'Switch Core Network', 'network', 'Cisco Catalyst 9300', 'CSC-NW-001', 6, 'baik', '2022-08-01', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(7, 'PC Laboratorium 01', 'pc', 'HP ProDesk 400', 'HP-PC-001', 5, 'rusak_ringan', '2023-02-20', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(8, 'Printer UGD', 'printer', 'Brother DCP-T720DW', 'BRO-PR-001', 2, 'baik', '2023-05-12', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(9, 'Laptop Admin Keuangan', 'laptop', 'ASUS ExpertBook', 'ASS-LP-001', 7, 'rusak_berat', '2021-09-30', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(10, 'Access Point UGD', 'network', 'Ubiquiti UniFi AP', 'UBQ-NW-001', 2, 'baik', '2023-04-18', '2026-05-24 22:17:44', '2026-05-24 22:17:44');

-- Dumping structure for table mini_simrs.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.personal_access_tokens: ~4 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'auth_token', '97230ff12045c2b45a69da943f85ee75d9977faa8da13f0f798c7616b6b1b4e0', '["*"]', NULL, NULL, '2026-05-24 22:25:02', '2026-05-24 22:25:02'),
	(2, 'App\\Models\\User', 4, 'auth_token', '1502db02de0e21920cdac3a1a72292eaedfb6fc65b7085bf642714f17d2fbe9c', '["*"]', NULL, NULL, '2026-05-24 22:48:29', '2026-05-24 22:48:29'),
	(4, 'App\\Models\\User', 2, 'auth_token', '8c148d9f1a769c26f1af9df74087edf2cf9a828ae5e1971d3979351077a65158', '["*"]', NULL, NULL, '2026-05-24 22:49:00', '2026-05-24 22:49:00'),
	(5, 'App\\Models\\User', 1, 'auth_token', '3d485547689323f7be58ed7f310eb0c6df7ea530f21351448d114e5782f6ef69', '["*"]', '2026-05-24 22:50:04', NULL, '2026-05-24 22:49:55', '2026-05-24 22:50:04');

-- Dumping structure for table mini_simrs.ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lantai` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.ruangan: ~7 rows (approximately)
INSERT INTO `ruangan` (`id`, `nama`, `lantai`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 'ICU', 2, 'Intensive Care Unit', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(2, 'UGD', 1, 'Unit Gawat Darurat', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(3, 'Radiologi', 1, 'Ruang pemeriksaan radiologi', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(4, 'Farmasi', 1, 'Bagian farmasi dan apotek', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(5, 'Laboratorium', 2, 'Lab pemeriksaan klinis', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(6, 'Ruang Server', 3, 'Data center rumah sakit', '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(7, 'Administrasi', 1, 'Ruang administrasi umum', '2026-05-24 22:17:44', '2026-05-24 22:17:44');

-- Dumping structure for table mini_simrs.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','teknisi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'teknisi',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mini_simrs.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin SIMRS', 'admin@simrs.test', NULL, '$2y$12$wUtjS6RfP71ZsNfRgAnMEuqgfyaGkeSvLA6Q1vVj7i8w.N1/t2N9O', 'admin', NULL, '2026-05-24 22:17:42', '2026-05-24 22:17:42'),
	(2, 'Teknisi Budi', 'budi@simrs.test', NULL, '$2y$12$28CxDzHWKqvDr/xkpSwfdeFRmxRdAqHr8HJEsZMy7mavsaC8aKibS', 'teknisi', NULL, '2026-05-24 22:17:43', '2026-05-24 22:17:43'),
	(3, 'Teknisi Andi', 'andi@simrs.test', NULL, '$2y$12$LJPI.iYue6.Zdk0yAmsUQ.G/v5TAMa.egUuK7oB6ds/V5lOxigVyi', 'teknisi', NULL, '2026-05-24 22:17:44', '2026-05-24 22:17:44'),
	(4, 'User Baru', 'userbaru@simrs.test', NULL, '$2y$12$AG0yOpmMVe40eVU7emKwneQjk1MRIkYODq1Bbvags1euvpieuP1zC', 'teknisi', NULL, '2026-05-24 22:48:29', '2026-05-24 22:48:29');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
