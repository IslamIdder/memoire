<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
$id_classe = $_GET['id'];
?>
<div style="display:none" id="searchType"><?= "classe_" . $id_classe ?></div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body class="relative">
    <?php
    include "nav-bar.php";
    $classe = "";
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
        $stmt = $conn->prepare("SELECT * FROM etudiant
        INNER JOIN classe
        on etudiant.id_classe = classe.id_classe
        and classe.id_classe = ?");
        $stmt->bind_param("s", $id_classe);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result)
            echo mysqli_error($conn);
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

    <dialog id="myDialog" style="position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  margin:0;">
        <p>Are you sure you want to delete the student?</p>
        <button id="closeDialog">close dialog</button>
    </dialog>
</body>

</html>