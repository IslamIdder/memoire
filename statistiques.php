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
    include "nav-bar.php"; ?>
    <main class="stats-container flex flex-j-center g-10">
        <div class="chart-type-container flex-j-fs fb-10">
            <div class="flex flex-j-fs flex-column g-10">
                <button class="chart-type all-chart flex flex-a-center g-10 current-chart" id="mapBtn">
                    <div class="chart-icon"><i class="map-icon"></i>
                    </div>
                    <div class="chart-label">
                        Choropleth
                    </div>
                </button>
                <button class="chart-type all-chart flex flex-a-center g-10" id="lollipopBtn">
                    <div class="chart-icon"><svg id="Layer_1" data-name="Layer 1" width="25px" height="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 179.76 180.14">
                            <path d="M0,132.27v-10H6.08q69.93,0,139.86,0c3.07,0,5-.66,6.88-3.43,3.67-5.49,10.63-7.34,16.89-5.19a14.94,14.94,0,0,1,10,14.09,15.51,15.51,0,0,1-10.56,14.32c-6.26,2-13.48,0-16.66-5.7-2.15-3.86-4.7-4.21-8.39-4.2q-68.93.15-137.86.1Z" />
                            <path d="M0,58.38v-10H6.16q56.25,0,112.49,0c3.3,0,5.69-.31,7.72-3.71,3.29-5.51,10.65-7.37,16.85-5.21a15.63,15.63,0,0,1,10.15,14.16A15.18,15.18,0,0,1,143,68c-6.14,2-13,.19-16.31-5.37-2.28-3.88-5-4.38-8.88-4.37-37.17.12-74.33.09-111.49.1Z" />
                            <path d="M0,96.14v-10H5.31c23.81,0,47.62-.06,71.43,0,2.92,0,4.64-.63,6.28-3.4A14.55,14.55,0,0,1,104.3,78.5a15.14,15.14,0,0,1,2.94,21.67c-5.43,6.9-15.39,8-21.35,1.14-4.27-4.94-8.76-5.29-14.31-5.25-22,.15-44,.07-65.93.08Z" />
                            <path d="M53.21,18.17l-53.14,0V10.27H13c12.83,0,25.66,0,38.49,0,2.46,0,4.08-.35,5.56-2.87A14.52,14.52,0,0,1,76.94,1.93a14.77,14.77,0,0,1,6.35,19.35C80,28.07,70.7,31.61,63.55,27.91,60,26.08,57.46,22.29,53.21,18.17Z" />
                            <path d="M0,170.27v-10c6.27,0,12.54-.11,18.8,0,2.61.07,4-.58,5.29-3.17,3.48-7,13-9.06,20.39-4.79a14.56,14.56,0,0,1,5.33,20c-4,7.34-12.66,10-19.62,6-1-.58-2.34-1.11-2.79-2-3.57-7.29-10.16-6-16.33-6Z" />
                        </svg></div>
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
            include('map.php');
            include('lolipop.php');
            include('pie.php');
            include('histo.php');
            ?>
        </div>
        <form id="myForm" method="post" onsubmit="getCurrentChart()" class="data-selection flex flex-j-fs flex-column fb-10 g-10">
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