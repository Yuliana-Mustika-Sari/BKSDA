<?php
session_start();
$is_loggedin = isset($_SESSION['loggedin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pemberdayaan Masyarakat - BKSDA Jawa Tengah</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .interactive-card {
            background-color: #f8f9fa;
            border-left: 5px solid var(--bs-primary);
            transition: all 0.3s ease-in-out;
        }
        .interactive-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .nav-tabs-custom .nav-link {
            border-radius: 50px;
            padding: 10px 20px;
            margin: 0 5px;
            background-color: #e9ecef;
            color: #495057;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-tabs-custom .nav-link.active {
            background-color: var(--bs-primary);
            color: #fff;
        }
        /* Style for better spaced nav items */
        .navbar-nav .nav-item {
            margin: 0 8px; /* Menambahkan margin horizontal untuk jarak */
        }
        .navbar-nav .nav-link {
            padding: 10px 15px !important; /* Menambahkan padding yang lebih besar */
        }
    </style>
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
                            <a href="../logout.php" class="nav-item nav-link text-danger fw-bold" onclick="return confirm('Apakah Anda yakin ingin logout dan kembali ke landing page?')">
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
                <h1 class="text-white display-2 mb-4 animated-text fw-bold">Pemberdayaan Masyarakat</h1>
                <p class="fs-4 text-white mb-4 animated-text">Membangun Kemitraan untuk Konservasi</p>
                <p class="fs-6 text-white-50 animated-text">Bersama-sama menjaga lingkungan dan meningkatkan kesejahteraan</p>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5 content-section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12">
                    <div class="text-center mx-auto section-title animate__animated animate__fadeInUp" style="max-width: 900px;">
                        <h5 class="text-uppercase text-primary">Program Kami</h5>
                        <h1 class="mb-4">Tahapan Pemberdayaan Masyarakat</h1>
                        <p class="mb-0">
                            Berikut adalah langkah-langkah yang kami lakukan dalam program pemberdayaan masyarakat untuk mendukung konservasi sumber daya alam secara berkelanjutan.
                        </p>
                    </div>
                    <ul class="nav nav-tabs nav-tabs-custom justify-content-center mb-4" id="pemberdayaanTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="identifikasi-tab" data-bs-toggle="tab" data-bs-target="#identifikasi-konten" type="button" role="tab" aria-controls="identifikasi-konten" aria-selected="true">
                                <i class="fas fa-search-location me-2"></i>Identifikasi Potensi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pembentukan-tab" data-bs-toggle="tab" data-bs-target="#pembentukan-konten" type="button" role="tab" aria-controls="pembentukan-konten" aria-selected="false">
                                <i class="fas fa-users-cog me-2"></i>Pembentukan Kelompok
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bantuan-tab" data-bs-toggle="tab" data-bs-target="#bantuan-konten" type="button" role="tab" aria-controls="bantuan-konten" aria-selected="false">
                                <i class="fas fa-hands-helping me-2"></i>Bantuan & Pelatihan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pembinaan-tab" data-bs-toggle="tab" data-bs-target="#pembinaan-konten" type="button" role="tab" aria-controls="pembinaan-konten" aria-selected="false">
                                <i class="fas fa-user-friends me-2"></i>Pembinaan & Pendampingan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="monitoring-tab" data-bs-toggle="tab" data-bs-target="#monitoring-konten" type="button" role="tab" aria-controls="monitoring-konten" aria-selected="false">
                                <i class="fas fa-chart-line me-2"></i>Monitoring
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="supervisi-tab" data-bs-toggle="tab" data-bs-target="#supervisi-konten" type="button" role="tab" aria-controls="supervisi-konten" aria-selected="false">
                                <i class="fas fa-eye me-2"></i>Supervisi
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pemberdayaanTabContent">
                        <div class="tab-pane fade show active" id="identifikasi-konten" role="tabpanel">
                            <div class="interactive-card p-5 animate__animated animate__fadeInUp">
                                <h3 class="h4 text-primary mb-4 text-center"><i class="fas fa-search me-2"></i>Identifikasi Potensi Wilayah</h3>
                                <p class="text-justify">
                                    BKSDA Jawa Tengah mengelola 33 kawasan konservasi dengan luas total 142.046,50 hektar yang terdiri dari cagar alam, suaka margasatwa, dan taman wisata alam. Identifikasi potensi dilakukan untuk mengoptimalkan pengelolaan kawasan tersebut.
                                </p>
                                <ul class="list-unstyled mt-4">
                                    <li class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-paw text-success me-2"></i>Keanekaragaman Hayati (Flora & Fauna)</h6>
                                        <p class="small text-muted mb-0">Identifikasi flora dan fauna langka, seperti lutung Jawa, kancil Jawa, dan burung gereja Jawa. Di kawasan pesisir, BKSDA fokus pada konservasi ekosistem mangrove dan terumbu karang, terutama di Cagar Alam Laut P. Momongan dan sekitarnya (Pekalongan) serta Cagar Alam Nasional Nusakambangan (Cilacap). Sejak 2022, tercatat penemuan 5 spesies tumbuhan endemik baru di Cagar Alam Telaga Ranjeng, Pekalongan.</p>
                                    </li>
                                    <li class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-water text-info me-2"></i>Sumber Daya Air dan Geologi</h6>
                                        <p class="small text-muted mb-0">Identifikasi 31 Cekungan Air Tanah (CAT) yang menjadi area konservasi air tanah penting di Jawa Tengah. Kami juga memetakan potensi geologi seperti kars untuk perlindungan sistem air bawah tanah. Proyek percontohan restorasi mata air di TWA Grojogan Sewu, Karanganyar telah berhasil meningkatkan debit air sebesar 20% dalam 1 tahun terakhir.</p>
                                    </li>
                                    <li>
                                        <h6 class="fw-bold"><i class="fas fa-handshake text-warning me-2"></i>Potensi Sosial & Ekonomi</h6>
                                        <p class="small text-muted mb-0">Meningkatkan keterampilan Kelompok Tani Hutan (KTH) di Taman Wisata Alam Gunung Selok, Cilacap dalam kewirausahaan, seperti pengemasan produk dan pemasaran. BKSDA juga berkoordinasi dengan perhutani untuk pemanfaatan berkelanjutan seperti penangkaran rusa di KPH Mantingan dan budidaya madu di sekitar Cagar Alam Telaga Ranjeng, Pekalongan. Program ini telah menghasilkan 3 produk olahan baru yang berhasil dipasarkan secara lokal.</p>
                                    </li>
                                </ul>
                                <div class="text-center mt-4">
                                    <button class="btn btn-primary" onclick="showPotentialData()">Lihat Data Potensi Utama</button>
                                    <div id="potentialData" class="mt-3" style="display:none;">
                                        <p class="fw-bold">Data Proyeksi Potensi (2025):</p>
                                        <ul class="list-unstyled small text-muted">
                                            <li><i class="fas fa-leaf me-2 text-success"></i> Potensi Hasil Hutan Non-Kayu: Produksi Madu Hutan diproyeksikan mencapai 750 kg/tahun.</li>
                                            <li><i class="fas fa-fish me-2 text-info"></i> Potensi Perikanan: Target produksi Lobster Air Tawar di area penyangga kawasan meningkat menjadi 2 ton/tahun.</li>
                                            <li><i class="fas fa-hiking me-2 text-warning"></i> Potensi Ekowisata: Peningkatan jumlah pengunjung di TWA Gunung Selok dan TWA Grojogan Sewu mencapai 20% tahun ini.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="pembentukan-konten" role="tabpanel">
                            <div class="interactive-card p-5 animate__animated animate__fadeInUp">
                                <h3 class="h4 text-primary mb-4 text-center"><i class="fas fa-users-cog me-2"></i>Pembentukan Kelompok Masyarakat</h3>
                                <p class="text-justify">
                                    Hingga saat ini, BKSDA Jawa Tengah telah memfasilitasi pembentukan dan pembinaan lebih dari 50 kelompok masyarakat yang tersebar di sekitar kawasan konservasi. Kemitraan ini adalah kunci keberhasilan konservasi.
                                </p>
                                <ul class="list-unstyled mt-4">
                                    <li class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-tree text-success me-2"></i>Kelompok Tani Hutan (KTH)</h6>
                                        <p class="small text-muted mb-0">Saat ini, terdapat 25 KTH aktif dengan total 800 anggota yang fokus pada pengelolaan hutan, reboisasi, dan pemanfaatan hasil hutan non-kayu secara berkelanjutan. Mereka dilatih untuk menghasilkan produk olahan dari getah pinus, madu, dan aneka tanaman obat.</p>
                                    </li>
                                    <li class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-fire-extinguisher text-danger me-2"></i>Masyarakat Peduli Api (MPA)</h6>
                                        <p class="small text-muted mb-0">Sebanyak 15 MPA dengan total 250 relawan telah dibentuk dan dilatih untuk menjadi garda terdepan dalam pencegahan dan penanggulangan kebakaran hutan dan lahan. Mereka dilengkapi dengan 50 set peralatan standar dan sistem komunikasi yang efektif.</p>
                                    </li>
                                    <li>
                                        <h6 class="fw-bold"><i class="fas fa-shield-alt text-primary me-2"></i>Masyarakat Mitra Polhut (MMP)</h6>
                                        <p class="small text-muted mb-0">Lebih dari 10 MMP dengan 150 anggota secara rutin membantu petugas polhut dalam pengawasan, patroli, dan deteksi dini kegiatan ilegal di kawasan konservasi. Kolaborasi ini telah berhasil menekan angka perburuan liar dan penebangan ilegal hingga 40% dalam tiga tahun terakhir.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="bantuan-konten" role="tabpanel">
                            <div class="interactive-card p-5 animate__animated animate__fadeInUp">
                                <h3 class="h4 text-primary mb-4 text-center"><i class="fas fa-hands-helping me-2"></i>Pemberian Bantuan & Pelatihan</h3>
                                <p class="text-justify">
                                    BKSDA secara rutin memberikan dukungan nyata kepada kelompok masyarakat, baik berupa bantuan materiil maupun peningkatan kapasitas melalui berbagai pelatihan. Sejak tahun 2022, telah disalurkan bantuan senilai total Rp 500 Juta untuk menunjang kegiatan produktif.
                                </p>
                                <div class="row g-4 mt-4">
                                    <div class="col-lg-6">
                                        <h6 class="fw-bold text-success"><i class="fas fa-box me-2"></i>Pemberian Bantuan Fisik</h6>
                                        <p class="small text-muted">Bantuan berupa bibit tanaman endemik, seperti bibit pohon jati dan mahoni untuk reboisasi, peralatan pertanian modern, hingga alat pemadam kebakaran portabel untuk menunjang kegiatan konservasi dan ekonomi produktif.</p>
                                        <ul class="list-unstyled small text-muted">
                                            <li><i class="fas fa-seedling me-2 text-success"></i> 15.000 bibit pohon telah disalurkan di 10 lokasi berbeda.</li>
                                            <li><i class="fas fa-tools me-2 text-info"></i> 25 set alat pemadam kebakaran dibagikan kepada MPA di kawasan rawan kebakaran.</li>
                                            <li><i class="fas fa-tractor me-2 text-warning"></i> 5 unit traktor tangan diserahkan kepada KTH di Banjarnegara dan Cilacap.</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6 class="fw-bold text-primary"><i class="fas fa-chalkboard-teacher me-2"></i>Pelatihan & Peningkatan Kapasitas</h6>
                                        <p class="small text-muted">Pelatihan teknis mencakup budidaya tanaman, pengolahan hasil non-kayu (misal, pengemasan madu dan pembuatan keripik buah), hingga strategi pemasaran produk lokal. Semua bertujuan untuk menciptakan kemandirian.</p>
                                        <ul class="list-unstyled small text-muted">
                                            <li><i class="fas fa-award me-2 text-primary"></i> Lebih dari 100 peserta mengikuti pelatihan kewirausahaan.</li>
                                            <li><i class="fas fa-hands-wash me-2 text-danger"></i> Pelatihan pengelolaan sanitasi dan air bersih di area TWA untuk 5 kelompok masyarakat.</li>
                                            <li><i class="fas fa-shipping-fast me-2 text-warning"></i> Workshop pemasaran digital untuk 15 produk UMKM lokal.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="pembinaan-konten" role="tabpanel">
                            <div class="interactive-card p-5 animate__animated animate__fadeInUp">
                                <h3 class="h4 text-primary mb-4 text-center"><i class="fas fa-user-friends me-2"></i>Pembinaan dan Pendampingan</h3>
                                <p class="text-justify">
                                    Tahap ini memastikan setiap program berjalan efektif dan berkelanjutan. Petugas BKSDA memberikan bimbingan teknis dan manajerial secara langsung di lapangan. Hingga kini, petugas lapangan kami melakukan setidaknya 20 kunjungan pendampingan per bulan.</p>
                                <ul class="list-unstyled mt-4">
                                    <li class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-headset text-success me-2"></i>Bimbingan Berkelanjutan</h6>
                                        <p class="small text-muted mb-0">Memberikan konsultasi dan solusi praktis untuk setiap kendala yang dihadapi kelompok di lapangan. Ini mencakup masalah hama, kendala pemasaran, hingga penyusunan laporan keuangan sederhana. Pada tahun 2024, telah diadakan 12 sesi mentoring khusus untuk KTH.</p>
                                    </li>
                                    <li>
                                        <h6 class="fw-bold"><i class="fas fa-cogs text-info me-2"></i>Peningkatan Keterampilan Manajerial</h6>
                                        <p class="small text-muted mb-0">Membantu kelompok dalam mengelola organisasi dan keuangan, serta meningkatkan keterampilan teknis sesuai dengan potensi lokal, seperti teknik budidaya lebah madu modern dan pengolahan limbah organik. Sekitar 80% kelompok yang didampingi menunjukkan peningkatan tata kelola.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="monitoring-konten" role="tabpanel">
                            <div class="interactive-card p-5 animate__animated animate__fadeInUp">
                                <h3 class="h4 text-primary mb-4 text-center"><i class="fas fa-chart-line me-2"></i>Monitoring dan Evaluasi Program</h3>
                                <p class="text-justify">
                                    BKSDA melakukan pemantauan rutin untuk mengukur keberhasilan program dan memastikan dampaknya terasa positif bagi masyarakat dan lingkungan. Sistem monitoring kami mencatat data kuantitatif dan kualitatif secara berkala.
                                </p>
                                <ul class="list-unstyled mt-4">
                                    <li class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-tasks text-success me-2"></i>Pemantauan Rutin & Pelaporan</h6>
                                        <p class="small text-muted mb-0">Mengevaluasi kegiatan yang telah berjalan, mulai dari pemanfaatan bantuan hingga pertumbuhan kelompok. Kami mencatat setiap progres, seperti jumlah pohon yang ditanam (total 5.000 bibit), volume produk yang dihasilkan (2 ton madu), dan jumlah kunjungan turis (bertambah 10.000 kunjungan).</p>
                                    </li>
                                    <li>
                                        <h6 class="fw-bold"><i class="fas fa-users-sync text-primary me-2"></i>Dampak Sosial dan Lingkungan</h6>
                                        <p class="small text-muted mb-0">Mengamati perubahan perilaku masyarakat terkait konservasi dan dampak ekologis dari program yang diterapkan. Contohnya, berkurangnya kasus perburuan liar di kawasan Cagar Alam Nasional Nusakambangan berkat peran aktif MMP.</p>
                                    </li>
                                </ul>
                                <div class="text-center mt-4">
                                    <button class="btn btn-warning" onclick="showMonitoringResults()">Tampilkan Hasil Monitoring (Simulasi)</button>
                                    <div id="monitoringResults" class="mt-3" style="display:none;">
                                        <p class="fw-bold">Ringkasan Hasil Monitoring (Tahun 2024):</p>
                                        <ul class="list-unstyled small text-muted">
                                            <li><i class="fas fa-hand-holding-usd me-2 text-success"></i> Pendapatan Kelompok Tani: Rata-rata meningkat 30% per tahun. Total pendapatan kolektif KTH mencapai Rp 350 Juta.</li>
                                            <li><i class="fas fa-tree me-2 text-info"></i> Area Rehabilitasi Hutan: Tambahan 20 hektar per tahun. Total area yang direhabilitasi dalam 5 tahun terakhir mencapai 100 hektar.</li>
                                            <li><i class="fas fa-balance-scale-right me-2 text-warning"></i> Kasus Ilegal: Penurunan kasus perambahan hutan dan perburuan liar sebesar 40%. Tercatat 5 kasus perburuan berhasil digagalkan oleh MMP.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="supervisi-konten" role="tabpanel">
                            <div class="interactive-card p-5 animate__animated animate__fadeInUp">
                                <h3 class="h4 text-primary mb-4 text-center"><i class="fas fa-eye me-2"></i>Supervisi Program</h3>
                                <p class="text-justify">
                                    Supervisi adalah langkah krusial untuk memastikan seluruh program pemberdayaan berjalan sesuai dengan tata kelola yang baik dan tujuan konservasi yang telah ditetapkan. Kami bekerja sama dengan auditor internal dan eksternal untuk memastikan transparansi.
                                </p>
                                <ul class="list-unstyled mt-4">
                                    <li class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-clipboard-check text-success me-2"></i>Audit & Penilaian Program</h6>
                                        <p class="small text-muted mb-0">Pemeriksaan dan penilaian berkala terhadap pelaksanaan program untuk memastikan efisiensi dan efektivitasnya. Kami memastikan setiap dana dan sumber daya digunakan secara optimal untuk mencapai tujuan konservasi dan kesejahteraan masyarakat. Audit terakhir menunjukkan tingkat efektivitas program mencapai 85%.</p>
                                    </li>
                                    <li>
                                        <h6 class="fw-bold"><i class="fas fa-balance-scale text-primary me-2"></i>Kepatuhan Prosedur</h6>
                                        <p class="small text-muted mb-0">Memastikan bahwa semua kegiatan dan penggunaan anggaran mematuhi prosedur yang berlaku serta regulasi dari Kementerian Lingkungan Hidup dan Kehutanan. Hal ini untuk menjaga akuntabilitas dan kepercayaan publik. Semua laporan keuangan dan operasional program telah diaudit dan dinyatakan patuh.</p>
                                    </li>
                                </ul>
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
                        <p class="mb-4">Sebagai Unit Pelaksana Teknis (UPT) Kementrian Lingkungan Hidup Dan Kehutanan yang bertugas untuk mengelola 33 kawasan konservasi berbentuk cagar alam, suaka margasatwa dan taman wisata di Jawa Tengah.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="mb-4 text-white">Tautan Cepat</h4>
                        <a href="../index.php"><i class="fas fa-angle-right me-2"></i> Beranda</a>
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
    <script>
        new WOW().init();
        
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            const targetPane = $(e.target.getAttribute('data-bs-target'));
            targetPane.hide().fadeIn(500);
        });

        function showPotentialData() {
            const dataDiv = document.getElementById('potentialData');
            if (dataDiv.style.display === 'none') {
                dataDiv.style.display = 'block';
            } else {
                dataDiv.style.display = 'none';
            }
        }

        function showMonitoringResults() {
            const dataDiv = document.getElementById('monitoringResults');
            if (dataDiv.style.display === 'none') {
                dataDiv.style.display = 'block';
            } else {
                dataDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>