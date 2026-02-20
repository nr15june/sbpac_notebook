-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2026 at 09:39 AM
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
  `type` varchar(255) NOT NULL DEFAULT 'notebook',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'เมาส์', 'notebook', '2026-02-20 01:37:37', '2026-02-20 01:37:37'),
(2, 'สายชาร์จ', 'notebook', '2026-02-20 01:37:37', '2026-02-20 01:37:37'),
(3, 'สาย USB ', 'printer', '2026-02-20 01:37:37', '2026-02-20 01:37:37'),
(4, 'ตลับหมึก', 'printer', '2026-02-20 01:37:37', '2026-02-20 01:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `name`, `password`, `created_at`, `updated_at`) VALUES
(1, 'adminit', 'ผู้ดูแลระบบ', '$2y$12$W7XqJUHFyfFoeEB1i9gCfep.Ls8O5Ojg976B9iZetPpC/b92jWdSO', '2026-02-20 01:38:57', '2026-02-20 01:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `borrower_first_name` varchar(255) NOT NULL,
  `borrower_last_name` varchar(255) NOT NULL,
  `borrower_phone` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `notebook_id` bigint(20) UNSIGNED NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `status` enum('pending','borrowed','returned','rejected') NOT NULL DEFAULT 'pending',
  `reject_reason` text DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrowing_accessory`
--

CREATE TABLE `borrowing_accessory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `borrowing_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL,
  `is_returned` tinyint(1) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, '2026_01_12_035321_add_image_to_notebooks_table', 1),
(8, '2026_01_13_030305_add_role_to_users', 1),
(9, '2026_01_13_062910_create_borrowings_table', 1),
(10, '2026_01_13_063105_create_accessories_table', 1),
(11, '2026_01_13_063505_create_borrowing_accessory_table', 1),
(12, '2026_01_14_043356_add_pending_to_notebooks_status', 1),
(13, '2026_01_30_075814_add_phone_to_borrowings_table', 1),
(14, '2026_01_30_091833_add_return_status_to_borrowing_accessory_table', 1),
(15, '2026_02_03_032248_create_printers_table', 1),
(16, '2026_02_03_033648_create_printer_borrowings_table', 1),
(17, '2026_02_03_045241_add_image_to_printers_table', 1),
(18, '2026_02_03_070725_create_printer_borrowing_accessory_table', 1),
(19, '2026_02_03_072401_add_type_to_accessories_table', 1),
(20, '2026_02_04_090319_add_return_columns_to_printer_borrowing_accessory_table', 1),
(21, '2026_02_05_030231_add_pending_to_printer_borrowings_status', 1),
(22, '2026_02_06_070858_update_printer_borrowings_status_enum', 1),
(23, '2026_02_06_073045_add_reject_fields_to_printer_borrowings', 1),
(24, '2026_02_06_081126_add_reject_reason_to_borrowings_table', 1),
(25, '2026_02_10_082829_add_username_to_admins_table', 1),
(26, '2026_02_10_083243_remove_email_from_users_and_admins', 1),
(27, '2026_02_10_083724_update_status_enum_on_borrowings_table', 1),
(28, '2026_02_10_084414_update_status_enum_on_printers_table', 1),
(29, '2026_02_10_084735_seed_default_accessories', 1),
(30, '2026_02_10_085946_add_username_to_users_table', 1),
(31, '2026_02_11_022955_remove_id_card_from_users_table', 1),
(32, '2026_02_11_025636_drop_name_and_email_verified_at_from_users_table', 1),
(33, '2026_02_19_044754_add_deleted_at_to_users_table', 1),
(34, '2026_02_20_024532_add_borrower_fields_to_borrowings_table', 1),
(35, '2026_02_20_031549_add_borrower_fields_to_printer_borrowings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notebooks`
--

CREATE TABLE `notebooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_code` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `status` enum('available','pending','borrowed','repair') NOT NULL DEFAULT 'available',
  `note` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `printers`
--

CREATE TABLE `printers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_code` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `status` enum('available','pending','borrowed','repair') NOT NULL DEFAULT 'available',
  `note` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `printer_borrowings`
--

CREATE TABLE `printer_borrowings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `borrower_first_name` varchar(255) DEFAULT NULL,
  `borrower_last_name` varchar(255) DEFAULT NULL,
  `borrower_phone` varchar(255) DEFAULT NULL,
  `printer_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `status` enum('pending','borrowed','returned','rejected') NOT NULL,
  `reject_reason` varchar(255) DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `printer_borrowing_accessory`
--

CREATE TABLE `printer_borrowing_accessory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `printer_borrowing_id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` bigint(20) UNSIGNED NOT NULL,
  `is_returned` tinyint(1) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
('Cc0hTSCSyQWxQ2fJE6xU8yeLyYGF6fklG4DjTXvA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYlpQUEQyN0ZKOUloTWZYWE05aEN2dEt5aldCY0hNeFBWWFZkQkxPMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ub3RlYm9va3MiO3M6NToicm91dGUiO3M6MjU6ImFkbWluLm5vdGVib29rX21hbmFnZW1lbnQiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1771576765);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `department` varchar(255) NOT NULL,
  `workgroup` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  ADD UNIQUE KEY `admins_username_unique` (`username`);

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
-- Indexes for table `printers`
--
ALTER TABLE `printers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `printers_asset_code_unique` (`asset_code`);

--
-- Indexes for table `printer_borrowings`
--
ALTER TABLE `printer_borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `printer_borrowings_user_id_foreign` (`user_id`),
  ADD KEY `printer_borrowings_printer_id_foreign` (`printer_id`);

--
-- Indexes for table `printer_borrowing_accessory`
--
ALTER TABLE `printer_borrowing_accessory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `printer_borrowing_accessory_printer_borrowing_id_foreign` (`printer_borrowing_id`),
  ADD KEY `printer_borrowing_accessory_accessory_id_foreign` (`accessory_id`);

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
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowing_accessory`
--
ALTER TABLE `borrowing_accessory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `notebooks`
--
ALTER TABLE `notebooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `printers`
--
ALTER TABLE `printers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `printer_borrowings`
--
ALTER TABLE `printer_borrowings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `printer_borrowing_accessory`
--
ALTER TABLE `printer_borrowing_accessory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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

--
-- Constraints for table `printer_borrowings`
--
ALTER TABLE `printer_borrowings`
  ADD CONSTRAINT `printer_borrowings_printer_id_foreign` FOREIGN KEY (`printer_id`) REFERENCES `printers` (`id`),
  ADD CONSTRAINT `printer_borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `printer_borrowing_accessory`
--
ALTER TABLE `printer_borrowing_accessory`
  ADD CONSTRAINT `printer_borrowing_accessory_accessory_id_foreign` FOREIGN KEY (`accessory_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `printer_borrowing_accessory_printer_borrowing_id_foreign` FOREIGN KEY (`printer_borrowing_id`) REFERENCES `printer_borrowings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
