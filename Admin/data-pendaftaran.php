<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../simaksi-db.php';

// Ambil data pendaftaran dari database
$sql = "SELECT id, nomor_surat, nama, jenis_surat, tanggal_kegiatan_mulai, lokasi, status FROM pendaftaran_simaksi ORDER BY tanggal_dibuat DESC";
$result = $conn->query($sql);

$pendaftaran = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $pendaftaran[] = $row;
    }
}
$conn->close();

function getStatusBadge($status) {
    switch ($status) {
        case 'Disetujui':
            return 'success';
        case 'Ditolak':
            return 'danger';
        case 'Diproses':
            return 'warning';
        default:
            return 'primary';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Data Pendaftaran - Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    
    
</head>
<body>
    <div class="admin-wrapper">
        <?php include __DIR__ . '/_admin_nav.php'; ?>
        <div class="content-wrapper">
            <div class="admin-header">
                <h4 class="mb-0 text-primary">Data Pendaftaran SIMAKSI</h4>
                <p class="text-muted mb-0">Kelola dan cetak data pendaftaran SIMAKSI di sini.</p>
            </div>
            <div class="container-fluid">
                <div class="data-card p-4">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Surat</th>
                                <th>Nama Pemohon</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pendaftaran)): ?>
                                <?php $i = 1; foreach ($pendaftaran as $row): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nomor_surat'] ?? 'Belum Ada'); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars(ucwords($row['jenis_surat'])); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo getStatusBadge($row['status']); ?>">
                                            <?php echo htmlspecialchars($row['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="detail-pendaftaran.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-search me-1"></i> Detail
                                        </a>
                                        <a href="hapus-pendaftaran.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data pendaftaran.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>