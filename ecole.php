<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
$id_ecole = $_GET['id']
?>
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
    include "nav-bar.php"; ?>
    <div class="utility flex flex-a-center flex-j-sb">
        <form class="inline">
            <div class="input-icons flex flex-a-center">
                <i class="fa-solid fa-magnifying-glass icon"></i>
                <input class="search-bar" placeholder="Search..." type="text">
            </div>
        </form>
    </div>
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
        $sql = "SELECT * FROM classe
        INNER JOIN ecole
        on classe.id_ecole = ecole.id_ecole
        where ecole.id_ecole = '$id_ecole'";
        $result = mysqli_query($conn, $sql);
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