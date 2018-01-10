-- --------------------------------------------------------
-- Host                          :127.0.0.1
-- Server version                :5.5.27 - MySQL Community Server (GPL)
-- Server OS                     :Win32
-- HeidiSQL Version              :7.0.0.4304
-- Created                       :2013-07-10 11:11:34
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

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
  CONSTRAINT `FK__tahunajaran_target` FOREIGN KEY (`tahunajaran_id`) REFERENCES `tahunajaran` (`id`),
  CONSTRAINT `FK__jenisbiaya_target` FOREIGN KEY (`jenisbiaya_id`) REFERENCES `jenisbiaya` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
