<?php
session_start();

// Cek status login
$is_admin = isset($_SESSION['loggedin']) && $_SESSION['role'] === 'admin';
$is_loggedin = isset($_SESSION['loggedin']);
$is_guest = !isset($_SESSION['loggedin']);

// Jalur yang benar ke file koneksi
$db_path = __DIR__ . '/../db-connect-admin.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Erorr: File koneksi database tidak ditemukan. Pastikan 'db-connect-admin.php' ada di folder yang benar.");
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam - Perlindungan</title>
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
    <div class="hero-section d-flex align-items-center" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/gunung.jpg') center/cover;">
        <div class="floating-elements">
            <div class="floating-leaf" style="top: 10%; left: 10%;"><i class="fas fa-leaf"></i></div>
            <div class="floating-leaf" style="top: 20%; right: 15%; animation-delay: -2s;"><i class="fas fa-seedling"></i></div>
            <div class="floating-leaf" style="top: 60%; left: 5%; animation-delay: -4s;"><i class="fas fa-tree"></i></div>
            <div class="floating-leaf" style="bottom: 20%; right: 10%; animation-delay: -1s;"><i class="fas fa-leaf"></i></div>
        </div>
        <div class="container hero-content">
            <div class="text-center">
                <h1 class="text-white display-2 mb-4 animated-text fw-bold">Perlindungan</h1>
                <p class="fs-4 text-white mb-4 animated-text">Tumbuhan dan Satwa Liar</p>
                <p class="fs-6 text-white-50 animated-text">Membangun kesadaran kolektif untuk kelestarian alam</p>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center pb-5">
                    <div class="judul-container">
                        <h2 class="judul-bayangan fw-bold" data-title="PERLINDUNGAN TSL">Perlindungan Tumbuhan dan Satwa Liar</h2>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInLeft" style="animation-delay: 0.2s;">
                        <div class="interactive-card p-5 hover-effect h-100">
                            <div class="text-center mb-4">
                                <div class="mission-icon"><i class="fas fa-paw"></i></div>
                                <h3 class="fw-bold text-primary">Satwa Liar</h3>
                            </div>
                            <p class="fs-6 text-muted">
                                Balai Konservasi Sumber Daya Alam Jawa Tengah berkomitmen penuh dalam perlindungan satwa liar, baik di dalam maupun di luar kawasan konservasi. Program kami mencakup penyelamatan, rehabilitasi, dan translokasi satwa liar yang terancam.
                            </p>
                            <ul class="list-unstyled mt-4">
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-primary me-2"></i>Penyelamatan dan evakuasi satwa.
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-primary me-2"></i>Pusat rehabilitasi dan pelepasliaran.
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-primary me-2"></i>Pengawasan perdagangan ilegal.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">
                        <div class="interactive-card p-5 hover-effect h-100">
                            <div class="text-center mb-4">
                                <div class="vision-icon"><i class="fas fa-tree"></i></div>
                                <h3 class="fw-bold text-success">Tumbuhan Langka</h3>
                            </div>
                            <p class="fs-6 text-muted">
                                Kami melindungi berbagai jenis tumbuhan langka yang menjadi bagian vital dari ekosistem hutan. Upaya ini melibatkan identifikasi, inventarisasi, dan pembinaan populasi tumbuhan, serta perlindungan dari eksploitasi dan perusakan habitat.
                            </p>
                            <ul class="list-unstyled mt-4">
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>Identifikasi dan pendataan flora.
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>Konservasi ex-situ dan in-situ.
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>Edukasi publik tentang tumbuhan langka.
                                </li>
                            </ul>
                        </div>
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
                    <h3 class="fw-bold mb-3">Laporkan Pelanggaran</h3>
                    <p class="text-muted mb-4">Jika Anda menemukan aktivitas yang membahayakan tumbuhan atau satwa liar, segera laporkan kepada kami. Kolaborasi Anda adalah kunci keberhasilan konservasi.</p>
                    <a href="contact.php" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-bullhorn me-2"></i>Laporkan Sekarang
                    </a>
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
            // Animate list items
            $('ul li').each(function(index) {
                const elementTop = $(this).offset().top;
                const viewportTop = $(window).scrollTop();
                const viewportBottom = viewportTop + $(window).height();
                
                if (elementTop < viewportBottom - 100) {
                    $(this).addClass('animate__animated animate__fadeInLeft');
                }
            });
        }
        $(window).scroll(checkScroll);
        checkScroll();
    </script>
</body>
</html>