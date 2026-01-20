-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2026 at 09:52 AM
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
-- Database: `sbpac_notebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Mouse', NULL, NULL),
(2, 'Charger', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@sbpac.go.th', '$2y$12$AKE4..N9ZudiKyWRLhLHOu9o8VgHZ2RBMdIxSH5DNjIIpCBLZUxZe', '2026-01-11 19:47:13', '2026-01-11 19:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notebook_id` bigint(20) UNSIGNED NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `notebook_id`, `borrow_date`, `return_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 4, '2026-01-13', '2026-01-15', 'returned', '2026-01-13 00:41:57', '2026-01-14 20:57:17'),
(2, 2, 3, '2026-01-15', '2026-01-15', 'returned', '2026-01-14 19:00:27', '2026-01-14 20:57:27'),
(3, 2, 2, '2026-01-15', '2026-01-15', 'returned', '2026-01-14 20:57:44', '2026-01-14 20:58:05'),
(4, 2, 3, '2026-01-15', '2026-01-15', 'returned', '2026-01-14 20:58:14', '2026-01-14 21:09:50'),
(5, 1, 2, '2026-01-15', '2026-01-15', 'returned', '2026-01-14 21:23:39', '2026-01-14 21:23:51'),
(6, 1, 2, '2026-01-15', '2026-01-19', 'returned', '2026-01-14 21:33:41', '2026-01-19 00:51:23'),
(7, 2, 3, '2026-01-15', '2026-01-15', 'returned', '2026-01-14 21:34:12', '2026-01-14 23:29:03'),
(8, 2, 4, '2026-01-15', '2026-01-15', 'returned', '2026-01-14 23:29:23', '2026-01-14 23:51:42'),
(9, 2, 3, '2026-01-24', '2026-01-15', 'returned', '2026-01-14 23:49:04', '2026-01-14 23:51:24'),
(10, 2, 4, '2026-01-15', '2026-01-20', 'returned', '2026-01-14 23:51:58', '2026-01-19 19:45:09'),
(11, 2, 3, '2026-01-19', '2026-01-28', 'borrowed', '2026-01-19 00:36:57', '2026-01-19 20:00:42'),
(12, 2, 2, '2026-01-31', '2026-02-14', 'pending', '2026-01-19 19:44:55', '2026-01-19 19:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `borrowing_accessory`
--

CREATE TABLE `borrowing_accessory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `borrowing_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowing_accessory`
--

INSERT INTO `borrowing_accessory` (`id`, `borrowing_id`, `accessory_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2),
(5, 3, 1),
(6, 3, 2),
(7, 4, 1),
(8, 4, 2),
(9, 5, 1),
(10, 5, 2),
(11, 6, 1),
(12, 6, 2),
(13, 7, 1),
(14, 7, 2),
(15, 8, 1),
(16, 8, 2);

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
(4, '2026_01_07_080714_create_admins_table', 1),
(5, '2026_01_09_040548_add_user_fields_to_users_table', 1),
(6, '2026_01_12_023651_create_notebooks_table', 1),
(7, '2026_01_12_025333_add_fields_to_notebooks_table', 2),
(8, '2026_01_12_035321_add_image_to_notebooks_table', 3),
(9, '2026_01_13_030305_add_role_to_users', 4),
(10, '2026_01_13_062910_create_borrowings_table', 5),
(11, '2026_01_13_063105_create_accessories_table', 5),
(12, '2026_01_13_063505_create_borrowing_accessory_table', 6),
(13, '2026_01_14_043356_add_pending_to_notebooks_status', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notebooks`
--

CREATE TABLE `notebooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_code` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `note` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notebooks`
--

INSERT INTO `notebooks` (`id`, `asset_code`, `brand`, `model`, `status`, `note`, `image`, `created_at`, `updated_at`) VALUES
(2, 'NB-99-00-001', 'Lenovo', 'ThinkPad X1 Carbon Gen 9', 'pending', '-', 'notebooks/ZimPA893Ekzn7yAI2HbxnHGVoM5stN6m0O7OB7XA.jpg', '2026-01-11 20:11:37', '2026-01-19 19:44:55'),
(3, 'NB-99-00-005', 'Dell', 'Latitude 5420', 'borrowed', NULL, 'notebooks/RSfqbsEp0Q2whqX3nIDLqLk5SUoMiXu4hZGOSA3I.jpg', '2026-01-12 21:43:27', '2026-01-19 20:00:42'),
(4, 'NB-00-00-001', 'HP', 'ProBook 450 G8', 'available', NULL, 'notebooks/8yNBfgpO25ZXRpr9yAEtp4EuFP4IymdfSx5qwi6N.jpg', '2026-01-12 21:45:11', '2026-01-19 19:45:09');

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
('1iWqsodAznpA5MA1pybw28LjpII9ZkPlc7Nzm8Lj', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNVFaSk5ySXFSYlJBM3BmbnRMMXVkNFAzM0NKQlpOMFVpS0p4Z2JvQyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VzZXIvYm9ycm93X2xpc3QiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VzZXIvbm90ZWJvb2tfcmVxdWVzdCI7czo1OiJyb3V0ZSI7czoyMToidXNlci5ub3RlYm9va19yZXF1ZXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1768891344),
('qCRbJvyCOaFHQblXjRMVbdEC0h3NhghJ3JVCermp', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZEh3bmYxZDBFOHJrNDhSZ2dqblFWSkVFR2JmeTJnUUp2RVczb0MwUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VyL25vdGVib29rX3JlcXVlc3QiO3M6NToicm91dGUiO3M6MjE6InVzZXIubm90ZWJvb2tfcmVxdWVzdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1768880213);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_card` varchar(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `department` varchar(255) NOT NULL,
  `workgroup` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_card`, `first_name`, `last_name`, `phone`, `department`, `workgroup`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '1125432514215', 'กนกกร', 'ใจบุญ', '0987458746', 'กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้', 'กลุ่มงานบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้', 'กนกกร ใจบุญ', 'kanokkorn@sbpac.go.th', NULL, '$2y$12$2p97McSGdYQWu66u2bgP8OGJY6NRoc.Cmd4.j7PjrJ4X2fncqdfY.', 'user', NULL, '2026-01-11 19:50:30', '2026-01-11 19:50:30'),
(2, '1152326423564', 'ใจดี', 'ใจบุญ', '0987654321', 'กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้', 'กลุ่มงานบริหารงบประมาณ', 'ใจดี ใจบุญ', 'jaidi@sbpac.go.th', NULL, '$2y$12$Es5ZYp4ImraXzIH2KyottOjP57G/tJq/UkOUYhn/2N8FNiy5gVMD6', 'user', NULL, '2026-01-12 20:44:34', '2026-01-12 20:44:34'),
(3, '1154854685945', 'ฮานัน', 'สาเระ', '0874589875', 'กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้', 'กลุ่มงานบริหารยุทธศาสตร์การสื่อสารสร้างความเข้าใจที่ดี', 'ฮานัน สาเระ', 'hanan@sbpac.go.th', NULL, '$2y$12$sHwZJFKlMLWpQ.YtdQkDGe9UFbMqxY8nGS.iREsjN/kWH5qvVn0TC', 'user', NULL, '2026-01-14 23:53:53', '2026-01-14 23:53:53'),
(4, '1154256565421', 'นูรี', 'เจะลง', '0987456321', 'กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้', 'กลุ่มงานบริหารยุทธศาสตร์การสื่อสารสร้างความเข้าใจที่ดี', 'นูรี เจะลง', 'nuree@sbpac.go.th', NULL, '$2y$12$mGaO74g/OluGTMXdKktpy.XPLT7k8aDxtnLZTc2kgpew5kNFMmFC6', 'user', NULL, '2026-01-14 23:55:10', '2026-01-14 23:55:10'),
(5, '1112547869456', 'สมหมาย', 'สมปอง', '0954875652', 'กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้', 'กลุ่มงานบริหารงบประมาณ', 'สมหมาย สมปอง', 'sommai@sbpac.go.th', NULL, '$2y$12$cck0lrtF4fzJlavJfoV7fuKrDIlI/fWqIQspg2pzIoA9AM2KrKxva', 'user', NULL, '2026-01-15 00:09:39', '2026-01-15 00:09:39'),
(6, '1234567893214', 'สมชัย', 'เอกทอง', '0874147851', 'สำนักงานเลขาธิการ', 'กลุ่มงานบริหารทรัพยากรบุคคล', 'สมชัย เอกทอง', 'somchai@sbpac.go.th', NULL, '$2y$12$.ddldZ40zJeBowvdbcJZnOB0pv4tKI1pRUsqBDiqg6Bzf2.giR5/O', 'user', NULL, '2026-01-16 01:43:42', '2026-01-16 01:43:42'),
(7, '1114565821451', 'จูเนียร์', 'ปณชัย', '0987458478', 'กองบริหารยุทธศาสตร์การพัฒนาจังหวัดชายแดนภาคใต้', 'กลุ่มงานอํานวยการและบริหาร', 'จูเนียร์ ปณชัย', 'juniar@sbpac.go.th', NULL, '$2y$12$oq3zL1p4LcgPwaXXLuX2wecK2.h2BT6SdsKiXR6.g8GSDAa2KfuCy', 'user', NULL, '2026-01-19 00:20:48', '2026-01-19 00:20:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowings_user_id_foreign` (`user_id`),
  ADD KEY `borrowings_notebook_id_foreign` (`notebook_id`);

--
-- Indexes for table `borrowing_accessory`
--
ALTER TABLE `borrowing_accessory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowing_accessory_borrowing_id_foreign` (`borrowing_id`),
  ADD KEY `borrowing_accessory_accessory_id_foreign` (`accessory_id`);

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
-- Indexes for table `notebooks`
--
ALTER TABLE `notebooks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notebooks_asset_code_unique` (`asset_code`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_id_card_unique` (`id_card`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `borrowing_accessory`
--
ALTER TABLE `borrowing_accessory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notebooks`
--
ALTER TABLE `notebooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_notebook_id_foreign` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`),
  ADD CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `borrowing_accessory`
--
ALTER TABLE `borrowing_accessory`
  ADD CONSTRAINT `borrowing_accessory_accessory_id_foreign` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`),
  ADD CONSTRAINT `borrowing_accessory_borrowing_id_foreign` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
