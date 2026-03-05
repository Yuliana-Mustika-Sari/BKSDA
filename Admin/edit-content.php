<?php
session_start();
// simple access control: allow only logged-in admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// include database connection (should define $conn as mysqli)
include __DIR__ . '/../db-connect-admin.php';

// generate or check CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // basic CSRF protection
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token mismatch.');
    }

    // Expect arrays: id[], page_slug[], section_id[], title[], content[]
    $ids = $_POST['id'] ?? [];
    $titles = $_POST['title'] ?? [];
    $contents = $_POST['content'] ?? [];

    // prepare update statement
    $stmt = $conn->prepare("UPDATE web_content SET title = ?, content = ? WHERE id = ?");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    // loop through submitted items and update
    for ($i = 0; $i < count($ids); $i++) {
        $id = intval($ids[$i]);
        $title = trim($titles[$i] ?? '');
        $contentVal = trim($contents[$i] ?? '');

        // basic validation
        if ($id <= 0) continue;

        $stmt->bind_param('ssi', $title, $contentVal, $id);
        if (!$stmt->execute()) {
            // you may want to log errors instead of dying
            error_log("Failed to update id=$id : " . $stmt->error);
        }
    }
    $stmt->close();

    // regenerate CSRF token after successful POST
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // redirect to avoid resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// fetch current content entries
$sql = "SELECT id, page_slug, section_id, title, profile, content FROM web_content ORDER BY page_slug, section_id, id";
$result = $conn->query($sql);
$entries = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit Konten Website - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <?php include __DIR__ . '/_admin_nav.php'; ?>
    <div class="admin-wrapper">

        <div class="content-wrapper">
            <div class="admin-header mb-3">
                <h4 class="mb-0 text-primary">Edit Konten Website</h4>
                <p class="text-muted mb-0">Perbarui teks dan bagian konten untuk halaman publik.</p>
            </div>

            <div class="container-fluid">
                <div class="data-card p-4">
                    <?php if (empty($entries)): ?>
                        <div class="alert alert-info">Belum ada konten tersimpan.</div>
                    <?php else: ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php foreach ($entries as $index => $item): ?>
                                <div class="mb-4 entry-box">
                                    <input type="hidden" name="id[]" value="<?php echo (int)$item['id']; ?>">

                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label">Halaman - Section</label>
                                            <input class="form-control" type="text" readonly value="<?php echo htmlspecialchars($item['page_slug'] . ' - ' . $item['section_id']); ?>">
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Judul (title)</label>
                                            <input class="form-control" type="text" name="title[]" value="<?php echo htmlspecialchars($item['title']); ?>">
                                        </div>
                                    </div>

                                    <label class="form-label mt-2">Isi Konten</label>
                                    <textarea name="content[]" class="form-control" rows="6"><?php echo htmlspecialchars($item['content']); ?></textarea>
                                    
                                    <label class="form-label mt-2">Profile</label>
                                    <textarea name="profile[]" class="form-control" rows="6"><?php echo htmlspecialchars($item['profile']); ?></textarea>
                                </div>
                            <?php endforeach; ?>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>