<?php
session_start();

// Cek status login untuk menentukan tampilan menu
$is_admin = isset($_SESSION['loggedin']) && $_SESSION['role'] === 'users';
$is_loggedin = isset($_SESSION['loggedin']);
$is_guest = !isset($_SESSION['loggedin']);

$db_path = __DIR__ . '/../db-connect-admin.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Error: File koneksi database tidak ditemukan. Pastikan 'db-connect-admin.php' ada di folder yang benar.");
}

$sql_visi = "SELECT title, content FROM web_content WHERE page_slug = 'visimisi' AND section_id = 'visi'";
$result_visi = $conn->query($sql_visi);
$visi = $result_visi->fetch_assoc();

$sql_misi = "SELECT title, content FROM web_content WHERE page_slug = 'visimisi' AND section_id = 'misi'";
$result_misi = $conn->query($sql_misi);
$misi = $result_misi->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam - Visi & Misi</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
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
                        <a href="https://www.linkedin.com/in/balai-konservasi-sumber-daya-alam-bksda-jawa-tengah" class="btn-square text-white me-0" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
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
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Profile</a>
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
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Data & Informasi</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="kawasan_hutan.php" class="dropdown-item">Kawasan Konservasi</a>
                                <a href="perlindungan.php" class="dropdown-item">Perlindungan</a>
                                <a href="pemberdayaan-masyarakat.php" class="dropdown-item">Pemberdayaan Masyarakat</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        
                        <!-- Logout/Login Button in Navbar -->
                        <?php if ($is_loggedin): ?>
                            <a href="logout.php" class="nav-item nav-link text-danger fw-bold" onclick="return confirm('Apakah Anda yakin ingin logout dan kembali ke landing page?')">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                        <?php else: ?>
                            <a href="../landing.php" class="nav-item nav-link text-primary fw-bold">
                                <i class="fas fa-sign-in-alt me-1"></i>logout
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
                <h1 class="text-white display-2 mb-4 animated-text fw-bold">Visi & Misi</h1>
                <p class="fs-4 text-white mb-4 animated-text">Balai Konservasi Sumber Daya Alam Jawa Tengah</p>
                <p class="fs-6 text-white-50 animated-text">Membangun masa depan yang berkelanjutan melalui konservasi alam</p>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <ul class="nav nav-tabs nav-tabs-custom" id="visionMissionTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                    <i class="fas fa-eye me-2"></i>Overview
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vision-tab" data-bs-toggle="tab" data-bs-target="#vision" type="button" role="tab">
                    <i class="fas fa-lightbulb me-2"></i>Visi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="mission-tab" data-bs-toggle="tab" data-bs-target="#mission" type="button" role="tab">
                    <i class="fas fa-target me-2"></i>Misi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline" type="button" role="tab">
                    <i class="fas fa-history me-2"></i>Timeline
                </button>
            </li>
        </ul>
        <div class="tab-content" id="visionMissionTabContent">
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row g-4 mt-4">
                    <div class="col-md-6">
                        <div class="interactive-card p-5 text-center hover-effect">
                            <div class="vision-icon pulse-animation">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3 class="fw-bold text-primary mb-3">VISI</h3>
                            <p class="text-muted">Pandangan masa depan yang ingin dicapai oleh BKSDA Jawa Tengah dalam pengelolaan konservasi alam.</p>
                            <button class="btn btn-outline-primary" onclick="document.getElementById('vision-tab').click()">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="interactive-card p-5 text-center hover-effect">
                            <div class="mission-icon pulse-animation" style="animation-delay: 0.5s;">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3 class="fw-bold text-success mb-3">MISI</h3>
                            <p class="text-muted">Langkah-langkah strategis yang dilakukan untuk mencapai visi konservasi sumber daya alam.</p>
                            <button class="btn btn-outline-primary" onclick="document.getElementById('mission-tab').click()">
                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="vision" role="tabpanel">
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-10">
                        <div class="interactive-card p-5 text-center">
                            <div class="vision-icon mb-4">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h2 class="fw-bold text-uppercase text-primary mb-4" style="letter-spacing: 3px;">VISI KAMI</h2>
                            <div class="p-4 rounded-3" style="background: linear-gradient(135deg, #1f7a67 0%, #2d5a4d 100%); color: white;">
                                <p class="mb-0 fs-4 lh-base">
                                    <i class="fas fa-quote-left me-3"></i>
                                    Terwujudnya pengelolaan sumber daya alam hayati dan ekosistemnya yang aman, mantap, dan berkelanjutan untuk kesejahteraan masyarakat dan kelestarian lingkungan.
                                    <i class="fas fa-quote-right ms-3"></i>
                                </p>
                            </div>
                            <div class="row g-4 mt-4">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                                        <h5>Aman</h5>
                                        <p class="text-muted">Perlindungan ekosistem dari ancaman</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="fas fa-mountain fa-3x text-success mb-3"></i>
                                        <h5>Mantap</h5>
                                        <p class="text-muted">Pengelolaan yang kuat dan konsisten</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="fas fa-recycle fa-3x text-info mb-3"></i>
                                        <h5>Berkelanjutan</h5>
                                        <p class="text-muted">Untuk generasi masa depan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="mission" role="tabpanel">
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-10">
                        <div class="interactive-card p-5">
                            <div class="text-center mb-5">
                                <div class="mission-icon">
                                    <i class="fas fa-target"></i>
                                </div>
                                <h2 class="fw-bold text-uppercase text-success mb-3" style="letter-spacing: 3px;">MISI KAMI</h2>
                                <p class="text-muted fs-5">Untuk mewujudkan visi tersebut, BKSDA Jawa Tengah mengemban misi:</p>
                            </div>
                            
                            <div class="mission-list">
                                <div class="mission-item">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-leaf text-success fs-4 me-3 mt-1"></i>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-2">Konservasi Terpadu</h5>
                                            <p class="mb-0">Melaksanakan konservasi keanekaragaman hayati dan ekosistemnya secara terpadu dan berkelanjutan.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mission-item">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-users text-primary fs-4 me-3 mt-1"></i>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-2">Pemanfaatan Bijaksana</h5>
                                            <p class="mb-0">Memanfaatkan sumber daya alam secara bijaksana demi kesejahteraan masyarakat.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mission-item">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-graduation-cap text-warning fs-4 me-3 mt-1"></i>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-2">Edukasi Publik</h5>
                                            <p class="mb-0">Meningkatkan kesadaran publik akan pentingnya kelestarian lingkungan.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mission-item">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-handshake text-info fs-4 me-3 mt-1"></i>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-2">Kerjasama Strategis</h5>
                                            <p class="mb-0">Membangun kerja sama strategis dengan berbagai pihak untuk mendukung konservasi.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="timeline" role="tabpanel">
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-10">
                        <h3 class="text-center mb-5 fw-bold">Perjalanan Visi & Misi BKSDA</h3>
                        
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-icon">
                                    <i class="fas fa-flag"></i>
                                </div>
                                <h4 class="fw-bold text-primary">Penetapan Visi</h4>
                                <p class="mb-0">Visi BKSDA Jawa Tengah ditetapkan sebagai panduan utama dalam pengelolaan konservasi sumber daya alam hayati yang berkelanjutan.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-icon">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <h4 class="fw-bold text-primary">Implementasi Misi</h4>
                                <p class="mb-0">Empat pilar misi utama dijalankan secara konsisten untuk mencapai tujuan konservasi yang optimal dan berkelanjutan.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4 class="fw-bold text-primary">Evaluasi & Pengembangan</h4>
                                <p class="mb-0">Evaluasi berkelanjutan terhadap pencapaian visi dan misi untuk memastikan efektivitas program konservasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="stats-section">
    <div class="container-fluid counter py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(../img/gunung.jpg) no-repeat center center; background-size: cover;">
    <div class="container py-5">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h5 class="mb-4 text-white ">Pencapaian Kami</h5>
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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="interactive-card p-5 text-center">
                    <i class="fas fa-hands-helping fa-4x text-success mb-4"></i>
                    <h3 class="fw-bold mb-3">Bergabunglah dengan Misi Kami</h3>
                    <p class="text-muted mb-4">Mari bersama-sama mewujudkan visi konservasi alam yang berkelanjutan untuk generasi masa depan. Setiap kontribusi Anda sangat berarti dalam pelestarian keanekaragaman hayati Indonesia.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="contact.php" class="btn btn-success btn-lg px-4">
                            <i class="fas fa-envelope me-2"></i>Hubungi Kami
                        </a>
                        <a href="perlindungan.php" class="btn btn-outline-success btn-lg px-4">
                            <i class="fas fa-leaf me-2"></i>Program Konservasi
                        </a>
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
                        <p class="mb-4">Sebagai Unit Pelaksana Teknis (UPT) Kementerian Lingkungan Hidup Dan Kehutanan yang bertugas untuk mengelola 33 kawasan konservasi berbentuk cagar alam, suaka margasatwa dan taman wisata di Jawa Tengah.</p>
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
    </div>
    <div class="container-fluid copyright bg-dark text-body py-4">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <div class="social-media mb-3">
                <a href="https://www.facebook.com/bksdajawatengah/" target="_blank" aria-label="Facebook" class="hover-effect"><i class="fab fa-facebook-f"></i></a>
                <a href="https://x.com/bksdajawatengah" target="_blank" aria-label="Twitter" class="hover-effect"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/bksda_jateng/" target="_blank" aria-label="Instagram" class="hover-effect"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/balai-konservasi-sumber-daya-alam-bksda-jawa-tengah/" target="_blank" aria-label="LinkedIn" class="hover-effect"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="text-center text-white">
                <span>© 2024 BKSDA JAWA TENGAH. All rights reserved. | Visi & Misi untuk Konservasi Berkelanjutan</span>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top hover-effect"><i class="fa fa-arrow-up"></i></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
        // Animated Counter
        function animateCounter() {
            $('.stats-number').each(function() {
                const $this = $(this);
                const target = parseInt($this.attr('data-target'));
                
                $({ countNum: 0 }).animate({
                    countNum: target
                }, {
                    duration: 2000,
                    easing: 'linear',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(target);
                    }
                });
            });
        }

        // Trigger counter animation when stats section is visible
        $(document).ready(function() {
            let counterTriggered = false;
            
            $(window).scroll(function() {
                if (!counterTriggered && $('.stats-section').offset().top - $(window).scrollTop() < $(window).height()) {
                    animateCounter();
                    counterTriggered = true;
                }
            });

            // Tab click animations
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                $(e.target.getAttribute('data-bs-target')).hide().fadeIn(500);
            });

            // Smooth scrolling for internal links
            $('a[href^="#"]').click(function(e) {
                e.preventDefault();
                const target = $($(this).attr('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            });

            // Add parallax effect to hero section
            $(window).scroll(function() {
                const scrolled = $(this).scrollTop();
                const rate = scrolled * -0.5;
                $('.hero-section').css('transform', 'translateY(' + rate + 'px)');
            });

            // Interactive card animations on scroll
            function checkScroll() {
                $('.interactive-card').each(function() {
                    const elementTop = $(this).offset().top;
                    const elementBottom = elementTop + $(this).outerHeight();
                    const viewportTop = $(window).scrollTop();
                    const viewportBottom = viewportTop + $(window).height();

                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $(this).addClass('animate__animated animate__fadeInUp');
                    }
                });
            }

            $(window).scroll(checkScroll);
            checkScroll(); // Check on page load
        });

        // Add hover sound effect (optional)
        $('.interactive-card, .stats-item').hover(
            function() {
                $(this).addClass('pulse');
            },
            function() {
                $(this).removeClass('pulse');
            }
        );

        // Dynamic background color change based on active tab
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            const targetTab = e.target.getAttribute('data-bs-target');
            const body = $('body');
            
            body.removeClass('vision-theme mission-theme timeline-theme overview-theme');
            
            switch(targetTab) {
                case '#vision':
                    body.addClass('vision-theme');
                    break;
                case '#mission':
                    body.addClass('mission-theme');
                    break;
                case '#timeline':
                    body.addClass('timeline-theme');
                    break;
                default:
                    body.addClass('overview-theme');
            }
        });
    </script>
</body>
</html>