<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/script.js" defer></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <title>Document</title>
</head>

<body class="">
    <?php
    $current = "statistiques";
    include "nav-bar.php"; ?>
    <main class="stats-container flex flex-j-center g-10">
        <div class="chart-type-container flex-j-fs fb-10">
            <div class="flex flex-j-fs flex-column g-10">
                <div class="chart-type flex flex-a-center  g-10">
                    <div class="chart-icon"><i class="map-icon"></i>
                    </div>
                    <div class="chart-label">
                        Choropleth
                    </div>
                </div>
                <div class="chart-type flex flex-a-center g-10">
                    <div class="chart-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <div class="chart-label">Lollipop</div>
                </div>
                <div class="chart-type flex flex-a-center g-10">
                    <div class="chart-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <div class="chart-label">Pie</div>
                </div>
            </div>
        </div>
        <div id="chart-display" class="chart-display flex-center fb-80">

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                require_once("config.php");
                $start_date = $_POST['start'];
                $finish_date = $_POST['finish'];
                $illness = $_POST['case'];
                // $sql = "SELECT e.wilaya, COUNT(DISTINCT v.id_etudiant) AS num_students
                // FROM etudiant e
                // INNER JOIN visites v ON e.id_etudiant = v.id_etudiant
                // INNER JOIN maladie m ON v.id_visite = m.id_visite AND m.nom_maladie = '$illness'
                // WHERE DATE(v.date_visite) BETWEEN '$start_date' AND '$finish_date' and type_visite = 'generaliste' 
                // GROUP BY e.wilaya";
                $sql = "SELECT w.nom_wilaya, COUNT(DISTINCT v.id_etudiant) AS num_students
                FROM wilaya w
                INNER JOIN dds d on d.num_wilaya = w.num_wilaya
                INNER JOIN ecole ec on ec.id_dds = d.id_dds
                INNER JOIN classe c on c.id_ecole = ec.id_ecole
                INNER JOIN etudiant e on e.id_classe = c.id_classe
                INNER JOIN visites v ON e.id_etudiant = v.id_etudiant
                INNER JOIN maladie m ON v.id_visite = m.id_visite AND m.nom_maladie = '$illness'
                WHERE DATE(v.date_visite) BETWEEN '$start_date' AND '$finish_date' and type_visite = 'generaliste' 
                GROUP BY w.nom_wilaya";
                $result = mysqli_query($conn, $sql);
                $data = array();
                if (!$result) {
                    die('Query failed: ' . mysqli_error($conn));
                }
                if (mysqli_num_rows($result) > 0) {
                    $result_str = "";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $result_str .= $row["nom_wilaya"] . ": " . $row["num_students"] . "<br>";
                        $stat = new stdClass();
                        $stat->wilaya = $row['nom_wilaya'];
                        $stat->number = $row['num_students'];
                        $data[] = $stat;
                    }
                    // var_dump($data);
                } else {
                    echo "no result";
                }
                $json = json_encode($data);
                include('map copy.php');
            }
            ?>
        </div>
        <form id="myForm" method="post" class="data-selection flex flex-j-fs flex-column fb-10 g-10">

            <div>Date:</div>
            <div class="flex flex-a-center g-10">
                <input class="input-field" type="date" name="start">
                <div class="div">to</div>
                <input class="input-field" type="date" name="finish">
            </div>
            <div>Illness:</div>
            <select class="" id="case" name="case">
                <option value="neurologique">neurologique</option>
                <option value="digestif">digestif</option>
                <option value="peau">peau</option>
                <option value="rachis">rachis</option>
            </select>
            <button class="btn" type="submit">Confirm</button>

        </form>
        <!-- <script>
            document.getElementById("myForm").addEventListener("submit", function(event) {
                // Prevent default form submission action
                // event.preventDefault();

                // Create an AJAX request to submit the form data and get the result
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "stats-query.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Update the chart display element with the result
                        document.getElementById("chart-display").innerHTML = xhr.responseText;
                    }
                };
                xhr.send(new FormData(event.target));
            });
        </script> -->
    </main>
</body>

</html>