-- --------------------------------------------------------
-- Host                          :localhost
-- Server version                :5.5.27 - MySQL Community Server (GPL)
-- Server OS                     :Win32
-- HeidiSQL Version              :7.0.0.4304
-- Created                       :2013-07-02 19:26:39
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for simasad
DROP DATABASE IF EXISTS `simasad`;
CREATE DATABASE IF NOT EXISTS `simasad` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `simasad`;


-- Dumping structure for table simasad.activator
DROP TABLE IF EXISTS `activator`;
CREATE TABLE IF NOT EXISTS `activator` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `lunas` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.activator: ~1 rows (approximately)
/*!40000 ALTER TABLE `activator` DISABLE KEYS */;
INSERT INTO `activator` (`id`, `created_at`, `updated_at`, `tanggal`, `lunas`) VALUES
	(3, '2013-06-16 09:59:52', '2013-07-02 15:30:42', '2013-07-09', 'N');
/*!40000 ALTER TABLE `activator` ENABLE KEYS */;


-- Dumping structure for table simasad.appsetting
DROP TABLE IF EXISTS `appsetting`;
CREATE TABLE IF NOT EXISTS `appsetting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `biaya_id` int(11) DEFAULT NULL COMMENT 'biaya id yang di guanakan di One click biaya',
  `mysqldumppath` varchar(150) DEFAULT NULL,
  `cetaknota` enum('Y','N') DEFAULT NULL,
  `printeraddr` varchar(50) DEFAULT NULL,
  `lunas` enum('Y','N') DEFAULT 'N',
  `linekertas` int(11) DEFAULT NULL,
  `spaceprinter` int(11) DEFAULT NULL,
  `charcount` int(11) DEFAULT NULL,
  `sn_key` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_appsetting_biaya` (`biaya_id`),
  CONSTRAINT `FK_appsetting_biaya` FOREIGN KEY (`biaya_id`) REFERENCES `jenisbiaya` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.appsetting: ~1 rows (approximately)
/*!40000 ALTER TABLE `appsetting` DISABLE KEYS */;
INSERT INTO `appsetting` (`id`, `created_at`, `updated_at`, `biaya_id`, `mysqldumppath`, `cetaknota`, `printeraddr`, `lunas`, `linekertas`, `spaceprinter`, `charcount`, `sn_key`) VALUES
	(1, '2013-05-31 10:03:45', '2013-07-02 16:15:47', 1, 'C:\\xampp\\mysql\\bin\\', 'Y', '//192.168.0.2/epson_lx_800', 'N', 30, 14, 56, 'Tk-Qt-Z3-Qt-Tl-Ut-SX-Qt-TX-ot-a3-Qt-TV-Ut-TX-Qt-Uk-Qt-VX-Qt-T0-Ut-RT-0=');
/*!40000 ALTER TABLE `appsetting` ENABLE KEYS */;


-- Dumping structure for table simasad.bulan
DROP TABLE IF EXISTS `bulan`;
CREATE TABLE IF NOT EXISTS `bulan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `angka` int(11) DEFAULT NULL,
  `posisi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.bulan: ~12 rows (approximately)
/*!40000 ALTER TABLE `bulan` DISABLE KEYS */;
INSERT INTO `bulan` (`id`, `created_at`, `updated_at`, `nama`, `angka`, `posisi`) VALUES
	(1, '2013-05-09 17:09:28', '2013-05-11 02:42:00', 'januari', 1, 7),
	(2, '2013-05-09 17:09:38', '2013-05-11 02:42:01', 'februari', 2, 8),
	(3, '2013-05-09 17:09:53', '2013-05-11 02:42:03', 'maret', 3, 9),
	(4, '2013-05-09 17:10:00', '2013-05-11 02:42:05', 'april', 4, 10),
	(5, '2013-05-09 17:10:06', '2013-05-11 02:42:07', 'mei', 5, 11),
	(6, '2013-05-09 17:10:11', '2013-05-11 02:42:07', 'juni', 6, 12),
	(7, '2013-05-09 17:10:16', '2013-05-11 02:41:50', 'juli', 7, 1),
	(8, '2013-05-09 17:10:21', '2013-05-11 02:41:52', 'agustus', 8, 2),
	(9, '2013-05-09 17:10:28', '2013-05-11 02:41:54', 'september', 9, 3),
	(10, '2013-05-09 17:10:33', '2013-05-11 02:41:55', 'oktober', 10, 4),
	(11, '2013-05-09 17:10:40', '2013-05-11 02:41:57', 'november', 11, 5),
	(12, '2013-05-09 17:10:47', '2013-05-11 02:41:58', 'desember', 12, 6);
/*!40000 ALTER TABLE `bulan` ENABLE KEYS */;


-- Dumping structure for table simasad.detiltransmasuk
DROP TABLE IF EXISTS `detiltransmasuk`;
CREATE TABLE IF NOT EXISTS `detiltransmasuk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `transmasuk_id` int(10) DEFAULT NULL,
  `jenisbiaya_id` int(10) DEFAULT NULL,
  `bulan_id` int(10) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL,
  `ket` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_detiltransmasuk_transmasuk` (`transmasuk_id`),
  KEY `FK_detiltransmasuk_jenisbiaya` (`jenisbiaya_id`),
  KEY `FK_detiltransmasuk_bulan` (`bulan_id`),
  CONSTRAINT `FK_detiltransmasuk_bulan` FOREIGN KEY (`bulan_id`) REFERENCES `bulan` (`id`),
  CONSTRAINT `FK_detiltransmasuk_jenisbiaya` FOREIGN KEY (`jenisbiaya_id`) REFERENCES `jenisbiaya` (`id`),
  CONSTRAINT `FK_detiltransmasuk_transmasuk` FOREIGN KEY (`transmasuk_id`) REFERENCES `transmasuk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.detiltransmasuk: ~0 rows (approximately)
/*!40000 ALTER TABLE `detiltransmasuk` DISABLE KEYS */;
/*!40000 ALTER TABLE `detiltransmasuk` ENABLE KEYS */;


-- Dumping structure for table simasad.jenisbiaya
DROP TABLE IF EXISTS `jenisbiaya`;
CREATE TABLE IF NOT EXISTS `jenisbiaya` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(60) DEFAULT NULL,
  `perjenjang` enum('Y','N') DEFAULT 'N',
  `tipe` enum('ITB','ITC','BBBI','BTBI') DEFAULT NULL COMMENT 'ITB : Iuran Tetap Bulanan, ITC:Iuran Tetap Cicilan, BBBI : Biaya bebas bukan iuran, BTBI: Biaya Tetap Bukan Iuran',
  `arus` enum('M','K') DEFAULT 'M',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.jenisbiaya: ~5 rows (approximately)
/*!40000 ALTER TABLE `jenisbiaya` DISABLE KEYS */;
INSERT INTO `jenisbiaya` (`id`, `created_at`, `updated_at`, `nama`, `perjenjang`, `tipe`, `arus`) VALUES
	(1, '2013-05-20 21:39:03', '2013-05-20 21:39:03', 'SPP', 'Y', 'ITB', 'M'),
	(2, '2013-05-20 21:42:25', '2013-05-20 21:42:25', 'Pendaftaran Siswa Baru', 'N', 'BTBI', 'M'),
	(3, '2013-05-20 21:42:39', '2013-05-20 21:42:39', 'Pengadaan Peralatan Sekolah', 'N', 'BBBI', 'K'),
	(4, '2013-05-20 21:42:54', '2013-05-20 21:42:54', 'LKS', 'Y', 'ITC', 'M'),
	(6, '2013-05-26 08:53:02', '2013-05-26 08:53:02', 'Modal', 'N', 'BBBI', 'M');
/*!40000 ALTER TABLE `jenisbiaya` ENABLE KEYS */;


-- Dumping structure for table simasad.ketentuanbiaya
DROP TABLE IF EXISTS `ketentuanbiaya`;
CREATE TABLE IF NOT EXISTS `ketentuanbiaya` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tahunajaran_id` int(10) DEFAULT NULL,
  `jenisbiaya_id` int(10) DEFAULT NULL,
  `jenjang` enum('1','2','3','4','5','6') DEFAULT NULL,
  `jumlah` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK__tahunajaran` (`tahunajaran_id`),
  KEY `FK__jenisbiaya` (`jenisbiaya_id`),
  CONSTRAINT `FK__jenisbiaya` FOREIGN KEY (`jenisbiaya_id`) REFERENCES `jenisbiaya` (`id`),
  CONSTRAINT `FK__tahunajaran` FOREIGN KEY (`tahunajaran_id`) REFERENCES `tahunajaran` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.ketentuanbiaya: ~13 rows (approximately)
/*!40000 ALTER TABLE `ketentuanbiaya` DISABLE KEYS */;
INSERT INTO `ketentuanbiaya` (`id`, `created_at`, `updated_at`, `tahunajaran_id`, `jenisbiaya_id`, `jenjang`, `jumlah`) VALUES
	(1, '2013-06-10 07:03:32', '2013-06-10 07:03:32', 4, 1, '1', 100000),
	(2, '2013-06-10 07:03:32', '2013-06-10 07:03:32', 4, 1, '2', 110000),
	(3, '2013-06-10 07:03:32', '2013-06-10 07:03:32', 4, 1, '3', 120000),
	(4, '2013-06-10 07:03:32', '2013-06-10 07:03:32', 4, 1, '4', 130000),
	(5, '2013-06-10 07:03:32', '2013-06-10 07:03:32', 4, 1, '5', 140000),
	(6, '2013-06-10 07:03:32', '2013-06-10 07:03:32', 4, 1, '6', 150000),
	(7, '2013-06-10 07:04:05', '2013-06-10 07:04:05', 4, 4, '1', 200000),
	(8, '2013-06-10 07:04:05', '2013-06-10 07:04:05', 4, 4, '2', 210000),
	(9, '2013-06-10 07:04:05', '2013-06-10 07:04:05', 4, 4, '3', 220000),
	(10, '2013-06-10 07:04:05', '2013-06-10 07:04:05', 4, 4, '4', 230000),
	(11, '2013-06-10 07:04:05', '2013-06-10 07:04:05', 4, 4, '5', 240000),
	(12, '2013-06-10 07:04:05', '2013-06-10 07:04:05', 4, 4, '6', 250000),
	(13, '2013-06-10 07:15:35', '2013-06-10 07:15:35', 4, 2, NULL, 200000);
/*!40000 ALTER TABLE `ketentuanbiaya` ENABLE KEYS */;


-- Dumping structure for table simasad.laravel_migrations
DROP TABLE IF EXISTS `laravel_migrations`;
CREATE TABLE IF NOT EXISTS `laravel_migrations` (
  `bundle` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`bundle`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.laravel_migrations: ~5 rows (approximately)
/*!40000 ALTER TABLE `laravel_migrations` DISABLE KEYS */;
INSERT INTO `laravel_migrations` (`bundle`, `name`, `batch`) VALUES
	('sentry', '2012_08_03_162320_install', 1),
	('sentry', '2012_08_15_001334_database_rules', 1),
	('sentry', '2012_10_08_000000_users_nullable', 1),
	('verify', '2012_06_17_211339_init', 2),
	('verify', '2013_02_24_094926_user_roles_one_to_many', 2);
/*!40000 ALTER TABLE `laravel_migrations` ENABLE KEYS */;


-- Dumping structure for table simasad.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.permissions: ~15 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'manage_user', 'Mengelola Data User (tambah,edit,hapus)', '2013-06-11 17:59:12', '2013-06-11 17:59:12'),
	(2, 'manage_user_group', 'Mengelola Data User Group (tambah,edit,hapus)', '2013-06-11 17:59:12', '2013-06-11 17:59:12'),
	(3, 'manage_tahun_ajaran', 'Mengelola Data Tahun Ajaran (tambah,edit,hapus)', '2013-06-11 17:59:12', '2013-06-11 17:59:12'),
	(4, 'manage_bulan', 'Mengelola Data Urutan Bulan (tambah,edit,hapus)', '2013-06-11 18:00:33', '2013-06-11 18:00:33'),
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
	(15, 'manage_rekapitulasi_tahunan', 'Mengelola Data Rekapitulasi Keuangan Tahunan', '2013-06-26 05:41:33', '2013-06-26 05:41:33');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;


-- Dumping structure for table simasad.permission_role
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.permission_role: ~29 rows (approximately)
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(12, 1, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(13, 2, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(14, 3, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
	(15, 4, 1, '2013-06-11 18:19:22', '2013-06-11 18:19:22'),
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
	(31, 4, 4, '2013-06-11 19:09:43', '2013-06-11 19:09:43'),
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
	(45, 15, 1, '2013-06-26 05:41:57', '2013-06-26 05:41:57'),
	(46, 15, 4, '2013-06-26 05:42:07', '2013-06-26 05:42:07');
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;


-- Dumping structure for table simasad.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.roles: ~3 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `description`, `level`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', NULL, 10, '2013-06-11 17:07:25', '2013-06-11 17:07:25'),
	(4, 'Bagian Keuangan', NULL, 0, '2013-06-11 19:09:43', '2013-06-11 19:09:43'),
	(5, 'Kasir', NULL, 0, '2013-06-11 19:09:59', '2013-06-11 19:09:59');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- Dumping structure for table simasad.role_user
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_index` (`user_id`),
  KEY `role_user_role_id_index` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.role_user: ~4 rows (approximately)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2013-06-12 08:44:17', '2013-06-12 08:44:17'),
	(2, 2, 1, '2013-06-12 08:47:50', '2013-06-12 08:47:50'),
	(3, 3, 4, '2013-06-12 08:49:05', '2013-06-12 08:49:05'),
	(5, 5, 5, '2013-06-26 17:10:14', '2013-06-26 17:10:14');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;


-- Dumping structure for table simasad.rombel
DROP TABLE IF EXISTS `rombel`;
CREATE TABLE IF NOT EXISTS `rombel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenjang` enum('1','2','3','4','5','6','0') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.rombel: ~13 rows (approximately)
/*!40000 ALTER TABLE `rombel` DISABLE KEYS */;
INSERT INTO `rombel` (`id`, `created_at`, `updated_at`, `nama`, `jenjang`) VALUES
	(1, '2013-05-10 02:37:42', '2013-05-14 23:54:29', 'I - RA Kartini', '1'),
	(2, '2013-05-10 02:37:56', '2013-05-14 23:59:48', 'I - Cut Nya`Din', '1'),
	(3, '2013-05-10 02:38:01', '2013-05-15 00:00:30', 'II - Hasanudin', '2'),
	(4, '2013-05-10 02:38:09', '2013-05-15 00:05:25', 'II - Wachid Hasyim', '2'),
	(5, '2013-05-10 02:38:13', '2013-05-15 00:00:52', 'III - Imam Bonjol', '3'),
	(6, '2013-05-10 02:38:19', '2013-05-10 02:38:19', 'III - Ki Hajar Dewantara', '3'),
	(7, '2013-05-10 02:38:25', '2013-05-15 00:05:42', 'IV - Pangeran Diponegoro', '4'),
	(8, '2013-05-10 02:38:31', '2013-05-15 00:06:27', 'IV - Teuku Umar', '4'),
	(9, '2013-05-10 02:39:10', '2013-05-15 00:06:38', 'V - Ahmad Yani', '5'),
	(10, '2013-05-10 02:39:19', '2013-05-10 02:39:19', 'V - Dr Sutomo', '5'),
	(11, '2013-05-10 02:39:25', '2013-05-10 02:39:25', 'VI - Jendral Sudirman', '6'),
	(12, '2013-05-10 02:39:31', '2013-05-10 02:39:31', 'VI - Yos Sudarso', '6'),
	(13, '2013-05-11 09:47:50', '2013-06-03 07:00:15', 'Lulus', '0');
/*!40000 ALTER TABLE `rombel` ENABLE KEYS */;


-- Dumping structure for table simasad.rombelsiswa
DROP TABLE IF EXISTS `rombelsiswa`;
CREATE TABLE IF NOT EXISTS `rombelsiswa` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tahunajaran_id` int(10) DEFAULT NULL,
  `rombel_id` int(10) DEFAULT NULL,
  `siswa_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rombelsiswa_tahunajaran` (`tahunajaran_id`),
  KEY `FK_rombelsiswa_rombel` (`rombel_id`),
  KEY `FK_rombelsiswa_siswa` (`siswa_id`),
  CONSTRAINT `FK_rombelsiswa_rombel` FOREIGN KEY (`rombel_id`) REFERENCES `rombel` (`id`),
  CONSTRAINT `FK_rombelsiswa_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`),
  CONSTRAINT `FK_rombelsiswa_tahunajaran` FOREIGN KEY (`tahunajaran_id`) REFERENCES `tahunajaran` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.rombelsiswa: ~53 rows (approximately)
/*!40000 ALTER TABLE `rombelsiswa` DISABLE KEYS */;
INSERT INTO `rombelsiswa` (`id`, `created_at`, `updated_at`, `tahunajaran_id`, `rombel_id`, `siswa_id`) VALUES
	(1, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 1),
	(2, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 2),
	(3, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 3),
	(4, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 4),
	(5, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 5),
	(6, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 6),
	(7, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 7),
	(8, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 8),
	(9, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 9),
	(10, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 1, 10),
	(11, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 11),
	(12, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 12),
	(13, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 13),
	(14, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 14),
	(15, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 15),
	(16, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 16),
	(17, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 17),
	(18, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 18),
	(19, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 19),
	(20, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 2, 20),
	(21, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 21),
	(22, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 22),
	(23, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 23),
	(24, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 24),
	(25, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 25),
	(26, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 26),
	(27, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 27),
	(28, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 28),
	(29, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 29),
	(30, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 3, 30),
	(31, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 31),
	(32, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 32),
	(33, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 33),
	(34, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 34),
	(35, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 35),
	(36, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 36),
	(37, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 37),
	(38, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 38),
	(39, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 39),
	(40, '2013-06-05 14:06:33', '2013-06-05 14:06:33', 4, 4, 40),
	(64, '2013-06-05 17:01:22', '2013-06-05 17:01:22', 4, 5, 42),
	(65, '2013-06-05 17:02:51', '2013-06-05 17:02:51', 4, 5, 43),
	(66, '2013-06-05 17:03:08', '2013-06-05 17:03:08', 4, 5, 44),
	(67, '2013-06-05 17:03:30', '2013-06-05 17:03:30', 4, 5, 45),
	(68, '2013-06-05 17:03:48', '2013-06-05 17:03:48', 4, 5, 46),
	(69, '2013-06-05 18:22:28', '2013-06-05 18:22:28', 4, 5, 47),
	(70, '2013-06-05 18:23:54', '2013-06-05 18:23:54', 4, 5, 48),
	(71, '2013-06-05 18:24:22', '2013-06-05 18:24:22', 4, 5, 49),
	(72, '2013-06-05 18:24:44', '2013-06-05 18:24:44', 4, 5, 50),
	(73, '2013-06-05 18:25:26', '2013-06-05 18:25:26', 4, 5, 51),
	(74, '2013-06-05 18:25:38', '2013-06-05 18:25:38', 4, 5, 52),
	(75, '2013-06-05 18:25:53', '2013-06-05 18:25:53', 4, 5, 53),
	(76, '2013-06-05 18:26:07', '2013-06-05 18:26:07', 4, 5, 54);
/*!40000 ALTER TABLE `rombelsiswa` ENABLE KEYS */;


-- Dumping structure for table simasad.setting
DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama_skul` varchar(150) DEFAULT NULL,
  `alamat_skul` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.setting: ~1 rows (approximately)
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` (`id`, `created_at`, `updated_at`, `nama_skul`, `alamat_skul`) VALUES
	(1, '2013-05-28 06:26:42', '2013-05-28 06:26:44', 'SEKOLAH DASAR ISLAM SABILIL HUDA', 'Jl. Singokarso 54 Sumorame Candi Sidoarjo 61271 Telp. 031-8061169');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;


-- Dumping structure for table simasad.siswa
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nisn` varchar(10) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.siswa: ~53 rows (approximately)
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
INSERT INTO `siswa` (`id`, `created_at`, `updated_at`, `nisn`, `nama`) VALUES
	(1, '2013-05-10 23:26:01', '2013-05-10 23:48:58', '2565', 'Aqilla Qanza Habibi'),
	(2, '2013-05-10 23:26:23', '2013-05-10 23:26:23', '2567', 'Afia Najah Abdullah Hafizah'),
	(3, '2013-05-10 23:26:34', '2013-05-10 23:26:34', '2568', 'Ahmad Hanbal'),
	(4, '2013-05-10 23:27:42', '2013-05-10 23:27:42', '2569', 'Muhammad Maulana Mailk Ibrahim'),
	(5, '2013-05-10 23:27:56', '2013-05-10 23:27:56', '2570', 'Falihah Farannisa'),
	(6, '2013-05-10 23:28:09', '2013-05-10 23:28:09', '2571', 'Muhammad Sultan Al Fatih'),
	(7, '2013-05-10 23:28:30', '2013-05-10 23:28:30', '2572', 'Awila Najah'),
	(8, '2013-05-10 23:28:47', '2013-05-10 23:28:47', '2573', 'Farhad Aschibly'),
	(9, '2013-05-10 23:31:32', '2013-05-10 23:31:32', '2574', 'Afia Naila Arkarna'),
	(10, '2013-05-10 23:31:45', '2013-05-10 23:31:45', '2575', 'Ismed Bahasuan'),
	(11, '2013-05-10 23:32:09', '2013-05-10 23:32:09', '2576', 'Aina Talita Zahran'),
	(12, '2013-05-10 23:32:31', '2013-05-10 23:32:31', '2577', 'Abu Bakar Al Habsy'),
	(13, '2013-05-10 23:32:45', '2013-05-10 23:32:45', '2578', 'Ainiya Faida Azmi'),
	(14, '2013-05-10 23:32:56', '2013-05-10 23:32:56', '2579', 'Ahmad Husein Assegaf'),
	(15, '2013-05-10 23:33:17', '2013-05-10 23:33:17', '2580', 'Akifa Naila'),
	(16, '2013-05-10 23:33:28', '2013-05-10 23:33:28', '2581', 'Muhammad Zein AL Athas'),
	(17, '2013-05-10 23:33:50', '2013-05-10 23:33:50', '2582', 'Annisa Faiha'),
	(18, '2013-05-10 23:34:06', '2013-05-10 23:34:06', '2583', 'Saad Amirullah'),
	(19, '2013-05-10 23:34:24', '2013-05-10 23:34:24', '2584', 'Muhammad Shalahudin Yusuf Al Ayyubi'),
	(20, '2013-05-10 23:34:53', '2013-05-10 23:34:53', '2585', 'Andi Ainurrahman'),
	(21, '2013-05-10 23:35:16', '2013-05-10 23:35:16', '2586', 'Rahmat Kukuh Rahardiansyah'),
	(22, '2013-05-10 23:35:29', '2013-05-10 23:35:29', '2587', 'Muhammad Saad'),
	(23, '2013-05-10 23:35:41', '2013-05-10 23:35:41', '2588', 'Putra Abric Susanto'),
	(24, '2013-05-10 23:35:53', '2013-05-10 23:35:53', '2589', 'Bima Putra Narendra'),
	(25, '2013-05-10 23:36:12', '2013-05-10 23:36:12', '2590', 'Adista Novendra Robi'),
	(26, '2013-05-10 23:36:39', '2013-05-10 23:36:39', '2591', 'Tri Nur Dianingsih'),
	(27, '2013-05-10 23:36:54', '2013-05-10 23:36:54', '2592', 'Muhmmad Nasichul Amin'),
	(28, '2013-05-10 23:37:15', '2013-05-10 23:37:15', '2593', 'Yopie Indra Kurnia'),
	(29, '2013-05-10 23:37:29', '2013-05-10 23:37:29', '2594', 'Fadhil Al Kadri'),
	(30, '2013-05-10 23:37:49', '2013-05-10 23:37:49', '2595', 'Dimas Satya Wardhana'),
	(31, '2013-05-10 23:38:16', '2013-05-10 23:38:16', '2596', 'Rangga Budi Utomo'),
	(32, '2013-05-10 23:38:43', '2013-05-10 23:38:43', '2597', 'Selvi Widya'),
	(33, '2013-05-10 23:38:55', '2013-05-10 23:38:55', '2598', 'Ratna Dwi Suhendra'),
	(34, '2013-05-10 23:39:26', '2013-05-10 23:39:26', '2599', 'Baiyah Uswatun Chasanah'),
	(35, '2013-05-10 23:39:50', '2013-05-10 23:39:50', '2600', 'Sulaiman Rosyid'),
	(36, '2013-05-10 23:40:00', '2013-05-10 23:40:00', '2601', 'Rafid Ibnu Shina'),
	(37, '2013-05-10 23:40:24', '2013-05-10 23:40:24', '2602', 'Catur Prasetyawan'),
	(38, '2013-05-10 23:40:31', '2013-05-10 23:40:31', '2603', 'Achmad Bagus'),
	(39, '2013-05-10 23:40:47', '2013-05-10 23:40:47', '2604', 'Annuril Maulida'),
	(40, '2013-05-10 23:49:56', '2013-05-10 23:49:56', '2605', 'Agustin Wanda Sari'),
	(42, '2013-06-05 17:01:22', '2013-06-05 17:01:22', '2606', 'SYEELA AYU PRAMATA RATRI'),
	(43, '2013-06-05 17:02:51', '2013-06-05 17:02:51', '2607', 'ARFAN JAROQIM'),
	(44, '2013-06-05 17:03:08', '2013-06-05 17:03:08', '2608', 'MONITA DEVI RESTIANA'),
	(45, '2013-06-05 17:03:30', '2013-06-05 17:03:30', '2609', 'MEI PRESILIA'),
	(46, '2013-06-05 17:03:48', '2013-06-05 17:03:48', '2610', 'RIZA RINDARANI'),
	(47, '2013-06-05 18:22:28', '2013-06-05 18:22:28', '2611', 'ANITA NANDA KUSUMA DEWI'),
	(48, '2013-06-05 18:23:54', '2013-06-05 18:23:54', '2612', 'MOCHAMAD ARIFIN'),
	(49, '2013-06-05 18:24:22', '2013-06-05 18:24:22', '2613', 'RENI AGUSTINA'),
	(50, '2013-06-05 18:24:44', '2013-06-05 18:24:44', '2614', 'AGUSTIN LISTIANA'),
	(51, '2013-06-05 18:25:25', '2013-06-05 18:25:25', '2615', 'AYU KRISTIANA'),
	(52, '2013-06-05 18:25:38', '2013-06-05 18:25:38', '2616', 'YESSY WULANDARI'),
	(53, '2013-06-05 18:25:53', '2013-06-05 18:25:53', '2617', 'HUSNI ASKARO'),
	(54, '2013-06-05 18:26:07', '2013-06-05 18:26:07', '2618', 'ISRO’ATUL LAILIAH');
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;


-- Dumping structure for table simasad.tahunajaran
DROP TABLE IF EXISTS `tahunajaran`;
CREATE TABLE IF NOT EXISTS `tahunajaran` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT 'N',
  `posisi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.tahunajaran: ~5 rows (approximately)
/*!40000 ALTER TABLE `tahunajaran` DISABLE KEYS */;
INSERT INTO `tahunajaran` (`id`, `created_at`, `updated_at`, `nama`, `aktif`, `posisi`) VALUES
	(1, '2013-05-10 02:35:25', '2013-05-16 10:15:37', '2010 / 2011', 'N', 1),
	(2, '2013-05-10 02:35:29', '2013-06-05 13:29:47', '2011 / 2012', 'N', 2),
	(3, '2013-05-10 02:35:34', '2013-06-05 13:29:49', '2012 / 2013', 'N', 3),
	(4, '2013-05-10 02:35:37', '2013-06-05 13:29:49', '2013 / 2014', 'Y', 4),
	(5, '2013-06-06 08:00:14', '2013-06-06 08:00:14', '2014 - 2015', 'N', 5);
/*!40000 ALTER TABLE `tahunajaran` ENABLE KEYS */;


-- Dumping structure for table simasad.target_pencapaian
DROP TABLE IF EXISTS `target_pencapaian`;
CREATE TABLE IF NOT EXISTS `target_pencapaian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tahunajaran_id` int(10) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.target_pencapaian: ~5 rows (approximately)
/*!40000 ALTER TABLE `target_pencapaian` DISABLE KEYS */;
INSERT INTO `target_pencapaian` (`id`, `created_at`, `updated_at`, `tahunajaran_id`, `jumlah`) VALUES
	(1, '2013-06-28 07:03:56', '2013-06-28 07:04:29', 1, 80000000),
	(2, '2013-06-28 07:03:58', '2013-06-28 07:03:58', 2, 100000000),
	(3, '2013-06-28 07:04:00', '2013-06-28 07:04:00', 3, 110000000),
	(4, '2013-06-28 07:04:01', '2013-06-28 10:26:12', 4, 100000000),
	(5, '2013-06-28 07:04:03', '2013-06-28 07:04:03', 5, 125000000);
/*!40000 ALTER TABLE `target_pencapaian` ENABLE KEYS */;


-- Dumping structure for table simasad.transmasuk
DROP TABLE IF EXISTS `transmasuk`;
CREATE TABLE IF NOT EXISTS `transmasuk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tahunajaran_id` int(10) DEFAULT NULL,
  `siswa_id` int(10) DEFAULT NULL,
  `arus` enum('M','K') DEFAULT 'M',
  PRIMARY KEY (`id`),
  KEY `FK_transmasuk_tahunajaran` (`tahunajaran_id`),
  KEY `FK_transmasuk_siswa` (`siswa_id`),
  CONSTRAINT `FK_transmasuk_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`),
  CONSTRAINT `FK_transmasuk_tahunajaran` FOREIGN KEY (`tahunajaran_id`) REFERENCES `tahunajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.transmasuk: ~0 rows (approximately)
/*!40000 ALTER TABLE `transmasuk` DISABLE KEYS */;
/*!40000 ALTER TABLE `transmasuk` ENABLE KEYS */;


-- Dumping structure for table simasad.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_username_index` (`username`),
  KEY `users_password_index` (`password`),
  KEY `users_email_index` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table simasad.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `verified`, `disabled`, `deleted`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'eries', '$2a$08$bcRj9c3qXX8psBEp9PpNtemSVQOfOlgQwmMTm2d9XLO/WNI/zgUxC', 'c9f169ae899b5f1f2d0f9277d639698b', 'eries@simas.ad', 1, 0, 0, '', '2013-06-12 08:44:01', '2013-06-12 08:46:34'),
	(2, 'admin', '$2a$08$Afz2r1HFDMA8cSoo6GwkCOlAQSHGMMNdO31aDenx10iUfKiANITHO', '8ba5d18b4cd2b70626a912a775f94658', 'admin@simas.ad', 1, 0, 0, 'Administrator', '2013-06-12 08:47:50', '2013-06-26 09:47:04'),
	(3, 'herman', '$2a$08$L5SjKTK.9uukZPhRd6uWAubwpBGkuIuLVVwRE6eQK/1nvvTYaJlKa', '76651a8c50b44b4c7c727a165ecc90b8', 'herman@simas.ad', 1, 0, 0, 'Arif Herman', '2013-06-12 08:49:05', '2013-06-26 09:47:11'),
	(5, 'akbar', '$2a$08$RDBFaVEwRFZ4YzhVaGJxV.QE7W.I0Mu1TPIGyj2q4SwGqrrQHXM6S', 'ee213ecfaa928c3106d216e543ff4c8e', 'akbar@simas.ad', 1, 0, 0, 'Ahmad Akbar', '2013-06-26 17:10:14', '2013-06-26 17:10:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for view simasad.vsiswa
DROP VIEW IF EXISTS `vsiswa`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vsiswa` (
	`id` INT(10) NOT NULL,
	`tahunajaran_id` INT(10) NULL,
	`tahunajaran` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`rombel_id` INT(10) NULL,
	`rombel` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`jenjang` ENUM('1','2','3','4','5','6','0') NULL COLLATE 'utf8_general_ci',
	`siswa_id` INT(10) NULL,
	`siswa` VARCHAR(150) NULL COLLATE 'utf8_general_ci',
	`nisn` VARCHAR(10) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


-- Dumping structure for view simasad.vtargetpencapaian
DROP VIEW IF EXISTS `vtargetpencapaian`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vtargetpencapaian` (
	`id` INT(10) NOT NULL,
	`nama` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`aktif` ENUM('Y','N') NULL COLLATE 'utf8_general_ci',
	`posisi` INT(11) NULL,
	`jumlah` BIGINT(11) NOT NULL,
	`target_id` INT(10) NULL
) ENGINE=MyISAM;


-- Dumping structure for view simasad.vtransmasuk
DROP VIEW IF EXISTS `vtransmasuk`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vtransmasuk` (
	`id` INT(10) NOT NULL,
	`created_at` DATETIME NULL,
	`updated_at` DATETIME NULL,
	`tanggal` DATE NULL,
	`arus` ENUM('M','K') NULL COLLATE 'utf8_general_ci',
	`tahunajaran_id` INT(10) NULL,
	`tahunajaran` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`posisi_tahunajaran` INT(11) NULL,
	`siswa_id` INT(10) NULL,
	`nisn` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`siswa` VARCHAR(150) NULL COLLATE 'utf8_general_ci',
	`detil_id` INT(10) NOT NULL,
	`jenisbiaya_id` INT(10) NULL,
	`jenisbiaya` VARCHAR(60) NULL COLLATE 'utf8_general_ci',
	`tipe` ENUM('ITB','ITC','BBBI','BTBI') NULL COMMENT 'ITB : Iuran Tetap Bulanan, ITC:Iuran Tetap Cicilan, BBBI : Biaya bebas bukan iuran, BTBI: Biaya Tetap Bukan Iuran' COLLATE 'utf8_general_ci',
	`bulan_id` INT(10) NULL,
	`bulan` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`posisi` INT(11) NULL,
	`ket` VARCHAR(250) NULL COLLATE 'utf8_general_ci',
	`jumlah` INT(10) NULL
) ENGINE=MyISAM;


-- Dumping structure for view simasad.vsiswa
DROP VIEW IF EXISTS `vsiswa`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vsiswa`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vsiswa` AS select `rs`.`id` AS `id`,`rs`.`tahunajaran_id` AS `tahunajaran_id`,`t`.`nama` AS `tahunajaran`,`rs`.`rombel_id` AS `rombel_id`,`r`.`nama` AS `rombel`,`r`.`jenjang` AS `jenjang`,`rs`.`siswa_id` AS `siswa_id`,`s`.`nama` AS `siswa`,`s`.`nisn` AS `nisn` from (((`rombelsiswa` `rs` join `siswa` `s` on((`rs`.`siswa_id` = `s`.`id`))) join `rombel` `r` on((`rs`.`rombel_id` = `r`.`id`))) join `tahunajaran` `t` on((`rs`.`tahunajaran_id` = `t`.`id`))) ;


-- Dumping structure for view simasad.vtargetpencapaian
DROP VIEW IF EXISTS `vtargetpencapaian`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vtargetpencapaian`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vtargetpencapaian` AS select ta.id, ta.nama,ta.aktif,ta.posisi, ifnull(tp.jumlah,0) as jumlah, tp.id as target_id
from tahunajaran ta left join target_pencapaian tp on tp.tahunajaran_id = ta.id ;


-- Dumping structure for view simasad.vtransmasuk
DROP VIEW IF EXISTS `vtransmasuk`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vtransmasuk`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vtransmasuk` AS select `tm`.`id` AS `id`,`tm`.`created_at` AS `created_at`,`tm`.`updated_at` AS `updated_at`,`tm`.`tanggal` AS `tanggal`,`tm`.`arus` AS `arus`,`tm`.`tahunajaran_id` AS `tahunajaran_id`,`ta`.`nama` AS `tahunajaran`,ta.posisi as posisi_tahunajaran,`tm`.`siswa_id` AS `siswa_id`,`sw`.`nisn` AS `nisn`,`sw`.`nama` AS `siswa`,`dtm`.`id` AS `detil_id`,`dtm`.`jenisbiaya_id` AS `jenisbiaya_id`,`jb`.`nama` AS `jenisbiaya`,`jb`.`tipe` AS `tipe`,`dtm`.`bulan_id` AS `bulan_id`,`bl`.`nama` AS `bulan`,`bl`.`posisi` AS `posisi`,`dtm`.`ket` AS `ket`,`dtm`.`jumlah` AS `jumlah` from (((((`transmasuk` `tm` join `detiltransmasuk` `dtm` on((`dtm`.`transmasuk_id` = `tm`.`id`))) join `jenisbiaya` `jb` on((`dtm`.`jenisbiaya_id` = `jb`.`id`))) left join `siswa` `sw` on((`tm`.`siswa_id` = `sw`.`id`))) left join `bulan` `bl` on((`dtm`.`bulan_id` = `bl`.`id`))) join `tahunajaran` `ta` on((`tm`.`tahunajaran_id` = `ta`.`id`))) ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
