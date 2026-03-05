<?php
session_start();

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Anda tidak lagi memerlukan koneksi ke simaksi-db.php di halaman ini
// include 'simaksi-db.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam - Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="admin-wrapper">
        <?php include __DIR__ . '/_admin_nav.php'; ?>
        <div class="content-wrapper">
            <div class="admin-header">
                <h4 class="mb-0 text-primary">Selamat Datang di Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h4>
                <p class="text-muted mb-0">Kelola semua aspek website Anda dengan mudah di sini.</p>
            </div>

            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-menu h-100 shadow-sm text-center">
                            <i class="fas fa-edit fa-4x mb-3"></i>
                            <h5 class="fw-bold">Kelola Konten Website</h5>
                            <p class="text-muted small">Perbarui Visi, Misi, Sejarah, dll.</p>
                            <a href="edit-content.php" class="btn btn-primary mt-auto">Masuk</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-menu h-100 shadow-sm text-center">
                            <i class="fas fa-file-alt fa-4x mb-3"></i>
                            <h5 class="fw-bold">Kelola Pendaftaran SIMAKSI</h5>
                            <p class="text-muted small">Lihat dan cetak pendaftaran SIMAKSI.</p>
                            <a href="data-pendaftaran.php" class="btn btn-primary mt-auto">Masuk</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-menu h-100 shadow-sm text-center">
                            <i class="fas fa-exclamation-triangle fa-4x mb-3"></i>
                            <h5 class="fw-bold">Kelola Laporan Konflik</h5>
                            <p class="text-muted small">Tinjau laporan konflik satwa.</p>
                            <a href="data-konflik.php" class="btn btn-primary mt-auto">Masuk</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-menu h-100 shadow-sm text-center">
                            <i class="fas fa-comment-dots fa-4x mb-3"></i>
                            <h5 class="fw-bold">Kelola Pengaduan</h5>
                            <p class="text-muted small">Tanggapi pertanyaan dari pengguna.</p>
                            <a href="aduan.php" class="btn btn-primary mt-auto">Masuk</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-menu h-100 shadow-sm text-center">
                            <i class="fas fa-images fa-4x mb-3"></i>
                            <h5 class="fw-bold">Kelola Galeri</h5>
                            <p class="text-muted small">Kelola foto dan video di galeri website.</p>
                            <a href="kelola-galeri.php" class="btn btn-primary mt-auto">Masuk</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-menu h-100 shadow-sm text-center">
                            <i class="fas fa-user fa-4x mb-3"></i>
                            <h5 class="fw-bold">Kelola Pengguna</h5>
                            <p class="text-muted small">Kelola akun pengguna sistem.</p>
                            <a href="kelola-pengguna.php" class="btn btn-primary mt-auto">Masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>