<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard Analitik - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dashboard-container {
            border: none;
            width: 100%;
            height: 80vh; /* Tinggi 80% dari viewport */
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <div class="content-wrapper p-4">
            <h3 class="mb-4">Dashboard Analitik Konflik Satwa</h3>
            <div class="card">
                <div class="card-body">
                    <iframe
                        src="URL_DASHBOARD_METABASE_ANDA"
                        frameborder="0"
                        class="dashboard-container"
                        allowtransparency
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</body>
</html>