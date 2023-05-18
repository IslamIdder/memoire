<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
require_once('../config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../Scripts/weight.js" charset="utf-8"></script>
    <script src="../Scripts/height.js" charset="utf-8"></script>
    <script src="../Scripts/script.js" defer></script>
    <script src="../Scripts/dossier.js" defer></script>
    <title>Document</title>
</head>

<body class="flex flex-column">
    <?php
    $current = 'none';
    include('../nav-bar.php');
    ?>
    <div class=" slider-container flex relative">
        <button class="move move-previous">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <div class="slider flex">
            <div class="dossier  flex flex-j-center">
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
                        <div class="fb-70">Nom et Prénom: <?php echo $row['nom'] . " " . $row['prenom'] ?></div>
                        <div class="info-right">Prénom du père:</div>
                    </div>
                    <div class="flex flex-a-center flex-j-sb">
                        <div class="fb-70">Né(e) le : <?php echo $row['date_naissance'] . " à:" ?></div>
                        <div class="info-right">Wilaya: <?php echo $row['wilaya'] ?></div>
                    </div>
                    <div class="flex flex-a-center flex-j-sb">
                        <div class="">Adresse des parents:</div>
                    </div>
                    <div class="flex flex-a-center flex-j-sb">
                        <div class="fb-70">Profession des parents:Père:</div>
                        <div class="info-right">Mère:</div>
                    </div>
                    <div class="table">
                        <h1 class="table-element span-all">
                            Vaccination
                        </h1>
                        <div class="table-element "></div>
                        <div class="table-element ">Vaccins</div>
                        <div class=" table-element span-2">
                            <div class="flex flex-column" style="width:100%;">
                                <div style="border-bottom:1px solid black">Vaccins</div>
                                <div class="flex">
                                    <div class="fb-50">Fait le</div>
                                    <div class="fb-50" style="border-left:1px solid black">A refaire le</div>
                                </div>
                            </div>
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
            <?php include('afficher-examens.php'); ?>
            <div class="dossier  flex flex-j-center">
                <div class="page-container flex flex-column ">
                    <div class="chartCard">
                        <div class="chartBox">
                            <canvas height='200%' id="myChart"></canvas>
                        </div>
                    </div>
                    <style>
                        .chartCard {
                            height: 100%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .chartBox {
                            width: 100%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 100%;
                            padding: 20px;
                            background: white;
                        }
                    </style>
                </div>
            </div>
            <div class="dossier  flex flex-j-center">
                <div class="page-container flex flex-column ">
                    <div class="chartCard">
                        <div class="chartBox">
                            <canvas height='200%' id="myChart1"></canvas>
                        </div>
                    </div>
                    <style>
                        .chartCard {
                            height: 100%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .chartBox {
                            width: 100%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 100%;
                            padding: 20px;
                            background: white;
                        }
                    </style>
                </div>
            </div>
            <?php include('afficher-visites-dentaires.php');  ?>

        </div>
        <button class="move move-next">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
        <div class="slider-icons">
        </div>
    </div>
</body>

</html>