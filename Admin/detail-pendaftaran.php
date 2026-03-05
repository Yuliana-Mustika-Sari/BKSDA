<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../simaksi-db.php';

$pendaftaran_id = $_GET['id'] ?? null;
if (!$pendaftaran_id) {
    header("Location: data-pendaftaran.php");
    exit();
}

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $tindak_lanjut = $_POST['tindak_lanjut'];

    $sql_update = "UPDATE pendaftaran_simaksi SET status = ?, tindak_lanjut = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $status, $tindak_lanjut, $pendaftaran_id);
    $stmt_update->execute();
    $stmt_update->close();

    // Redirect to the same page to see changes
    header("Location: detail-pendaftaran.php?id=" . $pendaftaran_id . "&status=updated");
    exit();
}

// Fetch details for the selected registration
$sql = "SELECT * FROM pendaftaran_simaksi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pendaftaran_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan.");
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Detail Pendaftaran - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Detail Pendaftaran: <?php echo htmlspecialchars($data['nomor_surat'] ?? 'N/A'); ?></h3>
            <a href="data-pendaftaran.php" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
            <div class="alert alert-success">Status berhasil diperbarui.</div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Informasi Pemohon</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <?php foreach ($data as $key => $value): ?>
                                <?php if (!in_array($key, ['id', 'status', 'tindak_lanjut', 'urutan', 'tanggal_dibuat'])): ?>
                                    <tr>
                                        <th style="width: 30%;"><?php echo ucwords(str_replace('_', ' ', $key)); ?></th>
                                        <td><?php echo htmlspecialchars($value ?? ''); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5>Status & Tindak Lanjut</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="status" class="form-label">Ubah Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Baru" <?php if ($data['status'] == 'Baru') echo 'selected'; ?>>Baru</option>
                                    <option value="Diproses" <?php if ($data['status'] == 'Diproses') echo 'selected'; ?>>Diproses</option>
                                    <option value="Disetujui" <?php if ($data['status'] == 'Disetujui') echo 'selected'; ?>>Disetujui</option>
                                    <option value="Ditolak" <?php if ($data['status'] == 'Ditolak') echo 'selected'; ?>>Ditolak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tindak_lanjut" class="form-label">Catatan / Tindak Lanjut (Internal)</label>
                                <textarea class="form-control" id="tindak_lanjut" name="tindak_lanjut" rows="5"><?php echo htmlspecialchars($data['tindak_lanjut'] ?? ''); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                        </form>
                        <hr>
                        <a href="cetak-simaksi-admin.php?id=<?php echo $pendaftaran_id; ?>" class="btn btn-success w-100" target="_blank">
                            <i class="fas fa-print me-2"></i>Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>