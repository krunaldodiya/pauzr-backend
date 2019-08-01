# ************************************************************
# Sequel Pro SQL dump
# Version 5446
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.16)
# Database: pauzr
# Generation Time: 2019-08-01 04:50:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar',
  `default` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `user_id`, `url`, `description`, `type`, `default`, `created_at`, `updated_at`)
VALUES
	(2,2,'https://res.cloudinary.com/pauzrapp/image/upload/v1564472105/f8katxm9vg8ot7nbh0wg.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(4,6,'https://res.cloudinary.com/pauzrapp/image/upload/v1564380097/n7lbd0hzhwyndzqodqxk.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(24,106,'https://res.cloudinary.com/pauzrapp/image/upload/v1564047630/bvzgbpvqstltkuh36km7.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(27,129,'https://res.cloudinary.com/pauzrapp/image/upload/v1564426039/rntxbjnpdvv0qjxahjgs.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(35,197,'https://res.cloudinary.com/pauzrapp/image/upload/v1564364957/ikfpm6h3stxdqekcu3fl.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(44,373,'https://res.cloudinary.com/pauzrapp/image/upload/v1563809124/f6e1ccfyhofp9k81vton.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(45,374,'https://res.cloudinary.com/pauzrapp/image/upload/v1563811765/bctguz6xxvftnzadohyy.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(46,376,'https://res.cloudinary.com/pauzrapp/image/upload/v1563883691/hkbolxva1zbimqpwpemn.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(47,377,'https://res.cloudinary.com/pauzrapp/image/upload/v1563847656/xnlkde1fvjvb6lgq2fut.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(48,391,'https://res.cloudinary.com/pauzrapp/image/upload/v1563885436/dwbbnwh1u10c0ngcrwl1.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(49,405,'https://res.cloudinary.com/pauzrapp/image/upload/v1563872204/mrapead5ibx8q1ynb7ec.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(50,446,'https://res.cloudinary.com/pauzrapp/image/upload/v1564108901/lzlupmxserufus5hjznn.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(51,451,'https://res.cloudinary.com/pauzrapp/image/upload/v1564369046/jlxnh18jwzycsxcaz2ei.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(52,452,'https://res.cloudinary.com/pauzrapp/image/upload/v1564117087/c2qh1avmvxhz874rdxne.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(53,456,'https://res.cloudinary.com/pauzrapp/image/upload/v1564457019/mptzpcy128x3qmdmylq9.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(54,457,'https://res.cloudinary.com/pauzrapp/image/upload/v1564125323/ldvbzhcsv1ozqyvc6mz3.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(55,501,'https://res.cloudinary.com/pauzrapp/image/upload/v1564448469/qjybhjbqiwdqhqzg1j6t.jpg',NULL,'avatar',1,'2019-07-30 13:38:00','2019-07-30 13:38:00'),
	(57,1,'https://res.cloudinary.com/pauzrapp/image/upload/v1564475796/exfmhfyye3wxctdy3wbq.jpg',NULL,'avatar',0,'2019-07-30 14:06:36','2019-08-01 10:06:27'),
	(59,1,'https://res.cloudinary.com/pauzrapp/image/upload/v1564497383/lfdahiijsskctc4rlz87.jpg',NULL,'avatar',0,'2019-07-30 20:06:23','2019-08-01 10:06:27'),
	(60,1,'https://res.cloudinary.com/pauzrapp/image/upload/v1564498179/a8bctwzsdujynsu3eofs.jpg',NULL,'post',0,'2019-07-30 20:19:39','2019-07-30 20:19:39'),
	(61,1,'https://res.cloudinary.com/pauzrapp/image/upload/v1564498260/hpyva60mvplfmplzxpi4.jpg',NULL,'post',0,'2019-07-30 20:21:00','2019-07-30 20:21:00'),
	(63,1,'https://res.cloudinary.com/pauzrapp/image/upload/v1564498713/gyevbde3re7azativ0r2.jpg',NULL,'avatar',0,'2019-07-30 20:28:34','2019-08-01 10:06:27'),
	(65,1,'https://res.cloudinary.com/pauzrapp/image/upload/v1564503261/c2xih2g1gjfgkx4xzloj.jpg',NULL,'post',0,'2019-07-30 21:44:22','2019-07-30 21:44:22'),
	(66,1,'https://res.cloudinary.com/pauzrapp/image/upload/v1564504485/yvt0ih9l3muov7uc5hv2.jpg',NULL,'post',0,'2019-07-30 22:04:45','2019-07-30 22:04:45'),
	(67,518,'https://res.cloudinary.com/pauzrapp/image/upload/v1564507719/sl25vurlhcbfvi6t6cu2.jpg',NULL,'avatar',1,'2019-07-30 22:58:39','2019-07-30 22:58:39'),
	(68,194,'https://res.cloudinary.com/pauzrapp/image/upload/v1564538408/jj63l476kvqybixom6gw.jpg',NULL,'avatar',1,'2019-07-31 07:30:08','2019-07-31 07:30:08'),
	(70,2,'https://res.cloudinary.com/pauzrapp/image/upload/v1564571344/jwwfgd5lp1nbmlhtfzvd.jpg',NULL,'post',0,'2019-07-31 16:39:04','2019-07-31 16:39:04'),
	(71,1,'https://res.cloudinary.com/pauzrapp/image/upload/v1564634186/s7ozkfmy8al1pfzcfpft.jpg',NULL,'avatar',1,'2019-08-01 10:06:27','2019-08-01 10:06:27');

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
