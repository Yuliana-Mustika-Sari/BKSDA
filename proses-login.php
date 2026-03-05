<?php
session_start();
include 'db-connect-admin.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        header("Location: login.php?status=failed"); exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            if ($_SESSION['role'] === 'admin') {
                header("Location: Admin/dashboard.php");
            } elseif ($_SESSION['role'] === 'user') { // Tambahkan kondisi ini
                header("Location: User/dashboard.php"); // Ganti dengan halaman dashboard pengguna
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            header("Location: login.php?status=failed"); exit();
        }
    } else {
        header("Location: login.php?status=failed"); exit();
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php"); exit();
}
?>