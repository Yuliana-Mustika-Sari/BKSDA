<?php
session_start();
// Cek login admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') { header("Location: ../login.php"); exit(); }

include '../db-connect-admin.php';
$result = $conn->query("SELECT id, nomor_registrasi, nama_pelapor, jenis_satwa, status_kasus, tanggal_laporan FROM konflik_satwa ORDER BY tanggal_laporan DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Data Laporan Konflik - Admin</title>
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
            <h4 class="mb-0 text-primary">Data Laporan Konflik Satwa</h4>
            <p class="text-muted mb-0">Kelola laporan konflik satwa yang masuk.</p>
        </div>

        <div class="container-fluid">
            <div class="data-card p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No. Laporan</th>
                                <th>Pelapor</th>
                                <th>Jenis Satwa</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nomor_registrasi']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_pelapor']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jenis_satwa']); ?></td>
                                    <td><span class="badge bg-info"><?php echo htmlspecialchars($row['status_kasus']); ?></span></td>
                                    <td><?php echo htmlspecialchars(date('d M Y', strtotime($row['tanggal_laporan']))); ?></td>
                                    <td>
                                        <a href="detail-konflik.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary me-1"><i class="fas fa-search me-1"></i> Detail</a>
                                        <a href="hapus-konflik.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus laporan konflik ini? Tindakan ini tidak dapat dibatalkan.');"><i class="fas fa-trash me-1"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>