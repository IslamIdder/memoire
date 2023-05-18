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
                    <div class="chart-icon"><svg id="Layer_1" data-name="Layer 1" width="25px" height="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 179.76 180.14">
                            <path d="M0,132.27v-10H6.08q69.93,0,139.86,0c3.07,0,5-.66,6.88-3.43,3.67-5.49,10.63-7.34,16.89-5.19a14.94,14.94,0,0,1,10,14.09,15.51,15.51,0,0,1-10.56,14.32c-6.26,2-13.48,0-16.66-5.7-2.15-3.86-4.7-4.21-8.39-4.2q-68.93.15-137.86.1Z" />
                            <path d="M0,58.38v-10H6.16q56.25,0,112.49,0c3.3,0,5.69-.31,7.72-3.71,3.29-5.51,10.65-7.37,16.85-5.21a15.63,15.63,0,0,1,10.15,14.16A15.18,15.18,0,0,1,143,68c-6.14,2-13,.19-16.31-5.37-2.28-3.88-5-4.38-8.88-4.37-37.17.12-74.33.09-111.49.1Z" />
                            <path d="M0,96.14v-10H5.31c23.81,0,47.62-.06,71.43,0,2.92,0,4.64-.63,6.28-3.4A14.55,14.55,0,0,1,104.3,78.5a15.14,15.14,0,0,1,2.94,21.67c-5.43,6.9-15.39,8-21.35,1.14-4.27-4.94-8.76-5.29-14.31-5.25-22,.15-44,.07-65.93.08Z" />
                            <path d="M53.21,18.17l-53.14,0V10.27H13c12.83,0,25.66,0,38.49,0,2.46,0,4.08-.35,5.56-2.87A14.52,14.52,0,0,1,76.94,1.93a14.77,14.77,0,0,1,6.35,19.35C80,28.07,70.7,31.61,63.55,27.91,60,26.08,57.46,22.29,53.21,18.17Z" />
                            <path d="M0,170.27v-10c6.27,0,12.54-.11,18.8,0,2.61.07,4-.58,5.29-3.17,3.48-7,13-9.06,20.39-4.79a14.56,14.56,0,0,1,5.33,20c-4,7.34-12.66,10-19.62,6-1-.58-2.34-1.11-2.79-2-3.57-7.29-10.16-6-16.33-6Z" />
                        </svg></div>
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
                        var array = JSON.parse(xhr.responseText);
                        console.log(array)
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