<?php

session_start();

// Cek status login untuk menentukan tampilan menu
$is_admin = isset($_SESSION['loggedin']) && $_SESSION['role'] === 'users';
$is_loggedin = isset($_SESSION['loggedin']);
$is_guest = !isset($_SESSION['loggedin']);

// Koneksi ke database untuk mengambil konten dinamis
$db_path = __DIR__ . '/db-connect-admin.php';
if (file_exists($db_path)) {
    include $db_path;

    // Contoh: Ambil konten untuk halaman "About" dari database
    $sql_about = "SELECT title, content FROM web_content WHERE page_slug = 'index' AND section_id = 'about-section'";
    $sql_profile = "SELECT profile FROM web_content WHERE page_slug = 'index' AND section_id = 'about-section'";
    $result_about = $conn->query($sql_about);
    $result_profile = $conn->query($sql_profile);
    $about_content = $result_about->fetch_assoc();
    $about_profile = $result_profile->fetch_assoc();

    $conn->close();
} else {
    $about_content = ['title' => 'Judul Konten Tidak Ditemukan', 'content' => 'Konten tidak dapat dimuat. Silakan cek koneksi database.'];
    $about_profile = ['profile' => 'Profile tidak dapat dimuat. Silakan cek koneksi database.'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam</title>
    <link rel="icon" type="image/png" href="img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
    /* Gaya untuk card galeri di tengah */
.gallery-item-center .gallery-item {
    height: 690px;
    position: relative;
}
.gallery-item-center .gallery-item img {
    height: 100%;
    object-fit: cover;
}

/* Style untuk logout dan login button */
.nav-link.text-danger {
    color: #dc3545 !important;
}

.nav-link.text-primary {
    color: #007bff !important;
}

.nav-link.text-danger:hover {
    color: #c82333 !important;
    background-color: rgba(220, 53, 69, 0.1);
    border-radius: 5px;
}

.nav-link.text-primary:hover {
    color: #0056b3 !important;
    background-color: rgba(0, 123, 255, 0.1);
    border-radius: 5px;
}
    /* === OWL CAROUSEL GALLERY STYLES === */
    .gallery-carousel .owl-item {
        transition: all 0.3s ease-in-out;
    }
    .gallery-carousel .owl-item.center .gallery-item {
        transform: scale(1.1);
        z-index: 10;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .gallery-carousel .owl-item.center .gallery-content {
        background-color: rgba(26, 99, 58, 0.9) !important;
    }
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin: 10px;
    }
    .gallery-img {
        position: relative;
    }
    .gallery-img img {
        height: 400px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .gallery-item:hover .gallery-img img {
        transform: scale(1.05);
    }
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-overlay i {
        font-size: 2.5rem;
    }
    .gallery-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 15px;
        background-color: rgba(0, 0, 0, 0.7);
        text-align: center;
        transition: background-color 0.3s ease;
        border-radius: 0 0 10px 10px;
    }
    .gallery-content a {
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Kustomisasi Tombol Navigasi Owl Carousel */
    .gallery-carousel .owl-nav button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background-color: rgba(255, 255, 255, 0.8) !important;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .gallery-carousel .owl-nav button:hover {
        background-color: #1a633a !important;
        color: #fff !important;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
    .gallery-carousel .owl-nav .owl-prev {
        left: -20px; /* Posisikan lebih ke kiri */
    }
    .gallery-carousel .owl-nav .owl-next {
        right: -20px; /* Posisikan lebih ke kanan */
    }
    .gallery-carousel .owl-nav button span {
        font-size: 2rem;
        line-height: 1;
    }
</style>

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
                <a href="index.php" class="navbar-brand ms-3 d-flex align-items-center">
                    <img src="img/logo2.png" alt="Logo BKSDA Jawa Tengah" style="width: 60px; height: auto;" class="me-2">
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
                        <a href="index.php" class="nav-item nav-link active">Beranda</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profile</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="User/sejarah.php" class="dropdown-item">Sejarah Organisasi</a>
                                <a href="User/visimisi.php" class="dropdown-item">Visi & Misi</a>
                                <a href="User/fungsi.php" class="dropdown-item">Tugas Pokok & Fungsi</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="User/simaksi.php" class="dropdown-item">SIMAKSI</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Data & Informasi</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="user/kawasan_hutan.php" class="dropdown-item">Kawasan Konservasi</a>
                                <a href="user/perlindungan.php" class="dropdown-item">Perlindungan</a>
                                <a href="user/pemberdayaan-masyarakat.php" class="dropdown-item">Pemberdayaan Masyarakat</a>
                                <a href="user/peraturan.php" class="dropdown-item">Peraturan</a>
                            </div>
                        </div>
                        <a href="User/contact.php" class="nav-item nav-link">Contact</a>
                        
                        <?php if ($is_loggedin): ?>
                            <a href="logout.php" class="nav-item nav-link text-danger fw-bold" onclick="return confirm('Apakah Anda yakin ingin logout dan kembali ke landing page?')">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                        <?php else: ?>
                            <a href="landing.php" class="nav-item nav-link text-primary fw-bold">
                                <i class="fas fa-sign-in-alt me-1"></i>logout
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="container-fluid carousel-header vh-100 px-0">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="img/gunung.jpg" class="img-fluid" alt="Image">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Balai Konservasi Sumber Daya Alam Jawa Tengah</h4>
                            <h1 class="display-1 text-capitalize text-white mb-4">Lestarikan Alam, Lindungi Satwa Liar</h1>
                            <p class="mb-5 fs-5">Lestarikan alam, jaga ekosistem, dan lindungi satwa liar di kawasan konservasi.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/home-1.jpg" class="img-fluid" alt="Image">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Balai Konservasi Sumber Daya Alam Jawa Tengah</h4>
                            <h1 class="display-1 text-capitalize text-white mb-4">Lestarikan Alam, Lindungi Satwa Liar</h1>
                            <p class="mb-5 fs-5">Berpartisipasi dalam setiap upaya konservasi untuk masa depan yang lebih baik bagi alam.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/carousel-3.jpg" class="img-fluid" alt="Image">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Balai Konservasi Sumber Daya Alam Jawa Tengah</h4>
                            <h1 class="display-1 text-capitalize text-white mb-4">Lestarikan Alam, Lindungi Satwa Liar</h1>
                            <p class="mb-5 fs-5">Bersama-sama, kita ciptakan keseimbangan antara alam dan kehidupan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-xl-5">
                <div class="h-100 d-flex justify-content-center align-items-center">
                    <img src="img/logo2.png" class="img-fluid rounded-circle p-2 bg-light shadow-sm" alt="Image" style="width: 300px; height: 300px; object-fit: cover;">
                </div>
            </div>
            <div class="col-xl-7">
                <h5 class="text-uppercase text-success fw-bold">Balai Konservasi Sumber Daya Alam</h5>
                <h5 class="text-uppercase text-success fw-bold">Jawa Tengah</h5>
                <h1 class="mb-4 fw-bold"><?php echo htmlspecialchars($about_content['title']); ?></h1>
                <p class="fs-5 text-muted">
                    <?php echo nl2br(htmlspecialchars($about_content['content'])); ?>
                </p>

                <div class="bg-light shadow-sm rounded p-4">
                    <h5 class="text-uppercase mb-3">Profil Singkat</h5>
                    <p>
                        <?php echo nl2br(htmlspecialchars($about_profile['profile'])); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h5 class="text-uppercase text-primary">Layanan & Program Kami</h5>
                <h1 class="mb-4">Kegiatan Konservasi Sumber Daya Alam</h1>
                <p class="mb-0">
                    Sebagai upaya menjaga keseimbangan ekosistem, kami menyelenggarakan berbagai layanan dan program unggulan yang berfokus pada perlindungan, pengawetan, dan pemanfaatan sumber daya alam hayati.
                </p>
            </div>
            <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
                    <div class="service-item bg-light rounded p-4">
                        <div class="service-content d-flex align-items-center justify-content-center mx-auto p-4">
                            <div class="service-content-inner text-center">
                                <i class="fa fa-leaf fa-4x text-primary mb-4"></i>
                                <h4 class="mb-3">SIMAKSI</h4>
                                <p class="mb-4">Akses Kawasan Konservasi. Memudahkan masyarakat yang ingin beraktivitas di kawasan konservasi.</p>
                                <a href="User/simaksi.php" class="btn btn-primary text-white py-2 px-4">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-item bg-light rounded p-4">
                        <div class="service-content d-flex align-items-center justify-content-center mx-auto p-4">
                            <div class="service-content-inner text-center">
                                <i class="fa fa-leaf fa-4x text-primary mb-4"></i>
                                <h4 class="mb-3">Perlindungan Satwa</h4>
                                <p class="mb-4">Menyelamatkan, merawat, dan melepasliarkan satwa liar yang terluka atau terancam ke habitat aslinya.</p>
                                <a href="User/perlindungan.php" class="btn btn-primary text-white py-2 px-4">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-item bg-light rounded p-4">
                        <div class="service-content d-flex align-items-center justify-content-center mx-auto p-4">
                            <div class="service-content-inner text-center">
                                <i class="fa fa-mountain fa-4x text-primary mb-4"></i>
                                <h4 class="mb-3">Kawasan Konservasi</h4>
                                <p class="mb-4">Mengelola kawasan hutan, cagar alam, suaka margasatwa, dan taman wisata untuk tujuan pelestarian.</p>
                                <a href="User/kawasan_hutan.php" class="btn btn-primary text-white py-2 px-4">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid counter py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(img/gunung.jpg) no-repeat center center; background-size: cover;">
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

    <div class="container-fluid service py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h1 class="text-uppercase text-primary">Breaking News</h1>
            </div>

            <div class="breaking-news-scroll-container" id="autoScrollContainer">
                <div class="news-card">
                    <div class="service-item">
                        <a href="https://www.msn.com/id-id/berita/other/situs-bumiayu-jejak-pantai-purba-yang-tersimpan-di-pedalaman-jawa-tengah/ar-AA1JNVF8?ocid=socialshare">
                            <img src="img/bumi.jpg" class="img-fluid w-100" alt="Image">
                        </a>
                        <div class="service-link">
                            <a href="https://www.msn.com/id-id/berita/other/situs-bumiayu-jejak-pantai-purba-yang-tersimpan-di-pedalaman-jawa-tengah/ar-AA1JNVF8?ocid=socialshare">Situs Bumiayu di Jawa Tengah</a>
                        </div>
                    </div>
                    <p class="mt-3">Jejak pantai purba yang tersimpan di pedalaman Jawa Tengah menjadi perhatian arkeologis dan pecinta lingkungan.</p>
                </div>
                <div class="news-card">
                    <div class="service-item">
                        <a href="https://regional.kompas.com/read/2024/05/08/215039278/terluka-akibat-terperangkap-di-pohon-seekor-monyet-di-salatiga-diserahkan">
                            <img src="img/monyet.jpg" class="img-fluid w-100" alt="Monyet Salatiga">
                        </a>
                        <div class="service-link">
                            <a href="https://regional.kompas.com/read/2024/05/08/215039278/terluka-akibat-terperangkap-di-pohon-seekor-monyet-di-salatiga-diserahkan">Evakuasi Monyet di Salatiga</a>
                        </div>
                    </div>
                    <p class="mt-3">Seekor monyet yang terperangkap di pohon dievakuasi petugas Damkar Kota Salatiga. Setelah berhasil dievakuasi, monyet tersebut diserahkan ke Balai Konservasi Sumber Daya Alam (BKSDA) Jawa Tengah.</p>
                </div>
                <div class="news-card">
                    <div class="service-item">
                        <a href="https://regional.kompas.com/read/2013/05/10/05212010/BKSDA.Jateng.Tangkap.Pemasok.Satwa.Liar">
                            <img src="img/satwa.jpeg" class="img-fluid w-100" alt="Satwa Liar">
                        </a>
                        <div class="service-link">
                            <a href="https://regional.kompas.com/read/2013/05/10/05212010/BKSDA.Jateng.Tangkap.Pemasok.Satwa.Liar">Penangkapan Pemasok Satwa Liar</a>
                        </div>
                    </div>
                    <p class="mt-3">BKSDA Jateng berhasil menangkap pemasok satwa liar di kawasan Jawa Tengah dalam operasi bersama pihak berwajib.</p>
                </div>
                <div class="news-card">
                    <div class="service-item">
                        <a href="https://www.detik.com/jateng/berita/d-6579514/sempat-sakit-gigi-sekar-si-gajah-betina-semarang-zoo-mati">
                            <img src="img/gajah.jpeg" class="img-fluid w-100" alt="Gajah Sekar Mati">
                        </a>
                        <div class="service-link">
                            <a href="https://www.detik.com/jateng/berita/d-6579514/sempat-sakit-gigi-sekar-si-gajah-betina-semarang-zoo-mati">Gajah Sekar di Semarang Zoo Mati</a>
                        </div>
                    </div>
                    <p class="mt-3">Gajah betina koleksi Semarang Zoo bernama Sekar mati setelah sempat sakit gigi. Hal ini menjadi duka bagi pecinta satwa.</p>
                </div>
                <div class="news-card">
                    <div class="service-item">
                        <a href="https://news.detik.com/berita-jawa-tengah/d-4355358/macan-tutul-lereng-lawu-yang-tertangkap-diduga-induk">
                            <img src="img/macan.jpeg" class="img-fluid w-100" alt="Macan Tutul Lawu">
                        </a>
                        <div class="service-link">
                            <a href="https://news.detik.com/berita-jawa-tengah/d-4355358/macan-tutul-lereng-lawu-yang-tertangkap-diduga-induk">Macan Tutul Lereng Lawu Tertangkap</a>
                        </div>
                    </div>
                    <p class="mt-3">Seekor macan tutul yang terperangkap di lereng Gunung Lawu telah ditangkap dan diduga merupakan induk.</p>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="container-fluid gallery py-5 px-3">
        <div class="text-center mx-auto pb-5" style="max-width: 900px;">
            <h5 class="text-uppercase text-primary">Galeri Kegiatan</h5>
            <h1 class="mb-4">Dokumentasi Berbagai Kegiatan Kami</h1>
            <p class="mb-0">
                Jelajahi momen-momen penting dalam upaya kami melestarikan alam dan keanekaragaman hayati di Jawa Tengah.
            </p>
        </div>
        <div class="owl-carousel gallery-carousel">
            <div class="gallery-item">
                <div class="gallery-img">
                    <img src="img/zoo.jpg" class="img-fluid rounded" alt="Taman Wisata">
                    <div class="gallery-overlay">
                        <a href="img/zoo.jpg" data-lightbox="gallery" class="my-auto">
                            <i class="fas fa-search-plus text-white"></i>
                        </a>
                    </div>
                </div>
                <div class="gallery-content">
                    <a href="#" class="h5 text-white mb-0">Taman Wisata Alam</a>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-img">
                    <img src="img/simaksi.png" class="img-fluid rounded" alt="Alur Pendaftaran Simaksi">
                    <div class="gallery-overlay">
                        <a href="img/simaksi.png" data-lightbox="gallery" class="my-auto">
                            <i class="fas fa-search-plus text-white"></i>
                        </a>
                    </div>
                </div>
                <div class="gallery-content">
                    <a href="user/simaksi.php" class="h5 text-white mb-0">Alur Pendaftaran Simaksi</a>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-img">
                    <img src="img/bksda.jpg" class="img-fluid rounded" alt="Gedung BKSDA">
                    <div class="gallery-overlay">
                        <a href="img/bksda.jpg" data-lightbox="gallery" class="my-auto">
                            <i class="fas fa-search-plus text-white"></i>
                        </a>
                    </div>
                </div>
                <div class="gallery-content">
                    <a href="user/contact.php" class="h5 text-white mb-0">Hubungi Kami</a>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-img">
                    <img src="img/gunung.jpg" class="img-fluid rounded" alt="Kawasan Konservasi">
                    <div class="gallery-overlay">
                        <a href="img/gunung.jpg" data-lightbox="gallery" class="my-auto">
                            <i class="fas fa-search-plus text-white"></i>
                        </a>
                    </div>
                </div>
                <div class="gallery-content">
                    <a href="user/kawasan_hutan.php" class="h5 text-white mb-0">Kawasan Hutan</a>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-img">
                    <img src="img/home-1.jpg" class="img-fluid rounded" alt="Flora dan Fauna">
                    <div class="gallery-overlay">
                        <a href="img/home-1.jpg" data-lightbox="gallery" class="my-auto">
                            <i class="fas fa-search-plus text-white"></i>
                        </a>
                    </div>
                </div>
                <div class="gallery-content">
                    <a href="user/perlindungan.php" class="h5 text-white mb-0">Perlindungan Satwa</a>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="user/galeri.php" class="btn btn-primary px-4 py-2">
                Lapor Konflik <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>


    <div class="container-fluid footer-bksda text-body py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                        <img src="img/logo2.png" alt="Logo BKSDA Jawa Tengah" class="img-fluid mb-4 footer-logo">
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
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function() {
            $(".gallery-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                center: true,
                loop: true,
                margin: 25,
                nav: true,
                dots: false,
                navText: [
                    '<i class="bi bi-arrow-left"></i>',
                    '<i class="bi bi-arrow-right"></i>'
                ],
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    992: { items: 3 }
                }
            });
        });
    </script>
</body>
</html>