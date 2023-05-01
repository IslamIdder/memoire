<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/studentcreation.js" defer></script>
    <title>Document</title>
</head>

<body class="flex-center">
    <form method="post" class="form flex flex-column flex-j-center" action="createstudent.php">
        <h1>Ajouter un etudiant</h1>
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
            for ($i = 1; $i <= 8; $i++) {
                echo '<input type="number" maxlength="1" class="id-input">';
            }
            ?>
        </div> -->
        <button type="submit" class="btn">Confirmer</button>
    </form>
</body>

</html>