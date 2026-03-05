<?php
session_start();

// Kumpulkan semua data dari GET parameter
$jenis_surat = $_GET['jenis_surat'] ?? 'penelitian';
$all_data = $_GET;
unset($all_data['jenis_surat']);

// Mengatur header untuk membuat file Word
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=bukti_pendaftaran_simaksi_" . str_replace(' ', '_', $all_data['Nama_Lengkap'] ?? 'Dokumen') . ".doc");
header("Pragma: no-cache");
header("Expires: 0");

$nomor_surat = 'SIMAKSI/' . strtoupper($jenis_surat) . '/' . date('Y') . '/' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
$tanggal_pengajuan = date('d F Y');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran SIMAKSI</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            line-height: 1.6; 
            font-size: 11pt; 
            margin: 0;
            padding: 0;
        }
        .document-container {
            width: 800px;
            margin: 20px auto;
            border: 3px solid #1a7337;
            padding: 40px;
        }
        .header-doc {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #1a7337;
        }
        .header-doc .logo {
            display: table-cell;
            vertical-align: top;
            width: 100px;
            padding-right: 20px;
        }
        .header-doc .logo img {
            width: 100%;
        }
        .header-doc .title-area {
            display: table-cell;
            vertical-align: middle;
            text-align: left;
        }
        .header-doc .title-area h1 {
            font-size: 20pt;
            color: #1a7337;
            margin: 0;
            line-height: 1.2;
        }
        .header-doc .title-area p {
            margin: 0;
            font-size: 11pt;
            color: #555;
        }
        .main-content {
            padding: 10px 0;
            font-size: 11pt;
        }
        .main-content h2 {
            font-size: 14pt;
            color: #1a7337;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table th, .info-table td {
            text-align: left;
            padding: 8px 0;
            vertical-align: top;
            font-size: 11pt;
        }
        .info-table th {
            width: 30%;
            font-weight: bold;
            padding-right: 20px;
        }
        .info-table td {
            width: 70%;
        }
        .footer-doc {
            text-align: center;
            font-size: 10pt;
            color: #888;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        /* CSS untuk memastikan satu halaman */
        @page {
            size: A4;
            margin: 2cm;
        }
    </style>
</head>
<body>
        <div class="main-content">
            <h2>Detail Pendaftaran</h2>
            <table class="info-table">
                <tbody>
                    <?php
                    // Tampilkan semua data dari formulir secara dinamis
                    foreach ($all_data as $key => $value):
                        $label = str_replace('_', ' ', $key);
                        $label = ucwords($label);
                        if ($value && $value !== 'N/A'):
                    ?>
                    <tr>
                        <th><?php echo htmlspecialchars($label); ?></th>
                        <td>: <?php echo htmlspecialchars($value); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <tr>
                        <th>Jenis Permohonan</th>
                        <td>: <?php echo htmlspecialchars($jenis_surat); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>: <?php echo htmlspecialchars($tanggal_pengajuan); ?></td>
                    </tr>
                </tbody>
            </table>

            <p style="text-align: center; margin-top: 25px; font-style: italic; color: #666;">
                Bukti pendaftaran ini dapat digunakan sebagai referensi untuk verifikasi lebih lanjut. Harap tunggu konfirmasi dari tim kami melalui email.
            </p>
        </div>
        
        <div class="footer-doc">
            <p>Diterbitkan oleh Sistem SIMAKSI BKSDA Jawa Tengah.</p>
        </div>
    </div>
</body>
</html>