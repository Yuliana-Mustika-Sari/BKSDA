<?php
session_start();

// Simple detail page for news items. Tries DB first, falls back to sample data.
$db_path = __DIR__ . '/db-connect-admin.php';
$news_item = null;

if (file_exists($db_path)) {
    include $db_path;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int) $_GET['id'];
        $stmt = $conn->prepare("SELECT id, title, content, created_date FROM news WHERE id = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $res->num_rows > 0) {
                $news_item = $res->fetch_assoc();
            }
            $stmt->close();
        }
    }
    $conn->close();
}

// Fallback sample data when DB not available or item not found
if (!$news_item) {
    $sample = [
        1 => [
            'id' => 1,
            'title' => 'Kolaborasi untuk Konservasi Kukang Jawa',
            'created_date' => '2025-08-12',
            'content' => 'Perhutani bersama BKSDA Provinsi Jawa Tengah telah melakukan pelepasliaran Kukang Jawa (Nycticebus javanicus) di hutan alam Kemuning. Upaya ini bertujuan untuk melestarikan Kukang di habitat yang sesuai agar dapat berkembang biak.'
        ],
        2 => [
            'id' => 2,
            'title' => 'Upaya Mengembalikan Pulau Bidadari Sebagai Habitat Penyu',
            'created_date' => '2025-05-15',
            'content' => 'BKSDA bersama Ancol berupaya mengembalikan Pulau Bidadari di Kepulauan Seribu sebagai tempat pendaratan penyu. Sekitar 200 ekor tukik (penyu sisik) telah dilepaskan.'
        ]
    ];
    $requested = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 1;
    $news_item = $sample[$requested] ?? array_values($sample)[0];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($news_item['title']); ?> - BKSDA JAWA TENGAH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
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
                    <a href="https://www.instagram.com/bksda_jateng/" class="btn-square text-white me-2" target="_blank"><i class="fab fa-instagram"></i></a>
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
        </div>
    </nav>
</div>

<div class="container py-5" style="margin-top:120px;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="interactive-card p-5">
                <h1 class="fw-bold text-primary mb-3"><?php echo htmlspecialchars($news_item['title']); ?></h1>
                <p class="text-muted mb-4"><?php echo date('d M Y', strtotime($news_item['created_date'] ?? date('Y-m-d'))); ?></p>
                <div class="news-content text-justify">
                    <?php echo nl2br(htmlspecialchars($news_item['content'])); ?>
                </div>
                <div class="mt-4">
                    <a href="sejarah.php" class="btn btn-outline-secondary">&larr; Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../lib/wow/wow.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
