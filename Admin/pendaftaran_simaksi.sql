-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Agu 2025
-- Server: MariaDB 10.4.32
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

-- ===============================
-- DATABASE: simaksi_db
-- ===============================
CREATE DATABASE IF NOT EXISTS simaksi_db;
USE simaksi_db;

-- ==================================================
-- TABLE: pendaftaran_simaksi
-- ==================================================
CREATE TABLE IF NOT EXISTS pendaftaran_simaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_surat VARCHAR(50),
    nama VARCHAR(100),
    identitas VARCHAR(50),
    email VARCHAR(100),
    telepon VARCHAR(20),
    jenis_surat VARCHAR(50),
    tanggal_kegiatan_mulai DATE,
    lokasi VARCHAR(150),
    tujuan TEXT,
    status ENUM('Diproses','Disetujui','Ditolak') DEFAULT 'Diproses',
    tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pendaftaran_simaksi
(nomor_surat, nama, identitas, email, telepon, jenis_surat, tanggal_kegiatan_mulai, lokasi, tujuan, status)
VALUES
('SIMAKSI-001', 'Rifan', 'KTP', 'rifan@mail.com', '081234567890', 'Penelitian', '2025-08-07', 'TN Merbabu', 'Penelitian flora', 'Diproses'),
('SIMAKSI-002', 'Sulis', 'KTP', 'sulis@mail.com', '082345678901', 'Penelitian', '2025-08-15', 'TN Ciremai', 'Observasi satwa', 'Disetujui'),
('SIMAKSI-003', 'Andi', 'SIM', 'andi@mail.com', '083456789012', 'Pendakian', '2025-08-20', 'TN Gede Pangrango', 'Pendakian jalur resmi', 'Ditolak');

-- ==================================================
-- TABLE: aduan
-- ==================================================
CREATE TABLE IF NOT EXISTS aduan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100),
    telepon VARCHAR(20),
    subjek VARCHAR(150),
    pesan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO aduan
(nama, email, telepon, subjek, pesan)
VALUES
('Budi', 'budi@mail.com', '0811111111', 'Kerusakan Jalur', 'Jalur pendakian rusak dan licin'),
('Sari', 'sari@mail.com', '0822222222', 'Sampah', 'Banyak sampah di area camping');

-- ==================================================
-- TABLE: laporan_konflik
-- ==================================================
CREATE TABLE IF NOT EXISTS laporan_konflik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_laporan VARCHAR(50),
    nama_pelapor VARCHAR(100),
    email_pelapor VARCHAR(100),
    lokasi_kejadian VARCHAR(150),
    foto_bukti VARCHAR(255),
    status ENUM(
        'Baru',
        'Verifikasi',
        'Penanganan',
        'Selesai',
        'Monitoring'
    ) DEFAULT 'Baru',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO laporan_konflik
(nomor_laporan, nama_pelapor, email_pelapor, lokasi_kejadian, foto_bukti, status)
VALUES
('LK-001', 'Wawan', 'wawan@mail.com', 'Desa Selo', 'foto1.jpg', 'Baru'),
('LK-002', 'Tini', 'tini@mail.com', 'Desa Argapura', 'foto2.jpg', 'Penanganan');

-- ==================================================
-- TABLE: tindak_lanjut_konflik
-- ==================================================
CREATE TABLE IF NOT EXISTS tindak_lanjut_konflik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_laporan_konflik INT,
    petugas VARCHAR(100),
    catatan_tindakan TEXT,
    tanggal_tindakan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_laporan_konflik
        FOREIGN KEY (id_laporan_konflik)
        REFERENCES laporan_konflik(id)
        ON DELETE CASCADE
);

INSERT INTO tindak_lanjut_konflik
(id_laporan_konflik, petugas, catatan_tindakan)
VALUES
(2, 'Petugas Lapangan A', 'Pemasangan pagar pengaman sementara'),
(2, 'Petugas Lapangan B', 'Sosialisasi ke warga sekitar');

COMMIT;
