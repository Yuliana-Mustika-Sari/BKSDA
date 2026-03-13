<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../db-connect-admin.php';

$items = [];
$stmt = $conn->prepare('SELECT id, judul, jenis, nomor, tahun, status, file_path, url_sumber, created_at FROM peraturan ORDER BY created_at DESC');
if ($stmt && $stmt->execute()) {
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $items[] = $row;
}
if ($stmt) $stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kelola Peraturan - Admin</title>
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
                <h4 class="mb-0 text-primary">Kelola Peraturan</h4>
                <p class="text-muted mb-0">Daftar peraturan yang tersimpan.</p>
            </div>

            <div class="container-fluid mt-4">
                <div class="data-card p-4">
                    <div class="mb-3"><a href="tambah-peraturan.php" class="btn btn-success">Tambah Peraturan</a></div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th>Nomor/Tahun</th>
                                    <th>File / Sumber</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $it): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($it['judul']); ?></td>
                                        <td><?php echo htmlspecialchars($it['jenis']); ?></td>
                                        <td><?php echo htmlspecialchars($it['nomor']) . ' ' . htmlspecialchars($it['tahun']); ?></td>
                                        <td>
                                            <?php if (!empty($it['file_path'])): ?>
                                                <a href="../<?php echo htmlspecialchars($it['file_path']); ?>" target="_blank">Unduh PDF</a>
                                            <?php elseif (!empty($it['url_sumber'])): ?>
                                                <a href="<?php echo htmlspecialchars($it['url_sumber']); ?>" target="_blank">Sumber</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($it['status']); ?></td>
                                        <td><?php echo htmlspecialchars($it['created_at']); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="tambah-peraturan.php?id=<?php echo $it['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form method="post" action="proses-hapus-peraturan.php" onsubmit="return confirm('Hapus peraturan ini? Tindakan tidak dapat dibatalkan.');" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo $it['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>