-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 08:00 PM
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
-- Database: `blangkis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat_konsumens`
--

CREATE TABLE `alamat_konsumens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `konsumen_id` bigint(20) UNSIGNED NOT NULL,
  `provinsi_id` bigint(20) UNSIGNED NOT NULL,
  `provinsi_nama` varchar(255) NOT NULL,
  `kota_id` bigint(20) UNSIGNED NOT NULL,
  `kota_nama` varchar(255) NOT NULL,
  `kecamatan_nama` varchar(255) DEFAULT NULL,
  `kecamatan_id` bigint(50) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `kode_pos` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alamat_konsumens`
--

INSERT INTO `alamat_konsumens` (`id`, `konsumen_id`, `provinsi_id`, `provinsi_nama`, `kota_id`, `kota_nama`, `kecamatan_nama`, `kecamatan_id`, `alamat_lengkap`, `kode_pos`, `created_at`, `updated_at`) VALUES
(6, 5, 33, 'JAWA TENGAH', 3318, 'KABUPATEN PATI', 'PATI', 3318100, 'Desa Panjunan', '59116', '2025-07-08 02:09:37', '2025-07-08 02:09:37');

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
('laravel_cache_ronaldo@gmail.com|127.0.0.1', 'i:1;', 1751974510),
('laravel_cache_ronaldo@gmail.com|127.0.0.1:timer', 'i:1751974510;', 1751974510);

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
  `konsumen_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(2, 'blangkon jogjakarta', '2025-07-08 01:43:37', '2025-07-08 01:44:01'),
(3, 'blangkon solo', '2025-07-08 01:43:48', '2025-07-08 01:43:48'),
(4, 'blangkon jawa', '2025-07-08 01:51:24', '2025-07-08 01:51:24'),
(5, 'blangkon indonesia', '2025-07-08 09:42:48', '2025-07-08 09:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `konsumens`
--

CREATE TABLE `konsumens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `konsumens`
--

INSERT INTO `konsumens` (`id`, `nama`, `email`, `password`, `alamat`, `telepon`, `created_at`, `updated_at`) VALUES
(1, 'Konsumen Uji Coba', 'konsumen@example.com', '$2y$12$KrIyyLcucSVeqPj.uGwYue0XBVaBx5QPbg6j.OlbADu/LFaZ/LE9.', 'Jl. Pelanggan No. 9', '082112223333', '2025-06-25 00:32:35', '2025-06-25 00:32:35'),
(2, 'royoyo', 'joko@gmail.com', '$2y$12$e60MMpRf9aaLEpM/bCsMCeeXgACPCRXcktO3i/fn/t6MuP8kGiVDK', 'Desa Panjunan', '081282314682', '2025-06-25 02:27:13', '2025-06-25 02:27:13'),
(3, 'ray', 'ray@gmail.com', '$2y$12$a.iGNSuvtGdgA9k90puMj.tEuw8xs3IKKYmGRVWUtVmGPq9VOid6y', 'Desa Panjunan', '081282314682', '2025-06-30 08:25:35', '2025-06-30 08:25:35'),
(4, 'KRISTINA DWI OKTAVIANI', 'k@gmail.com', '$2y$12$C8v3vt6nUS0hkZE4E9vUcucMi5cD.DyZg5UTOpyQYP5h6s5beKJ06', 'Jalan Bulustalan IV no 630b', '085328903646', '2025-07-07 04:21:27', '2025-07-07 04:21:27'),
(5, 'ronaldo', 'ronaldo@gmail.com', '$2y$12$QDbZnIX9eOKl7lNFebCJNOIzlade34bZ4bQmYOWXkT5a0utkbZ1uK', 'Desa Panjunan', '081282314682', '2025-07-08 01:50:26', '2025-07-08 01:50:26');

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
(4, '2025_06_25_055724_create_kategoris_table', 1),
(5, '2025_06_25_055734_create_produks_table', 1),
(6, '2025_06_25_055746_create_konsumens_table', 1),
(7, '2025_06_25_055753_create_carts_table', 1),
(8, '2025_06_25_055759_create_orders_table', 1),
(9, '2025_06_25_055806_create_order_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `konsumen_id` bigint(20) UNSIGNED NOT NULL,
  `kode_order` varchar(255) NOT NULL,
  `tanggal_order` date NOT NULL,
  `total` int(11) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `ekspedisi` varchar(255) NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `invoice_pdf` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `konsumen_id`, `kode_order`, `tanggal_order`, `total`, `ongkir`, `ekspedisi`, `bukti_bayar`, `invoice_pdf`, `status`, `created_at`, `updated_at`) VALUES
(13, 5, 'ORD-Z7DTRM', '2025-07-08', 370000, 10000, 'JNE', NULL, NULL, 'pesanan dikirim', '2025-07-08 02:09:44', '2025-07-08 02:17:05'),
(14, 5, 'ORD-DK92ID', '2025-07-08', 100000, 10000, 'JNE', NULL, NULL, 'belum bayar', '2025-07-08 02:15:13', '2025-07-08 02:15:13'),
(15, 5, 'ORD-YHXJL0', '2025-07-08', 100000, 10000, 'JNE', NULL, NULL, 'belum bayar', '2025-07-08 02:16:24', '2025-07-08 02:16:24'),
(16, 5, 'ORD-UFCX1O', '2025-07-08', 120000, 10000, 'JNE', NULL, NULL, 'pesanan diterima', '2025-07-08 02:35:47', '2025-07-08 02:50:44'),
(17, 5, 'ORD-JTAPDI', '2025-07-08', 100000, 10000, 'JNE', 'bukti-bayar/bukti_1751967504.jpg', NULL, 'selesai', '2025-07-08 02:37:36', '2025-07-08 02:50:13'),
(18, 5, 'ORD-XBQN0O', '2025-07-08', 120000, 10000, 'JNE', 'bukti-bayar/bukti_1751971738.png', NULL, 'sudah bayar', '2025-07-08 03:48:41', '2025-07-08 03:48:58'),
(19, 5, 'ORD-FCP8JI', '2025-07-08', 270000, 10000, 'JNE', NULL, NULL, 'belum bayar', '2025-07-08 04:31:44', '2025-07-08 04:31:44'),
(20, 5, 'ORD-1YEPWB', '2025-07-08', 100000, 10000, 'JNE', NULL, NULL, 'belum bayar', '2025-07-08 04:32:08', '2025-07-08 04:32:08'),
(21, 5, 'ORD-YDQNMW', '2025-07-08', 150000, 10000, 'JNE', 'bukti-bayar/bukti_1751975001.png', NULL, 'sudah bayar', '2025-07-08 04:32:35', '2025-07-08 04:43:21'),
(22, 5, 'ORD-J98RIL', '2025-07-08', 100000, 10000, 'JNE', 'bukti-bayar/bukti_1751974904.png', NULL, 'sudah bayar', '2025-07-08 04:33:39', '2025-07-08 04:41:44'),
(23, 5, 'ORD-L54FHV', '2025-07-08', 150000, 10000, 'JNE', 'bukti-bayar/bukti_1751987766.png', NULL, 'sudah bayar', '2025-07-08 07:42:43', '2025-07-08 08:16:06'),
(24, 5, 'ORD-ICYWNW', '2025-07-08', 450000, 10000, 'JNE', NULL, NULL, 'belum bayar', '2025-07-08 09:04:56', '2025-07-08 09:04:56'),
(25, 5, 'ORD-ZH2BR0', '2025-07-08', 150000, 10000, 'JNE', 'bukti-bayar/bukti_1751993457.jpg', NULL, 'sudah bayar', '2025-07-08 09:49:10', '2025-07-08 09:50:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `produk_id`, `harga`, `jumlah`, `subtotal`, `created_at`, `updated_at`) VALUES
(9, 13, 7, 150000, 1, 150000, '2025-07-08 02:09:44', '2025-07-08 02:09:44'),
(10, 13, 8, 120000, 1, 120000, '2025-07-08 02:09:44', '2025-07-08 02:09:44'),
(11, 13, 9, 100000, 1, 100000, '2025-07-08 02:09:44', '2025-07-08 02:09:44'),
(12, 14, 9, 100000, 1, 100000, '2025-07-08 02:15:13', '2025-07-08 02:15:13'),
(13, 15, 9, 100000, 1, 100000, '2025-07-08 02:16:24', '2025-07-08 02:16:24'),
(14, 16, 8, 120000, 1, 120000, '2025-07-08 02:35:47', '2025-07-08 02:35:47'),
(15, 17, 9, 100000, 1, 100000, '2025-07-08 02:37:36', '2025-07-08 02:37:36'),
(16, 18, 8, 120000, 1, 120000, '2025-07-08 03:48:41', '2025-07-08 03:48:41'),
(17, 19, 7, 150000, 1, 150000, '2025-07-08 04:31:44', '2025-07-08 04:31:44'),
(18, 19, 8, 120000, 1, 120000, '2025-07-08 04:31:44', '2025-07-08 04:31:44'),
(19, 20, 9, 100000, 1, 100000, '2025-07-08 04:32:08', '2025-07-08 04:32:08'),
(20, 21, 7, 150000, 1, 150000, '2025-07-08 04:32:35', '2025-07-08 04:32:35'),
(21, 22, 9, 100000, 1, 100000, '2025-07-08 04:33:39', '2025-07-08 04:33:39'),
(22, 23, 7, 150000, 1, 150000, '2025-07-08 07:42:43', '2025-07-08 07:42:43'),
(23, 24, 7, 150000, 3, 450000, '2025-07-08 09:04:56', '2025-07-08 09:04:56'),
(24, 25, 7, 150000, 1, 150000, '2025-07-08 09:49:10', '2025-07-08 09:49:10');

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
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `berat` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `kategori_id`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`, `berat`, `created_at`, `updated_at`) VALUES
(7, 2, 'blangkon jogjakarta', 'berasal dari jogjakarta', 150000, 5, 'produk/m6NQz8NoimUO0KyWxf0FCpWCKg41A1vb4jSpMxxl.jpg', 4, '2025-07-08 01:46:01', '2025-07-08 01:46:01'),
(8, 3, 'blangkon solo', 'berasal dari solo', 120000, 7, 'produk/FlraRWF3wblqgoAoaeXszsbEdhzen6e27BRvJg1h.jpg', 6, '2025-07-08 01:46:43', '2025-07-08 01:46:43'),
(9, 4, 'blangkon jawa', 'berasal dari jawa', 100000, 8, 'produk/DcjSh7gPyUmS1fINC778mqG0y4xh19cuoLZcb9It.jpg', 6, '2025-07-08 01:52:35', '2025-07-08 01:52:35'),
(10, 5, 'blangkon indonesia', 'blangkon indo', 50000, 8, 'produk/kpld1hTYqiJcLcliwqXfwbgFP7MGK4VRHdRB885u.jpg', 9, '2025-07-08 09:43:50', '2025-07-08 09:43:50');

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
('lO0oVDrB02OEpJGNLiN63hMJRKoG7zYIesoxprLj', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Avast/137.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZHRnbHlpazhMTzZ3OGtkS3BoU0xjOTZKdFYxMmpBVmJuaFpvOTJ4VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9vcmRlci1leHBvcnQ/Zm9ybWF0PXBkZiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9vcmRlciI7fXM6NDoiY2FydCI7YToxOntpOjc7YTo1OntzOjI6ImlkIjtpOjc7czo0OiJuYW1hIjtzOjE5OiJibGFuZ2tvbiBqb2dqYWthcnRhIjtzOjU6ImhhcmdhIjtpOjE1MDAwMDtzOjY6Imp1bWxhaCI7czoxOiIxIjtzOjY6ImdhbWJhciI7czo1MToicHJvZHVrL202TlF6OE5vaW1VTzBLeVd4ZjBGQ3BXQ0tnNDFBMXZiNGpTcE14eGwuanBnIjt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1751993545);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(5, 'kadmin', 'kadmin@gmail.com', '$2y$12$M9sBGGur/YaL63TgT1dwn.wMUrHRzoBNxPpnQ1vxLJfaSWmEjtDEu', '2025-07-07 05:40:20', '2025-07-07 05:40:20'),
(6, 'raynaldo', 'dreandre550@gmail.com', '$2y$12$AtW8nfWmN3PR6WPcUT.qa.odIm7IOiBzLy5jrzT3PbNLFaHyUdnl2', '2025-07-08 01:42:09', '2025-07-08 01:42:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat_konsumens`
--
ALTER TABLE `alamat_konsumens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alamat_konsumens_konsumen_id` (`konsumen_id`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_konsumen_id_foreign` (`konsumen_id`),
  ADD KEY `carts_produk_id_foreign` (`produk_id`);

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
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konsumens`
--
ALTER TABLE `konsumens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `konsumens_email_unique` (`email`);

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
  ADD UNIQUE KEY `orders_kode_order_unique` (`kode_order`),
  ADD KEY `orders_konsumen_id_foreign` (`konsumen_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produks_kategori_id_foreign` (`kategori_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat_konsumens`
--
ALTER TABLE `alamat_konsumens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `konsumens`
--
ALTER TABLE `konsumens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamat_konsumens`
--
ALTER TABLE `alamat_konsumens`
  ADD CONSTRAINT `fk_alamat_konsumens_konsumen_id` FOREIGN KEY (`konsumen_id`) REFERENCES `konsumens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_konsumen_id_foreign` FOREIGN KEY (`konsumen_id`) REFERENCES `konsumens` (`id`),
  ADD CONSTRAINT `carts_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_konsumen_id_foreign` FOREIGN KEY (`konsumen_id`) REFERENCES `konsumens` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`);

--
-- Constraints for table `produks`
--
ALTER TABLE `produks`
  ADD CONSTRAINT `produks_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
