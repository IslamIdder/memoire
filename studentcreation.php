<?php
session_start();
include_once 'functions.php';
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
// function checkSet(&$value)
// {
//     if (isset($value))
//         return $value;
//     else {
//         return '';
//     }
// }
require_once('config.php');
$id_directeur = $_SESSION['id'];
$title = "Add a student";
if (isset($_GET['id'])) {
    $id_student = $_GET['id'];
    $title = "Modify a student";
    $stmt = $conn->prepare("SELECT * from etudiant WHERE id_etudiant=?");
    $stmt->bind_param("i", $id_student);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $classe = $_POST["classe"];
        $wilaya = $_POST["wilaya"];
        $date = $_POST["dob"];
        $stmt = $conn->prepare("UPDATE etudiant SET nom=?, prenom=?,date_naissance=?,wilaya=? where id_etudiant=?");
        if (!$stmt)
            die($conn->error);
        $stmt->bind_param("ssssi",  $name, $surname, $date, $wilaya, $id_student);
        $stmt->execute();
        header("Location: Folders/dossier.php?id=" . $id_student);
        $conn->close();
        exit;
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $classe = $_POST["classe"];
        $wilaya = $_POST["wilaya"];
        $date = $_POST["dob"];
        $id = $_POST["reg-num"];
        $stmt = $conn->prepare("INSERT INTO etudiant (id_etudiant, nom, prenom,date_naissance,wilaya,classe) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $id, $name, $surname, $date, $wilaya, $classe);
        $stmt->execute();
        header("Location: Folders/dossier.php?id=" . $id);
        $conn->close();
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/studentcreation.js" defer></script>
    <script src="Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php include('nav-bar.php') ?>
    <div class="flex flex-j-center max-height" style="margin-top:auto" ;>
        <form method="post" class="form flex g-30 flex-column ">
            <h1 class="form-title"><?= $title ?></h1>
            <?= createInputField("name", "name", "text", "Name", setValue($row['nom']), "required") ?>
            <?= createInputField("surname", "surname", "text", "Family name", setValue($row['prenom']), "required") ?>
            <div class="input-container">
                <input type="date" autocomplete="off" id="dob" name="dob" class="input" <?= checkSet($row['date_naissance']) ?> required>
                <label class="lbl" for="dob">Date de naissance</label>
            </div>
            <div class="input-container">
                <select class="input" id="wilaya" name="wilaya" required>
                    <?php
                    $wilayas = array("Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "M'Sila", "Mascara", "Ouargla", "Oran", "El Bayadh", "Illizi", "Bordj Bou Arréridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela", "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane");
                    $i = 1;
                    foreach ($wilayas as $wilaya) {
                        if ($wilaya == $row['wilaya'])
                            echo '<option selected value="' . $wilaya . '">' . $i . ' ' . $wilaya . '</option>';
                        else
                            echo '<option value="' . $wilaya . '">' . $i . ' ' . $wilaya . '</option>';
                        $i++;
                    }
                    ?>
                </select>
                <label class="lbl" for="wilaya">Lieu de naissance</label>
            </div>
            <div class="input-container">
                <?php
                $sql = "SELECT nom_classe from classe 
                    INNER JOIN directeurs on directeurs.id_ecole = classe.id_ecole
                    where directeurs.id_directeur = '$id_directeur'
                    order by nom_classe ASC";
                $result = mysqli_query($conn, $sql);
                if (!$result)
                    die(mysqli_error($conn));
                ?>
                <select class="input" id="classe" name="classe" required>
                    <?php
                    $classes = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $classes[] = $row['nom_classe'];
                    }
                    foreach ($classes as $classe) {
                        if ($classe == $row['id_classe'])
                            echo '<option selected value="' . $classe . '">' . $classe . '</option>';
                        echo '<option value="' . $classe . '">' . $classe . '</option>';
                    }
                    ?>
                </select>
                <label class="lbl" for="classe">Classe</label>
            </div>
            <!-- <div class="verification-code flex flex-j-center">
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    echo '<input type="number" maxlength="1" class="id-input">';
                }
                ?>
            </div> -->
            <button type="submit" class="btn center">Confirmer</button>
        </form>
    </div>
    <script>
        const inputField = document.querySelector('input[name="name"]');
        const errorMessage = document.getElementById('customErrorMessage');

        inputField.addEventListener('invalid', function(event) {
            event.preventDefault();
            errorMessage.textContent = 'Please enter only alphabetical characters.';
            errorMessage.style.display = 'block';
        });

        inputField.addEventListener('input', function() {
            errorMessage.style.display = 'none';
        });
    </script>

    <style>
        .error-message {
            color: red;
            font-size: 14px;
            display: none;
            position: absolute;
            bottom: 5px;
        }
    </style>
</body>

</html>