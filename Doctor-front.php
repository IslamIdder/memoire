<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
$id_docteur = $_SESSION['id'];
?>
<div style="display:none" id="searchType"><?= "doctor-front_" . $id_docteur ?></div>
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
    <div class="dossier-etudiant flex-center header ">
        <div class="display-info flex-center ">
            <div class="student-info">School ID</div>
            <div class="student-info">School name</div>
            <div class="student-info">DDS ID</div>
        </div>
    </div>
    <div class="liste-etudiants flex-center flex-column">
        <?php
        require_once 'config.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT * FROM ecole
        INNER JOIN docteurs
        on ecole.id_dds = docteurs.id_dds
        where docteurs.id_docteur = ?");
        $stmt->bind_param("s", $id_docteur);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                include 'celluleecole.php';
            }
        } else {
            echo "student list is empty";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>