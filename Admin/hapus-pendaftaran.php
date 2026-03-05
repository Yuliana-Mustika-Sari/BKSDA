<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Sertakan file koneksi database
include '../simaksi-db.php'; 

// Periksa apakah ada parameter 'id' atau parameter 'hapus_semua'
$pendaftaran_id = $_GET['id'] ?? null;
$hapus_semua = $_POST['hapus_semua'] ?? null;

if ($pendaftaran_id) {
    // Logika untuk menghapus satu data
    $sql = "DELETE FROM pendaftaran_simaksi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $pendaftaran_id);
        
        if ($stmt->execute()) {
            $_SESSION['pesan_status'] = "Data pendaftaran berhasil dihapus.";
            $_SESSION['tipe_status'] = 'success';
        } else {
            $_SESSION['pesan_status'] = "Gagal menghapus data pendaftaran. Error: " . $stmt->error;
            $_SESSION['tipe_status'] = 'danger';
        }
        $stmt->close();
    } else {
        $_SESSION['pesan_status'] = "Gagal menyiapkan statement: " . $conn->error;
        $_SESSION['tipe_status'] = 'danger';
    }
} elseif ($hapus_semua) {
    // Logika untuk menghapus semua data
    $sql = "DELETE FROM pendaftaran_simaksi";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['pesan_status'] = "Semua data pendaftaran berhasil dihapus.";
        $_SESSION['tipe_status'] = 'success';
    } else {
        $_SESSION['pesan_status'] = "Gagal menghapus semua data. Error: " . $conn->error;
        $_SESSION['tipe_status'] = 'danger';
    }
} else {
    $_SESSION['pesan_status'] = "Aksi tidak valid.";
    $_SESSION['tipe_status'] = 'warning';
}

$conn->close();
header("Location: data-pendaftaran.php");
exit();
?>