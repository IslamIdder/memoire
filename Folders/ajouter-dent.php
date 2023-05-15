<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $myArray = json_decode(file_get_contents('php://input'), true);
    $id_student = $_GET['id'];
    $id_docteur = $_SESSION['id'];
    $type_visite = $_SESSION['doctor_type'];
    $date = date('Y/m/d');
    require_once('../config.php');
    $sql = "INSERT INTO visites(id_etudiant, id_docteur, type_visite,date_visite) 
        VALUES ('$id_student', '$id_docteur', '$type_visite','$date')";
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
    $response = array('redirect' => 'dossier.php?id=' . $id_student);
    echo json_encode($response);
}
