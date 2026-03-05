<?php
session_start();

$is_loggedin = isset($_SESSION['loggedin']);

$db_path = __DIR__ . '/../db-connect-admin.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Error: File koneksi database tidak ditemukan.");
}

$status_message = '';
$status_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil semua data dari form
    $nama_pelapor = trim($_POST['nama']);
    $email_pelapor = trim($_POST['email']);
    $telepon_pelapor = trim($_POST['telepon']);
    $tanggal_kejadian = trim($_POST['tanggal_kejadian']);
    $lokasi_deskripsi = trim($_POST['lokasi']);
    $jenis_satwa = trim($_POST['jenis_satwa']);
    $deskripsi_kejadian = trim($_POST['pesan']);
    
    // Generate nomor registrasi unik
    $nomor_registrasi = 'K-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

    $url_dokumentasi = '';
    if (isset($_FILES['dokumentasi']) && $_FILES['dokumentasi']['error'] == 0) {
        $target_dir = "../uploads/konflik/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["dokumentasi"]["name"]);
        if (move_uploaded_file($_FILES["dokumentasi"]["tmp_name"], $target_file)) {
            $url_dokumentasi = "uploads/konflik/" . basename($_FILES["dokumentasi"]["name"]);
        }
    }

    if (empty($nama_pelapor) || empty($email_pelapor) || empty($lokasi_deskripsi) || empty($deskripsi_kejadian)) {
        $status_message = "Semua bidang bertanda bintang (*) harus diisi.";
        $status_type = 'danger';
    } else {
        $sql = "INSERT INTO konflik_satwa (nomor_registrasi, nama_pelapor, email_pelapor, telepon_pelapor, tanggal_kejadian, lokasi_deskripsi, jenis_satwa, deskripsi_kejadian, url_dokumentasi, status_kasus, tanggal_laporan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Baru', NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $nomor_registrasi, $nama_pelapor, $email_pelapor, $telepon_pelapor, $tanggal_kejadian, $lokasi_deskripsi, $jenis_satwa, $deskripsi_kejadian, $url_dokumentasi);

        if ($stmt->execute()) {
            $status_message = "Laporan Anda dengan nomor registrasi <strong>$nomor_registrasi</strong> berhasil dikirim! Terima kasih atas partisipasi Anda.";
            $status_type = 'success';
        } else {
            $status_message = "Gagal mengirim laporan. Silakan coba lagi nanti. Error: " . $stmt->error;
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
    <title>BKSDA Jawa Tengah - Lapor Konflik Satwa</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
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
    
    <div class="hero-section d-flex align-items-center">
        <div class="container hero-content text-center">
            <h1 class="text-white display-2 mb-4 fw-bold">Lapor Konflik Satwa</h1>
            <p class="fs-4 text-white mb-4">Partisipasi Anda sangat berarti untuk mitigasi konflik antara manusia dan satwa liar.</p>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-xl-6">
                    <div class="interactive-card h-100 p-5">
                        <h2 class="mb-4 text-primary fw-bold"><i class="fas fa-paw me-2"></i>Formulir Laporan Konflik</h2>
                        <p class="mb-4 text-muted">Gunakan formulir ini untuk melaporkan kejadian konflik antara manusia dan satwa liar di wilayah Anda.</p>
                        
                        <?php if (!empty($status_message)): ?>
                            <div class="alert alert-<?php echo $status_type; ?>" role="alert">
                                <?php echo $status_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                            <div class="row gx-4 gy-3">
                                <h5 class="mt-4 text-dark">Data Pelapor</h5>
                                <div class="col-md-6">
                                    <input type="text" class="form-control bg-light border-0 py-3 px-4" name="nama" placeholder="Nama Anda *" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control bg-light border-0 py-3 px-4" name="email" placeholder="Email Anda *" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control bg-light border-0 py-3 px-4" name="telepon" placeholder="Nomor Telepon">
                                </div>

                                <h5 class="mt-4 text-dark">Detail Kejadian</h5>
                                 <div class="col-md-6">
                                    <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian *</label>
                                    <input type="date" id="tanggal_kejadian" class="form-control bg-light border-0 py-3 px-4" name="tanggal_kejadian" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="jenis_satwa" class="form-label">Jenis Satwa *</label>
                                    <select id="jenis_satwa" name="jenis_satwa" class="form-select bg-light border-0 py-3 px-4" required>
                                        <option value="">Pilih Satwa...</option>
                                        <option value="Monyet Ekor Panjang">Monyet Ekor Panjang</option>
                                        <option value="Babi Hutan">Babi Hutan</option>
                                        <option value="Ular">Ular</option>
                                        <option value="Macan Tutul">Macan Tutul</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control bg-light border-0 py-3 px-4" name="lokasi" placeholder="Lokasi Detail Kejadian (Desa, Kecamatan) *" required>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control bg-light border-0 py-3 px-4" rows="4" name="pesan" placeholder="Deskripsi Singkat Kejadian *" required></textarea>
                                </div>
                                 <div class="col-12">
                                    <label for="dokumentasi" class="form-label">Unggah Dokumentasi (Foto/Video)</label>
                                    <input type="file" id="dokumentasi" class="form-control bg-light border-0" name="dokumentasi" accept="image/*,video/*">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3 px-5" type="submit">Kirim Laporan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                 <div class="col-xl-6">
                    <div class="h-100">
                        <div class="interactive-card p-4 d-flex align-items-start mb-4">
                            <div class="circle-icon me-3 flex-shrink-0"><i class="fas fa-map-marker-alt text-white"></i></div>
                            <div>
                                <h4 class="text-primary">Alamat Kantor</h4>
                                <p class="mb-0 text-muted">Jl. Dr. Suratmo No. 171, Manyaran, Semarang, Jawa Tengah</p>
                            </div>
                        </div>
                        <div class="interactive-card p-4">
                            <h4 class="text-primary mb-3">Lokasi Kami</h4>
                            <iframe class="w-100 rounded" style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.203744835084!2d110.38317861477322!3d-6.98522299495403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708aa43806173d%3A0x4770275037e90835!2sBalai%20KSDA%20Jawa%20Tengah!5e0!3m2!1sen!2sid!4v1634543210987!5m2!1sen!2sid" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <script src="../js/main.js"></script>

</body>
</html>