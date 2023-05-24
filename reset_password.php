<?php
session_start();
date_default_timezone_set('Africa/Algiers');
require_once('config.php');
if (isset($_GET["id"]) && isset($_GET["home"])) {
    $id = $_SESSION["id"] = $_GET["id"];
    $home = $_GET["home"];
    $_SESSION['home'] = $home;
    $_SESSION["access_type"] = $access_type = $_GET["access_type"];
    $table_name = $_GET["table_name"];
    $token = $_GET["token"];
    if (isset($doctor_type))
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
        $_SESSION["status"] = "Invalid login, please try again empty ";
        header("Location: reset_password.php");
        exit();
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
        header("Location: " . $home);
        exit();
    } else {
        $_SESSION["status"] = "wrong password , please try again!! ";
        header("Location: reset_password.php");
        exit();
    }
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
        <h1>reset password</h1>
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
                <label>create new password</label>
                <input type="password" name="pass1" class="input-field">
            </div>
            <div class="txt">
                <label>confirm your password</label>
                <input type="password" name="pass2" class="input-field">
            </div>
            <input type="submit" name="signin" class="button" value="submit">
        </form>

    </div>
</body>

</html>