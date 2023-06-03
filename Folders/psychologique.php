<?php session_start();
function checkSet($show_button, &$value)
{
    if (isset($value))
        return $value;
    else if ($show_button == false) {
        return " disabled ";
    }
}
$show_button = true;
if (isset($_GET['id_visite'])) {
    $id_visite = $_GET['id_visite'];
    require_once('../config.php');
    $stmt = $conn->prepare("SELECT * from disorders 
    INNER JOIN visites on visites.id_visite = disorders.id_visite
    INNER JOIN etudiant on etudiant.id_etudiant = visites.id_etudiant
    where visites.id_visite=?");
    $stmt->bind_param("i", $id_visite);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die(mysqli_error($conn));
    }
    $show_button = false;
    $disorders = array();
    $disorders_headers = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $nom = $row['nom'];
        $prenom = $row['prenom'];
        $disorders[$row['name_disorder']] = 'disabled checked';
        $disorders_headers[$row['category_disorder']] = 'disabled checked';
    }
} else
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('../config.php');
    $id_student = $_GET['id'];
    $id_docteur = $_SESSION['id'];
    $type_visite = $_SESSION['doctor_type'];
    $date = date('Y/m/d');
    $stmt = $conn->prepare("INSERT INTO visites (date_visite, id_etudiant, id_docteur,type_visite) VALUES (?,?,?,?)");
    $stmt->bind_param("siss", $date, $id_student, $id_docteur, $type_visite);
    $stmt->execute();
    $visit_id = mysqli_insert_id($conn);
    if (isset($_POST['disorders'])) {
        $disorders = $_POST['disorders'];
        $array = array();
        foreach ($disorders as $disorder) {
            $array[] = $disorder;
            $parts = explode("_", $disorder);
            $category = $parts[0];
            $name = $parts[1];
            $id_disorder = $visit_id . "_" . $name;
            $stmt = $conn->prepare("INSERT INTO disorders(id_disorder,name_disorder,category_disorder,id_visite) VALUES (?,?,?,?)");
            if ($stmt->error) {
                die($stmt->error);
            }
            $stmt->bind_param("sssi", $id_disorder, $name,  $category, $visit_id);
            $stmt->execute();
        }
    }
    require_once("../send_message.php");
    sand_mail($id_student);
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
    <h2 class="flex-center g-10 mt-20">Psychological exam <?php if (!$show_button) echo " of the student <span class=\"highlighted\">" . $nom . " " . $prenom . "</span>" ?></h2>
    <form method="post" class="general flex flex-j-center  g-30">
        <div class="flex flex-column g-10 fb-33">
            <div class="fs-25 fw-700">Social issues</div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="pop-up-checkbox cbx" <?= checkSet($show_button, $disorders_headers['anxiety']) ?> id="anxiety" value="anxiety" type="checkbox" />
                    <label class="inp-cbx" for="anxiety">Anxiety-related issues</label>
                </div>
                <div class="flex flex-column g-10 ml-20" id="id_1" style="display:none;">
                    <div class="flex flex-a-center g-10">
                        <input class=" cbx" <?= checkSet($show_button, $disorders['stress']) ?> id="stress" value="anxiety_stress" name="disorders[]" type="checkbox" />
                        <label class="inp-cbx" for="stress">Stress</label>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class=" cbx" <?= checkSet($show_button, $disorders['generalized anxiety']) ?> id="generalized_anxiety" value="anxiety_generalized anxiety" name="disorders[]" type="checkbox" />
                        <label class="inp-cbx" for="generalized_anxiety">Generalized anxiety</label>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class=" cbx" <?= checkSet($show_button, $disorders['social anxiety']) ?> id="social_anxiety" value="anxiety_social anxiety" name="disorders[]" type="checkbox" />
                        <label class="inp-cbx" for="social_anxiety">Social anxiety</label>
                    </div>
                </div>
                <div class="flex flex-column g-10">
                    <div class="flex flex-a-center g-10">
                        <input class="pop-up-checkbox cbx" id="relationship_issues" <?= checkSet($show_button, $disorders_headers['relationship']) ?> value="relationship" type="checkbox" />
                        <label class="inp-cbx" for="relationship_issues">Relationship issues</label>
                    </div>
                    <div class="flex flex-column g-10 ml-20" id="id_2" style="display:none;">
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['conflict']) ?> id="conflict" value="relationship_conflict" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="conflict">Conflict with friends</label>
                        </div>
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['family']) ?> id="family" value="relationship_family" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="family">Family issues</label>
                        </div>
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['bullying']) ?> id="bullying" value="relationship_bullying" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="bullying">Bullying</label>
                        </div>
                    </div>
                </div>
                <div class="flex flex-column g-10">
                    <div class="flex flex-a-center g-10">
                        <input class="pop-up-checkbox cbx" <?= checkSet($show_button, $disorders_headers['adjustement']) ?> id="adjustment" value="adjustement" type="checkbox" />
                        <label class="inp-cbx" for="adjustment">Adjustment-related Issues</label>
                    </div>
                    <div class="flex flex-column g-10 ml-20" id="id_3" style="display:none;">
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['homesickness']) ?> id="homesickness" value="adjustement_homesickness" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="homesickness">Homesickness</label>
                        </div>
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['cultural']) ?> id="cultural" value="adjustement_cultural" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="cultural">Cultural adjustement</label>
                        </div>
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['transition']) ?> id="transition" value="adjustement_transition" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="transition">Transition difficulties</label>
                        </div>
                    </div>
                </div>

                <?php if ($show_button == true) : ?>
                    <div class="va-header">
                        <button type="submit" class="btn">Confirmer</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex flex-column g-10 fb-33">
            <div class="fs-25 fw-700">Academic difficulties</div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="pop-up-checkbox cbx" <?= checkSet($show_button, $disorders_headers['focus']) ?> id="focus" value="focus" type="checkbox" />
                    <label class="inp-cbx" for="focus">Focus issues</label>
                </div>
                <div class="flex flex-column g-10 ml-20" id="id_4" style="display:none;">
                    <div class="flex flex-a-center g-10">
                        <input class=" cbx" <?= checkSet($show_button, $disorders['adhd']) ?> id="adhd" value="focus_adhd" name="disorders[]" type="checkbox" />
                        <label class="inp-cbx" for="adhd">ADHD</label>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class=" cbx" <?= checkSet($show_button, $disorders['attention']) ?> id="attention" value="focus_attention" name="disorders[]" type="checkbox" />
                        <label class="inp-cbx" for="attention">Attention difficulties</label>
                    </div>
                </div>
                <div class="flex flex-column g-10">
                    <div class="flex flex-a-center g-10">
                        <input class="pop-up-checkbox cbx" id="linguistic" <?= checkSet($show_button, $disorders_headers['linguistic']) ?> value="linguistic" type="checkbox" />
                        <label class="inp-cbx" for="linguistic">Linguinstic issues</label>
                    </div>
                    <div class="flex flex-column g-10 ml-20" id="id_5" style="display:none;">
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['dylexia']) ?> id="dylexia" value="linguistic_dylexia" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="dylexia">Dyslexia</label>
                        </div>
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['barrier']) ?> id="barrier" value="linguistic_barrier" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="barrier">Language barrier</label>
                        </div>
                    </div>
                </div>
                <div class="flex flex-column g-10">
                    <div class="flex flex-a-center g-10">
                        <input class="pop-up-checkbox cbx" <?= checkSet($show_button, $disorders_headers['learning']) ?> id="learning" value="learning" type="checkbox" />
                        <label class="inp-cbx" for="learning">Learning difficulties</label>
                    </div>
                    <div class="flex flex-column g-10 ml-20" id="id_6" style="display:none;">
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['struggle']) ?> id="struggle" value="learning_struggle" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="struggle">Learning struggle</label>
                        </div>
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['dyscalculia']) ?> id="dyscalculia" value="learning_dyscalculia" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="dyscalculia">Dyscalculia</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="flex flex-column g-10 fb-33">
            <div class="fs-25 fw-700">Other</div>
            <div class="flex flex-column g-10">
                <div class="flex flex-a-center g-10">
                    <input class="pop-up-checkbox cbx" <?= checkSet($show_button, $disorders_headers['sleep']) ?> id="sleep" value="sleep" type="checkbox" />
                    <label class="inp-cbx" for="sleep">Sleep disorders</label>
                </div>
                <div class="flex flex-column g-10 ml-20" id="id_7" style="display:none;">
                    <div class="flex flex-a-center g-10">
                        <input class=" cbx" <?= checkSet($show_button, $disorders['insomnia']) ?> id="insomnia" value="sleep_insomnia" name="disorders[]" type="checkbox" />
                        <label class="inp-cbx" for="insomnia">insomnia</label>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class=" cbx" <?= checkSet($show_button, $disorders['hypersomnia']) ?> id="hypersomnia" value="sleep_hypersomnia" name="disorders[]" type="checkbox" />
                        <label class="inp-cbx" for="hypersomnia">Hypersomnia</label>
                    </div>
                    <div class="flex flex-a-center g-10">
                        <input class=" cbx" <?= checkSet($show_button, $disorders['distrubances']) ?> id="distrubances" value="sleep_distrubances" name="disorders[]" type="checkbox" />
                        <label class="inp-cbx" for="disturbances">Sleep-wake diturbances</label>
                    </div>
                </div>
                <div class="flex flex-column g-10">
                    <div class="flex flex-a-center g-10">
                        <input class="pop-up-checkbox cbx" id="behavioural" <?= checkSet($show_button, $disorders_headers['behavioural']) ?> value="behavioural" type="checkbox" />
                        <label class="inp-cbx" for="behavioural">Behavioural issues</label>
                    </div>
                    <div class="flex flex-column g-10 ml-20" id="id_8" style="display:none;">
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['agressiveness']) ?> id="agressiveness" value="behavioural_agressiveness" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="agressiveness">Agressiveness</label>
                        </div>
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['restlesness']) ?> id="restlesness" value="behavioural_restlesness" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="restlesness">Restlesness</label>
                        </div>
                    </div>
                </div>
                <div class="flex flex-column g-10">
                    <div class="flex flex-a-center g-10">
                        <input class="pop-up-checkbox cbx" <?= checkSet($show_button, $disorders_headers['mental']) ?> id="mental" value="mental" type="checkbox" />
                        <label class="inp-cbx" for="mental">Mental disorders</label>
                    </div>
                    <div class="flex flex-column g-10 ml-20" id="id_9" style="display:none;">
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['depression']) ?> id="depression" value="mental_depression" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="depression">Depression</label>
                        </div>
                        <div class="flex flex-a-center g-10">
                            <input class=" cbx" <?= checkSet($show_button, $disorders['bipolar']) ?> id="bipolar" value="mental_bipolar" name="disorders[]" type="checkbox" />
                            <label class="inp-cbx" for="bipolar">Bipolar </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        const checkBoxes = document.querySelectorAll('.pop-up-checkbox');
        checkBoxes.forEach((cb, i) => {
            let popup = document.querySelector("#id_" + (i + 1))
            if (cb.checked) {
                popup.style.display = 'flex';
                popup.childNodes.forEach(c => {
                    c.required = true
                })
            } else {
                popup.style.display = 'none';
                popup.childNodes.forEach(c => {
                    c.required = false
                })
            }
            cb.addEventListener('click', () => {
                if (cb.checked) {
                    popup.style.display = 'flex';
                    popup.childNodes.forEach(c => {
                        c.required = true
                    })
                } else {
                    popup.style.display = 'none';
                    popup.childNodes.forEach(c => {
                        c.required = false
                    })
                    popup.querySelectorAll('input name="disorders[]"[type="checkbox"').forEach(i => {
                        i.checked = false
                    })
                }
            })
        })
    </script>
</body>


</html>