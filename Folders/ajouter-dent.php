<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $array = $_POST['array'];
    $myArray = json_decode($array);
    var_dump($myArray);
    $id_student = $_GET['id'];
    $id_docteur = $_SESSION['id'];
    $type_visite = $_SESSION['doctor_type'];
    $date = date('Y/m/d');
    $hygiene = $_POST['hygiene'];
    // if (isset($_POST['gingivite'])) {
    //     $illnesses = $_POST['gingivite'];
    //     $array = array();
    //     foreach ($illnesses as $illness) {
    //         $array[] = $illness;
    //         $id_maladie = $visit_id . "_" . $illness;
    //         $mal = "INSERT INTO maladie(id_maladie,id_visite, nom_maladie) VALUES ('$id_maladie','$visit_id', '$illness')";
    //         mysqli_query($conn, $mal);
    //     }
    // }
    require_once('../config.php');
    $sql = "INSERT INTO visites(id_etudiant, id_docteur, type_visite,date_visite,hygiene) 
        VALUES ('$id_student', '$id_docteur', '$type_visite','$date','$hygiene')";
    mysqli_query($conn, $sql);
    $visit_id = mysqli_insert_id($conn);
    foreach ($myArray as $number => $tooth) {
        if ($tooth) {
            $number = $number + 1;
            $id_dent = $visit_id . "_" . $number;
            $sql = "INSERT INTO dent (id_dent,id_visite, numero_dent, type_dent) VALUES ('$id_dent','$visit_id', '$number', '$tooth')";
            mysqli_query($conn, $sql);
        }
    }
    header('Location: dossier.php?id=' . $id_student);
    exit();
}
