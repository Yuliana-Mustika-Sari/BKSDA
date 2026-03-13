<?php
session_start();
// Cek status login untuk menentukan tampilan menu
$is_admin = isset($_SESSION['loggedin']) && $_SESSION['role'] === 'users';
$is_loggedin = isset($_SESSION['loggedin']);
$is_guest = !isset($_SESSION['loggedin']);
// Menggunakan koneksi ke database simaksi
$db_path = __DIR__ . '/../simaksi-db.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Erorr: File koneksi database tidak ditemukan. Pastikan 'db-connect-simaksi.php' ada di folder yang benar.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam - SIMAKSI</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
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
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Layanan</a>
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
                                <a href="peraturan.php" class="dropdown-item">Peraturan</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        
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
                <h1 class="text-white display-2 mb-4 animated-text fw-bold">SIMAKSI</h1>
                <p class="fs-4 text-white mb-4 animated-text">Sistem Perizinan Akses Kawasan Konservasi</p>
                <p class="fs-6 text-white-50 animated-text">Mempermudah permohonan dan pengelolaan perizinan kegiatan di kawasan konservasi.</p>
            </div>
        </div>
    </div>

    <div class="container-fluid blog py-5" style="font-family: 'Poppins', sans-serif;">
    <div class="container py-5">
        <div class="text-center pb-5" style="max-width: 800px; margin: 0 auto;">
            <h2 class="judul-bayangan fw-bold" data-title="SISTEM SIMAKSI">Sistem SIMAKSI</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="p-4 rounded shadow-sm bg-light mb-5">
                    <p class="fs-6 mb-4">
                        SIMAKSI atau Sistem Informasi Manajemen Akses Kawasan Konservasi adalah platform terpadu yang memfasilitasi perizinan kegiatan di kawasan konservasi. Sistem ini bertujuan untuk mempermudah masyarakat dalam mengajukan permohonan kunjungan, penelitian, atau kegiatan lainnya secara legal dan terkelola.
                    </p>
                    <h4 class="fw-bold mb-3">Mengapa SIMAKSI Penting?</h4>
                    <p class="fs-6 mb-4">
                        Sosialisasi SIMAKSI bertujuan untuk meningkatkan kesadaran publik akan pentingnya perizinan dalam setiap aktivitas di kawasan konservasi. Dengan memiliki izin, Anda tidak hanya mematuhi peraturan, tetapi juga berkontribusi langsung pada perlindungan ekosistem dan satwa liar, serta memastikan keamanan diri Anda sendiri.
                    </p>
                </div>
            </div>
        </div>

       <!-- Tambahan gambar alur SIMAKSI -->
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <!-- Klik gambar buka modal -->
                <img src="AlurSimaksi.png" alt="Alur SIMAKSI" 
                     class="img-fluid rounded shadow-sm" 
                     style="max-width: 50%; height: auto; margin-top: 20px; cursor:pointer;" 
                     data-bs-toggle="modal" data-bs-target="#gambarModal">
            </div>
        </div>
    </div>
</div>

<!-- Modal Bootstrap untuk memperbesar gambar -->
<div class="modal fade" id="gambarModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center">
        <img src="AlurSimaksi.png" class="img-fluid rounded shadow" alt="Alur SIMAKSI" style="max-width: 80%; height:auto;">
      </div>
    </div>
  </div>
</div>  

            <div class="container py-5">
                <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                    <h5 class="text-uppercase text-primary">Layanan Perizinan</h5>
                    <h1 class="mb-4">Surat Izin SIMAKSI</h1>
                    <p class="mb-0">
                        Ajukan permohonan izin kegiatan di kawasan konservasi melalui sistem SIMAKSI untuk berbagai keperluan seperti penelitian, pendidikan, religi, dan kegiatan lainnya.
                    </p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="service-card bg-white rounded p-5 h-100 shadow-lg">
                            <div class="service-icon">
                                <i class="fas fa-file-alt fa-2x text-white"></i>
                            </div>
                            <h4 class="mb-3 text-center">Surat Izin SIMAKSI</h4>
                            <p class="text-center mb-4">
                                Perizinan untuk berbagai kegiatan di kawasan konservasi meliputi penelitian, pendidikan, religi, dan aktivitas lainnya yang memerlukan akses ke kawasan konservasi.
                            </p>

                            <div class="text-center">
                                <a href="daftar-simaksi.php" class="btn btn-primary px-5 py-3">Ajukan Izin Sekarang</a>
                            </div>
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
                        <p class="mb-4">Sebagai Unit Pelaksana Teknis ( UPT ) Kementrian Lingkungan Hidup Dan Kehutanan yang bertugas untuk mengelola 33 kawasan konservasi berbentuk cagar alam, suaka margasatwa dan taman wisata di Jawa Tengah.</p>
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
                <a href="https://www.facebook.com/bksdajawatengah/" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://x.com/bksdajawatengah" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/bksda_jateng/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/balai-konservasi-sumber-daya-alam-bksda-jawa-tengah/" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="text-center text-white">
                <span>© BKSDA JAWA TENGAH. All rights reserved.</span>
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
    </script>
</body>
</html>