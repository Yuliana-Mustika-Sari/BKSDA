<?php
session_start();
// Menggunakan koneksi ke database admin untuk konten dinamis
$db_path = __DIR__ . '/../db-connect-admin.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Error: File koneksi database tidak ditemukan.");
}

$sql_kawasan = "SELECT title, content FROM web_content WHERE page_slug = 'kawasan_hutan' AND section_id = 'intro'";
$result_kawasan = $conn->query($sql_kawasan);
$kawasan = $result_kawasan->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Balai Konservasi Sumber Daya Alam - Kawasan Hutan</title>
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
                                    <a href="perizinan.php" class="dropdown-item">Perizinan</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Data & Informasi</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="kawasan_hutan.php" class="dropdown-item active">Kawasan Hutan</a>
                                    <a href="perlindungan.php" class="dropdown-item">Perlindungan</a>
                                    <a href="laporan.php" class="dropdown-item">Laporan</a>
                                </div>
                            </div>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="container-fluid header-bg">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h3 class="text-white display-3 mb-4">Kawasan Hutan</h3>
                <p class="fs-5 text-white mb-4">Balai Konservasi Sumber Daya Alam Jawa Tengah</p>
            </div>
        </div>
        <div class="container-fluid blog py-5" style="font-family: 'Poppins', sans-serif;">
            <div class="container py-5">
                <div class="text-center pb-5" style="max-width: 800px; margin: 0 auto;">
                    <h2 class="judul-bayangan fw-bold" data-title="KAWASAN HUTAN">Kawasan Hutan</h2>
                </div>
         <?php
// file: kawasan.php
?>

<section id="grid-kawasan" class="row g-4">

<!-- Stasiun Flora Fauna Bunder -->
<div class="col-md-6 col-lg-4">
    <div class="card">
        <img src="img/stasiun bunder.jpg" class="card-img-top" alt="Stasiun Flora Fauna Bunder">
        <div class="card-body">
            <a href="https://kabarhandayani.com/stasiun-flora-dan-fauna-bunder-ruang-pembelajaran-pengelolaan-dan-pelestarian-alam/" 
               class="link-kawasan" target="_blank" rel="noopener noreferrer">
                <h5 class="card-title">Stasiun Flora Fauna Bunder</h5>
                <p class="card-text">Stasiun Flora dan Fauna Bunder</p>
            </a>
        </div>
    </div>
</div>

    <!-- Lembaga Konservasi -->
    <div class="col-md-6 col-lg-4">
    <div class="card">
        <img src="/assets/images/gembira-loka.jpg" class="card-img-top" alt="Taman Nasional Karimun Jawa">
        <div class="card-body">
            <h5 class="card-title">Lembaga Konservasi</h5>
            <ul>
                <li>
                    <a href="https://tnkarimunjawa.id/" 
                     class="link-kawasan" target="_blank" rel="noopener noreferrer">
                     Taman Nasional Karimun Jawa
                    </a>
                </li>
                <li>
                    <a href="https://wisatategal.com/wisata-1408195-kawasan_konservasi_karang_jeruk.html" 
                     class="link-kawasan" target="_blank" rel="noopener noreferrer">
                     Kawasan Konservasi Karang Jeruk
                    </a>
                </li>
                <li>
                    <a href="https://regional.kompas.com/read/2023/02/02/175231678/pantai-karang-jahe-di-rembang-daya-tarik-aktivitas-dan-rute?page=all" 
                     class="link-kawasan" target="_blank" rel="noopener noreferrer">
                     Perairan Karang Jahe
                    </a>
                </li>
                <li>
                    <a href="https://visitjawatengah.jatengprov.go.id/id/regency/kabupaten-jepara/destinasi-wisata/pulau-panjang" 
                     class="link-kawasan" target="_blank" rel="noopener noreferrer">
                     Pulau Panjang
                    </a>
                </li>
                <li>
                    <a href="https://p2k.stekom.ac.id/ensiklopedia/Cagar_Alam_Bantarbolang" 
                     class="link-kawasan" target="_blank" rel="noopener noreferrer">
                     Cagar Alam Donoloyo
                    </a>
                </li>
                <li>
                    <a href="https://www.detik.com/jateng/budaya/d-6066338/asal-usul-donoloyo-hutan-peninggalan-senapati-majapahit-di-wonogiri" 
                     class="link-kawasan" target="_blank" rel="noopener noreferrer">
                     Cagar Alam Donoloyo
                    </a>
                </li>
                <li>
                    <a href="https://alamendah.org/tag/cagar-alam-gebugan/" 
                       class="link-kawasan" target="_blank" rel="noopener noreferrer">
                        Cagar Alam Gebugan
                    </a>
                </li>
                <li>
                    <a href="https://katadata.co.id/lifestyle/varia/6458a85466723/profil-wisata-guci-tegal-dari-fasilitas-hingga-daya-tariknya" 
                         class="link-kawasan" target="_blank" rel="noopener noreferrer">
                         Taman Wisata Alam Guci
                    </a>
                </li>
                <li>
                    <a href="https://www.detik.com/jateng/wisata/d-7093400/grojogan-sewu-karanganyar-lokasi-rute-harga-tiket-dan-daya-tariknya" 
                         class="link-kawasan" target="_blank" rel="noopener noreferrer">
                         Taman Wisata Alam Grojogan Sewu
                    </a>
                </li>
                <li>
                    <a href="https://www.kabaralam.com/wisata-alam/59312431502/ini-daya-tarik-unik-twa-telogo-warno-telogo-pengilon-di-dataran-tinggi-dieng-wonosobo" 
                         class="link-kawasan" target="_blank" rel="noopener noreferrer">
                         Taman Wisata Alam Telogo Warna & Pengilon
                    </a>
                </li>
                <li>
                    <a href="https://www.kliklabuanbajo.id/ragam/pr-5425800083/mengenal-suaka-margasatwa-gunung-tunggangan"
                    class="link-kawasan" target="_blank" rel="noopener noreferrer">
                     Suaka Margasatwa Gunung Tunggangan
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

    <!-- Kawasan Ekosistem Essensial DIY -->
    <div class="col-md-6 col-lg-4">
    <div class="card">
        <img src="img/mangrove mojo.jpg" class="card-img-top" alt="Kawasan Mangrove Mojo">
        <div class="card-body">
            <h5 class="card-title">Kawasan Ekosistem Essensial Jawa Tengah</h5>
            <ul>
                <li>
                    <a href="https://www.rri.co.id/daerah/1399532/mangrove-muara-kali-ijo-jaga-ekosistem-pesisir-jawa-tengah" 
                       class="link-kawasan" target="_blank" rel="noopener noreferrer">
                        Hutan Mangrove Muara Kali Ijo
                    </a>
                </li>
                <li>
                    <a href="https://nativeindonesia.com/hutan-mangrove-mojo/" 
                       class="link-kawasan" target="_blank" rel="noopener noreferrer">
                        Hutan Mangrove Mojo
                    </a>
                </li>
                <li>
                    <a href="https://tireman-rembang.desa.id/index.php/artikel/2022/3/23/kee-kawasan-ekosistem-essensial-desa-tireman" 
                       class="link-kawasan" target="_blank" rel="noopener noreferrer">
                        Desa Tireman & Pasarbanggi (Mangrove)
                    </a>
                </li>
                <li>
                    <a href="https://visitjawatengah.jatengprov.go.id/id/regency/kabupaten-pekalongan/destinasi-wisata/kawasan-ekowisata-petungkriyono" 
                       class="link-kawasan" target="_blank" rel="noopener noreferrer">
                        Hutan Petungkriyono
                    </a>
                </li>
                <li>
                    <a href="https://relungindonesia.org/2024/03/mengembangkan-ekowisata-dan-agroforestri-di-hutan-lindung-gunung-ungaran/" 
                       class="link-kawasan" target="_blank" rel="noopener noreferrer">
                        Hutan Lindung Gunung Ungaran
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

</section>


<style>
    /* Warna default link */
    .link-kawasan {
        color: #444;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    /* Warna saat hover */
    .link-kawasan:hover {
        color: orange;
    }
    /* Warna saat aktif diklik */
    .link-kawasan.active {
        color: orange;
        font-weight: bold;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".link-kawasan");

        links.forEach(link => {
            link.addEventListener("click", function() {
                // hapus active dari semua link
                links.forEach(l => l.classList.remove("active"));
                // tambahkan active ke link yang diklik
                this.classList.add("active");
            });
        });
    });
</script>
                <div class="card p-4 shadow-sm h-100">
                    <p class="fs-6 mb-4"><?php echo nl2br(htmlspecialchars($kawasan['content'] ?? 'Konten kawasan hutan belum diisi.')); ?></p>
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
                            <a href="../index.php"><i class="fas fa-angle-right me-2"></i> Beranda</a>
                            <a href="sejarah.php"><i class="fas fa-angle-right me-2"></i> Tentang Kami</a>
                            <a href="../berita-lainnya.html"><i class="fas fa-angle-right me-2"></i> Berita & Artikel</a>
                            <a href="perlindungan.php"><i class="fas fa-angle-right me-2"></i> Kegiatan Konservasi</a>
                            <a href="gallery.html"><i class="fas fa-angle-right me-2"></i> Galeri</a>
                            <a href="contact.html"><i class="fas fa-angle-right me-2"></i> Kontak</a>
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