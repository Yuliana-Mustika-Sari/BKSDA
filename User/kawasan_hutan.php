<?php

session_start();

// Cek status login untuk menentukan tampilan menu
$is_admin = isset($_SESSION['loggedin']) && $_SESSION['role'] === 'users';
$is_loggedin = isset($_SESSION['loggedin']);
$is_guest = !isset($_SESSION['loggedin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam - Kawasan Konservasi</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
             .interactive-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(26, 115, 55, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            position: relative;
        }

        .interactive-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .interactive-card:hover::before {
            left: 100%;
        }

        .interactive-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(26, 115, 55, 0.2);
        }

        .nav-tabs-custom {
            border: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 60px;
            padding: 8px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
        }

        .nav-tabs-custom .nav-link {
            color: #555;
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            margin: 0 5px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-tabs-custom .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .nav-tabs-custom .nav-link.active,
        .nav-tabs-custom .nav-link:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 115, 55, 0.3);
        }

        .nav-tabs-custom .nav-link.active::before,
        .nav-tabs-custom .nav-link:hover::before {
            left: 0;
        }

        .map-container {
            position: relative;
            width: 100%;
            height: 600px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            border: 3px solid var(--light-green);
        }

        /* Custom map controls styling */
        .leaflet-control-zoom {
            border-radius: 10px !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
        }

        .leaflet-control-zoom a {
            border-radius: 8px !important;
            font-size: 18px !important;
            line-height: 26px !important;
            width: 30px !important;
            height: 30px !important;
            background: rgba(255,255,255,0.95) !important;
            color: var(--primary-green) !important;
            border: 1px solid var(--light-green) !important;
        }

        .leaflet-control-zoom a:hover {
            background: var(--primary-green) !important;
            color: white !important;
            transform: scale(1.1);
        }

        .leaflet-control-custom {
            border-radius: 10px !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
            transition: all 0.3s ease !important;
        }

        .leaflet-control-custom:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 8px 25px rgba(26, 115, 55, 0.2) !important;
        }

        .leaflet-control-scale-line {
            background: rgba(255,255,255,0.9) !important;
            border: 2px solid var(--primary-green) !important;
            border-radius: 5px !important;
            color: var(--primary-green) !important;
            font-weight: bold !important;
        }

        /* Custom popup styling */
        .leaflet-popup-content-wrapper {
            border-radius: 15px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
            border: 2px solid var(--light-green) !important;
        }

        .leaflet-popup-tip {
            background: white !important;
            border: 2px solid var(--light-green) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
        }

        .custom-popup img {
            border: 2px solid var(--light-green) !important;
        }

        /* Smooth scrolling for map */
        .leaflet-container {
            cursor: grab !important;
        }

        .leaflet-container:active {
            cursor: grabbing !important;
        }

        /* Java Island focus indicator */
        .java-bounds-indicator {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(26, 115, 55, 0.9);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            z-index: 1000;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .kawasan-card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            background: #fff;
        }

        .kawasan-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }

        .kawasan-card:hover::after {
            opacity: 0.1;
        }

        .kawasan-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .kawasan-card:hover {
            transform: translateY(-15px) rotateY(5deg);
            box-shadow: 0 25px 60px rgba(26, 115, 55, 0.2);
        }

        .kawasan-card:hover img {
            transform: scale(1.15) rotateZ(2deg);
        }

        .card-content {
            padding: 25px;
            position: relative;
            z-index: 2;
        }

        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);
            color: white;
            padding: 30px 25px;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.4s ease;
            z-index: 3;
        }

        .kawasan-card:hover .card-overlay {
            transform: translateY(0);
            opacity: 1;
        }

        .stats-section {
            background: var(--gradient-primary);
            color: white;
            padding: 60px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: movePattern 20s linear infinite;
        }

        @keyframes movePattern {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(50px) translateY(50px); }
        }

        .stat-item {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 700;
            display: block;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            animation: countUp 2s ease-out;
        }

        @keyframes countUp {
            from { 
                opacity: 0;
                transform: scale(0.5);
            }
            to { 
                opacity: 1;
                transform: scale(1);
            }
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid var(--primary-green);
            background: transparent;
            color: var(--primary-green);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 55, 0.3);
        }

        .search-box {
            max-width: 400px;
            margin: 0 auto 30px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid var(--light-green);
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 20px rgba(26, 115, 55, 0.2);
        }

        .search-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-green);
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--light-green);
            border-top: 4px solid var(--primary-green);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--light-green);
            z-index: 9999;
        }

        .scroll-progress {
            height: 100%;
            background: var(--gradient-primary);
            width: 0%;
            transition: width 0.1s ease;
        }

        @media (max-width: 768px) {
            .header-bg {
                padding: 120px 0 80px;
            }
            
            .kawasan-card:hover {
                transform: translateY(-10px);
            }
            
            .map-container {
                height: 400px;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="scroll-indicator">
        <div class="scroll-progress" id="scrollProgress"></div>
    </div>

    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center" style="z-index: 10000;">
        <div class="spinner-grow text-success" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>

    <div class="container-fluid fixed-top px-0">
        <div class="topbar">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8">
                    <div class="topbar-info d-flex flex-wrap">
                        <a href="#" class="text-light me-4"><i class="fas fa-envelope text-white me-2"></i>bksda_jateng@yahoo.co.id</a>
                        <a href="#" class="text-light"><i class="fas fa-phone-alt text-white me-2"></i>(024)7614752</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="topbar-icon d-flex align-items-center justify-content-end">
                        <a href="https://www.facebook.com/bksdajawatengah" class="btn-square text-white me-2" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/bksdajawatengah" class="btn-square text-white me-2" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/bksda_jateng" class="btn-square text-white me-2" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/balai-konservasi-sumber-daya-alam-bksda-jawa-tengah" class="btn-square text-white me-0" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-light bg-light navbar-expand-xl">
            <div class="container px-0">
                <a href="../index.php" class="navbar-brand ms-3 d-flex align-items-center">
                    <img src="../img/logo2.png" alt="Logo BKSDA Jawa Tengah" style="width: 60px; height: auto;" class="me-2">
                    <div>
                        <h1 class="bksda-title fs-3 mb-0">BKSDA JAWA TENGAH</h1>
                        <h1 class="bksda-subtitle fs-6 fw-semibold mb-0">Balai Konservasi Sumber Daya Alam</h1>
                    </div>
                </a>
                <button class="navbar-toggler py-2 px-3 me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-light" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="../index.php" class="nav-item nav-link">Beranda</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profile</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="sejarah.php" class="dropdown-item">Sejarah Organisasi</a>
                                <a href="visimisi.php" class="dropdown-item">Visi & Misi</a>
                                <a href="fungsi.php" class="dropdown-item">Tugas Pokok & Fungsi</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="simaksi.php" class="dropdown-item">SIMAKSI</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Data & Informasi</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="kawasan_hutan.php" class="dropdown-item">Kawasan Konservasi</a>
                                <a href="perlindungan.php" class="dropdown-item">Perlindungan</a>
                                <a href="pemberdayaan-masyarakat.php" class="dropdown-item">Pemberdayaan Masyarakat</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        
                        <?php if ($is_loggedin): ?>
                            <a href="logout.php" class="nav-item nav-link text-danger fw-bold" onclick="return confirm('Apakah Anda yakin ingin logout dan kembali ke landing page?')">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                        <?php else: ?>
                            <a href="../landing.php" class="nav-item nav-link text-primary fw-bold">
                                <i class="fas fa-sign-in-alt me-1"></i>Logout
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="hero-section d-flex align-items-center">
        <div class="container hero-content">
            <div class="text-center">
                <h1 class="text-white display-2 mb-4 animated-text fw-bold">Kawasan Konservasi</h1>
                <p class="fs-4 text-white mb-4 animated-text">Penyebaran Wilayah Kawasan Konservasi</p>
                <p class="fs-6 text-white-50 animated-text">Menjelajahi keanekaragaman hayati di setiap sudut Jawa Tengah</p>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <ul class="nav nav-tabs nav-tabs-custom justify-content-center" id="kawasanTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-konten" type="button" role="tab">
                    <i class="fas fa-map-marked-alt me-2"></i>Peta Interaktif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-konten" type="button" role="tab">
                    <i class="fas fa-list-alt me-2"></i>Daftar Kawasan
                </button>
            </li>
        </ul>

        <div class="tab-content" id="kawasanTabContent">
            <div class="tab-pane fade show active" id="overview-konten" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="interactive-card p-4">
                            <h3 class="text-center mb-4 fw-bold" style="color: var(--primary-green);">
                                <i class="fas fa-globe-asia me-2"></i>
                                Peta Persebaran 33 Kawasan Konservasi BKSDA Jawa Tengah
                            </h3>
                            <p class="text-center text-muted mb-4">Klik pada marker untuk melihat detail kawasan konservasi</p>
                            <div class="loading-overlay" id="mapLoading">
                                <div class="spinner"></div>
                            </div>
                            <div class="java-bounds-indicator">
                                📍
                            </div>
                            <div id="map" class="map-container"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane fade" id="list-konten" role="tabpanel">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Cari kawasan konservasi..." />
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="cagar-alam">Cagar Alam</button>
                    <button class="filter-btn" data-filter="suaka-margasatwa">Suaka Margasatwa</button>
                    <button class="filter-btn" data-filter="taman-wisata">Taman Wisata Alam</button>
                    <button id="favoritesBtn" class="filter-btn" data-filter="favorites">Favorit Saya <span id="favCount" class="badge bg-light text-dark ms-2">0</span></button>
                </div>

                <div class="loading-overlay" id="listLoading">
                    <div class="spinner"></div>
                </div>

                <div class="row g-4" id="kawasan-list">
                    </div>
                
                <div id="noResults" class="text-center py-5" style="display: none;">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak ada hasil yang ditemukan</h4>
                    <p class="text-muted">Coba gunakan kata kunci yang berbeda</p>
                </div>
            </div>
        </div>
    </div>
    <div class="stats-section">
            <div class="container-fluid counter py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(../img/gunung.jpg) no-repeat center center; background-size: cover;">
                <div class="container py-5">
                    <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                        <h5 class="mb-4 text-white">Pencapaian Kami</h5>
                        <h1 class="mb-4 text-white">Bekerja Keras Untuk Konservasi Alam</h1>
                        <p class="mb-0 text-white">
                            Fakta dan angka di balik setiap usaha kami dalam melestarikan alam dan satwa liar di Jawa Tengah.
                        </p>
                    </div>
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-3">
                            <div class="counter-item text-center">
                                <h1 class="text-white fw-bold mb-4" data-toggle="counter-up">33</h1>
                                <h5 class="text-white">Kawasan Konservasi</h5>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="counter-item text-center">
                                <h1 class="text-white fw-bold mb-4" data-toggle="counter-up">256</h1>
                                <h5 class="text-white">Jenis Satwa Terlindungi</h5>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="counter-item text-center">
                                <h1 class="text-white fw-bold mb-4" data-toggle="counter-up">50</h1>
                                <h5 class="text-white">Relawan Aktif</h5>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="counter-item text-center">
                                <h1 class="text-white fw-bold mb-4" data-toggle="counter-up">1500</h1>
                                <h5 class="text-white">Hektar Hutan Reboisasi</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="container-fluid footer-bksda text-body py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                        <img src="../img/logo2.png" alt="Logo BKSDA Jawa Tengah" class="img-fluid mb-4 footer-logo">
                        <p class="mb-4">Sebagai Unit Pelaksana Teknis (UPT) Kementrian Lingkungan Hidup Dan Kehutanan yang bertugas untuk mengelola 33 kawasan konservasi berbentuk cagar alam, suaka margasatwa dan taman wisata di Jawa Tengah.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Tautan Cepat</h4>
                        <a href="index.php"><i class="fas fa-angle-right me-2"></i> Beranda</a>
                        <a href="https://play.google.com/store/apps/details?id=id.net.nexa.bksda"><i class="fas fa-angle-right me-2"></i> Aplikasi Mobile BKSDA Jateng</a>
                        <a href="https://www.perhutani.co.id/"><i class="fas fa-angle-right me-2"></i> Perusahaan Umum Kehutanan Negara</a>
                        <a href="https://www.menlhk.go.id/"><i class="fas fa-angle-right me-2"></i> Kementrian Lingkungan Hidup dan Kehutanan</a>
                        <a href="https://ksdae.or.id/"><i class="fas fa-angle-right me-2"></i> Konservasi Sumber Daya Alam dan Ekosistem</a>
                        <a href="https://www.bmkg.go.id/"><i class="fas fa-angle-right me-2"></i> BMKG</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                    <h4 class="mb-4 text-white">Hubungi Kami</h4>
    <a href="https://maps.app.goo.gl/PrbZaAM8mMZMKQBBA?g_st=aw" target="_blank" class="d-block text-body mb-2">
        <i class="fa fa-map-marker-alt me-2"></i>Jl. Dr. Suratmo No. 171 Semarang
    </a>
    <a href="tel:+62247614752" class="d-block text-body mb-2">
        <i class="fa fa-phone-alt me-2"></i>(024)7614752
    </a>
    <a href="mailto:bksda_jateng@yahoo.co.id" class="d-block text-body mb-2">
        <i class="fa fa-envelope me-2"></i>bksda_jateng@yahoo.co.id
    </a>
</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid copyright bg-dark text-body py-4">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <div class="social-media mb-3">
                <a href="https://www.facebook.com/bksdajawatengah/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://x.com/bksdajawatengah" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/bksda_jateng/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/balai-konservasi-sumber-daya-alam-bksda-jawa-tengah/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="text-center text-white">
                <span>© BKSDA JAWA TENGAH. All rights reserved.</span>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top"><i class="fa fa-arrow-up"></i></a>
    <div class="modal fade" id="kawasanModal" tabindex="-1" aria-labelledby="kModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kModalTitle">Detail Kawasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <img id="kModalImage" src="" alt="" class="img-fluid rounded" style="width:100%; height:auto; object-fit:cover;" />
                        </div>
                        <div class="col-md-6">
                            <p><strong>Jenis:</strong> <span id="kModalType"></span></p>
                            <p id="kModalDesc"></p>
                            <p><strong>Koordinat:</strong> <span id="kModalCoords"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="window.print();">Cetak</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <!-- favorites view removed: now shown as filter/list instead of modal -->
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
        // Data 33 kawasan konservasi BKSDA Jawa Tengah berdasarkan peta
        const kawasanData = [
            // Cagar Alam
            { id: 1, name: "CA Baturraden", type: "cagar-alam", lat: -7.3167, lng: 109.2167, description: "Hutan pegunungan di lereng Gunung Slamet dengan air terjun dan pemandian air panas.", image: "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400" },
            { id: 2, name: "CA Karangbolong", type: "cagar-alam", lat: -7.690, lng: 109.117, description: "Kawasan karst Kebumen dengan gua alami dan keanekaragaman flora.", image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400" },
            { id: 3, name: "CA Leuweung Sancang", type: "cagar-alam", lat: -7.5167, lng: 108.7167, description: "Hutan tropis pantai selatan Garut, habitat banteng jawa dan flora endemik.", image: "https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=400" },
            { id: 4, name: "CA Nusakambangan Timur", type: "cagar-alam", lat: -7.7333, lng: 108.9000, description: "Pulau dengan hutan tropis dan satwa langka seperti lutung.", image: "https://images.unsplash.com/photo-1500375592092-40eb2168fd21?w=400" },
            { id: 5, name: "CA Nusakambangan Barat", type: "cagar-alam", lat: -7.7167, lng: 108.8333, description: "Hutan hujan pulau Nusakambangan dengan keanekaragaman satwa liar.", image: "https://images.unsplash.com/photo-1551632811-561732d1e306?w=400" },
            { id: 6, name: "CA Panjalu", type: "cagar-alam", lat: -7.1500, lng: 108.2500, description: "Danau alami Situ Lengkong dengan ekosistem perairan tawar.", image: "https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?w=400" },
            { id: 7, name: "CA Telaga Warna", type: "cagar-alam", lat: -7.2000, lng: 109.9167, description: "Telaga dengan warna air yang berubah-ubah", image: "https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=400" },
            { id: 8, name: "CA Kawah Kamojang", type: "cagar-alam", lat: -7.1333, lng: 107.8000, description: "Kawah vulkanik dengan aktivitas geothermal", image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400" },
            { id: 9, name: "CA Wonosadi", type: "cagar-alam", lat: -7.8500, lng: 110.5000, description: "Hutan jati dengan nilai konservasi tinggi", image: "https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=400" },
            { id: 10, name: "CA Dieng", type: "cagar-alam", lat: -7.2000, lng: 109.9000, description: "Dataran tinggi dengan danau vulkanik", image: "https://images.unsplash.com/photo-1500375592092-40eb2168fd21?w=400" },
            { id: 11, name: "CA Ulolanang", type: "cagar-alam", lat: -7.3000, lng: 109.8500, description: "Kawasan pegunungan dengan hutan primer", image: "https://images.unsplash.com/photo-1551632811-561732d1e306?w=400" },
            { id: 12, name: "CA Yanlappa", type: "cagar-alam", lat: -7.4000, lng: 109.7000, description: "Hutan hujan tropis dengan flora langka", image: "https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?w=400" },
            { id: 13, name: "CA Pananjung Pangandaran", type: "cagar-alam", lat: -7.7000, lng: 108.6500, description: "Hutan pantai dengan mangrove", image: "https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=400" },
            { id: 14, name: "CA Bojonglarang Jayanti", type: "cagar-alam", lat: -7.0500, lng: 108.5000, description: "Kawasan karst dengan ekosistem unik", image: "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400" },
            { id: 15, name: "CA Dungus Iwul", type: "cagar-alam", lat: -7.2500, lng: 109.5000, description: "Hutan dengan pohon iwul endemik", image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400" },
            { id: 16, name: "CA Sikundur", type: "cagar-alam", lat: -7.1000, lng: 109.3000, description: "Kawasan konservasi dengan mata air alami", image: "https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=400" },
            { id: 17, name: "CA Kalikuning", type: "cagar-alam", lat: -7.0000, lng: 109.1000, description: "Hutan pegunungan dengan udara sejuk", image: "https://images.unsplash.com/photo-1500375592092-40eb2168fd21?w=400" },
            { id: 18, name: "CA Gunung Slamet", type: "cagar-alam", lat: -7.2419, lng: 109.2081, description: "Gunung tertinggi di Jawa Tengah", image: "https://images.unsplash.com/photo-1551632811-561732d1e306?w=400" },
            { id: 19, name: "CA Pegunungan Kendeng", type: "cagar-alam", lat: -7.1500, lng: 110.5000, description: "Kawasan pegunungan kapur dengan gua", image: "https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?w=400" },
            { id: 20, name: "CA Kemuning", type: "cagar-alam", lat: -7.4500, lng: 109.8000, description: "Hutan dengan bunga kemuning langka", image: "https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=400" },
            { id: 21, name: "CA Petungkriono", type: "cagar-alam", lat: -7.1000, lng: 109.5500, description: "Kawasan dengan air terjun spektakuler", image: "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400" },
            { id: 22, name: "CA Linggoasri", type: "cagar-alam", lat: -7.3500, lng: 109.6000, description: "Hutan jati kuno dengan nilai sejarah", image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400" },
            { id: 23, name: "CA Sempor", type: "cagar-alam", lat: -7.2000, lng: 109.4000, description: "Danau buatan dengan ekosistem unik", image: "https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=400" },
            { id: 24, name: "CA Borobudur", type: "cagar-alam", lat: -7.6079, lng: 110.2038, description: "Area di sekitar candi Borobudur", image: "https://images.unsplash.com/photo-1500375592092-40eb2168fd21?w=400" },
            { id: 25, name: "CA Gunung Merapi", type: "cagar-alam", lat: -7.5407, lng: 110.4461, description: "Gunung berapi aktif dengan ekosistem vulkanik", image: "https://images.unsplash.com/photo-1551632811-561732d1e306?w=400" },
            { id: 26, name: "CA Gunung Merbabu", type: "cagar-alam", lat: -7.4550, lng: 110.4303, description: "Gunung dengan padang savana indah", image: "https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?w=400" },
            { id: 27, name: "CA Donoloyo", type: "cagar-alam", lat: -7.868, lng: 110.999, description: "Kawasan dengan sumber mata air jernih", image: "https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=400" },

            // Suaka Margasatwa
            { id: 28, name: "SM Gunung Tunggangan", type: "suaka-margasatwa", lat: -7.348, lng: 109.923, description: "Habitat alami berbagai satwa langka", image: "https://images.unsplash.com/photo-1547036967-23d11aacaee0?w=400" },

            // Taman Wisata Alam
            { id: 29, name: "TWA Guci", type: "taman-wisata", lat: -7.151, lng: 109.289, description: "Pemandian air panas alami di pegunungan", image: "https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?w=400" },
            { id: 30, name: "TWA Kopeng", type: "taman-wisata", lat: -7.3000, lng: 110.4000, description: "Kawasan wisata alam pegunungan sejuk", image: "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400" },
            { id: 31, name: "TWA Kawah Sikidang", type: "taman-wisata", lat: -7.2083, lng: 109.9167, description: "Kawah vulkanik dengan fenomena alam unik", image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400" },
            { id: 32, name: "TWA Tinggi Raja", type: "taman-wisata", lat: -7.1500, lng: 109.8000, description: "Wisata alam dengan panorama pegunungan", image: "https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=400" },
            { id: 33, name: "TN Karimun Jawa", type: "taman-wisata", lat: -5.8427, lng: 110.4285, description: "Taman nasional laut dengan keanekaragaman biota laut", image: "https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400" }
        ];

        let map;
        let markersLayer;
        let currentData = kawasanData;

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeMap();
            initializeKawasanList();
            initializeSearch();
            initializeFilters();
            initializeScrollProgress();
            
            // Remove spinner after everything loads
            setTimeout(() => {
                $('#spinner').removeClass('show');
            }, 1000);
        });

        // Initialize Leaflet map
        function initializeMap() {
            const mapElement = document.getElementById('map');
            if (!mapElement) return;

            // Show loading
            document.getElementById('mapLoading').classList.add('show');

            // Initialize map focused on Java Island with better bounds
            map = L.map('map', {
                center: [-7.5, 110.0],
                zoom: 8,
                minZoom: 7,
                maxZoom: 15,
                scrollWheelZoom: true,
                zoomControl: true,
                dragging: true,
                touchZoom: true,
                doubleClickZoom: true,
                boxZoom: true,
                keyboard: true,
                zoomSnap: 0.5,
                zoomDelta: 0.5
            });

            // Set bounds to Java Island to prevent excessive panning
            const javaBounds = L.latLngBounds(
                L.latLng(-8.8, 105.0), // Southwest corner (southern Java, western border)
                L.latLng(-5.5, 115.5)  // Northeast corner (northern Java, eastern border)
            );
            
            map.setMaxBounds(javaBounds);
            map.fitBounds(javaBounds, { padding: [20, 20] });

            // Add OpenStreetMap tiles with better styling for Java
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 15,
                minZoom: 7
            }).addTo(map);

            // Add custom zoom controls with better positioning
            map.zoomControl.setPosition('topright');

            // Add scale control
            L.control.scale({
                position: 'bottomleft',
                metric: true,
                imperial: false
            }).addTo(map);

            // Create markers layer group
            markersLayer = L.layerGroup().addTo(map);

            // Add markers for each kawasan
            addMarkersToMap();

            // Add smooth zoom to Central Java button
            addZoomToCentralJavaControl();

            // Hide loading after map is ready
            map.whenReady(function() {
                setTimeout(() => {
                    document.getElementById('mapLoading').classList.remove('show');
                }, 500);
            });
        }

        // Add custom control to zoom to Central Java
        function addZoomToCentralJavaControl() {
            const ZoomToCentralJava = L.Control.extend({
                onAdd: function(map) {
                    const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                    
                    container.style.backgroundColor = 'white';
                    container.style.backgroundImage = 'none';
                    container.style.width = '40px';
                    container.style.height = '40px';
                    container.style.cursor = 'pointer';
                    container.style.display = 'flex';
                    container.style.alignItems = 'center';
                    container.style.justifyContent = 'center';
                    container.style.fontSize = '16px';
                    container.style.fontWeight = 'bold';
                    container.style.color = '#1a7337';
                    container.innerHTML = '🎯';
                    container.title = 'Fokus ke Jawa Tengah';

                    container.onclick = function() {
                        // Smooth zoom to Central Java with all markers visible
                        const centralJavaBounds = L.latLngBounds([
                            [-8.0, 108.0],  // Southwest
                            [-6.0, 112.0]   // Northeast
                        ]);
                        
                        map.fitBounds(centralJavaBounds, {
                            padding: [30, 30],
                            animate: true,
                            duration: 1.5
                        });
                    };

                    return container;
                }
            });

            map.addControl(new ZoomToCentralJava({ position: 'topright' }));
        }

        // Add markers to map
        function addMarkersToMap() {
            markersLayer.clearLayers();

            kawasanData.forEach(function(kawasan) {
                // Custom icon based on type
                let iconColor = '#1a7337';
                if (kawasan.type === 'suaka-margasatwa') iconColor = '#dc3545';
                else if (kawasan.type === 'taman-wisata') iconColor = '#007bff';

                // Create custom marker
                const marker = L.circleMarker([kawasan.lat, kawasan.lng], {
                    radius: 8,
                    fillColor: iconColor,
                    color: '#fff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.8
                });

                // Add hover effects
                marker.on('mouseover', function(e) {
                    this.setRadius(12);
                    this.openTooltip();
                });

                marker.on('mouseout', function(e) {
                    this.setRadius(8);
                    this.closeTooltip();
                });

                // Bind popup with detailed info and a detail button
                const popupContent = `
                    <div class="custom-popup">
                        <img src="${kawasan.image}" alt="${kawasan.name}" style="width: 200px; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
                        <h6 class="fw-bold mb-2">${kawasan.name}</h6>
                        <p class="small text-muted mb-2">${kawasan.description}</p>
                        <span class="badge bg-${kawasan.type === 'cagar-alam' ? 'success' : kawasan.type === 'suaka-margasatwa' ? 'danger' : 'primary'}">${getTypeLabel(kawasan.type)}</span>
                        <div class="mt-2 text-end">
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="showDetail(${kawasan.id});">Lihat Detail</button>
                            <button class="btn btn-sm btn-outline-warning" onclick="toggleFavorite(${kawasan.id});">❤</button>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);
                marker.bindTooltip(kawasan.name, {
                    permanent: false,
                    direction: 'top'
                });

                markersLayer.addLayer(marker);
            });
        }

        // Initialize kawasan list
        function initializeKawasanList() {
            renderKawasanList(currentData);
        }

        // Render kawasan list
        function renderKawasanList(data) {
            const container = document.getElementById('kawasan-list');
            const noResults = document.getElementById('noResults');
            
            if (data.length === 0) {
                container.innerHTML = '';
                noResults.style.display = 'block';
                return;
            }

            noResults.style.display = 'none';
            
            container.innerHTML = data.map(kawasan => `
                <div class="col-md-6 col-lg-4 kawasan-item" data-type="${kawasan.type}">
                    <div class="kawasan-card interactive-card h-100">
                        <div class="position-relative" onclick="focusOnKawasan(${kawasan.lat}, ${kawasan.lng}, '${kawasan.name}')" style="cursor: pointer;">
                            <img src="${kawasan.image}" class="card-img-top" alt="${kawasan.name}" loading="lazy">
                            <div class="card-overlay">
                                <h5 class="fw-bold mb-2">${kawasan.name}</h5>
                                <p class="small mb-3">${kawasan.description}</p>
                                <span class="badge bg-${kawasan.type === 'cagar-alam' ? 'success' : kawasan.type === 'suaka-margasatwa' ? 'danger' : 'primary'}">${getTypeLabel(kawasan.type)}</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <h6 class="card-title fw-bold mb-2">${kawasan.name}</h6>
                            <p class="card-text text-muted small mb-3">${kawasan.description}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-${kawasan.type === 'cagar-alam' ? 'success' : kawasan.type === 'suaka-margasatwa' ? 'danger' : 'primary'}">${getTypeLabel(kawasan.type)}</span>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    ${kawasan.lat.toFixed(3)}, ${kawasan.lng.toFixed(3)}
                                </small>
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <button class="btn btn-sm btn-outline-primary me-2" onclick="showDetail(${kawasan.id}); event.stopPropagation();">Lihat Detail</button>
                                <button class="btn btn-sm btn-outline-warning me-2 fav-toggle" data-id="${kawasan.id}" onclick="toggleFavorite(${kawasan.id}); event.stopPropagation();">❤</button>
                                <button class="btn btn-sm btn-success" onclick="focusOnKawasan(${kawasan.lat}, ${kawasan.lng}, '${kawasan.name}'); event.stopPropagation();">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');

            // Add animation to cards
            const cards = container.querySelectorAll('.kawasan-item');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate__animated', 'animate__fadeInUp');
            });

            // Update favorite buttons state and count after rendering
            updateFavoriteButtons();
            updateFavCount();
        }

        // Focus on kawasan in map
        function focusOnKawasan(lat, lng, name) {
            // Switch to map tab
            const mapTab = document.getElementById('overview-tab');
            const mapTabPane = document.getElementById('overview-konten');
            const listTabPane = document.getElementById('list-konten');
            
            // Activate map tab
            mapTab.classList.add('active');
            document.getElementById('list-tab').classList.remove('active');
            mapTabPane.classList.add('show', 'active');
            listTabPane.classList.remove('show', 'active');

            // Focus on location with smooth animation
            setTimeout(() => {
                map.setView([lat, lng], 12, {
                    animate: true,
                    pan: {
                        animate: true,
                        duration: 1.5,
                        easeLinearity: 0.1
                    },
                    zoom: {
                        animate: true,
                        duration: 1.5
                    }
                });

                // Find and open popup for this location
                markersLayer.eachLayer(function(marker) {
                    const markerLatLng = marker.getLatLng();
                    if (Math.abs(markerLatLng.lat - lat) < 0.01 && Math.abs(markerLatLng.lng - lng) < 0.01) {
                        setTimeout(() => {
                            marker.openPopup();
                            // Add pulse animation to focused marker
                            marker.setStyle({
                                radius: 15,
                                fillColor: '#ffff00',
                                color: '#ff0000',
                                weight: 3
                            });
                            
                            // Reset marker style after 3 seconds
                            setTimeout(() => {
                                let iconColor = '#1a7337';
                                const kawasanType = kawasanData.find(k => 
                                    Math.abs(k.lat - lat) < 0.01 && Math.abs(k.lng - lng) < 0.01
                                )?.type;
                                
                                if (kawasanType === 'suaka-margasatwa') iconColor = '#dc3545';
                                else if (kawasanType === 'taman-wisata') iconColor = '#007bff';
                                
                                marker.setStyle({
                                    radius: 8,
                                    fillColor: iconColor,
                                    color: '#fff',
                                    weight: 2
                                });
                            }, 3000);
                        }, 800);
                    }
                });
            }, 300);
        }

        // Initialize search functionality
        function initializeSearch() {
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filterData();
                }, 300);
            });
        }

        // Initialize filter buttons
        function initializeFilters() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update active button
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // If favorites button clicked, switch to list tab and show favorites
                    if (this.dataset.filter === 'favorites') {
                        // activate list tab
                        document.getElementById('list-tab').click();
                        filterData();
                        return;
                    }

                    filterData();
                });
            });

            // initialize favorite count and button state
            updateFavCount();
            updateFavoriteButtons();
        }

        // Filter data based on search and filter
        function filterData() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
            
            let filteredData = kawasanData;

            // Apply favorites filter first
            if (activeFilter === 'favorites') {
                filteredData = filteredData.filter(item => isFavorite(item.id));
            } else {
                // Apply type filter
                if (activeFilter !== 'all') {
                    filteredData = filteredData.filter(item => item.type === activeFilter);
                }
            }

            // Apply search filter
            if (searchTerm) {
                filteredData = filteredData.filter(item => 
                    item.name.toLowerCase().includes(searchTerm) ||
                    item.description.toLowerCase().includes(searchTerm)
                );
            }

            currentData = filteredData;
            renderKawasanList(currentData);
        }

        // Get type label
        function getTypeLabel(type) {
            const labels = {
                'cagar-alam': 'Cagar Alam',
                'suaka-margasatwa': 'Suaka Margasatwa',
                'taman-wisata': 'Taman Wisata Alam'
            };
            return labels[type] || type;
        }

        // Show detail modal for a kawasan
        function showDetail(id) {
            const kawasan = kawasanData.find(k => k.id === id);
            if (!kawasan) return;

            // Populate modal fields
            document.getElementById('kModalTitle').innerText = kawasan.name;
            document.getElementById('kModalImage').src = kawasan.image;
            document.getElementById('kModalImage').alt = kawasan.name;
            document.getElementById('kModalType').innerText = getTypeLabel(kawasan.type);
            document.getElementById('kModalDesc').innerText = kawasan.description;
            document.getElementById('kModalCoords').innerText = `${kawasan.lat.toFixed(5)}, ${kawasan.lng.toFixed(5)}`;

            // Show Bootstrap modal
            const modalEl = document.getElementById('kawasanModal');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }

        // Favorites management using localStorage
        const FAVORITES_KEY = 'bksda_favorites';

        function getFavorites() {
            try {
                const raw = localStorage.getItem(FAVORITES_KEY);
                return raw ? JSON.parse(raw) : [];
            } catch (e) {
                return [];
            }
        }

        function saveFavorites(list) {
            localStorage.setItem(FAVORITES_KEY, JSON.stringify(list));
            updateFavCount();
        }

        function isFavorite(id) {
            return getFavorites().indexOf(id) !== -1;
        }

        function toggleFavorite(id) {
            const favs = getFavorites();
            const idx = favs.indexOf(id);
            if (idx === -1) favs.push(id); else favs.splice(idx, 1);
            saveFavorites(favs);
            // update UI buttons
            updateFavoriteButtons();
            // if favorites filter active, re-filter
            if (document.querySelector('.filter-btn.active')?.dataset.filter === 'favorites') filterData();
        }

        function updateFavCount() {
            const el = document.getElementById('favCount');
            if (!el) return;
            el.innerText = getFavorites().length;
        }

        function updateFavoriteButtons() {
            const favs = getFavorites();
            document.querySelectorAll('.fav-toggle').forEach(btn => {
                const id = Number(btn.dataset.id);
                if (favs.indexOf(id) !== -1) {
                    btn.classList.add('btn-warning');
                    btn.classList.remove('btn-outline-warning');
                } else {
                    btn.classList.remove('btn-warning');
                    btn.classList.add('btn-outline-warning');
                }
            });
        }

        // favorites view handled in filter/list view (no modal)


        // Initialize scroll progress indicator
        function initializeScrollProgress() {
            const progressBar = document.getElementById('scrollProgress');
            
            window.addEventListener('scroll', function() {
                const scrollTotal = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrollCurrent = window.pageYOffset;
                const scrollPercentage = (scrollCurrent / scrollTotal) * 100;
                
                progressBar.style.width = scrollPercentage + '%';
            });
        }

        // Tab switching with smooth transitions
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            const targetPane = $(e.target.getAttribute('data-bs-target'));
            targetPane.hide().fadeIn(500);
            
            // Refresh map when switching to map tab
            if (e.target.id === 'overview-tab' && map) {
                setTimeout(() => {
                    map.invalidateSize();
                }, 300);
            }
        });

        // Initialize WOW.js for animations
        if (typeof WOW !== 'undefined') {
            new WOW({
                boxClass: 'wow',
                animateClass: 'animate__animated',
                offset: 100,
                mobile: true,
                live: true
            }).init();
        }
        // Smooth scrolling for back to top button
        document.querySelector('.back-to-top')?.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Show/hide back to top button
        window.addEventListener('scroll', function() {
            const backToTop = document.querySelector('.back-to-top');
            if (backToTop) {
                if (window.pageYOffset > 300) {
                    backToTop.style.display = 'block';
                } else {
                    backToTop.style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>