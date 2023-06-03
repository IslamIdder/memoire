<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $array = $_POST['array'];
    $myArray = json_decode($array);
    $id_student = $_GET['id'];
    $id_docteur = $_SESSION['id'];
    $type_visite = $_SESSION['doctor_type'];
    $date = date('Y/m/d');
    if (isset($_POST['hygiene'])) {
        $hygiene = $_POST['hygiene'][0];
    }
    if (isset($_POST['gingivite'])) {
        $gin = $_POST['gingivite'][0];
    }
    require_once('../config.php');
    $stmt = $conn->prepare("INSERT INTO visites(id_etudiant, id_docteur, type_visite,date_visite,hygiene,gingivite) 
        VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("isssss", $id_student, $id_docteur, $type_visite, $date, $hygiene, $gin);
    $stmt->execute();
    $visit_id = mysqli_insert_id($conn);
    foreach ($myArray as $number => $tooth) {
        if ($tooth) {
            $number = $number + 1;
            $id_dent = $visit_id . "_" . $number;
            $stmt = $conn->prepare("INSERT INTO dent (id_dent,id_visite, numero_dent, type_dent) VALUES (?,?,?,?)");
            $stmt->bind_param("siis", $id_dent, $visit_id, $number, $tooth);
            $stmt->execute();
        }
    }
    require_once("../send_message.php");
    sand_mail($id_student);
    header('Location: dossier.php?id=' . $id_student);
    exit();
}
