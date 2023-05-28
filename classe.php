<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
$id_classe = $_GET['id'];
?>
<div style="display:none" id="classeID"><?= $id_classe ?></div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php
    include_once "nav-bar.php";
    $classe = "";
    include_once "utility.php";
    ?>
    <div class="dossier-etudiant flex-center header">
        <div class="flex-center" style="width:65px;">Image</div>
        <div class="display-info flex-center ">
            <div class="student-info">Name</div>
            <div class="student-info">Family name</div>
            <div class="student-info">Inscription number</div>
        </div>
    </div>
    <div class="liste-etudiants flex-center flex-column">
        <?php
        require_once('config.php');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM etudiant
        INNER JOIN classe
        on etudiant.id_classe = classe.id_classe
        and classe.id_classe = '$id_classe'";
        $result = mysqli_query($conn, $sql);
        if (!$result)
            echo mysqli_error($conn);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                include_once 'celluleetudiant.php';
            }
        } else {
            echo "student list is empty";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>