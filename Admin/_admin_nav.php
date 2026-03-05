<?php
// Reusable admin sidebar. Expects to be included from files in Admin/ directory.
$cur = basename($_SERVER['PHP_SELF']);
function _navClass($file) {
    // compare basename without extension to allow passing either 'edit-content' or 'edit-content.php'
    $curBase = pathinfo($GLOBALS['cur'], PATHINFO_FILENAME);
    $fileBase = pathinfo($file, PATHINFO_FILENAME);
    if ($curBase === $fileBase) {
        return 'nav-link active rounded py-2 px-3';
    }
    return 'nav-link rounded py-2 px-3';
}
?>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--bs-primary);
            color: #fff;
            padding: 20px;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-header img {
            width: 80px;
            animation: bounceIn 1s;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .sidebar-header h4 {
            color: #fff;
            margin-top: 15px;
            font-weight: 600;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            background-color: rgba(0, 0, 0, 0.2);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 30px;
            width: 100%;
            transition: all 0.3s;
        }

        .admin-header {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .05);
            margin-bottom: 30px;
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-menu {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 10px;
            padding: 30px;
        }

        .card-menu:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-menu .fas {
            color: var(--bs-primary);
            transition: color 0.3s;
        }

        .card-menu:hover .fas {
            color: var(--bs-success);
        }

        .card-menu h5 {
            font-weight: 600;
            color: #333;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            background-color: #006400;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }
        .card-body {
            padding: 25px;
        }
        .btn-hapus-semua {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .btn-hapus-semua:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
<div class="sidebar">
            <div class="sidebar-header">
                <img src="../img/logo2.png" alt="Logo BKSDA Jateng">
                <h4>Dashboard Admin</h4>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link <?= _navClass('dashboard') ?> rounded py-2 px-3" href="dashboard.php">
                        <i class="fas fa-home me-2"></i>Beranda
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= _navClass('edit-content') ?> rounded py-2 px-3" href="edit-content.php">
                        <i class="fas fa-edit me-2"></i>Kelola Konten
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= _navClass('data-pendaftaran') ?> rounded py-2 px-3" href="data-pendaftaran.php">
                        <i class="fas fa-file-alt me-2"></i>Data Pendaftaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= _navClass('data-konflik') ?> rounded py-2 px-3" href="data-konflik.php">
                        <i class="fas fa-exclamation-triangle me-2"></i>Data Laporan Konflik
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= _navClass('aduan') ?> rounded py-2 px-3" href="aduan.php">
                        <i class="fas fa-comment-dots me-2"></i>Pengaduan
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= _navClass('kelola-galeri') ?> rounded py-2 px-3" href="kelola-galeri.php">
                        <i class="fas fa-images me-2"></i>Kelola Galeri
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= _navClass('kelola-pengguna') ?> rounded py-2 px-3" href="kelola-pengguna.php">
                        <i class="fas fa-users me-2"></i>Kelola Pengguna
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= _navClass('logout') ?> rounded py-2 px-3" href="../logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
