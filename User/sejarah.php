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

    // Ambil konten untuk halaman "Sejarah Singkat" dari database
    $sql_sejarah = "SELECT title, content FROM web_content WHERE page_slug = 'sejarah' AND section_id = 'sejarah-singkat'";
    $result_sejarah = $conn->query($sql_sejarah);
    $sejarah_content = $result_sejarah->fetch_assoc();

    // Ambil data berita terbaru
    $sql_berita = "SELECT id, title, content, created_date FROM news ORDER BY created_date DESC LIMIT 4";
    $result_berita = $conn->query($sql_berita);

    // Ambil data timeline
    $sql_timeline = "SELECT title, content, event_year FROM timeline ORDER BY event_year ASC";
    $result_timeline = $conn->query($sql_timeline);

    // Ambil data galeri
    $sql_galeri = "SELECT title, description, image_url, category FROM gallery ORDER BY created_date DESC";
    $result_galeri = $conn->query($sql_galeri);

    $conn->close();
} else {
    // Konten statis jika koneksi database gagal
    $sejarah_content = ['title' => 'Sejarah Organisasi', 'content' => 'Balai Konservasi Sumber Daya Alam atau biasa disingkat menjadi BKSDA, adalah unit pelaksana teknis dari Direktorat Jenderal Konservasi Sumber Daya Alam dan Ekosistem pada Kementerian Kehutanan Republik Indonesia yang bertugas melaksanakan penyelenggaraan konservasi sumber daya alam dan ekosistemnya pada cagar alam, suaka margasatwa, taman wisata alam, dan taman buru; konservasi keanekaragaman hayati ekosistem, spesies, dan genetik; serta koordinasi teknis pengelolaan taman hutan raya dan kawasan ekosistem esensial atau kawasan dengan nilai konservasi tinggi. Berdasarkan Peraturan Menteri Kehutanan Nomor : P.02/Menhut-II/2007 Tanggal 1 Pebruari 2007 sebagaimana telah diperbaharui dengan Peraturan Menteri Kehutanan nomor P.51/Menhut-II/2009 tanggal 27 Juli 2009 tentang Organisasi dan Tata Kerja Unit Pelaksana Konservasi Sumber Daya Alam, Balai Konservasi Sumber Daya Alam Jawa Tengah sebagai Unit Pelaksana Teknis di Bidang Konservasi Sumber Daya Alam Hayati dan Ekosistemnya yang berada dibawah dan bertanggung jawab kepada Direktur Jenderal Perlindungan Hutan dan Konservasi Alam, Kementerian Kehutanan. Kawasan konservasi yang dikelola oleh Balai KSDA Jawa Tengah tersebar di 2 (dua) Seksi Konservasi Wilayah dengan luas 3.170,50 ha yang terdiri dari : 30 Cagar Alam (2.819,40 ha), 4 Taman Wisata Alam (247,20 ha), serta satu Suaka Margasatwa (103,90 ha).'];
    $result_berita = false;
    $result_timeline = false;
    $result_galeri = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
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
    <link href="../css/sejarah_style.css" rel="stylesheet">
</head>

<body>
    <?php include '_user_nav.php'; ?>
    <div class="hero-section d-flex align-items-center">
        <div class="floating-elements">
            <div class="floating-leaf" style="top: 10%; left: 10%;"><i class="fas fa-leaf"></i></div>
            <div class="floating-leaf" style="top: 20%; right: 15%; animation-delay: -2s;"><i class="fas fa-seedling"></i></div>
            <div class="floating-leaf" style="top: 60%; left: 5%; animation-delay: -4s;"><i class="fas fa-tree"></i></div>
            <div class="floating-leaf" style="bottom: 20%; right: 10%; animation-delay: -1s;"><i class="fas fa-leaf"></i></div>
        </div>
        <div class="container hero-content">
            <div class="text-center">
                <h1 class="text-white display-2 mb-4 animated-text fw-bold">Sejarah Organisasi</h1>
                <p class="fs-4 text-white mb-4 animated-text">Balai Konservasi Sumber Daya Alam Jawa Tengah</p>
                <p class="fs-6 text-white-50 animated-text">Menjelajahi jejak langkah kami dalam melestarikan alam</p>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <ul class="nav nav-tabs nav-tabs-custom justify-content-center" id="sejarahTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="sejarah-tab" data-bs-toggle="tab" data-bs-target="#sejarah-konten" type="button" role="tab">
                    <i class="fas fa-landmark me-2"></i>Sejarah Singkat
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline-konten" type="button" role="tab">
                    <i class="fas fa-history me-2"></i>Timeline
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="berita-tab" data-bs-toggle="tab" data-bs-target="#berita-konten" type="button" role="tab">
                    <i class="fas fa-newspaper me-2"></i>Berita Terbaru
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="galeri-tab" data-bs-toggle="tab" data-bs-target="#galeri-konten" type="button" role="tab">
                    <i class="fas fa-images me-2"></i>Galeri
                </button>
            </li>
        </ul>

        <div class="tab-content" id="sejarahTabContent">
            <div class="tab-pane fade show active" id="sejarah-konten" role="tabpanel">
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-10">
                        <div class="interactive-card p-5 text-center animate__animated animate__fadeInUp">
                            <i class="fas fa-book-open fa-4x text-primary mb-4"></i>
                            <h2 class="fw-bold text-uppercase text-primary mb-4"><?php echo htmlspecialchars($sejarah_content['title'] ?? 'Sejarah Organisasi'); ?></h2>
                            <p class="text-justify lh-lg fs-5">
                                <?php
                                $sejarah_parts = explode('Berdasarkan Peraturan Menteri Kehutanan', $sejarah_content['content'] ?? 'Balai Konservasi Sumber Daya Alam atau biasa disingkat menjadi BKSDA, adalah unit pelaksana teknis dari Direktorat Jenderal Konservasi Sumber Daya Alam dan Ekosistem pada Kementerian Kehutanan Republik Indonesia yang bertugas melaksanakan penyelenggaraan konservasi sumber daya alam dan ekosistemnya pada cagar alam, suaka margasatwa, taman wisata alam, dan taman buru; konservasi keanekaragaman hayati ekosistem, spesies, dan genetik; serta koordinasi teknis pengelolaan taman hutan raya dan kawasan ekosistem esensial atau kawasan dengan nilai konservasi tinggi. Berdasarkan Peraturan Menteri Kehutanan Nomor : P.02/Menhut-II/2007 Tanggal 1 Pebruari 2007 sebagaimana telah diperbaharui dengan Peraturan Menteri Kehutanan nomor P.51/Menhut-II/2009 tanggal 27 Juli 2009 tentang Organisasi dan Tata Kerja Unit Pelaksana Konservasi Sumber Daya Alam, Balai Konservasi Sumber Daya Alam Jawa Tengah sebagai Unit Pelaksana Teknis di Bidang Konservasi Sumber Daya Alam Hayati dan Ekosistemnya yang berada dibawah dan bertanggung jawab kepada Direktur Jenderal Perlindungan Hutan dan Konservasi Alam, Kementerian Kehutanan. Kawasan konservasi yang dikelola oleh Balai KSDA Jawa Tengah tersebar di 2 (dua) Seksi Konservasi Wilayah dengan luas 3.170,50 ha yang terdiri dari : 30 Cagar Alam (2.819,40 ha), 4 Taman Wisata Alam (247,20 ha), serta satu Suaka Margasatwa (103,90 ha).');
                                echo htmlspecialchars($sejarah_parts[0]);
                                ?>
                            </p>
                            <p class="text-justify lh-lg fs-5 mt-4">
                                <?php
                                if (isset($sejarah_parts[1])) {
                                    echo 'Berdasarkan Peraturan Menteri Kehutanan' . htmlspecialchars($sejarah_parts[1]);
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="timeline-konten" role="tabpanel">
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-10">
                        <h3 class="text-center mb-5 fw-bold"><i class="fas fa-history me-2"></i>Perjalanan Sejarah BKSDA</h3>
                        <div class="timeline">
                            <?php if ($result_timeline && $result_timeline->num_rows > 0): ?>
                                <?php while ($item = $result_timeline->fetch_assoc()): ?>
                                    <div class="timeline-item animate__animated animate__fadeInLeft">
                                        <div class="timeline-icon"><i class="fas fa-calendar-alt"></i></div>
                                        <div class="timeline-content interactive-card">
                                            <h4 class="fw-bold text-primary"><?php echo htmlspecialchars($item['title']); ?></h4>
                                            <p class="mb-0"><?php echo htmlspecialchars($item['content']); ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="timeline-item animate__animated animate__fadeInLeft">
                                    <div class="timeline-icon"><i class="fas fa-seedling"></i></div>
                                    <div class="timeline-content interactive-card">
                                        <h4 class="fw-bold text-primary">Berdirinya Organisasi</h4>
                                        <p class="mb-0">BKSDA Jawa Tengah didirikan sebagai unit pelaksana teknis untuk mengelola kawasan konservasi di wilayah Jawa Tengah.</p>
                                    </div>
                                </div>
                                <div class="timeline-item animate__animated animate__fadeInLeft" style="animation-delay: 0.3s;">
                                    <div class="timeline-icon"><i class="fas fa-gavel"></i></div>
                                    <div class="timeline-content interactive-card">
                                        <h4 class="fw-bold text-primary">Pembaruan Peraturan</h4>
                                        <p class="mb-0">Penerbitan Peraturan Menteri Kehutanan Nomor P.51/Menhut-II/2009 memperbarui tata kerja BKSDA.</p>
                                    </div>
                                </div>
                                <div class="timeline-item animate__animated animate__fadeInLeft" style="animation-delay: 0.6s;">
                                    <div class="timeline-icon"><i class="fas fa-chart-line"></i></div>
                                    <div class="timeline-content interactive-card">
                                        <h4 class="fw-bold text-primary">Ekspansi Kawasan Konservasi</h4>
                                        <p class="mb-0">Perluasan area kelola BKSDA hingga mencakup 30 Cagar Alam, 4 Taman Wisata Alam, dan 1 Suaka Margasatwa.</p>
                                    </div>
                                </div>
                                <div class="timeline-item animate__animated animate__fadeInLeft" style="animation-delay: 0.9s;">
                                    <div class="timeline-icon"><i class="fas fa-leaf"></i></div>
                                    <div class="timeline-content interactive-card">
                                        <h4 class="fw-bold text-primary">Fokus Reboisasi</h4>
                                        <p class="mb-0">Memulai program reboisasi besar-besaran di beberapa kawasan konservasi untuk memulihkan ekosistem yang rusak.</p>
                                    </div>
                                </div>
                                <div class="timeline-item animate__animated animate__fadeInLeft" style="animation-delay: 1.2s;">
                                    <div class="timeline-icon"><i class="fas fa-paw"></i></div>
                                    <div class="timeline-content interactive-card">
                                        <h4 class="fw-bold text-primary">Pelepasliaran Satwa</h4>
                                        <p class="mb-0">Melaksanakan berbagai kegiatan pelepasliaran satwa hasil rehabilitasi, termasuk Burung Elang dan Macan Tutul Jawa.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="berita-konten" role="tabpanel">
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-8">
                        <div class="interactive-card p-5 animate__animated animate__fadeInUp">
                            <h3 class="h4 text-primary mb-4 text-center">
                                <i class="fas fa-newspaper me-2"></i>Berita Terbaru
                            </h3>
                            <?php
                            $news_data = [];
                            if ($result_berita && $result_berita->num_rows > 0) {
                                while ($berita = $result_berita->fetch_assoc()) {
                                    $news_data[] = $berita;
                                }
                            } else {
                                $news_data = [
                                    [
                                        'id' => 1,
                                        'title' => 'Kolaborasi untuk Konservasi Kukang Jawa',
                                        'created_date' => '2025-08-12',
                                        'content' => 'Perhutani bersama BKSDA Provinsi Jawa Tengah telah melakukan pelepasliaran Kukang Jawa (*Nycticebus javanicus*) di hutan alam Kemuning. Upaya ini bertujuan untuk melestarikan Kukang di habitat yang sesuai agar dapat berkembang biak.'
                                    ],
                                    [
                                        'id' => 2,
                                        'title' => 'Upaya Mengembalikan Pulau Bidadari Sebagai Habitat Penyu',
                                        'created_date' => '2025-05-15',
                                        'content' => 'BKSDA bersama Ancol berupaya mengembalikan Pulau Bidadari di Kepulauan Seribu sebagai tempat pendaratan penyu. Sekitar 200 ekor tukik (penyu sisik) telah dilepaskan di sana sebagai langkah awal untuk menjadikannya habitat penyu di masa depan.'
                                    ],
                                    [
                                        'id' => 3,
                                        'title' => 'Gunung Slamet Diajukan Jadi Taman Nasional',
                                        'created_date' => '2025-04-24',
                                        'content' => 'Pemprov Jawa Tengah telah mengajukan Gunung Slamet kepada KLHK untuk dijadikan taman nasional. Kawasan ini dikenal sebagai habitat bagi 28 spesies burung endemik dan Macan Tutul Jawa.'
                                    ],
                                    [
                                        'id' => 4,
                                        'title' => 'Dari Pemburu Menjadi Penjaga Burung',
                                        'created_date' => '2025-05-20',
                                        'content' => 'Junianto dan Ari Hidayat, mantan pemburu burung di Gunung Slamet, kini menjadi pegiat konservasi. Ari bahkan meraih penghargaan Kalpataru tingkat provinsi pada tahun 2019.'
                                    ],
                                    [
                                        'id' => 5,
                                        'title' => 'Rehabilitasi Elang Jawa di Kawasan Konservasi',
                                        'created_date' => '2025-07-01',
                                        'content' => 'Tim dari BKSDA Jawa Tengah berhasil merehabilitasi seekor Elang Jawa yang ditemukan terluka. Setelah proses pemulihan, elang tersebut dilepasliarkan kembali ke habitat aslinya di Cagar Alam Gunung Merbabu.'
                                    ],
                                    [
                                        'id' => 6,
                                        'title' => 'Pelatihan Mitigasi Konflik Satwa Liar',
                                        'created_date' => '2025-06-10',
                                        'content' => 'BKSDA Jawa Tengah mengadakan pelatihan untuk masyarakat yang tinggal di sekitar kawasan hutan. Pelatihan ini berfokus pada teknik mitigasi konflik antara manusia dan satwa liar, seperti macan dan monyet ekor panjang.'
                                    ],
                                    [
                                        'id' => 7,
                                        'title' => 'Penanaman Pohon Endemik di Kawasan Suaka Margasatwa',
                                        'created_date' => '2025-03-25',
                                        'content' => 'Dalam rangka Hari Hutan Sedunia, BKSDA Jawa Tengah berkolaborasi dengan komunitas lokal untuk menanam ribuan bibit pohon endemik di area Suaka Margasatwa dataran rendah. Kegiatan ini diharapkan dapat mengembalikan keanekaragaman flora di kawasan tersebut.'
                                    ]
                                ];
                            }
                            ?>
                            <?php foreach ($news_data as $berita): ?>
                                <div class="news-item mb-3 pb-3 border-bottom animate__animated animate__fadeInLeft">
                                    <h6 class="fw-semibold mb-2">
                                        <a href="berita-detail.php?id=<?php echo $berita['id'] ?? '#'; ?>" class="text-decoration-none text-dark">
                                            <?php echo htmlspecialchars($berita['title'] ?? 'Judul Berita'); ?>
                                        </a>
                                    </h6>
                                    <p class="small text-muted mb-2">
                                        <?php echo date('d M Y', strtotime($berita['created_date'] ?? date('Y-m-d'))); ?>
                                    </p>
                                    <p class="small text-justify">
                                        <?php
                                        $content = $berita['content'] ?? 'Konten berita tidak tersedia.';
                                        echo htmlspecialchars(substr($content, 0, 150)) . (strlen($content) > 150 ? '...' : '');
                                        ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="galeri-konten" role="tabpanel">
                <div class="p-5 mt-4 interactive-card animate__animated animate__fadeInUp">
                    <div class="text-center pb-3" style="max-width: 800px; margin: 0 auto;">
                        <h2 class="fw-bold text-primary mb-3">
                            <i class="fas fa-images me-2"></i>Galeri Konservasi
                        </h2>
                        <p class="text-muted">Dokumentasi Keanekaragaman Hayati Jawa Tengah</p>
                    </div>

                    <div class="mb-5">
                        <h4 class="text-primary fw-bold mb-3"><i class="fas fa-paw me-2"></i>Fauna Jawa Tengah</h4>
                        <div class="row g-3">
                            <?php
                            $fauna_data = [];
                            if ($result_galeri && $result_galeri->num_rows > 0) {
                                mysqli_data_seek($result_galeri, 0);
                                while ($row = $result_galeri->fetch_assoc()) {
                                    if ($row['category'] == 'fauna') {
                                        $fauna_data[] = $row;
                                    }
                                }
                            } else {
                                $fauna_data = [
                                    ['title' => 'Burung Gereja Jawa', 'description' => 'Lonchura leucogastroides', 'image_url' => '../img/gereja-jawa.jpg'],
                                    ['title' => 'Kancil Jawa', 'description' => 'Tragulus javanicus', 'image_url' => '../img/kancil_jawa.jpg'],
                                    ['title' => 'Lutung Jawa', 'description' => 'Trachypithecus auratus', 'image_url' => '../img/Lutung_Jawa.jpg'],
                                    ['title' => 'Rangkong Jawa', 'description' => 'Buceros rhinoceros', 'image_url' => '../img/rangkong_jawa.jpg'],
                                    ['title' => 'Macan Tutul Jawa', 'description' => 'Panthera pardus melas', 'image_url' => '../img/macantutul.jpg'],
                                    ['title' => 'Elang Jawa', 'description' => 'Nisaetus bartelsi', 'image_url' => '../img/elang-jawa.jpg']
                                ];
                            }
                            foreach ($fauna_data as $img): ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="gallery-item position-relative overflow-hidden rounded animate__animated animate__zoomIn">
                                        <img src="<?php echo htmlspecialchars($img['image_url']); ?>" alt="<?php echo htmlspecialchars($img['title']); ?>" class="img-fluid gallery-image" style="height: 200px; width: 100%; object-fit: cover;">
                                        <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end">
                                            <div class="p-3 text-white w-100">
                                                <h6 class="h4 text-white"><?php echo htmlspecialchars($img['title']); ?></h6>
                                                <small><?php echo htmlspecialchars($img['description']); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h4 class="text-primary fw-bold mb-3"><i class="fas fa-leaf me-2"></i>Flora Jawa Tengah</h4>
                        <div class="row g-3">
                            <?php
                            $flora_data = [];
                            if ($result_galeri && $result_galeri->num_rows > 0) {
                                mysqli_data_seek($result_galeri, 0);
                                while ($row = $result_galeri->fetch_assoc()) {
                                    if ($row['category'] == 'flora') {
                                        $flora_data[] = $row;
                                    }
                                }
                            } else {
                                $flora_data = [
                                    ['title' => 'Edelweis Jawa', 'description' => 'Anaphalis javanica', 'image_url' => '../img/edelweis.jpeg'],
                                    ['title' => 'Bunga Kantil', 'description' => 'Michelia alba', 'image_url' => '../img/kantil.jpeg'],
                                    ['title' => 'Anggrek Jawa', 'description' => 'Phalaenopsis javanica', 'image_url' => '../img/anggrek.jpeg'],
                                    ['title' => 'Pakis Jawa', 'description' => 'Cyathea contaminans', 'image_url' => '../img/pakis.jpg'],

                                ];
                            }
                            foreach ($flora_data as $img): ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="gallery-item position-relative overflow-hidden rounded animate__animated animate__zoomIn">
                                        <img src="<?php echo htmlspecialchars($img['image_url']); ?>" alt="<?php echo htmlspecialchars($img['title']); ?>" class="img-fluid gallery-image" style="height: 200px; width: 100%; object-fit: cover;">
                                        <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end">
                                            <div class="p-3 text-white w-100">
                                                <h6 class="h4 text-white"><?php echo htmlspecialchars($img['title']); ?></h6>
                                                <small><?php echo htmlspecialchars($img['description']); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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

        $(document).ready(function() {
            let counterTriggered = false;

            $(window).scroll(function() {
                if (!counterTriggered && $('.stats-section').offset().top - $(window).scrollTop() < $(window).height()) {
                    $('[data-toggle="counter-up"]').counterUp({
                        delay: 10,
                        time: 2000
                    });
                    counterTriggered = true;
                }
            });

            // Tab click animation
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const targetPane = $(e.target.getAttribute('data-bs-target'));
                targetPane.hide().fadeIn(500);
            });
        });
    </script>
</body>

</html>