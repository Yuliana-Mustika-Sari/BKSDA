<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../db-connect-admin.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: data-konflik.php?status=invalid');
    exit();
}

// Fetch file path (if any) before deleting
$stmt = $conn->prepare('SELECT url_dokumentasi FROM konflik_satwa WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if ($row) {
    $url = $row['url_dokumentasi'];
    // Try to resolve possible paths and remove file
    if (!empty($url)) {
        $candidates = [];
        // If stored path already contains uploads/konflik
        if (strpos($url, 'uploads/konflik') !== false) {
            $candidates[] = __DIR__ . '/../' . $url;
        }
        // also try base filename under uploads/konflik
        $candidates[] = __DIR__ . '/../uploads/konflik/' . basename($url);

        foreach ($candidates as $file) {
            if (file_exists($file) && is_file($file)) {
                @unlink($file);
            }
        }
    }

    // Delete any tindak_lanjut_konflik rows related
    $delHist = $conn->prepare('DELETE FROM tindak_lanjut_konflik WHERE id_laporan_konflik = ?');
    $delHist->bind_param('i', $id);
    $delHist->execute();
    $delHist->close();

    // Delete main report
    $del = $conn->prepare('DELETE FROM konflik_satwa WHERE id = ?');
    $del->bind_param('i', $id);
    $ok = $del->execute();
    $del->close();

    $conn->close();

    if ($ok) {
        header('Location: data-konflik.php?status=deleted');
        exit();
    }
}

$conn->close();
header('Location: data-konflik.php?status=error');
exit();
