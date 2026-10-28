-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2026 at 03:23 PM
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
-- Database: `personal_care_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `session_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(13, 'tKdPIDnAOfpltHzovc18YvWGD3EAs6yx6gpdbkV6', 2, 1, '2026-06-19 12:07:51', '2026-06-19 12:07:51'),
(22, 'Zhw1TPMhsRxrJVuEgorVqV7K6iyHD8gGi2gHOecz', 3, 1, '2026-06-21 08:00:58', '2026-06-21 08:00:58');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'cafe', 'cafe', NULL, NULL, NULL, 1, 0, '2026-06-19 12:29:36', '2026-06-19 12:29:36'),
(3, 'phone', 'phone', NULL, NULL, NULL, 1, 0, '2026-06-19 12:29:42', '2026-06-19 12:29:42'),
(4, 'wmni', 'wmni', NULL, NULL, NULL, 1, 0, '2026-06-21 11:56:40', '2026-06-21 11:56:40');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `admin_reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `admin_reply`, `replied_at`, `created_at`, `updated_at`) VALUES
(1, 'Joty Prokash Biswas', 'jotybiswas0199@gmail.com', 'xfgfdbgcn ghjygki', 'dfrrgtrf', '2026-06-21 08:39:06', '2026-06-21 08:34:53', '2026-06-21 08:39:06'),
(2, 'Joty Prokash Biswas', 'jotybiswas0199@gmail.com', 'dfgrt ghjy dgyhuj76 ghjyu77i', NULL, NULL, '2026-06-21 08:39:38', '2026-06-21 08:39:38');

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
(4, '2026_06_19_140119_add_is_admin_to_users_table', 1),
(5, '2026_06_19_141441_create_categories_table', 1),
(6, '2026_06_19_141441_create_orders_table', 1),
(7, '2026_06_19_141441_create_products_table', 1),
(8, '2026_06_19_141442_create_order_items_table', 1),
(9, '2026_06_19_141442_create_reviews_table', 1),
(10, '2026_06_19_141442_create_shipping_addresses_table', 1),
(11, '2026_06_19_141443_create_carts_table', 1),
(12, '2026_06_19_141444_create_payment_details_table', 2),
(13, '2026_06_19_141445_add_payment_proof_to_orders_table', 2),
(14, '2026_06_19_150000_create_settings_table', 3),
(15, '2026_06_19_160000_update_settings_delivery_charge', 4),
(16, '2026_06_19_160001_add_discount_name_to_products', 5),
(17, '2026_06_19_170001_add_discount_percent_to_products', 6),
(18, '2026_06_20_120000_add_contact_fields_to_settings_table', 7),
(19, '2026_06_20_130000_add_image_to_reviews_table', 8),
(20, '2026_06_21_141332_add_newsletter_fields_to_settings_table', 9),
(21, '2026_06_21_143038_create_contact_messages_table', 10),
(22, '2026_06_21_140000_add_cancelled_by_to_orders_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `payment_method` varchar(255) DEFAULT NULL,
  `cancelled_by` varchar(255) DEFAULT NULL COMMENT 'Tracks who cancelled the order: "user" or "admin". Null if not cancelled.',
  `stripe_payment_id` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `guest_email`, `user_id`, `status`, `subtotal`, `shipping_cost`, `tax`, `total`, `payment_status`, `payment_method`, `cancelled_by`, `stripe_payment_id`, `transaction_id`, `proof_image`, `created_at`, `updated_at`) VALUES
(11, 'ORD-JWLSDWFFMT', 'jotybiswas0199@gmail.com', 1, 'delivered', 135.00, 150.00, 6.75, 291.75, 'approved', NULL, NULL, NULL, '34r55e4t5rtyr6tr', 'proofs/7Q0MOsDJU4f4cUkSxEOTzJbxavRmAyN3LoM0lLCm.jpg', '2026-06-19 12:06:24', '2026-06-19 12:06:47'),
(12, 'ORD-EKKP42BADS', 'jotybiswas0199@gmail.com', NULL, 'delivered', 135.00, 60.00, 6.75, 201.75, 'approved', NULL, NULL, NULL, '34r55e4t5rtyr6tr', 'proofs/CzLqtz4XhbeKfJd8rxASYaJ7Pb11WVXeVaz51q0V.png', '2026-06-19 12:08:08', '2026-06-21 11:28:34'),
(13, 'ORD-WWBXP9NAIC', 'jotybiswas019@gmail.com', NULL, 'cancelled', 135.00, 60.00, 6.75, 201.75, 'rejected', NULL, NULL, NULL, '34r55e4t5rtyr6tr', 'proofs/nLnxuOrg98J4JuqGdZzeUIuD0U3Tq8VJXBd8vmRa.png', '2026-06-19 12:20:11', '2026-06-21 08:47:53'),
(14, 'ORD-BLTOMCETQM', 'jotybiswas01@gmail.com', 3, 'delivered', 135.00, 60.00, 6.75, 201.75, 'approved', NULL, NULL, NULL, '34r55e4t5rtyr6tr', 'proofs/aSLrhDM2QlwyD33JkYTxkNBGBYtu0q6zquvjqo6s.png', '2026-06-19 12:21:21', '2026-06-19 12:22:47'),
(15, 'ORD-LWPQLXD5HN', 'jotybiswas0199@gmail.com', 1, 'delivered', 250.00, 60.00, 12.50, 322.50, 'approved', NULL, NULL, NULL, '34r55e4t5rtyr6tr', 'proofs/FcDPSC8AluzjdRPcfG8lU61qhyt0gQoD3iABVoOk.jpg', '2026-06-19 12:30:15', '2026-06-19 12:30:51'),
(16, 'ORD-GVFYXV6JYJ', 'jotybiswas0199@gmail.com', 1, 'delivered', 810.00, 60.00, 40.50, 910.50, 'approved', NULL, NULL, NULL, '34r55e4t5rtyr6tr', 'proofs/muiIO7COtMLUNVogMNBMiQI0CnRtpSfEBq4qYQDK.png', '2026-06-19 13:58:30', '2026-06-19 13:58:52'),
(17, 'ORD-8QEI8Q0YB5', 'jotybiswas0199@gmail.com', 1, 'delivered', 855.00, 60.00, 42.75, 957.75, 'approved', NULL, NULL, NULL, '34r55e4t5rtyr6tr', 'proofs/0FNNXefu3P5E1NPIQksEn5jDhLBwWNe6vw8e2i7X.png', '2026-06-19 13:59:53', '2026-06-19 14:00:20'),
(18, 'ORD-W7YBIE4H47', 'jotybiswas0199@gmail.com', 1, 'cancelled', 480.00, 60.00, 24.00, 564.00, 'cancelled', NULL, NULL, NULL, '34r55e4t5rtyr6tr', 'proofs/glv1169bx7CcxqR2fsLdYrwy46l5tQ9ANw1rvvs3.png', '2026-06-21 09:08:27', '2026-06-21 09:20:46'),
(19, 'ORD-AE1ZC3LRDF', 'test@example.com', NULL, 'delivered', 480.00, 60.00, 24.00, 564.00, 'unpaid', NULL, NULL, NULL, NULL, NULL, '2026-06-21 09:21:43', '2026-06-21 13:01:26'),
(20, 'ORD-XHR46LO4EO', 'jotybiswas0199@gmail.com', 1, 'cancelled', 135.00, 60.00, 6.75, 201.75, 'cancelled', NULL, 'user', NULL, NULL, NULL, '2026-06-21 09:26:45', '2026-06-21 09:26:50'),
(21, 'ORD-DLIARISA1J', 'jotybiswas0199@gmail.com', 1, 'cancelled', 135.00, 60.00, 6.75, 201.75, 'paid', NULL, 'admin', NULL, '34r55e4t5rtyr6tr', 'proofs/UjoXw1mSb1uJNcAdNqgW62mnhLceZc7VMLKVLuG7.png', '2026-06-21 09:27:45', '2026-06-21 09:32:46'),
(22, 'ORD-SWXSGJFCSL', 'jotybiswas0199@gmail.com', 1, 'cancelled', 225.00, 60.00, 11.25, 296.25, 'unpaid', NULL, 'admin', NULL, NULL, NULL, '2026-06-21 09:36:46', '2026-06-21 09:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(12, 11, 2, 'Espresso', 135.00, 1, 135.00, '2026-06-19 12:06:24', '2026-06-19 12:06:24'),
(13, 12, 2, 'Espresso', 135.00, 1, 135.00, '2026-06-19 12:08:08', '2026-06-19 12:08:08'),
(14, 13, 2, 'Espresso', 135.00, 1, 135.00, '2026-06-19 12:20:11', '2026-06-19 12:20:11'),
(15, 14, 2, 'Espresso', 135.00, 1, 135.00, '2026-06-19 12:21:21', '2026-06-19 12:21:21'),
(16, 15, 3, 'iphone 12', 250.00, 1, 250.00, '2026-06-19 12:30:15', '2026-06-19 12:30:15'),
(17, 16, 2, 'Espresso', 135.00, 6, 810.00, '2026-06-19 13:58:30', '2026-06-19 13:58:30'),
(18, 17, 3, 'iphone 12', 225.00, 2, 450.00, '2026-06-19 13:59:53', '2026-06-19 13:59:53'),
(19, 17, 2, 'Espresso', 135.00, 3, 405.00, '2026-06-19 13:59:53', '2026-06-19 13:59:53'),
(20, 18, 4, 'Masum', 240.00, 2, 480.00, '2026-06-21 09:08:27', '2026-06-21 09:08:27'),
(21, 19, 4, 'Masum', 240.00, 2, 480.00, '2026-06-21 09:21:43', '2026-06-21 09:21:43'),
(22, 20, 2, 'Espresso', 135.00, 1, 135.00, '2026-06-21 09:26:45', '2026-06-21 09:26:45'),
(23, 21, 2, 'Espresso', 135.00, 1, 135.00, '2026-06-21 09:27:45', '2026-06-21 09:27:45'),
(24, 22, 3, 'iphone 12', 225.00, 1, 225.00, '2026-06-21 09:36:46', '2026-06-21 09:36:46');

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
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_holder` varchar(255) NOT NULL,
  `instructions` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `bank_name`, `account_number`, `account_holder`, `instructions`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'ttyty', '4565696', 'tytyt', 'gfdghhfg fghutyu fhtyu', 1, '2026-06-19 09:37:00', '2026-06-19 09:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `discount_name` varchar(255) DEFAULT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL COMMENT 'Weight in kg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `short_description`, `price`, `sale_price`, `discount_name`, `discount_percent`, `stock_quantity`, `sku`, `category_id`, `brand`, `images`, `is_active`, `is_featured`, `meta_title`, `meta_description`, `weight`, `created_at`, `updated_at`) VALUES
(2, 'Espresso', 'espresso', 'tytr5u rty56 tryuy6u try56\r\nrdygt566uh tyjh76o\r\nfhggtjuu7 thj6ik8 tgjyu7ki\r\ntytr5u rty56 tryuy6u try56\r\nrdygt566uh tyjh76o\r\nfhggtjuu7 thj6ik8 tgjyu7ki\r\ntytr5u rty56 tryuy6u try56\r\nrdygt566uh tyjh76o\r\nfhggtjuu7 thj6ik8 tgjyu7ki', 'etrr rthuyk', 100.00, 150.00, 'Stock Clearance', 10.00, 5, 'rtrytr', 2, 'fdrg', '[\"products\\/sQ7C4haTm3OMRyHRhmcUKEpuSGh0ZPDKWsvqQQHk.png\"]', 1, 0, NULL, NULL, NULL, '2026-06-19 11:49:23', '2026-06-21 11:28:34'),
(3, 'iphone 12', 'iphone-12', 'fdghtyj dghjyu dghhjyuk', 'sdg fgjhtyg fhbgjh', 200.00, 250.00, NULL, 10.00, 17, NULL, 3, 'iphone', '[\"products\\/0IQTCybSjJJ9j7Gyh0b2VrIF8UXJ9wGWbsKV34w5.jpg\"]', 1, 0, NULL, NULL, NULL, '2026-06-19 12:29:08', '2026-06-19 14:00:20'),
(4, 'Masum', 'masum', 'fgchth tju76 tyik8k yuik8', 'rgtter fghtyj tyjyu', 200.00, 300.00, NULL, 20.00, 48, NULL, 3, 'fdrg', '[\"products\\/P3rHReTI10foYfpm2C1MULChq5FFWofLlOzRwTG8.png\"]', 1, 0, NULL, NULL, NULL, '2026-06-21 08:43:57', '2026-06-21 13:01:26'),
(5, 'Dark Algo 5', 'dark-algo-5', NULL, 'tr fdg', 100.00, 120.00, NULL, NULL, 10, NULL, 4, 'wasa', '[\"products\\/XcGueingTphsuVITTOek6pxQ5byT8Yjom0fcQN5O.png\"]', 1, 0, NULL, NULL, NULL, '2026-06-21 11:56:15', '2026-06-21 11:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_name` varchar(255) DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `admin_reply` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `order_id`, `guest_name`, `guest_email`, `user_id`, `rating`, `title`, `body`, `image`, `is_approved`, `admin_reply`, `created_at`, `updated_at`) VALUES
(1, 3, 15, NULL, NULL, 1, 3, NULL, 'good', 'reviews/W99vwh9TgTrdlDJxW1pTqKckkKWJNrEUr3EBhe25.jpg', 0, NULL, '2026-06-19 12:52:49', '2026-06-19 12:52:49'),
(2, 2, 11, NULL, NULL, 1, 3, NULL, 'rtferetygr', NULL, 1, 'ggfh', '2026-06-19 12:57:30', '2026-06-19 12:58:20'),
(3, 2, 16, NULL, NULL, 1, 3, NULL, 'dthyt  hgjyujki', 'reviews/URSeUbox7rOxpwTu9J8CkT6Rt8UJpKYlsRhbncHi.png', 1, NULL, '2026-06-21 08:45:38', '2026-06-21 08:45:38');

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

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'BDT',
  `delivery_charge_inside` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_charge_outside` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vat_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `contact_hours` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `newsletter_heading` varchar(255) DEFAULT 'Stay in the Loop',
  `newsletter_text` text DEFAULT 'Subscribe to get notified about new products, exclusive offers, and care tips delivered to your inbox.',
  `newsletter_placeholder` varchar(255) DEFAULT 'Enter your email address',
  `newsletter_button_text` varchar(255) DEFAULT 'Subscribe',
  `newsletter_enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `currency`, `delivery_charge_inside`, `delivery_charge_outside`, `vat_percentage`, `contact_phone`, `contact_email`, `contact_address`, `contact_hours`, `created_at`, `updated_at`, `newsletter_heading`, `newsletter_text`, `newsletter_placeholder`, `newsletter_button_text`, `newsletter_enabled`) VALUES
(1, 'BDT', 60.00, 150.00, 5.00, '+8801403107510', 'jotybiswas0199@gmail.com', '22/2, Kabi Nazrul Sarak, west Tootpara', NULL, NULL, '2026-06-21 11:55:08', 'Stay in the Loop', 'Subscribe to get notified about new products, exclusive offers, and care tips delivered to your inbox.', 'Enter your email address', 'Subscribe', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `order_id`, `first_name`, `last_name`, `email`, `phone`, `address_line1`, `address_line2`, `city`, `state`, `postal_code`, `country`, `created_at`, `updated_at`) VALUES
(11, 11, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', NULL, '9100', 'Bangladesh', '2026-06-19 12:06:24', '2026-06-19 12:06:24'),
(12, 12, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', 'Bangladesh', '9100', 'Bangladesh', '2026-06-19 12:08:08', '2026-06-19 12:08:08'),
(13, 13, 'Joty Prokash', 'Biswas', 'jotybiswas019@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', NULL, '9100', 'Bangladesh', '2026-06-19 12:20:11', '2026-06-19 12:20:11'),
(14, 14, 'Joty Prokash', 'Biswas', 'jotybiswas01@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', 'Bangladesh', '9100', 'Bangladesh', '2026-06-19 12:21:21', '2026-06-19 12:21:21'),
(15, 15, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', 'Bangladesh', '9100', 'Bangladesh', '2026-06-19 12:30:15', '2026-06-19 12:30:15'),
(16, 16, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', 'Bangladesh', '9100', 'Bangladesh', '2026-06-19 13:58:30', '2026-06-19 13:58:30'),
(17, 17, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', 'Bangladesh', '9100', 'Bangladesh', '2026-06-19 13:59:53', '2026-06-19 13:59:53'),
(18, 18, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', 'Bangladesh', '9100', 'Bangladesh', '2026-06-21 09:08:27', '2026-06-21 09:08:27'),
(19, 19, 'Test', 'User', 'test@example.com', '01700000000', '123 Test Street', NULL, 'Khulna', NULL, '9000', 'Bangladesh', '2026-06-21 09:21:43', '2026-06-21 09:21:43'),
(20, 20, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', 'Bangladesh', '9100', 'Bangladesh', '2026-06-21 09:26:45', '2026-06-21 09:26:45'),
(21, 21, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', 'Bangladesh', '9100', 'Bangladesh', '2026-06-21 09:27:45', '2026-06-21 09:27:45'),
(22, 22, 'Joty Prokash', 'Biswas', 'jotybiswas0199@gmail.com', '01403107510', '22/2, Kabi Nazrul Sarak, west Tootpara', '22/2, Kabi Nazrul Sarak, west Tootpara', 'Khulna', NULL, '9100', 'Bangladesh', '2026-06-21 09:36:46', '2026-06-21 09:36:46');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 'Joty Prokash Biswas', 'jotybiswas0199@gmail.com', '2026-06-19 14:51:12', '$2y$12$TjPDU3f0E3oK7QSuRkOZOOCXyU3Cb/qDYKtlzvQNnVVEzbRRo7DNy', NULL, '2026-06-19 08:51:03', '2026-06-21 12:19:20', 1),
(2, 'tyt ytjuy', 'jotybiswas099@gmail.com', NULL, '$2y$12$l4An.313djoY82qhSu0TXOKv0R3B0MLNIBI4MNPi7t6naUD27IOC.', NULL, '2026-06-19 10:45:13', '2026-06-19 10:45:13', 0),
(3, 'Joty Prokash Biswas', 'jotybiswas01@gmail.com', NULL, '$2y$12$KuJvJKAZ20KgDQ7iPpSTvOKW3deRkOQJRwm8PmbJYZpS6zRJ/rhVC', NULL, '2026-06-19 12:21:11', '2026-06-19 12:21:11', 0),
(4, 'Test User', 'test@example.com', NULL, '$2y$12$a09iVIz.J4ZlBBKVZwVBwuA7Ituf81ait.MiihGjfxO6dd7xe6IlW', NULL, '2026-06-21 12:53:55', '2026-06-21 12:53:55', 0),
(5, 'Admin', 'admin@test.com', NULL, '$2y$12$9tWgpmEhN7Ftvw4bZMNOreNU7nodZ9i/vnTdsITBm02yMggtYTdvi', NULL, '2026-06-21 12:54:47', '2026-06-21 12:54:47', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_order_id_foreign` (`order_id`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
