<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../db-connect-admin.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah-peraturan.php');
    exit();
}

$judul = trim($_POST['judul'] ?? '');
$nomor = trim($_POST['nomor'] ?? '');
$tahun = trim($_POST['tahun'] ?? null);
$jenis = trim($_POST['jenis'] ?? '');
$instansi = trim($_POST['instansi_penerbit'] ?? 'Kementerian Lingkungan Hidup dan Kehutanan');
$tanggal = trim($_POST['tanggal'] ?? null);
$ringkasan = trim($_POST['ringkasan'] ?? '');
$isi_teks = trim($_POST['isi_teks'] ?? '');
$url_sumber = trim($_POST['url_sumber'] ?? '');
$bahasa = trim($_POST['bahasa'] ?? 'ID');
$lingkup = trim($_POST['lingkup'] ?? '');
$tags = trim($_POST['tags'] ?? '');
$status = in_array($_POST['status'] ?? '', ['published','draft']) ? $_POST['status'] : 'draft';
$related_gallery_id = !empty($_POST['related_gallery_id']) ? intval($_POST['related_gallery_id']) : null;
$created_by = $_SESSION['user_id'] ?? null;

$id = !empty($_POST['id']) ? intval($_POST['id']) : null;

if (empty($judul) || empty($ringkasan) || empty($jenis)) {
    $_SESSION['flash_error'] = 'Judul, ringkasan, dan jenis harus diisi.';
    header('Location: tambah-peraturan.php');
    exit();
}

// fetch existing file_path when updating
$existing_file = null;
if ($id) {
    $q = $conn->prepare('SELECT file_path FROM peraturan WHERE id = ? LIMIT 1');
    if ($q) {
        $q->bind_param('i', $id);
        if ($q->execute()) {
            $r = $q->get_result();
            if ($row = $r->fetch_assoc()) $existing_file = $row['file_path'];
        }
        $q->close();
    }
}

// handle upload (if any)
$new_file_path = null;
if (!empty($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/peraturan/';
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', basename($_FILES['file_pdf']['name']));
    $target = $upload_dir . $filename;
    if (move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target)) {
        $new_file_path = 'uploads/peraturan/' . $filename;
    }
}

if ($id) {
    // UPDATE
    $final_file = $new_file_path ?? $existing_file;
    $sql = 'UPDATE peraturan SET judul=?, nomor=?, tahun=?, jenis=?, instansi_penerbit=?, tanggal=?, ringkasan=?, isi_teks=?, file_path=?, url_sumber=?, bahasa=?, lingkup=?, tags=?, status=?, related_gallery_id=? WHERE id = ?';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['flash_error'] = 'Gagal menyiapkan query: ' . $conn->error;
        header('Location: tambah-peraturan.php?id=' . $id);
        exit();
    }
    $stmt->bind_param('ssssssssssssssii', $judul, $nomor, $tahun, $jenis, $instansi, $tanggal, $ringkasan, $isi_teks, $final_file, $url_sumber, $bahasa, $lingkup, $tags, $status, $related_gallery_id, $id);
    if ($stmt->execute()) {
        // delete old file if replaced
        if ($new_file_path && $existing_file && $existing_file !== $new_file_path) {
            $full = __DIR__ . '/../' . $existing_file;
            if (file_exists($full)) @unlink($full);
        }
        header('Location: kelola-peraturan.php');
        exit();
    } else {
        $_SESSION['flash_error'] = 'Gagal mengupdate: ' . $stmt->error;
        header('Location: tambah-peraturan.php?id=' . $id);
        exit();
    }
    $stmt->close();
} else {
    // INSERT
    $sql = "INSERT INTO peraturan
      (judul, nomor, tahun, jenis, instansi_penerbit, tanggal, ringkasan, isi_teks, file_path, url_sumber, bahasa, lingkup, tags, status, related_gallery_id, created_by, created_at)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['flash_error'] = 'Gagal menyiapkan query: ' . $conn->error;
        header('Location: tambah-peraturan.php');
        exit();
    }
    $file_for_insert = $new_file_path;
    $stmt->bind_param('ssssssssssssssii', $judul, $nomor, $tahun, $jenis, $instansi, $tanggal, $ringkasan, $isi_teks, $file_for_insert, $url_sumber, $bahasa, $lingkup, $tags, $status, $related_gallery_id, $created_by);
    if ($stmt->execute()) {
        header('Location: kelola-peraturan.php');
        exit();
    } else {
        $_SESSION['flash_error'] = 'Gagal menyimpan: ' . $stmt->error;
        header('Location: tambah-peraturan.php');
        exit();
    }
    $stmt->close();
}

$conn->close();
