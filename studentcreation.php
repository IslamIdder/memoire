<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
require_once('config.php');
$id_directeur = $_SESSION['id'];
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
    <script src="Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php include('nav-bar.php') ?>
    <div class="flex-center max-height" style="margin-top:auto" ;>
        <form method="post" class="form flex flex-column flex-j-center">
            <h1 class="form-title">Ajouter un etudiant</h1>
            <div class="input-container relative">
                <input type="text" autocomplete="off" id="name" pattern="[A-Za-z ]+" name="name" class="input" required>
                <div id="customErrorMessage" class="error-message"></div>
                <label class="lbl" for="name" class="test">Nom</label>
            </div>
            <div class="input-container">
                <input type="text" autocomplete="off" id="surname" pattern="[A-Za-z ]+" name="surname" class="input" required>
                <label class="lbl" for="surname">Prénom</label>
            </div>
            <div class="input-container">
                <input type="date" autocomplete="off" id="dob" name="dob" class="input" required>
                <label class="lbl" for="dob">Date de naissance</label>
            </div>
            <div class="input-container">
                <select class="input" id="wilaya" name="wilaya" required>
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
            event.preventDefault(); // Prevent the default browser error message from appearing
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