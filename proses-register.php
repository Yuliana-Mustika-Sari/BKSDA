<?php
// Pastikan file db-connect-admin.php ada
require_once 'db-connect-admin.php'; 

// Cek apakah data form sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan hashing password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Periksa apakah username sudah ada di database
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Jika username sudah ada, kembalikan ke halaman register dengan pesan error
        header("Location: register.php?status=userexists");
        exit();
    } else {
        // Masukkan data pengguna baru ke database dengan role 'admin'
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')"); // Pastikan 'role' diatur menjadi 'admin'
        $stmt->bind_param("ss", $username, $hashed_password);
        
        if ($stmt->execute()) {
            // Jika berhasil, redirect ke halaman login
            header("Location: login.php?status=registered");
            exit();
        } else {
            // Jika gagal, kembalikan ke halaman register dengan pesan error
            header("Location: register.php?status=error");
            exit();
        }
    }
    
    $stmt->close();
    $conn->close();
} else {
    // Jika tidak ada data POST, kembalikan ke halaman register
    header("Location: register.php");
    exit();
}
?>