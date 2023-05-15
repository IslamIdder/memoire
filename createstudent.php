
<?php
session_start();
require_once('config.php');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$name = $_POST["name"];
$surname = $_POST["surname"];
$school = $_POST["school"];
$wilaya = $_POST["wilaya"];
$date = $_POST["dob"];
$id = $_POST["reg-num"];


$sql = "INSERT INTO etudiant (id_etudiant, nom, prenom,date_naissance,wilaya,ecole) VALUES ('$id', '$name', '$surname', '$date', '$wilaya', '$school')";
if ($conn->query($sql) === TRUE) {
  // echo "Student created successfully";
} else {
  echo "Error creating student: " . $conn->error;
}
header("Location: Folders/vue-general.php?id=" . $id);
exit;

$conn->close();
?>