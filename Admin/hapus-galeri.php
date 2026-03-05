<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../db-connect-admin.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: kelola-galeri.php');
    exit();
}

$stmt = $conn->prepare('SELECT image_url FROM galleries WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if ($row) {
    $image_url = $row['image_url'];
    // delete file
    if (!empty($image_url) && file_exists(__DIR__ . '/../' . $image_url)) {
        @unlink(__DIR__ . '/../' . $image_url);
    }
    $del = $conn->prepare('DELETE FROM galleries WHERE id = ?');
    $del->bind_param('i', $id);
    $del->execute();
    $del->close();
}

$conn->close();
header('Location: kelola-galeri.php');
exit();
