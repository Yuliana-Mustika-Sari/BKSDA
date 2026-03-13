<?php
session_start();

$is_loggedin = isset($_SESSION['loggedin']);
$is_guest = !isset($_SESSION['loggedin']);

require_once __DIR__ . '/../db-connect-admin.php';

$items = [];

$stmt = $conn->prepare("
SELECT id, judul, jenis, nomor, tahun, ringkasan, file_path, url_sumber, tags, lingkup, created_at
FROM peraturan
WHERE status='published'
ORDER BY created_at DESC
");

if ($stmt && $stmt->execute()) {
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $items[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Peraturan - BKSDA Jawa Tengah</title>
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

<body class="bg-light">
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
                <h1 class="text-white display-2 mb-4 animated-text fw-bold">Peraturan Perundang - Undangan</h1>
                <p class="fs-4 text-white mb-4 animated-text">Balai Konservasi Sumber Daya Alam Jawa Tengah</p>
                <p class="fs-6 text-white-50 animated-text">Daftar peraturan terkait konservasi dan pengelolaan sumber daya alam</p>
            </div>
        </div>
    </div>>
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <input id="searchBox" type="text" class="form-control" placeholder="Cari peraturan...">
                    <button id="clearSearch" class="btn btn-outline-secondary">
                        Clear
                    </button>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <select id="filterLingkup" class="form-select w-auto d-inline-block">
                    <option value="">Semua Lingkup</option>
                    <?php
                    $lingkups = [];
                    foreach ($items as $it) {
                        if (!empty($it['lingkup'])) {
                            foreach (explode(',', $it['lingkup']) as $l) {
                                $lingkups[trim($l)] = true;
                            }
                        }
                    }
                    foreach (array_keys($lingkups) as $lk) {
                        echo "<option value='$lk'>$lk</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row" id="peraturanList">
            <?php if (empty($items)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        Belum ada peraturan tersedia di database. Berikut satu contoh peraturan resmi:
                    </div>
                </div>
                
            <?php else: ?>
                <?php foreach ($items as $it): ?>
                    <div class="col-lg-6 mb-4 peraturan-item"
                        data-tags="<?= htmlspecialchars($it['tags']) ?>"
                        data-lingkup="<?= htmlspecialchars($it['lingkup']) ?>">
                        <div class="card shadow-sm h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($it['judul']) ?> 
                                </h5>
                                <div class="text-muted small mb-2">
                                    <?= htmlspecialchars($it['jenis']) ?> Nomor 
                                    <?= htmlspecialchars($it['nomor']) ?> Tahun
                                    <?= htmlspecialchars($it['tahun']) ?>
                                </div>
                                <p>
                                    <?= htmlspecialchars(mb_strimwidth($it['ringkasan'], 0, 200, '...')) ?>
                                </p>
                            </div>
                            <div class="card-footer bg-white border-0 d-flex justify-content-between">
                                <div>
                                    <?php if (!empty($it['file_path'])): ?>
                                        <a href="../<?= $it['file_path'] ?>" target="_blank" class="btn btn-sm btn-primary">
                                            Unduh PDF
                                        </a>
                                    <?php elseif (!empty($it['url_sumber'])): ?>
                                        <a href="<?= $it['url_sumber'] ?>" target="_blank" class="btn btn-sm btn-primary">
                                            Lihat Sumber
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted">
                                    <?= date('d M Y', strtotime($it['created_at'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
        (function($) {
            function filterList() {
                var q = $('#searchBox').val().toLowerCase();
                var lingkup = $('#filterLingkup').val();
                $('.peraturan-item').each(function() {
                    var el = $(this);
                    var text = el.text().toLowerCase();
                    var itemLingkup = el.data('lingkup');
                    var matchQ = q === '' || text.indexOf(q) !== -1;
                    var matchLingkup = lingkup === '' || itemLingkup.indexOf(lingkup) !== -1;
                    if (matchQ && matchLingkup) {
                        el.show();
                    } else {
                        el.hide();
                    }
                });
            }
            $('#searchBox').on('input', filterList);
            $('#filterLingkup').on('change', filterList);
            $('#clearSearch').on('click', function() {
                $('#searchBox').val('');
                $('#filterLingkup').val('');
                filterList();
            });
        })(jQuery);
    </script>


</body>

</html>