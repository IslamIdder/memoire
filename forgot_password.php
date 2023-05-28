<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('config.php');
    date_default_timezone_set('Africa/Algiers');
    $email = $_SESSION["email"] = $_POST["email"];
    $id = $_POST["id"];
    if (empty($email) || empty($id)) {
        $_SESSION["status"] = "Invalid login, please try again empty ";
        header("Location: forgot_password.php");
        exit();
    }

    if (strcasecmp(substr($id, 0, 1), 'M') === 0) {
        $access_type = 'docteur';
        $att_name = 'id_docteur';
        $table_name = 'docteurs';
        $direction = "doctor-front";
        $type = substr($id, 0, 2);
        switch ($type) {
            case 'mg':
                $doctor_type = "generaliste";
                break;
            case 'mi':
                $doctor_type = "infermier";
                break;
            case 'md':
                $doctor_type = "dentiste";
                break;
            case 'mp':
                $doctor_type = "psychologue";
                break;
        }
    } elseif (strcasecmp(substr($id, 0, 1), 'P') === 0) {
        $access_type = 'parent';
        $att_name = 'id_parent';
        $table_name = 'parents';
        $direction = "/Folders/dossier?id=" . $id;
    } elseif (strcasecmp(substr($id, 0, 1), 'D') === 0) {
        $access_type = 'directeur';
        $att_name = 'id_directeur';
        $table_name = 'directeurs';
        $direction = "director-front";
    } else {
        $_SESSION["status"] = "Sorry, your account does not exist!!";
        header("Location: forgot_password.php");
        exit();
    }

    $sql = "SELECT  * from " . $table_name . " where id_" . $access_type . "=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["email_" . $access_type] == $email) {

            require_once 'phpmailer/src/PHPMailer.php';
            require_once 'phpmailer/src/Exception.php';
            require_once 'phpmailer/src/SMTP.php';


            $mail = new PHPMailer(true);

            try {
                $_SESSION['table_name'] = $table_name;
                $_SESSION["access_type"] = $access_type;
                if (isset($doctor_type))
                    $_SESSION["doctor_type"] = $doctor_type;
                $_SESSION['id'] = $row[$att_name];
                $home = $direction . ".php?id=" . $_SESSION['id'];
                $_SESSION['home'] = $home;



                $current_timestamp = date("Y-m-d H:i:s");
                $_SESSION["current_time"] = $current_timestamp;



                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ehealthad15@gmail.com';
                $mail->Password = 'rbaporiiqhmlzncq';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;


                $to = $email;
                $subject = 'Your Subject';
                $form_file = "email_validation.php";
                $message = file_get_contents("$form_file");
                $token = bin2hex(random_bytes(32));
                $resetPasswordURL = "http://localhost/memoire/reset_password.php?token=" . $token . "&id=" . $_SESSION['id'] . "&home=" . $_SESSION['home'] . "&access_type=" . $access_type . "&table_name=" . $table_name . "&doctor_type=" . $doctor_type;
                $message = str_replace('{reset_password_url}', $resetPasswordURL, $message);

                $mail->setFrom('ehealthad15@gmail.com');
                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->msgHTML($message);
                $mail->Body = $message;



                $sql = "INSERT into sessions(user_id,token,date_session) values(?,?,NOW());";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $id, $token);
                mysqli_stmt_execute($stmt);
                $mail->send();

                header("Location: check_email.php");

                exit();
            } catch (Exception $e) {
                echo "Failed to send email. Error: " . $mail->ErrorInfo;
            }
        } else {
            $_SESSION["status"] = "email incorrect";
            header("Location: forgot_password.php");
            exit();
        }
    } else {
        $_SESSION["status"] = "this email does not exist !!";
        header("Location: forgot_password.php");
        exit();
    }
    $stmt->close();
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/signin.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/studentcreation.js" defer></script>
    <title>Document</title>
</head>

<body class="flex-center">
    <div class="center">
        <h1>forgot password</h1>
        <p id="error"> <?php
                        if (isset($_SESSION["status"])) { ?>
                <style>
                    #error {
                        opacity: 100%;
                    }
                </style>
                <strong>Error: </strong><?php echo $_SESSION["status"]; ?>
            <?php } ?>
        </p>
        <form method="post">
            <div class="txt">
                <label for="Identifier">Enter id</label>
                <input type="text" name="id" class="input-field">
            </div>
            <div class="txt">
                <label for="Identifier">Enter your Email address</label>
                <input type="email" name="email" class="input-field">
            </div>
            <input type="submit" name="signin" class="button" value="Sign in">
        </form>

    </div>
</body>

</html>