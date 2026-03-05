<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function kirimNotifikasiStatus($email_pelapor, $nomor_laporan, $status_baru) {
    $mail = new PHPMailer(true);
    $subjek = "Update Status Laporan Konflik Satwa #" . $nomor_laporan;
    $isi_pesan = "
        <p>Yth. Pelapor,</p>
        <p>Status laporan Anda dengan nomor <strong>#$nomor_laporan</strong> telah diperbarui menjadi:</p>
        <h3 style='color: #007bff;'>$status_baru</h3>
        <p>Terima kasih atas partisipasi Anda dalam konservasi satwa liar.</p>
        <p>Hormat kami,<br>Tim BKSDA Jawa Tengah</p>
    ";

    try {
        // Konfigurasi SMTP (sama seperti di aduan.php)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bksdaa383@gmail.com';
        $mail->Password   = 'gbed gpor hzou xwbu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Pengirim dan Penerima
        $mail->setFrom('no-reply@bksda-jateng.go.id', 'BKSDA Jawa Tengah');
        $mail->addAddress($email_pelapor);

        // Konten Email
        $mail->isHTML(true);
        $mail->Subject = $subjek;
        $mail->Body    = $isi_pesan;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Opsional: catat error ke log
        error_log("Gagal kirim notifikasi: " . $mail->ErrorInfo);
        return false;
    }
}
?>