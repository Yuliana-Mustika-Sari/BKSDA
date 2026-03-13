<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../db-connect-admin.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    header('Location: kelola-peraturan.php');
    exit();
}

$id = intval($_POST['id']);

// Ambil file_path jika ada
$file_path = null;
$stmt = $conn->prepare('SELECT file_path FROM peraturan WHERE id = ? LIMIT 1');
if ($stmt) {
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if ($row) $file_path = $row['file_path'];
    }
    $stmt->close();
}

// Hapus record
$stmt = $conn->prepare('DELETE FROM peraturan WHERE id = ?');
if ($stmt) {
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        // Hapus file fisik jika ada
        if (!empty($file_path)) {
            $full = __DIR__ . '/../' . $file_path;
            if (file_exists($full)) @unlink($full);
        }
    }
    $stmt->close();
}

$conn->close();
header('Location: kelola-peraturan.php');
exit();
