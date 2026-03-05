<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../db-connect-admin.php';

// Ambil data pengguna
$sql = "SELECT id, username, role FROM users ORDER BY id DESC";
$result = $conn->query($sql);
$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();

function roleBadge($role)
{
    switch ($role) {
        case 'admin':
            return 'danger';
        case 'user':
            return 'primary';
        default:
            return 'secondary';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kelola Pengguna - Admin Dashboard</title>
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
                <h4 class="mb-0 text-primary">Kelola Pengguna</h4>
                <p class="text-muted mb-0">Lihat, kelola, dan hapus pengguna aplikasi.</p>
            </div>

            <div class="container-fluid">
                <div class="data-card p-4">
                    <div class="mb-3">
                        <a href="tambah-pengguna.php" class="btn btn-success"><i class="fas fa-user-plus me-1"></i> Tambah Pengguna</a>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php $i = 1;
                                foreach ($users as $u): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                                        <td><span class="badge bg-<?php echo roleBadge($u['role']); ?>"><?php echo htmlspecialchars($u['role']); ?></span></td>
                                        <td>
                                            <a href="detail-pengguna.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-info"><i class="fas fa-search me-1"></i> Detail</a>
                                            <a href="hapus-pengguna.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengguna ini?');"><i class="fas fa-trash me-1"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada pengguna.</td>
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