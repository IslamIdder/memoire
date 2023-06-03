<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
$id_parent = $_SESSION['id'];
?>
<div style="display:none" id="searchType"><?= "parent_" . $id_parent ?></div>
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
    $current = "accueil";
    include "nav-bar.php";
    include "utility.php";
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
        INNER JOIN parent
        on etudiant.id_parent= parent.id_parent
        where parent.id_parent = '$id_parent'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                include 'celluleetudiant.php';
            }
        } else {
            echo "student list is empty";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>