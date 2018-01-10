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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.appsetting
DROP TABLE IF EXISTS `appsetting`;
CREATE TABLE IF NOT EXISTS `appsetting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `biaya_id` int(11) NOT NULL COMMENT 'biaya id yang di guanakan di One click biaya',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.detiltransmasuk
DROP TABLE IF EXISTS `detiltransmasuk`;
CREATE TABLE IF NOT EXISTS `detiltransmasuk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `transmasuk_id` int(10) DEFAULT NULL,
  `jenisbiaya_id` int(10) DEFAULT NULL,
  `bulan_id` int(10) DEFAULT NULL,
  `jumlah` decimal(10,0) DEFAULT NULL,
  `potongan` decimal(10,0) DEFAULT NULL,
  `ket` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_detiltransmasuk_transmasuk` (`transmasuk_id`),
  KEY `FK_detiltransmasuk_jenisbiaya` (`jenisbiaya_id`),
  KEY `FK_detiltransmasuk_bulan` (`bulan_id`),
  CONSTRAINT `FK_detiltransmasuk_bulan` FOREIGN KEY (`bulan_id`) REFERENCES `bulan` (`id`),
  CONSTRAINT `FK_detiltransmasuk_jenisbiaya` FOREIGN KEY (`jenisbiaya_id`) REFERENCES `jenisbiaya` (`id`),
  CONSTRAINT `FK_detiltransmasuk_transmasuk` FOREIGN KEY (`transmasuk_id`) REFERENCES `transmasuk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.jenisbiaya
DROP TABLE IF EXISTS `jenisbiaya`;
CREATE TABLE IF NOT EXISTS `jenisbiaya` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(60) DEFAULT NULL,
  `perjenjang` enum('Y','N') DEFAULT 'N',
  `tipe` enum('ITB','ITC','BBBI','BTBI','IB') DEFAULT NULL COMMENT 'ITB : Iuran Tetap Bulanan, ITC:Iuran Tetap Cicilan, BBBI : Biaya bebas bukan iuran, BTBI: Biaya Tetap Bukan Iuran',
  `arus` enum('M','K') DEFAULT 'M',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.laravel_migrations
DROP TABLE IF EXISTS `laravel_migrations`;
CREATE TABLE IF NOT EXISTS `laravel_migrations` (
  `bundle` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`bundle`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.potongan
DROP TABLE IF EXISTS `potongan`;
CREATE TABLE IF NOT EXISTS `potongan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `siswa_id` int(10) DEFAULT NULL,
  `tahunajaran_id` int(10) DEFAULT NULL,
  `bulan_id` int(10) DEFAULT NULL,
  `jenisbiaya_id` int(10) DEFAULT NULL,
  `disc` decimal(10,0) DEFAULT NULL,
  `nilai` decimal(10,0) DEFAULT NULL,
  `ket` varchar(100) DEFAULT NULL,
  `jenis` enum('BP','BS') DEFAULT NULL COMMENT 'BP = Bantuan Pendidikan, BS = Beasiswa',
  PRIMARY KEY (`id`),
  KEY `jenisbiaya_id` (`jenisbiaya_id`),
  KEY `FK_potongan_siswa` (`siswa_id`),
  KEY `FK_potongan_tahunajaran` (`tahunajaran_id`),
  CONSTRAINT `FK_potongan_jenisbiaya` FOREIGN KEY (`jenisbiaya_id`) REFERENCES `jenisbiaya` (`id`),
  CONSTRAINT `FK_potongan_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`),
  CONSTRAINT `FK_potongan_tahunajaran` FOREIGN KEY (`tahunajaran_id`) REFERENCES `tahunajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.rombel
DROP TABLE IF EXISTS `rombel`;
CREATE TABLE IF NOT EXISTS `rombel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenjang` enum('1','2','3','4','5','6','0') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.setting
DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama_skul` varchar(150) DEFAULT NULL,
  `alamat_skul` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.siswa
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nisn` varchar(10) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.target_bulanan
DROP TABLE IF EXISTS `target_bulanan`;
CREATE TABLE IF NOT EXISTS `target_bulanan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tahunajaran_id` int(10) DEFAULT NULL,
  `jenisbiaya_id` int(10) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__tahunajaran_target` (`tahunajaran_id`),
  KEY `FK__jenisbiaya_target` (`jenisbiaya_id`),
  CONSTRAINT `FK__jenisbiaya_target` FOREIGN KEY (`jenisbiaya_id`) REFERENCES `jenisbiaya` (`id`),
  CONSTRAINT `FK__tahunajaran_target` FOREIGN KEY (`tahunajaran_id`) REFERENCES `tahunajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table simasad.target_pencapaian
DROP TABLE IF EXISTS `target_pencapaian`;
CREATE TABLE IF NOT EXISTS `target_pencapaian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tahunajaran_id` int(10) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for view simasad.view_siswa
DROP VIEW IF EXISTS `view_siswa`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_siswa` (
	`id` INT(10) NULL,
	`nama` VARCHAR(150) NULL COLLATE 'utf8_general_ci',
	`nisn` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`tahunajaran_id` INT(10) NULL,
	`tahunajaran` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`rombel_id` INT(10) NULL,
	`rombel` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`jenjang` ENUM('1','2','3','4','5','6','0') NULL COLLATE 'utf8_general_ci',
	`aktif` ENUM('Y','N') NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


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
	`nisn` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`aktif` ENUM('Y','N') NULL COLLATE 'utf8_general_ci'
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
	`tipe` ENUM('ITB','ITC','BBBI','BTBI','IB') NULL COMMENT 'ITB : Iuran Tetap Bulanan, ITC:Iuran Tetap Cicilan, BBBI : Biaya bebas bukan iuran, BTBI: Biaya Tetap Bukan Iuran' COLLATE 'utf8_general_ci',
	`bulan_id` INT(10) NULL,
	`bulan` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`posisi` INT(11) NULL,
	`ket` VARCHAR(250) NULL COLLATE 'utf8_general_ci',
	`jumlah` DECIMAL(10,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for view simasad.view_siswa
DROP VIEW IF EXISTS `view_siswa`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_siswa`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `simasad`.`view_siswa` AS select `rs`.`siswa_id` AS `id`,`s`.`nama` AS `nama`,`s`.`nisn` AS `nisn`,`rs`.`tahunajaran_id` AS `tahunajaran_id`,`t`.`nama` AS `tahunajaran`,`rs`.`rombel_id` AS `rombel_id`,`r`.`nama` AS `rombel`,`r`.`jenjang` AS `jenjang`,`s`.`aktif` AS `aktif` from (((`rombelsiswa` `rs` join `siswa` `s` on((`rs`.`siswa_id` = `s`.`id`))) join `rombel` `r` on((`rs`.`rombel_id` = `r`.`id`))) join `tahunajaran` `t` on((`rs`.`tahunajaran_id` = `t`.`id`))) ;


-- Dumping structure for view simasad.vsiswa
DROP VIEW IF EXISTS `vsiswa`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vsiswa`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `simasad`.`vsiswa` AS select `rs`.`id` AS `id`,`rs`.`tahunajaran_id` AS `tahunajaran_id`,`t`.`nama` AS `tahunajaran`,`rs`.`rombel_id` AS `rombel_id`,`r`.`nama` AS `rombel`,`r`.`jenjang` AS `jenjang`,`rs`.`siswa_id` AS `siswa_id`,`s`.`nama` AS `siswa`,`s`.`nisn` AS `nisn`,`s`.`aktif` AS `aktif` from (((`rombelsiswa` `rs` join `siswa` `s` on((`rs`.`siswa_id` = `s`.`id`))) join `rombel` `r` on((`rs`.`rombel_id` = `r`.`id`))) join `tahunajaran` `t` on((`rs`.`tahunajaran_id` = `t`.`id`))) ;


-- Dumping structure for view simasad.vtargetpencapaian
DROP VIEW IF EXISTS `vtargetpencapaian`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vtargetpencapaian`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `simasad`.`vtargetpencapaian` AS select `ta`.`id` AS `id`,`ta`.`nama` AS `nama`,`ta`.`aktif` AS `aktif`,`ta`.`posisi` AS `posisi`,ifnull(`tp`.`jumlah`,0) AS `jumlah`,`tp`.`id` AS `target_id` from (`tahunajaran` `ta` left join `target_pencapaian` `tp` on((`tp`.`tahunajaran_id` = `ta`.`id`))) ;


-- Dumping structure for view simasad.vtransmasuk
DROP VIEW IF EXISTS `vtransmasuk`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vtransmasuk`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `simasad`.`vtransmasuk` AS select `tm`.`id` AS `id`,`tm`.`created_at` AS `created_at`,`tm`.`updated_at` AS `updated_at`,`tm`.`tanggal` AS `tanggal`,`tm`.`arus` AS `arus`,`tm`.`tahunajaran_id` AS `tahunajaran_id`,`ta`.`nama` AS `tahunajaran`,`ta`.`posisi` AS `posisi_tahunajaran`,`tm`.`siswa_id` AS `siswa_id`,`sw`.`nisn` AS `nisn`,`sw`.`nama` AS `siswa`,`dtm`.`id` AS `detil_id`,`dtm`.`jenisbiaya_id` AS `jenisbiaya_id`,`jb`.`nama` AS `jenisbiaya`,`jb`.`tipe` AS `tipe`,`dtm`.`bulan_id` AS `bulan_id`,`bl`.`nama` AS `bulan`,`bl`.`posisi` AS `posisi`,`dtm`.`ket` AS `ket`,`dtm`.`jumlah` AS `jumlah` from (((((`transmasuk` `tm` join `detiltransmasuk` `dtm` on((`dtm`.`transmasuk_id` = `tm`.`id`))) join `jenisbiaya` `jb` on((`dtm`.`jenisbiaya_id` = `jb`.`id`))) left join `siswa` `sw` on((`tm`.`siswa_id` = `sw`.`id`))) left join `bulan` `bl` on((`dtm`.`bulan_id` = `bl`.`id`))) join `tahunajaran` `ta` on((`tm`.`tahunajaran_id` = `ta`.`id`))) ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
