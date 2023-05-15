<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("config.php");
    $start_date = $_POST['start'];
    $finish_date = $_POST['finish'];
    $case = $_POST['case'];
    $sql = "SELECT s.wilaya, COUNT(DISTINCT s.id_etudiant) AS num_students
                FROM etudiant s
                JOIN visites v ON s.id_etudiant = v.id_etudiant
                JOIN maladie m ON v.id_etudiant = m.id_visite
                WHERE m.nom_maladie = 'neurologique' AND v.date_visite BETWEEN '$start_date' AND '$finish_date'
                GROUP BY s.wilaya";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }
    if (mysqli_num_rows($result) > 0) {
        $result_str = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $result_str .= $row["wilaya"] . ": " . $row["num_students"] . "<br>";
        }
        echo $result_str;
    }
}
