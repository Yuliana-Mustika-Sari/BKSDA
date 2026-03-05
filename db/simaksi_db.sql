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
-- Database: `simaksi_db`
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
(1, 'Budi', 'budi@mail.com', '0811111111', 'Kerusakan Jalur', 'Jalur pendakian rusak dan licin', '2026-02-05 13:46:27'),
(2, 'Sari', 'sari@mail.com', '0822222222', 'Sampah', 'Banyak sampah di area camping', '2026-02-05 13:46:27');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_konflik`
--

CREATE TABLE `laporan_konflik` (
  `id` int NOT NULL,
  `nomor_laporan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pelapor` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_pelapor` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lokasi_kejadian` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_satwa` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto_bukti` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Baru','Verifikasi','Penanganan','Selesai','Monitoring') COLLATE utf8mb4_general_ci DEFAULT 'Baru',
  `tanggal_laporan` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_konflik`
--

INSERT INTO `laporan_konflik` (`id`, `nomor_laporan`, `nama_pelapor`, `email_pelapor`, `lokasi_kejadian`, `jenis_satwa`, `foto_bukti`, `status`, `tanggal_laporan`, `created_at`) VALUES
(1, 'LK-001', 'Wawan', 'wawan@mail.com', 'Desa Selo', 'Monyet', 'foto1.jpg', 'Monitoring', '2026-02-05 14:13:17', '2026-02-05 13:46:27'),
(2, 'LK-002', 'Tini', 'tini@mail.com', 'Desa Argapura', 'Babi Hutan', 'foto2.jpg', 'Penanganan', '2026-02-05 14:13:17', '2026-02-05 13:46:27');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_simaksi`
--

CREATE TABLE `pendaftaran_simaksi` (
  `id` int NOT NULL,
  `nomor_surat` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `identitas` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_surat` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_kegiatan_mulai` date DEFAULT NULL,
  `tanggal_kegiatan_berakhir` date DEFAULT NULL,
  `lokasi` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `urutan` int DEFAULT '0',
  `tujuan` text COLLATE utf8mb4_general_ci,
  `status` enum('Diproses','Disetujui','Ditolak') COLLATE utf8mb4_general_ci DEFAULT 'Diproses',
  `jumlah_peserta` int DEFAULT '0',
  `tindak_lanjut` text COLLATE utf8mb4_general_ci,
  `tanggal_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran_simaksi`
--

INSERT INTO `pendaftaran_simaksi` (`id`, `nomor_surat`, `nama`, `identitas`, `email`, `telepon`, `jenis_surat`, `tanggal_kegiatan_mulai`, `tanggal_kegiatan_berakhir`, `lokasi`, `urutan`, `tujuan`, `status`, `jumlah_peserta`, `tindak_lanjut`, `tanggal_dibuat`) VALUES
(1, 'SIMAKSI-001', 'Rifan', 'KTP', 'rifan@mail.com', '081234567890', 'Penelitian', '2025-08-07', '2025-08-14', 'TN Merbabu', 0, 'Penelitian flora', 'Diproses', 10, '', '2026-02-05 13:46:27'),
(2, 'SIMAKSI-002', 'Sulis', 'KTP', 'sulis@mail.com', '082345678901', 'Penelitian', '2025-08-15', '2025-08-21', 'TN Ciremai', 0, 'Observasi satwa', 'Disetujui', 20, NULL, '2026-02-05 13:46:27'),
(3, 'SIMAKSI-003', 'Andi', 'SIM', 'andi@mail.com', '083456789012', 'Pendakian', '2025-08-20', '2025-08-29', 'TN Gede Pangrango', 0, 'Pendakian jalur resmi', 'Ditolak', 25, NULL, '2026-02-05 13:46:27'),
(5, 'SIMAKSI/A/2026/0001', 'Lorem', 'Lorem Ipsum', 'arjunadimas200@gmail.com', '0922211111', 'penelitian', '2026-02-05', '2026-02-12', 'CA Keling 2&3', 1, 'lorem ipsum dolor si amet', 'Diproses', 30, NULL, '2026-02-05 15:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `tindak_lanjut_konflik`
--

CREATE TABLE `tindak_lanjut_konflik` (
  `id` int NOT NULL,
  `id_laporan_konflik` int DEFAULT NULL,
  `petugas` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `catatan_tindakan` text COLLATE utf8mb4_general_ci,
  `tanggal_tindakan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tindak_lanjut_konflik`
--

INSERT INTO `tindak_lanjut_konflik` (`id`, `id_laporan_konflik`, `petugas`, `catatan_tindakan`, `tanggal_tindakan`) VALUES
(1, 2, 'Petugas Lapangan A', 'Pemasangan pagar pengaman sementara', '2026-02-05 13:46:27'),
(2, 2, 'Petugas Lapangan B', 'Sosialisasi ke warga sekitar', '2026-02-05 13:46:27'),
(3, 1, 'admin1', 'lorem ipsum', '2026-03-02 19:39:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aduan`
--
ALTER TABLE `aduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_konflik`
--
ALTER TABLE `laporan_konflik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran_simaksi`
--
ALTER TABLE `pendaftaran_simaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tindak_lanjut_konflik`
--
ALTER TABLE `tindak_lanjut_konflik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_laporan_konflik` (`id_laporan_konflik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aduan`
--
ALTER TABLE `aduan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laporan_konflik`
--
ALTER TABLE `laporan_konflik`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pendaftaran_simaksi`
--
ALTER TABLE `pendaftaran_simaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tindak_lanjut_konflik`
--
ALTER TABLE `tindak_lanjut_konflik`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tindak_lanjut_konflik`
--
ALTER TABLE `tindak_lanjut_konflik`
  ADD CONSTRAINT `fk_laporan_konflik` FOREIGN KEY (`id_laporan_konflik`) REFERENCES `laporan_konflik` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
