<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
if (isset($_GET['id'])) {
    $type = "docteur";
    $id_ecole = $_GET['id'];
} else {
    $id_directeur = $_SESSION['id'];
    $type = "directeur";
}
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
    include_once "nav-bar.php";
    $ecole = "";
    include_once "utility.php";
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
        if ($type == "docteur") {
            $sql = "SELECT * FROM classe
        INNER JOIN ecole
        on classe.id_ecole = ecole.id_ecole
        where ecole.id_ecole = '$id_ecole'";
        } else {
            $sql = "SELECT * FROM classe
        INNER JOIN directeurs
        on classe.id_ecole = directeurs.id_ecole
        where directeurs.id_directeur = '$id_directeur'";
        }
        $search_query = "";
        $search_request = $sql . " and nom_classe LIKE '$search_query%' OR id_classe LIKE '$search_query%' OR annee LIKE '$search_query%'";
        echo '<div style="display:none" id="query" data-page="ecole">' . $search_request . '</div>';
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                include_once 'celluleclasse.php';
            }
        } else {
            echo "student list is empty";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>