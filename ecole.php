<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
$id_ecole = $_GET['id'];
?>
<div style="display:none;" id="searchType"><?= "ecole_" . $id_ecole ?></div>
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
    include "nav-bar.php";
    $ecole = "";
    include "utility.php";
    ?>
    <div class="dossier-etudiant flex-center header">
        <div class=" display-info flex-center ">
            <div class=" student-info">Class ID</div>
            <div class="student-info">Class name</div>
            <div class="student-info">Year</div>
        </div>
    </div>
    <div class="liste-etudiants flex-center flex-column">
        <?php
        require_once('config.php');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT * FROM classe 
        INNER JOIN ecole
        ON classe.id_ecole = ecole.id_ecole
        WHERE ecole.id_ecole = ?");
        $stmt->bind_param("i", $id_ecole);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                include 'celluleclasse.php';
            }
        } else {
            echo "student list is empty";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>