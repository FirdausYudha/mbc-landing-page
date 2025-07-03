<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Autoload PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST["name"]);
    $email   = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';           // Server Gmail
        $mail->SMTPAuth   = true;
        $mail->Username   = 'deuslovult321@gmail.com';  // email
        $mail->Password   = 'gcjr gwhk xkpe pijg';      // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Pengirim dan Penerima
        $mail->setFrom($email, $name); // dari user
        $mail->addAddress('deuslovult321@gmail.com', 'MBC Admin'); // ke KAMU!!

        // Isi Email
        $mail->Subject = 'Pesan dari Form Kontak Website';
        $mail->Body    = "Nama: $name\nEmail: $email\n\nPesan:\n$message";

        $mail->send();
        echo "<script>alert('Pesan berhasil dikirim!'); window.location.href='contact.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Gagal mengirim pesan: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>
