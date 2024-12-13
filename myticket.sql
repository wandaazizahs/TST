-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 09:45 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Kereta Api', 'kereta-api', '2024-11-28 04:50:19', '2024-11-28 04:50:19'),
(2, 'Pesawat', 'pesawat', '2024-12-09 07:29:55', '2024-12-09 07:29:55');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2020_11_16_131654_create_category_table', 1),
(3, '2020_11_17_004604_create_transportasi_table', 1),
(4, '2020_11_18_081507_create_rute_table', 1),
(5, '2020_11_20_095338_create_pemesanan_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `kursi` varchar(255) DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` int(11) NOT NULL,
  `status` enum('Belum Bayar','Sudah Bayar') NOT NULL DEFAULT 'Belum Bayar',
  `rute_id` bigint(20) UNSIGNED NOT NULL,
  `penumpang_id` bigint(20) UNSIGNED NOT NULL,
  `petugas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `kode`, `kursi`, `waktu`, `total`, `status`, `rute_id`, `penumpang_id`, `petugas_id`, `created_at`, `updated_at`) VALUES
(1, 'ALCGE47', 'K31', '2024-11-30 09:00:00', 700000, 'Belum Bayar', 1, 2, NULL, '2024-11-28 04:51:42', '2024-11-28 04:51:42'),
(2, 'VDUHY9Z', 'K12', '2024-11-28 09:00:00', 700000, 'Belum Bayar', 1, 2, NULL, '2024-11-28 04:54:09', '2024-11-28 04:54:09'),
(3, 'EAY3UZF', 'K11', '2024-12-08 09:00:00', 700000, 'Belum Bayar', 1, 3, NULL, '2024-12-07 14:26:37', '2024-12-07 14:26:37');

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `jam` time NOT NULL,
  `transportasi_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`id`, `tujuan`, `start`, `end`, `harga`, `jam`, `transportasi_id`, `created_at`, `updated_at`) VALUES
(1, 'Malang', 'Stasiun Gambir', 'Stasiun Malang', 700000, '16:00:00', 1, '2024-11-28 04:51:14', '2024-11-28 04:51:14'),
(2, 'Malang', 'Bandar Udara Soekarno-Hatta', 'Bandar Udara Abdulrachman Saleh', 1400000, '08:00:00', 2, '2024-12-09 07:31:37', '2024-12-09 07:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `transportasi`
--

CREATE TABLE `transportasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transportasi`
--

INSERT INTO `transportasi` (`id`, `name`, `kode`, `jumlah`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'BRAWIJAYA', 'BRAW', 500, 1, '2024-11-28 04:50:29', '2024-12-09 07:30:35'),
(2, 'GARUDA INDONESIA', 'GA', 100, 2, '2024-12-09 07:30:51', '2024-12-09 07:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Admin','Petugas','Penumpang') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '$2y$10$Uf2iDAJ8YjmcJL0UdbFBF.gyMdoWLQRsqZhejor7QQPe3puzZDDwC', 'Admin', '2024-11-28 04:16:21', '2024-11-28 04:16:21'),
(2, 'tst', 'tst', '$2y$10$N5LJ4sW8H4XFTAv5xG.d9enN33qESVZdbXLxSY7X/6jVU3l2aBx0a', 'Penumpang', '2024-11-28 04:17:11', '2024-11-28 04:17:11'),
(3, 'haha', 'haha', '$2y$10$5QyR3OUmKrNbIfGsRQb77.ivt7vm6loX5srEFgOWRyH1Tv0LsTRj2', 'Penumpang', '2024-12-07 14:25:53', '2024-12-07 14:25:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemesanan_rute_id_foreign` (`rute_id`),
  ADD KEY `pemesanan_penumpang_id_foreign` (`penumpang_id`),
  ADD KEY `pemesanan_petugas_id_foreign` (`petugas_id`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rute_transportasi_id_foreign` (`transportasi_id`);

--
-- Indexes for table `transportasi`
--
ALTER TABLE `transportasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transportasi_category_id_foreign` (`category_id`);

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
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rute`
--
ALTER TABLE `rute`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transportasi`
--
ALTER TABLE `transportasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_penumpang_id_foreign` FOREIGN KEY (`penumpang_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pemesanan_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pemesanan_rute_id_foreign` FOREIGN KEY (`rute_id`) REFERENCES `rute` (`id`);

--
-- Constraints for table `rute`
--
ALTER TABLE `rute`
  ADD CONSTRAINT `rute_transportasi_id_foreign` FOREIGN KEY (`transportasi_id`) REFERENCES `transportasi` (`id`);

--
-- Constraints for table `transportasi`
--
ALTER TABLE `transportasi`
  ADD CONSTRAINT `transportasi_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
