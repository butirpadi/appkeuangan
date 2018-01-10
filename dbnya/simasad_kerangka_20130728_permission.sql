-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.5.27 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- Dumping data for table simasad.permissions: ~16 rows (approximately)
DELETE FROM `permissions`;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'manage_user', 'Mengelola Data User (tambah,edit,hapus)', '2013-06-11 17:59:12', '2013-06-11 17:59:12'),
	(2, 'manage_user_group', 'Mengelola Data User Group (tambah,edit,hapus)', '2013-06-11 17:59:12', '2013-06-11 17:59:12'),
	(3, 'manage_tahun_ajaran', 'Mengelola Data Tahun Ajaran (tambah,edit,hapus)', '2013-06-11 17:59:12', '2013-06-11 17:59:12'),
	(5, 'manage_rombel', 'Mengelola Data Rombongan Belajar (tambah,edit,hapus)', '2013-06-11 18:01:05', '2013-06-11 18:01:06'),
	(6, 'manage_biaya', 'Mengelola Data Biaya (tambah,edit,hapus, dan pengaturan biaya)', '2013-06-11 18:01:29', '2013-06-11 18:01:29'),
	(7, 'manage_siswa', 'Mengelola Data Siswa (tambah,edit,hapus)', '2013-06-11 18:04:33', '2013-06-11 18:04:33'),
	(8, 'manage_transaksi_penerimaan_iuran', 'Mengelola Transaksi Penerimaan Iuran Siswa', '2013-06-11 18:04:33', '2013-06-11 18:04:34'),
	(9, 'manage_transaksi_penerimaan', 'Mengelola Transaksi Penerimaan', '2013-06-11 18:04:57', '2013-06-11 18:04:57'),
	(10, 'manage_transaksi_pengeluaran', 'Mengelola Transaksi Pengeluaran', '2013-06-11 18:05:09', '2013-06-11 18:05:10'),
	(11, 'manage_histori_transaksi', 'Mengelola Data Histori Transaksi', '2013-06-11 18:05:27', '2013-06-11 18:05:27'),
	(12, 'manage_rekapitulasi_transaksi', 'Mengelola Data Rekapitulasi Transaksi', '2013-06-11 18:05:57', '2013-06-11 18:05:57'),
	(13, 'manage_rekapitulasi_iuran', 'Mengelola Data Rekapitulasi Iuran Per Tahun Ajaran', '2013-06-11 18:06:20', '2013-06-11 18:06:20'),
	(14, 'manage_system_setting', 'Mengelola Data System Setting', '2013-06-11 19:29:08', '2013-06-11 19:29:09'),
	(15, 'manage_rekapitulasi_tahunan', 'Mengelola Data Rekapitulasi Keuangan Tahunan', '2013-06-26 05:41:33', '2013-06-26 05:41:33'),
	(16, 'manage_rekapitulasi_bulanan', 'Mengelola Data Rekapitulasi Iuran Bulanan', '2013-07-18 06:31:23', '2013-07-18 06:31:24'),
	(17, 'manage_beasiswa', 'Mengelola Beasiswa & Bantuan Biaya Pendidikan', '2013-07-28 21:52:56', '2013-07-28 21:52:56'),
	(18, 'manage_target_pencapaian', 'Mengelola Nilai Target Pencapaian Pendapatan per Bulan', '2013-07-28 21:52:56', '2013-07-28 21:52:56'),
	(19, 'manage_kenaikan_siswa', 'Mengelola Proses Kenaikan Siswa', '2013-07-28 22:32:28', '2013-07-28 22:32:28');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping data for table simasad.permission_role: ~31 rows (approximately)
DELETE FROM `permission_role`;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(12, 1, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(13, 2, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(14, 3, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(16, 5, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(17, 6, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(18, 7, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(19, 8, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(20, 9, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(21, 10, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(22, 11, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(23, 12, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(24, 13, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(30, 3, 4, '2013-06-11 19:09:43', '2013-06-11 19:09:43'),
	(32, 5, 4, '2013-06-11 19:09:43', '2013-06-11 19:09:43'),
	(33, 6, 4, '2013-06-11 19:09:43', '2013-06-11 19:09:43'),
	(34, 7, 4, '2013-06-11 19:09:43', '2013-06-11 19:09:43'),
	(35, 8, 4, '2013-06-11 19:09:44', '2013-06-11 19:09:44'),
	(36, 9, 4, '2013-06-11 19:09:44', '2013-06-11 19:09:44'),
	(37, 10, 4, '2013-06-11 19:09:44', '2013-06-11 19:09:44'),
	(38, 11, 4, '2013-06-11 19:09:44', '2013-06-11 19:09:44'),
	(39, 12, 4, '2013-06-11 19:09:44', '2013-06-11 19:09:44'),
	(40, 13, 4, '2013-06-11 19:09:44', '2013-06-11 19:09:44'),
	(41, 8, 5, '2013-06-11 19:09:59', '2013-06-11 19:09:59'),
	(42, 9, 5, '2013-06-11 19:09:59', '2013-06-11 19:09:59'),
	(44, 14, 1, '2013-06-26 05:41:57', '2013-06-26 05:41:57'),
	(46, 15, 4, '2013-06-26 05:42:07', '2013-06-26 05:42:07'),
	(48, 15, 1, '2013-07-18 06:30:53', '2013-07-18 06:30:53'),
	(49, 16, 1, '2013-07-18 06:31:39', '2013-07-18 06:31:39'),
	(50, 16, 4, '2013-07-18 06:32:13', '2013-07-18 06:32:13'),
	(51, 17, 1, '2013-07-26 13:40:05', '2013-07-26 13:40:05'),
	(52, 17, 4, '2013-07-26 13:40:34', '2013-07-26 13:40:34'),
	(53, 18, 4, '2013-07-28 22:03:28', '2013-07-28 22:03:28'),
	(54, 19, 4, '2013-07-28 22:39:07', '2013-07-28 22:39:07'),
	(55, 18, 1, '2013-07-28 22:39:12', '2013-07-28 22:39:12'),
	(56, 19, 1, '2013-07-28 22:39:12', '2013-07-28 22:39:12');
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;

-- Dumping data for table simasad.roles: ~3 rows (approximately)
DELETE FROM `roles`;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `description`, `level`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', NULL, 10, '2013-06-11 17:07:25', '2013-06-11 17:07:25'),
	(4, 'Bagian Keuangan', NULL, 5, '2013-06-11 19:09:43', '2013-06-11 19:09:43'),
	(5, 'Kasir', NULL, 2, '2013-06-11 19:09:59', '2013-06-11 19:09:59');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping data for table simasad.role_user: ~3 rows (approximately)
DELETE FROM `role_user`;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2013-06-12 08:44:17', '2013-06-12 08:44:17'),
	(2, 2, 1, '2013-06-12 08:47:50', '2013-06-12 08:47:50'),
	(6, 6, 4, '2013-07-05 10:32:36', '2013-07-05 10:32:36'),
	(8, 7, 1, '2013-07-28 22:13:40', '2013-07-28 22:13:40');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;

-- Dumping data for table simasad.users: ~3 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `verified`, `disabled`, `deleted`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'eries', '$2a$08$bcRj9c3qXX8psBEp9PpNtemSVQOfOlgQwmMTm2d9XLO/WNI/zgUxC', 'c9f169ae899b5f1f2d0f9277d639698b', 'eries@simas.ad', 1, 0, 0, '', '2013-06-12 08:44:01', '2013-06-12 08:46:34'),
	(2, 'admin', '$2a$08$Afz2r1HFDMA8cSoo6GwkCOlAQSHGMMNdO31aDenx10iUfKiANITHO', '8ba5d18b4cd2b70626a912a775f94658', 'admin@simas.ad', 1, 0, 0, 'Administrator', '2013-06-12 08:47:50', '2013-06-26 09:47:04'),
	(6, 'queen', '$2a$08$WnBzM1pjMFlxZGxweXhiSeH4N6Is5p1sX4MmVofEqBugo8GbbHEXK', 'c102976addb71ccf4de3e555402cdf61', 'queen@simas.ad', 1, 0, 0, 'Ayu Candra', '2013-07-05 10:32:35', '2013-07-05 12:56:16'),
	(7, 'herman', '$2a$08$/KSErl6arieKzYxFodIzAOfj9tASZWILW6LhBqxUk6EpMprQzMco6', '289d84af82b1f25ea15f34d038398833', 'herman@simas.ad', 1, 0, 0, 'hermanto', '2013-07-28 22:09:23', '2013-07-28 22:09:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
