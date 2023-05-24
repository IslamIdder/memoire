<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
$id_classe = $_GET['id'];
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
    <div style="display:none" id="classeID"><?php echo $id_classe ?></div>
    <div class="utility flex flex-a-center flex-j-sb">
        <form class="inline">
            <div class="input-icons flex flex-a-center">
                <i class="fa-solid fa-magnifying-glass icon"></i>
                <input class="search-bar" placeholder="Search..." type="text">
            </div>
        </form>
        <?php if ($_SESSION['access_type'] == "directeur") : ?>
            <a class="btn" href="studentcreation.php">
                Add a student
            </a>
        <?php endif; ?>
    </div>
    <div class="dossier-etudiant flex-center header">
        <div class="flex-center" style="width:65px;">Image</div>
        <div class="display-info flex-center ">
            <div class="student-info">Name</div>
            <div class="student-info">Family name</div>
            <div class="student-info">Inscription number</div>
        </div>
        <!-- <button class="student-settings">
        <i class="fa-solid fa-gear "></i>
    </button> -->
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