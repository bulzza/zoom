<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    $errors = [];

    if (!$name) $errors[] = 'Bitte geben Sie Ihren Namen ein.';
    if (!$email) $errors[] = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
    if (!$subject) $errors[] = 'Bitte wählen Sie ein Thema aus.';
    if (!$message) $errors[] = 'Bitte geben Sie eine Nachricht ein.';

    if (!empty($errors)) {
        // Ensure a proper JSON response with an error status
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host ='mail.zoomreinigungen.ch';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@zoomreinigungen.ch'; // Replace with your Gmail
        $mail->Password = 'zoomContactMail123#'; // Replace with your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email setup
        $mail->setFrom('contact@zoomreinigungen.ch', 'Contact');
        $mail->addAddress('contact@zoomreinigungen.ch', 'Contact Admin Von Zoom '); // Replace with recipient's email

        // Proper handling of Reply-To
        if ($email) {
            $mail->addReplyTo($email, $name);
        }

        $mail->isHTML(true);
        $mail->Subject = "Neue Nachricht aus dem Kontaktformular von Zoom:  $subject";
        $mail->Body = "
            <h2>Neue Nachricht</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Thema:</strong> $subject</p>
            <p><strong>Nachricht:</strong><br>$message</p>
        ";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Ihre Nachricht wurde erfolgreich gesendet!']);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Fehler beim Senden der Nachricht.',
            'error_detail' => $mail->ErrorInfo,
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Ungültige Anfrage']);
}
?>
