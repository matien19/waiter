-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2025 at 01:28 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------


--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','siswa','staf','calon_siswa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staf',
  `auth_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nama`, `email`, `email_verified_at`, `password`, `role`, `auth_key`, `created_at`, `updated_at`) VALUES
(1, 'staf', 'staf', 'staf@gmail.com', NULL, '$2y$12$MQKXHb/8KPi16bCEVIO2cuJos0yoiF2mbtuxHH5Va1Hqpp13abv2S', 'staf', NULL, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(4, 'calonuser3', 'Calon Siswa 3', 'calon3@mail.com', NULL, '$2y$12$6SBnLVWzqtqtTe1MrC5ZBOKfTxGD2aHoz7nIfINSot1seUd/zi036', 'calon_siswa', NULL, '2025-07-10 10:12:15', '2025-07-10 10:12:15'),
(5, 'calonuser4', 'Calon Siswa 4', 'calon4@mail.com', NULL, '$2y$12$O94T.SmX.h.nOa.lCXCpKuzcUp5Oswdr3FTO9jC8ALiko.CD8kQh6', 'calon_siswa', NULL, '2025-07-10 10:12:16', '2025-07-10 10:12:16'),
(7, 'calonuser6', 'Calon Siswa 6', 'calon6@mail.com', NULL, '$2y$12$TTP5SIRloNPiZsCT9..PoezLNEXjhWLDl5IemM6S/QVR1Og.E/lw2', 'calon_siswa', NULL, '2025-07-10 10:12:17', '2025-07-10 10:12:17'),
(8, 'calonuser7', 'Calon Siswa 7', 'calon7@mail.com', NULL, '$2y$12$ZOzKTp2yDGn7oh8YeuSFquDCIvdLbHLCrdI.wGCv5ZFGuG9ffxydS', 'calon_siswa', NULL, '2025-07-10 10:12:17', '2025-07-10 10:12:17'),
(9, 'calonuser8', 'Calon Siswa 8', 'calon8@mail.com', NULL, '$2y$12$q7VU9BWI5lanmsQp9/zYwekQsHy4i83zRSMT88amz2i1Zv5y1NbZG', 'calon_siswa', NULL, '2025-07-10 10:12:18', '2025-07-10 10:12:18'),
(10, 'calonuser9', 'Calon Siswa 9', 'calon9@mail.com', NULL, '$2y$12$AqJz/kDlnjOfeTBm9QvEXeQhiDbNhpL8CQY8XfB/.A063TMd4ZTIq', 'calon_siswa', NULL, '2025-07-10 10:12:18', '2025-07-10 10:12:18'),
(11, 'calonuser10', 'Calon Siswa 10', 'calon10@mail.com', NULL, '$2y$12$Z4z71d/37PUDRzeifEGxquFO1s1ttZ2V7LaqDRunEUrV5fXO9OWr2', 'calon_siswa', NULL, '2025-07-10 10:12:19', '2025-07-10 10:12:19'),
(12, 'siswauser1', 'Siswaaaaa', 'siswa1@mail.com', NULL, '$2y$12$gMXukIIZKD.a1EFbilM1mOHlhRKzh7ntqOLvoRqb8dGCqPI3eOjh2', 'siswa', NULL, '2025-07-10 10:12:19', '2025-07-20 05:52:15'),
(13, 'siswauser2', 'Siswa 2', 'siswa2@mail.com', NULL, '$2y$12$SA1MRP7rgm68A3BVjbY0Tu2eNob5F6ggL/g6W7eKrEP7wh2u.Oql2', 'siswa', NULL, '2025-07-10 10:12:20', '2025-07-10 10:12:20'),
(14, 'siswauser3', 'Siswa 3', 'siswa3@mail.com', NULL, '$2y$12$yiH6W9LH18hqpSLBqgo2buQ.lPmLJRlRV9TKi7Fp5k5gp5AjQPkqi', 'siswa', NULL, '2025-07-10 10:12:21', '2025-07-10 10:12:21'),
(15, 'siswauser4', 'Siswa 4', 'siswa4@mail.com', NULL, '$2y$12$FJNvagRiXSo9kr.PXLKvCOeUhcFUocVj0rjRW.gfESUxCO4LtyTsa', 'siswa', NULL, '2025-07-10 10:12:21', '2025-07-10 10:12:21'),
(16, 'siswauser5', 'Siswa 5', 'siswa5@mail.com', NULL, '$2y$12$b.ATkeFfRVj/bmH73jSWW.fmUyPfY99RRPI59GZ83pF0H0zPJwj4G', 'siswa', NULL, '2025-07-10 10:12:22', '2025-07-10 10:12:22'),
(17, 'siswauser6', 'Siswa 6', 'siswa6@mail.com', NULL, '$2y$12$HQ1kr2sKOuadutTLBpqoJ.f63XBfcSE1xaRRlM6UlD/wTzZHnNI2.', 'siswa', NULL, '2025-07-10 10:12:22', '2025-07-10 10:12:22'),
(18, 'siswauser7', 'Siswa 7', 'siswa7@mail.com', NULL, '$2y$12$AbUr/SnVYMSBhHyJFRLMNe8rXc97be0KJs6WjsycwzqTVwHuW/trC', 'siswa', NULL, '2025-07-10 10:12:23', '2025-07-10 10:12:23'),
(19, 'siswauser8', 'Siswa 8', 'siswa8@mail.com', NULL, '$2y$12$k7UQ1U2iFttG8xLAJFGZLOPbbpaO0een8dIOVTyX1jY2HQXwO7Mra', 'siswa', NULL, '2025-07-10 10:12:23', '2025-07-10 10:12:23'),
(20, 'siswauser9', 'Siswa 9', 'siswa9@mail.com', NULL, '$2y$12$.UDS8TWAasE2QxDrhAo2..wjZHR5enqD3YyI.Af4zaIWec5N/S/b.', 'siswa', NULL, '2025-07-10 10:12:24', '2025-07-10 10:12:24'),
(21, 'siswauser10', 'Siswa 10', 'siswa10@mail.com', NULL, '$2y$12$7Zn77JRg7ZGCK1PYSfgpSOi9cYbrOG39HevPMhCgns7qsdgAsQJoa', 'siswa', NULL, '2025-07-10 10:12:24', '2025-07-10 10:12:24'),
(22, 'siswauser11', 'Siswa 11', 'siswa11@mail.com', NULL, '$2y$12$4ICg3QfkgpaMRLX8tpcMV.Pl43OIYUXDi9SBXPyE7OteL6AmgtwnG', 'siswa', NULL, '2025-07-10 10:12:25', '2025-07-10 10:12:25'),
(23, 'siswauser12', 'Siswa 12', 'siswa12@mail.com', NULL, '$2y$12$hyX/xu6DdXlGbkb0AfNKo.ZI3p2HD4EKG38rqS3RmbPga5f4HviQW', 'siswa', NULL, '2025-07-10 10:12:25', '2025-07-10 10:12:25'),
(25, 'siswauser14', 'Siswa 14', 'siswa14@mail.com', NULL, '$2y$12$jpVmpsd1isPKqdTBCleOaulwz1TYfm8iOqd9ZhOlWlV7QJFoDtG2W', 'siswa', NULL, '2025-07-10 10:12:26', '2025-07-10 10:12:26'),
(26, 'siswauser15', 'Siswa 15', 'siswa15@mail.com', NULL, '$2y$12$M6SpciQfaWbipoN2IiIBjuzqYabCC4NVszVegQtfNIn0hWWgEna22', 'siswa', NULL, '2025-07-10 10:12:27', '2025-07-10 10:12:27'),
(27, 'siswauser16', 'Siswa 16', 'siswa16@mail.com', NULL, '$2y$12$E9VAliEtpLYuq1A.rk9SrOdDMw5MkdgEjkH0mfHXopg.LursBtgNa', 'siswa', NULL, '2025-07-10 10:12:27', '2025-07-10 10:12:27'),
(28, 'siswauser17', 'Siswa 17', 'siswa17@mail.com', NULL, '$2y$12$AYCFx1FSnIi3cgW9xT2XTe1pKp4GtBe8O6VRKI8q69IPOGlxl1tuu', 'siswa', NULL, '2025-07-10 10:12:28', '2025-07-10 10:12:28'),
(30, 'siswauser19', 'Siswa 19', 'siswa19@mail.com', NULL, '$2y$12$.s4cHag49WdtEHvj12tiSeMmM01B0yqggbAadeWxS4E5v1AOOjrZ6', 'siswa', NULL, '2025-07-10 10:12:30', '2025-07-10 10:12:30'),
(31, 'siswauser20', 'Siswa 20', 'siswa20@mail.com', NULL, '$2y$12$CWV8/BHL8HqWH2eSZDrT5.A/NuB9S///NRyeYLJB7kvfSMKF/A8Wu', 'siswa', NULL, '2025-07-10 10:12:31', '2025-07-10 10:12:31'),
(32, 'zxc', 'zxc', 'zxc@gmail.com', NULL, '$2y$12$e9uvzbKvVyqnRRHn763Q6eCv7liaut8E0tGQROiYZaVT6BHKBkPbu', 'calon_siswa', NULL, '2025-07-19 08:05:37', '2025-07-19 08:05:37'),
(33, 'sdsdd', 'sdsdd', 'aa@gmail.com', NULL, '$2y$12$uUgGx48p10SpvKQ7yWq5mutBhCuMXfNS9tCkiJ5mI563ZTEpm4LQa', 'staf', NULL, '2025-07-19 08:06:49', '2025-07-19 08:07:10'),
(34, 'aaazzzz', 'aaazzzz', 'aaazzzz@gmail.com', NULL, '$2y$12$4rNPK0J3y79RxVq7sGDO1exR6pW9Of57f1pNH/jCECe6U.0/GiBXG', 'staf', NULL, '2025-07-19 08:07:34', '2025-07-19 08:07:34'),
(35, 'uts gasal', 'uts gasal', 'uts gasal@gmail.com', NULL, '$2y$12$yZH4ToRZkhZmfC/sRvc9O.e/.ErRxba9kYPR4r232hlJpkUklBzTS', 'calon_siswa', NULL, '2025-07-19 08:08:11', '2025-07-19 08:08:11'),
(36, 'zzz', 'zzz', 'zzz@gmail.com', NULL, '$2y$12$vNThq2pAjI2lBFJer0C6J.MAU6J9sjLQEC9lz0x6UjGeZYHSpXLHe', 'siswa', NULL, '2025-07-19 08:08:39', '2025-07-19 08:08:39'),
(37, 'aasssa', 'aasssa', 'aasssa@gmail.com', NULL, '$2y$10$ZvYkAObTBtjQRxN9BKXfY.AGQUSUwhN1yDAxN8fSGr3/E5qYydEWu', 'siswa', NULL, NULL, NULL),
(38, 'matien', 'matien', 'matien@gmail.com', NULL, '$2y$10$DHrSyv.8n6J4R2d7GyVEIOP1AXefNCOWeqXwTspRiIsdcS20dQQum', 'siswa', NULL, NULL, NULL),
(39, 'aac', 'aac', 'aac@gmail.com', NULL, '$2y$13$w7SGsupvUczoHGJBmFJlQeeTA0PFRJBKqiEB6QzmefMA0S0KEynEq', 'siswa', NULL, '2025-07-20 00:59:55', '2025-07-20 00:59:55'),
(41, 'pp', 'ppp', 'p@gmail.com', NULL, '$2y$13$3RBBSNgbZzaQzOU1HuKheu6aQ1w8q969Xeuxh589.6zkquzIJbq3W', 'staf', NULL, '2025-07-20 09:48:32', '2025-07-20 09:48:32'),
(44, 'REG11112', 'azzzzzz', 'aaasss@gmail.com', NULL, '$2y$13$z0RSNWc91F7NIn8TiyPBQOcBSPbufAoY4KlRJIvfGAgpaBsHY.Raq', 'siswa', NULL, '2025-07-20 12:30:38', '2025-07-20 23:52:10'),
(45, '1233', 'xczc', 'xczc@gmail.com', NULL, '$2y$13$BYQ/XtpSGYjYHoOtSkVcVuv5fzl5sd9GPnUHG6KEe.uVktS5Zk6t6', 'siswa', NULL, '2025-07-24 19:46:43', '2025-07-24 19:46:43'),
(46, 'REG4444', 'gghfgh', 'gghfgh@gmail.com', NULL, '$2y$13$gbiN/PqZDXBHh.VOeD31QOz2qLkT78Kpf4yGrC.YRPOzkG2H1O.2m', 'siswa', NULL, '2025-07-27 22:38:40', '2025-07-27 22:38:40'),
(48, 'admin', 'admin', 'admin@gmail.com', NULL, '$2y$12$MQKXHb/8KPi16bCEVIO2cuJos0yoiF2mbtuxHH5Va1Hqpp13abv2S', 'admin', NULL, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(49, 'REG121', 'pp', 'pp@gmail.com', NULL, '$2y$13$fsiJICddievrnLTt4PcLD.WZPEIqoE9QQY3TlYR/lejw8ImF3WzHe', 'siswa', NULL, '2025-08-01 01:25:09', '2025-08-01 01:25:09');

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;
-- --------------------------------------------------------