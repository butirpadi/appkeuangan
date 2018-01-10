-- MySQL dump 10.13  Distrib 5.5.27, for Win32 (x86)
--
-- Host: localhost    Database: simasad
-- ------------------------------------------------------
-- Server version	5.5.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `appsetting`
--

DROP TABLE IF EXISTS `appsetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appsetting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `biaya_id` int(11) DEFAULT NULL COMMENT 'biaya id yang di guanakan di One click biaya',
  `mysqldumppath` varchar(150) DEFAULT NULL,
  `cetaknota` enum('Y','N') DEFAULT NULL,
  `printeraddr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_appsetting_biaya` (`biaya_id`),
  CONSTRAINT `FK_appsetting_biaya` FOREIGN KEY (`biaya_id`) REFERENCES `_biaya` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appsetting`
--

LOCK TABLES `appsetting` WRITE;
/*!40000 ALTER TABLE `appsetting` DISABLE KEYS */;
INSERT INTO `appsetting` VALUES (1,'2013-05-31 10:03:45','2013-06-14 10:00:41',1,'C:\\xampp\\mysql\\bin\\','Y','//192.168.0.1/epson_lx_800');
/*!40000 ALTER TABLE `appsetting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bulan`
--

DROP TABLE IF EXISTS `bulan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bulan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `angka` int(11) DEFAULT NULL,
  `posisi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bulan`
--

LOCK TABLES `bulan` WRITE;
/*!40000 ALTER TABLE `bulan` DISABLE KEYS */;
INSERT INTO `bulan` VALUES (1,'2013-05-09 17:09:28','2013-05-11 02:42:00','januari',1,7),(2,'2013-05-09 17:09:38','2013-05-11 02:42:01','februari',2,8),(3,'2013-05-09 17:09:53','2013-05-11 02:42:03','maret',3,9),(4,'2013-05-09 17:10:00','2013-05-11 02:42:05','april',4,10),(5,'2013-05-09 17:10:06','2013-05-11 02:42:07','mei',5,11),(6,'2013-05-09 17:10:11','2013-05-11 02:42:07','juni',6,12),(7,'2013-05-09 17:10:16','2013-05-11 02:41:50','juli',7,1),(8,'2013-05-09 17:10:21','2013-05-11 02:41:52','agustus',8,2),(9,'2013-05-09 17:10:28','2013-05-11 02:41:54','september',9,3),(10,'2013-05-09 17:10:33','2013-05-11 02:41:55','oktober',10,4),(11,'2013-05-09 17:10:40','2013-05-11 02:41:57','november',11,5),(12,'2013-05-09 17:10:47','2013-05-11 02:41:58','desember',12,6);
/*!40000 ALTER TABLE `bulan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detiltransmasuk`
--

DROP TABLE IF EXISTS `detiltransmasuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detiltransmasuk` (
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detiltransmasuk`
--

LOCK TABLES `detiltransmasuk` WRITE;
/*!40000 ALTER TABLE `detiltransmasuk` DISABLE KEYS */;
INSERT INTO `detiltransmasuk` VALUES (1,'2013-06-10 08:17:17','2013-06-10 08:17:17',1,1,7,100000,NULL),(2,'2013-06-10 08:17:24','2013-06-10 08:17:24',2,1,7,100000,NULL),(3,'2013-06-10 08:17:32','2013-06-10 08:17:32',3,1,7,100000,NULL),(4,'2013-06-10 08:17:39','2013-06-10 08:17:39',4,1,7,100000,NULL),(5,'2013-06-10 08:17:47','2013-06-10 08:17:47',5,1,7,100000,NULL),(6,'2013-06-14 06:34:58','2013-06-14 06:34:58',6,1,8,100000,NULL),(7,'2013-06-14 06:37:24','2013-06-14 06:37:24',7,1,8,100000,NULL),(8,'2013-06-14 06:37:24','2013-06-14 06:37:24',7,4,NULL,150000,NULL),(9,'2013-06-14 06:40:17','2013-06-14 06:40:17',8,1,9,100000,NULL),(10,'2013-06-14 06:40:17','2013-06-14 06:40:17',8,1,10,100000,NULL),(11,'2013-06-14 06:42:42','2013-06-14 06:42:42',9,1,8,100000,NULL),(12,'2013-06-14 06:42:42','2013-06-14 06:42:42',9,1,9,100000,NULL),(13,'2013-06-14 06:42:42','2013-06-14 06:42:42',9,4,NULL,100000,NULL),(14,'2013-06-14 06:45:37','2013-06-14 06:45:37',10,1,8,100000,NULL),(15,'2013-06-14 06:45:37','2013-06-14 06:45:37',10,4,NULL,150000,NULL),(16,'2013-06-14 06:47:57','2013-06-14 06:47:57',11,1,8,100000,NULL),(17,'2013-06-14 06:47:57','2013-06-14 06:47:57',11,1,9,100000,NULL),(18,'2013-06-14 06:47:57','2013-06-14 06:47:57',11,1,10,100000,NULL),(19,'2013-06-14 06:47:57','2013-06-14 06:47:57',11,4,NULL,50000,NULL),(20,'2013-06-14 06:49:40','2013-06-14 06:49:40',12,1,7,100000,NULL),(21,'2013-06-14 06:49:40','2013-06-14 06:49:40',12,1,8,100000,NULL),(22,'2013-06-14 06:49:40','2013-06-14 06:49:40',12,4,NULL,200000,NULL),(23,'2013-06-14 06:57:37','2013-06-14 06:57:37',13,1,7,100000,NULL),(24,'2013-06-14 06:57:37','2013-06-14 06:57:37',13,1,8,100000,NULL),(25,'2013-06-14 06:57:37','2013-06-14 06:57:37',13,4,NULL,50000,NULL),(26,'2013-06-14 07:01:27','2013-06-14 07:01:27',14,1,7,100000,NULL),(27,'2013-06-14 07:01:27','2013-06-14 07:01:27',14,4,NULL,150000,NULL),(28,'2013-06-14 07:02:40','2013-06-14 07:02:40',15,1,7,100000,NULL),(29,'2013-06-14 07:02:40','2013-06-14 07:02:40',15,4,NULL,75000,NULL),(30,'2013-06-14 07:04:28','2013-06-14 07:04:28',16,1,7,100000,NULL),(31,'2013-06-14 07:04:28','2013-06-14 07:04:28',16,4,NULL,90000,NULL),(32,'2013-06-14 07:10:13','2013-06-14 07:10:13',17,1,7,100000,NULL),(33,'2013-06-14 07:10:13','2013-06-14 07:10:13',17,4,NULL,25000,NULL),(34,'2013-06-14 07:12:16','2013-06-14 07:12:16',18,1,7,100000,NULL),(35,'2013-06-14 07:12:16','2013-06-14 07:12:16',18,4,NULL,105000,NULL),(36,'2013-06-14 07:20:33','2013-06-14 07:20:33',19,1,7,100000,NULL),(37,'2013-06-14 07:20:33','2013-06-14 07:20:33',19,4,NULL,82500,NULL);
/*!40000 ALTER TABLE `detiltransmasuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenisbiaya`
--

DROP TABLE IF EXISTS `jenisbiaya`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenisbiaya` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(60) DEFAULT NULL,
  `perjenjang` enum('Y','N') DEFAULT 'N',
  `tipe` enum('ITB','ITC','BBBI','BTBI') DEFAULT NULL COMMENT 'ITB : Iuran Tetap Bulanan, ITC:Iuran Tetap Cicilan, BBBI : Biaya bebas bukan iuran, BTBI: Biaya Tetap Bukan Iuran',
  `arus` enum('M','K') DEFAULT 'M',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenisbiaya`
--

LOCK TABLES `jenisbiaya` WRITE;
/*!40000 ALTER TABLE `jenisbiaya` DISABLE KEYS */;
INSERT INTO `jenisbiaya` VALUES (1,'2013-05-20 21:39:03','2013-05-20 21:39:03','SPP','Y','ITB','M'),(2,'2013-05-20 21:42:25','2013-05-20 21:42:25','Pendaftaran Siswa Baru','N','BTBI','M'),(3,'2013-05-20 21:42:39','2013-05-20 21:42:39','Pengadaan Peralatan Sekolah','N','BBBI','K'),(4,'2013-05-20 21:42:54','2013-05-20 21:42:54','LKS','Y','ITC','M'),(6,'2013-05-26 08:53:02','2013-05-26 08:53:02','Modal','N','BBBI','M');
/*!40000 ALTER TABLE `jenisbiaya` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ketentuanbiaya`
--

DROP TABLE IF EXISTS `ketentuanbiaya`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ketentuanbiaya` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ketentuanbiaya`
--

LOCK TABLES `ketentuanbiaya` WRITE;
/*!40000 ALTER TABLE `ketentuanbiaya` DISABLE KEYS */;
INSERT INTO `ketentuanbiaya` VALUES (1,'2013-06-10 07:03:32','2013-06-10 07:03:32',4,1,'1',100000),(2,'2013-06-10 07:03:32','2013-06-10 07:03:32',4,1,'2',110000),(3,'2013-06-10 07:03:32','2013-06-10 07:03:32',4,1,'3',120000),(4,'2013-06-10 07:03:32','2013-06-10 07:03:32',4,1,'4',130000),(5,'2013-06-10 07:03:32','2013-06-10 07:03:32',4,1,'5',140000),(6,'2013-06-10 07:03:32','2013-06-10 07:03:32',4,1,'6',150000),(7,'2013-06-10 07:04:05','2013-06-10 07:04:05',4,4,'1',200000),(8,'2013-06-10 07:04:05','2013-06-10 07:04:05',4,4,'2',210000),(9,'2013-06-10 07:04:05','2013-06-10 07:04:05',4,4,'3',220000),(10,'2013-06-10 07:04:05','2013-06-10 07:04:05',4,4,'4',230000),(11,'2013-06-10 07:04:05','2013-06-10 07:04:05',4,4,'5',240000),(12,'2013-06-10 07:04:05','2013-06-10 07:04:05',4,4,'6',250000),(13,'2013-06-10 07:15:35','2013-06-10 07:15:35',4,2,NULL,200000);
/*!40000 ALTER TABLE `ketentuanbiaya` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laravel_migrations`
--

DROP TABLE IF EXISTS `laravel_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laravel_migrations` (
  `bundle` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`bundle`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laravel_migrations`
--

LOCK TABLES `laravel_migrations` WRITE;
/*!40000 ALTER TABLE `laravel_migrations` DISABLE KEYS */;
INSERT INTO `laravel_migrations` VALUES ('sentry','2012_08_03_162320_install',1),('sentry','2012_08_15_001334_database_rules',1),('sentry','2012_10_08_000000_users_nullable',1),('verify','2012_06_17_211339_init',2),('verify','2013_02_24_094926_user_roles_one_to_many',2);
/*!40000 ALTER TABLE `laravel_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (12,1,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(13,2,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(14,3,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(15,4,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(16,5,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(17,6,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(18,7,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(19,8,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(20,9,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(21,10,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(22,11,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(23,12,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(24,13,1,'2013-06-11 18:19:22','2013-06-11 18:19:22'),(30,3,4,'2013-06-11 19:09:43','2013-06-11 19:09:43'),(31,4,4,'2013-06-11 19:09:43','2013-06-11 19:09:43'),(32,5,4,'2013-06-11 19:09:43','2013-06-11 19:09:43'),(33,6,4,'2013-06-11 19:09:43','2013-06-11 19:09:43'),(34,7,4,'2013-06-11 19:09:43','2013-06-11 19:09:43'),(35,8,4,'2013-06-11 19:09:44','2013-06-11 19:09:44'),(36,9,4,'2013-06-11 19:09:44','2013-06-11 19:09:44'),(37,10,4,'2013-06-11 19:09:44','2013-06-11 19:09:44'),(38,11,4,'2013-06-11 19:09:44','2013-06-11 19:09:44'),(39,12,4,'2013-06-11 19:09:44','2013-06-11 19:09:44'),(40,13,4,'2013-06-11 19:09:44','2013-06-11 19:09:44'),(41,8,5,'2013-06-11 19:09:59','2013-06-11 19:09:59'),(42,9,5,'2013-06-11 19:09:59','2013-06-11 19:09:59'),(43,10,5,'2013-06-11 19:09:59','2013-06-11 19:09:59');
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'manage_user','Mengelola Data User (tambah,edit,hapus)','2013-06-11 17:59:12','2013-06-11 17:59:12'),(2,'manage_user_group','Mengelola Data User Group (tambah,edit,hapus)','2013-06-11 17:59:12','2013-06-11 17:59:12'),(3,'manage_tahun_ajaran','Mengelola Data Tahun Ajaran (tambah,edit,hapus)','2013-06-11 17:59:12','2013-06-11 17:59:12'),(4,'manage_bulan','Mengelola Data Urutan Bulan (tambah,edit,hapus)','2013-06-11 18:00:33','2013-06-11 18:00:33'),(5,'manage_rombel','Mengelola Data Rombongan Belajar (tambah,edit,hapus)','2013-06-11 18:01:05','2013-06-11 18:01:06'),(6,'manage_biaya','Mengelola Data Biaya (tambah,edit,hapus, dan pengaturan biaya)','2013-06-11 18:01:29','2013-06-11 18:01:29'),(7,'manage_siswa','Mengelola Data Siswa (tambah,edit,hapus)','2013-06-11 18:04:33','2013-06-11 18:04:33'),(8,'manage_transaksi_penerimaan_iuran','Mengelola Transaksi Penerimaan Iuran Siswa','2013-06-11 18:04:33','2013-06-11 18:04:34'),(9,'manage_transaksi_penerimaan','Mengelola Transaksi Penerimaan','2013-06-11 18:04:57','2013-06-11 18:04:57'),(10,'manage_transaksi_pengeluaran','Mengelola Transaksi Pengeluaran','2013-06-11 18:05:09','2013-06-11 18:05:10'),(11,'manage_histori_transaksi','Mengelola Data Histori Transaksi','2013-06-11 18:05:27','2013-06-11 18:05:27'),(12,'manage_rekapitulasi_transaksi','Mengelola Data Rekapitulasi Transaksi','2013-06-11 18:05:57','2013-06-11 18:05:57'),(13,'manage_rekapitulasi_iuran','Mengelola Data Rekapitulasi Iuran Per Tahun Ajaran','2013-06-11 18:06:20','2013-06-11 18:06:20'),(14,'manage_system_setting','Mengelola Data System Setting','2013-06-11 19:29:08','2013-06-11 19:29:09');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1,'2013-06-12 08:44:17','2013-06-12 08:44:17'),(2,2,1,'2013-06-12 08:47:50','2013-06-12 08:47:50'),(3,3,4,'2013-06-12 08:49:05','2013-06-12 08:49:05'),(4,4,5,'2013-06-12 08:49:16','2013-06-12 08:49:16');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin',NULL,10,'2013-06-11 17:07:25','2013-06-11 17:07:25'),(4,'Bagian Keuangan',NULL,0,'2013-06-11 19:09:43','2013-06-11 19:09:43'),(5,'Kasir',NULL,0,'2013-06-11 19:09:59','2013-06-11 19:09:59');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rombel`
--

DROP TABLE IF EXISTS `rombel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rombel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenjang` enum('1','2','3','4','5','6','0') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rombel`
--

LOCK TABLES `rombel` WRITE;
/*!40000 ALTER TABLE `rombel` DISABLE KEYS */;
INSERT INTO `rombel` VALUES (1,'2013-05-10 02:37:42','2013-05-14 23:54:29','I - RA Kartini','1'),(2,'2013-05-10 02:37:56','2013-05-14 23:59:48','I - Cut Nya`Din','1'),(3,'2013-05-10 02:38:01','2013-05-15 00:00:30','II - Hasanudin','2'),(4,'2013-05-10 02:38:09','2013-05-15 00:05:25','II - Wachid Hasyim','2'),(5,'2013-05-10 02:38:13','2013-05-15 00:00:52','III - Imam Bonjol','3'),(6,'2013-05-10 02:38:19','2013-05-10 02:38:19','III - Ki Hajar Dewantara','3'),(7,'2013-05-10 02:38:25','2013-05-15 00:05:42','IV - Pangeran Diponegoro','4'),(8,'2013-05-10 02:38:31','2013-05-15 00:06:27','IV - Teuku Umar','4'),(9,'2013-05-10 02:39:10','2013-05-15 00:06:38','V - Ahmad Yani','5'),(10,'2013-05-10 02:39:19','2013-05-10 02:39:19','V - Dr Sutomo','5'),(11,'2013-05-10 02:39:25','2013-05-10 02:39:25','VI - Jendral Sudirman','6'),(12,'2013-05-10 02:39:31','2013-05-10 02:39:31','VI - Yos Sudarso','6'),(13,'2013-05-11 09:47:50','2013-06-03 07:00:15','Lulus','0');
/*!40000 ALTER TABLE `rombel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rombelsiswa`
--

DROP TABLE IF EXISTS `rombelsiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rombelsiswa` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rombelsiswa`
--

LOCK TABLES `rombelsiswa` WRITE;
/*!40000 ALTER TABLE `rombelsiswa` DISABLE KEYS */;
INSERT INTO `rombelsiswa` VALUES (1,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,1),(2,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,2),(3,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,3),(4,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,4),(5,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,5),(6,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,6),(7,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,7),(8,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,8),(9,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,9),(10,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,1,10),(11,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,11),(12,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,12),(13,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,13),(14,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,14),(15,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,15),(16,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,16),(17,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,17),(18,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,18),(19,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,19),(20,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,2,20),(21,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,21),(22,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,22),(23,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,23),(24,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,24),(25,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,25),(26,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,26),(27,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,27),(28,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,28),(29,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,29),(30,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,3,30),(31,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,31),(32,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,32),(33,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,33),(34,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,34),(35,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,35),(36,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,36),(37,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,37),(38,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,38),(39,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,39),(40,'2013-06-05 14:06:33','2013-06-05 14:06:33',4,4,40),(64,'2013-06-05 17:01:22','2013-06-05 17:01:22',4,5,42),(65,'2013-06-05 17:02:51','2013-06-05 17:02:51',4,5,43),(66,'2013-06-05 17:03:08','2013-06-05 17:03:08',4,5,44),(67,'2013-06-05 17:03:30','2013-06-05 17:03:30',4,5,45),(68,'2013-06-05 17:03:48','2013-06-05 17:03:48',4,5,46),(69,'2013-06-05 18:22:28','2013-06-05 18:22:28',4,5,47),(70,'2013-06-05 18:23:54','2013-06-05 18:23:54',4,5,48),(71,'2013-06-05 18:24:22','2013-06-05 18:24:22',4,5,49),(72,'2013-06-05 18:24:44','2013-06-05 18:24:44',4,5,50),(73,'2013-06-05 18:25:26','2013-06-05 18:25:26',4,5,51),(74,'2013-06-05 18:25:38','2013-06-05 18:25:38',4,5,52),(75,'2013-06-05 18:25:53','2013-06-05 18:25:53',4,5,53),(76,'2013-06-05 18:26:07','2013-06-05 18:26:07',4,5,54);
/*!40000 ALTER TABLE `rombelsiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama_skul` varchar(150) DEFAULT NULL,
  `alamat_skul` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'2013-05-28 06:26:42','2013-05-28 06:26:44','SEKOLAH DASAR ISLAM SABILIL HUDA','Jl. Singokarso 54 Sumorame Candi Sidoarjo 61271 Telp. 031-8061169');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siswa` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nisn` varchar(10) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa`
--

LOCK TABLES `siswa` WRITE;
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
INSERT INTO `siswa` VALUES (1,'2013-05-10 23:26:01','2013-05-10 23:48:58','2565','Aqilla Qanza Habibi'),(2,'2013-05-10 23:26:23','2013-05-10 23:26:23','2567','Afia Najah Abdullah Hafizah'),(3,'2013-05-10 23:26:34','2013-05-10 23:26:34','2568','Ahmad Hanbal'),(4,'2013-05-10 23:27:42','2013-05-10 23:27:42','2569','Muhammad Maulana Mailk Ibrahim'),(5,'2013-05-10 23:27:56','2013-05-10 23:27:56','2570','Falihah Farannisa'),(6,'2013-05-10 23:28:09','2013-05-10 23:28:09','2571','Muhammad Sultan Al Fatih'),(7,'2013-05-10 23:28:30','2013-05-10 23:28:30','2572','Awila Najah'),(8,'2013-05-10 23:28:47','2013-05-10 23:28:47','2573','Farhad Aschibly'),(9,'2013-05-10 23:31:32','2013-05-10 23:31:32','2574','Afia Naila Arkarna'),(10,'2013-05-10 23:31:45','2013-05-10 23:31:45','2575','Ismed Bahasuan'),(11,'2013-05-10 23:32:09','2013-05-10 23:32:09','2576','Aina Talita Zahran'),(12,'2013-05-10 23:32:31','2013-05-10 23:32:31','2577','Abu Bakar Al Habsy'),(13,'2013-05-10 23:32:45','2013-05-10 23:32:45','2578','Ainiya Faida Azmi'),(14,'2013-05-10 23:32:56','2013-05-10 23:32:56','2579','Ahmad Husein Assegaf'),(15,'2013-05-10 23:33:17','2013-05-10 23:33:17','2580','Akifa Naila'),(16,'2013-05-10 23:33:28','2013-05-10 23:33:28','2581','Muhammad Zein AL Athas'),(17,'2013-05-10 23:33:50','2013-05-10 23:33:50','2582','Annisa Faiha'),(18,'2013-05-10 23:34:06','2013-05-10 23:34:06','2583','Saad Amirullah'),(19,'2013-05-10 23:34:24','2013-05-10 23:34:24','2584','Muhammad Shalahudin Yusuf Al Ayyubi'),(20,'2013-05-10 23:34:53','2013-05-10 23:34:53','2585','Andi Ainurrahman'),(21,'2013-05-10 23:35:16','2013-05-10 23:35:16','2586','Rahmat Kukuh Rahardiansyah'),(22,'2013-05-10 23:35:29','2013-05-10 23:35:29','2587','Muhammad Saad'),(23,'2013-05-10 23:35:41','2013-05-10 23:35:41','2588','Putra Abric Susanto'),(24,'2013-05-10 23:35:53','2013-05-10 23:35:53','2589','Bima Putra Narendra'),(25,'2013-05-10 23:36:12','2013-05-10 23:36:12','2590','Adista Novendra Robi'),(26,'2013-05-10 23:36:39','2013-05-10 23:36:39','2591','Tri Nur Dianingsih'),(27,'2013-05-10 23:36:54','2013-05-10 23:36:54','2592','Muhmmad Nasichul Amin'),(28,'2013-05-10 23:37:15','2013-05-10 23:37:15','2593','Yopie Indra Kurnia'),(29,'2013-05-10 23:37:29','2013-05-10 23:37:29','2594','Fadhil Al Kadri'),(30,'2013-05-10 23:37:49','2013-05-10 23:37:49','2595','Dimas Satya Wardhana'),(31,'2013-05-10 23:38:16','2013-05-10 23:38:16','2596','Rangga Budi Utomo'),(32,'2013-05-10 23:38:43','2013-05-10 23:38:43','2597','Selvi Widya'),(33,'2013-05-10 23:38:55','2013-05-10 23:38:55','2598','Ratna Dwi Suhendra'),(34,'2013-05-10 23:39:26','2013-05-10 23:39:26','2599','Baiyah Uswatun Chasanah'),(35,'2013-05-10 23:39:50','2013-05-10 23:39:50','2600','Sulaiman Rosyid'),(36,'2013-05-10 23:40:00','2013-05-10 23:40:00','2601','Rafid Ibnu Shina'),(37,'2013-05-10 23:40:24','2013-05-10 23:40:24','2602','Catur Prasetyawan'),(38,'2013-05-10 23:40:31','2013-05-10 23:40:31','2603','Achmad Bagus'),(39,'2013-05-10 23:40:47','2013-05-10 23:40:47','2604','Annuril Maulida'),(40,'2013-05-10 23:49:56','2013-05-10 23:49:56','2605','Agustin Wanda Sari'),(42,'2013-06-05 17:01:22','2013-06-05 17:01:22','2606','SYEELA AYU PRAMATA RATRI'),(43,'2013-06-05 17:02:51','2013-06-05 17:02:51','2607','ARFAN JAROQIM'),(44,'2013-06-05 17:03:08','2013-06-05 17:03:08','2608','MONITA DEVI RESTIANA'),(45,'2013-06-05 17:03:30','2013-06-05 17:03:30','2609','MEI PRESILIA'),(46,'2013-06-05 17:03:48','2013-06-05 17:03:48','2610','RIZA RINDARANI'),(47,'2013-06-05 18:22:28','2013-06-05 18:22:28','2611','ANITA NANDA KUSUMA DEWI'),(48,'2013-06-05 18:23:54','2013-06-05 18:23:54','2612','MOCHAMAD ARIFIN'),(49,'2013-06-05 18:24:22','2013-06-05 18:24:22','2613','RENI AGUSTINA'),(50,'2013-06-05 18:24:44','2013-06-05 18:24:44','2614','AGUSTIN LISTIANA'),(51,'2013-06-05 18:25:25','2013-06-05 18:25:25','2615','AYU KRISTIANA'),(52,'2013-06-05 18:25:38','2013-06-05 18:25:38','2616','YESSY WULANDARI'),(53,'2013-06-05 18:25:53','2013-06-05 18:25:53','2617','HUSNI ASKARO'),(54,'2013-06-05 18:26:07','2013-06-05 18:26:07','2618','ISRO’ATUL LAILIAH');
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tahunajaran`
--

DROP TABLE IF EXISTS `tahunajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tahunajaran` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT 'N',
  `posisi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tahunajaran`
--

LOCK TABLES `tahunajaran` WRITE;
/*!40000 ALTER TABLE `tahunajaran` DISABLE KEYS */;
INSERT INTO `tahunajaran` VALUES (1,'2013-05-10 02:35:25','2013-05-16 10:15:37','2010 / 2011','N',1),(2,'2013-05-10 02:35:29','2013-06-05 13:29:47','2011 / 2012','N',2),(3,'2013-05-10 02:35:34','2013-06-05 13:29:49','2012 / 2013','N',3),(4,'2013-05-10 02:35:37','2013-06-05 13:29:49','2013 / 2014','Y',4),(5,'2013-06-06 08:00:14','2013-06-06 08:00:14','2014 - 2015','N',5);
/*!40000 ALTER TABLE `tahunajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transmasuk`
--

DROP TABLE IF EXISTS `transmasuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transmasuk` (
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transmasuk`
--

LOCK TABLES `transmasuk` WRITE;
/*!40000 ALTER TABLE `transmasuk` DISABLE KEYS */;
INSERT INTO `transmasuk` VALUES (1,'2013-06-10 08:17:17','2013-06-10 08:17:17','2013-06-10',4,1,'M'),(2,'2013-06-10 08:17:24','2013-06-10 08:17:24','2013-06-10',4,2,'M'),(3,'2013-06-10 08:17:32','2013-06-10 08:17:32','2013-06-10',4,3,'M'),(4,'2013-06-10 08:17:39','2013-06-10 08:17:39','2013-06-10',4,4,'M'),(5,'2013-06-10 08:17:47','2013-06-10 08:17:47','2013-06-10',4,5,'M'),(6,'2013-06-14 06:34:58','2013-06-14 06:34:58','2013-06-14',4,1,'M'),(7,'2013-06-14 06:37:24','2013-06-14 06:37:24','2013-06-14',4,2,'M'),(8,'2013-06-14 06:40:17','2013-06-14 06:40:17','2013-06-14',4,1,'M'),(9,'2013-06-14 06:42:42','2013-06-14 06:42:42','2013-06-14',4,3,'M'),(10,'2013-06-14 06:45:37','2013-06-14 06:45:37','2013-06-14',4,4,'M'),(11,'2013-06-14 06:47:57','2013-06-14 06:47:57','2013-06-14',4,5,'M'),(12,'2013-06-14 06:49:40','2013-06-14 06:49:40','2013-06-14',4,6,'M'),(13,'2013-06-14 06:57:37','2013-06-14 06:57:37','2013-06-14',4,9,'M'),(14,'2013-06-14 07:01:27','2013-06-14 07:01:27','2013-06-14',4,10,'M'),(15,'2013-06-14 07:02:40','2013-06-14 07:02:40','2013-06-14',4,11,'M'),(16,'2013-06-14 07:04:28','2013-06-14 07:04:28','2013-06-14',4,12,'M'),(17,'2013-06-14 07:10:13','2013-06-14 07:10:13','2013-06-14',4,13,'M'),(18,'2013-06-14 07:12:16','2013-06-14 07:12:16','2013-06-14',4,14,'M'),(19,'2013-06-14 07:20:33','2013-06-14 07:20:33','2013-06-14',4,15,'M');
/*!40000 ALTER TABLE `transmasuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'eries','$2a$08$bcRj9c3qXX8psBEp9PpNtemSVQOfOlgQwmMTm2d9XLO/WNI/zgUxC','c9f169ae899b5f1f2d0f9277d639698b','eries@simas.ad',1,0,0,'2013-06-12 08:44:01','2013-06-12 08:46:34'),(2,'admin','$2a$08$Afz2r1HFDMA8cSoo6GwkCOlAQSHGMMNdO31aDenx10iUfKiANITHO','8ba5d18b4cd2b70626a912a775f94658','admin@simas.ad',1,0,0,'2013-06-12 08:47:50','2013-06-12 08:47:50'),(3,'herman','$2a$08$L5SjKTK.9uukZPhRd6uWAubwpBGkuIuLVVwRE6eQK/1nvvTYaJlKa','76651a8c50b44b4c7c727a165ecc90b8','herman@simas.ad',1,0,0,'2013-06-12 08:49:05','2013-06-12 08:49:05'),(4,'akbar','$2a$08$dNoMm4wkxsuBjLvxtxJJdOTffcJdyXkTSRYMcTSyXvdirdAD8yUwC','ce163ab6ddd289af214f5c972d49fb44','akbar@simas.ad',1,0,0,'2013-06-12 08:49:16','2013-06-12 08:49:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vsiswa`
--

DROP TABLE IF EXISTS `vsiswa`;
/*!50001 DROP VIEW IF EXISTS `vsiswa`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vsiswa` (
  `id` tinyint NOT NULL,
  `tahunajaran_id` tinyint NOT NULL,
  `tahunajaran` tinyint NOT NULL,
  `rombel_id` tinyint NOT NULL,
  `rombel` tinyint NOT NULL,
  `jenjang` tinyint NOT NULL,
  `siswa_id` tinyint NOT NULL,
  `siswa` tinyint NOT NULL,
  `nisn` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vtransmasuk`
--

DROP TABLE IF EXISTS `vtransmasuk`;
/*!50001 DROP VIEW IF EXISTS `vtransmasuk`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vtransmasuk` (
  `id` tinyint NOT NULL,
  `created_at` tinyint NOT NULL,
  `updated_at` tinyint NOT NULL,
  `tanggal` tinyint NOT NULL,
  `arus` tinyint NOT NULL,
  `tahunajaran_id` tinyint NOT NULL,
  `tahunajaran` tinyint NOT NULL,
  `siswa_id` tinyint NOT NULL,
  `nisn` tinyint NOT NULL,
  `siswa` tinyint NOT NULL,
  `detil_id` tinyint NOT NULL,
  `jenisbiaya_id` tinyint NOT NULL,
  `jenisbiaya` tinyint NOT NULL,
  `tipe` tinyint NOT NULL,
  `bulan_id` tinyint NOT NULL,
  `bulan` tinyint NOT NULL,
  `posisi` tinyint NOT NULL,
  `ket` tinyint NOT NULL,
  `jumlah` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vsiswa`
--

/*!50001 DROP TABLE IF EXISTS `vsiswa`*/;
/*!50001 DROP VIEW IF EXISTS `vsiswa`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vsiswa` AS select `rs`.`id` AS `id`,`rs`.`tahunajaran_id` AS `tahunajaran_id`,`t`.`nama` AS `tahunajaran`,`rs`.`rombel_id` AS `rombel_id`,`r`.`nama` AS `rombel`,`r`.`jenjang` AS `jenjang`,`rs`.`siswa_id` AS `siswa_id`,`s`.`nama` AS `siswa`,`s`.`nisn` AS `nisn` from (((`rombelsiswa` `rs` join `siswa` `s` on((`rs`.`siswa_id` = `s`.`id`))) join `rombel` `r` on((`rs`.`rombel_id` = `r`.`id`))) join `tahunajaran` `t` on((`rs`.`tahunajaran_id` = `t`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vtransmasuk`
--

/*!50001 DROP TABLE IF EXISTS `vtransmasuk`*/;
/*!50001 DROP VIEW IF EXISTS `vtransmasuk`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vtransmasuk` AS select `tm`.`id` AS `id`,`tm`.`created_at` AS `created_at`,`tm`.`updated_at` AS `updated_at`,`tm`.`tanggal` AS `tanggal`,`tm`.`arus` AS `arus`,`tm`.`tahunajaran_id` AS `tahunajaran_id`,`ta`.`nama` AS `tahunajaran`,`tm`.`siswa_id` AS `siswa_id`,`sw`.`nisn` AS `nisn`,`sw`.`nama` AS `siswa`,`dtm`.`id` AS `detil_id`,`dtm`.`jenisbiaya_id` AS `jenisbiaya_id`,`jb`.`nama` AS `jenisbiaya`,`jb`.`tipe` AS `tipe`,`dtm`.`bulan_id` AS `bulan_id`,`bl`.`nama` AS `bulan`,`bl`.`posisi` AS `posisi`,`dtm`.`ket` AS `ket`,`dtm`.`jumlah` AS `jumlah` from (((((`transmasuk` `tm` join `detiltransmasuk` `dtm` on((`dtm`.`transmasuk_id` = `tm`.`id`))) join `jenisbiaya` `jb` on((`dtm`.`jenisbiaya_id` = `jb`.`id`))) left join `siswa` `sw` on((`tm`.`siswa_id` = `sw`.`id`))) left join `bulan` `bl` on((`dtm`.`bulan_id` = `bl`.`id`))) join `tahunajaran` `ta` on((`tm`.`tahunajaran_id` = `ta`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-14 10:43:19
