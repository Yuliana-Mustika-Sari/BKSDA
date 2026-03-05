<?php 
session_start();
include '../simaksi-db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis_surat = $_POST['jenis_surat'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $identitas = $_POST['identitas'] ?? '';
    $email = $_POST['email'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $tanggal_mulai = $_POST['tanggal'] ?? '';
    $tanggal_berakhir = $_POST['tanggal_berakhir'] ?? '';
    $lokasi = $_POST['lokasi'] ?? '';
    $jumlah_peserta = $_POST['jumlah_peserta'] ?? '';
    $tujuan = $_POST['tujuan'] ?? '';

    // Simpan data ke database
    $sql = "INSERT INTO pendaftaran_simaksi (nama, identitas, email, telepon, tanggal_kegiatan_mulai, tanggal_kegiatan_berakhir, lokasi, jumlah_peserta, tujuan, jenis_surat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Error: " . $conn->error);
    }
    
    $stmt->bind_param("ssssssssss", $nama, $identitas, $email, $telepon, $tanggal_mulai, $tanggal_berakhir, $lokasi, $jumlah_peserta, $tujuan, $jenis_surat);
    
    if ($stmt->execute()) {
        // Ambil ID data yang baru dimasukkan
        $last_id = $conn->insert_id;
        
        // Simpan data ke session
        $_SESSION['pendaftaran_id'] = $last_id;

        // Redirect ke halaman sukses
        header('Location: simaksi-berhasil.php');
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pendaftaran SIMAKSI</title>
    <link rel="icon" type="image/png" href="../img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <style>
        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        .section-title {
            color: #007bff;
            font-weight: 600;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h3><i class="fas fa-leaf me-2"></i>PENDAFTARAN SIMAKSI</h3>
                        <p class="mb-0">Sistem Manajemen Konservasi Sumberdaya Alam</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form method="POST" action="">
                            <div class="form-section">
                                <h5 class="section-title"><i class="fas fa-file-alt me-2"></i>Jenis Permohonan</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_surat" id="penelitian" value="penelitian" required>
                                            <label class="form-check-label" for="penelitian">
                                                <i class="fas fa-microscope text-primary"></i> Surat Izin Penelitian
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_surat" id="pendidikan" value="pendidikan" required>
                                            <label class="form-check-label" for="pendidikan">
                                                <i class="fas fa-graduation-cap text-success"></i> Surat Izin Pendidikan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_surat" id="religi" value="religi" required>
                                            <label class="form-check-label" for="religi">
                                                <i class="fas fa-praying-hands text-warning"></i> Surat Izin Religi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="section-title"><i class="fas fa-user me-2"></i>Data Pemohon</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap *</label>
                                        <input type="text" class="form-control" name="nama" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nomor Identitas (KTP/SIM) *</label>
                                        <input type="text" class="form-control" name="identitas" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email *</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nomor Telepon *</label>
                                        <input type="tel" class="form-control" name="telepon" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="section-title"><i class="fas fa-calendar-alt me-2"></i>Detail Kegiatan</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Mulai *</label>
                                        <input type="date" class="form-control" name="tanggal" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Berakhir *</label>
                                        <input type="date" class="form-control" name="tanggal_berakhir" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi Konservasi *</label>
                                        <select class="form-select" name="lokasi" required>
                                            <option value="">Pilih Lokasi</option>
                                            <option value="CA Bantarbolan">CA Bantarbolan</option>
                                            <option value="CA Bekutuk">CA Bekutuk</option>
                                            <option value="CA Cabak">CA Cabak</option>
                                            <option value="CA Donoloyo">CA Donoloyo</option>
                                            <option value="CA Gebugan">CA Gebugan</option>
                                            <option value="CA Gunung Butak">CA Gunung Butak</option>
                                            <option value="CA Gunung Celering">CA Gunung Celering</option>
                                            <option value="CA Karang Bolong">CA Karang Bolong</option>
                                            <option value="CA Kecubung Ulolanang">CA Kecubung Ulolanang</option>
                                            <option value="CA Keling 1">CA Keling 1</option>
                                            <option value="CA Keling 2&3">CA Keling 2&3</option>
                                            <option value="CA Kembang">CA Kembang</option>
                                            <option value="CA Moga">CA Moga</option>
                                            <option value="CA Nusakambanga Timur">CA Nusakambanga Timur</option>
                                            <option value="CA Nusakambangan Barat">CA Nusakambangan Barat</option>
                                            <option value="CA Pager Wunung Darupono">CA Pager Wunung Darupono</option>
                                            <option value="CA Peson Subah 1">CA Peson Subah 1</option>
                                            <option value="CA Peson Subah 2">CA Peson Subah 2</option>
                                            <option value="CA Pringombo">CA Pringombo</option>
                                            <option value="CA Sepakung">CA Sepakung</option>
                                            <option value="CA Sub Vak 18C 19B Jatinegara">CA Sub Vak 18C 19B Jatinegara</option>
                                            <option value="CA Telogo Dringo">CA Telogo Dringo</option>
                                            <option value="CA Telogo Sumurup">CA Telogo Sumurup</option>
                                            <option value="CA Tlogranjeng">CA Tlogranjeng</option>
                                            <option value="CA Wijaya Kusuma">CA Wijaya Kusuma</option>
                                            <option value="SM Gunung Tunggangan">SM Gunung Tunggangan</option>
                                            <option value="TWA Curug Bengkawah">TWA Curug Bengkawah</option>
                                            <option value="TWA Grojogan Tunggangan">TWA Grojogan Tunggangan</option>
                                            <option value="TWA Guci">TWA Guci</option>
                                            <option value="TWA Gunung Selok">TWA Gunung Selok</option>
                                            <option value="TWA Sumber Semen">TWA Sumber Semen</option>
                                            <option value="TWA TWTP">TWA TWTP</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jumlah Peserta *</label>
                                        <input type="number" class="form-control" name="jumlah_peserta" min="1" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Tujuan Kegiatan *</label>
                                        <textarea class="form-control" name="tujuan" rows="3" placeholder="Jelaskan tujuan kegiatan Anda..." required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Permohonan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>