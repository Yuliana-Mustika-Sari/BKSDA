<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../db-connect-admin.php';

$status_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = ($_POST['role'] === 'admin') ? 'admin' : 'user';

    if (empty($username) || empty($password)) {
        $status_message = 'Username dan password wajib diisi.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $hash, $role);
        if ($stmt->execute()) {
            header('Location: kelola-pengguna.php');
            exit();
        } else {
            $status_message = 'Gagal menambah pengguna: ' . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Pengguna - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background:#f0f2f5; }
    .content-wrapper { margin-left:250px; padding:30px; }
    .data-card { background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,.05); }
  </style>
</head>
<body>
  <div class="admin-wrapper">
    <?php include __DIR__ . '/_admin_nav.php'; ?>
    <div class="content-wrapper">
      <div class="admin-header mb-3">
        <h4 class="mb-0 text-primary">Tambah Pengguna</h4>
        <p class="text-muted mb-0">Buat akun baru untuk aplikasi.</p>
      </div>

      <div class="container-fluid">
        <div class="data-card">
          <?php if (!empty($status_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($status_message); ?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3"><label class="form-label">Username</label><input class="form-control" name="username" required></div>
            <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
            <div class="mb-3"><label class="form-label">Role</label>
              <select name="role" class="form-select"><option value="user">User</option><option value="admin">Admin</option></select>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary">Buat Pengguna</button>
              <a href="kelola-pengguna.php" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
