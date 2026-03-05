<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Menggunakan jalur relatif yang benar karena file ini berada di folder 'User'
include '../simaksi-db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama      = $_POST["nama"] ?? '';
    $identitas = $_POST["identitas"] ?? '';
    $email     = $_POST["email"] ?? '';
    $telepon   = $_POST["telepon"] ?? '';
    $tanggal   = $_POST["tanggal"] ?? '';
    $lokasi    = $_POST["lokasi"] ?? '';
    $tujuan    = $_POST["tujuan"] ?? '';

    $sql = "INSERT INTO pendaftaran_simaksi (nama, identitas, email, telepon, tanggal_kegiatan, lokasi, tujuan) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        header("Location: daftar-simaksi.php?status=error&msg=" . urlencode($conn->error));
        exit();
    }
    
    if (!$stmt->bind_param("sssssss", $nama, $identitas, $email, $telepon, $tanggal, $lokasi, $tujuan)) {
        header("Location: daftar-simaksi.php?status=error&msg=" . urlencode($stmt->error));
        exit();
    }
    
    if ($stmt->execute()) {
        header("Location: simaksi-berhasil.php?status=success");
        exit();
    } else {
        header("Location: daftar-simaksi.php?status=error&msg=" . urlencode($stmt->error));
        exit();
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: daftar-simaksi.php?status=error&msg=" . urlencode("Akses tidak diizinkan."));
    exit();
}
?>