# ************************************************************
# Sequel Pro SQL dump
# Version 5446
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.16)
# Database: pauzr
# Generation Time: 2019-07-28 16:44:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table quotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `quotes`;

CREATE TABLE `quotes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `type` enum('quote','ad') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `quotes` WRITE;
/*!40000 ALTER TABLE `quotes` DISABLE KEYS */;

INSERT INTO `quotes` (`id`, `author`, `title`, `image`, `order`, `type`, `created_at`, `updated_at`)
VALUES
	(20,'','','ktXbFpwEGqdrJt9o2DFhNDX6NYQIXQGAwvlh7lcN.jpeg',1,'ad','2019-07-28 00:51:32','2019-07-28 08:46:42'),
	(21,'','','HZ2UfnrXZubANIXbzpitToOXV3CYugolQ7fHR3rX.jpeg',2,'ad','2019-07-28 00:51:42','2019-07-28 01:08:07'),
	(22,'','','JXm8HwrkVaBN0OvvgL2D4wek6xxtYflM60aDhtVq.jpeg',3,'ad','2019-07-28 00:51:53','2019-07-28 01:07:46'),
	(23,'','','27KBaLuhkpuvPf1wBASQ8qtv3TaWN5jCga0rac8l.jpeg',4,'ad','2019-07-28 00:52:02','2019-07-28 01:07:24'),
	(24,'','','0mbnJtJXpgEARZ7n5CpJFDWPNckfQlZd55eeeqmJ.jpeg',5,'ad','2019-07-28 00:52:13','2019-07-28 01:07:00'),
	(25,'','','fNIvtlhZY8zRVKfdRh55y4Ip4XT5toPNz1iG54u0.jpeg',6,'ad','2019-07-28 00:52:26','2019-07-28 01:06:35'),
	(26,'','','61lzlkSanFoSAhBOnBTI6YyxgyPt5uV1dc4gOeYb.jpeg',7,'ad','2019-07-28 00:52:39','2019-07-28 01:05:57'),
	(27,'','','gaioTuglA7ZkXJDSKfDZZmFwxFHsuQ6oLHLaYbl6.jpeg',8,'ad','2019-07-28 00:52:53','2019-07-28 01:05:21'),
	(28,NULL,NULL,'88JnK85K3PT8x67Z80esGU1XTL6uDKbuc90AuDj8.jpeg',9,'ad','2019-07-28 21:07:00','2019-07-28 21:07:00'),
	(29,NULL,NULL,'ZcfoxIVmWtWGAdILlld4fzgzl4Qo5KzsuSlW599O.jpeg',10,'ad','2019-07-28 21:07:11','2019-07-28 21:07:11'),
	(30,NULL,NULL,'v71uAE0IxYKjxXqHAnTSx70RMuuLsCCAiLwG9kVc.jpeg',11,'ad','2019-07-28 21:07:20','2019-07-28 21:07:20'),
	(31,NULL,NULL,'ENpyNC1THCp6sOn9OCmawM9WoSyP4vcnbZhchqWv.jpeg',12,'ad','2019-07-28 21:07:29','2019-07-28 21:07:29'),
	(32,NULL,NULL,'A8N9ncKB2yNFr5FHgew6sAd8JA8p9bRZWHoRS91h.jpeg',13,'ad','2019-07-28 21:07:39','2019-07-28 21:07:39'),
	(33,NULL,NULL,'jPzwScDAbvPI4OYwGisIryfLQK8yj5kZphcKZLPG.jpeg',15,'ad','2019-07-28 21:07:51','2019-07-28 21:07:51'),
	(34,NULL,NULL,'pMuSo0C9ADpLiwdmGZSfLz4TQfChDWhtMYIDDeiH.jpeg',14,'ad','2019-07-28 21:08:23','2019-07-28 21:08:23');

/*!40000 ALTER TABLE `quotes` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
