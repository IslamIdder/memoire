<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
}
require_once('../config.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$fill =   false;
$view = false;
if (isset($_GET['id_visite'])) {
    $view = true;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
    // mysqli_close($conn);
    $fill = true;


    $stmt = $conn->prepare("SELECT * FROM vaccinations 
    INNER JOIN etudiant on vaccinations.id_etudiant = etudiant.id_etudiant
    WHERE etudiant.id_etudiant=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vaccinations = array_fill(0, 11, array("nom" => "", "df" => "", "dr" => "", "ob" => ""));
    if (!$result)
        die(mysqli_error($conn));
    while ($row2 = mysqli_fetch_assoc($result)) {
        $num_vaccin = $row2['num_vaccin'];
        $vaccinations[$num_vaccin]['nom'] = $row2['periode_vaccin'];
        $vaccinations[$num_vaccin]['df'] = $row2['date_fait'];
        $vaccinations[$num_vaccin]['dr'] = $row2['date_refait'];
        $vaccinations[$num_vaccin]['ob'] = $row2['observation'];
    }
}
function checkVaccine($i, $vaccinations, &$fait, &$refait, &$obs, $view)
{
    $fait = "";
    $refait = "";
    $obs = "";
    if ($vaccinations[$i]['nom'] !== "") {
        $fait = "disabled value=\"" . $vaccinations[$i]['df'] . "\"";
        $refait = "disabled value=\"" . $vaccinations[$i]['dr'] . "\"";
        if (!empty($vaccinations[$i]['ob'])) {
            $obs = "disabled value=\"" . $vaccinations[$i]['ob'] . "\"";
        } else {
            $obs = "disabled value=\"/\"";
        }
    } else if ($view) {
        $fait = "disabled value=\"\"";
        $refait = "disabled value=\"\"";
        $obs = "disabled value=\"\"";
    }
}
$place = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    for ($i = 0; $i < 11; $i++) {
        $place = $i . "-fait";
        if (isset($_POST[$place]) && $_POST[$place] != "") {
            switch ($i) {
                case 0:
                    $periode_vaccin = "Naissance";
                    break;
                case 1:
                    $periode_vaccin = "1 Mois";
                    break;
                case 2:
                    $periode_vaccin = "3 Mois";
                    break;
                case 3:
                    $periode_vaccin = "4 Mois";
                    break;
                case 4:
                    $periode_vaccin = "5 Mois";
                    break;
                case 5:
                    $periode_vaccin = "9 Mois";
                    break;
                case 6:
                    $periode_vaccin = "18 Mois";
                    break;
                case 7:
                    $periode_vaccin = "1ère Année Fondamentale";
                    break;
                case 8:
                    $periode_vaccin = "6ème Année Fondamentale";
                    break;
                case 9:
                    $periode_vaccin = "1ère Année Secondaire";
                    break;
                case 10:
                    $periode_vaccin = "apres 18 ans";
                    break;
            }
            $fait = $_POST[$i . "-fait"];
            $refait = $_POST[$i . "-refait"];
            $obs = $_POST[$i . "-obs"];
            $id_vaccin = $id . "_" . $i;
            $id_docteur = $_SESSION['id'];
            $date = date('Y/m/d');
            $type_visite = $_SESSION['doctor_type'];
            $stmt = $conn->prepare("INSERT INTO visites(id_etudiant,id_docteur,date_visite,type_visite) values (?,?,?,?)");
            if (!$stmt)
                die("Error: " . $conn->error);
            $stmt->bind_param("isss", $id, $id_docteur, $date, $type_visite);
            $stmt->execute();
            $visit_id = mysqli_insert_id($conn);
            $stmt = $conn->prepare("INSERT INTO vaccinations(id_vaccin,id_etudiant,date_fait,date_refait,observation,num_vaccin,periode_vaccin,id_visite) values (?,?,?,?,?,?,?,?)");
            if (!$stmt)
                echo "Error: " . $conn->error;
            $stmt->bind_param("sisssisi", $id_vaccin, $id, $fait, $refait, $obs, $i, $periode_vaccin, $visit_id);
            $stmt->execute();
            $result = $stmt->get_result();
            header("Location: dossier.php?id=" . $id);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="../Scripts/script.js" defer></script>
    <title>Document</title>
</head>

<body class="flex flex-column ">
    <?php
    $current = 'none';
    include_once('../nav-bar.php');
    ?>
    <div class="flex-center max-height">
        <div class="dossier flex flex-j-center" style="position:relative;">
            <form method="POST" onsubmit="checkDates" class="page-container flex flex-column ">
                <div class="flex-center">République Algérienne Démocratique et Populaire</div>
                <div class="flex flex-a-center ">
                    <div class="fb-70">Ministère de l'Education Nationale</div>
                    <div class="info-right">Ministère de la Santé</div>
                </div>
                <div class="flex flex-a-center flex-j-sb">
                    <div class="fb-70">Wilaya: </div>
                    <div class="info-right">Commune:</div>
                </div>
                <h1 class="title">
                    Dossier Médical scolaire
                </h1>
                <div class="flex flex-a-center flex-j-sb">
                    <div class="fb-70">Nom et Prénom: <span class="highlighted"><?php echo $row['nom'] . " " . $row['prenom'] ?></span></div>
                </div>
                <div class="flex flex-a-center flex-j-sb">
                    <div class="fb-70">Né(e) le : <span class="highlighted"><?php echo $row['date_naissance'] . " " ?></span></div>
                    <div class=" info-right">à: <span class="highlighted"><?php echo $row['wilaya'] ?></span></div>
                </div>
                <div class=" flex flex-a-center flex-j-sb">
                </div>
                <div class="flex flex-a-center flex-j-sb">
                </div>
                <div class="table">
                    <h1 class="table-element span-all">
                        Vaccination
                    </h1>
                    <div class="table-element "></div>
                    <div class="table-element ">Vaccins</div>
                    <div class=" table-element span-2">
                        <div class="flex flex-column" style="width:100%;">
                            <div style="border-bottom:1px solid black">Vaccins</div>
                            <div class="flex">
                                <div class="fb-50">Fait le</div>
                                <div class="fb-50" style="border-left:1px solid black">A refaire le</div>
                            </div>
                        </div>
                    </div>
                    <div class="table-element ">Observations</div>
                    <div class="table-element ">Naissance</div>
                    <div class="table-element ">BCG + Polio Oral + Hépatite Virale B (1)</div>
                    <?php checkVaccine(0, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="0-fait" <?= $fait ?> class="table-element ">
                    <input type="date" name="0-refait" <?= $refait ?> class="table-element ">
                    <input type="text" name="0-obs" <?= $obs ?> class="table-element ">

                    <div class="table-element ">1 Mois</div>
                    <div class="table-element ">Hépatite Virale B (2)</div>
                    <?php checkVaccine(1, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="1-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="1-refait" <?= $refait ?>class="table-element ">
                    <input type="text" name="1-obs" <?= $obs ?>class="table-element ">

                    <div class="table-element ">3 Mois</div>
                    <div class="table-element ">D.TCoq + Polio Oral</div>
                    <?php checkVaccine(2, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="2-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="2-refait" <?= $refait ?> class="table-element ">
                    <input type="text" name="2-obs" <?= $obs ?>class="table-element ">

                    <div class="table-element ">4 Mois</div>
                    <div class="table-element ">D.TCoq + Polio Oral</div>
                    <?php checkVaccine(3, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="3-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="3-refait" <?= $refait ?>class="table-element ">
                    <input type="text" name="3-obs" <?= $obs ?>class="table-element ">

                    <div class="table-element ">5 Mois</div>
                    <div class="table-element ">D.TCoq + Polio Oral+ Hépatite Virale B (3)</div>
                    <?php checkVaccine(4, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="4-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="4-refait" <?= $refait ?>class="table-element ">
                    <input type="text" name="4-obs" <?= $obs ?> class="table-element ">

                    <div class="table-element ">9 Mois</div>
                    <div class="table-element ">Antirougeoleux</div>
                    <?php checkVaccine(5, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="5-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="5-refait" <?= $refait ?> class="table-element ">
                    <input type="text" name="5-obs" <?= $obs ?>class="table-element ">

                    <div class="table-element ">18 Mois</div>
                    <div class="table-element ">D.TCoq + Polio Oral</div>
                    <?php checkVaccine(6, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="6-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="6-refait" <?= $refait ?>class="table-element ">
                    <input type="text" name="6-obs" <?= $obs ?>class="table-element ">

                    <div class="table-element ">1ère Année Fondamentale</div>
                    <div class="table-element ">D.T.enfant + Polio Oral + Antirougeoleux</div>
                    <?php checkVaccine(7, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="7-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="7-refait" <?= $refait ?> class="table-element ">
                    <input type="text" name="7-obs" <?= $obs ?> class="table-element ">

                    <div class="table-element ">6ère Année Fondamentale</div>
                    <div class="table-element ">D.T.Adult + Polio Oral</div>
                    <?php checkVaccine(8, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="8-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="8-refait" <?= $refait ?>class="table-element ">
                    <input type="text" name="8-obs" <?= $obs ?>class="table-element ">

                    <div class="table-element ">1ère Année secondaire</div>
                    <div class="table-element ">D.T.Adult + Polio Oral</div>
                    <?php checkVaccine(9, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="9-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="9-refait" <?= $refait ?>class="table-element ">
                    <input type="text" name="9-obs" <?= $obs ?>class="table-element ">

                    <div class="table-element ">Tous les dix ans après 18 ans</div>
                    <div class="table-element ">D.T.Adult</div>
                    <?php checkVaccine(10, $vaccinations, $fait, $refait, $obs, $view) ?>
                    <input type="date" name="10-fait" <?= $fait ?>class="table-element ">
                    <input type="date" name="10-refait" <?= $refait ?>class="table-element ">
                    <input type="text" name="10-obs" <?= $obs ?>class="table-element ">
                </div>
                <?php if (!$view) : ?>
                    <button class="btn" style="position:aboslute;bottom:0;width: 20%;align-self:center" type="submit">Confirmer</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <script>
        const dateInput = document.querySelectorAll('input[type="date"]');
        // console.log(dateInput)
        const obsInput = document.querySelectorAll('input[type="text"]');
        const confirm = document.querySelector('.btn')

        // const selectedDate = new Date(this.value);
        // function checkDates() {
        //     dateInput.forEach(e => {
        //         let adjacent
        //         if (e.name.split("'")[1] == "fait") {
        //             adjacent = e.nextElementSibling
        //         } else if (e.name.split("'")[1] == "refait") {
        //             adjacent = e.previousElementSibling
        //         }
        //         if (e.value === '') {
        //             adjacent.required = false
        //         } else {
        //             adjacent.required = true
        //         }

        //     });
        // }
        // })
        dateInput.forEach(e => {
            e.addEventListener('change', function() {
                if (e.name.split("-")[1] == "fait") {
                    adjacent = e.nextElementSibling
                } else if (e.name.split("-")[1] == "refait") {
                    adjacent = e.previousElementSibling
                }
                if (e.value != "") {
                    adjacent.required = true
                } else {
                    adjacent.required = false
                }
            });
        })
        // const date = document.getElementById('date');

        // date.addEventListener('input', function() {
        //     const enteredDate = this.value.replace(/-/g, '');
        //     let formattedDate = '';
        //     for (let i = 0; i < enteredDate.length; i++) {
        //         if (i === 1 || i === 3) {
        //             formattedDate += enteredDate.charAt(i) + '-';
        //         } else {
        //             formattedDate += enteredDate.charAt(i);
        //         }
        //     }
        //     this.value = formattedDate;
        // });
        obsInput.forEach(e => {
            e.addEventListener('input', function() {
                let refait = e.previousElementSibling
                let fait = refait.previousElementSibling
                if (e.value != "") {
                    refait.required = true
                    fait.required = true
                } else {
                    refait.required = false
                    fait.required = false
                }
            });
        })
    </script>
</body>

</html>