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
                <button class="chart-type flex flex-a-center g-10 current-chart" id="choroplethBtn">
                    <div class="chart-icon"><i class="map-icon"></i>
                    </div>
                    <div class="chart-label">
                        Choropleth
                    </div>
                </button>
                <button class="chart-type flex flex-a-center g-10" id="lollipopBtn">
                    <div class="chart-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <div class="chart-label">Lollipop</div>
                </button>
                <!-- <button class="chart-type flex flex-a-center g-10" id="pieBtn">
                    <div class="chart-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <div class="chart-label">Pie</div>
                </button> -->
            </div>
        </div>
        <div id="chart-display" class="chart-display flex-center fb-80">

            <?php
            // if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //     require_once("config.php");
            //     $start_date = $_POST['start'];
            //     $finish_date = $_POST['finish'];
            //     $illness = $_POST['case'];
            //     $current_chart = $_POST['current'];
            //     $sql = "SELECT w.nom_wilaya, COUNT(DISTINCT v.id_etudiant) AS num_students
            //     FROM wilaya w
            //     INNER JOIN dds d on d.num_wilaya = w.num_wilaya
            //     INNER JOIN ecole ec on ec.id_dds = d.id_dds
            //     INNER JOIN classe c on c.id_ecole = ec.id_ecole
            //     INNER JOIN etudiant e on e.id_classe = c.id_classe
            //     INNER JOIN visites v ON e.id_etudiant = v.id_etudiant
            //     INNER JOIN maladie m ON v.id_visite = m.id_visite AND m.nom_maladie = '$illness'
            //     WHERE DATE(v.date_visite) BETWEEN '$start_date' AND '$finish_date' and type_visite = 'generaliste' 
            //     GROUP BY w.nom_wilaya";
            //     $result = mysqli_query($conn, $sql);
            //     $data = array();
            //     if (!$result) {
            //         die('Query failed: ' . mysqli_error($conn));
            //     }
            //     if (mysqli_num_rows($result) > 0) {
            //         $result_str = "";
            //         while ($row = mysqli_fetch_assoc($result)) {
            //             $stat = new stdClass();
            //             $stat->wilaya = $row['nom_wilaya'];
            //             $stat->number = $row['num_students'];
            //             $data[] = $stat;
            //         }
            //         // var_dump($data);
            //     } else {
            //         echo "no result";
            //     }
            //     $json = json_encode($data);
            // }
            // 
            ?>
            <?php
            include('map copy.php');
            include('lolipop copy.php');
            ?>
        </div>
        <form id="myForm" method="post" onsubmit="getCurrentChart()" class="data-selection flex flex-j-fs flex-column fb-10 g-10">
            <input type="hidden" id="current" name="current">
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
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intercept the form submission event
            document.getElementById('myForm').addEventListener('submit', function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Get the form data
                var formData = new FormData(this);

                // Send an AJAX request to the server
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "stats-query", true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // console.log(xhr.responseText);
                        // console.log(JSON.parse(xhr.responseText))
                        var array = JSON.parse(xhr.responseText);
                        var wilayas = ["Adrar", "Chlef", "Laghouat", "Oum_El_Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanghasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi_Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi_Bel_Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "MSila", "Mascara", "Ouargla", "Oran", "El_Bayadh", "Illizi", "Bordj_Bou_Arréridj", "Boumerdès", "El_Tarf", "Tindouf", "Tissemsilt", "El_Oued", "Khenchela", "Souk_Ahras", "Tipaza", "Mila", "Aïn_Defla", "Naâma", "Aïn_Témouchent", "Ghardaïa", "Relizane"];
                        var data_final = [];
                        for (var i = 0; i < 48; i++) {
                            data_final[i] = {
                                wilaya: wilayas[i],
                                value: 0
                            }
                        }
                        for (var i = 0; i < wilayas.length; i++) {
                            for (var j = 0; j < array.length; j++) {
                                if (wilayas[i] === array[j].wilaya) {
                                    data_final[i].value = parseInt(array[j].number);
                                }
                            }
                        }
                        console.log(data_final)

                        function colorMap(data) {
                            var minMaxVals = d3.extent(data, function(d) {
                                return d.value;
                            });
                            var minVal = minMaxVals[0];
                            var maxVal = minMaxVals[1];
                            var colorGradient = d3.schemeBlues[7];
                            var gradient = d3.scaleLinear()
                                .domain(d3.range(0, 7).map(function(i) {
                                    return minVal + (i / 6) * (maxVal - minVal);
                                }))
                                .range(colorGradient);
                            for (var i = 0; i < data.length; i++) {
                                d3.selectAll(`#${data[i].wilaya}`)
                                    .attr("fill", function(d) {
                                        var regionVal = data[i].value;
                                        return gradient(regionVal);
                                    })
                                    .attr("data-nbr-cas", function(d) {
                                        return data[i].value;
                                    });
                            }
                        }
                        colorMap(data_final);



                        var lolipop = document.querySelector('#lolipop')
                        lolipop.innerHTML = ""
                        createLolipopChart(data_final)

                    } else {
                        // Handle the error response
                        console.error(xhr.responseText);
                    }
                };
                xhr.onerror = function() {
                    // Handle any network errors
                    console.error('An error occurred during the AJAX request.');
                };
                xhr.send(formData);
            });
        });
    </script>
</body>

</html>