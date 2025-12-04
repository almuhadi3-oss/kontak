<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $subjek = htmlspecialchars($_POST['subjek']);
    $pesan = htmlspecialchars($_POST['pesan']);

    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Server Gmail
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dinsosinhil@gmail.com'; // Ganti dengan email dinas
        $mail->Password   = 'xxxxxxxxxxxx'; // Ganti dengan App Password Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Pengirim & penerima
        $mail->setFrom('dinsosinhil@gmail.com', 'Website Dinas Sosial Inhil');
        $mail->addAddress('dinsosinhil@gmail.com', 'Dinas Sosial Inhil'); // Email penerima (sama juga boleh)
        $mail->addReplyTo($email, $nama); // Supaya bisa dibalas langsung

        // Konten Email
        $mail->isHTML(true);
        $mail->Subject = "Pesan dari Website Dinas Sosial: $subjek";
        $mail->Body    = "
            <h3>Pesan Baru dari Form Kontak</h3>
            <p><b>Nama:</b> $nama</p>
            <p><b>Email:</b> $email</p>
            <p><b>Subjek:</b> $subjek</p>
            <p><b>Pesan:</b><br>$pesan</p>
        ";

        $mail->send();
        echo "<script>alert('Pesan berhasil dikirim! Terima kasih.'); window.history.back();</script>";
    } catch (Exception $e) {
        echo "<script>alert('Pesan gagal dikirim. Error: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>
