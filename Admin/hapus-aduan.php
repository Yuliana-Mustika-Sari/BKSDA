<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$db_path = __DIR__ . '/../db-connect-admin.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Error: File koneksi database tidak ditemukan.");
}

$aduan_id = $_GET['id'] ?? null;
$hapus_semua = $_POST['hapus_semua'] ?? null;

if ($aduan_id) {
    // Logika untuk menghapus satu aduan
    $sql = "DELETE FROM aduan WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $aduan_id);
        
        if ($stmt->execute()) {
            $_SESSION['status_message'] = "Aduan berhasil dihapus.";
            $_SESSION['status_type'] = 'success';
        } else {
            $_SESSION['status_message'] = "Gagal menghapus aduan. Error: " . $stmt->error;
            $_SESSION['status_type'] = 'danger';
        }
        $stmt->close();
    } else {
        $_SESSION['status_message'] = "Gagal menyiapkan statement: " . $conn->error;
        $_SESSION['status_type'] = 'danger';
    }
} elseif ($hapus_semua) {
    // Logika untuk menghapus semua aduan
    $sql = "DELETE FROM aduan";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['status_message'] = "Semua aduan berhasil dihapus.";
        $_SESSION['status_type'] = 'success';
    } else {
        $_SESSION['status_message'] = "Gagal menghapus semua aduan. Error: " . $conn->error;
        $_SESSION['status_type'] = 'danger';
    }
} else {
    $_SESSION['status_message'] = "Aksi tidak valid.";
    $_SESSION['status_type'] = 'warning';
}

$conn->close();
header("Location: aduan.php");
exit();
?>