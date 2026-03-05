<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../db-connect-admin.php';

$status_message = '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: kelola-galeri.php');
    exit();
}

$stmt = $conn->prepare('SELECT id, title, description, peraturan, image_url, status FROM galleries WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$item = $res->fetch_assoc();
$stmt->close();

if (!$item) {
    header('Location: kelola-galeri.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $peraturan = trim($_POST['peraturan']);
    $status = in_array($_POST['status'] ?? '', ['published','draft']) ? $_POST['status'] : 'draft';

    $image_url = $item['image_url'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = '../uploads/galeri/';
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // remove old file if exists
            if (!empty($image_url) && file_exists(__DIR__ . '/../' . $image_url)) {
                @unlink(__DIR__ . '/../' . $image_url);
            }
            $image_url = 'uploads/galeri/' . $filename;
        } else {
            $status_message = 'Gagal mengunggah gambar baru.';
        }
    }

    if (empty($title)) {
        $status_message = 'Judul wajib diisi.';
    }

    if (empty($status_message)) {
        $sql = 'UPDATE galleries SET title = ?, description = ?, peraturan = ?, image_url = ?, status = ?, updated_at = NOW() WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $title, $description, $peraturan, $image_url, $status, $id);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header('Location: kelola-galeri.php');
            exit();
        } else {
            $status_message = 'Gagal menyimpan perubahan: ' . $stmt->error;
            $stmt->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Galeri - Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; }
        .admin-wrapper { display:flex; min-height:100vh; }
        .sidebar { width:250px; background-color:var(--bs-primary); color:#fff; padding:20px; position:fixed; height:100%; overflow-y:auto; }
        .sidebar-header img { width:80px; height:auto; }
        .nav-link { color: rgba(255,255,255,0.8); }
        .nav-link:hover, .nav-link.active { color:#fff; background-color: rgba(0,0,0,0.12); }
        .content-wrapper { margin-left:250px; padding:30px; width:100%; }
        .data-card { border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,.05); background:#fff; padding:20px; }
        img.current-thumb { max-width:240px; display:block; margin-bottom:8px; border-radius:6px; }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include __DIR__ . '/_admin_nav.php'; ?>

        <div class="content-wrapper">
            <div class="admin-header">
                <h4 class="mb-0 text-primary">Edit Item Galeri</h4>
                <p class="text-muted mb-0">Perbarui informasi dan gambar item galeri.</p>
            </div>

            <div class="container-fluid mt-4">
                <div class="data-card p-4">
                    <?php if (!empty($status_message)): ?>
                      <div class="alert alert-danger"><?php echo $status_message; ?></div>
                    <?php endif; ?>
                    <form method="post" enctype="multipart/form-data">
                      <div class="mb-3"><label class="form-label">Judul</label><input class="form-control" name="title" value="<?php echo htmlspecialchars($item['title']); ?>" required></div>
                      <div class="mb-3"><label class="form-label">Deskripsi</label><textarea class="form-control" name="description"><?php echo htmlspecialchars($item['description']); ?></textarea></div>
                      <div class="mb-3"><label class="form-label">Peraturan (opsional)</label><textarea class="form-control" name="peraturan"><?php echo htmlspecialchars($item['peraturan']); ?></textarea></div>
                      <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label><br>
                        <?php if (!empty($item['image_url'])): ?>
                          <img src="../<?php echo htmlspecialchars($item['image_url']); ?>" class="current-thumb" alt="">
                        <?php endif; ?>
                        <label class="form-label">Ganti Gambar (opsional)</label>
                        <input type="file" name="image" accept="image/*">
                      </div>
                      <div class="mb-3"><label class="form-label">Status</label>
                        <select name="status" class="form-select"><option value="published" <?php echo $item['status']=='published'?'selected':''; ?>>Published</option><option value="draft" <?php echo $item['status']=='draft'?'selected':''; ?>>Draft</option></select>
                      </div>
                      <div class="d-flex gap-2">
                        <button class="btn btn-primary">Simpan Perubahan</button>
                        <a href="kelola-galeri.php" class="btn btn-secondary">Batal</a>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
