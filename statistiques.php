<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
require_once('config.php');
$id =  $_SESSION['id'];
if ($_SESSION['access_type'] == 'docteur')
    $query = "docteurs.id_docteur";
else if ($_SESSION['access_type'] == 'directeur')
    $query = "directeurs.id_directeur";
$sql = "SELECT w.nom_wilaya
                FROM wilaya w
                INNER JOIN dds d on d.num_wilaya = w.num_wilaya
                INNER JOIN docteurs on d.id_dds = docteurs.id_dds
                INNER JOIN ecole ec on ec.id_dds = d.id_dds
                INNER JOIN directeurs on directeurs.id_ecole = ec.id_ecole
                where " . $query . " = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$nom_wilaya = $row['nom_wilaya'];
$wilayas = array("Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "M'Sila", "Mascara", "Ouargla", "Oran", "El Bayadh", "Illizi", "Bordj Bou Arréridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela", "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/script.js" defer></script>
    <script src="Scripts/statistiques.js" defer></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <title>Document</title>
</head>

<body class="">
    <?php
    $current = "statistiques";
    $current_chart = 'choropleth';
    include_once "nav-bar.php"; ?>
    <main class="stats-container flex flex-j-center g-10">
        <div class="chart-type-container flex-j-s fb-10">
            <div class="flex flex-j-s flex-column g-10">
                <button class="chart-type all-chart flex flex-a-center g-10 current-chart" id="mapBtn">
                    <div class="chart-icon"><?= svg(25, 25, "dz-mini") ?></div>
                    <div class="chart-label">
                        Choropleth
                    </div>
                </button>
                <button class="chart-type all-chart flex flex-a-center g-10" id="lollipopBtn">
                    <div class="chart-icon"><?= svg(25, 25, "lollipop-mini") ?></div>
                    <div class="chart-label">Lollipop</div>
                </button>
                <button class="chart-type wilaya-chart flex flex-a-center g-10 " id="pieBtn">
                    <div class="chart-icon"><i class="fa-solid fa-chart-pie"></i></i>
                    </div>
                    <div class="chart-label">
                        Pie
                    </div>
                </button>
                <button class="chart-type wilaya-chart flex flex-a-center g-10 " id="histoBtn">
                    <div class="chart-icon"><i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <div class="chart-label">
                        Histogram
                    </div>
                </button>
            </div>
        </div>
        <div id="chart-display" class="chart-display flex-center fb-80">
            <?php
            include_once('map.php');
            include_once('lolipop.php');
            include_once('pie.php');
            include_once('histo.php');
            ?>
        </div>
        <form id="myForm" method="post" onsubmit="getCurrentChart()" class="data-selection flex flex-j-s flex-column fb-10 g-10">
            <input type="hidden" id="current" name="current">
            <div>Affichage:</div>
            <select class="input" id="wilaya" name="wilaya">
                <?php
                $i = 1;
                echo '<option value="all">All</option>';
                foreach ($wilayas as $wilaya) {
                    if ($wilaya == $nom_wilaya)
                        echo '<option value="' . $wilaya . '" selected>' . $i . ' ' . $wilaya . '</option>';
                    else
                        echo '<option value="' . $wilaya . '">' . $i . ' ' . $wilaya . '</option>';
                    $i++;
                }
                ?>
            </select>
            <div>Date:</div>
            <div class="flex flex-a-center g-10">
                <input class="input-field" type="date" name="start" required>
                <div class="div">to</div>
                <input class="input-field" type="date" id="finish_date" name="finish">
            </div>
            <div id="illnesses">
                <div>Illness:</div>
                <select class="input " id="case" name="case">
                    <option value="neurologique">Neurologique</option>
                    <option value="digestif">Digestif</option>
                    <option value="peau">Peau</option>
                    <option value="rachis">Rachis</option>
                    <option value="ophalmique">Ophalmique</option>
                    <option value="orl">ORL</option>
                    <option value="respiratoire">Respiratoire</option>
                    <option value="cardio">Cardio-vasculaire</option>
                    <option value="endocrinien">Endocrinien</option>
                    <option value="urinaire">Urinaire</option>
                    <option value="genital">Génital</option>
                </select>
            </div>
            <button class="btn" type="submit">Confirm</button>
        </form>
    </main>
</body>

</html>