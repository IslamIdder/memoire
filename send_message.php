<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



function sand_mail($id)
{

    try {
        require('config.php');

        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/SMTP.php';
        $mail = new PHPMailer(true);

        $sql = "SELECT parent.email_parent from parent INNER JOIN etudiant
            on etudiant.id_parent= parent.id_parent
            where etudiant.id_etudiant = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $email = $row["email_parent"];
        }

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ehealthad15@gmail.com';
        $mail->Password = 'rbaporiiqhmlzncq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;


        $to = $email;
        $subject = 'New visit';
        $form_file = "../dush.html";
        $message = file_get_contents("$form_file");
        $token = bin2hex(random_bytes(32));
        $resetPasswordURL = "http://localhost/memoire/login.php";
        $message = str_replace('{reset_password_url}', $resetPasswordURL, $message);

        $mail->setFrom('ehealthad15@gmail.com');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->Body = $message;


        $mail->send();
    } catch (Exception $e) {
        echo "Failed to send email. Error: " . $mail->ErrorInfo;
        exit();
    }
}
