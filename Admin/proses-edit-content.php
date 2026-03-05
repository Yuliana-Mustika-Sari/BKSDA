<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
    foreach ($_POST['content'] as $id => $data) {
        $id = intval($id);
        $title = $data['title'] ?? '';
        $content = $data['content'] ?? '';

        $sql = "UPDATE web_content SET title = ?, content = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssi", $title, $content, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
    $conn->close();
    header("Location: edit-content.php?status=success");
    exit();
} else {
    header("Location: edit-content.php");
    exit();
}
?>