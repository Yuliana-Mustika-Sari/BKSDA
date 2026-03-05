<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Jalur diperbaiki agar mengarah ke folder PHPMailer
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$db_path = __DIR__ . '/../db-connect-admin.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Erorr: File koneksi database tidak ditemukan.");
}

$status_message = '';
$status_type = '';

// Proses pengiriman balasan email jika formulir dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_reply'])) {
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi Server
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Ganti dengan host SMTP Anda
        $mail->SMTPAuth   = true;
        $mail->Username   = 'arjunadimas832@gmail.com'; // Ganti dengan alamat email Anda
        $mail->Password = 'bzde zgus tjlb jrrt';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Penerima
        $mail->setFrom('arjunadimas200@gmail.com', 'Admin BKSDA Jateng'); // Ganti dengan alamat email Anda
        $mail->addAddress($_POST['email_admin']);

        // Konten
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject_admin'];
        $mail->Body    = nl2br(htmlspecialchars($_POST['reply_admin']));

        $mail->send();
        $status_message = "Balasan berhasil dikirim ke " . htmlspecialchars($_POST['email_admin']);
        $status_type = 'success';
    } catch (Exception $e) {
        $status_message = "Gagal mengirim balasan. Error: {$mail->ErrorInfo}";
        $status_type = 'danger';
    }
}

// Ambil semua aduan dari database
$sql_aduan = "SELECT id, nama, email, telepon, subjek, pesan, created_at FROM aduan ORDER BY created_at DESC";
$result_aduan = $conn->query($sql_aduan);
$aduan_list = $result_aduan ? $result_aduan->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Aduan Masuk</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script>
        function confirmHapusSemuaAduan() {
            return confirm("Apakah Anda yakin ingin menghapus SEMUA data aduan? Tindakan ini tidak dapat dibatalkan!");
        }
    </script>
</head>
<body>
    <div class="admin-wrapper">
        <?php include __DIR__ . '/_admin_nav.php'; ?>

        <div class="content-wrapper">
            <div class="admin-header">
                <h4 class="mb-0" style="color: #004d00;">Daftar Aduan Masuk</h4>
            </div>

            <div class="container-fluid">
                <?php if (!empty($status_message)): ?>
                    <div class="alert alert-<?php echo $status_type; ?>" role="alert">
                        <?php echo $status_message; ?>
                    </div>
                <?php endif; ?>

                <div class="row mb-4">
                    <div class="col-12 text-end">
                        <form method="POST" action="hapus-aduan.php" onsubmit="return confirmHapusSemuaAduan();">
                            <input type="hidden" name="hapus_semua" value="1">
                            <button type="submit" class="btn btn-hapus-semua">
                                <i class="fas fa-trash-alt me-1"></i> Hapus Semua Aduan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <?php if (!empty($aduan_list)): ?>
                        <?php foreach ($aduan_list as $aduan): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Pengaduan dari: <?php echo htmlspecialchars($aduan['nama']); ?></h5>
                                        <a href="hapus-aduan.php?id=<?php echo $aduan['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus aduan ini?');">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Subjek:</strong> <?php echo htmlspecialchars($aduan['subjek']); ?></p>
                                        <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($aduan['email']); ?>"><?php echo htmlspecialchars($aduan['email']); ?></a></p>
                                        <p><strong>Telepon:</strong> <?php echo htmlspecialchars($aduan['telepon']); ?></p>
                                        <p><strong>Tanggal:</strong> <?php echo date('d-m-Y H:i', strtotime($aduan['created_at'])); ?></p>
                                        <hr>
                                        <p><strong>Pesan:</strong></p>
                                        <p><?php echo nl2br(htmlspecialchars($aduan['pesan'])); ?></p>
                                        
                                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#replyModal_<?php echo $aduan['id']; ?>">
                                            <i class="fas fa-reply me-1"></i> Balas Pesan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="replyModal_<?php echo $aduan['id']; ?>" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="aduan.php" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="replyModalLabel">Balas Pengaduan dari <?php echo htmlspecialchars($aduan['nama']); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="email_admin" class="form-label">Tujuan Email</label>
                                                    <input type="email" class="form-control" name="email_admin" value="<?php echo htmlspecialchars($aduan['email']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="subject_admin" class="form-label">Subjek</label>
                                                    <input type="text" class="form-control" name="subject_admin" value="Balasan Aduan: <?php echo htmlspecialchars($aduan['subjek']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="reply_admin" class="form-label">Isi Balasan</label>
                                                    <textarea class="form-control" name="reply_admin" rows="5" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" name="send_reply" class="btn btn-primary">Kirim Balasan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="alert alert-info text-center">Belum ada aduan yang masuk.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>