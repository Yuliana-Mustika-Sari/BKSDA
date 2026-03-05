<?php
session_start();
// Cek login admin
?>
<!DOCTYPE html>
<html>
<head>
    <title>Buat Laporan Berkala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h3>Buat Laporan Berkala Konflik Satwa</h3>
    <div class="card">
        <div class="card-body">
            <form action="generate-laporan.php" method="POST" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="format" class="form-label">Format Laporan</label>
                        <select name="format" class="form-select">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-cogs me-2"></i>Generate Laporan
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>