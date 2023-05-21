<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats page of memoire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4> </h4>
                    </div>
                    <div class="card-body">

                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                                                                        echo $_GET['from_date'];
                                                                                    } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                                                                        echo $_GET['to_date'];
                                                                                    } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label></label> <br>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $con = mysqli_connect("localhost", "root", "12345678", "ehealth");

                                if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                    $from_date = $_GET['from_date'];
                                    $to_date = $_GET['to_date'];

                                    $query = "SELECT w.nom_wilaya, COUNT(DISTINCT v.id_etudiant) AS num_students
                FROM wilaya w
                INNER JOIN dds d on d.num_wilaya = w.num_wilaya
                INNER JOIN ecole ec on ec.id_dds = d.id_dds
                INNER JOIN classe c on c.id_ecole = ec.id_ecole
                INNER JOIN etudiant e on e.id_classe = c.id_classe
                INNER JOIN visites v ON e.id_etudiant = v.id_etudiant
                INNER JOIN maladie m ON v.id_visite = m.id_visite AND m.nom_maladie = 'peau'
                WHERE DATE(v.date_visite) BETWEEN '$from_date' AND '$to_date' and type_visite = 'generaliste' 
                GROUP BY w.nom_wilaya";
                                    $query_run = mysqli_query($con, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $row) {
                                ?>
                                            <tr>
                                                <td><?= $row['nom_wilaya']; ?></td>
                                                <td><?= $row['nom_wilaya']; ?></td>
                                                <td><?= $row['num_students']; ?></td>
                                            </tr>
                                <?php
                                        }
                                    } else {
                                        echo "No Record Found";
                                    }
                                }
                                ?>
                            </tbody>
                            <div id="piechart2" style="width: 1500px; height: 800px;"></div>
                            <div id="piechart4" style="width: 1500px; height: 1000px;"></div>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['nom_wilaya', 'num_students'],
                <?php
                $sql = "SELECT w.nom_wilaya, COUNT(DISTINCT v.id_etudiant) AS num_students
                FROM wilaya w
                INNER JOIN dds d on d.num_wilaya = w.num_wilaya
                INNER JOIN ecole ec on ec.id_dds = d.id_dds
                INNER JOIN classe c on c.id_ecole = ec.id_ecole
                INNER JOIN etudiant e on e.id_classe = c.id_classe
                INNER JOIN visites v ON e.id_etudiant = v.id_etudiant
                INNER JOIN maladie m ON v.id_visite = m.id_visite AND m.nom_maladie = 'peau'
                WHERE DATE(v.date_visite) BETWEEN '$from_date' AND '$to_date' and type_visite = 'generaliste' 
                GROUP BY w.nom_wilaya";
                $fire = mysqli_query($con, $sql);
                while ($result = mysqli_fetch_assoc($fire)) {
                    echo "['" . $result['nom_wilaya'] . "'," . $result['num_students'] . "],";
                }

                ?>
            ]);

            var options = {};

            var chart = new google.visualization.ColumnChart(document.getElementById('piechart2'));

            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['nom_wilaya', 'num_students'],
                <?php
                $sql = "SELECT w.nom_wilaya, COUNT(DISTINCT v.id_etudiant) AS num_students
                FROM wilaya w
                INNER JOIN dds d on d.num_wilaya = w.num_wilaya
                INNER JOIN ecole ec on ec.id_dds = d.id_dds
                INNER JOIN classe c on c.id_ecole = ec.id_ecole
                INNER JOIN etudiant e on e.id_classe = c.id_classe
                INNER JOIN visites v ON e.id_etudiant = v.id_etudiant
                INNER JOIN maladie m ON v.id_visite = m.id_visite AND m.nom_maladie = 'peau'
                WHERE DATE(v.date_visite) BETWEEN '$from_date' AND '$to_date' and type_visite = 'generaliste' 
                GROUP BY w.nom_wilaya";
                $fire = mysqli_query($con, $sql);
                while ($result = mysqli_fetch_assoc($fire)) {
                    echo "['" . $result['nom_wilaya'] . "'," . $result['num_students'] . "],";
                }

                ?>
            ]);

            var options = {
                pieHole: 0.0
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart4'));

            chart.draw(data, options);
        }
    </script>
</body>

</html>