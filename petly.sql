-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2026 at 01:34 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petly`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` bigint UNSIGNED NOT NULL,
  `customer_user_id` bigint UNSIGNED NOT NULL,
  `foreign_product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `total_price` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `customer_user_id`, `foreign_product_id`, `quantity`, `total_price`, `created_at`, `updated_at`) VALUES
(3, 3, 3, 3, 389700, '2025-12-21 01:30:04', '2025-12-21 01:30:04'),
(6, 3, 9, 2, 140000, '2025-12-22 01:30:53', '2025-12-22 01:30:53');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`address`, `created_at`, `updated_at`, `user_user_id`) VALUES
('Peta Selatan, Jakarta Barat', '2025-12-20 23:27:20', '2025-12-22 01:42:47', 3);

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` bigint UNSIGNED NOT NULL,
  `delivery_deadline` datetime NOT NULL,
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_id` bigint UNSIGNED DEFAULT NULL,
  `delivery_delivery_class_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`delivery_id`, `delivery_deadline`, `delivery_address`, `courier_id`, `delivery_delivery_class_id`, `created_at`, `updated_at`) VALUES
(1, '2025-12-25 08:50:04', 'peta selatan dalam, 11840', NULL, 1, '2025-12-21 01:50:04', '2025-12-21 01:50:04'),
(2, '2025-12-25 08:58:17', 'peta selatan dalam, 11840', NULL, 1, '2025-12-21 01:58:17', '2025-12-21 01:58:17'),
(3, '2025-12-25 08:58:59', 'peta selatan dalam, 11840', NULL, 1, '2025-12-21 01:58:59', '2025-12-21 01:58:59');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_classes`
--

CREATE TABLE `delivery_classes` (
  `delivery_class_id` bigint UNSIGNED NOT NULL,
  `delivery_class_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_class_price` int NOT NULL,
  `delivery_class_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_classes`
--

INSERT INTO `delivery_classes` (`delivery_class_id`, `delivery_class_name`, `delivery_class_price`, `delivery_class_desc`, `created_at`, `updated_at`) VALUES
(1, 'Standard', 5000, 'Estimasi sampai 2 - 4 hari', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(2, 'Ekspress', 7000, 'Estimasi sampai 1 - 2 hari', '2025-12-20 23:13:21', '2025-12-20 23:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_03_10_120839_create_roles_table', 1),
(2, '2025_03_10_121600_create_users_table', 1),
(3, '2025_03_11_054312_personal_access_tokens', 1),
(4, '2025_03_11_102858_create_pet_types_table', 1),
(5, '2025_03_12_073853_create_customers_table', 1),
(6, '2025_03_17_032826_create_couriers_table', 1),
(7, '2025_03_17_130218_create_admins_table', 1),
(8, '2025_03_18_072558_create_product_types_table', 1),
(9, '2025_03_18_072932_create_pets_table', 1),
(10, '2025_03_20_051655_create_delivery_classes_table', 1),
(11, '2025_03_21_035012_create_payment_methods_table', 1),
(12, '2025_03_21_040629_create_deliveries_table', 1),
(13, '2025_03_21_042355_create_transaction_statuses_table', 1),
(14, '2025_03_21_044044_create_products_table', 1),
(15, '2025_03_21_093716_create_carts_table', 1),
(16, '2025_03_21_093717_create_transactions_table', 1),
(17, '2025_03_21_093719_create_transaction_details_table', 1),
(18, '2025_03_28_033726_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` bigint UNSIGNED NOT NULL,
  `payment_payment_method_id` bigint UNSIGNED NOT NULL,
  `payment_transaction_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `payment_payment_method_id`, `payment_transaction_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-12-21 01:50:04', '2025-12-21 01:50:04'),
(2, 1, 3, '2025-12-21 01:58:17', '2025-12-21 01:58:17'),
(3, 1, 4, '2025-12-21 01:58:59', '2025-12-21 01:58:59');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `payment_method_id` bigint UNSIGNED NOT NULL,
  `payment_method_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`payment_method_id`, `payment_method_name`, `created_at`, `updated_at`) VALUES
(1, 'Credit Card', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(2, 'COD', '2025-12-20 23:13:21', '2025-12-20 23:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(7, 'App\\Models\\User', 2, 'auth_token', 'a3a96f55468861b12cb12c5778606c9ee2a25be70ef8268bcf58beeb86164983', '[\"*\"]', NULL, NULL, '2025-12-21 02:00:16', '2025-12-21 02:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `pet_types`
--

CREATE TABLE `pet_types` (
  `pet_type_id` bigint UNSIGNED NOT NULL,
  `pet_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pet_types`
--

INSERT INTO `pet_types` (`pet_type_id`, `pet_type_name`, `created_at`, `updated_at`) VALUES
(1, 'dog', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(2, 'cat', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(3, 'rabbit', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(4, 'turtle', '2025-12-20 23:13:21', '2025-12-20 23:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_product_type_id` bigint UNSIGNED NOT NULL,
  `pet_pet_types_id` bigint UNSIGNED NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_stock` int NOT NULL,
  `product_rating` int NOT NULL,
  `product_price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_desc`, `product_product_type_id`, `pet_pet_types_id`, `product_image`, `product_stock`, `product_rating`, `product_price`, `created_at`, `updated_at`) VALUES
(1, 'Smartheart 1 Kg Makanan Kelinci Rasa Apel', 'Rasa apel\nMenjaga kesehatan kulit dan bulu kelinci\nKaya vitamin dan mineral', 1, 3, 'https://images.tokopedia.net/img/cache/700/hDjmkQ/2025/3/7/8f24522d-658b-46a0-91b2-3ec3518a49a7.jpg.webp?ect=4g', 19, 4, 49900, '2025-12-20 23:13:21', '2025-12-21 01:50:04'),
(2, 'Royal Canin 3 Kg Makanan Anjing Kering Adult Cihuahua', 'Makanan khusus untuk anjing Chihuahua\nKandungan nutrisi lengkap dan seimbang untuk sistem imun atau kekebalan tubuh\nMenjaga kesehatan bulu agar lebih lebat dan berkilau\nMendukung kesehatan, gigi, tulang, dan persendian\nMencegah masalah pencernaan\nMerangsang nafsu makan anjing\nMengurangi bau tidak sedap pada kotoran anjing\nRasa lezat yang disukai anjing\nMemiliki bentuk dan ukuran kibble yang disesuaikan secara khusus', 1, 1, 'https://images.tokopedia.net/img/cache/700/hDjmkQ/2025/2/13/3c04fa21-cdc1-4c11-8baa-721ae95ebefc.jpg.webp?ect=4g', 55, 10, 445900, '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(3, 'Pet Kingdom Wanpy 1.5 kg Makanan Kucing Kering Kitten grain Free Tuna', 'Terbuat dari bahan-bahan berkualitas\nDilengkapi 91% protein hewani\nGrain-free (tanpa tambahan jangung, gandum, kedelai, atau kacang-kacangan)\nMeningkatkan sistem imun tubuh anak kucing selama masa pertumbuhan\nMembantu melatih insting alami kucing untuk mengunyah\nTekstur mudah dicerna\nRasa dan aroma yang disukai kucing\nIsi : 1.5 kg', 1, 2, 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/3/25/c7f6f805-9520-432a-bc5f-1172e6e318e9.jpg.webp?ect=4g', 56, 10, 129900, '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(4, 'Pet Kingdom Aatas Cat 80 gr Makanan Kucing Basah Daily Defence', 'Disajikan dalam jelly gurih untuk pengalaman makan yang nikmat\nGrain free\nDengan kombinasi bahan berkualitas\nMengandung Ammonium Chloride\nMendukung kesehatan saluran kemih\nMembantu mencegah pembentukan batu ginjal dan kandung kemih\nMenambah variasi makanan serta membantu hidrasi kucing\nMemiliki rasa lezat yang disukai kucing \nIsi : 80 gr', 1, 2, 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/3/25/55a165ac-76d0-4ce6-9e05-5aa8126190e6.jpg.webp?ect=4g', 10, 7, 16900, '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(5, 'Pet Kingdom Ukuran S Coolpet Tali Ikatan Badan - Ungu/Hijau Mint', 'Perpaduan warna menarik\nDilengkapi lubang pengait dan clip\nDapat dikaitkan dengan tali anjing\nPanjang dan lebar tali dapat disesuaikan\nMudah dipasang dan nyaman saat digunakan\nMaterial berkualitas, kuat, dan awet\nCocok untuk mengawasi atau membawa pergi anjing\nUkuran : S', 2, 1, 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/3/5/4e4bb299-1f82-4e2f-99a2-889610016a0e.jpg.webp?ect=4g', 12, 5, 53940, '2025-12-20 23:13:21', '2025-12-21 01:58:59'),
(6, 'Pet Kingdom M-Pets Ukuran L Java Tempat Tidur Anjing Dengan Cushion  ', 'Cushion dengan kualitas bantalan empuk dan nyaman saat digunakan\nKeranjang mudah dibersihkan\nMudah dipindahkan\nMaterial berkualitas dan awet\nCocok digunakan sebagai tempat istirahat atau area tidur anjing\nUkuran : L', 2, 1, 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/2/21/c7e3bcf5-aeff-430c-a739-fe7d27547a68.jpg.webp?ect=4g', 72, 9, 459900, '2025-12-20 23:13:21', '2025-12-21 01:58:17'),
(7, 'Pet Kingdom 200 Ml Rose Parfum Hewan', 'Praktis digunakan\nBebas alkohol\nAman untuk hewan peliharaan\nDapat digunakan untuk anjing dan kucing\nMembuat bulu terasa halus, berkilau, dan wangi\nAroma : mawar\nIsi : 200 ml', 3, 1, 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/2/13/93359398-1875-4b5c-a0fd-9fd430a4d496.jpg.webp?ect=4g', 93, 8, 119900, '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(8, 'Pet Kingdom Germ Killer 500 ml Spray Disinfektan', 'Praktis digunakan\nDisinfektan cair premium water based\nTersertifikasi oleh lembaga di Amerika dan Singapore\nHospital grade Efektif membunuh 99.99999% bakteri dan virus (termasuk SARS-CoV-2, H1N1, dan patogen berbahaya lainnya)\nMampu mencegah pertumbuhan jamur dan lumut\nDapat menghilangkan bau', 3, 1, 'https://images.tokopedia.net/img/cache/700/hDjmkQ/2025/3/6/6d530216-9e3f-45a3-a22c-cfdef9c118a7.jpg.webp?ect=4g', 98, 10, 198000, '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(9, 'Sampo Hewan Extra Care Neem Tree Oil Grooming Anjing Mandi Peliharaan Pembersih Bulu Perawatan Peliharaan', 'Dapat menghilangkan gatal \r\n\r\nDapat melindungi kulit hewan peliharaan\r\n\r\nMengurangi radang dan kemerahan\r\n\r\nMengusir serangga secara alami\r\n\r\nTidak menggunakan pewarna', 2, 1, 'https://down-id.img.susercontent.com/file/sg-11134201-7reo2-m2c8bfxjr08ada@resize_w900_nl.webp', 15, 9, 70000, '2025-12-22 01:30:26', '2025-12-22 01:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `product_type_id` bigint UNSIGNED NOT NULL,
  `product_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`product_type_id`, `product_type_name`, `created_at`, `updated_at`) VALUES
(1, 'food', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(2, 'accesories', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(3, 'medicine', '2025-12-20 23:13:21', '2025-12-20 23:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'customer', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(2, 'courier', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(3, 'admin', '2025-12-20 23:13:21', '2025-12-20 23:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` bigint UNSIGNED NOT NULL,
  `transaction_date` datetime NOT NULL,
  `user_user_id` bigint UNSIGNED DEFAULT NULL,
  `delivery_delivery_id` bigint UNSIGNED DEFAULT NULL,
  `foreign_cart_id` bigint UNSIGNED DEFAULT NULL,
  `transactions_transaction_status_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `transaction_date`, `user_user_id`, `delivery_delivery_id`, `foreign_cart_id`, `transactions_transaction_status_id`, `created_at`, `updated_at`) VALUES
(1, '2025-12-21 08:10:36', 3, NULL, NULL, 3, '2025-12-21 01:10:36', '2025-12-21 01:10:36'),
(2, '2025-12-21 08:12:52', 3, 1, NULL, 2, '2025-12-21 01:12:52', '2025-12-21 01:50:04'),
(3, '2025-12-21 08:58:15', 3, 2, NULL, 2, '2025-12-21 01:58:15', '2025-12-21 01:58:17'),
(4, '2025-12-21 08:58:56', 3, 3, NULL, 2, '2025-12-21 01:58:56', '2025-12-21 01:58:59');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `total_payment` int NOT NULL,
  `quantity` int NOT NULL,
  `foreign_product_id` bigint UNSIGNED NOT NULL,
  `transaction_transaction_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`total_payment`, `quantity`, `foreign_product_id`, `transaction_transaction_id`, `created_at`, `updated_at`) VALUES
(174700, 3, 1, 1, '2025-12-21 01:10:36', '2025-12-21 01:10:36'),
(174700, 3, 1, 2, '2025-12-21 01:12:52', '2025-12-21 01:12:52'),
(1404700, 3, 6, 3, '2025-12-21 01:58:15', '2025-12-21 01:58:15'),
(132880, 2, 5, 4, '2025-12-21 01:58:56', '2025-12-21 01:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_statuses`
--

CREATE TABLE `transaction_statuses` (
  `transaction_status_id` bigint UNSIGNED NOT NULL,
  `transaction_status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_statuses`
--

INSERT INTO `transaction_statuses` (`transaction_status_id`, `transaction_status_name`, `created_at`, `updated_at`) VALUES
(1, 'complete', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(2, 'progress', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(3, 'pending', '2025-12-20 23:13:21', '2025-12-20 23:13:21'),
(4, 'canceled', '2025-12-20 23:13:21', '2025-12-20 23:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_role_id` bigint UNSIGNED NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `role_role_id`, `password`, `phone_number`, `email`, `token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 3, '$2y$12$EW4P88CEGqHBkISLngqXAeMJowOqD/bX9Wc3hvQsc3JRmPHacdfiu', '081949742576', 'admin@gmail.com', '6|plyueH47vRFvuobNvYMcOjsfcoOjBe3DF2CsZfTF5cb22e7f', '2025-12-20 23:13:21', '2025-12-21 01:59:49'),
(2, 'courier', 2, '$2y$12$NlinhmcGouA37zn3c0/SvuKSiaJmyf/G6jLRpIPhvKb86W39j4Zsi', '081223388991', 'salikinsalimin@gmail.com', '7|qu8BVhyE7N6ArRVTj9C6RrjbuYsrpy3eCIsdc0vxf206dae2', '2025-12-20 23:13:21', '2025-12-21 02:00:16'),
(3, 'shandy Shulton Shihab', 1, '$2y$12$o9g9zvWigeRvgStdFARV8.HNdm9aChQMqVtPlhsxVSCLxlj1JwuO.', '081212181182', 'ssshandy60@gmail.com', NULL, '2025-12-20 23:27:20', '2025-12-22 01:42:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`user_user_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `carts_customer_user_id_foreign` (`customer_user_id`),
  ADD KEY `carts_foreign_product_id_foreign` (`foreign_product_id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`user_user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`user_user_id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `deliveries_courier_id_foreign` (`courier_id`),
  ADD KEY `deliveries_delivery_delivery_class_id_foreign` (`delivery_delivery_class_id`);

--
-- Indexes for table `delivery_classes`
--
ALTER TABLE `delivery_classes`
  ADD PRIMARY KEY (`delivery_class_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payments_payment_payment_method_id_foreign` (`payment_payment_method_id`),
  ADD KEY `payments_payment_transaction_id_foreign` (`payment_transaction_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pet_types`
--
ALTER TABLE `pet_types`
  ADD PRIMARY KEY (`pet_type_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_product_product_type_id_foreign` (`product_product_type_id`),
  ADD KEY `products_pet_pet_types_id_foreign` (`pet_pet_types_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transactions_user_user_id_foreign` (`user_user_id`),
  ADD KEY `transactions_delivery_delivery_id_foreign` (`delivery_delivery_id`),
  ADD KEY `transactions_foreign_cart_id_foreign` (`foreign_cart_id`),
  ADD KEY `transactions_transactions_transaction_status_id_foreign` (`transactions_transaction_status_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`transaction_transaction_id`),
  ADD KEY `transaction_details_foreign_product_id_foreign` (`foreign_product_id`);

--
-- Indexes for table `transaction_statuses`
--
ALTER TABLE `transaction_statuses`
  ADD PRIMARY KEY (`transaction_status_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_token_unique` (`token`),
  ADD KEY `users_role_role_id_foreign` (`role_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `delivery_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_classes`
--
ALTER TABLE `delivery_classes`
  MODIFY `delivery_class_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `payment_method_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pet_types`
--
ALTER TABLE `pet_types`
  MODIFY `pet_type_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `product_type_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction_statuses`
--
ALTER TABLE `transaction_statuses`
  MODIFY `transaction_status_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_user_id_foreign` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_user_id_foreign` FOREIGN KEY (`customer_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_foreign_product_id_foreign` FOREIGN KEY (`foreign_product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `couriers`
--
ALTER TABLE `couriers`
  ADD CONSTRAINT `couriers_user_user_id_foreign` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_user_id_foreign` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deliveries_delivery_delivery_class_id_foreign` FOREIGN KEY (`delivery_delivery_class_id`) REFERENCES `delivery_classes` (`delivery_class_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_payment_payment_method_id_foreign` FOREIGN KEY (`payment_payment_method_id`) REFERENCES `payment_methods` (`payment_method_id`),
  ADD CONSTRAINT `payments_payment_transaction_id_foreign` FOREIGN KEY (`payment_transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_pet_pet_types_id_foreign` FOREIGN KEY (`pet_pet_types_id`) REFERENCES `pet_types` (`pet_type_id`),
  ADD CONSTRAINT `products_product_product_type_id_foreign` FOREIGN KEY (`product_product_type_id`) REFERENCES `product_types` (`product_type_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_delivery_delivery_id_foreign` FOREIGN KEY (`delivery_delivery_id`) REFERENCES `deliveries` (`delivery_id`),
  ADD CONSTRAINT `transactions_foreign_cart_id_foreign` FOREIGN KEY (`foreign_cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_transactions_transaction_status_id_foreign` FOREIGN KEY (`transactions_transaction_status_id`) REFERENCES `transaction_statuses` (`transaction_status_id`),
  ADD CONSTRAINT `transactions_user_user_id_foreign` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_foreign_product_id_foreign` FOREIGN KEY (`foreign_product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_details_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_role_id_foreign` FOREIGN KEY (`role_role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
