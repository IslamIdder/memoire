<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: login.php");
}
require_once('../config.php');
if (isset($_GET['id']))
    $id = $_GET['id'];
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM etudiant WHERE id_etudiant=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}

$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="../CSS/foldertemplate.css">
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="/memoire/Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php include('../header.php') ?>
    <div class="history-display-grid">
        <a class="history" href="#">
            <div class="preview"></div>
            <div class="date">abc</div>
        </a>
        <a class="add flex-center" href="#">
            <div>
                <i class="fa-solid fa-plus"></i>
            </div>
        </a>
    </div>
</body>

</html>