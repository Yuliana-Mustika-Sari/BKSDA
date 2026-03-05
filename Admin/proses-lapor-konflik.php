<?php
include 'simaksi-db.php'; // Menggunakan koneksi database yang sama

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil data dari form
    $nama_pelapor = $_POST['nama_pelapor'];
    $telepon_pelapor = $_POST['telepon_pelapor'];
    $email_pelapor = $_POST['email_pelapor'] ?? '';
    $tanggal_kejadian = $_POST['tanggal_kejadian'];
    $lokasi_kejadian = $_POST['lokasi_kejadian'];
    $jenis_satwa = $_POST['jenis_satwa'] ?? 'Tidak diisi';
    $deskripsi_konflik = $_POST['deskripsi_konflik'];

    // 2. Generate Nomor Laporan Unik
    $nomor_laporan = 'KFL/' . date('Ymd') . '/' . strtoupper(substr(uniqid(), -5));

    // 3. Handle Upload Foto
    $nama_file_foto = null;
    if (isset($_FILES['foto_bukti']) && $_FILES['foto_bukti']['error'] == 0) {
        $target_dir = "uploads/konflik/"; // Pastikan folder 'uploads/konflik' ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $nama_file_foto = time() . '_' . basename($_FILES["foto_bukti"]["name"]);
        $target_file = $target_dir . $nama_file_foto;
        move_uploaded_file($_FILES["foto_bukti"]["tmp_name"], $target_file);
    }

    // 4. Simpan ke Database
    $sql = "INSERT INTO laporan_konflik (nomor_laporan, nama_pelapor, telepon_pelapor, email_pelapor, tanggal_kejadian, lokasi_kejadian, jenis_satwa, deskripsi_konflik, foto_bukti) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $nomor_laporan, $nama_pelapor, $telepon_pelapor, $email_pelapor, $tanggal_kejadian, $lokasi_kejadian, $jenis_satwa, $deskripsi_konflik, $nama_file_foto);

    if ($stmt->execute()) {
        header("Location: lapor-konflik.php?status=sukses");
    } else {
        header("Location: lapor-konflik.php?status=gagal");
    }
    
    $stmt->close();
    $conn->close();
}
?>