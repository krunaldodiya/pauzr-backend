# ************************************************************
# Sequel Pro SQL dump
# Version 5438
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.15)
# Database: pauzr
# Generation Time: 2019-03-25 13:44:07 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `parent_id`, `name`, `created_at`, `updated_at`)
VALUES
	(101,0,'Electronics','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(102,101,'Cameras & Accessories','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(103,101,'Audio, Video & Home Entertainment','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(104,101,'Computer Accessories','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(105,101,'Laptops and  Desktops','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(106,101,'Mobile & Tablets','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(107,101,'Mobiles & Tablet Accessories','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(108,101,'Televisions','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(109,0,'Fashion','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(110,109,'Fashion Accessories','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(111,109,'Clothing','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(112,109,'Jewellery','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(113,109,'Nightwear & Lingerie','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(114,109,'Sunglasses & Contact Lens','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(115,109,'Watches','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(116,109,'Footwear','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(117,109,'Luggage & Bags','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(118,0,'Baby & Kids','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(119,118,'Baby Footwear','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(120,118,'Baby Care','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(121,118,'Baby & Kids Clothing','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(122,118,'Diapering','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(123,118,'Baby & Kids Fashion Accessories','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(124,118,'Toys','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(125,0,'Home & Kitchen','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(126,125,'Furniture','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(127,125,'Home Decor & Furnishing','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(128,125,'Home Appliances','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(129,125,'Kitchen Appliances','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(130,125,'Kitchenware & Dinnerware','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(131,0,'Beauty, Personal & Health Care','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(132,131,'Beauty & Personal Care','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(133,131,'Perfumes & Deodorants','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(134,131,'Personal Grooming Appliances','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(135,131,'Sports & Fitness Equipment','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(136,131,'Medicine & Health Supplement','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(137,131,'Health Care Devices','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(138,0,'Recharge & Bill Payment','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(139,138,'Mobile, DTH Recharge','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(140,138,'Bill Payment','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(141,0,'Travel','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(142,141,'Bus','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(143,141,'Flights','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(144,141,'Holiday Packages','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(145,141,'Hotels','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(146,141,'Cab & Auto','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(147,0,'Grocery, Food & Beverages','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(148,147,'Food & Beverages','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(149,147,'Chocolates, Cakes & Sweets','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(150,147,'Restaurants','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(151,147,'Grocery','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(152,0,'Office Supplies & Stationaries','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(153,152,'Education And Stationaries','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(154,152,'Books','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(155,152,'Office Supplies','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(156,152,'Custom Products','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(157,0,'Entertainment, Media & Software','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(158,157,'Music, Movies and Ticket Booking','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(159,157,'Web Hosting & Domains','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(160,157,'Software','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(161,157,'Games & Entertainment','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(162,0,'Flowers & Gift Cards','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(163,162,'Gifts & Flowers','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(164,162,'Gift Cards','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(165,0,'Others','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(166,165,'Automotive','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(167,165,'Business','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(168,165,'Wallet & Payment Gateways','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(169,165,'Gardening Products','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(170,165,'General Services','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(171,165,'Industrial Supplies','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(172,165,'Animals & Pet Supplies','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(173,0,'Bank Specific Offers','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(174,173,'HDFC Bank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(175,173,'ICICI Bank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(176,173,'SBI Card','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(177,173,'AXIS Bank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(178,173,'Citibank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(179,173,'Kotak Bank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(180,173,'American Express Bank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(181,173,'Deutsche Bank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(182,173,'IndusInd Bank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(183,173,'Standard Chartered','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(184,173,' Yes Bank','2019-03-03 06:33:43','2019-03-03 06:33:43'),
	(185,0,'Most Used','2019-03-25 19:12:29','2019-03-25 19:12:29');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
