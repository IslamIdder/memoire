<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">
    <link rel="stylesheet" href="../CSS/all.css">
    <script src="../Scripts/script.js" defer></script>
    <script src="../Scripts/tooth.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php include('../nav-bar.php'); ?>
    <div id="id_etudiant" data-id="<?php echo $_GET['id']; ?>"></div>
    <form method="POST" action="ajouter-dent.php?id=<?php echo $_GET['id']; ?> " onsubmit="setMyArrayValue()" class=" flex-center " style=" height:calc(100% - 51px);gap:100px;">
        <div class="section1">
            <label>Hygiene Bucco-dentaire:</label>
            <input type="hidden" name="array" id="tooth">
            <label>Gingivite:</label>
            <div class="check-container">
                <div class="checkbox-wrapper-4">
                    <input class="inp-cbx" value="localisee" name="gingivite[]" type="checkbox" />
                    <label class="cbx" for="localisee">Localisée</label>
                </div>
                <div class="checkbox-wrapper-4">
                    <input class="inp-cbx" value="generalisee" name="gingivite[]" type="checkbox" />
                    <label class="cbx" for="generalisee">Generalisée</label>
                </div>
                <div class="checkbox-wrapper-4">
                    <input class="inp-cbx" value="tartre" name="gingivite[]" type="checkbox" />
                    <label class="cbx" for="tartre">Tartre</label>
                </div>
            </div>
            <label>Anomalie Dento-Faciale</label>
            <div>
                <input type="text" name="anomalie">
            </div>
            <button type="submit" class="btn" id="myButton">Enregistrer</button>
        </div>
        <div class="section2"></div>
    </form>
</body>

</html>