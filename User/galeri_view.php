<?php
// simple gallery viewer that reads gallery items from DB
session_start();

$db_path = __DIR__ . '/../db-connect-admin.php';
if (!file_exists($db_path)) {
    die("Error: koneksi database tidak ditemukan.");
}
include $db_path; // provides $conn

$sql = "SELECT id, title, description, peraturan, image_url, created_at FROM galleries WHERE status = 'published' ORDER BY created_at DESC";
$result = $conn->query($sql);
$items = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Galeri - BKSDA Jateng</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4">Galeri</h1>
    <?php if (empty($items)): ?>
      <div class="alert alert-info">Belum ada item galeri.</div>
    <?php else: ?>
      <div class="row g-3">
        <?php foreach ($items as $it): ?>
          <div class="col-sm-6 col-md-4">
            <div class="card">
              <img src="../<?php echo htmlspecialchars($it['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($it['title']); ?>" style="height:220px;object-fit:cover;">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($it['title']); ?></h5>
                <p class="card-text"><?php echo nl2br(htmlspecialchars($it['description'])); ?></p>
                <?php if (!empty($it['peraturan'])): ?>
                  <p class="small text-muted mb-0"><strong>Peraturan:</strong> <?php echo nl2br(htmlspecialchars($it['peraturan'])); ?></p>
                <?php endif; ?>
                <p class="small text-muted mt-2">Diunggah: <?php echo htmlspecialchars($it['created_at']); ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
