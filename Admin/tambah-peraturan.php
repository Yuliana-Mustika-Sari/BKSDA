<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../db-connect-admin.php';

$status_message = '';
// prepare for edit mode
$is_edit = false;
$edit_id = null;
$edit = [
    'judul'=>'', 'nomor'=>'', 'tahun'=>'', 'jenis'=>'', 'instansi_penerbit'=>'Kementerian Lingkungan Hidup dan Kehutanan',
    'tanggal'=>'', 'ringkasan'=>'', 'isi_teks'=>'', 'url_sumber'=>'', 'file_path'=>'', 'lingkup'=>'', 'bahasa'=>'ID', 'tags'=>'', 'status'=>'published','related_gallery_id'=>null
];
if (!empty($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    $stmt = $conn->prepare('SELECT * FROM peraturan WHERE id = ? LIMIT 1');
    if ($stmt) {
        $stmt->bind_param('i', $edit_id);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $is_edit = true;
                foreach ($edit as $k => $v) { if (isset($row[$k])) $edit[$k] = $row[$k]; }
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tambah Peraturan - Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="admin-wrapper">
        <?php include __DIR__ . '/_admin_nav.php'; ?>

        <div class="content-wrapper">
            <div class="admin-header">
                <h4 class="mb-0 text-primary">Tambah Peraturan</h4>
                <p class="text-muted mb-0">Masukkan metadata peraturan dan lampirkan PDF bila ada.</p>
            </div>

            <div class="container-fluid mt-4">
                <div class="data-card p-4">
                    <?php if (!empty($status_message)): ?>
                        <div class="alert alert-danger"><?php echo $status_message; ?></div>
                    <?php endif; ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Contoh Pengisian</h6>
                            <p class="card-text text-muted small">Klik <strong>Isi Contoh</strong> untuk mengisi form dengan data contoh (format nyata tapi tidak resmi).</p>
                            <div class="d-flex gap-2">
                                <button id="fillExample" type="button" class="btn btn-outline-primary btn-sm">Isi Contoh</button>
                                <button id="clearExample" type="button" class="btn btn-outline-secondary btn-sm">Kosongkan</button>
                            </div>
                            <ul class="mt-3 mb-0">
                                <li><strong>Judul:</strong> Peraturan Menteri Lingkungan Hidup dan Kehutanan Nomor 8 Tahun 2021 tentang Tata Hutan dan Penyusunan Rencana Pengelolaan Hutan serta Pemanfaatan Hutan di Hutan Lindung dan Hutan Produksi</li>
                                <li><strong>Nomor:</strong> 8</li>
                                <li><strong>Tahun:</strong> 2021</li>
                                <li><strong>Jenis:</strong> Peraturan Menteri</li>
                                <li><strong>Ringkasan:</strong> Mengatur tata cara pengelolaan dan pemanfaatan kawasan konservasi untuk menjaga keanekaragaman hayati serta memberikan pedoman perizinan kegiatan.</li>
                                <li><strong>URL Sumber:</strong> https://peraturan.bpk.go.id/Details/235254/pe</li>
                            </ul>
                        </div>
                    </div>
                    <form method="post" action="proses-tambah-peraturan.php" enctype="multipart/form-data">
                        <?php if ($is_edit): ?><input type="hidden" name="id" value="<?php echo $edit_id; ?>"><?php endif; ?>
                        <div class="mb-3"><label class="form-label">Judul</label><input class="form-control" name="judul" required value="<?php echo htmlspecialchars($edit['judul']); ?>"></div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Nomor</label><input class="form-control" name="nomor" value="<?php echo htmlspecialchars($edit['nomor']); ?>"></div>
                            <div class="col-md-2 mb-3"><label class="form-label">Tahun</label><input class="form-control" name="tahun" placeholder="2020" value="<?php echo htmlspecialchars($edit['tahun']); ?>"></div>
                            <div class="col-md-6 mb-3"><label class="form-label">Jenis</label><input class="form-control" name="jenis" placeholder="Peraturan Menteri" value="<?php echo htmlspecialchars($edit['jenis']); ?>"></div>
                        </div>
                        <div class="mb-3"><label class="form-label">Instansi Penerbit</label><input class="form-control" name="instansi_penerbit" value="<?php echo htmlspecialchars($edit['instansi_penerbit']); ?>"></div>
                        <div class="mb-3"><label class="form-label">Tanggal (opsional)</label><input type="date" class="form-control" name="tanggal" value="<?php echo htmlspecialchars($edit['tanggal']); ?>"></div>
                        <div class="mb-3"><label class="form-label">Ringkasan (1-3 kalimat)</label><textarea class="form-control" name="ringkasan" required><?php echo htmlspecialchars($edit['ringkasan']); ?></textarea></div>
                        <div class="mb-3"><label class="form-label">URL Sumber (JDIH / peraturan.go.id)</label><input class="form-control" name="url_sumber" placeholder="https://..." value="<?php echo htmlspecialchars($edit['url_sumber']); ?>"></div>
                        <div class="mb-3">
                            <label class="form-label">Upload PDF (opsional)</label>
                            <?php if (!empty($edit['file_path'])): ?>
                                <div class="mb-2">File saat ini: <a href="../<?php echo htmlspecialchars($edit['file_path']); ?>" target="_blank">Unduh</a></div>
                            <?php endif; ?>
                            <input type="file" name="file_pdf" accept="application/pdf" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Lingkup / Tema</label><input class="form-control" name="lingkup"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Bahasa</label><input class="form-control" name="bahasa" value="ID"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Tags (comma separated)</label><input class="form-control" name="tags"></div>
                        </div>
                        <div class="mb-3"><label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="published" <?php echo ($edit['status']=='published')? 'selected':''; ?>>Published</option>
                                <option value="draft" <?php echo ($edit['status']=='draft')? 'selected':''; ?>>Draft</option>
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary"><?php echo $is_edit? 'Update':'Simpan'; ?></button>
                            <a href="kelola-peraturan.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Isi otomatis contoh data pengisian peraturan
        (function() {
            const example = {
                judul: 'Peraturan Menteri Lingkungan Hidup dan Kehutanan Nomor 8 Tahun 2021 tentang Tata Hutan dan Penyusunan Rencana Pengelolaan Hutan',
                nomor: '8',
                tahun: '2021',
                jenis: 'Peraturan Menteri',
                instansi_penerbit: 'Kementerian Lingkungan Hidup dan Kehutanan',
                tanggal: '2021-04-01',
                ringkasan: 'Mengatur tata hutan, penyusunan rencana pengelolaan hutan serta pemanfaatan hutan di kawasan hutan lindung dan hutan produksi.',
                url_sumber: 'https://peraturan.bpk.go.id/Details/235254/pe',
                lingkup: 'pengelolaan hutan',
                bahasa: 'ID',
                tags: 'hutan,lindung,produksi'
            };

            document.getElementById('fillExample').addEventListener('click', function() {
                Object.keys(example).forEach(function(k) {
                    const el = document.getElementsByName(k)[0];
                    if (!el) return;
                    el.value = example[k];
                });
            });
            document.getElementById('clearExample').addEventListener('click', function() {
                const names = ['judul', 'nomor', 'tahun', 'jenis', 'instansi_penerbit', 'tanggal', 'ringkasan', 'url_sumber', 'lingkup', 'bahasa', 'tags'];
                names.forEach(function(n) {
                    const el = document.getElementsByName(n)[0];
                    if (el) el.value = '';
                });
            });
        })();
    </script>
</body>

</html>