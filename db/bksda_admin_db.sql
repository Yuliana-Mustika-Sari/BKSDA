-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 05, 2026 at 12:24 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bksda_admin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `aduan`
--

CREATE TABLE `aduan` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subjek` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aduan`
--

INSERT INTO `aduan` (`id`, `nama`, `email`, `telepon`, `subjek`, `pesan`, `created_at`) VALUES
(1, 'Budi', 'arjunadimas832@gmail.com', '0811111111', 'Kerusakan Jalur', 'Jalur pendakian rusak dan licin', '2026-02-05 13:55:33'),
(2, 'Sari', 'sari@mail.com', '0822222222', 'Sampah', 'Banyak sampah di area camping', '2026-02-05 13:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `peraturan` text,
  `image_url` varchar(255) NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('published','draft') NOT NULL DEFAULT 'published'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `description`, `peraturan`, `image_url`, `created_by`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Contoh Lokasi A', 'Deskripsi contoh lokasi A', 'Peraturan A', 'uploads/galeri/sample1.jpg', NULL, '2026-02-28 21:57:41', '2026-02-28 21:57:41', 'published'),
(2, 'Contoh Lokasi B', 'Deskripsi contoh lokasi B', 'Peraturan B', 'uploads/galeri/sample2.jpg', NULL, '2026-02-28 21:57:41', '2026-02-28 21:57:41', 'published');

-- --------------------------------------------------------

--
-- Table structure for table `konflik_satwa`
--

CREATE TABLE `konflik_satwa` (
  `id` int NOT NULL,
  `nomor_registrasi` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pelapor` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email_pelapor` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pelapor` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_kejadian` date NOT NULL,
  `lokasi_deskripsi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_satwa` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi_kejadian` text COLLATE utf8mb4_general_ci NOT NULL,
  `url_dokumentasi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_kasus` enum('Baru','Verifikasi','Penanganan','Selesai','Monitoring') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Baru',
  `tanggal_laporan` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konflik_satwa`
--

INSERT INTO `konflik_satwa` (`id`, `nomor_registrasi`, `nama_pelapor`, `email_pelapor`, `telepon_pelapor`, `tanggal_kejadian`, `lokasi_deskripsi`, `jenis_satwa`, `deskripsi_kejadian`, `url_dokumentasi`, `status_kasus`, `tanggal_laporan`) VALUES
(2, 'K-20260302-64B4', 'lorem', 'loremipsum@sms.as', '013842098', '2026-03-03', 'adalah', 'Ular', 'lorem ipsum', 'uploads/konflik/African_Bush_Elephant.jpg', 'Selesai', '2026-03-03 02:30:09'),
(5, 'K-20260303-0CD4', 'Lorem', 'officer1@parking.com', '0922211111', '2026-03-03', 'Semarang', 'Ular', 'Lorem Ipsum', 'uploads/konflik/African_Bush_Elephant.jpg', 'Selesai', '2026-03-03 17:29:24');

-- --------------------------------------------------------

--
-- Table structure for table `tindak_lanjut_konflik`
--

CREATE TABLE `tindak_lanjut_konflik` (
  `id` int NOT NULL,
  `id_laporan_konflik` int DEFAULT NULL,
  `petugas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `catatan_tindakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tanggal_tindakan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tindak_lanjut_konflik`
--

INSERT INTO `tindak_lanjut_konflik` (`id`, `id_laporan_konflik`, `petugas`, `catatan_tindakan`, `tanggal_tindakan`) VALUES
(1, 2, 'Petugas Lapangan A', 'Pemasangan pagar pengaman sementara', '2026-02-05 13:46:27'),
(2, 2, 'Petugas Lapangan B', 'Sosialisasi ke warga sekitar', '2026-02-05 13:46:27'),
(5, NULL, 'admin1', 'Lorem Ipsum', '2026-03-03 10:36:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(2, 'admin1', '$2y$10$KPxvYJ0hnjRRTtTmtbZkruMivmciWQOjxbvw4wKHn/2O70ja3qcfG', 'admin', '2026-02-05 06:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `web_content`
--

CREATE TABLE `web_content` (
  `id` int NOT NULL,
  `page_slug` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `section_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_content`
--

INSERT INTO `web_content` (`id`, `page_slug`, `section_id`, `title`, `content`, `created_at`, `profile`) VALUES
(1, 'index', 'about-section', 'Tentang Kami', 'Balai Konservasi Sumber Daya Alam Jawa Tengah adalah Unit Pelaksana Teknis (UPT) di bawah Kementerian Lingkungan Hidup dan Kehutanan yang bertugas mengelola 33 kawasan konservasi di Jawa Tengah, termasuk cagar alam, suaka margasatwa, dan taman wisata alam.', '2026-02-05 05:15:37', 'Kami berkomitmen menjaga kelestarian sumber daya alam dan keanekaragaman hayati di Jawa Tengah. Tugas kami mencakup perlindungan flora dan fauna langka, pemulihan habitat, dan pengembangan pariwisata alam yang berkelanjutan. Kami juga bekerja sama dengan masyarakat lokal, akademisi, dan lembaga lain untuk memastikan pengelolaan lingkungan yang ramah alam demi generasi mendatang.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aduan`
--
ALTER TABLE `aduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konflik_satwa`
--
ALTER TABLE `konflik_satwa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_registrasi` (`nomor_registrasi`);

--
-- Indexes for table `tindak_lanjut_konflik`
--
ALTER TABLE `tindak_lanjut_konflik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_laporan_konflik` (`id_laporan_konflik`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `web_content`
--
ALTER TABLE `web_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aduan`
--
ALTER TABLE `aduan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `konflik_satwa`
--
ALTER TABLE `konflik_satwa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tindak_lanjut_konflik`
--
ALTER TABLE `tindak_lanjut_konflik`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `web_content`
--
ALTER TABLE `web_content`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
