<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') { header("Location: ../login.php"); exit(); }

include '../db-connect-admin.php';
require_once 'notifikasi_helper.php'; // Panggil helper notifikasi

$id_laporan = $_GET['id'] ?? 0;

// Proses form saat admin submit tindak lanjut / ubah status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_tindakan'])) {
    $status_baru = $_POST['status'];
    $catatan_tindakan = $_POST['catatan_tindakan'];
    $petugas = $_SESSION['username']; // Ambil nama admin yang login

    // 1. Update status di tabel utama
    $stmt_update = $conn->prepare("UPDATE konflik_satwa SET status_kasus = ? WHERE id = ?");
    $stmt_update->bind_param("si", $status_baru, $id_laporan);
    $stmt_update->execute();
    
    // 2. Simpan catatan tindak lanjut ke tabel riwayat
    if (!empty($catatan_tindakan)) {
        $stmt_tindakan = $conn->prepare("INSERT INTO tindak_lanjut_konflik (id, petugas, catatan_tindakan) VALUES (?, ?, ?)");
        $stmt_tindakan->bind_param("iss", $id_laporan, $petugas, $catatan_tindakan);
        $stmt_tindakan->execute();
    }

    // 3. Kirim notifikasi email ke pelapor
    $result_laporan = $conn->query("SELECT email_pelapor, nomor_registrasi FROM konflik_satwa WHERE id = $id_laporan");
    $data_laporan = $result_laporan->fetch_assoc();
    if (!empty($data_laporan['email_pelapor'])) {
        kirimNotifikasiStatus($data_laporan['email_pelapor'], $data_laporan['nomor_registrasi'], $status_baru);
    }
    
    header("Location: detail-konflik.php?id=$id_laporan&pesan=sukses");
    exit();
}

// Ambil data laporan dan riwayat tindak lanjutnya
$laporan = $conn->query("SELECT * FROM konflik_satwa WHERE id = $id_laporan")->fetch_assoc();
$riwayat = $conn->query("SELECT * FROM tindak_lanjut_konflik WHERE id = $id_laporan ORDER BY tanggal_tindakan DESC");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Laporan Konflik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Detail Laporan #<?php echo htmlspecialchars($laporan['nomor_registrasi']); ?></h3>
        <a href="data-konflik.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>
    <?php if(isset($_GET['pesan'])): ?><div class="alert alert-success">Perubahan berhasil disimpan!</div><?php endif; ?>

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header">Detail Laporan</div>
                <div class="card-body">
                    <p><strong>Pelapor:</strong> <?php echo $laporan['nama_pelapor']; ?></p>
                    <p><strong>Lokasi:</strong> <?php echo $laporan['lokasi_deskripsi']; ?></p>
                    <?php if ($laporan['url_dokumentasi']): ?>
                        <p><strong>Foto Bukti:</strong></p>
                        <img src="../<?php echo $laporan['url_dokumentasi']; ?>" class="img-fluid rounded">
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Riwayat Tindak Lanjut</div>
                <ul class="list-group list-group-flush">
                    <?php while($tindakan = $riwayat->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong><?php echo date('d M Y, H:i', strtotime($tindakan['tanggal_tindakan'])); ?></strong> oleh <strong><?php echo $tindakan['petugas']; ?></strong>
                        <p class="mb-0"><?php echo nl2br($tindakan['catatan_tindakan']); ?></p>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Tindakan Admin</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Ubah Status Laporan</label>
                            <select name="status" class="form-select">
                                <option value="Baru" <?php if($laporan['status_kasus'] == 'Baru') echo 'selected'; ?>>Baru</option>
                                <option value="Verifikasi" <?php if($laporan['status_kasus'] == 'Verifikasi') echo 'selected'; ?>>Verifikasi</option>
                                <option value="Penanganan" <?php if($laporan['status_kasus'] == 'Penanganan') echo 'selected'; ?>>Penanganan</option>
                                <option value="Selesai" <?php if($laporan['status_kasus'] == 'Selesai') echo 'selected'; ?>>Selesai</option>
                                <option value="Monitoring" <?php if($laporan['status_kasus'] == 'Monitoring') echo 'selected'; ?>>Monitoring</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tambah Catatan Tindak Lanjut</label>
                            <textarea name="catatan_tindakan" class="form-control" rows="6" placeholder="Contoh: Tim SKW I telah dikerahkan ke lokasi untuk verifikasi."></textarea>
                        </div>
                        <button type="submit" name="submit_tindakan" class="btn btn-success w-100">Simpan Tindakan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>