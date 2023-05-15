<?php
require_once('config.php');
$query = sprintf("SELECT weight,height,age,id_visite from visites ORDER BY weight ASC,height ASC ,age ASC;");
$result = $mysqli->query($query);
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

$result->close();
$mysqli->close();
print json_encode($data);
