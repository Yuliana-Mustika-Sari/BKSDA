<?php 
session_start();

$db_path = __DIR__ . '/../simaksi-db.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Error: File koneksi database tidak ditemukan. Pastikan 'simaksi-db.php' ada di folder yang benar.");
}

$id_pendaftaran = $_SESSION['pendaftaran_id'] ?? null;
if (!$id_pendaftaran) {
    header("Location: daftar-simaksi.php");
    exit();
}

$sql = "SELECT * FROM pendaftaran_simaksi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pendaftaran);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data = [
        "Nama Lengkap" => $row['nama'],
        "Nomor Identitas" => $row['identitas'],
        "Email" => $row['email'],
        "Nomor Telepon" => $row['telepon'],
        "Tanggal Mulai" => $row['tanggal_kegiatan_mulai'],
        "Tanggal Berakhir" => $row['tanggal_kegiatan_berakhir'],
        "Lokasi Konservasi" => $row['lokasi'],
        "Jumlah Peserta" => $row['jumlah_peserta'],
        "Tujuan Kegiatan" => $row['tujuan'],
    ];
    $jenis_surat = $row['jenis_surat'];
    $nomor_surat = $row['nomor_surat'];
} else {
    die("Data pendaftaran tidak ditemukan.");
}
$stmt->close();

$config = [
    'penelitian' => [
        'title' => 'SURAT IZIN PENELITIAN',
        'icon' => 'fas fa-microscope',
        'color' => 'primary',
        'kode' => 'A'
    ],
    'pendidikan' => [
        'title' => 'SURAT IZIN PENDIDIKAN',
        'icon' => 'fas fa-graduation-cap',
        'color' => 'success',
        'kode' => 'B'
    ],
    'religi' => [
        'title' => 'SURAT IZIN KEGIATAN RELIGI',
        'icon' => 'fas fa-praying-hands',
        'color' => 'warning',
        'kode' => 'C'
    ]
];

$current_config = $config[$jenis_surat];

// Generate nomor surat jika belum ada (hanya untuk pertama kali)
function generateNomorSurat($conn, $id_pendaftaran, $jenis_surat, $kode) {
    $tahun = date('Y');
    
    // Check if a number already exists for this registration
    $query_check = "SELECT nomor_surat FROM pendaftaran_simaksi WHERE id = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("i", $id_pendaftaran);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();
    
    if (!empty($row_check['nomor_surat'])) {
        return $row_check['nomor_surat'];
    }

    $query_urutan = "SELECT MAX(urutan) as max_urutan FROM pendaftaran_simaksi WHERE jenis_surat = ? AND YEAR(tanggal_dibuat) = ?";
    $stmt_urutan = $conn->prepare($query_urutan);
    $stmt_urutan->bind_param("si", $jenis_surat, $tahun);
    $stmt_urutan->execute();
    $result_urutan = $stmt_urutan->get_result();
    $row_urutan = $result_urutan->fetch_assoc();
    
    $urutan_baru = ($row_urutan['max_urutan'] ?? 0) + 1;
    $nomor_urut = str_pad($urutan_baru, 4, '0', STR_PAD_LEFT);
    
    $nomor_surat_baru = "SIMAKSI/{$kode}/{$tahun}/{$nomor_urut}";

    $update_query = "UPDATE pendaftaran_simaksi SET nomor_surat = ?, urutan = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sii", $nomor_surat_baru, $urutan_baru, $id_pendaftaran);
    $update_stmt->execute();
    $update_stmt->close();

    return $nomor_surat_baru;
}

$nomor_surat = generateNomorSurat($conn, $id_pendaftaran, $jenis_surat, $current_config['kode']);
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?php echo $current_config['title']; ?> - SIMAKSI</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <style>
        @media print {
            .no-print { display: none !important; }
            .print-header { 
                text-align: center; 
                margin-bottom: 30px;
                border-bottom: 3px solid #000;
                padding-bottom: 20px;
            }
            .print-content { 
                font-size: 14px; 
                line-height: 1.6;
            }
            .table { 
                border: 1px solid #000 !important; 
            }
            .table th, .table td { 
                border: 1px solid #000 !important; 
                padding: 8px !important;
            }
            body { 
                background: white !important; 
                color: black !important;
            }
        }
        
        .success-card {
            border: 2px solid #28a745;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.1);
        }
        
        .badge-custom {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card success-card p-5 shadow-lg">
                    <div class="text-center no-print mb-4">
                        <i class="<?php echo $current_config['icon']; ?> text-<?php echo $current_config['color']; ?> fa-5x mb-3"></i>
                        <h1 class="text-uppercase text-<?php echo $current_config['color']; ?> mb-3">Pendaftaran Berhasil!</h1>
                        <span class="badge bg-<?php echo $current_config['color']; ?> badge-custom">
                            <?php echo $current_config['title']; ?>
                        </span>
                    </div>

                    <div class="print-content">
                        <p class="mb-4 no-print">Terima kasih, data Anda telah kami simpan. Berikut adalah detail pendaftaran Anda:</p>
                        
                        <div class="row mb-4 no-print">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong>Nomor Surat:</strong> <?php echo $nomor_surat; ?>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <?php
                                    foreach ($data as $key => $value) {
                                        if ($value !== 'N/A' && !empty($value)) {
                                            echo "<tr>";
                                            echo "<th style='width: 40%; background-color: #f8f9fa;'>" . htmlspecialchars($key) . "</th>";
                                            echo "<td>" . htmlspecialchars($value) . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4 no-print">
                        <a href="simaksi.php" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-home me-2"></i> Kembali ke Halaman Simaksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>