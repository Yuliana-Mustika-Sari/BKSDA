<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../db-connect-admin.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: kelola-pengguna.php');
    exit();
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header('Location: kelola-pengguna.php?status=deleted');
    exit();
} else {
    $stmt->close();
    $conn->close();
    header('Location: kelola-pengguna.php?status=error');
    exit();
}
