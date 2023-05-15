<?php
session_start();
if (isset($_SESSION["id"])) {
    if ($_SESSION['access_type'] == "docteur")
        header("location: doctor-front.php");
    else if ($_SESSION['access_type'] == "directeur")
        header("location: director-front.php");
}
require_once('config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["identifiant"];
    $password = $_POST["password"];
    if (strcasecmp(substr($id, 0, 1), 'M') === 0) {
        $stmt = $conn->prepare("SELECT * FROM docteurs WHERE id_docteur=? and mdp_docteur=?");
        $access_type = 'docteur';
        $att_name = 'id_docteur';
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
        $stmt = $conn->prepare("SELECT * FROM parents WHERE id_parent=? and mdp_parent=?");
        $access_type = 'parent';
        $att_name = 'id_parent';
        $direction = "/Folders/dossier?id=" . $id;
    } elseif (strcasecmp(substr($id, 0, 1), 'D') === 0) {
        $stmt = $conn->prepare("SELECT * FROM directeurs WHERE id_directeur=? and mdp_directeur=?");
        $access_type = 'directeur';
        $att_name = 'id_directeur';
        $direction = "director-front";
    } else {
        header("location: login.php");
        exit;
    }

    $stmt->bind_param("ss", $id, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["id"] = $row[$att_name];
        $_SESSION["access_type"] =  $access_type;
        if (isset($doctor_type))
            $_SESSION["doctor_type"] = $doctor_type;
        $home = $direction . ".php?id=" . $_SESSION['id'];
        $_SESSION['home'] = $home;
        header("Location: " . $home);
        $stmt->close();
        mysqli_close($conn);
        exit;
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
        <button type="submit" class="btn">Confirmer</button>
    </form>
</body>

</html>