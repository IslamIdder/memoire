<?php
session_start();
if (isset($_SESSION["username"])) {
    if ($_SESSION['access_type'] == "doctor")
        header("location: Doctor-front.php");
}
require_once('config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (strcasecmp(substr($username, 0, 1), 'M') === 0) {
        $stmt = $conn->prepare("SELECT * FROM docteurs WHERE id_docteur=?");
        $access_type = 'docteur';
        $att_name = 'id_docteur';
        $direction = "Doctor-front";
    } elseif (strcasecmp(substr($username, 0, 1), 'P') === 0) {
        $stmt = $conn->prepare("SELECT * FROM parents WHERE id_parent=?");
        $access_type = 'parent';
        $att_name = 'id_parent';
        $direction = "/Folders/ajoutervisite?id=" . $username;
    } elseif (strcasecmp(substr($username, 0, 1), 'D') === 0) {
        $stmt = $conn->prepare("SELECT * FROM directeurs WHERE id_directeur=?");
        $access_type = 'directeur';
        $att_name = 'id_directeur';
        $direction = "directeur-front";
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $row[$att_name];
        $_SESSION["access_type"] =  $access_type;
        // $_SESSION["type_docteur"] = 
        header("Location: " . $direction . ".php");
        $stmt->close();
        mysqli_close($conn);
        exit;
    } else {
        // echo $username . $password . 'no user';
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
        <h1>Se connecter</h1>
        <div class="input-container">
            <input type="text" autocomplete="off" id="username" name="username" class="input">
            <label class="lbl" for="username" class="test">Identifiant</label>
        </div>
        <div class="input-container">
            <input type="password" autocomplete="off" id="password" name="password" class="input">
            <label class="lbl" for="password">Mot de passe</label>
        </div>
        <button type="submit" class="btn">Confirmer</button>
    </form>
</body>

</html>