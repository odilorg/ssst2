-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: ssst2
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `amenities`
--

DROP TABLE IF EXISTS `amenities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `amenities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `amenities`
--

LOCK TABLES `amenities` WRITE;
/*!40000 ALTER TABLE `amenities` DISABLE KEYS */;
INSERT INTO `amenities` VALUES (1,'2025-01-10 16:43:28','2025-01-10 16:43:28','A/C'),(2,'2025-01-11 05:48:59','2025-01-11 05:48:59','TV'),(3,'2025-01-11 05:49:13','2025-01-11 05:49:13','Air Condition'),(4,'2025-01-11 05:49:44','2025-01-11 05:49:44','WiFi'),(5,'2025-01-11 06:09:01','2025-01-11 06:09:01','Garden'),(6,'2025-01-11 06:09:45','2025-01-11 06:09:45','Terrace'),(7,'2025-01-13 10:04:08','2025-01-13 10:04:08','swimming pool');
/*!40000 ALTER TABLE `amenities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `amenity_room`
--

DROP TABLE IF EXISTS `amenity_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `amenity_room` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amenity_id` bigint unsigned NOT NULL,
  `room_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `amenity_room_amenity_id_foreign` (`amenity_id`),
  KEY `amenity_room_room_id_foreign` (`room_id`),
  CONSTRAINT `amenity_room_amenity_id_foreign` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `amenity_room_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `amenity_room`
--

LOCK TABLES `amenity_room` WRITE;
/*!40000 ALTER TABLE `amenity_room` DISABLE KEYS */;
INSERT INTO `amenity_room` VALUES (2,NULL,NULL,1,3),(3,NULL,NULL,3,5),(4,NULL,NULL,2,5),(5,NULL,NULL,4,5),(6,NULL,NULL,6,6),(7,NULL,NULL,2,6),(8,NULL,NULL,4,6),(9,NULL,NULL,3,6),(10,NULL,NULL,3,7),(11,NULL,NULL,6,7),(12,NULL,NULL,4,7),(13,NULL,NULL,2,7),(14,NULL,NULL,3,8),(15,NULL,NULL,5,8),(16,NULL,NULL,6,8),(17,NULL,NULL,2,8),(18,NULL,NULL,4,8),(19,NULL,NULL,2,9),(20,NULL,NULL,4,9),(21,NULL,NULL,3,9),(22,NULL,NULL,3,10),(23,NULL,NULL,2,10),(24,NULL,NULL,4,10),(25,NULL,NULL,3,11),(26,NULL,NULL,2,11),(27,NULL,NULL,4,11),(28,NULL,NULL,3,12),(29,NULL,NULL,2,12),(30,NULL,NULL,4,12),(31,NULL,NULL,3,13),(32,NULL,NULL,2,13),(33,NULL,NULL,4,13),(34,NULL,NULL,3,14),(35,NULL,NULL,2,14),(36,NULL,NULL,4,14),(37,NULL,NULL,2,15),(38,NULL,NULL,4,15),(39,NULL,NULL,3,15),(40,NULL,NULL,3,16),(41,NULL,NULL,2,16),(42,NULL,NULL,4,16),(43,NULL,NULL,3,17),(44,NULL,NULL,2,17),(45,NULL,NULL,4,17),(46,NULL,NULL,3,18),(47,NULL,NULL,6,18),(48,NULL,NULL,2,18),(49,NULL,NULL,4,18),(50,NULL,NULL,3,19),(51,NULL,NULL,2,19),(52,NULL,NULL,4,19);
/*!40000 ALTER TABLE `amenity_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('jahongir_app_cache_6cb167b6ae9d2f2e473d029e2ed51da0cabd815f','i:1;',1736605217),('jahongir_app_cache_6cb167b6ae9d2f2e473d029e2ed51da0cabd815f:timer','i:1736605217;',1736605217),('jahongir_app_cache_da4b9237bacccdf19c0760cab7aec4a8359010b0','i:1;',1736768320),('jahongir_app_cache_da4b9237bacccdf19c0760cab7aec4a8359010b0:timer','i:1736768320;',1736768320),('jahongir_app_cache_fb3a2b083b2149c6e18db7f7e161e9151950a2cb','i:1;',1736767803),('jahongir_app_cache_fb3a2b083b2149c6e18db7f7e161e9151950a2cb:timer','i:1736767803;',1736767803),('jahongir_app_cache_fd0b91afe999a0578b2e6522c2751d78fe201773','i:1;',1736591449),('jahongir_app_cache_fd0b91afe999a0578b2e6522c2751d78fe201773:timer','i:1736591449;',1736591449);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`),
  CONSTRAINT `cities_chk_1` CHECK (json_valid(`images`))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2,'2025-01-11 05:16:30','2025-01-11 05:52:58','Tashkent',NULL,'[]'),(3,'2025-01-11 05:16:47','2025-01-11 05:16:47','Samarkand',NULL,'[]'),(4,'2025-01-11 05:17:09','2025-01-11 05:39:03','Bukhara',NULL,'[]'),(5,'2025-01-11 05:17:35','2025-01-11 05:53:17','Khiva',NULL,'[]'),(6,'2025-01-11 05:54:14','2025-01-11 05:54:14','Shakhrisabz',NULL,'[]'),(7,'2025-01-11 05:54:38','2025-01-11 05:54:38','Navoiy',NULL,'[]'),(8,'2025-01-11 05:54:38','2025-01-11 05:54:38','Navoiy',NULL,'[]'),(9,'2025-01-11 05:55:01','2025-01-11 05:55:01','Fergana',NULL,'[]'),(10,'2025-01-11 05:55:19','2025-01-11 05:55:19','Nukus',NULL,'[]');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'2025-01-10 16:50:09','2025-01-10 16:50:09','Alain Migus','tolib71@mail.ru','+998902115854','Amir Timur 164/11'),(2,'2025-01-13 11:07:45','2025-01-13 11:07:45','Odil','odilorg@gmail.com','998915550808','Chiroqchi 11 '),(3,'2025-01-13 11:32:26','2025-01-13 11:32:26','GUANGZHOU  Aero Meng','aero_meng@gzl.com.cn','862086089947    8615017564445 ','1,Lejia Rd, jichang Rd West, Guangzhou, P.R. China Pc:510403');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `drivers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `drivers_phone_unique` (`phone`),
  UNIQUE KEY `drivers_email_unique` (`email`),
  UNIQUE KEY `drivers_license_number_unique` (`license_number`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drivers`
--

LOCK TABLES `drivers` WRITE;
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;
INSERT INTO `drivers` VALUES (1,'2025-01-13 11:15:40','2025-01-13 11:15:40','SHODMONOV  JAMSHID',NULL,'+998993120741',NULL,NULL,NULL,NULL,NULL),(2,'2025-01-13 11:18:02','2025-01-13 11:18:02','ESHONQULOV BAXODIR',NULL,'+998994160648',NULL,NULL,NULL,NULL,NULL),(3,'2025-01-13 11:36:24','2025-01-13 11:36:24','YUSUPOV XASAN',NULL,'+998902284056',NULL,'AD 6301731','27.02.2034','01JHFQ6QTG1JSFQ9AS5JSFH5RZ.jpg',NULL),(4,'2025-01-13 11:51:16','2025-01-13 11:51:16','QUVONDIQOV MUSOQUL',NULL,'+998 99 552 93 60',NULL,NULL,NULL,NULL,NULL),(5,'2025-01-13 11:52:06','2025-01-13 11:52:06','POLATOV OYNAZAR',NULL,'+998 93 239 99 95',NULL,NULL,NULL,NULL,NULL),(6,'2025-01-13 11:52:42','2025-01-13 11:52:42','ERGASHOV XALIMJON',NULL,'+998 97 927 96 70',NULL,NULL,NULL,NULL,NULL),(7,'2025-01-13 11:53:58','2025-01-13 11:53:58','SULAYMONOV G`IYOS',NULL,'+998 94 406 09 00',NULL,NULL,NULL,NULL,NULL),(8,'2025-01-13 11:54:42','2025-01-13 11:54:42','OMONOV ZOIR',NULL,'+998 94 240 83 97',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estimates`
--

DROP TABLE IF EXISTS `estimates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estimates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estimate_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimate_date` date NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `tour_id` bigint unsigned NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `estimates_estimate_number_unique` (`estimate_number`),
  KEY `fk_estimates_customer_id` (`customer_id`),
  KEY `fk_estimates_tour_id` (`tour_id`),
  CONSTRAINT `fk_estimates_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_estimates_tour_id` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estimates`
--

LOCK TABLES `estimates` WRITE;
/*!40000 ALTER TABLE `estimates` DISABLE KEYS */;
INSERT INTO `estimates` VALUES (1,'2025-01-10 16:50:25','2025-01-10 16:50:25','5656','2025-01-10',NULL,'estimate_1.pdf',1,1,'EST-2025-001'),(2,'2025-01-10 16:51:45','2025-01-10 16:51:45','781','1985-04-30','Deserunt adipisicing','estimate_2.pdf',1,1,'EST-2025-002'),(3,'2025-01-10 16:55:13','2025-01-10 16:55:13','582','1992-03-24','Dolor voluptas nulla','estimate_3.pdf',1,1,'EST-2025-003'),(4,'2025-01-13 11:08:51','2025-01-13 11:08:51','EST4012025','2025-01-15','mestniy ','estimate_4.pdf',2,2,'EST-2025-004'),(5,'2025-01-13 11:13:53','2025-01-13 11:13:53','EST5012025','2025-01-22',NULL,'estimate_5.pdf',2,2,'EST-2025-005'),(6,'2025-01-13 11:18:05','2025-01-13 11:18:05','EST6012025','1972-12-09','Quisquam quo laudant','estimate_6.pdf',1,3,'EST-2025-006'),(7,'2025-01-13 11:29:58','2025-01-13 11:29:58','EST7012025','1985-05-08','Ut et ipsam anim mol','estimate_7.pdf',1,4,'EST-2025-007'),(8,'2025-01-13 11:37:15','2025-01-13 11:37:15','EST8012025','2025-01-10',NULL,'estimate_8.pdf',1,5,'EST-2025-008'),(9,'2025-01-13 11:38:50','2025-01-13 11:38:50','EST9012025','2020-01-10','Sunt quia rerum adip','estimate_9.pdf',1,5,'EST-2025-009'),(10,'2025-01-13 11:42:46','2025-01-13 11:42:46','EST10012025','2012-10-09','At consequatur eu a','estimate_10.pdf',1,5,'EST-2025-010'),(11,'2025-01-13 11:43:52','2025-01-13 11:43:52','EST11012025','1982-09-03','Atque sapiente obcae','estimate_11.pdf',1,5,'EST-2025-011');
/*!40000 ALTER TABLE `estimates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guide_spoken_language`
--

DROP TABLE IF EXISTS `guide_spoken_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guide_spoken_language` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guide_id` bigint unsigned NOT NULL,
  `spoken_language_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `guide_spoken_language_guide_id_foreign` (`guide_id`),
  KEY `guide_spoken_language_spoken_language_id_foreign` (`spoken_language_id`),
  CONSTRAINT `guide_spoken_language_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guide_spoken_language_spoken_language_id_foreign` FOREIGN KEY (`spoken_language_id`) REFERENCES `spoken_languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guide_spoken_language`
--

LOCK TABLES `guide_spoken_language` WRITE;
/*!40000 ALTER TABLE `guide_spoken_language` DISABLE KEYS */;
INSERT INTO `guide_spoken_language` VALUES (1,'2025-01-10 16:42:19','2025-01-10 16:42:19',1,1),(2,'2025-01-13 11:44:48','2025-01-13 11:44:48',2,6),(3,'2025-01-13 11:44:48','2025-01-13 11:44:48',2,2);
/*!40000 ALTER TABLE `guide_spoken_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guides`
--

DROP TABLE IF EXISTS `guides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guides` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_marketing` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guides`
--

LOCK TABLES `guides` WRITE;
/*!40000 ALTER TABLE `guides` DISABLE KEYS */;
INSERT INTO `guides` VALUES (1,'English',45.00,'2025-01-10 16:42:19','2025-01-10 16:42:19',1,NULL,NULL,NULL,NULL,NULL),(2,'KAZAKOV AKBAR',80.00,'2025-01-13 11:44:48','2025-01-13 11:44:48',0,'+998979192900','akbar@yahoo.com','BAM','Samarkand','01JHFQP4TND6JJGP3VREAH9H95.jpg');
/*!40000 ALTER TABLE `guides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotels`
--

DROP TABLE IF EXISTS `hotels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hotels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` enum('bed_breakfast','3_star','4_star','5_star') COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('bed_breakfast','3_star','4_star','5_star') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotels`
--

LOCK TABLES `hotels` WRITE;
/*!40000 ALTER TABLE `hotels` DISABLE KEYS */;
INSERT INTO `hotels` VALUES (2,'Shamsan',NULL,'2025-01-11 05:20:40','2025-01-11 05:20:40','bed_breakfast','4_star',2,'Dlya Kitay','+998909078844','book@shamsan.uz',NULL,'[]'),(3,'Bentley Hotel','2A Mirzakalon Ismoiliy Street, Tashkent/Uzbekistan','2025-01-11 06:00:36','2025-01-11 06:00:36','bed_breakfast','4_star',2,'Bentley Tashkent Hotel consists of 62 comfortable and well equipped rooms, an upscale restaurant, conference and meeting rooms, a swimming pool, gym, spa and wellness center.','998 95 255 00 11','sales@bentleyhotel.uz',NULL,'[\"01JH9Z6DY97BYW19V8324KGZNX.jpg\"]'),(4,'Avant Hotel','Askiya Street 12, Tashkent','2025-01-11 06:16:23','2025-01-11 06:16:23','bed_breakfast','3_star',2,'Early check-in:\n00:00 - 06:59: 100% from the cost per night\n07:00 - 11:59: 50% from the cost per night\nLate check-out:\n14:00 - 17:59: 50% from the cost per night\n18:00 - 23:59: 100% from the cost per night','998 55 517 50 00',' avantterracehotel@gmail.com 24/7',NULL,'[\"01JHA03ASYF347KZJB1201MH87.jpg\"]'),(5,'Holiday Inn Tashkent City',' 3 Ukchi street Tashkent, 100017 Uzbekistan','2025-01-13 07:13:24','2025-01-13 07:13:24','bed_breakfast','4_star',2,NULL,'+99871 205 20 00','reservation@hitc.uz',NULL,'[]'),(6,'Royal Sebzor Hotel','г. Ташкент, Ул. Тахтапуль, 41','2025-01-13 09:40:48','2025-01-13 09:40:48','bed_breakfast','4_star',2,'до 18:00 бесплатная отмена бронирования','+99899 188 71 10','royal.sebzor@gmail.com',NULL,'[\"01JHFGK2SMSTWSY1W10AAXK4RN.webp\"]'),(7,'Europe Hotel Tashkent','\"Shohjahon 58, 100100, Tashkent   4.2 км до центра города\"	','2025-01-13 09:52:00','2025-01-13 09:52:00','bed_breakfast','3_star',2,NULL,'+99897 330 88 88','book@europehotel.uz',NULL,'[\"01JHFH7K89W8AWGF6PBPY8C3GW.jpg\"]'),(8,'Marwa Hotel Tasgkent','Uzbekistan, Tashkent, Almazar district, 12 Lyangar street','2025-01-13 11:03:38','2025-01-13 11:03:38','bed_breakfast','3_star',2,NULL,'+998995207007','marwahoteltashkent@gmail.com',NULL,'[\"01JHFNARCDM76SJW1PB16Q7SNV.webp\"]'),(9,'Al Anvar Hotel','г. Ташкент, ул. Юсуф Хос Ходжиба, д. 65','2025-01-13 11:09:04','2025-01-13 11:09:04','bed_breakfast','4_star',2,NULL,'+998995120660','sales@alanvarhotel.uz',NULL,'[\"01JHFNMP5YY379KXG6XESWTRAQ.webp\"]'),(10,'Gabrielle INTERNATIONAL','43 Shota Rustaveli, street, Tashkent, Uzbekistan','2025-01-13 11:17:20','2025-01-13 11:17:20','bed_breakfast','3_star',2,NULL,'+998 (71) 255-91-19','@gabrielle.com',NULL,'[\"01JHFP3V2TYJASCQ5Y8Q29M9F9.jpg\"]'),(11,'City  Palace','Amir Temur Street 15, 100000, Tashkent','2025-01-13 11:50:50','2025-01-13 11:50:50','bed_breakfast','5_star',2,NULL,'+99855 511-30-00','info@citypal',NULL,'[\"01JHFR15ZCWB6S1F8CXX0PTSVA.jpg\"]');
/*!40000 ALTER TABLE `hotels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meal_type_restaurant_tour_days`
--

DROP TABLE IF EXISTS `meal_type_restaurant_tour_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meal_type_restaurant_tour_days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meal_type_id` bigint unsigned NOT NULL,
  `restaurant_id` bigint unsigned NOT NULL,
  `tour_day_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_meal_type_restaurant_tour_days_meal_type_id` (`meal_type_id`),
  KEY `fk_meal_type_restaurant_tour_days_restaurant_id` (`restaurant_id`),
  KEY `fk_meal_type_restaurant_tour_days_tour_day_id` (`tour_day_id`),
  CONSTRAINT `fk_meal_type_restaurant_tour_days_meal_type_id` FOREIGN KEY (`meal_type_id`) REFERENCES `meal_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_meal_type_restaurant_tour_days_restaurant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_meal_type_restaurant_tour_days_tour_day_id` FOREIGN KEY (`tour_day_id`) REFERENCES `tour_days` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meal_type_restaurant_tour_days`
--

LOCK TABLES `meal_type_restaurant_tour_days` WRITE;
/*!40000 ALTER TABLE `meal_type_restaurant_tour_days` DISABLE KEYS */;
INSERT INTO `meal_type_restaurant_tour_days` VALUES (2,'2025-01-13 11:06:04','2025-01-13 11:06:04',3,2,2),(3,'2025-01-13 11:06:04','2025-01-13 11:06:04',5,4,3);
/*!40000 ALTER TABLE `meal_type_restaurant_tour_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meal_types`
--

DROP TABLE IF EXISTS `meal_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meal_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restaurant_id` bigint unsigned NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `name` enum('breakfast','lunch','dinner','coffee_break') COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_images` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_meal_types_restaurant_id` (`restaurant_id`),
  CONSTRAINT `fk_meal_types_restaurant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meal_types`
--

LOCK TABLES `meal_types` WRITE;
/*!40000 ALTER TABLE `meal_types` DISABLE KEYS */;
INSERT INTO `meal_types` VALUES (2,'2025-01-11 05:26:29','2025-01-13 11:23:42','3 salads , 1st and 2nd meals, drinks',2,10.00,'lunch',NULL),(3,'2025-01-11 05:26:29','2025-01-13 11:23:42','3 salads , meal, drinks',2,10.00,'dinner',NULL),(4,'2025-01-11 06:20:23','2025-01-13 11:22:51','3 salads, 1st meal, 2nd meal',3,10.00,'lunch',NULL),(5,'2025-01-11 06:22:54','2025-01-13 11:28:08','3 salads, 1st and 2nd meals, drinks',4,10.00,'lunch',NULL),(6,'2025-01-13 10:15:04','2025-01-13 10:15:04','3 salads, 1st and 2nd meals',5,10.00,'lunch',NULL),(7,'2025-01-13 10:19:49','2025-01-13 10:19:49','3 salads, 1st and 2nd meals',6,10.00,'dinner',NULL),(8,'2025-01-13 10:25:36','2025-01-13 10:25:36','3 salads, 1st and 2nd meals,drinks',7,10.00,'lunch',NULL),(9,'2025-01-13 10:43:25','2025-01-13 10:43:25','3 salads, 1st and 2nd meal',8,10.00,'lunch',NULL),(10,'2025-01-13 10:43:27','2025-01-13 10:43:27','3 salads, 1st and 2nd meal',9,10.00,'lunch',NULL),(11,'2025-01-13 10:52:15','2025-01-13 10:52:15','3 salads, 1st and 2nd meals',10,10.00,'lunch',NULL),(12,'2025-01-13 11:04:20','2025-01-13 11:28:08','3 salad,  2-meal drinks',4,10.00,'dinner',NULL);
/*!40000 ALTER TABLE `meal_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_01_11_035613_add_cols_to_guides_table',1),(2,'2025_01_11_043128_add_cols_to_hotels_table',1),(3,'2025_01_11_120520_add_menu_image_to_meal_types_table',2),(4,'2025_01_11_122220_create_drivers_table',2),(5,'2025_01_11_123043_add_driver_id_to_transports_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monument_tour_days`
--

DROP TABLE IF EXISTS `monument_tour_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monument_tour_days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `monument_id` bigint unsigned NOT NULL,
  `tour_day_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `monument_tour_days_monument_id_foreign` (`monument_id`),
  KEY `monument_tour_days_tour_day_id_foreign` (`tour_day_id`),
  CONSTRAINT `monument_tour_days_monument_id_foreign` FOREIGN KEY (`monument_id`) REFERENCES `monuments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `monument_tour_days_tour_day_id_foreign` FOREIGN KEY (`tour_day_id`) REFERENCES `tour_days` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monument_tour_days`
--

LOCK TABLES `monument_tour_days` WRITE;
/*!40000 ALTER TABLE `monument_tour_days` DISABLE KEYS */;
INSERT INTO `monument_tour_days` VALUES (2,NULL,NULL,2,2),(3,NULL,NULL,10,2),(4,NULL,NULL,9,3),(5,NULL,NULL,2,4),(6,NULL,NULL,10,4),(7,NULL,NULL,9,4),(8,NULL,NULL,2,5),(9,NULL,NULL,11,6);
/*!40000 ALTER TABLE `monument_tour_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monuments`
--

DROP TABLE IF EXISTS `monuments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monuments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_price` decimal(8,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `city_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_monuments_city_id` (`city_id`),
  CONSTRAINT `fk_monuments_city_id` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  CONSTRAINT `monuments_chk_1` CHECK (json_valid(`images`))
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monuments`
--

LOCK TABLES `monuments` WRITE;
/*!40000 ALTER TABLE `monuments` DISABLE KEYS */;
INSERT INTO `monuments` VALUES (1,'2025-01-10 16:43:53','2025-01-11 06:14:40','Registan',6.00,'The Registan (Uzbek: Регистон, Registon) was the heart of the city of Samarkand of the Timurid Empire, now in Uzbekistan. The name Rēgistan (ریگستان) means \"sandy place\" or \"desert\" in Persian.\n\nThe Registan was a public square, where people gathered to hear royal proclamations, heralded by blasts on enormous copper pipes called dzharchis — and a place of public executions. It is framed by three madrasahs (Islamic schools) of distinctive Persian architecture. The square was regarded as the hub of the Timurid Renaissance.','[\"01JH9Y6CJ5JKN6PXQZJ3XR84QY.jpg\",\"01JH9Y6CJ8GACEVCJ7BG9WS2N2.jpg\",\"01JH9Y6CJ9814N0EDW1EMF5FN1.jpg\"]',3),(2,'2025-01-11 05:28:05','2025-01-13 10:15:02','Hasti Imam',3.00,'The Hazrati Imam complex (also known as Hastimom or Hastim)  is an architectural monument dating from the 16th to 20th centuries, located in the Olmazor district of Tashkent city, Uzbekistan. The complex consists of the Moʻyi Muborak madrasa, the Qaffol Shoshi mausoleum, the Baroqxon Madrasa, the Hazrati Imam mosque, the Tillashayx mosque, and the Imam al-Bukhari Islamic Institute. The ensemble was built near the grave of Hazrati Imam, the first imam-khatib of Tashkent, a scholar, one of the first Islamic preachers in Tashkent, a poet and an artist.\n\nAccording to historical sources, Hazrati Imam was also a master of making locks and keys, for which he received the nickname \"Qaffol\", meaning \"locksmith\". He also spoke 72 languages and translated the Old Testament (Torah) into Arabic.\n\nToday, the Hazrati Imam complex is located in the \"Old City\" part of Tashkent, and survived the strong earthquake of 1966. In 2007, by the Decree of the President of the Republic of Uzbekistan Islam Karimov, the Hazrati Imam (Hastimom) public association was established, and construction and renovation works were carried out to restore the original historical appearance of the Hazrati Imam complex.','[\"01JH9YQ7PQV7VBB3EPE73NJ2FN.jpg\"]',2),(3,'2025-01-11 05:48:39','2025-01-11 05:48:39','Gur-E-Amir ',3.00,'The Gūr-i Amīr or Guri Amir (Uzbek: Amir Temur Maqbarasi, Go\'ri Amir, Persian: is a mausoleum of the Turkic conqueror Timur (also known as Tamerlane) in Samarkand, Uzbekistan. It occupies an important place in the history of Turkestan\'s architecture as the precursor for and had influence on later Mughal architecture tombs, including Gardens of Babur in Kabul, Humayun\'s Tomb in Delhi and the Taj Mahal in Agra, built by Timur\'s Indian descendants, Mongols  that followed Indian culture with Central Asian influences.  Mughals established the ruling Mughal dynasty of the Indian subcontinent. The mausoleum has been heavily restored over the course of its existence.','[\"01JH9YGHS6GXKHRHQ07H8Q2YJ3.jpg\"]',3),(4,'2025-01-11 05:58:19','2025-01-11 05:58:19','Shakhi-zinda',3.00,'The Shah-i-Zinda Ensemble includes mausoleums and other ritual buildings of 11th – 15th and 19th centuries. The name Shah-i-Zinda (meaning \"The living king\") is connected with the legend that Qutham ibn Abbas, a cousin of Muhammad, is buried here. He came to Samarkand with the Arab invasion in the 7th century to preach Islam.\n\nThe Shah-i-Zinda complex was formed over eight (from the 11th until the 19th) centuries and now includes more than twenty buildings.\nView inside the necropolis\nTuman Aka complex\nThe ensemble comprises three groups of structures: lower, middle and upper connected by four-arched domed passages locally called chartak. The earliest buildings date back to the 11th – 12th centuries. Mainly their bases and headstones have remained now. The most part dates back to the 14th – 15th centuries. Reconstructions of the 16th – 19th centuries were of no significance and did not change the general composition and appearance.\nThe initial main body - Kusam-ibn-Abbas complex - is situated in the north-eastern part of the ensemble. It consists of several buildings. The most ancient of them, the Kusam-ibn-Abbas mausoleum and mosque (16th century), are among them.\nThe upper group of buildings consists of three mausoleums facing each other. The earliest one is Khodja-Akhmad Mausoleum (1340s), which completes the passage from the north. The Mausoleum of 1361, on the right, restricts the same passage from the east.\nThe middle group consists of the mausoleums of the last quarter of the 14th century - first half of the 15th century and is concerned with the names of Timur\'s relatives, military and clergy aristocracy. On the western side the Turkan Ago Mausoleum, the niece of Timur, stands out. This portal-domed one-premise crypt was built in 1372. Opposite is the Mausoleum of Shirin Bika Aga, Timur\'s sister.Next to Shirin-Bika-Aga Mausoleum is the so-called Octahedron, an unusual crypt of the first half of the 15th century.\nNear the multi-step staircase the most well proportioned buildings of the lower group is situated. It is a double-cupola mausoleum of the beginning of the 15th century. This mausoleum is devoted to Kazi Zade Rumi, who was the scientist and astronomer. Therefore the double-cupola mausoleum which was built by Ulugh Beg above his tomb in 1434 to 1435 has the height comparable with cupolas of the royal family\'s mausoleums. The main entrance gate to the ensemble (Darvazakhana or the first chartak) turned southward was built in 1434 to 1435 under Ulugbek','[\"01JH9Z28QCCFCFJFKWW9FB0YDR.jpg\"]',3),(5,'2025-01-11 06:01:37','2025-01-11 06:01:37','Ulugbek Observatory',3.00,'The Ulugh Beg Observatory is an observatory in modern day Samarkand, Uzbekistan, which was built in the 1420s by the Timurid astronomer Ulugh Beg. This school of astronomy was constructed under the Timurid Empire, and was the last of its kind from the Islamic Medieval period. Islamic astronomers who worked at the observatory include Jamshid al-Kashi, Ali Qushji, and Ulugh Beg himself. The observatory was destroyed in 1449 and rediscovered in 1908.','[\"01JH9Z8AACVP9FSYZH0FY8VH9K.jpg\"]',3),(6,'2025-01-11 06:05:21','2025-01-11 06:05:21','Bibi-Khanym mosque',3.00,'The Bibi-Khanym Mosque (Uzbek: Bibixonim masjidi; Persian: مسجد بی بی خانم; also variously spelled as Khanum, Khanom, Hanum, Hanim) is one of the most important monuments of Samarkand, Uzbekistan. In the 15th century, it was one of the largest and most magnificent mosques in the Islamic world. It is considered a masterpiece of the Timurid Renaissance. By the mid-20th century, only a grandiose ruin of it still survived, but major parts of the mosque were restored during the Soviet period.','[\"01JH9ZF4VKMWQTRRATCWAZHHK0.jpg\"]',3),(7,'2025-01-11 06:08:16','2025-01-11 06:08:16','Afrasiab Museum',3.00,'Afrasiab Museum of Samarkand (Uzbek: Afrosiyob-Samarqand shahar tarixi muzeyi) is a museum located at the historical site of Afrasiyab, one of the largest archaeological sites in the world and the ancient city that was destroyed by the Mongols in the early 13th century. Museum building and the archaeological site are located in the north-eastern part of the city of Samarkand in the Central Asian country of Uzbekistan. It bears the name of Afrasiab, mythical king and hero of Turan. Permanent exhibition of the Afrasiab Museum of Samarkand is focused on the history of the city itself as well as the surrounding region. The museum building was designed by Armenian architect Bagdasar Arzumanyan in 1970, at the time when Uzbek Soviet Socialist Republic was still part of the Soviet Union. The opening of the museum was dedicated to the 2500th anniversary of the founding of the city of Samarkand.Thematically, the museum is divided into five rooms dedicated to different periods of life in the fort of Afrasiyab.','[\"01JH9ZMFVANYE2H02C54YXN7TQ.jpg\"]',3),(8,'2025-01-11 06:13:49','2025-01-11 06:13:49','Konighil paper village ',2.00,'Konigil village is located 13 km from Samarkand. In the times of the Great Silk Road, there were many caravanserais here, but with its decline, the area fell into decay. However, thanks to the efforts of the Mukhtarov brothers, a once neglected 800 m territory turned into a country handicrafts center, at the same time providing jobs for suburban residents.\n\nUnder the shade of green trees, there is the tourist village of Konigil. It vividly demonstrates the culture, lifestyle, heritage, and customs of the Uzbek people through the works of local craftspeople. And the Meros Paper Mill in Samarkand is ready to offer its visitors its treasure in full.\n\nSamarkand silk paper was spread worldwide by the caravans. It used to be a precious commodity on the Great Silk Road because it did not spoil if got wet and had a minimum shelf life made 400 years! By comparison, the maximum shelf life of modern manufactured paper is one century. In ancient times, silk paper was ordered for writing manuscripts, and nowadays it is used for their restoration.','[\"01JH9ZYN8WMHHAD302N1WC0KXZ.jpg\"]',3),(9,'2025-01-13 09:35:50','2025-01-13 09:35:50','Tashkent metro station( Tashkent underground Museum)',1.00,'Planning for the Tashkent Metro started in 1968, two years after a major earthquake struck the city in 1966. Construction on the first line began in 1972 and it opened on 6 November 1977 with nine stations. This line was extended in 1980, and the second line was added in 1984. The most recent line is the Circle (Halqa) Line, the first section of which opened in 2020.[4]\n\nA northern extension of the Yunusobod Line for 2 stations Turkiston and Yunusobod was completed and opened on 29 August 2020. The fourth Circle line is currently under construction, first 7 stations for the line have already been built in 2020.','[\"01JHFG9ZAY0FYXDBDQFDPGSVGX.jpg\"]',2),(10,'2025-01-13 09:50:50','2025-01-13 09:50:50','Minor Mosque ( White mosque)',0.00,'The Minor Mosque is called the White Mosque or Ok Machit. The mosque opened in October 2014. The snow-white beauty was built near the Ankhor embankment. The White Mosque can accommodate more than 2,400 people, has two tall minarets and a sky-colored dome. The style of the mosque building has absorbed all the best from centuries-old Uzbek traditions. And at the same time, the builders managed to bring something new to the image of the new mosque. Due to the white marble finish, the Minor Mosque acquired some lightness, airiness. White is the color of purity and innocence, which perfectly matches the Muslim way of thinking.','[\"01JHFH5ECE641N1T9GYDJM569Q.jpg\"]',2),(11,'2025-01-13 09:57:37','2025-01-13 09:58:07','Ark of Bukhara',3.00,'The Ark of Bukhara is a massive fortress located in the city of Bukhara, Uzbekistan, that was initially built and occupied around the 5th century AD. In addition to being a military structure, the Ark encompassed what was essentially a town that, during much of the fortress\'s history, was inhabited by the various royal courts that held sway over the region surrounding Bukhara. The Ark was used as a fortress until it fell to Russia in 1920. Currently, the Ark is a tourist attraction and houses museums covering its history. The museums and other restored areas include an archaeological museum, the throne room, the reception and coronation court, a local history museum, and the court mosque','[\"01JHFHHWC91AZ0Z69T38FF82P2.jpg\"]',4),(12,'2025-01-13 10:01:41','2025-01-13 10:01:41','Ulugbek Madrasah',0.00,'Ulugbek madrasah is an architectural monument (1417) in Bukhara, Uzbekistan. It is the oldest preserved madrasah in Central Asia. It is the oldest of the madrasahs built by Ulugbek. During the reign of Abdullah Khan II, major renovation works were carried out (1586).\nThe building is a monument of the heyday of Central Asian architecture, and madrasahs were built on its model in other cities of Central Asia. Currently, the madrasah is the only building of this size preserved in Bukhara from the Timurid dynasty. The madrasah, as well as the three madrasahs built by Ulugbek, is the oldest surviving building. It is located opposite the Abdulaziz Khan Madrasah and forms a single architectural ensemble with it. In the architecture of Central Asia, the paired ensemble of two buildings facing each other is defined by the term \"double\", and the term \"double madrasah\" refers to two madrasahs.\nIt was included in the UNESCO World Heritage List in 1993 as part of the \"Historic Center of Bukhara\". Currently, the Ulugbek madrasa houses the Museum of the History of the Restoration of Bukhara Monuments.','[\"01JHFHSA0MS3XAS6732FCS5RXT.jpg\"]',4),(13,'2025-01-13 10:04:39','2025-01-13 10:04:39','Kalon Mosque',3.00,'Kalan Mosque (Persian: Big mosque) is an architectural monument located in Bukhara, Uzbekistan. It was considered one of the largest mosques built on the place of Jame\' Mosque. Its current appearance was built in 1514 during the reign of Shaybani Ubaidullah Khan of Bukhara. Currently, the mosque is included in the national list of estate real objects of material and cultural heritage of Uzbekistan.','[\"01JHFHYR3K59HEN6CWFGFC6N1X.jpg\"]',4),(14,'2025-01-13 10:10:54','2025-01-13 10:10:54','Chor Minar ',2.00,'Chor Minor (Char Minar Uzbek: Chor minor), alternatively known as the Madrasah of Khalif Niyaz-kul, is a historic gatehouse for a now-destroyed madrasa in the historic city of Bukhara, Uzbekistan. It is located in a lane northeast of the Lyab-i Hauz complex. It is protected as a cultural heritage monument, and also it is a part of the World Heritage Site Historic Centre of Bukhara.[1] In Persian, the name of the monument means \"four minarets\", referring to the building\'s four towers.','[\"01JHFJA63RPNX4SK7R0W2Z24EG.jpg\"]',4),(15,'2025-01-13 10:14:36','2025-01-13 10:14:36','Bolo Haouz Mosque',0.00,'Bolo Haouz Mosque is a historical mosque in Bukhara, Uzbekistan.[1] Built in 1712, on the opposite side of the citadel of Ark in Registan district, it is inscribed in the UNESCO World Heritage Site list along with other parts of the historic city. It served as a Friday mosque during the time when the emir of Bukhara was being subjugated under the Bolshevik Russian rule in the 1920s. Thin columns made of painted wood were added to the frontal part of the iwan (entrance) in 1917, additionally supporting the bulged roof of summer prayer room. The columns are decorated with colored muqarnas.','[\"01JHFJGZEMFYCJYP5CHZJQ7BE4.jpg\"]',4),(16,'2025-01-13 10:18:27','2025-01-13 10:18:27','Lyabi- Khauz ensemble ',0.00,'Lab-i Hauz (Uzbek: Labihovuz, Tajik: Лаби Ҳавз, romanized: Labi Havz, Persian: لب حوض, romanized: Lab-e Howz, meaning in Persian \"by the pool\"), sometimes also known as Lyab-i Khauz, a Russian approximation, is the name of the area surrounding one of the few remaining hauz pools that have survived in the city of Bukhara, Uzbekistan. Until the Soviet period, there were many such pools, which were the city\'s principal source of water, but they were notorious for spreading disease and were mostly filled in during the 1920s and 1930s.\n\nThe Lab-i Hauz survived because it is the centerpiece of a magnificent architectural ensemble, created during the 16th and 17th centuries, which has not been significantly changed since. The Lab-i Hauz ensemble, surrounding the pool on three sides, consists of the Kukeldash Madrasah (1568–1569, the largest madrasa in the city), on the north side of the pool, and two religious edifices built by Nadir Divan-Beghi: a khanqah (1620; Uzbek: xonaqah, meaning a lodging house for itinerant Sufis) and a madrasa (1622), which stand on the west and east sides of the pool respectively. The small Qāzī-e Kalān Nasreddīn madrasa (now demolished) was formerly located beside the Kukeldash madrasah.','[\"01JHFJR0B3Z4FQPYGWKNFMW6MF.jpg\"]',4),(17,'2025-01-13 10:23:58','2025-01-13 10:23:58','Bahoutdin Architectural Complex',3.00,'The Bahouddin Naqshband Memorial Complex is located approximately 10 kilometers northeast of Bukhara city and has been developed over many centuries. During the time of the Soviets, it was forbidden to visit the grave here. The complex was initially established after the death of Bahouddin Naqshband and has been a place of pilgrimage for many generations. Bahouddin Naqshband\'s full name was Bahouddin Muhammad ibn Burhoniddin Muhammad al-Bukhori, and he lived from 1318 to 1389. He was also known by titles such as \"Shohi Naqshband\" and \"Xojayi Buzruk.\" Bahouddin Naqshband is recognized as the seventh Sufi saint.\nThe Bahouddin Naqshband Memorial Complex begins with a small domed gatehouse. In 2003, the calligrapher Habibulloh Solih inscribed the 28th verse of the Surah Ar-Ra\'d (The Thunder) on the wall near the \"Bobi Islom\" gate, using an Arabic script known as \"Nasta\'liq\".In the muqarnas section of the gate, the names of the master builders and the year of construction are inscribed. A rubai (quatrain) is written in \"Nasta\'liq\" script on the entrance door of the mausoleum.The tombs within the complex have been arranged according to the command of Abdulaziz Khan and are currently well-preserved. The largest building in the complex, the khanqah (Sufi lodge), was constructed between 1544 and 1545.[3] Inside the cells of the khanqah, you can find poetry inscribed in \"Nasta\'liq\" script. The memorial complex also includes a minaret featuring an inscription in \"Nasta\'liq\" script, indicating that it was built in 1885','[\"01JHFK23S782YT2Y6WEECMT7HF.jpg\"]',4),(18,'2025-01-13 10:34:34','2025-01-13 10:34:34','Samanid Mausoleum',3.00,'The Samanid Mausoleum is a mausoleum located in the northwestern part of Bukhara, Uzbekistan, just outside its historic center. It was built in the 10th century CE as the resting place of the powerful and influential Islamic Samanid dynasty that ruled the Samanid Empire from approximately 900 to 1000. It contained three burials, one of whom is known to have been that of Nasr II.\nThe mausoleum is considered one of the iconic examples of early Islamic architecture and is known as the oldest funerary building of Central Asian architecture.The Samanids established their de facto independence from the Abbasid Caliphate in Baghdad and ruled over parts of modern Afghanistan, Iran, Uzbekistan, Tajikistan, and Kazakhstan. It is the only surviving monument from the Samanid era, but American art historian Arthur Upham Pope called it \"one of the finest in Persia\".\nPerfectly symmetrical, compact in its size, yet monumental in its structure, the mausoleum not only combined multi-cultural building and decorative traditions, such as Sogdian, Sassanian, Persian and even classical and Byzantine architecture, but incorporated features customary for Islamic architecture – a circular dome and mini domes, pointed arches, elaborate portals, columns and intricate geometric designs in the brickwork. At each corner, the mausoleum\'s builders employed squinches, an architectural solution to the problem of supporting the circular-plan dome on a square. The building was buried in silt some centuries after its construction and was revealed during the 20th century by archaeological excavation conducted under the USSR.','[\"01JHFKNH4SQZB5BG6GKXF7JYY8.jpg\"]',4),(19,'2025-01-13 10:37:11','2025-01-13 10:37:11','Chashma-Ayub Mausoleum',3.00,'Chashma-Ayub Mausoleum (Uzbek: Chashmai Ayyub, lit. \'Job\'s Well\') is located near the Samani Mausoleum, in Bukhara, Uzbekistan. Its name means Job\'s well, due to the legend in which Job (Ayub) visited this place and made a well by striking the ground with his staff. The water of this well is still pure and is considered healing. The current building was constructed during the reign of Timur and features a Khwarazm-style conical dome uncommon in Bukhara.','[\"01JHFKTAV4R3NVTHZ3HNZ0WM96.jpg\"]',4),(20,'2025-01-13 10:45:21','2025-01-13 10:45:21','Magok-i-Attari Mosque',3.00,'Maghoki Attori Mosque (Uzbek: Magʻoki Attori masjidi, Tajik: Масҷиди Мағокии Атторӣ, romanized: Masjidi Maghokii Attori, Persian: مسجد مغاکی عطاری, romanized: Masjed-e Maghākī-ye Attārī) is a historical mosque in Bukhara, Uzbekistan. It forms a part of the historical religious complex of Lyab-i Hauz. The mosque is located in the historical center of Bukhara, about 300 meters southwest of Po-i-Kalyan, 100 meters southwest of the Toqi Telpak Furushon trading dome and 100 meters east of Lab-i Hauz. It is a part of UNESCO World Heritage Site Historic Centre of Bukhara. Today, the mosque is used as a carpet museum.','[\"01JHFM98G9YNX9WR169X2R46Z0.jpg\"]',4);
/*!40000 ALTER TABLE `monuments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restaurants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurants_city_id_foreign` (`city_id`),
  CONSTRAINT `restaurants_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (2,'2025-01-11 05:26:29','2025-01-11 05:57:13','Sim-Sim restaurant','15-uy, Mukimi Street, 100115, Tashkent','+998909439067','www.simsim.uz','sim@mail.ru',2),(3,'2025-01-11 06:20:23','2025-01-13 10:43:57','Miramandi','Furqat ko\'chasi 10, 100027, Тоshkent,','+998972640000','almandi.uz','Miramandi@tashkent.com',2),(4,'2025-01-11 06:22:54','2025-01-11 06:22:54','Beshqozon',' Iftihor ko\'chasi 1, Тоshkent, Toshkent','+998712009444','wwwbeshqozon.uz','Beshqozon@mail.ru',2),(5,'2025-01-13 10:15:04','2025-01-13 10:15:04','Karimbek',' Гагарин кўчаси 194, Samarqand, Samarqand viloyati','+998662377739','wwwkarimbek.uz','karimbekon@mail.ru',3),(6,'2025-01-13 10:19:49','2025-01-13 10:20:09','Ibrohim Bek','Muqimiy ko\'chasi, 100100, Тоshkent, Toshkent','+998712539665','www.ibroximbek.uz','bekrestaurants@mail.ru',2),(7,'2025-01-13 10:25:36','2025-01-13 10:25:36','Samarqand','MX32+R97, Samarqand, Samarqand viloyati','+998907430405','www.Samarqandrest.uz','samarqandrest@mail.ru',3),(8,'2025-01-13 10:43:25','2025-01-13 10:43:25','Emirhan ','Махмуджанова 1/18 Самарканд Сиябский, 140100, Samarkand','+998888916000','www.emirhan.uz','Emirhan@mail.ru',3),(9,'2025-01-13 10:43:27','2025-01-13 10:43:27','Emirhan ','Махмуджанова 1/18 Самарканд Сиябский, 140100, Samarkand','+998888916000','www.emirhan.uz','Emirhan@mail.ru',3),(10,'2025-01-13 10:52:15','2025-01-13 10:52:15','Han Atlas','Mahmud Qoshgariy ko\'chasi 92, Samarqand, Samarqand viloyati','+998662331831','www.xanatlas.uz','hanatlas@uzmail.ru',3);
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_types`
--

DROP TABLE IF EXISTS `room_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_types`
--

LOCK TABLES `room_types` WRITE;
/*!40000 ALTER TABLE `room_types` DISABLE KEYS */;
INSERT INTO `room_types` VALUES (1,'2025-01-10 16:43:13','2025-01-10 16:43:13','Double'),(2,'2025-01-11 05:21:21','2025-01-11 05:21:21','sing'),(3,'2025-01-11 05:44:54','2025-01-11 05:44:54','Delux room'),(4,'2025-01-11 05:45:34','2025-01-11 05:45:34','Standard room'),(5,'2025-01-11 05:55:41','2025-01-11 05:55:41','Single');
/*!40000 ALTER TABLE `room_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hotel_id` bigint unsigned NOT NULL,
  `room_type_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cost_per_night` decimal(10,2) NOT NULL DEFAULT '0.00',
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_hotel_id_foreign` (`hotel_id`),
  KEY `rooms_room_type_id_foreign` (`room_type_id`),
  CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (2,'2025-01-11 05:20:40','2025-01-11 05:20:40',2,1,NULL,NULL,62.00,'[]'),(3,'2025-01-11 05:21:45','2025-01-11 05:21:45',2,2,NULL,NULL,50.00,'[]'),(4,'2025-01-11 06:00:36','2025-01-11 06:00:36',3,5,NULL,NULL,85.00,'[\"01JH9Z6DYC7W407YZXP7WQA8H7.jpg\"]'),(5,'2025-01-11 06:00:36','2025-01-11 06:00:36',3,1,NULL,NULL,97.00,'[\"01JH9Z6DYEZQ03YD09DN21TMXN.jpg\"]'),(6,'2025-01-11 06:16:23','2025-01-11 06:16:23',4,5,NULL,NULL,45.00,'[\"01JHA03AT0FFXREPYP0536Z5CS.jpg\"]'),(7,'2025-01-11 06:16:23','2025-01-11 06:16:23',4,1,NULL,NULL,50.00,'[\"01JHA03AT216H6G0Y6MSSK67KQ.jpg\"]'),(8,'2025-01-13 07:13:24','2025-01-13 07:13:24',5,5,NULL,NULL,70.00,'[]'),(9,'2025-01-13 09:40:48','2025-01-13 09:40:48',6,5,NULL,NULL,45.00,'[\"01JHFGK2SQH2TWF6WDKAM48P5V.webp\"]'),(10,'2025-01-13 09:40:48','2025-01-13 09:40:48',6,1,NULL,NULL,55.00,'[\"01JHFGK2SRXFT5EN6MJKAEC3KW.webp\"]'),(11,'2025-01-13 09:52:00','2025-01-13 09:52:00',7,5,NULL,NULL,54.00,'[\"01JHFH7K8BVG2PW890WBSP032T.jpg\"]'),(12,'2025-01-13 09:52:00','2025-01-13 09:52:00',7,1,NULL,NULL,70.00,'[\"01JHFH7K8CRDYVXFTJJXZND1F8.jpg\"]'),(13,'2025-01-13 11:03:38','2025-01-13 11:03:38',8,5,NULL,NULL,70.00,'[]'),(14,'2025-01-13 11:03:38','2025-01-13 11:03:38',8,1,NULL,NULL,65.00,'[]'),(15,'2025-01-13 11:09:04','2025-01-13 11:09:04',9,5,NULL,NULL,61.00,'[]'),(16,'2025-01-13 11:09:04','2025-01-13 11:09:04',9,1,NULL,NULL,77.00,'[]'),(17,'2025-01-13 11:17:20','2025-01-13 11:17:20',10,5,NULL,NULL,60.00,'[]'),(18,'2025-01-13 11:17:20','2025-01-13 11:17:20',10,1,NULL,NULL,78.00,'[]'),(19,'2025-01-13 11:50:50','2025-01-13 11:50:50',11,5,NULL,NULL,0.00,'[]');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spoken_languages`
--

DROP TABLE IF EXISTS `spoken_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spoken_languages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spoken_languages`
--

LOCK TABLES `spoken_languages` WRITE;
/*!40000 ALTER TABLE `spoken_languages` DISABLE KEYS */;
INSERT INTO `spoken_languages` VALUES (1,'2025-01-10 16:42:16','2025-01-10 16:42:16','EN'),(2,'2025-01-13 11:38:17','2025-01-13 11:38:17','FR'),(3,'2025-01-13 11:38:49','2025-01-13 11:38:49','EN'),(4,'2025-01-13 11:40:30','2025-01-13 11:40:30','RU'),(5,'2025-01-13 11:44:20','2025-01-13 11:44:20','CN'),(6,'2025-01-13 11:44:35','2025-01-13 11:44:35','UZ');
/*!40000 ALTER TABLE `spoken_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_day_hotel_room`
--

DROP TABLE IF EXISTS `tour_day_hotel_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_day_hotel_room` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tour_day_id` bigint unsigned DEFAULT NULL,
  `hotel_id` bigint unsigned DEFAULT NULL,
  `room_id` bigint unsigned DEFAULT NULL,
  `quantity` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tour_day_id` (`tour_day_id`),
  KEY `hotel_id` (`hotel_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `tour_day_hotel_room_ibfk_1` FOREIGN KEY (`tour_day_id`) REFERENCES `tour_days` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tour_day_hotel_room_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tour_day_hotel_room_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_day_hotel_room`
--

LOCK TABLES `tour_day_hotel_room` WRITE;
/*!40000 ALTER TABLE `tour_day_hotel_room` DISABLE KEYS */;
INSERT INTO `tour_day_hotel_room` VALUES (2,2,4,7,2,'2025-01-13 11:06:04','2025-01-13 11:06:04'),(3,2,4,6,1,'2025-01-13 11:06:04','2025-01-13 11:06:04');
/*!40000 ALTER TABLE `tour_day_hotel_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_day_transport`
--

DROP TABLE IF EXISTS `tour_day_transport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_day_transport` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_day_id` bigint unsigned NOT NULL,
  `transport_id` bigint unsigned NOT NULL,
  `price_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tour_day_transport_tour_day_id_foreign` (`tour_day_id`),
  KEY `tour_day_transport_transport_id_foreign` (`transport_id`),
  CONSTRAINT `tour_day_transport_tour_day_id_foreign` FOREIGN KEY (`tour_day_id`) REFERENCES `tour_days` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tour_day_transport_transport_id_foreign` FOREIGN KEY (`transport_id`) REFERENCES `transports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_day_transport`
--

LOCK TABLES `tour_day_transport` WRITE;
/*!40000 ALTER TABLE `tour_day_transport` DISABLE KEYS */;
INSERT INTO `tour_day_transport` VALUES (2,'2025-01-13 11:06:04','2025-01-13 11:06:04',2,4,'per_day'),(3,'2025-01-13 11:06:04','2025-01-13 11:06:04',2,2,'per_pickup_dropoff'),(4,'2025-01-13 11:06:04','2025-01-13 11:06:04',3,4,'per_day'),(5,'2025-01-13 11:17:53','2025-01-13 11:17:53',4,7,'per_day'),(6,'2025-01-13 11:29:42','2025-01-13 11:29:42',5,7,'per_day'),(7,'2025-01-13 11:29:42','2025-01-13 11:29:42',5,7,'per_pickup_dropoff'),(8,'2025-01-13 11:36:57','2025-01-13 11:43:38',6,2,'per_day'),(9,'2025-01-13 11:36:57','2025-01-13 11:38:20',6,9,'per_pickup_dropoff');
/*!40000 ALTER TABLE `tour_day_transport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_days`
--

DROP TABLE IF EXISTS `tour_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `guide_id` bigint unsigned DEFAULT NULL,
  `hotel_id` bigint unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` bigint unsigned DEFAULT NULL,
  `restaurant_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hotel_id` (`hotel_id`),
  KEY `guide_id` (`guide_id`),
  KEY `tour_id` (`tour_id`),
  KEY `fk_tour_days_city_id` (`city_id`),
  KEY `fk_tour_days_restaurant_id` (`restaurant_id`),
  CONSTRAINT `tour_days_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tour_days_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tour_days_ibfk_3` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_days`
--

LOCK TABLES `tour_days` WRITE;
/*!40000 ALTER TABLE `tour_days` DISABLE KEYS */;
INSERT INTO `tour_days` VALUES (2,'2025-01-13 11:06:04','2025-01-13 11:06:04',2,'Day 1: Tashkent – Arrival ',NULL,1,4,'3_star',2,2),(3,'2025-01-13 11:06:04','2025-01-13 11:06:04',2,'Day 2: Tashkent ',NULL,1,NULL,NULL,2,4),(4,'2025-01-13 11:17:53','2025-01-13 11:17:53',3,'Lacota Mccoy',NULL,1,10,'3_star',2,2),(5,'2025-01-13 11:29:42','2025-01-13 11:29:42',4,'Kaseem Kemp',NULL,1,NULL,NULL,2,NULL),(6,'2025-01-13 11:36:57','2025-01-13 11:36:57',5,'May Norton',NULL,1,NULL,NULL,4,NULL);
/*!40000 ALTER TABLE `tour_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tours` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_people` int NOT NULL DEFAULT '0',
  `tour_duration` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tours_tour_number_unique` (`tour_number`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--

LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
INSERT INTO `tours` VALUES (1,'Uzb 1 day','Libero exercitatione','2025-01-10 16:46:13','2025-01-10 16:55:05','uzb-1-day',1,1,'2025-01-09','2025-01-10'),(2,'Odil','Welcome to Uzbekistan, where you will have an exciting tour to the world of oriental fairy tale. The Eight-day Uzbekistan classic tour is a visit of Tashkent, Samarkand, Bukhara and Khiva the cities sparkling like diamonds with striking multifaceted architecture, rich of traditions and ancient customs of mysterious and hospitable Uzbekistan','2025-01-13 11:06:04','2025-01-13 11:06:04','odil',5,3,'2025-01-15','2025-01-17'),(3,'Shafira Horne','Odio deleniti archit','2025-01-13 11:17:53','2025-01-13 11:17:53','shafira-horne',548,7408,'1973-06-01','1993-09-11'),(4,'Gloria Jimenez','Corrupti non blandi','2025-01-13 11:29:42','2025-01-13 11:29:42','gloria-jimenez',586,1,'2025-01-11','2025-01-13'),(5,'Rinah Justice v2','Maxime sit ut illo d','2025-01-13 11:36:57','2025-01-13 11:42:36','rinah-justice-v2',169,3419,'1993-02-15','2002-06-26');
/*!40000 ALTER TABLE `tours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_prices`
--

DROP TABLE IF EXISTS `transport_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transport_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT '0.00',
  `transport_type_id` bigint unsigned NOT NULL,
  `price_type` enum('per_day','per_pickup_dropoff','vip','economy','business','po_gorodu') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transport_prices_transport_type_id` (`transport_type_id`),
  CONSTRAINT `fk_transport_prices_transport_type_id` FOREIGN KEY (`transport_type_id`) REFERENCES `transport_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_prices`
--

LOCK TABLES `transport_prices` WRITE;
/*!40000 ALTER TABLE `transport_prices` DISABLE KEYS */;
INSERT INTO `transport_prices` VALUES (3,'2025-01-11 04:45:36','2025-01-11 04:45:36',50.00,2,'per_day'),(4,'2025-01-11 04:46:05','2025-01-11 04:46:05',15.00,2,'per_pickup_dropoff'),(5,'2025-01-11 04:46:52','2025-01-11 04:46:52',80.00,3,'per_day'),(6,'2025-01-11 04:46:52','2025-01-11 04:46:52',20.00,3,'per_pickup_dropoff'),(7,'2025-01-11 04:47:30','2025-01-11 04:47:30',100.00,4,'per_day'),(8,'2025-01-11 04:47:30','2025-01-11 04:47:30',25.00,4,'per_pickup_dropoff'),(9,'2025-01-11 04:48:27','2025-01-11 04:48:27',120.00,5,'per_day'),(10,'2025-01-11 04:48:27','2025-01-11 04:48:27',40.00,5,'per_pickup_dropoff'),(11,'2025-01-11 04:49:12','2025-01-11 04:49:12',150.00,6,'per_day'),(12,'2025-01-11 04:49:12','2025-01-11 04:49:12',40.00,6,'per_pickup_dropoff'),(13,'2025-01-11 04:50:35','2025-01-11 04:50:35',190.00,7,'per_day'),(14,'2025-01-11 04:50:35','2025-01-11 04:50:35',50.00,7,'per_pickup_dropoff'),(15,'2025-01-11 04:53:12','2025-01-11 04:53:12',200.00,8,'per_day'),(16,'2025-01-11 04:53:12','2025-01-11 04:53:12',50.00,8,'per_pickup_dropoff'),(17,'2025-01-11 04:53:12','2025-01-11 04:53:12',150.00,8,'economy'),(18,'2025-01-11 04:53:44','2025-01-11 04:53:44',220.00,9,'per_day'),(19,'2025-01-11 04:54:08','2025-01-11 04:54:08',220.00,10,'per_day'),(20,'2025-01-11 04:56:58','2025-01-11 04:56:58',27.00,11,'economy'),(21,'2025-01-11 04:56:58','2025-01-11 04:56:58',40.00,11,'business'),(22,'2025-01-11 04:56:58','2025-01-11 04:56:58',52.00,11,'vip'),(23,'2025-01-11 04:58:55','2025-01-11 04:58:55',27.00,12,'economy'),(24,'2025-01-11 05:00:04','2025-01-11 05:35:58',35.00,13,'economy'),(25,'2025-01-11 05:00:46','2025-01-11 05:00:46',27.00,14,'economy'),(26,'2025-01-11 05:01:45','2025-01-11 05:01:45',27.00,15,'economy'),(27,'2025-01-11 05:21:40','2025-01-11 05:21:40',40.00,12,'business'),(28,'2025-01-11 05:21:40','2025-01-11 05:21:40',52.00,12,'vip'),(29,'2025-01-11 05:23:20','2025-01-11 05:23:20',40.00,15,'business'),(30,'2025-01-11 05:23:20','2025-01-11 05:23:20',52.00,15,'vip'),(31,'2025-01-11 05:24:21','2025-01-11 05:24:21',40.00,14,'business'),(32,'2025-01-11 05:24:21','2025-01-11 05:24:21',52.00,14,'vip'),(33,'2025-01-11 05:35:58','2025-01-11 05:35:58',51.00,13,'business'),(34,'2025-01-11 05:37:44','2025-01-11 05:37:44',35.00,16,'economy'),(35,'2025-01-11 05:37:44','2025-01-11 05:37:44',51.00,16,'business'),(36,'2025-01-11 05:44:13','2025-01-11 05:44:13',15.00,17,'economy'),(37,'2025-01-11 05:44:13','2025-01-11 05:44:13',19.00,17,'business'),(38,'2025-01-11 05:45:11','2025-01-11 05:45:11',15.00,18,'economy'),(39,'2025-01-11 05:45:11','2025-01-11 05:45:11',19.00,18,'business'),(40,'2025-01-11 05:46:06','2025-01-11 05:46:06',50.00,10,'per_pickup_dropoff'),(41,'2025-01-11 05:59:36','2025-01-11 05:59:36',50.00,9,'per_pickup_dropoff'),(42,'2025-01-11 14:22:46','2025-01-11 14:22:46',45.00,2,'po_gorodu');
/*!40000 ALTER TABLE `transport_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_types`
--

DROP TABLE IF EXISTS `transport_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transport_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT '0.00',
  `price_type` enum('per_day','per_pickup_dropoff','po_gorodu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('bus','car','mikro_bus','mini_van','air','rail') COLLATE utf8mb4_unicode_ci NOT NULL,
  `running_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`),
  CONSTRAINT `transport_types_chk_1` CHECK (json_valid(`running_days`))
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_types`
--

LOCK TABLES `transport_types` WRITE;
/*!40000 ALTER TABLE `transport_types` DISABLE KEYS */;
INSERT INTO `transport_types` VALUES (2,'2025-01-11 04:45:36','2025-01-11 04:45:36','sedn',0.00,'per_day','car',NULL),(3,'2025-01-11 04:46:52','2025-01-11 05:51:22','Hyundai H1 3-5',0.00,'per_day','mikro_bus',NULL),(4,'2025-01-11 04:47:30','2025-01-11 05:51:49','Joylong 6-8',0.00,'per_day','mikro_bus',NULL),(5,'2025-01-11 04:48:27','2025-01-11 04:48:27','Sprintor',0.00,'per_day','mikro_bus',NULL),(6,'2025-01-11 04:49:12','2025-01-11 04:49:12','Coster',0.00,'per_day','mikro_bus',NULL),(7,'2025-01-11 04:50:35','2025-01-11 04:50:35','33 seat',0.00,'per_day','bus',NULL),(8,'2025-01-11 04:53:12','2025-01-11 04:53:12','43',0.00,'per_day','bus',NULL),(9,'2025-01-11 04:53:44','2025-01-11 04:53:44','50',0.00,'per_day','bus',NULL),(10,'2025-01-11 04:54:08','2025-01-11 04:54:08','53',0.00,'per_day','bus',NULL),(11,'2025-01-11 04:56:58','2025-01-11 04:56:58','AFRASIYAB  Tosh-Sam',0.00,'per_day','rail','[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"]'),(12,'2025-01-11 04:58:55','2025-01-11 04:58:55','AFRASIYOB  Sam-Bux',0.00,'per_day','rail','[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"]'),(13,'2025-01-11 05:00:03','2025-01-11 05:00:03','AFRASITAB Tosh-Bux',0.00,'per_day','rail','[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"]'),(14,'2025-01-11 05:00:46','2025-01-11 05:00:46','AFRASIYOB  Bux-Sam',0.00,'per_day','rail','[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"]'),(15,'2025-01-11 05:01:45','2025-01-11 05:01:45','ASFRASIYAB  Sam-Tash',0.00,'per_day','rail','[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"]'),(16,'2025-01-11 05:37:44','2025-01-11 05:38:19','AFRASIYAB  Bux-Tosh',0.00,'per_day','rail','[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"]'),(17,'2025-01-11 05:44:13','2025-01-11 05:44:13','AFRASIYAB  Tosh-Marg',0.00,'per_day','rail','[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"]'),(18,'2025-01-11 05:45:11','2025-01-11 05:45:11','AFRASIYAB  Marg-Tosh',0.00,'per_day','rail','[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"]');
/*!40000 ALTER TABLE `transport_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transports`
--

DROP TABLE IF EXISTS `transports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `plate_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_seat` int DEFAULT NULL,
  `transport_type_id` bigint unsigned NOT NULL,
  `category` enum('bus','car','mikro_bus','mini_van','air','rail') COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_time` time DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `driver_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transports_driver_id_foreign` (`driver_id`),
  CONSTRAINT `transports_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transports`
--

LOCK TABLES `transports` WRITE;
/*!40000 ALTER TABLE `transports` DISABLE KEYS */;
INSERT INTO `transports` VALUES (2,'2025-01-11 05:04:24','2025-01-13 11:17:03','30 355 VAA','ZHONGTONG',53,10,'bus',NULL,NULL,1),(3,'2025-01-11 05:05:48','2025-01-13 11:18:32','30 081 YAA','ZHONGTONG',53,10,'bus',NULL,NULL,2),(4,'2025-01-11 05:06:45','2025-01-11 05:57:21','30 706 FBA','ZONGTONG',51,9,'bus',NULL,NULL,NULL),(5,'2025-01-11 05:58:00','2025-01-11 05:58:00','30 745 FBA','ZONGTONG',51,9,'bus',NULL,NULL,NULL),(6,'2025-01-11 05:58:24','2025-01-11 05:58:24','30 780 FBA','ZONGTONG',51,9,'bus',NULL,NULL,NULL),(7,'2025-01-11 05:59:01','2025-01-11 05:59:01','30 322 ABA','YUTONG',49,9,'bus',NULL,NULL,NULL),(8,'2025-01-11 06:00:14','2025-01-11 06:00:14','30 299 ABA','YUTONG',43,8,'bus',NULL,NULL,NULL),(9,'2025-01-11 06:00:39','2025-01-11 06:03:25','30 308 YAA','YUTONG',43,8,'bus',NULL,NULL,NULL),(10,'2025-01-11 06:02:15','2025-01-11 06:02:15','30 976 QAA','YUTONG',45,8,'bus',NULL,NULL,NULL),(11,'2025-01-11 06:04:06','2025-01-11 06:04:06','30 175 VBA','ZONGTONG',43,8,'bus',NULL,NULL,NULL),(12,'2025-01-11 06:05:37','2025-01-11 06:05:37','85 409 HBA','ZONGTONG',43,8,'bus',NULL,NULL,NULL),(13,'2025-01-11 06:06:56','2025-01-11 06:06:56','85 689 HBA','ZONGTONG',35,7,'bus',NULL,NULL,NULL),(14,'2025-01-11 06:07:46','2025-01-11 06:07:46','85 651 HBA','YUTONG',33,7,'bus',NULL,NULL,NULL),(15,'2025-01-11 06:13:32','2025-01-11 06:13:32','30 637 RAA','YUTONG',33,7,'bus',NULL,NULL,NULL),(16,'2025-01-11 06:13:57','2025-01-11 06:13:57','30 517 SAA','YUTONG',33,7,'bus',NULL,NULL,NULL),(17,'2025-01-11 06:14:47','2025-01-11 06:14:47','30 422 RAA','YUTONG',33,7,'bus',NULL,NULL,NULL),(18,'2025-01-11 06:15:49','2025-01-11 06:15:49','30 887 EBA','JOYLONG',16,4,'mikro_bus',NULL,NULL,NULL),(19,'2025-01-11 06:16:29','2025-01-11 06:16:29','30 247 FBA','JOYLONG',16,4,'mikro_bus',NULL,NULL,NULL),(20,'2025-01-11 06:30:09','2025-01-11 06:30:09','30M128CB','NEXIA',3,2,'car',NULL,NULL,NULL);
/*!40000 ALTER TABLE `transports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Odil','odilorg@gmail.com',NULL,'$2y$12$OsIPU3q9RBcPQOl/5zCjkOAK87NWlDqOb3FMeILUCe2CsCj1xXOQm','TQLpgcQ1PUU9vUBBwTbSKom1yxiwnIUfI6Wa9qmGDTzJtFk7TWe22coEEiUq','2025-01-10 16:41:11','2025-01-10 16:41:11'),(2,'Tolib','tolib71@mail.ru',NULL,'$2y$12$UPsLsbvomMz2Jn8BzNgel.9Fn5Jy0dvdqb6ud8TaYBu/r5XPdTn1y','E6yK9K2aJiuQo5FuFTgavCqqShPf5pmFgiVZetEWk1B5tFyJcWOz4G4yB8Kb','2025-01-11 04:43:41','2025-01-11 04:43:41');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-13 11:57:41
