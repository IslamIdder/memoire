<?php
if (!isset($_SESSION['id']))
    header('Location: ../login.php');

function checkDisorder(&$value)
{
    if (isset($value) && $value != "")
        return $value;
    else {
        return "/";
    }
}
$sql = "SELECT * FROM visites 
INNER JOIN etudiant on visites.id_etudiant = etudiant.id_etudiant 
INNER JOIN classe on etudiant.id_classe = classe.id_classe 
where visites.id_etudiant = $id and type_visite='psychologue' 
order by date_visite";
$result = mysqli_query($conn, $sql);
$numRows = mysqli_num_rows($result);

if ($numRows > 0) :
    $numPages = ceil($numRows / 5);

    for ($pageNum = 1; $pageNum <= $numPages; $pageNum++) :
        $start = ($pageNum - 1) * 5;
        $finish = min($start + 5, $numRows); ?>

        <div class="dossier flex flex-j-center">
            <div class="page-container flex flex-column ">
                <h6 class="flex-center">Examen Psychologique</h6>
                <div class="table-med t-3">
                    <div class="table-element"> Date de l'examen</div>
                    <div class="table-element">Classe fréquentée</div>
                    <div class="table-element">Age de l'élève</div>
                    <?php
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $date_naissance = $row['date_naissance'];
                        $currentDate = $row['date_visite'];
                        $diff = date_diff(date_create($date_naissance), date_create($currentDate));
                        $age = $diff->y;
                        echo '<div class="table-element"> ' . format($row['date_visite']) . '</div>';
                        echo '<div class="table-element">' . $row['nom_classe'] . '</div>';
                        echo '<div class="table-element">' . $age . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Anxiety-related issues</h6>
                <div class="table-med t-3">
                    <div class="table-element">Stress</div>
                    <div class="table-element">General anxiety</div>
                    <div class="table-element">Social anxiety</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['stress']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['generalized anxiety']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['social anxiety']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Relationship issues</h6>
                <div class="table-med t-3">
                    <div class="table-element"> Conflict with friends</div>
                    <div class="table-element">Family issues</div>
                    <div class="table-element">Bullying</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['conflict']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['family']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['bullying']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Adjustment-related Issues</h6>
                <div class="table-med t-3">
                    <div class="table-element">Homesickness</div>
                    <div class="table-element">Cultural adjustement</div>
                    <div class="table-element">Transition difficulties</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['homesickness']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['cultural']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['transition']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Focus issues</h6>
                <div class="table-med t-2">
                    <div class="table-element">ADHD</div>
                    <div class="table-element">Attention difficulties</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['adhd']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['attention']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Linguinstic issues</h6>
                <div class="table-med t-2">
                    <div class="table-element">Dyslexia</div>
                    <div class="table-element">Language barrier</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['dylexia']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['barrier']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Learning difficulties</h6>
                <div class="table-med t-2">
                    <div class="table-element">Learning struggle</div>
                    <div class="table-element">Dyscalculia</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['struggle']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['dyscalculia']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Sleep disorders</h6>
                <div class="table-med t-3">
                    <div class="table-element">insomnia</div>
                    <div class="table-element">Hypersomnia</div>
                    <div class="table-element">Sleep-wake diturbances</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['insomnia']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['hypersomnia']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['distrubances']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Behavioural issues</h6>
                <div class="table-med t-2">
                    <div class="table-element">Agressiveness</div>
                    <div class="table-element">Restlesness</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['agressiveness']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['restlesness']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h6 class="flex-center">Mental disorders</h6>
                <div class="table-med t-2">
                    <div class="table-element">Depression</div>
                    <div class="table-element">Bipolar</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $disorders = array();
                        $id_visite = $row['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['depression']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['bipolar']) . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    $start += 5;
                    ?>
                </div>
            </div>
        </div>
<?php endfor;
endif; ?>