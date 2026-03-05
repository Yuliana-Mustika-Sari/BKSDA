<?php
session_start();

$is_admin = isset($_SESSION['loggedin']) && $_SESSION['role'] === 'admin';
$is_loggedin = isset($_SESSION['loggedin']);
$is_guest = !isset($_SESSION['loggedin']);

$db_path = __DIR__ . '/../db-connect-admin.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Erorr: File koneksi database tidak ditemukan. Pastikan 'db-connect-admin.php' ada di folder yang benar.");
}

$status_message = '';
$status_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $subjek = trim($_POST['subjek']);
    $pesan = trim($_POST['pesan']);

    if (empty($nama) || empty($email) || empty($subjek) || empty($pesan)) {
        $status_message = "Semua bidang bertanda bintang (*) harus diisi.";
        $status_type = 'danger';
    } else {
        $stmt = $conn->prepare("INSERT INTO aduan (nama, email, telepon, subjek, pesan, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $nama, $email, $telepon, $subjek, $pesan);

        if ($stmt->execute()) {
            $status_message = "Pesan Anda berhasil dikirim! Terima kasih telah menghubungi kami.";
            $status_type = 'success';
        } else {
            $status_message = "Gagal mengirim pesan. Silakan coba lagi nanti.";
            $status_type = 'danger';
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam - Kontak</title>
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
    <style>
        .nav-link.text-primary { color: #007bff !important; }
        .nav-link.text-primary:hover {
            color: #0056b3 !important;
            background-color: rgba(0, 123, 255, 0.1);
            border-radius: 5px;
        }
        .nav-link.text-danger { color: #dc3545 !important; }
        .nav-link.text-danger:hover {
            color: #c82333 !important;
            background-color: rgba(220, 53, 69, 0.1);
            border-radius: 5px;
        }
    </style>
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
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Data & Informasi</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="kawasan_hutan.php" class="dropdown-item">Kawasan Konservasi</a>
                                <a href="perlindungan.php" class="dropdown-item">Perlindungan</a>
                                <a href="pemberdayaan-masyarakat.php" class="dropdown-item">Pemberdayaan Masyarakat</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link active">Contact</a>
                        
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
                <h1 class="text-white display-2 mb-4 animated-text fw-bold">Hubungi Kami</h1>
                <p class="fs-4 text-white mb-4 animated-text">Balai Konservasi Sumber Daya Alam Jawa Tengah</p>
                <p class="fs-6 text-white-50 animated-text">Kami siap membantu dan berkolaborasi dalam upaya konservasi</p>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-5">
            <div class="col-xl-5 animate__animated animate__fadeInLeft">
    <div class="interactive-card h-100 p-5">
        <h2 class="mb-4 text-primary fw-bold">Kirim Pesan kepada Kami</h2>
        <p class="mb-4 text-muted">Untuk informasi lebih lanjut, pertanyaan, atau laporan terkait konservasi sumber daya alam, silakan hubungi kami melalui formulir di bawah ini.</p>
        
        <?php if (!empty($status_message)): ?>
            <div class="alert alert-<?php echo $status_type; ?>" role="alert">
                <?php echo $status_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="contact.php">
            <div class="row gx-4 gy-3">
                <div class="col-xl-6">
                    <input type="text" class="form-control bg-light border-0 py-3 px-4" name="nama" placeholder="Nama Anda *" required>
                </div>
                <div class="col-xl-6">
                    <input type="email" class="form-control bg-light border-0 py-3 px-4" name="email" placeholder="Email Anda *" required>
                </div>
                <div class="col-xl-6">
                    <input type="text" class="form-control bg-light border-0 py-3 px-4" name="telepon" placeholder="Nomor Telepon">
                </div>
                <div class="col-xl-6">
                    <input type="text" class="form-control bg-light border-0 py-3 px-4" name="subjek" placeholder="Subjek *" required>
                </div>
                <div class="col-12">
                    <textarea class="form-control bg-light border-0 py-3 px-4" rows="5" name="pesan" placeholder="Pesan Anda *" required></textarea>
                </div>
                <div class="col-12">
                    <button class="btn-hover-bg btn btn-primary w-100 py-3 px-5" type="submit">Kirim Pesan</button>
                </div>
            </div>
        </form>
    </div>
</div>
                <div class="col-xl-7 animate__animated animate__fadeInRight">
                    <div class="h-100">
                        <h2 class="mb-4 text-primary fw-bold">Informasi Kontak</h2>
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="interactive-card p-4 d-flex align-items-start hover-effect">
                                    <div class="circle-icon me-3 flex-shrink-0"><i class="fas fa-map-marker-alt text-white"></i></div>
                                    <div>
                                        <h4 class="text-primary">Alamat Kantor</h4>
                                        <p class="mb-0 text-muted">Jl. Dr. Suratmo No. 171, Manyaran, Semarang, Jawa Tengah</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
    <div class="interactive-card p-4 text-center hover-effect">
        <div class="circle-icon mx-auto mb-3"><i class="fas fa-envelope text-white"></i></div>
        <h4 class="text-primary">Email Kami</h4>
        <p class="mb-0 text-muted">
            <a href="mailto:bksda_jateng@yahoo.co.id" class="text-muted">bksda_jateng@yahoo.co.id</a>
        </p>
    </div>
</div>
<div class="col-lg-6">
    <div class="interactive-card p-4 text-center hover-effect">
        <div class="circle-icon mx-auto mb-3"><i class="fa fa-phone-alt text-white"></i></div>
        <h4 class="text-primary">Hubungi Kami</h4>
        <p class="mb-0 text-muted">
            <a href="tel:+62247614752" class="text-muted">(024) 7614752</a>
        </p>
    </div>
</div>
                            <div class="col-lg-12">
                                <div class="interactive-card p-4">
                                    <h4 class="text-primary mb-3">Lokasi Kami</h4>
                                    <iframe class="w-100 rounded" style="height: 385px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.038104523789!2d110.37077647530513!3d-6.993437168532454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b7d4d7c040d%3A0x7d287d32c51b7593!2sBalai%20Konservasi%20Sumber%20Daya%20Alam%20(BKSDA)%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1723467652758!5m2!1sid!2sid" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid faq py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 animate__animated animate__fadeInUp" style="max-width: 800px;">
                <h5 class="text-uppercase text-primary fw-bold">Pertanyaan</h5>
                <h1 class="mb-4 fw-bold">Pertanyaan yang Sering Diajukan</h1>
                <p class="mb-0 text-muted">
                    Berikut adalah beberapa pertanyaan umum seputar layanan, program, dan kegiatan kami.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6 animate__animated animate__fadeInLeft" style="animation-delay: 0.2s;">
                    <div class="accordion" id="accordionFAQ1">
                        <div class="accordion-item hover-effect interactive-card">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="fas fa-question-circle text-primary me-3"></i>Bagaimana cara melapor jika menemukan satwa liar yang terancam?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFAQ1">
                                <div class="accordion-body">
                                    Anda dapat menghubungi kami melalui nomor telepon atau email yang tertera di halaman ini. Berikan detail lengkap mengenai lokasi, jenis satwa, dan kondisi terkini untuk memudahkan tim kami bertindak cepat.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item hover-effect interactive-card">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fas fa-question-circle text-primary me-3"></i>Apakah BKSDA menyediakan layanan edukasi dan kunjungan?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFAQ1">
                                <div class="accordion-body">
                                    Ya, kami sering mengadakan program edukasi dan menerima kunjungan dari sekolah atau komunitas. Silakan hubungi kami untuk informasi jadwal dan pendaftaran.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item hover-effect interactive-card">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fas fa-question-circle text-primary me-3"></i>Bagaimana cara menjadi relawan di BKSDA Jawa Tengah?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFAQ1">
                                <div class="accordion-body">
                                    Anda dapat mengirimkan permohonan melalui email kami dengan menyertakan biodata singkat dan motivasi Anda. Tim kami akan menghubungi Anda untuk proses selanjutnya.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">
                    <div class="accordion" id="accordionFAQ2">
                        <div class="accordion-item hover-effect interactive-card">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="fas fa-question-circle text-primary me-3"></i>Apa saja kawasan konservasi yang dikelola BKSDA Jawa Tengah?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFAQ2">
                                <div class="accordion-body">
                                    Kami mengelola 30 Cagar Alam, 4 Taman Wisata Alam, dan satu Suaka Margasatwa. Informasi lengkap bisa Anda temukan di halaman `Kawasan Hutan`.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item hover-effect interactive-card">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <i class="fas fa-question-circle text-primary me-3"></i>Apakah ada biaya untuk mengunjungi kawasan konservasi?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionFAQ2">
                                <div class="accordion-body">
                                    Beberapa kawasan konservasi memiliki kebijakan biaya masuk atau perizinan. Anda dapat melihat detailnya di halaman `SIMAKSI` dan `Perizinan`.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item hover-effect interactive-card">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <i class="fas fa-question-circle text-primary me-3"></i>Bagaimana cara mendapatkan izin penelitian di kawasan konservasi?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionFAQ2">
                                <div class="accordion-body">
                                    Prosedur perizinan penelitian dapat diajukan melalui kantor kami atau halaman `Perizinan` di website ini. Pastikan Anda melengkapi semua dokumen yang diperlukan.
                                </div>
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
                        <a href="../index.php" class="hover-effect"><i class="fas fa-angle-right me-2"></i> Beranda</a>
                        <a href="sejarah.php" class="hover-effect"><i class="fas fa-angle-right me-2"></i> Sejarah Organisasi</a>
                        <a href="visimisi.php" class="hover-effect"><i class="fas fa-angle-right me-2"></i> Visi & Misi</a>
                        <a href="fungsi.php" class="hover-effect"><i class="fas fa-angle-right me-2"></i> Tugas Pokok & Fungsi</a>
                        <a href="perlindungan.php" class="hover-effect"><i class="fas fa-angle-right me-2"></i> Program Konservasi</a>
                        <a href="contact.php" class="hover-effect text-success"><i class="fas fa-angle-right me-2"></i> Hubungi Kami</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                        <h4 class="mb-4 text-white">Hubungi Kami</h4>
                        <div class="contact-info">
                            <p class="mb-3 hover-effect"><i class="fa fa-map-marker-alt me-3 text-success"></i>Jl. Dr. Suratmo No. 171 Semarang</p>
                            <p class="mb-3 hover-effect"><i class="fa fa-phone-alt me-3 text-primary"></i>(024)7614752</p>
                            <p class="mb-3 hover-effect"><i class="fa fa-envelope me-3 text-info"></i>bksda_jateng@yahoo.co.id</p>
                            <div class="social-links mt-4">
                            </div>
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
            $('.accordion-item').each(function(index) {
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