-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2024 at 12:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ssst2`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, '2024-12-26 23:32:50', '2024-12-26 23:32:50', 'Air Conditioner'),
(2, '2024-12-26 23:33:04', '2024-12-26 23:33:04', 'Bathroom with glass door'),
(3, '2024-12-26 23:33:15', '2024-12-26 23:33:15', 'TV 43\''),
(4, '2024-12-26 23:49:05', '2024-12-26 23:49:05', 'Desk'),
(5, '2024-12-26 23:59:34', '2024-12-26 23:59:34', 'Sofa');

-- --------------------------------------------------------

--
-- Table structure for table `amenity_room`
--

CREATE TABLE `amenity_room` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenity_room`
--

INSERT INTO `amenity_room` (`id`, `created_at`, `updated_at`, `amenity_id`, `room_id`) VALUES
(1, '2024-12-26 23:53:20', '2024-12-26 23:53:20', 1, 1),
(2, '2024-12-26 23:53:20', '2024-12-26 23:53:20', 2, 1),
(3, NULL, NULL, 4, 1),
(4, NULL, NULL, 5, 1),
(5, NULL, NULL, 3, 1),
(6, NULL, NULL, 2, 2),
(7, NULL, NULL, 4, 2),
(8, NULL, NULL, 1, 3),
(9, NULL, NULL, 2, 3),
(10, NULL, NULL, 2, 4),
(11, NULL, NULL, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1735276228),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1735276228;', 1735276228),
('a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1735461163),
('a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1735461163;', 1735461163);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `day_number` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `day_guide`
--

CREATE TABLE `day_guide` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day_id` bigint(20) UNSIGNED NOT NULL,
  `guide_id` bigint(20) UNSIGNED NOT NULL,
  `number_of_days` int(11) NOT NULL DEFAULT 1,
  `agreed_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `day_hotel`
--

CREATE TABLE `day_hotel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `number_of_rooms` int(11) NOT NULL DEFAULT 1,
  `number_of_nights` int(11) NOT NULL DEFAULT 1,
  `agreed_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `day_transportation`
--

CREATE TABLE `day_transportation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day_id` bigint(20) UNSIGNED NOT NULL,
  `transportation_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `agreed_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE `estimates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estimate_number` varchar(255) NOT NULL,
  `estimate_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `guide_id` bigint(20) UNSIGNED NOT NULL,
  `transport_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

CREATE TABLE `guides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `daily_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`id`, `name`, `daily_rate`, `created_at`, `updated_at`) VALUES
(1, 'Odil', 100.00, '2024-12-26 22:10:51', '2024-12-26 22:12:50'),
(2, 'Zafar', 90.00, '2024-12-26 22:13:10', '2024-12-26 22:13:10');

-- --------------------------------------------------------

--
-- Table structure for table `guide_pricings`
--

CREATE TABLE `guide_pricings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guide_id` bigint(20) UNSIGNED NOT NULL,
  `language` varchar(255) NOT NULL,
  `daily_rate` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guide_spoken_language`
--

CREATE TABLE `guide_spoken_language` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guide_id` bigint(20) UNSIGNED NOT NULL,
  `spoken_language_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guide_spoken_language`
--

INSERT INTO `guide_spoken_language` (`id`, `created_at`, `updated_at`, `guide_id`, `spoken_language_id`) VALUES
(1, '2024-12-29 05:22:33', '2024-12-29 05:22:33', 1, 1),
(2, '2024-12-29 05:22:43', '2024-12-29 05:22:43', 2, 2),
(3, '2024-12-29 05:25:48', '2024-12-29 05:25:48', 1, 2),
(4, '2024-12-29 05:25:48', '2024-12-29 05:25:48', 1, 5),
(5, '2024-12-29 05:25:48', '2024-12-29 05:25:48', 1, 3),
(6, '2024-12-29 05:25:48', '2024-12-29 05:25:48', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('bed_and_breakfast','3_star','4_star') NOT NULL,
  `category` enum('bed_breakfast','3_star','4_star','5_star') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `address`, `created_at`, `updated_at`, `type`, `category`) VALUES
(1, 'Jahongir Premium', 'sam', '2024-12-25 01:20:34', '2024-12-29 05:29:15', '3_star', '3_star'),
(2, 'Jahongir', 'chirokchi 4', '2024-12-26 22:22:13', '2024-12-26 22:22:13', 'bed_and_breakfast', 'bed_breakfast');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_25_055712_create_tours_table', 1),
(5, '2024_12_25_055741_create_days_table', 1),
(6, '2024_12_25_055853_create_hotels_table', 1),
(7, '2024_12_25_055921_create_transportations_table', 1),
(8, '2024_12_25_060012_create_day_transportation_table', 1),
(9, '2024_12_25_060034_create_guides_table', 1),
(10, '2024_12_25_060054_create_day_guide_table', 1),
(11, '2024_12_25_060439_create_guide_pricings_table', 1),
(12, '2024_12_25_060509_create_transportation_pricings_table', 1),
(13, '2024_12_25_061304_create_day_hotel_table', 1),
(14, '2024_12_27_030157_create_estimates_table', 2),
(15, '2024_12_27_031405_add_type_to_hotels_table', 2),
(16, '2024_12_27_032324_add_cols_to_estimates_table', 3),
(17, '2024_12_27_032617_add_room_type_to_hotels_table', 3),
(18, '2024_12_27_033249_create_hotel_rooms_table', 4),
(19, '2024_12_27_034545_create_room_types_table', 5),
(20, '2024_12_27_040054_create_rooms_table', 5),
(21, '2024_12_27_040757_create_amenities_table', 5),
(22, '2024_12_27_043759_create_amenity_room_table', 6),
(23, '2024_12_27_065711_add_type_to_hotels_table', 7),
(24, '2024_12_27_093834_add_cols_to_transportations_table', 7),
(25, '2024_12_27_094840_create_transports_table', 7),
(26, '2024_12_27_095442_create_transport_prices_table', 7),
(27, '2024_12_27_102352_create_transport_types_table', 7),
(28, '2024_12_27_103208_add_col_to_transport_types_table', 7),
(29, '2024_12_27_122657_add_col_to_transports_table', 7),
(30, '2024_12_27_163708_create_spoken_languages_table', 7),
(31, '2024_12_27_164024_create_guide_spoken_language_table', 7),
(32, '2024_12_27_175356_create_customers_table', 7),
(33, '2024_12_27_175800_create_tour_days_table', 7),
(34, '2024_12_27_180021_add_cols_to_tours_table', 7),
(35, '2024_12_27_180448_create_estimates_table', 8),
(36, '2024_12_27_185727_create_tour_day_transports_table', 8),
(37, '2024_12_29_084257_create_tour_day_hotel_room_table', 9),
(38, '2024_12_29_085129_add_price_type_to_transport_prices_table', 10),
(39, '2024_12_29_085437_add_guide_id_to_tour_days_table', 11),
(40, '2024_12_29_085514_add_hotel_id_to_tour_days_table', 12),
(41, '2024_12_29_111245_create_monuments_table', 13),
(42, '2024_12_29_111708_create_monument_tour_days_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `monuments`
--

CREATE TABLE `monuments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `ticket_price` decimal(8,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monuments`
--

INSERT INTO `monuments` (`id`, `created_at`, `updated_at`, `name`, `city`, `ticket_price`, `description`) VALUES
(1, '2024-12-29 06:15:31', '2024-12-29 06:15:31', 'Registan', 'Samarkand', 8.00, 'dfd'),
(2, '2024-12-29 06:15:47', '2024-12-29 06:15:47', 'Gur Emir', 'Samarkand', 5.00, NULL),
(3, '2024-12-29 06:28:19', '2024-12-29 06:28:19', 'Shahi Zinda', 'Samarkand', 8.50, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monument_tour_days`
--

CREATE TABLE `monument_tour_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `monument_id` bigint(20) UNSIGNED NOT NULL,
  `tour_day_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monument_tour_days`
--

INSERT INTO `monument_tour_days` (`id`, `created_at`, `updated_at`, `monument_id`, `tour_day_id`) VALUES
(1, NULL, NULL, 2, 1),
(2, NULL, NULL, 1, 1),
(3, NULL, NULL, 2, 2),
(4, NULL, NULL, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cost_per_night` decimal(10,2) NOT NULL DEFAULT 0.00,
  `images` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `created_at`, `updated_at`, `hotel_id`, `room_type_id`, `name`, `description`, `cost_per_night`, `images`) VALUES
(1, '2024-12-26 23:17:31', '2024-12-26 23:23:21', 2, 1, '8 xona', NULL, 30.00, '[\"01JG35K6390FZPEZP7TXYE5MF1.jpg\",\"01JG35K63DRMVTA9PCB99S9AB2.jpg\",\"01JG35NJNKH1X15VHJJ7YH9ZHT.jpg\"]'),
(2, '2024-12-26 23:23:46', '2024-12-26 23:23:46', 2, 2, '11 xona', NULL, 45.00, '[\"01JG35PBNA63Q5K9HZ7MMCNTD0.jpg\",\"01JG35PBNE1RWF3R292GM2ER2T.jpg\"]'),
(3, '2024-12-27 00:09:33', '2024-12-27 00:10:38', 1, 5, '26 xona', NULL, 90.00, '[\"01JG38A5TQVZHE934MV3SH04E0.jpg\"]'),
(4, '2024-12-27 00:10:38', '2024-12-27 00:10:38', 1, 2, '22 xona', NULL, 40.00, '[]');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `created_at`, `updated_at`, `type`) VALUES
(1, '2024-12-26 23:13:41', '2024-12-26 23:13:41', 'Single'),
(2, '2024-12-26 23:14:03', '2024-12-26 23:14:03', 'Double'),
(3, '2024-12-26 23:14:09', '2024-12-26 23:14:09', 'Twin'),
(4, '2024-12-26 23:14:18', '2024-12-26 23:14:18', 'Triple'),
(5, '2024-12-27 00:08:57', '2024-12-27 00:08:57', 'Superior Double');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('zV2NjfU5tBJnzonDFUHOPjfec45ShotLHcIEyzFz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiUXdiY285UUV1ZzZPT1dmS1BHOEpLdTd0czF4U09haWQ3T1B2MmozNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRQTW9kalpTV2V5TVhMU0huUWNsR3B1Qjd0OEJucnBzajZ1aGFFVEVxcVVmZGZqVGsxbWpDcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90b3Vycy8xL2VkaXQiO31zOjg6ImZpbGFtZW50IjthOjA6e319', 1735471848);

-- --------------------------------------------------------

--
-- Table structure for table `spoken_languages`
--

CREATE TABLE `spoken_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spoken_languages`
--

INSERT INTO `spoken_languages` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, '2024-12-29 05:21:53', '2024-12-29 05:21:53', 'English'),
(2, '2024-12-29 05:21:58', '2024-12-29 05:21:58', 'French'),
(3, '2024-12-29 05:22:02', '2024-12-29 05:22:02', 'Russian'),
(4, '2024-12-29 05:22:06', '2024-12-29 05:22:06', 'Spanish'),
(5, '2024-12-29 05:22:14', '2024-12-29 05:22:14', 'German');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `name`, `description`, `created_at`, `updated_at`, `tour_number`) VALUES
(1, 'UZb 10', 'dfdsf', '2024-12-25 01:22:20', '2024-12-29 04:35:10', 'UZB-534');

-- --------------------------------------------------------

--
-- Table structure for table `tour_days`
--

CREATE TABLE `tour_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `guide_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_days`
--

INSERT INTO `tour_days` (`id`, `created_at`, `updated_at`, `tour_id`, `name`, `description`, `guide_id`, `hotel_id`) VALUES
(1, '2024-12-29 03:55:34', '2024-12-29 05:25:29', 1, 'DAy 1', 'd', 2, 1),
(2, '2024-12-29 04:38:21', '2024-12-29 05:26:05', 1, 'Day 2', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tour_day_hotel_room`
--

CREATE TABLE `tour_day_hotel_room` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_day_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hotel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_day_hotel_room`
--

INSERT INTO `tour_day_hotel_room` (`id`, `tour_day_id`, `hotel_id`, `room_id`, `quantity`, `created_at`, `updated_at`) VALUES
(11, 2, 1, 3, 15, '2024-12-29 04:38:40', '2024-12-29 05:32:10'),
(12, 2, 1, 4, 10, '2024-12-29 04:38:40', '2024-12-29 04:38:40');

-- --------------------------------------------------------

--
-- Table structure for table `tour_day_transport`
--

CREATE TABLE `tour_day_transport` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_day_id` bigint(20) UNSIGNED NOT NULL,
  `transport_id` bigint(20) UNSIGNED NOT NULL,
  `price_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_day_transport`
--

INSERT INTO `tour_day_transport` (`id`, `created_at`, `updated_at`, `tour_day_id`, `transport_id`, `price_type`) VALUES
(1, '2024-12-29 03:55:34', '2024-12-29 05:42:31', 1, 3, 'per_day'),
(2, '2024-12-29 03:55:34', '2024-12-29 03:55:34', 1, 1, 'per_pickup_dropoff'),
(3, '2024-12-29 04:38:21', '2024-12-29 05:42:31', 2, 3, 'per_day');

-- --------------------------------------------------------

--
-- Table structure for table `transportation_pricings`
--

CREATE TABLE `transportation_pricings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transportation_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `cost_per_unit` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transportation_pricings`
--

INSERT INTO `transportation_pricings` (`id`, `transportation_id`, `vehicle_type`, `cost_per_unit`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 100.00, '2024-12-11', '2025-01-11', '2024-12-25 01:22:07', '2024-12-25 01:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `transports`
--

CREATE TABLE `transports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `plate_number` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `number_of_seat` int(11) NOT NULL,
  `transport_type_id` bigint(20) UNSIGNED NOT NULL,
  `category` enum('bus','car','mikro_bus','air','rail') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transports`
--

INSERT INTO `transports` (`id`, `created_at`, `updated_at`, `plate_number`, `model`, `number_of_seat`, `transport_type_id`, `category`) VALUES
(1, '2024-12-29 03:53:03', '2024-12-29 05:40:09', '30H656G', 'BYD Chazor', 3, 2, 'car'),
(2, '2024-12-29 05:40:33', '2024-12-29 06:07:39', '30HY656', 'Lacetti', 3, 4, 'car'),
(3, '2024-12-29 05:41:23', '2024-12-29 05:41:23', '30H767', 'Golden Dragon', 43, 3, 'bus');

-- --------------------------------------------------------

--
-- Table structure for table `transport_prices`
--

CREATE TABLE `transport_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT 0.00,
  `transport_type_id` bigint(20) UNSIGNED NOT NULL,
  `price_type` enum('per_day','per_pickup_dropoff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transport_prices`
--

INSERT INTO `transport_prices` (`id`, `created_at`, `updated_at`, `cost`, `transport_type_id`, `price_type`) VALUES
(1, '2024-12-29 03:52:18', '2024-12-29 03:52:18', 100.00, 2, 'per_day'),
(2, '2024-12-29 03:52:18', '2024-12-29 03:52:18', 50.00, 2, 'per_pickup_dropoff'),
(3, '2024-12-29 05:41:19', '2024-12-29 05:41:19', 150.00, 3, 'per_day'),
(4, '2024-12-29 05:41:19', '2024-12-29 05:41:19', 80.00, 3, 'per_pickup_dropoff'),
(5, '2024-12-29 06:07:35', '2024-12-29 06:07:35', 80.00, 4, 'per_day'),
(6, '2024-12-29 06:07:35', '2024-12-29 06:07:35', 30.00, 4, 'per_pickup_dropoff');

-- --------------------------------------------------------

--
-- Table structure for table `transport_types`
--

CREATE TABLE `transport_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT 0.00,
  `price_type` enum('per_day','per_pickup_dropoff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transport_types`
--

INSERT INTO `transport_types` (`id`, `created_at`, `updated_at`, `type`, `cost`, `price_type`) VALUES
(2, '2024-12-29 03:52:18', '2024-12-29 03:52:18', 'Sedan', 0.00, 'per_day'),
(3, '2024-12-29 05:41:18', '2024-12-29 05:41:18', '43 seat', 0.00, 'per_day'),
(4, '2024-12-29 06:07:35', '2024-12-29 06:07:35', 'Sedan Lacetti', 0.00, 'per_day');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Odil', 'odilorg@gmail.com', NULL, '$2y$12$PModjZSWeyMXLSHnQclGpuB7t8Bnrpsj6uhaETEqqUfdfjTk1mjCq', 'UFAPVynGEYbOqoDYPQ7oTCw9UKgEncQXQkZv8SgKMIvvolAuI03uj4gpRoXO', '2024-12-25 01:20:11', '2024-12-25 01:20:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenity_room`
--
ALTER TABLE `amenity_room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `amenity_room_amenity_id_foreign` (`amenity_id`),
  ADD KEY `amenity_room_room_id_foreign` (`room_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `days_tour_id_foreign` (`tour_id`);

--
-- Indexes for table `day_guide`
--
ALTER TABLE `day_guide`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `day_guide_day_id_guide_id_unique` (`day_id`,`guide_id`),
  ADD KEY `day_guide_guide_id_foreign` (`guide_id`);

--
-- Indexes for table `day_hotel`
--
ALTER TABLE `day_hotel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `day_hotel_day_id_hotel_id_unique` (`day_id`,`hotel_id`),
  ADD KEY `day_hotel_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `day_transportation`
--
ALTER TABLE `day_transportation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `day_transportation_day_id_transportation_id_unique` (`day_id`,`transportation_id`),
  ADD KEY `day_transportation_transportation_id_foreign` (`transportation_id`);

--
-- Indexes for table `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estimates_estimate_number_unique` (`estimate_number`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guide_pricings`
--
ALTER TABLE `guide_pricings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guide_pricings_guide_id_foreign` (`guide_id`);

--
-- Indexes for table `guide_spoken_language`
--
ALTER TABLE `guide_spoken_language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guide_spoken_language_guide_id_foreign` (`guide_id`),
  ADD KEY `guide_spoken_language_spoken_language_id_foreign` (`spoken_language_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monuments`
--
ALTER TABLE `monuments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monument_tour_days`
--
ALTER TABLE `monument_tour_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monument_tour_days_monument_id_foreign` (`monument_id`),
  ADD KEY `monument_tour_days_tour_day_id_foreign` (`tour_day_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_hotel_id_foreign` (`hotel_id`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `spoken_languages`
--
ALTER TABLE `spoken_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tours_tour_number_unique` (`tour_number`);

--
-- Indexes for table `tour_days`
--
ALTER TABLE `tour_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_days_tour_id_foreign` (`tour_id`),
  ADD KEY `tour_days_guide_id_foreign` (`guide_id`),
  ADD KEY `tour_days_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `tour_day_hotel_room`
--
ALTER TABLE `tour_day_hotel_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tour_day_transport`
--
ALTER TABLE `tour_day_transport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_day_transport_tour_day_id_foreign` (`tour_day_id`),
  ADD KEY `tour_day_transport_transport_id_foreign` (`transport_id`);

--
-- Indexes for table `transportation_pricings`
--
ALTER TABLE `transportation_pricings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transportation_pricings_transportation_id_foreign` (`transportation_id`);

--
-- Indexes for table `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_prices`
--
ALTER TABLE `transport_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_types`
--
ALTER TABLE `transport_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `amenity_room`
--
ALTER TABLE `amenity_room`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `day_guide`
--
ALTER TABLE `day_guide`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `day_hotel`
--
ALTER TABLE `day_hotel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `day_transportation`
--
ALTER TABLE `day_transportation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimates`
--
ALTER TABLE `estimates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guides`
--
ALTER TABLE `guides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guide_pricings`
--
ALTER TABLE `guide_pricings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guide_spoken_language`
--
ALTER TABLE `guide_spoken_language`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `monuments`
--
ALTER TABLE `monuments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `monument_tour_days`
--
ALTER TABLE `monument_tour_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `spoken_languages`
--
ALTER TABLE `spoken_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tour_days`
--
ALTER TABLE `tour_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tour_day_hotel_room`
--
ALTER TABLE `tour_day_hotel_room`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tour_day_transport`
--
ALTER TABLE `tour_day_transport`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transportation_pricings`
--
ALTER TABLE `transportation_pricings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transports`
--
ALTER TABLE `transports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transport_prices`
--
ALTER TABLE `transport_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transport_types`
--
ALTER TABLE `transport_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenity_room`
--
ALTER TABLE `amenity_room`
  ADD CONSTRAINT `amenity_room_amenity_id_foreign` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amenity_room_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `days`
--
ALTER TABLE `days`
  ADD CONSTRAINT `days_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `day_guide`
--
ALTER TABLE `day_guide`
  ADD CONSTRAINT `day_guide_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `day_guide_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `day_hotel`
--
ALTER TABLE `day_hotel`
  ADD CONSTRAINT `day_hotel_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `day_hotel_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `day_transportation`
--
ALTER TABLE `day_transportation`
  ADD CONSTRAINT `day_transportation_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `day_transportation_transportation_id_foreign` FOREIGN KEY (`transportation_id`) REFERENCES `transportations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guide_pricings`
--
ALTER TABLE `guide_pricings`
  ADD CONSTRAINT `guide_pricings_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guide_spoken_language`
--
ALTER TABLE `guide_spoken_language`
  ADD CONSTRAINT `guide_spoken_language_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guide_spoken_language_spoken_language_id_foreign` FOREIGN KEY (`spoken_language_id`) REFERENCES `spoken_languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `monument_tour_days`
--
ALTER TABLE `monument_tour_days`
  ADD CONSTRAINT `monument_tour_days_monument_id_foreign` FOREIGN KEY (`monument_id`) REFERENCES `monuments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `monument_tour_days_tour_day_id_foreign` FOREIGN KEY (`tour_day_id`) REFERENCES `tour_days` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`),
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`);

--
-- Constraints for table `tour_days`
--
ALTER TABLE `tour_days`
  ADD CONSTRAINT `tour_days_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`),
  ADD CONSTRAINT `tour_days_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`),
  ADD CONSTRAINT `tour_days_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`);

--
-- Constraints for table `tour_day_transport`
--
ALTER TABLE `tour_day_transport`
  ADD CONSTRAINT `tour_day_transport_tour_day_id_foreign` FOREIGN KEY (`tour_day_id`) REFERENCES `tour_days` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_day_transport_transport_id_foreign` FOREIGN KEY (`transport_id`) REFERENCES `transports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transportation_pricings`
--
ALTER TABLE `transportation_pricings`
  ADD CONSTRAINT `transportation_pricings_transportation_id_foreign` FOREIGN KEY (`transportation_id`) REFERENCES `transportations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
