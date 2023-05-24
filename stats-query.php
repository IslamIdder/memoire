<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("config.php");
    $start_date = $_POST['start'];
    $finish_date = $_POST['finish'];
    $illness = $_POST['case'];
    $current_chart = $_POST['current'];
    $wilaya = $_POST['wilaya'];
    $data = array();
    if ($wilaya != 'all') {
        $sql = "SELECT nom_maladie,COUNT(DISTINCT visites.id_etudiant)AS num_students
                FROM maladie
                INNER JOIN visites on maladie.id_visite = visites.id_visite
                INNER JOIN etudiant on etudiant.id_etudiant = visites.id_etudiant
                INNER JOIN classe on classe.id_classe = etudiant.id_classe
                INNER JOIN ecole on ecole.id_ecole = classe.id_ecole
                INNER JOIN dds on dds.id_dds = ecole.id_dds
                INNER JOIN wilaya on wilaya.num_wilaya = dds.num_wilaya
                WHERE DATE(visites.date_visite) between '$start_date' and '$finish_date' and type_visite= 'generaliste' and wilaya.nom_wilaya ='$wilaya'
                group by maladie.nom_maladie;";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die(json_encode(mysqli_error($conn)));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $stat = new stdClass();
                $data[$row['nom_maladie']] = $row['num_students'];
            }
        } else {
            $data = [];
            echo json_encode($data);
            exit();
        }
    } else {
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
        if (!$result) {
            die('Query failed: ' . mysqli_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $stat = new stdClass();
                $stat->wilaya = $row['nom_wilaya'];
                $stat->number = $row['num_students'];
                $data[] = $stat;
            }
        } else {
            $data = [];
            echo json_encode($data);
            exit();
        }
    }
    $json = json_encode($data);
    echo $json;
}
