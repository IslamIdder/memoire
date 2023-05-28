<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('config.php');
    $email = $_SESSION["email"];
    try {
        require_once 'phpmailer/src/PHPMailer.php';
        require_once 'phpmailer/src/Exception.php';
        require_once 'phpmailer/src/SMTP.php';
        $mail = new PHPMailer(true);
        $current_timestamp = date("Y-m-d H:i:s");
        $_SESSION["current_time"] = $current_timestamp;
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ehealthad15@gmail.com'; // Replace with your Gmail address
        $mail->Password = 'rbaporiiqhmlzncq'; // Replace with your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email content
        $to = $email;
        $subject = 'Your Subject';
        $form_file = "email_validation.php";
        $message = file_get_contents("$form_file");
        $token = bin2hex(random_bytes(32));
        $resetPasswordURL = "http://localhost/memoire/reset_password.php?id=" . $_SESSION['id'] . "&home=" . $_SESSION['home'] . "&access_type=" . $_SESSION["access_type"] . "&table_name=" .  $_SESSION['table_name'] . "&doctor_type=" . $_SESSION["doctor_type"] . "&token=" . $token;
        $message = str_replace('{reset_password_url}', $resetPasswordURL, $message);
        // Set email details
        $mail->setFrom('ehealthad15@gmail.com');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->Body = $message;
        $id = $_SESSION['id'];
        $sql = "INSERT into sessions(user_id,token,date_session) values(?,?,NOW());";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $id, $token);
        mysqli_stmt_execute($stmt);
        $mail->send();

        // Send email
        $mail->send();

        header("Location: check_email.php");
        exit();
    } catch (Exception $e) {
        echo "Failed to send email. Error: " . $mail->ErrorInfo;
    }
    $stmt->close();
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="CSS/abdo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="test">
        <form method="post">
            <h1>Check Your Email</h1>
            <p>Please Check the email adress</p>
            <p><?php print $_SESSION["email"]; ?> for the instructions to reset Your password</p>
            <button name="resand">Resend email</button>
        </form>
    </div>

</body>

</html>