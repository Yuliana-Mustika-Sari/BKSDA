<?php
session_start();
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
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
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
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
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
                                <a href="simaksi.php" class="dropdown-item active">SIMAKSI</a>
                                <a href="perizinan.html" class="dropdown-item">Perizinan</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Data & Informasi</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="kawasan_hutan.php" class="dropdown-item">Kawasan Hutan</a>
                                <a href="perlindungan.php" class="dropdown-item">Perlindungan</a>
                                <a href="laporan.html" class="dropdown-item">Laporan</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap pt-xl-0" style="margin-left: 15px;">
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="container-fluid header-bg">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4">SIMAKSI</h3>
            <p class="fs-5 text-white mb-4">Balai Konservasi Sumber Daya Alam Jawa Tengah</p>
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
            <div class="container simaksi-process py-5">
                <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                    <h5 class="text-uppercase text-primary">Proses Mudah</h5>
                    <h1 class="mb-4">Alur Pengajuan Perizinan SIMAKSI</h1>
                    <p class="mb-0">
                        Ikuti langkah-langkah mudah di bawah ini untuk mengajukan permohonan SIMAKSI.
                    </p>
                </div>
                <div class="row g-4 justify-content-center text-center">
                    <div class="col-lg-3 d-flex flex-column align-items-center">
                        <div class="step-icon">
                            <i class="fas fa-user-edit fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">1. Pendaftaran Akun</h4>
                        <p class="mb-0">Daftarkan akun Anda di portal resmi SIMAKSI dan lengkapi data diri.</p>
                    </div>
                    <div class="col-lg-3 d-flex flex-column align-items-center">
                        <div class="step-icon">
                            <i class="fas fa-file-alt fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">2. Isi Formulir</h4>
                        <p class="mb-0">Pilih jenis perizinan dan isi formulir permohonan dengan detail kegiatan Anda.</p>
                    </div>
                    <div class="col-lg-3 d-flex flex-column align-items-center">
                        <div class="step-icon">
                            <i class="fas fa-upload fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">3. Unggah Dokumen</h4>
                        <p class="mb-0">Unggah semua dokumen persyaratan yang diperlukan sesuai jenis permohonan.</p>
                    </div>
                    <div class="col-lg-3 d-flex flex-column align-items-center">
                        <div class="step-icon" style="background-color: var(--bs-primary);">
                            <i class="fas fa-check-circle fa-3x text-white"></i>
                        </div>
                        <h4 class="mb-3">4. Verifikasi & Terbit</h4>
                        <p class="mb-0">Tunggu proses verifikasi. Jika disetujui, izin akan diterbitkan dan siap digunakan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid text-center bg-primary py-5">
        <div class="container py-3">
            <h2 class="text-white mb-4">Ajukan Perizinan SIMAKSI Sekarang!</h2>
            <p class="text-white mb-4">Dapatkan izin resmi untuk kegiatan Anda di kawasan konservasi dengan mudah melalui portal kami.</p>
            <a href="daftar-simaksi.php" class="btn btn-light text-primary py-3 px-5">Daftar SIMAKSI</a>
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
                        <a href="../index.php"><i class="fas fa-angle-right me-2"></i> Beranda</a>
                        <a href="sejarah.php"><i class="fas fa-angle-right me-2"></i> Tentang Kami</a>
                        <a href="../berita-lainnya.html"><i class="fas fa-angle-right me-2"></i> Berita & Artikel</a>
                        <a href="perlindungan.php"><i class="fas fa-angle-right me-2"></i> Kegiatan Konservasi</a>
                        <a href="gallery.html"><i class="fas fa-angle-right me-2"></i> Galeri</a>
                        <a href="contact.php"><i class="fas fa-angle-right me-2"></i> Kontak</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                        <h4 class="mb-4 text-white">Hubungi Kami</h4>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-2"></i>Jl. Dr. Suratmo No. 171 Semarang</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-2"></i>(024)7614752</p>
                        <p class="mb-2"><i class="fa fa-envelope me-2"></i>bksda_jateng@yahoo.co.id</p>
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
    <a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top"><i class="fa fa-arrow-up"></i></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>