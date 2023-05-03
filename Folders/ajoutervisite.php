<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: login.php");
}
require_once('../config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$fill =   false;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
    mysqli_close($conn);
    $fill = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="../Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body class="flex flex-column ">
    <?php
    $current = 'none';
    include('../header.php');
    ?>
    <div class=" slider-container flex relative">
        <button class="move move-previous">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <div class="slider flex">
            <div class="dossier flex-center">
                <div class="page-container flex flex-column ">
                    <div class="flex-center">République Algérienne Démocratique et Populaire</div>
                    <div class="flex flex-a-center ">
                        <div class="info-left">Ministère de l'Education Nationale</div>
                        <div class="info-right">Ministère de la Santé</div>
                    </div>
                    <div class="flex flex-a-center flex-j-sb">
                        <div class="info-left">Wilaya: </div>
                        <div class="info-right">Commune:</div>
                    </div>
                    <h1 class="title">
                        Dossier Médical scolaire
                    </h1>
                    <div class="flex flex-a-center flex-j-sb">
                        <div class="info-left">Nom et Prénom: <?php if ($fill) echo $row['nom'] . " " . $row['prenom'] ?></div>
                        <div class="info-right">Prénom du père:</div>
                    </div>
                    <div class="flex flex-a-center flex-j-sb">
                        <div class="info-left">Né(e) le : <?php if ($fill) echo $row['date_naissance'] . " à:" ?></div>
                        <div class="info-right">Wilaya: <?php if ($fill) echo $row['wilaya'] ?></div>
                    </div>
                    <div class="flex flex-a-center flex-j-sb">
                        <div class="">Adresse des parents:</div>
                    </div>
                    <div class="flex flex-a-center flex-j-sb">
                        <div class="info-left">Profession des parents:Père:</div>
                        <div class="info-right">Mère:</div>
                    </div>
                    <div class="annees-scolaire">
                        <div class="as-element">Etablissements scolaire fréquentés</div>
                        <div class="as-element">Années scolaires</div>
                        <input type="text" class="as-element">
                        <input type="text" class="as-element">
                    </div>
                    <div class="table flex flex-column flex-a-center flex-j-center">
                        <div class="table-row" style="border-right:1px solid black;">
                            Vaccination
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5"></div>
                            <div class="table-element c-5">Vaccins</div>
                            <div class=" table-element c-5 flex flex-column" style="flex-basis:40%;">
                                Vaccinations
                                <div class="flex flex-j-sb flex-a-center" style="width:100%;">
                                    <div class="" style="flex-basis:50%;border-top:1px solid black;border-right:1px solid black">Fait le</div>
                                    <div class="" style="flex-basis:50%;border-top:1px solid black">A refaire le</div>
                                </div>
                            </div>
                            <div class="table-element c-5">Observations</div>
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">Naissance</div>
                            <div class="table-element c-5">BCG + Polio Oral + Hépatite Virale B (1)</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">1 Mois</div>
                            <div class="table-element c-5">Hépatite Virale B (2)</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">3 Mois</div>
                            <div class="table-element c-5">D.TCoq + Polio Oral</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">4 Mois</div>
                            <div class="table-element c-5">D.TCoq + Polio Oral</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">5 Mois</div>
                            <div class="table-element c-5">D.TCoq + Polio Oral+ Hépatite Virale B (3)</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">9 Mois</div>
                            <div class="table-element c-5">Antirougeoleux</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">18 Mois</div>
                            <div class="table-element c-5">D.TCoq + Polio Oral</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">1ère Année Fondamentale</div>
                            <div class="table-element c-5">D.T.enfant + Polio Oral + Antirougeoleux</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">6ère Année Fondamentale</div>
                            <div class="table-element c-5">D.T.Adult + Polio Oral</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">1ère Année secondaire</div>
                            <div class="table-element c-5">D.T.Adult + Polio Oral</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                        <div class="table-row">
                            <div class="table-element c-5">Tous les dix ans après 18 ans</div>
                            <div class="table-element c-5">D.T.Adult</div>
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                            <input type="text" class="table-element c-5">
                        </div>
                    </div>
                </div>
            </div>
            <div class="dossier flex-center">
                <div class="page-container flex flex-column ">
                    <?php
                    $title = 'Examen de depistage';
                    $numElements = 5;
                    $elementHeaders = array("Date de l'examen", "Classe fréquentée", "Age de l'élève");
                    include('table.php');
                    ?>
                    <?php
                    $title = 'Antecedents de L\'eleve';
                    $numElements = 5;
                    $elementHeaders = array("Tension artérielle", "Acuité OD", "Visuelle OG", "Pédiculose");
                    include('table.php');
                    ?>
                    <?php
                    $title = 'Examen Medical';
                    $numElements = 5;
                    $elementHeaders = array("app.Neurologique", "app.Endocrinien", "Rachis et Membres", "Peau et Phanères", "app.Ophtalmique", "app.O.R.L", "app.Respiratoire", "app.Cardio-vasculaire", "app.Digestif", "app.Urinaire", "app.Génital", "Autre anomalies Dépistées");
                    include('table.php');
                    ?>
                </div>
            </div>
        </div>
        <button class="move move-next">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
    </div>
</body>

</html>