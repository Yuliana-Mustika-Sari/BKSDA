-- ================================
-- DATABASE
-- ================================
CREATE DATABASE IF NOT EXISTS bksda_admin_db;
USE bksda_admin_db;

-- ================================
-- TABLE: users
-- ================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================
-- DEFAULT ADMIN ACCOUNT
-- username: admin
-- password: admin123
-- ================================
INSERT INTO users (username, password, role)
VALUES (
    'admin',
    '$2y$10$Wm9ZQ9QxRZcQKp1aO5tZ3u5JdR9P7qZkz4wZ8d3Z8Jt4z9F1EwH1e',
    'admin'
);

-- ================================
-- TABLE: web_content
-- ================================
CREATE TABLE IF NOT EXISTS web_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_slug VARCHAR(50) NOT NULL,
    section_id VARCHAR(50) NOT NULL,
    title VARCHAR(100),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================
-- DEFAULT CONTENT FOR INDEX PAGE
-- ================================
INSERT INTO web_content (page_slug, section_id, title, content)
VALUES (
    'index',
    'about-section',
    'Tentang Kami',
    'Balai Konservasi Sumber Daya Alam Jawa Tengah merupakan Unit Pelaksana Teknis (UPT) di bawah Kementerian Lingkungan Hidup dan Kehutanan yang bertugas mengelola kawasan konservasi, melindungi satwa liar, serta menjaga kelestarian ekosistem di Jawa Tengah.'
);

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
