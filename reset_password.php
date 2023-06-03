<?php
session_start();
date_default_timezone_set('Africa/Algiers');
require_once('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["id"]) && isset($_GET["home"])) {
        $id = $_SESSION["id"] = $_GET["id"];
        $home = $_GET["home"];
        $_SESSION['home'] = $home;
        $_SESSION["access_type"] = $access_type = $_GET["access_type"];
        $table_name = $_GET["table_name"];
        $token = $_GET["token"];
        $doctor_type = $_SESSION["doctor_type"] = $_GET["doctor_type"];
    } else {
        header("Location: forgot_password.php");
        exit();
    }

    $sql = "SELECT `date_session` FROM `sessions` WHERE `user_id` = ? AND token=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $id, $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($row && isset($row['date_session'])) {
        $prev_time = new DateTime($row['date_session']);
        $current_time = new DateTime();
        $diff = $prev_time->diff($current_time);
        if ($diff->format('%H:%I:%S') > '00:01:00') {
            header("Location: link_expired.php");
            exit();
        }
    } else {
        $_SESSION["status"] = "Something went wrong, please try again ";
        header("Location: reset_password.php?token=" . $token . "&id=" . $id . "&home=" . $home . "&access_type=" . $access_type . "&table_name=" . $table_name . "&doctor_type=" . $doctor_type);
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $pass1 = $_POST["pass1"];
        $pass2 = $_POST["pass2"];
        if (empty($pass1) || empty($pass2)) {
            $error = "Please fill both of these fields";
        }
        if ($pass1 == $pass2) {
            $sql = "UPDATE " . $table_name . " SET mdp_" . $access_type . "= ? WHERE id_" . $access_type . " = ?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $pass1, $id);
            mysqli_stmt_execute($stmt);
            $sql = "DELETE  FROM `sessions` WHERE `user_id` = ?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $_SESSION['id'] = $id;
            header("Location: " . $home);
            exit();
        } else {
            $error = "Passwords do not match, Please try again";
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/studentcreation.js" defer></script>
    <title>Document</title>
</head>

<body class="flex flex-j-center">
    <form method="post" class="form flex flex-column  g-30" style="padding-top:100px;">
        <h1 class="form-title">Reset password</h1>
        <?php if (isset($error)) : ?>
            <div class=" br-5 pd-15 flex flex-j-sb flex-a-center error-message" id="error_message">
                <div><?= $error ?></div>
                <button class=" flex-center" type="button" id="errorButton" onclick="removeErrorMessage()" style="aspect-ratio:1/1;"><i class=" fa-solid fa-xmark"></i></button>
            </div>
        <?php endif; ?>
        <div class="input_box">
            <input type="password" autocomplete="off" id="identifiant" placeholder=" " name="pass1" class="input">
            <label class="label" for="password" class="test">create new password</label>
        </div>
        <div class="input_box">
            <input class="input" type="password" autocomplete="off" name="pass2" placeholder=" ">
            <label class="label" for="c_password">confirm your password</label>
        </div>
        <div class="input_box"><button type="submit" class="btn" name="submit">Confirm</button></div>
    </form>


    </div>
</body>

</html>