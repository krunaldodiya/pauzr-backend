# ************************************************************
# Sequel Pro SQL dump
# Version 5438
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.15)
# Database: pauzr
# Generation Time: 2019-06-11 11:32:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table levels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `levels`;

CREATE TABLE `levels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;

INSERT INTO `levels` (`id`, `level`, `points`, `created_at`, `updated_at`)
VALUES
	(1,0,0,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(2,1,30,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(3,2,60,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(4,3,100,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(5,4,160,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(6,5,260,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(7,6,410,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(8,7,610,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(9,8,880,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(10,9,1230,'2019-06-10 09:00:28','2019-06-10 09:00:28'),
	(11,10,1630,'2019-06-10 09:00:28','2019-06-10 09:00:28');

/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
