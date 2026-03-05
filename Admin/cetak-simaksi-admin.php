<?php
session_start();

// Hanya admin yang bisa mengakses
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../simaksi-db.php';

$id_pendaftaran = $_GET['id'] ?? null;
if (!$id_pendaftaran) {
    die("ID pendaftaran tidak valid.");
}

// Mengambil semua data dari database berdasarkan ID [cite: 8]
$sql = "SELECT * FROM pendaftaran_simaksi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pendaftaran);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data pendaftaran tidak ditemukan.");
}
$row = $result->fetch_assoc();
$stmt->close();
$conn->close();

$data = [
    "Nomor Surat" => $row['nomor_surat'],
    "Nama Lengkap" => $row['nama'],
    "Nomor Identitas" => $row['identitas'],
    "Email" => $row['email'],
    "Nomor Telepon" => $row['telepon'],
    "Tanggal Mulai Kegiatan" => $row['tanggal_kegiatan_mulai'],
    "Tanggal Berakhir Kegiatan" => $row['tanggal_kegiatan_berakhir'],
    "Lokasi Konservasi" => $row['lokasi'],
    "Jumlah Peserta" => $row['jumlah_peserta'],
    "Tujuan Kegiatan" => $row['tujuan'],
    "Jenis Surat" => ucwords($row['jenis_surat']),
    "Tanggal Pengajuan" => date('d F Y', strtotime($row['tanggal_dibuat'])),
    "Status Terakhir" => $row['status'],
    "Catatan Tindak Lanjut" => $row['tindak_lanjut'] ?? 'Tidak ada catatan.'
];

// Header untuk generate file Word
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Laporan_SIMAKSI_" . str_replace('/', '_', $row['nomor_surat']) . ".doc");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendaftaran SIMAKSI</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin: 1in; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h3, .kop-surat p { margin: 0; }
        .judul-laporan { text-align: center; font-weight: bold; text-decoration: underline; margin: 30px 0; }
        .table-detail { border-collapse: collapse; width: 100%; }
        .table-detail th, .table-detail td { vertical-align: top; text-align: left; padding: 5px; }
        .table-detail th { width: 30%; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h3>BALAI KONSERVASI SUMBER DAYA ALAM JAWA TENGAH</h3>
        <p>Jl. Dr. Suratmo No. 171, Manyaran, Semarang | Telp: (024)7614752</p>
    </div>

    <h4 class="judul-laporan">REKAPITULASI PENDAFTARAN SIMAKSI</h4>

    <table class="table-detail">
        <tbody>
            <?php foreach ($data as $key => $value): ?>
            <tr>
                <th><?php echo htmlspecialchars($key); ?></th>
                <td>: <?php echo nl2br(htmlspecialchars($value)); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br><br>
    <p>Dokumen ini adalah rekapitulasi data yang tersimpan di sistem E-Reporting dan dicetak pada tanggal <?php echo date('d F Y'); ?>.</p>

</body>
</html>