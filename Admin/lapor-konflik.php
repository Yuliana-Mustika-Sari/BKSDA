<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Lapor Konflik Satwa - BKSDA Jawa Tengah</title>
    <link rel="icon" type="image/png" href="img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-danger text-white text-center">
                        <h3><i class="fas fa-exclamation-triangle me-2"></i>FORM LAPORAN KONFLIK SATWA</h3>
                        <p class="mb-0">Laporkan kejadian konflik dengan satwa liar di sekitar Anda.</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
                            <div class="alert alert-success">Laporan Anda berhasil dikirim. Terima kasih!</div>
                        <?php elseif(isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
                            <div class="alert alert-danger">Gagal mengirim laporan. Silakan coba lagi.</div>
                        <?php endif; ?>

                        <form method="POST" action="proses-lapor-konflik.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Pelapor *</label>
                                <input type="text" class="form-control" name="nama_pelapor" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Telepon *</label>
                                    <input type="tel" class="form-control" name="telepon_pelapor" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email_pelapor">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal & Waktu Kejadian *</label>
                                <input type="datetime-local" class="form-control" name="tanggal_kejadian" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Detail Lokasi Kejadian *</label>
                                <textarea class="form-control" name="lokasi_kejadian" rows="2" placeholder="Contoh: Desa Karangsari, RT 02/RW 03, dekat area persawahan" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Satwa (Jika Tahu)</label>
                                <input type="text" class="form-control" name="jenis_satwa" placeholder="Contoh: Monyet Ekor Panjang, Ular, Babi Hutan">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Kejadian *</label>
                                <textarea class="form-control" name="deskripsi_konflik" rows="4" required></textarea>
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Unggah Foto (Opsional)</label>
                                <input type="file" class="form-control" name="foto_bukti" accept="image/*">
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-danger btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>