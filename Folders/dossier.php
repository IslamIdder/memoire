<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}
require_once('../config.php');
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM etudiant WHERE id_etudiant=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="/memoire/Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php include('../nav-bar.php') ?>
    <div class="student-name">
        Medical folder of the student: <span class="highlighted"><?php echo $row['nom'] . " " . $row['prenom'] ?></span></div>
    <div class="history-display-grid">
        <a class="history flex flex-j-center flex-column" href="vue-general?id=<?= $id ?>">
            <div class="preview flex-center">
                <svg id="Layer_1" style="width:50px;" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 78 100">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #fff;
                            }
                        </style>
                    </defs>
                    <g id="SVGRepo_iconCarrier" data-name="SVGRepo iconCarrier">
                        <path class="cls-1" d="M61,33.2V21.3a2.8,2.8,0,0,0-2.7-2.7H19.6a2.8,2.8,0,0,0-2.7,2.7V33.2a2.4,2.4,0,0,0,2.4,2.4H58.6A2.4,2.4,0,0,0,61,33.2ZM32.2,22H47.5a1.8,1.8,0,0,1,1.7,1.7,1.7,1.7,0,0,1-1.7,1.7H32.2a1.7,1.7,0,0,1-1.7-1.7A1.8,1.8,0,0,1,32.2,22ZM52.5,32.2H25.4a1.7,1.7,0,1,1,0-3.4H52.5a1.7,1.7,0,1,1,0,3.4Z" />
                        <path class="cls-1" d="M49.2,79.7H73.1c.7-2.7,1.7-4.6,2.4-5.1h.2A2.7,2.7,0,0,0,78,71.8V3.6A3.6,3.6,0,0,0,74.4,0H16.9A16.9,16.9,0,0,0,0,16.9V86.4H0a14,14,0,0,0,2.2,7.5A13.8,13.8,0,0,0,13.6,100H76a2,2,0,0,0,1.9-1.4,1.9,1.9,0,0,0-1-2.1,11.4,11.4,0,0,1-3.7-5h-19a1.7,1.7,0,0,1-1.7-1.7,1.8,1.8,0,0,1,1.7-1.7H72.3a9.1,9.1,0,0,1-.1-1.7c0-1.1.1-2.3.2-3.3H49.2a1.7,1.7,0,0,1-1.7-1.7A1.6,1.6,0,0,1,49.2,79.7ZM19.3,39a5.8,5.8,0,0,1-5.7-5.8V21.3a6,6,0,0,1,6-6H58.3a6,6,0,0,1,6.1,6V33.2A5.8,5.8,0,0,1,58.6,39Z" />
                    </g>
                </svg>
            </div>
            <div class="date-visite">General view</div>
        </a>
        <?php
        require_once('../config.php');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT visites.type_visite, docteurs.nom_docteur, visites.date_visite,id_visite
        FROM visites 
        INNER JOIN docteurs ON docteurs.id_docteur = visites.id_docteur
        WHERE visites.id_etudiant = $id
        ORDER BY date_visite ASC ");
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $type_visite = $row['type_visite'];
                $doctor_name = $row['nom_docteur'];
                $date_visite = $row['date_visite'];
                $id_visite = $row['id_visite'];
                include 'afficher-visite.php';
            }
        }
        mysqli_close($conn);
        ?>
        <?php
        $type;
        if ($_SESSION['access_type'] == "docteur") :
            switch ($_SESSION['doctor_type']) {
                case 'dentiste': {
                        $direction = 'dentaire.php?id=';
                        break;
                    }
                case 'infermier': {
                        $direction = 'vaccin.php?id=';
                        break;
                    }
                case 'psychologue': {
                        $direction = 'psychologique.php?id=';
                        break;
                    }
                case 'generaliste': {
                        $direction = 'general.php?id=';
                        break;
                    }
            } ?>
            <div class="history flex-j-center flex-column">
                <a class="add flex-center" href="<?= $direction . $id ?>">
                    <div>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                </a>
                <div>Add a visit</div>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>