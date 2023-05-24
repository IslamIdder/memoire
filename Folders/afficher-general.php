<?php session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_student = $_GET['id'];
    $id_docteur = $_SESSION['id'];
    $type_visite = $_SESSION['doctor_type'];
    $age = $_POST["age"];
    $height = $_POST["height"];
    $weight = $_POST["weight"];
    $date = date('Y/m/d');
    $od = $_POST["od"];
    $og = $_POST["og"];
    $ten = $_POST["tention"];
    require_once('../config.php');
    $sql = "INSERT INTO visites(id_etudiant, id_docteur, type_visite, age, height, weight, visuelle_OD, visuelle_OG, date_visite, tention) 
        VALUES ('$id_student', '$id_docteur', '$type_visite', '$age', '$height', '$weight', '$od', '$og', '$date', '$ten')";
    mysqli_query($conn, $sql);
    $visit_id = mysqli_insert_id($conn);
    if (isset($_POST['illness'])) {
        $illnesses = $_POST['illness'];
        $array = array();
        foreach ($illnesses as $illness) {
            $array[] = $illness;
            $id_maladie = $visit_id . "_" . $illness;
            $mal = "INSERT INTO maladie(id_maladie,id_visite, nom_maladie) VALUES ('$id_maladie','$visit_id', '$illness')";
            mysqli_query($conn, $mal);
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
    <form method="post" class="general flex flex-j-center g-30">
        <div class="section1 flex fb-40 flex-column g-10">
            <div class="fs-25 fw-700">Examen Medical De Depistage</div>
            <div class="input-group-container flex flex-column">
                <label class="mb-10">Information de l'élève:</label>
                <div class="flex flex-column g-20">
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" value="18" placeholder=" " name="age" required>
                        <label class="label">Age</label>
                    </div>
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" placeholder=" " name="height" required>
                        <label class="label">Height</label>
                    </div>
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" placeholder=" " name="weight" required>
                        <label class="label">Weight</label>
                    </div>
                </div>
            </div>
            <div class="input-group-container flex flex-column ">
                <label class="mb-10 mt-10">Tension Arteriellle:</label>
                <div class="va-header">

                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" placeholder=" " name="tention" required>
                        <label class="label">Tention</label>
                    </div>
                </div>
            </div>
            <div class="input-group-container flex flex-column">
                <label class="mb-10 mt-10">Etat visuel:</label>
                <div class="flex g-20 flex-column">

                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" placeholder=" " name="od" required>
                        <label class="label">Acuité OD</label>
                    </div>

                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" placeholder=" " name="og" required>
                        <label class="label">Acuité OG</label>
                    </div>
                </div>
            </div>
            <div class="va-header">
                <button type="submit" class="btn">Confirmer</button>
            </div>
        </div>
        <div class="flex flex-column g-10 fb-30">
            <div class="fs-25 fw-700">Antécédents de L'élève</div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="cbx" id="hospitalisation" checked name="hospitalisation" type="checkbox" />
                    <label class="cbx" for="hospitalisation">Hospitalisation<span>
                </div>
                <div class="flex flex-column g-10" id="id_1" style="display:none;">
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" placeholder=" " name="cause_hospitalisation" required>
                        <label class="label">Cause</label>
                    </div>
                    <input class="input-field" type="date" name="date_hospitalisation" placeholder="date">
                </div>
            </div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="cbx" id="epilepsie" name="epilepsie" type="checkbox" />
                    <label class="cbx" for="epilepsie">Epilepsie</label>
                </div>
                <div class="flex flex-column" id="id_2" style="display:none;">
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" placeholder=" " name="frequence_epilepsie" required>
                        <label class="label">Frequence</label>
                    </div>
                </div>
            </div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="cbx" id="asthme" name="asthme" type="checkbox" />
                    <label class="cbx" for="asthme">Asthme</label>
                </div>

                <div class="flex flex-column" id="id_3" style="display:none;">
                    <div class="input_box">
                        <input class="input" type="text" autocomplete="off" placeholder=" " name="frequence_asthme" required>
                        <label class="label">Frequence</label>
                    </div>
                </div>
            </div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="cbx" id="diabete" name="diabete" type="checkbox" />
                    <label class="cbx" for="diabete">Diabete<span>
                </div>
                <div class="flex flex-column" id="id_4" style="display:none;">
                    <input class="input-field popup" type="date" name="date_diabete" placeholder="date de debut">
                </div>
            </div>
        </div>
        <div class="section3 fb-30">
            <div class="fs-25 fw-700">Examen Medical</div>
            <div class="flex g-10" style="flex-wrap:wrap;">
                <div class="flex flex-column g-5 ">
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="neurologique" value="neurologique" name="illness[]" type="checkbox" />
                        <label class="cbx" for="neurologique">Neurologique<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="endocrinien" value="endocrinien" name="illness[]" type="checkbox" />
                        <label class="cbx" for="endocrinien">Endocrinien<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="rachis" value="rachis" name="illness[]" type="checkbox" />
                        <label class="cbx" for="rachis">Rachis<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="pau" value="peau" name="illness[]" type="checkbox" />
                        <label class="cbx" for="pau">Peau<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="ophtalmique" value="ophtalmique" name="illness[]" type="checkbox" />
                        <label class="cbx" for="ophtalmique">Ophalmique<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="orl" value="orl" name="illness[]" type="checkbox" />
                        <label class="cbx" for="orl">Orl<span>
                    </div>
                </div>
                <div class="flex flex-column">
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="respiratoire" value="respiratoire" name="illness[]" type="checkbox" />
                        <label class="cbx" for="respiratoire">Respiratoire<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="cardio" value="cardio" name="illness[]" type="checkbox" />
                        <label class="cbx" for="cardio">Cardio<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="digestif" value="digestif" name="illness[]" type="checkbox" />
                        <label class="cbx" for="digestif">Digestif<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="urinaire" value="urinaire" name="illness[]" type="checkbox" />
                        <label class="cbx" for="urinaire">Urinaire<span>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class="inp-cbx" id="genital" value="genital" name="illness[]" type="checkbox" />
                        <label class="cbx" for="genital">Genital<span>
                    </div>
                </div>
            </div>
    </form>
    <script>
        const checkBoxes = document.querySelectorAll('.cbx');
        checkBoxes.forEach((cb, i) => {
            cb.addEventListener('click', () => {
                if (cb.checked) {
                    document.querySelector("id_" + i).display = 'flex';
                } else {
                    document.querySelector("id_" + i).display = 'none';
                }
            })
        })
        // checkbox1.addEventListener('click', () => {
        //     if (checkbox1.checked) {
        //         inputContainer1.style.display = 'flex';
        //     } else {
        //         inputContainer1.style.display = 'none';
        //     }
        // });

        // checkbox2.addEventListener('click', () => {
        //     if (checkbox2.checked) {
        //         inputContainer2.style.display = 'flex';
        //     } else {
        //         inputContainer2.style.display = 'none';
        //     }
        // });

        // checkbox3.addEventListener('click', () => {
        //     if (checkbox3.checked) {
        //         inputContainer3.style.display = 'flex';
        //     } else {
        //         inputContainer3.style.display = 'none';
        //     }
        // });
        // checkbox4.addEventListener('click', () => {
        //     if (checkbox4.checked) {
        //         inputContainer4.style.display = 'flex';
        //     } else {
        //         inputContainer4.style.display = 'none';
        //     }
        // });
    </script>
</body>


</html>