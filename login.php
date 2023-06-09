<?php
session_start();
require_once('config.php');
include_once 'functions.php';
if (isset($_SESSION["id"])) {
    header("location: " . $_SESSION['home']);
}

function svg($width, $height, $id, $class = "")
{
    return '<svg width="' . $width . 'px" height="' . $height . 'px" class="' . $class . '">
    <use style="width:100%;height:100%;" xlink:href="/memoire/Images/icons.svg#' . $id . '"></use>
</svg>';
}

if (isset($_COOKIE["identifiant"]) && isset($_COOKIE["pass"])) {
    $id = $_COOKIE["identifiant"];
    $pass = $_COOKIE["pass"];
} else {
    $pass = "";
    $id  = "";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Africa/Algiers');
    $id = $_POST["identifiant"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if (empty($id) || !isset($_POST['password'])) {
        $error = "Please fill both these fields";
    } else {
        $max_attempts = 5;
        $lockout_duration = 1 % 120;
        $stmt = mysqli_prepare($conn, "SELECT attempts,last_attempt_time as last_attempt FROM login_attempts WHERE user_id = ? ;");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $num_attempts = $row['attempts'];
            $last_attempt = $row['last_attempt'];
            if (isset($num_attempts) && $num_attempts >= $max_attempts) {
                $current_timestamp = date("Y-m-d H:i:s");
                $lockout_expiration = date("Y-m-d H:i:s", strtotime($last_attempt) + ($lockout_duration * 60));
                if ($current_timestamp > $lockout_expiration) {
                    $stmt = mysqli_prepare($conn, "DELETE FROM login_attempts  WHERE user_id = ?");
                    mysqli_stmt_bind_param($stmt, "s", $id);
                    mysqli_stmt_execute($stmt);
                } else {
                    $time_remaining = strtotime($lockout_expiration) - strtotime($current_timestamp);
                    $_SESSION["status"] = "You have exceeded the maximum number of login attempts.
             Please try again later.  " . $time_remaining . " seconds";
                    echo $time_remaining;
                    // exit();
                }
            }
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
                default:
                    header("location: login.php");
                    exit;
                    break;
            }
        } elseif (strcasecmp(substr($id, 0, 1), 'P') === 0) {
            $access_type = 'parent';
            $att_name = 'id_parent';
            $table_name = 'parent';
            $direction = "parent-front";
        } elseif (strcasecmp(substr($id, 0, 1), 'D') === 0) {
            $access_type = 'directeur';
            $att_name = 'id_directeur';
            $table_name = 'directeurs';
            $direction = "director-front";
        }
        if (isset($access_type)) {
            $row_password = "mdp_" . $access_type;
            $sql = "SELECT * FROM " . $table_name . " WHERE " . $att_name . " = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($row[$row_password], $hashed_password)) {
                    if (isset($_POST["remember"])) {
                        setcookie("identifiant", $id, time() + (86400 * 30), "/");
                        setcookie("pass", $password, time() + (86400 * 30), "/");
                    }
                    $stmt = mysqli_prepare($conn, "DELETE FROM login_attempts  WHERE user_id = ?");
                    mysqli_stmt_bind_param($stmt, "s", $id);
                    mysqli_stmt_execute($stmt);
                    $_SESSION["access_type"] = $access_type;
                    if (isset($doctor_type))
                        $_SESSION["doctor_type"] = $doctor_type;
                    $_SESSION["id"] = $row[$att_name];
                    $home = $direction . ".php";
                    $_SESSION['home'] = $home;
                    header("Location: " . $home);
                    exit();
                } else {
                    $stmt = mysqli_prepare($conn, "INSERT INTO login_attempts (user_id, attempts, last_attempt_time) VALUES (?, 1, NOW()) ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt_time = NOW();");
                    if (!$stmt) {
                        echo mysqli_error($conn);
                    }
                    mysqli_stmt_bind_param($stmt, "s", $id);
                    mysqli_stmt_execute($stmt);
                    $error = "Incorrect password";
                }
            } else {
                $error = "This username does not exist";
            }
        } else {
            $error = "This username does not exist";
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
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/studentcreation.js" defer></script>
    <title>Log in</title>
</head>

<body>
    <div class="flex-center pd-20"><?= svg(70, 70, "logo") ?></div>
    <div class="flex-center">
        <form method="post" class="form flex flex-column flex-j-center g-30">
            <h1 class="form-title">Log in</h1>
            <?php if (isset($error)) : ?>
                <div class=" br-5 pd-15 flex flex-j-sb flex-a-center error-message" id="error_message">
                    <div><?= $error ?></div>
                    <button class=" flex-center" type="button" id="errorButton" onclick="removeErrorMessage()" style="aspect-ratio:1/1;"><i class=" fa-solid fa-xmark"></i></button>
                </div>
            <?php endif; ?>
            <?= createInputField("identifiant", "identifiant", "text", "Username", setValue($id), "") ?>
            <?= createInputField("password", "password", "password", "Password", setValue($pass), "") ?>
            <div>
                <input type="checkbox" id="check" name="remember">
                <label id="rem">Remember me</label>
            </div>
            <button type="submit" class="btn center" name="submit">Confirm</button>
            <div class="self-center highlighted">
                <a href="forgot_password.php" id="forgot ">Forgot password</a>
            </div>
        </form>
    </div>

</body>

</html>