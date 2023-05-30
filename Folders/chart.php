<?php
require_once('../config.php');

$id =  $_GET['id'];
$query = sprintf("SELECT weight,height,age,id_visite from visites where type_visite='generaliste' and id_etudiant = '$id' ORDER by age ASC;");
$result = $conn->query($query);
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}
$result->close();
echo json_encode($data);
