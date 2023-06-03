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
        $error = "Please fill both these fields";
    } else {
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
        } elseif (strcasecmp(substr($id, 0, 1), '1') === 0) {
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
            $error = "Sorry, your account does not exist!!";
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
                require 'phpmailer/src/PHPMailer.php';
                require 'phpmailer/src/Exception.php';
                require 'phpmailer/src/SMTP.php';
                $mail = new PHPMailer(true);
                try {
                    $_SESSION['table_name'] = $table_name;
                    $_SESSION["access_type"] = $access_type;
                    if (isset($doctor_type))
                        $_SESSION["doctor_type"] = $doctor_type;
                    else
                        $doctor_type = "";
                    $_SESSION['id1'] = $row[$att_name];
                    $home = $direction . ".php?id=" . $_SESSION['id1'];
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
                    $subject = '';
                    $form_file = "email_validation.php";
                    $message = file_get_contents("$form_file");
                    $token = bin2hex(random_bytes(32));
                    $resetPasswordURL = "http://localhost/memoire/reset_password.php?token=" . $token . "&id=" . $_SESSION['id1'] . "&home=" . $_SESSION['home'] . "&access_type=" . $access_type . "&table_name=" . $table_name . "&doctor_type=" . $doctor_type;
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
                    sleep(2);
                    header("Location: check_email.php");
                    exit();
                } catch (Exception $e) {
                    $error = "failed to send email, Please try agian";
                }
            } else {
                $error = "email incorrect";
            }
        } else {
            $error = "This email does not exist";
        }
        $stmt->close();
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/CSS/all.css">
    <script src="Scripts/studentcreation.js" defer></script>
    <title>Forgot password</title>
</head>

<body class="flex flex-j-center">
    <form method="post" class="form flex flex-column  g-30" style="padding-top:100px;">
        <h1 class="form-title">Forgot password</h1>

        <?php if (isset($error)) : ?>
            <div class=" br-5 pd-15 flex flex-j-sb flex-a-center error-message" id="error_message">
                <div><?= $error ?></div>
                <button class=" flex-center" type="button" id="errorButton" onclick="removeErrorMessage()" style="aspect-ratio:1/1;"><i class=" fa-solid fa-xmark"></i></button>
            </div>
        <?php endif; ?>
        <div class="input_box">
            <input type="input" autocomplete="off" id="identifiant" placeholder=" " name="id" class="input">
            <label class="label" for="identifiant" class="test">Username</label>
        </div>
        <div class="input_box">
            <input class="input" type="email" autocomplete="off" name="email" placeholder=" ">
            <label class="label" for="password">Email</label>
        </div>
        <div class="input_box"><button type="submit" class="btn" name="submit">Confirm</button></div>
    </form>
</body>

</html>