<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
require_once('config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    header("Location: Folders/dossier.php?id=" . $id);
    exit;
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/studentcreation.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php include('nav-bar.php') ?>
    <div class="flex-center max-height" style="margin-top:auto" ;>
        <form method="post" class="form flex flex-column flex-j-center">
            <h1 class="form-title">Ajouter un etudiant</h1>
            <div class="input-container">
                <input type="text" autocomplete="off" id="name" name="name" class="input">
                <label class="lbl" for="name" class="test">Nom</label>
            </div>
            <div class="input-container">
                <input type="text" autocomplete="off" id="surname" name="surname" class="input">
                <label class="lbl" for="surname">Prénom</label>
            </div>
            <div class="input-container">
                <input type="date" autocomplete="off" id="dob" name="dob" class="input">
                <label class="lbl" for="dob">Date de naissance</label>
            </div>
            <div class="input-container">
                <select class="input" id="wilaya" name="wilaya">
                    <?php
                    $wilayas = array("Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "M'Sila", "Mascara", "Ouargla", "Oran", "El Bayadh", "Illizi", "Bordj Bou Arréridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela", "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane");
                    $i = 1;
                    foreach ($wilayas as $wilaya) {
                        echo '<option value="' . $wilaya . '">' . $i . ' ' . $wilaya . '</option>';
                        $i++;
                    }
                    ?>
                </select>
                <label class="lbl" for="wilaya">Lieu de naissance</label>
            </div>
            <div class="input-container">
                <input type="text" autocomplete="off" id="school" name="school" class="input">
                <label class="lbl" for="school">Ecole</label>
            </div>
            <div class="input-container">
                <input type="text" autocomplete="off" id="reg-num" name="reg-num" class="input">
                <label class="lbl" for="reg-num">Numéro d'inscription</label>
            </div>
            <!-- <div class="verification-code flex flex-j-center">
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    echo '<input type="number" maxlength="1" class="id-input">';
                }
                ?>
            </div> -->
            <button type="submit" class="btn">Confirmer</button>
        </form>
    </div>
</body>

</html>