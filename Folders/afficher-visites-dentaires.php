<?php
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
require_once('../config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function checkSet(&$value)
{
    if (isset($value)) {
        return $value;
    } else {
        return "";
    }
}

$stmt = $conn->prepare("SELECT * FROM visites INNER JOIN etudiant on visites.id_etudiant = etudiant.id_etudiant and visites.id_etudiant = ? and type_visite='dentiste'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$i = 1;
while ($row1 = mysqli_fetch_assoc($result)) {
    $hygiene = array();
    $id_visite = $row1['id_visite'];
    $stmt = $conn->prepare("SELECT * FROM dent where dent.id_visite = ?");
    $stmt->bind_param("i", $id_visite);
    $stmt->execute();
    $result2 = $stmt->get_result();
    $hygiene[$row1['hygiene']] = " disabled checked ";
    $hygiene[$row1['gingivite']] = " disabled checked ";
    $tooth_array = array();
    while ($row = $result2->fetch_assoc()) {
        if ($row['type_dent']) {
            $dent = new stdClass();
            $dent->type = $row['type_dent'];
            $dent->number = $row['numero_dent'];
            $tooth_array[] = $dent;
        }
    }
    $json = json_encode($tooth_array);
    include 'visite-dentaire.php';
    $i++;
}
