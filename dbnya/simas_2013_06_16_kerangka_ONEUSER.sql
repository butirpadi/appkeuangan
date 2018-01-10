-- --------------------------------------------------------
-- Host                          :127.0.0.1
-- Server version                :5.5.27 - MySQL Community Server (GPL)
-- Server OS                     :Win32
-- HeidiSQL Version              :7.0.0.4304
-- Created                       :2013-06-16 17:05:38
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for vsimasad
DROP DATABASE IF EXISTS `simasad`;
CREATE DATABASE IF NOT EXISTS `simasad` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `simasad`;


-- Dumping structure for table vsimasad.activator
DROP TABLE IF EXISTS `activator`;
CREATE TABLE IF NOT EXISTS `activator` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `lunas` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.activator: ~0 rows (approximately)
/*!40000 ALTER TABLE `activator` DISABLE KEYS */;
/*!40000 ALTER TABLE `activator` ENABLE KEYS */;


-- Dumping structure for table vsimasad.appsetting
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
  PRIMARY KEY (`id`),
  KEY `FK_appsetting_biaya` (`biaya_id`),
  CONSTRAINT `FK_appsetting_biaya` FOREIGN KEY (`biaya_id`) REFERENCES `jenisbiaya` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.appsetting: ~1 rows (approximately)
/*!40000 ALTER TABLE `appsetting` DISABLE KEYS */;
INSERT INTO `appsetting` (`id`, `created_at`, `updated_at`, `biaya_id`, `mysqldumppath`, `cetaknota`, `printeraddr`, `lunas`) VALUES
	(1, '2013-05-31 10:03:45', '2013-06-16 09:27:04', 1, 'C:\\xampp\\mysql\\bin\\', 'Y', '//192.168.0.1/epson_lx_800', 'N');
/*!40000 ALTER TABLE `appsetting` ENABLE KEYS */;


-- Dumping structure for table vsimasad.bulan
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

-- Dumping data for table vsimasad.bulan: ~12 rows (approximately)
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


-- Dumping structure for table vsimasad.detiltransmasuk
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

-- Dumping data for table vsimasad.detiltransmasuk: ~0 rows (approximately)
/*!40000 ALTER TABLE `detiltransmasuk` DISABLE KEYS */;
/*!40000 ALTER TABLE `detiltransmasuk` ENABLE KEYS */;


-- Dumping structure for table vsimasad.jenisbiaya
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.jenisbiaya: ~0 rows (approximately)
/*!40000 ALTER TABLE `jenisbiaya` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenisbiaya` ENABLE KEYS */;


-- Dumping structure for table vsimasad.ketentuanbiaya
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.ketentuanbiaya: ~0 rows (approximately)
/*!40000 ALTER TABLE `ketentuanbiaya` DISABLE KEYS */;
/*!40000 ALTER TABLE `ketentuanbiaya` ENABLE KEYS */;


-- Dumping structure for table vsimasad.laravel_migrations
DROP TABLE IF EXISTS `laravel_migrations`;
CREATE TABLE IF NOT EXISTS `laravel_migrations` (
  `bundle` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`bundle`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.laravel_migrations: ~0 rows (approximately)
/*!40000 ALTER TABLE `laravel_migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `laravel_migrations` ENABLE KEYS */;


-- Dumping structure for table vsimasad.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.permissions: ~14 rows (approximately)
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
	(14, 'manage_system_setting', 'Mengelola Data System Setting', '2013-06-11 19:29:08', '2013-06-11 19:29:09');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;


-- Dumping structure for table vsimasad.permission_role
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.permission_role: ~27 rows (approximately)
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
	(43, 10, 5, '2013-06-11 19:09:59', '2013-06-11 19:09:59');
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;


-- Dumping structure for table vsimasad.roles
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.roles: ~1 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `description`, `level`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', NULL, 10, '2013-06-11 17:07:25', '2013-06-11 17:07:25');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- Dumping structure for table vsimasad.role_user
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.role_user: ~1 rows (approximately)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2013-06-12 08:44:17', '2013-06-12 08:44:17');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;


-- Dumping structure for table vsimasad.rombel
DROP TABLE IF EXISTS `rombel`;
CREATE TABLE IF NOT EXISTS `rombel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenjang` enum('1','2','3','4','5','6','0') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.rombel: ~0 rows (approximately)
/*!40000 ALTER TABLE `rombel` DISABLE KEYS */;
/*!40000 ALTER TABLE `rombel` ENABLE KEYS */;


-- Dumping structure for table vsimasad.rombelsiswa
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.rombelsiswa: ~0 rows (approximately)
/*!40000 ALTER TABLE `rombelsiswa` DISABLE KEYS */;
/*!40000 ALTER TABLE `rombelsiswa` ENABLE KEYS */;


-- Dumping structure for table vsimasad.setting
DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama_skul` varchar(150) DEFAULT NULL,
  `alamat_skul` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.setting: ~1 rows (approximately)
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` (`id`, `created_at`, `updated_at`, `nama_skul`, `alamat_skul`) VALUES
	(1, '2013-05-28 06:26:42', '2013-05-28 06:26:44', 'SEKOLAH DASAR ISLAM SABILIL HUDA', 'Jl. Singokarso 54 Sumorame Candi Sidoarjo 61271 Telp. 031-8061169');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;


-- Dumping structure for table vsimasad.siswa
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nisn` varchar(10) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.siswa: ~0 rows (approximately)
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;


-- Dumping structure for table vsimasad.tahunajaran
DROP TABLE IF EXISTS `tahunajaran`;
CREATE TABLE IF NOT EXISTS `tahunajaran` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT 'N',
  `posisi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.tahunajaran: ~0 rows (approximately)
/*!40000 ALTER TABLE `tahunajaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `tahunajaran` ENABLE KEYS */;


-- Dumping structure for table vsimasad.transmasuk
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

-- Dumping data for table vsimasad.transmasuk: ~0 rows (approximately)
/*!40000 ALTER TABLE `transmasuk` DISABLE KEYS */;
/*!40000 ALTER TABLE `transmasuk` ENABLE KEYS */;


-- Dumping structure for table vsimasad.users
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
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_username_index` (`username`),
  KEY `users_password_index` (`password`),
  KEY `users_email_index` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table vsimasad.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `verified`, `disabled`, `deleted`, `created_at`, `updated_at`) VALUES
	(1, 'eries', '$2a$08$bcRj9c3qXX8psBEp9PpNtemSVQOfOlgQwmMTm2d9XLO/WNI/zgUxC', 'c9f169ae899b5f1f2d0f9277d639698b', 'eries@simas.ad', 1, 0, 0, '2013-06-12 08:44:01', '2013-06-12 08:46:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for view vsimasad.vsiswa
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


-- Dumping structure for view vsimasad.vtransmasuk
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


-- Dumping structure for view vsimasad.vsiswa
DROP VIEW IF EXISTS `vsiswa`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vsiswa`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vsiswa` AS select `rs`.`id` AS `id`,`rs`.`tahunajaran_id` AS `tahunajaran_id`,`t`.`nama` AS `tahunajaran`,`rs`.`rombel_id` AS `rombel_id`,`r`.`nama` AS `rombel`,`r`.`jenjang` AS `jenjang`,`rs`.`siswa_id` AS `siswa_id`,`s`.`nama` AS `siswa`,`s`.`nisn` AS `nisn` from (((`rombelsiswa` `rs` join `siswa` `s` on((`rs`.`siswa_id` = `s`.`id`))) join `rombel` `r` on((`rs`.`rombel_id` = `r`.`id`))) join `tahunajaran` `t` on((`rs`.`tahunajaran_id` = `t`.`id`))) ;


-- Dumping structure for view vsimasad.vtransmasuk
DROP VIEW IF EXISTS `vtransmasuk`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vtransmasuk`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vtransmasuk` AS select `tm`.`id` AS `id`,`tm`.`created_at` AS `created_at`,`tm`.`updated_at` AS `updated_at`,`tm`.`tanggal` AS `tanggal`,`tm`.`arus` AS `arus`,`tm`.`tahunajaran_id` AS `tahunajaran_id`,`ta`.`nama` AS `tahunajaran`,`tm`.`siswa_id` AS `siswa_id`,`sw`.`nisn` AS `nisn`,`sw`.`nama` AS `siswa`,`dtm`.`id` AS `detil_id`,`dtm`.`jenisbiaya_id` AS `jenisbiaya_id`,`jb`.`nama` AS `jenisbiaya`,`jb`.`tipe` AS `tipe`,`dtm`.`bulan_id` AS `bulan_id`,`bl`.`nama` AS `bulan`,`bl`.`posisi` AS `posisi`,`dtm`.`ket` AS `ket`,`dtm`.`jumlah` AS `jumlah` from (((((`transmasuk` `tm` join `detiltransmasuk` `dtm` on((`dtm`.`transmasuk_id` = `tm`.`id`))) join `jenisbiaya` `jb` on((`dtm`.`jenisbiaya_id` = `jb`.`id`))) left join `siswa` `sw` on((`tm`.`siswa_id` = `sw`.`id`))) left join `bulan` `bl` on((`dtm`.`bulan_id` = `bl`.`id`))) join `tahunajaran` `ta` on((`tm`.`tahunajaran_id` = `ta`.`id`))) ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
