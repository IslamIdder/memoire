<?php
session_start();
if (isset($_SESSION["id"])) {
    if ($_SESSION['access_type'] == "docteur")
        header("location: " . $_SESSION['home']);
    else if ($_SESSION['access_type'] == "directeur")
        header("location: director-front.php");
}
require_once('config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Africa/Algiers');
    $id = $_POST["identifiant"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if (empty($id) || !isset($password)) {
        $_SESSION["status"] = "Invalid login, please try again empty !!";
        echo $_SESSION["status"];
    }
    $access_type = '';
    $max_attempts = 5;
    $lockout_duration = 1 % 120;
    $stmt = mysqli_prepare($conn, "SELECT attempts,last_attempt_time as last_attempt FROM login_attempts WHERE user_id = ? ;");
    if (!$stmt) {
        die('mysqli_prepare() failed: ' . htmlspecialchars(mysqli_error($conn)));
    }
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
        $table_name = 'parents';
        $direction = "/Folders/dossier?id=" . $id;
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
                $stmt = mysqli_prepare($conn, "DELETE FROM login_attempts  WHERE user_id = ?");
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                $_SESSION["access_type"] = $access_type;
                if (isset($doctor_type))
                    $_SESSION["doctor_type"] = $doctor_type;
                $_SESSION["id"] = $row[$att_name];
                $home = $direction . ".php?id=" . $_SESSION['id'];
                $_SESSION['home'] = $home;
                header("Location: " . $home);
                exit();
            } else {
                echo "Incorrect username or password";
                $stmt = mysqli_prepare($conn, "INSERT INTO login_attempts (user_id, attempts, last_attempt_time) VALUES (?, 1, NOW()) ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt_time = NOW();");
                if (!$stmt) {
                    //  die('mysqli_prepare() failed: ' . htmlspecialchars(mysqli_error($conn)));
                    echo mysqli_error($conn);
                }
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                $_SESSION["status"] = "Invalid login credentials. Please try again.";
                // exit();
            }
        } else {
            echo "Incorrect username or password";
        }
    } else {
        echo "Incorrect username or password";
    }
    $stmt->close();
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
    <title>Document</title>
</head>

<body class="flex-center">
    <form method="post" class="form flex flex-column flex-j-center">
        <h1 class="form-title">Se connecter</h1>
        <div class="input-container">
            <input type="text" autocomplete="off" id="identifiant" name="identifiant" class="input">
            <label class="lbl" for="identifiant" class="test">Identifiant</label>
        </div>
        <div class="input-container">
            <input type="password" autocomplete="off" id="password" name="password" class="input">
            <label class="lbl" for="password">Mot de passe</label>
        </div>
        <button type="submit" class="btn" name="submit">Confirmer</button>
    </form>
</body>

</html>