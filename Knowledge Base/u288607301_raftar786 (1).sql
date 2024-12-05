-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2024 at 09:26 AM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u288607301_raftar786`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_funds`
--

CREATE TABLE `add_funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(255) NOT NULL,
  `utr_no` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','disapproved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `add_funds`
--

INSERT INTO `add_funds` (`id`, `user_id`, `amount`, `utr_no`, `image`, `created_at`, `updated_at`, `status`) VALUES
(11, 1, '500.0', 'vc', 'addfund/oRkaWN1i53FubWSMO3tjxWTvXhrQ73oUPXLqb9yx.png', '2024-12-04 13:51:20', '2024-12-05 08:20:25', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `bets`
--

CREATE TABLE `bets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `pana` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `totalbet` decimal(10,2) NOT NULL,
  `bet` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`bet`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bets`
--

INSERT INTO `bets` (`id`, `user_id`, `game_id`, `game_name`, `pana`, `date`, `totalbet`, `bet`, `created_at`, `updated_at`) VALUES
(1, 1, 53, 'MAHARANI DAY', 'Single Digit', '2024-11-30', 250.00, '[{\"session\":\"close\",\"digits\":\"0\",\"amount\":\"250.0\"}]', '2024-11-30 13:03:37', '2024-11-30 13:03:37'),
(2, 1, 120, 'SUPER MATKA', 'Single Digit', '2024-11-30', 58.00, '[{\"session\":\"close\",\"digits\":\"0\",\"amount\":58}]', '2024-11-30 13:13:12', '2024-11-30 13:13:12'),
(3, 1, 120, 'SUPER MATKA', 'Single Digit', '2024-11-30', 2580.00, '[{\"session\":\"close\",\"digits\":\"0\",\"amount\":2580}]', '2024-11-30 13:22:10', '2024-11-30 13:22:10'),
(4, 1, 53, 'MAHARANI DAY', 'Single Digit', '2024-11-30', 265.00, '[{\"session\":\"close\",\"digits\":\"1\",\"amount\":10},{\"session\":\"close\",\"digits\":\"2\",\"amount\":25},{\"session\":\"close\",\"digits\":\"4\",\"amount\":50},{\"session\":\"close\",\"digits\":\"5\",\"amount\":60},{\"session\":\"close\",\"digits\":\"7\",\"amount\":100},{\"session\":\"close\",\"digits\":\"8\",\"amount\":20}]', '2024-11-30 13:38:56', '2024-11-30 13:38:56'),
(5, 1, 53, 'MAHARANI DAY', 'Single Pana', '2024-11-30', 90.00, '[{\"session\":\"close\",\"digits\":\"128\",\"amount\":10},{\"session\":\"close\",\"digits\":\"245\",\"amount\":10},{\"session\":\"close\",\"digits\":\"290\",\"amount\":10},{\"session\":\"close\",\"digits\":\"560\",\"amount\":10},{\"session\":\"close\",\"digits\":\"579\",\"amount\":50}]', '2024-11-30 13:39:36', '2024-11-30 13:39:36'),
(6, 1, 53, 'MAHARANI DAY', 'Single Pana', '2024-11-30', 100.00, '[{\"session\":\"close\",\"digits\":\"260\",\"amount\":10},{\"session\":\"close\",\"digits\":\"279\",\"amount\":50},{\"session\":\"close\",\"digits\":\"378\",\"amount\":20},{\"session\":\"close\",\"digits\":\"459\",\"amount\":20}]', '2024-11-30 13:40:11', '2024-11-30 13:40:11'),
(7, 1, 156, 'MILAN BAZAR MORNING', 'Single Digit', '2024-12-01', 350.00, '[{\"session\":\"close\",\"digits\":\"1\",\"amount\":50},{\"session\":\"close\",\"digits\":\"2\",\"amount\":50},{\"session\":\"close\",\"digits\":\"3\",\"amount\":50},{\"session\":\"close\",\"digits\":\"5\",\"amount\":50},{\"session\":\"close\",\"digits\":\"7\",\"amount\":50},{\"session\":\"close\",\"digits\":\"8\",\"amount\":50},{\"session\":\"close\",\"digits\":\"9\",\"amount\":50}]', '2024-12-01 06:51:00', '2024-12-01 06:51:00'),
(8, 1, 156, 'MILAN BAZAR MORNING', 'Single Pana', '2024-12-01', 600.00, '[{\"session\":\"close\",\"digits\":\"127\",\"amount\":50},{\"session\":\"close\",\"digits\":\"136\",\"amount\":50},{\"session\":\"close\",\"digits\":\"145\",\"amount\":50},{\"session\":\"close\",\"digits\":\"190\",\"amount\":50},{\"session\":\"close\",\"digits\":\"235\",\"amount\":50},{\"session\":\"close\",\"digits\":\"280\",\"amount\":50},{\"session\":\"close\",\"digits\":\"370\",\"amount\":50},{\"session\":\"close\",\"digits\":\"389\",\"amount\":50},{\"session\":\"close\",\"digits\":\"460\",\"amount\":50},{\"session\":\"close\",\"digits\":\"479\",\"amount\":50},{\"session\":\"close\",\"digits\":\"569\",\"amount\":50},{\"session\":\"close\",\"digits\":\"578\",\"amount\":50}]', '2024-12-01 06:52:12', '2024-12-01 06:52:12'),
(9, 1, 156, 'MILAN BAZAR MORNING', 'Single Pana', '2024-12-01', 600.00, '[{\"session\":\"close\",\"digits\":\"130\",\"amount\":50},{\"session\":\"close\",\"digits\":\"149\",\"amount\":50},{\"session\":\"close\",\"digits\":\"158\",\"amount\":50},{\"session\":\"close\",\"digits\":\"167\",\"amount\":50},{\"session\":\"close\",\"digits\":\"239\",\"amount\":50},{\"session\":\"close\",\"digits\":\"248\",\"amount\":50},{\"session\":\"close\",\"digits\":\"257\",\"amount\":50},{\"session\":\"close\",\"digits\":\"347\",\"amount\":50},{\"session\":\"close\",\"digits\":\"356\",\"amount\":50},{\"session\":\"close\",\"digits\":\"590\",\"amount\":50},{\"session\":\"close\",\"digits\":\"680\",\"amount\":50},{\"session\":\"close\",\"digits\":\"789\",\"amount\":50}]', '2024-12-01 06:53:27', '2024-12-01 06:53:27'),
(10, 1, 156, 'MILAN BAZAR MORNING', 'Single Pana', '2024-12-01', 600.00, '[{\"session\":\"close\",\"digits\":\"123\",\"amount\":50},{\"session\":\"close\",\"digits\":\"150\",\"amount\":50},{\"session\":\"close\",\"digits\":\"169\",\"amount\":50},{\"session\":\"close\",\"digits\":\"178\",\"amount\":50},{\"session\":\"close\",\"digits\":\"240\",\"amount\":50},{\"session\":\"close\",\"digits\":\"259\",\"amount\":50},{\"session\":\"close\",\"digits\":\"268\",\"amount\":50},{\"session\":\"close\",\"digits\":\"349\",\"amount\":50},{\"session\":\"close\",\"digits\":\"358\",\"amount\":50},{\"session\":\"close\",\"digits\":\"367\",\"amount\":50},{\"session\":\"close\",\"digits\":\"457\",\"amount\":50},{\"session\":\"close\",\"digits\":\"790\",\"amount\":50}]', '2024-12-01 06:54:02', '2024-12-01 06:54:02'),
(11, 1, 156, 'MILAN BAZAR MORNING', 'Single Digit', '2024-12-02', 50.00, '[{\"session\":\"close\",\"digits\":\"0\",\"amount\":25},{\"session\":\"close\",\"digits\":\"1\",\"amount\":25}]', '2024-12-02 05:54:08', '2024-12-02 05:54:08'),
(12, 1, 156, 'MILAN BAZAR MORNING', 'Single Digit', '2024-12-02', 2445.00, '[{\"session\":\"close\",\"digits\":\"0\",\"amount\":100},{\"session\":\"close\",\"digits\":\"1\",\"amount\":100},{\"session\":\"close\",\"digits\":\"2\",\"amount\":500},{\"session\":\"close\",\"digits\":\"3\",\"amount\":100},{\"session\":\"close\",\"digits\":\"4\",\"amount\":100},{\"session\":\"close\",\"digits\":\"5\",\"amount\":50},{\"session\":\"close\",\"digits\":\"6\",\"amount\":40},{\"session\":\"close\",\"digits\":\"7\",\"amount\":50},{\"session\":\"close\",\"digits\":\"8\",\"amount\":150},{\"session\":\"close\",\"digits\":\"9\",\"amount\":150},{\"session\":\"close\",\"digits\":\"0\",\"amount\":100},{\"session\":\"close\",\"digits\":\"1\",\"amount\":50},{\"session\":\"close\",\"digits\":\"2\",\"amount\":140},{\"session\":\"close\",\"digits\":\"3\",\"amount\":150},{\"session\":\"close\",\"digits\":\"4\",\"amount\":170},{\"session\":\"close\",\"digits\":\"5\",\"amount\":75},{\"session\":\"close\",\"digits\":\"6\",\"amount\":75},{\"session\":\"close\",\"digits\":\"7\",\"amount\":150},{\"session\":\"close\",\"digits\":\"8\",\"amount\":15},{\"session\":\"close\",\"digits\":\"9\",\"amount\":180}]', '2024-12-02 06:56:14', '2024-12-02 06:56:14'),
(13, 1, 4, 'DIAMOND BAZAR', 'Single Digit', '2024-12-03', 50.00, '[{\"session\":\"close\",\"digits\":\"0\",\"amount\":25},{\"session\":\"close\",\"digits\":\"1\",\"amount\":25}]', '2024-12-03 07:17:36', '2024-12-03 07:17:36'),
(14, 1, 85, 'KOHINOOR MORNING', 'Jodi Digit', '2024-12-03', 50.00, '[{\"digits\":\"0\",\"amount\":50}]', '2024-12-03 08:11:30', '2024-12-03 08:11:30'),
(15, 1, 50, 'MILAN NIGHT', 'Single Digit', '2024-12-03', 50.00, '[{\"session\":\"close\",\"digits\":\"2\",\"amount\":25},{\"session\":\"close\",\"digits\":\"5\",\"amount\":25}]', '2024-12-03 16:41:50', '2024-12-03 16:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gmail` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `telegram_link` varchar(255) DEFAULT NULL,
  `whatsapp_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `gmail`, `mobile_number`, `facebook_link`, `instagram_link`, `telegram_link`, `whatsapp_link`, `created_at`, `updated_at`) VALUES
(4, 'dev@gmail.com', '635002030', 'https://facebook.com/', 'https://instagram.com/', 'https://telegram.com/', 'https://whatsup.com/', '2024-12-03 12:52:34', '2024-12-03 12:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `earn_bonus`
--

CREATE TABLE `earn_bonus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `referral_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamecharts`
--

CREATE TABLE `gamecharts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `jodiUrl` varchar(255) NOT NULL,
  `panelUrl` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_chats`
--

CREATE TABLE `game_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `chart_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_rates`
--

CREATE TABLE `game_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_rates`
--

INSERT INTO `game_rates` (`id`, `name`, `rate`, `created_at`, `updated_at`) VALUES
(1, 'Single Digit', 9.50, '2024-12-02 12:32:42', '2024-12-02 12:32:42'),
(2, 'Jodi Digit', 95.00, '2024-12-02 12:33:01', '2024-12-02 12:33:01'),
(3, 'Single Panna', 150.00, '2024-12-02 12:33:21', '2024-12-02 12:33:21'),
(4, 'Double Panna', 300.00, '2024-12-02 12:33:54', '2024-12-02 12:33:54'),
(5, 'Tripple Panna', 800.00, '2024-12-02 12:34:12', '2024-12-02 12:34:12'),
(6, 'Half Sangam', 1200.00, '2024-12-02 12:34:33', '2024-12-02 12:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `game_results`
--

CREATE TABLE `game_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `market_id` bigint(20) UNSIGNED NOT NULL,
  `open` varchar(255) DEFAULT NULL,
  `jodi` varchar(255) DEFAULT NULL,
  `close` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `half_sangam_bets`
--

CREATE TABLE `half_sangam_bets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `pana` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `totalbet` decimal(10,2) NOT NULL,
  `bet` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`bet`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `how_to_play_videos`
--

CREATE TABLE `how_to_play_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `how_to_play_videos`
--

INSERT INTO `how_to_play_videos` (`id`, `video_link`, `created_at`, `updated_at`) VALUES
(1, 'https://www.youtube.com/watch?v=nGNmyt9Ywqc', '2024-11-16 13:16:03', '2024-12-03 13:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2014_10_12_000000_create_users_table', 3),
(11, '2014_10_12_100000_create_password_reset_tokens_table', 3),
(12, '2019_08_19_000000_create_failed_jobs_table', 3),
(5, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(6, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(7, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(8, '2016_06_01_000004_create_oauth_clients_table', 2),
(9, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(13, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(14, '2024_11_12_134618_create_notifications_table', 3),
(15, '2024_11_12_140012_create_game_chats_table', 3),
(16, '2024_11_12_141336_create_add_funds_table', 4),
(17, '2024_11_12_141841_create_withdrawals_table', 5),
(18, '2024_11_12_142347_add_wallet_balance_to_users_table', 6),
(23, '2024_11_14_050937_add_date_time_to_notifications_table', 7),
(24, '2024_11_14_083335_create_satta_matka_games_table', 8),
(25, '2024_11_14_134506_create_contact_us_table', 9),
(26, '2024_11_14_135513_add_msg_to_satta_matka_games_table', 10),
(28, '2024_11_15_131726_create_how_to_play_videos_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `date` date DEFAULT curdate(),
  `time` time DEFAULT curtime(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('021699064da632203c3eba9b34ee012c94dd8351db7cb000202212ba79e8db9b1905527db2f88b7d', 1, 1, 'UserToken', '[]', 0, '2024-11-11 18:47:07', '2024-11-11 18:47:07', '2025-11-11 11:47:07'),
('3f601eb4a8eb0822f2e2bda5ce55ea3b7770400c69b576ca55027545fd196f018dc8f9a0ebdbda6c', 1, 1, 'LoginToken', '[]', 0, '2024-11-14 12:46:58', '2024-11-14 12:46:58', '2025-11-14 05:46:58'),
('ada454ea8590927d13a9f44346746d20bb0f39f3af3015ffa9cc3e48f641aa6eb26f7d4a0fc0327e', 1, 1, 'LoginToken', '[]', 0, '2024-11-14 12:49:21', '2024-11-14 12:49:21', '2025-11-14 05:49:21'),
('ecff5a7c1e309396dde5088cd316d76488a6266b67a11b4367c56f3f2c592bddc521f25daf425881', 1, 1, 'LoginToken', '[]', 0, '2024-11-14 12:42:41', '2024-11-14 12:42:41', '2025-11-14 05:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', '0QCm6Fb6NJTtC4hVl1zFJ9Z0nhYQXH0xQkU2rsR4', NULL, 'http://localhost', 1, 0, 0, '2024-11-11 18:29:13', '2024-11-11 18:29:13'),
(2, NULL, 'Laravel Password Grant Client', 'eIfMrnoJco3XcfjhUkez59z56G3LyqR98q4Hiawp', 'users', 'http://localhost', 0, 1, 0, '2024-11-11 18:29:13', '2024-11-11 18:29:13');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-11-11 18:29:13', '2024-11-11 18:29:13');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_screenshots`
--

CREATE TABLE `payment_screenshots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `screenshot_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_screenshots`
--

INSERT INTO `payment_screenshots` (`id`, `screenshot_path`, `created_at`, `updated_at`) VALUES
(1, 'payment/gQJjBterhuBEgb1s8vhwtMZ9sHqEni1Tgnbbp9HU.jpg', '2024-11-29 09:42:09', '2024-11-29 09:42:09'),
(2, 'payment/ULSUsS3WSdR2gITSA0CGiWmbtcZs72mVnCJtkysn.jpg', '2024-11-29 11:12:29', '2024-11-29 11:12:29'),
(3, 'payment/uFvyGPJYYERTh0Md0vF5m6tz9r7ndOXMpLl6GJZF.webp', '2024-11-30 10:16:14', '2024-11-30 10:16:14'),
(4, 'payment/ky1KsMI05IHCKoGaxkKmjxrA4j7kZJfMi9C4i7rY.jpg', '2024-11-30 10:59:27', '2024-11-30 10:59:27');

-- --------------------------------------------------------

--
-- Table structure for table `pending_registrations`
--

CREATE TABLE `pending_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mpin` varchar(4) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pending_registrations`
--

INSERT INTO `pending_registrations` (`id`, `username`, `password`, `mpin`, `otp`, `created_at`, `updated_at`, `email`, `mobile_number`) VALUES
(1, 'bwyir', '$2y$10$sooBrls53..NkBFbStlmeeRjJDaS4wM3hqMstgvNbLzqCcGpnR3Om', '1234', 1097, '2024-12-02 12:10:19', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satta_matka_games`
--

CREATE TABLE `satta_matka_games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `open_time_formatted` varchar(255) NOT NULL,
  `close_time_formatted` varchar(255) NOT NULL,
  `market_id` varchar(255) NOT NULL,
  `market_name` varchar(255) NOT NULL,
  `aankdo_date` varchar(255) NOT NULL,
  `aankdo_open` varchar(255) NOT NULL,
  `aankdo_close` varchar(255) NOT NULL,
  `figure_open` varchar(255) DEFAULT NULL,
  `figure_close` varchar(255) NOT NULL,
  `jodi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `open_time` varchar(255) NOT NULL,
  `close_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satta_matka_games`
--

INSERT INTO `satta_matka_games` (`id`, `open_time_formatted`, `close_time_formatted`, `market_id`, `market_name`, `aankdo_date`, `aankdo_open`, `aankdo_close`, `figure_open`, `figure_close`, `jodi`, `created_at`, `updated_at`, `open_time`, `close_time`) VALUES
(3, '09:45 AM', '10:45 AM', '85', 'GOLDEN MORNING', '2024-11-29', '120', '370', '3', '3', '33', '2024-12-03 10:25:28', '2024-12-04 12:15:46', '2024-12-03 09:45:00', '2024-12-02 10:45:00'),
(4, '11:05 AM', '12:05 PM', '3', 'RAFTAR MORNING', '2024-12-03', '139', '377', '8', '8', '88', '2024-12-03 10:57:06', '2024-12-04 13:17:20', '2024-12-03 11:05:00', '2024-12-03 12:05:00'),
(5, '11:10 AM', '12:10 PM', '4', 'DIAMOND BAZAR', '2024-12-03', '140', '260', '7', '6', '76', '2024-12-03 10:58:46', '2024-12-04 13:17:20', '2024-12-03 11:10:00', '2024-12-03 12:10:00'),
(6, '11:35 AM', '12:35 PM', '6', 'RAFTAR DAY', '2024-12-03', '876', '678', '0', '8', '08', '2024-12-03 11:01:46', '2024-12-04 13:17:20', '2024-12-03 11:35:00', '2024-12-03 12:35:00'),
(7, '02:19 PM', '10:45 AM', '7', 'RAFTAR NIGHT', '2024-12-03', '324', '654', '5', '9', '59', '2024-12-03 11:05:03', '2024-12-04 13:17:20', '10:00 AM', '2024-12-03 10:45:00'),
(8, '10:00 AM', '06:32 PM', '8', 'MUMBAI NIGHT', '2024-12-03', '963', '234', '8', '4', '84', '2024-12-03 11:06:40', '2024-12-04 13:28:07', '10:00 AM', '06:00 PM'),
(9, '09:45 AM', '10:45 PM', '9', 'KALYAN RAJ', '2024-12-03', '789', '345', '7', '2', '72', '2024-12-03 11:07:15', '2024-12-04 13:28:11', '10:00 AM', '06:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_histories`
--

CREATE TABLE `transaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaction_histories`
--

INSERT INTO `transaction_histories` (`id`, `user_id`, `transaction_type`, `amount`, `transaction_date`, `created_at`, `updated_at`) VALUES
(17, 12, 'Deposit', 90.00, '2024-11-27', '2024-11-27 13:14:37', '2024-11-27 13:14:37'),
(52, 1, 'Deposit', 2580.00, '2024-12-03', '2024-12-03 06:17:18', '2024-12-03 06:17:18'),
(53, 1, 'Deposit', 5000.00, '2024-12-03', '2024-12-03 06:51:37', '2024-12-03 06:51:37'),
(54, 1, 'Deposit', 5000.00, '2024-12-03', '2024-12-03 06:57:38', '2024-12-03 06:57:38'),
(55, 1, 'Deposit', 2580.00, '2024-12-03', '2024-12-03 07:16:57', '2024-12-03 07:16:57'),
(56, 1, 'Deposit', 2558.00, '2024-12-03', '2024-12-03 07:19:43', '2024-12-03 07:19:43'),
(57, 1, 'Withdraw', 1000.00, '2024-12-03', '2024-12-03 07:20:27', '2024-12-03 07:20:27'),
(58, 1, 'Deposit', 500.00, '2024-12-03', '2024-12-03 08:11:01', '2024-12-03 08:11:01'),
(59, 1, 'Deposit', 50.00, '2024-12-03', '2024-12-03 09:37:23', '2024-12-03 09:37:23'),
(60, 1, 'Deposit', 5000.00, '2024-12-03', '2024-12-03 12:50:27', '2024-12-03 12:50:27'),
(61, 1, 'Withdraw', 480.00, '2024-12-03', '2024-12-03 12:50:46', '2024-12-03 12:50:46'),
(62, 1, 'Withdraw', 950.00, '2024-12-03', '2024-12-03 13:24:24', '2024-12-03 13:24:24'),
(63, 1, 'Withdraw', 588.00, '2024-12-03', '2024-12-03 13:25:05', '2024-12-03 13:25:05'),
(64, 1, 'Withdraw', 25.00, '2024-12-03', '2024-12-03 16:42:12', '2024-12-03 16:42:12'),
(65, 1, 'Deposit', 500.00, '2024-12-05', '2024-12-05 08:20:25', '2024-12-05 08:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `mobile_number` varchar(191) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mpin` varchar(4) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `distic` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wallet_balance` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `photo` varchar(255) DEFAULT NULL,
  `referral_code` varchar(255) DEFAULT NULL,
  `referred_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_verified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `mobile_number`, `password`, `mpin`, `state`, `distic`, `email`, `created_at`, `updated_at`, `wallet_balance`, `is_active`, `photo`, `referral_code`, `referred_by`, `is_verified`) VALUES
(1, 'Devashish', '+919100000000', '$2y$10$hCFVjRr1OU3nDAuyMONPWu5Hmq7plKTi6WdBWF.eZOeW8J7RVNbm.', '1234', 'rajsthani', 'jaipur', 'rksonipatan232@gmail.com', '2024-12-04 12:53:33', '2024-12-05 08:20:25', '500', 1, NULL, 'REF122DCA', NULL, NULL),
(3, 'bwyir', '9100000000', '$2y$10$5L3OTIzbADC0aKcJCSra/eE.qK9hdNwfQ7nhVY6xIByyTG1LI0Wum', '0000', NULL, NULL, 'devashish@kotiboxglobaltech.com', '2024-12-05 08:44:43', '2024-12-05 09:07:20', NULL, 1, NULL, 'REFE7BE12', NULL, NULL),
(4, 'bwyir', '91045000000', '$2y$10$6sNM14wfBQIot8jlpFA8K.xi0C0xvbzREEZWOaYtNjfC/n8TnpRd2', '1234', NULL, NULL, 'gefime9235@nausard.com', '2024-12-05 08:50:20', '2024-12-05 08:50:20', NULL, 1, NULL, 'REF54AF95', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_otps`
--

CREATE TABLE `user_otps` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_otps`
--

INSERT INTO `user_otps` (`id`, `user_id`, `otp`, `created_at`, `updated_at`) VALUES
(1, 6, '7472', '2024-12-02 10:03:10', NULL),
(5, 3, '5393', '2024-12-02 11:13:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `win_histories`
--

CREATE TABLE `win_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `result` varchar(255) DEFAULT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `upi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `user_id`, `amount`, `payment_method`, `upi`, `created_at`, `updated_at`) VALUES
(1, 1, 480.00, 'Paytm', 'dev@slice', '2024-12-03 12:50:46', '2024-12-03 12:50:46'),
(2, 1, 950.00, 'Paytm', 'dev@slic', '2024-12-03 13:24:24', '2024-12-03 13:24:24'),
(3, 1, 588.00, 'PhonePe', 'gcv', '2024-12-03 13:25:05', '2024-12-03 13:25:05'),
(4, 1, 25.00, 'PhonePe', 'dev@slice', '2024-12-03 16:42:12', '2024-12-03 16:42:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_funds`
--
ALTER TABLE `add_funds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earn_bonus`
--
ALTER TABLE `earn_bonus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `referral_id` (`referral_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_jobs_uuid_index` (`uuid`);

--
-- Indexes for table `gamecharts`
--
ALTER TABLE `gamecharts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_chats`
--
ALTER TABLE `game_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_chats_user_id_foreign` (`user_id`);

--
-- Indexes for table `game_rates`
--
ALTER TABLE `game_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_results`
--
ALTER TABLE `game_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `market_id` (`market_id`);

--
-- Indexes for table `half_sangam_bets`
--
ALTER TABLE `half_sangam_bets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `half_sangam_bets_ibfk_1` (`user_id`);

--
-- Indexes for table `how_to_play_videos`
--
ALTER TABLE `how_to_play_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_screenshots`
--
ALTER TABLE `payment_screenshots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personal_access_tokens_tokenable_type_index` (`tokenable_type`),
  ADD KEY `personal_access_tokens_tokenable_id_index` (`tokenable_id`);

--
-- Indexes for table `satta_matka_games`
--
ALTER TABLE `satta_matka_games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_mobile_number_unique` (`mobile_number`),
  ADD UNIQUE KEY `referral_code` (`referral_code`),
  ADD KEY `users_referred_by_foreign` (`referred_by`);

--
-- Indexes for table `user_otps`
--
ALTER TABLE `user_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `win_histories`
--
ALTER TABLE `win_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_funds`
--
ALTER TABLE `add_funds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bets`
--
ALTER TABLE `bets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `earn_bonus`
--
ALTER TABLE `earn_bonus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamecharts`
--
ALTER TABLE `gamecharts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `game_chats`
--
ALTER TABLE `game_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `game_rates`
--
ALTER TABLE `game_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `game_results`
--
ALTER TABLE `game_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `half_sangam_bets`
--
ALTER TABLE `half_sangam_bets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `how_to_play_videos`
--
ALTER TABLE `how_to_play_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_screenshots`
--
ALTER TABLE `payment_screenshots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satta_matka_games`
--
ALTER TABLE `satta_matka_games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_otps`
--
ALTER TABLE `user_otps`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `win_histories`
--
ALTER TABLE `win_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_funds`
--
ALTER TABLE `add_funds`
  ADD CONSTRAINT `add_funds_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `earn_bonus`
--
ALTER TABLE `earn_bonus`
  ADD CONSTRAINT `earn_bonus_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `earn_bonus_ibfk_2` FOREIGN KEY (`referral_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_chats`
--
ALTER TABLE `game_chats`
  ADD CONSTRAINT `game_chats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_results`
--
ALTER TABLE `game_results`
  ADD CONSTRAINT `game_results_ibfk_1` FOREIGN KEY (`market_id`) REFERENCES `satta_matka_games` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `half_sangam_bets`
--
ALTER TABLE `half_sangam_bets`
  ADD CONSTRAINT `half_sangam_bets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_referred_by_foreign` FOREIGN KEY (`referred_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
