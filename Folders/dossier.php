<?php
require_once('../config.php');
$id = $_GET['id'];
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM etudiant WHERE num_insc=?");
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
    <script src="/Mémoire/Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php include('../header.php') ?>
    <header class="header"><?= $row['nom'] ?>

    </header>
    <div class="history-display-grid">
        <a class="add" href="ajoutervisite.php">
            <div>
                <i class="fa-solid fa-plus"></i>
            </div>
        </a>
    </div>
</body>

</html>