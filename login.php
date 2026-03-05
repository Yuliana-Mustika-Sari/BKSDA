<?php
session_start();
include 'db-connect-admin.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: Admin/dashboard.php");
            } else if ($role === 'user') { // Tambahkan kondisi ini
                header("Location: index.php"); // Ganti dengan halaman yang sesuai
            } else {
                header("Location: index.php"); // Untuk role selain admin dan user
            }
            exit;
        } else {
            $message = "Nama pengguna atau kata sandi salah.";
        }
    } else {
        $message = "Nama pengguna atau kata sandi salah.";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Balai Konservasi Sumber Daya Alam - Login</title>
    <link rel="icon" type="image/png" href="img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/gunung.jpg') no-repeat center center;
            background-size: cover;
            position: relative;
            z-index: 1;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card card p-5 shadow-sm">
            <div class="text-center mb-4">
                <img src="img/logo2.png" alt="Logo BKSDA Jawa Tengah" style="width: 80px; height: auto;" class="mb-3">
                <h1 class="h3 mb-3 fw-bold text-primary">Login Admin</h1>
            </div>
            <?php
            if (!empty($message)) {
                echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($message) . '</div>';
            }
            if (isset($_GET['status']) && $_GET['status'] == 'registered') {
                echo '<div class="alert alert-success" role="alert">Registrasi berhasil! Silakan login.</div>';
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3">Login</button>
            </form>
            <div class="mt-3 text-center">
                <p class="mb-0">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
            </div>
        </div>
    </div>
</body>
</html>