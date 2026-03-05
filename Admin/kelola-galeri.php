<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../db-connect-admin.php';

$sql = "SELECT id, title, image_url, status, created_at FROM galleries ORDER BY created_at DESC";
$result = $conn->query($sql);
$items = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Kelola Galeri - Admin Dashboard</title>
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
        <h4 class="mb-0 text-primary">Kelola Galeri</h4>
        <p class="text-muted mb-0">Tambahkan, sunting, atau hapus item galeri.</p>
      </div>

      <div class="container-fluid mt-4">
        <div class="data-card p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Daftar Item Galeri</h5>
            <div>
              <a href="tambah-galeri.php" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Tambah Item Galeri</a>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th style="width:60px;">#</th>
                  <th>Judul</th>
                  <th>Gambar</th>
                  <th>Status</th>
                  <th>Diunggah</th>
                  <th style="width:180px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($items)): ?>
                  <tr><td colspan="6" class="text-center">Belum ada item.</td></tr>
                <?php else: $i = 1; foreach ($items as $it): ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($it['title']); ?></td>
                    <td><img src="../<?php echo htmlspecialchars($it['image_url']); ?>" alt="" class="thumb"></td>
                    <td><?php echo htmlspecialchars($it['status']); ?></td>
                    <td><?php echo htmlspecialchars($it['created_at']); ?></td>
                    <td>
                      <a href="edit-galeri.php?id=<?php echo $it['id']; ?>" class="btn btn-sm btn-info me-1"><i class="fas fa-edit me-1"></i> Edit</a>
                      <a href="hapus-galeri.php?id=<?php echo $it['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item galeri?');"><i class="fas fa-trash me-1"></i> Hapus</a>
                    </td>
                  </tr>
                <?php endforeach; endif; ?>
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
