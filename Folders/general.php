<?php session_start();
function checkSet(&$value)
{
    if (isset($value))
        return $value . "disabled";
}
$view = false;
if (isset($_GET['id_visite'])) {
    $id_visite = $_GET['id_visite'];
    require_once('../config.php');
    $stmt = $conn->prepare("SELECT * from visites 
    LEFT JOIN etudiant on etudiant.id_etudiant = visites.id_etudiant
    LEFT JOIN maladie on maladie.id_visite = visites.id_visite
    LEFT JOIN antecedents on antecedents.id_visite = visites.id_visite
    where visites.id_visite=?");
    $stmt->bind_param("i", $id_visite);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die(mysqli_error($conn));
    }
    $view = true;
    $maladies = array("neurologique" => "disabled ", "rachis" => "disabled ", "genital" => "disabled ", "orl" => "disabled ", "urinaire" => "disabled ", "ophalmique" => "disabled ", "endocrinien" => "disabled ", "cardio" => "disabled ", "respiratoire" => "disabled ", "peau" => "disabled ", "digestif" => "disabled ");
    $antecedents = array("asthme" => "disabled  ", "diabete" => "disabled  ", "epilepsie" => "disabled  ", "hospitalisation" => "disabled  ");
    $att = "disabled value=\"";
    while ($row = mysqli_fetch_assoc($result)) {
        $nom = $row['nom'];
        $prenom = $row['prenom'];
        $age = $att . $row['age'] . "\"";
        $height = $att . $row['height'] . "\"";
        $weight = $att . $row['weight'] . "\"";
        $tention = $att . $row['tention'] . "\"";
        $od = $att . $row['visuelle_OD'] . "\"";
        $og = $att . $row['visuelle_OG'] . "\"";
        $cause = $att . $row['cause'] . "\"";
        if (isset($row['nom_antecedent']))
            if ($row['nom_antecedent'] == 'hospitalisation')
                $date_hos = $att . $row['date_antecedent'] . "\"";
            else if ($row['nom_antecedent'] == 'diabete')
                $date_dia = $att . $row['date_antecedent'] . "\"";
            else if ($row['nom_antecedent'] == 'asthme')
                $freq_as = $att . $row['frequence'] . "\"";
            else if ($row['nom_antecedent'] == 'epilepsie')
                $freq_ep = $att . $row['frequence'] . "\"";
        if (isset($row['nom_antecedent']))
            $antecedents[$row['nom_antecedent']] = " disabled checked ";
        if (isset($row['nom_maladie']))
            $maladies[$row['nom_maladie']] .= " disabled checked ";
    }
} else
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_student = $_GET['id'];
    $id_docteur = $_SESSION['id'];
    $type_visite = $_SESSION['doctor_type'];
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
    $height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_INT);
    $date = date('Y/m/d');
    $od = filter_input(INPUT_POST, 'od', FILTER_SANITIZE_NUMBER_INT);
    $og = filter_input(INPUT_POST, 'og', FILTER_SANITIZE_NUMBER_INT);
    $ten = filter_input(INPUT_POST, 'tention', FILTER_SANITIZE_NUMBER_INT);
    require_once('../config.php');
    $stmt = $conn->prepare("INSERT INTO visites(id_etudiant, id_docteur, type_visite, age, height, weight, visuelle_OD, visuelle_OG, date_visite, tention) 
        VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("issiiiiisi", $id_student, $id_docteur, $type_visite, $age, $height, $weight, $od, $og, $date, $ten);
    $stmt->execute();
    $visit_id = mysqli_insert_id($conn);
    if (isset($_POST['illness'])) {
        $illnesses = $_POST['illness'];
        $array = array();
        foreach ($illnesses as $illness) {
            $array[] = $illness;
            $id_maladie = $visit_id . "_" . $illness;
            $stmt = $conn->prepare("INSERT INTO maladie(id_maladie,id_visite, nom_maladie) VALUES (?,?, ?)");
            $stmt->bind_param("sis", $id_maladie, $visit_id, $illness);
            $stmt->execute();
        }
    }
    if (isset($_POST['hospitalisation'])) {
        $cause_hospitalisation = $_POST['cause_hospitalisation'];
        $date_hospitalisation = $_POST['date_hospitalisation'];
        $nom_antecedent = "hospitalisation";
        $num_antecedent = 0;
        $id_antecedent = $visit_id . "_" . $nom_antecedent;
        $stmt = $conn->prepare("INSERT INTO antecedents(id_antecedent,nom_antecedent,id_visite,num_antecedent,cause,date_antecedent) values(?,?,?,?,?,?);");
        $stmt->bind_param("ssiiss", $id_antecedent, $nom_antecedent, $visit_id, $num_antecedent, $cause_hospitalisation, $date_hospitalisation);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        }
    }

    if (isset($_POST['epilepsie'])) {
        $frequence_epilepsie = $_POST['frequence_epilepsie'];
        $nom_antecedent = "epilepsie";
        $num_antecedent = 3;
        $id_antecedent = $visit_id . "_" . $nom_antecedent;
        $stmt = $conn->prepare("INSERT INTO antecedents(id_antecedent,nom_antecedent,id_visite,num_antecedent,frequence) values(?,?,?,?,?);");
        $stmt->bind_param("ssiii", $id_antecedent, $nom_antecedent, $visit_id, $num_antecedent, $frequence_epilepsie);
        if ($stmt->error) {
            // An error occurred
            echo "Error: " . $stmt->error;
        }
        $stmt->execute();
    }
    if (isset($_POST['asthme'])) {
        $frequence_asthme = $_POST['frequence_asthme'];
        $nom_antecedent = "asthme";
        $num_antecedent = 2;
        $id_antecedent = $visit_id . "_" . $nom_antecedent;
        $stmt = $conn->prepare("INSERT INTO antecedents(id_antecedent,nom_antecedent,id_visite,num_antecedent,frequence) values(?,?,?,?,?);");
        $stmt->bind_param("ssiii", $id_antecedent, $nom_antecedent, $visit_id, $num_antecedent, $frequence_asthme);
        $stmt->execute();
        if ($stmt->error) {
            // An error occurred
            echo "Error: " . $stmt->error;
        }
    }
    if (isset($_POST['diabete'])) {
        $date_diabete = $_POST['date_diabete'];
        $nom_antecedent = "diabete";
        $num_antecedent = 1;
        $id_antecedent = $visit_id . "_" . $nom_antecedent;
        $stmt = $conn->prepare("INSERT INTO antecedents(id_antecedent,nom_antecedent,id_visite,num_antecedent,date_antecedent) values(?,?,?,?,?);");
        $stmt->bind_param("ssiis", $id_antecedent, $nom_antecedent, $visit_id, $num_antecedent, $date_diabete);
        $stmt->execute();
        if ($stmt->error) {
            // An error occurred
            echo "Error: " . $stmt->error;
        }
    }
    header("Location:dossier.php?id=" . $id_student);
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Add student</title>
    <link rel="stylesheet" type="text/css" href="../CSS/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="../Scripts/script.js" defer></script>
</head>

<body class="input-page">
    <?php include('../nav-bar.php'); ?>
    <h2 class="flex-center g-10 mt-20">Medical exam<?php if ($view) echo " of the student <span class=\"highlighted\">" . $nom . " " . $prenom . "</span>" ?></h2>
    <form method="post" class="general flex flex-j-center g-30">
        <div class="section1 flex fb-40 flex-column flex-a-s flex-j-s g-10">
            <div class="fs-25 fw-700">Examen Medical De Depistage</div>
            <div class="input-group-container flex flex-column">
                <label class="mb-10">Information de l'élève:</label>
                <div class="flex flex-column g-20">
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" <?= checkSet($age) ?> placeholder=" " name="age" required>
                        <label class="label">Age</label>
                    </div>
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" <?= checkSet($height) ?> placeholder=" " name="height" required>
                        <label class="label">Height</label>
                    </div>
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" <?= checkSet($weight) ?> placeholder=" " name="weight" required>
                        <label class="label">Weight</label>
                    </div>
                </div>
            </div>
            <div class="input-group-container flex flex-column ">
                <label class="mb-10 mt-10">Tension Arteriellle:</label>
                <div class="va-header">
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" <?= checkSet($tention) ?> placeholder=" " name="tention" required>
                        <label class="label">Tention</label>
                    </div>
                </div>
            </div>
            <div class="input-group-container flex flex-column">
                <label class="mb-10 mt-10">Etat visuel:</label>
                <div class="flex g-20 flex-column">

                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" <?= checkSet($od) ?> placeholder=" " name="od" required>
                        <label class="label">Acuité OD</label>
                    </div>

                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" <?= checkSet($og) ?> placeholder=" " name="og" required>
                        <label class="label">Acuité OG</label>
                    </div>
                </div>
            </div>
            <?php if ($view != true) : ?>
                <div class="va-header">
                    <button type="submit" class="btn">Confirmer</button>
                </div>
            <?php endif; ?>
        </div>
        <div class="flex flex-column g-10 fb-30">
            <div class="fs-25 fw-700">Antécédents de L'élève</div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="pop-up-checkbox cbx" <?= checkSet($antecedents['hospitalisation']) ?> id="hospitalisation" name="hospitalisation" type="checkbox" />
                    <label class="inp-cbx" for="hospitalisation">Hospitalisation</label>
                </div>
                <div class="flex flex-column g-10" id="id_1" style="display:none;">
                    <div class="input_box">
                        <input class="input" type="text" <?= checkSet($cause) ?> autocomplete="off" placeholder=" " name="cause_hospitalisation">
                        <label class="label">Cause</label>
                    </div>
                    <input class="input-field" type="date" <?= checkSet($date_hos) ?> name="date_hospitalisation" placeholder="date">
                </div>
            </div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="pop-up-checkbox cbx" id="epilepsie" <?= checkSet($antecedents['epilepsie']) ?> name="epilepsie" type="checkbox" />
                    <label class="inp-cbx" for="epilepsie">Epilepsie</label>
                </div>
                <div class="flex flex-column" id="id_2" style="display:none;">
                    <div class="input_box">
                        <input class="input" type="text" <?= checkSet($freq_ep) ?> autocomplete="off" placeholder=" " name="frequence_epilepsie">
                        <label class="label">Frequence</label>
                    </div>
                </div>
            </div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="pop-up-checkbox cbx" <?= checkSet($antecedents['asthme']) ?> id="asthme" name="asthme" type="checkbox" />
                    <label class="inp-cbx" for="asthme">Asthme</label>
                </div>

                <div class="flex flex-column" id="id_3" style="display:none;">
                    <div class="input_box">
                        <input class="input" type="text" <?= checkSet($freq_as) ?> autocomplete="off" placeholder=" " name="frequence_asthme">
                        <label class="label">Frequence</label>
                    </div>
                </div>
            </div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="pop-up-checkbox cbx" <?= checkSet($antecedents['diabete']) ?> id="diabete" name="diabete" type="checkbox" />
                    <label class="inp-cbx" for="diabete">Diabete<span>
                </div>
                <div class="flex flex-column" id="id_4" style="display:none;">
                    <input class="input-field popup" <?= checkSet($date_dia) ?> type="date" name="date_diabete" placeholder="date de debut">
                </div>
            </div>
        </div>
        <div class="section3 fb-30">
            <div class="flex flex-column g-10 ">
                <div class="fs-25 fw-700">Examen Medical</div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="neurologique" <?= checkSet($maladies['neurologique']) ?> value="neurologique" name="illness[]" type="checkbox" />
                    <label class="cbx" for="neurologique">Neurologique<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="endocrinien" <?= checkSet($maladies['endocrinien']) ?> value="endocrinien" name="illness[]" type="checkbox" />
                    <label class="cbx" for="endocrinien">Endocrinien<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="rachis" <?= checkSet($maladies['rachis']) ?> value="rachis" name="illness[]" type="checkbox" />
                    <label class="cbx" for="rachis">Rachis<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="pau" <?= checkSet($maladies['peau']) ?> value="peau" name="illness[]" type="checkbox" />
                    <label class="cbx" for="pau">Peau<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="ophtalmique" <?= checkSet($maladies['ophalmique']) ?> value="ophalmique" name="illness[]" type="checkbox" />
                    <label class="cbx" for="ophtalmique">Ophalmique<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="orl" <?= checkSet($maladies['orl']) ?> value="orl" name="illness[]" type="checkbox" />
                    <label class="cbx" for="orl">Orl<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="respiratoire" <?= checkSet($maladies['respiratoire']) ?> value="respiratoire" name="illness[]" type="checkbox" />
                    <label class="cbx" for="respiratoire">Respiratoire<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="cardio" <?= checkSet($maladies['cardio']) ?> value="cardio" name="illness[]" type="checkbox" />
                    <label class="cbx" for="cardio">Cardio<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="digestif" <?= checkSet($maladies['digestif']) ?> value="digestif" name="illness[]" type="checkbox" />
                    <label class="cbx" for="digestif">Digestif<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="urinaire" <?= checkSet($maladies['urinaire']) ?> value="urinaire" name="illness[]" type="checkbox" />
                    <label class="cbx" for="urinaire">Urinaire<span>
                </div>
                <div class="flex flex-a-center g-10">
                    <input class="inp-cbx" id="genital" <?= checkSet($maladies['genital']) ?> value="genital" name="illness[]" type="checkbox" />
                    <label class="cbx" for="genital">Genital<span>
                </div>
            </div>
    </form>
    <script>
        const checkBoxes = document.querySelectorAll('.pop-up-checkbox');
        checkBoxes.forEach((cb, i) => {
            let popup = document.querySelector("#id_" + (i + 1))
            if (cb.checked) {
                popup.style.display = 'flex';
                popup.querySelectorAll('input').forEach(i => {
                    i.required = true
                })
            } else {
                console.log('yo')
                popup.style.display = 'none';
                popup.querySelectorAll('input').forEach(i => {
                    i.required = false
                })
            }
            cb.addEventListener('click', () => {
                if (cb.checked) {
                    popup.style.display = 'flex';
                    popup.querySelectorAll('input').forEach(i => {
                        i.required = true
                    })
                } else {
                    popup.style.display = 'none';
                    popup.querySelectorAll('input').forEach(i => {
                        i.required = false
                    })
                }
            })
        })
    </script>
</body>


</html>