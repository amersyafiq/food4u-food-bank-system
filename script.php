<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require ROOT_PATH . '/mail/Exception.php';
    require ROOT_PATH . '/mail/PHPMailer.php';
    require ROOT_PATH . '/mail/SMTP.php';

    require 'config.php';

    function sendMail($email, $subject, $message) {

        $mail = new PHPMailer(true);

        $mail->isSMTP();

        $mail->SMTPAuth = true;
        $mail->Host = MAILHOST;
        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom(SEND_FROM, SEND_FROM_NAME);

        $mail->addAddress($email);
        $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;

        if(!$mail->send()) {
            return false;
        }
        else {
            return true;
        }
    }

    function sendMultiMail($emails, $subject, $message) {
        
        $mail = new PHPMailer(true);
    
        $mail->isSMTP();

        $mail->SMTPAuth = true;
        $mail->Host = MAILHOST;
        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom(SEND_FROM, SEND_FROM_NAME);

        foreach ($emails as $email) {
            $mail->AddBCC($email);
        }

        $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();

        if(!$mail->send()) {
            return false;
        }
        else {
            return true;
        }
    }

?>