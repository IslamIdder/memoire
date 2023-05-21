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
