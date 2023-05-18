<?php
$servername = "localhost";
$username = "root";
$password = "chelsea64";
$dbname = "ehealth";

$conn = new mysqli($servername, $username, $password, $dbname);
function format($date)
{
    return date("d-m-Y", strtotime($date));
}
$query = sprintf("SELECT weight,height,age,id_visite from visites where type_visite='generaliste' ORDER BY weight ASC,height ASC ,age ASC;");
$result = $conn->query($query);
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

$result->close();
// $conn->close();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    echo json_encode($data);
}


// echo json_encode($data);
