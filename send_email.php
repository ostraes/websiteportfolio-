<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail = new PHPMailer(true);

        try {
            // Gmail SMTP config
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'jasmineostraes@gmail.com'; // Your Gmail
            $mail->Password   = 'lwcx mbjl nupk iitq';       // App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Sender/Receiver
            $mail->setFrom('jasmineostraes@gmail.com', 'Cafe Delights Website');
            $mail->addAddress('jasmineostraes@gmail.com', 'Cafe Delights');
            $mail->addReplyTo($email, $name); // ✅ Reply goes to user

            // Email content
            $mail->Subject = "Contact Form: " . $subject;
            $mail->Body    = "You received a message from your website contact form:\n\n"
                           . "Name: $name\n"
                           . "Email: $email\n"
                           . "Subject: $subject\n\n"
                           . "Message:\n$message";

            $mail->send();

            $_SESSION['flash'] = "Message sent successfully! Thank you, $name.";
        } catch (Exception $e) {
            $_SESSION['flash'] = "Message could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['flash'] = "Invalid email address.";
    }

    header("Location: index.php");
    
}
?>
