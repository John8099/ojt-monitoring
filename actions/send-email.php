<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($name, $sendTo, $role)
{
    require "../vendors/PHPMailer/vendor/autoload.php";

    $mail = new PHPMailer(true);
    $content;
    if ($role === "supervisor") {
        $content = "Good day, $name has posted his/her report. Please check if its correct.";
    }
    else {
        $content = "Good day, $name has posted his/her report and already checked by his/her supervisor.";
    }
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = 1;
        $mail->Username = "lykamayguinabo@gmail.com";
        $mail->Password = 'guinabo789';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';

        $mail->setFrom("lykamayguinabo@gmail.com");
        $mail->addAddress($sendTo);
        $mail->addReplyTo("noreply@google.com");

        $html_body = file_get_contents('email-template.php');
        $html_body = str_replace('%content%', $content, $html_body);

        $mail->IsHTML(true);
        $mail->Subject = "OJT Monitoring System";
        $mail->Body    = $html_body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return true;
    }
}
