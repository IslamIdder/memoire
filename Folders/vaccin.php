<?php
session_start();
if (!isset($_SESSION["id"])) {
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
    include('../nav-bar.php');
    ?>
    <div class="flex-center max-height">
        <div class="page-container flex flex-column ">
            <div class="flex-center">République Algérienne Démocratique et Populaire</div>
            <div class="flex flex-a-center ">
                <div class="fb-70">Ministère de l'Education Nationale</div>
                <div class="info-right">Ministère de la Santé</div>
            </div>
            <div class="flex flex-a-center flex-j-sb">
                <div class="fb-70">Wilaya: </div>
                <div class="info-right">Commune:</div>
            </div>
            <h1 class="title">
                Dossier Médical scolaire
            </h1>
            <div class="flex flex-a-center flex-j-sb">
                <div class="fb-70">Nom et Prénom: <?php if ($fill) echo $row['nom'] . " " . $row['prenom'] ?></div>
                <div class="info-right">Prénom du père:</div>
            </div>
            <div class="flex flex-a-center flex-j-sb">
                <div class="fb-70">Né(e) le : <?php if ($fill) echo $row['date_naissance'] . " à:" ?></div>
                <div class="info-right">Wilaya: <?php if ($fill) echo $row['wilaya'] ?></div>
            </div>
            <div class="flex flex-a-center flex-j-sb">
                <div class="">Adresse des parents:</div>
            </div>
            <div class="flex flex-a-center flex-j-sb">
                <div class="fb-70">Profession des parents:Père:</div>
                <div class="info-right">Mère:</div>
            </div>
            <div class="annees-scolaire">
                <div class="as-element">Etablissements scolaire fréquentés</div>
                <div class="as-element">Années scolaires</div>
                <input type="text" class="as-element">
                <input type="text" class="as-element">
            </div>
            <div class="table">
                <h1 class="table-element span-all">
                    Vaccination
                </h1>
                <div class="table-element "></div>
                <div class="table-element ">Vaccins</div>
                <div class=" table-element span-2">
                    Vaccinations
                </div>
                <div class="table-element ">Observations</div>
                <div class="table-element ">Naissance</div>
                <div class="table-element ">BCG + Polio Oral + Hépatite Virale B (1)</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">1 Mois</div>
                <div class="table-element ">Hépatite Virale B (2)</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">3 Mois</div>
                <div class="table-element ">D.TCoq + Polio Oral</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">4 Mois</div>
                <div class="table-element ">D.TCoq + Polio Oral</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">5 Mois</div>
                <div class="table-element ">D.TCoq + Polio Oral+ Hépatite Virale B (3)</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">9 Mois</div>
                <div class="table-element ">Antirougeoleux</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">18 Mois</div>
                <div class="table-element ">D.TCoq + Polio Oral</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">1ère Année Fondamentale</div>
                <div class="table-element ">D.T.enfant + Polio Oral + Antirougeoleux</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">6ère Année Fondamentale</div>
                <div class="table-element ">D.T.Adult + Polio Oral</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">1ère Année secondaire</div>
                <div class="table-element ">D.T.Adult + Polio Oral</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <div class="table-element ">Tous les dix ans après 18 ans</div>
                <div class="table-element ">D.T.Adult</div>
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
                <input type="text" class="table-element ">
            </div>
        </div>
    </div>
</body>

</html>