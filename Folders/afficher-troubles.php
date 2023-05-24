<?php
if (!isset($_SESSION['id']))
    header('Location: ../login.php');
$sql = "SELECT * FROM visites INNER JOIN etudiant on visites.id_etudiant = etudiant.id_etudiant and visites.id_etudiant = $id and type_visite='psychologue'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) :
    if (mysqli_num_rows($result) > 5) {
        $num_pages = ceil(mysqli_num_rows($result) / 5);
    } else {
        $num_pages = 1;
    }
    $start = 0;
    $finish = 5;
    for ($i = 1; $i <= $num_pages; $i++) :
?>
        <div class="dossier flex flex-j-center">
            <div class="page-container flex flex-column ">
                <h6 class="flex-center">Examen Psychologique</h6>
                <div class="table-med t-3">
                    <div class="table-element"> Date de l'examen</div>
                    <div class="table-element">Classe fréquentée</div>
                    <div class="table-element">Age de l'élève</div>
                    <?php
                    $sql = "SELECT * FROM visites 
                    INNER JOIN etudiant on visites.id_etudiant = etudiant.id_etudiant and visites.id_etudiant = $id and type_visite='psychologue' 
                    INNER JOIN classe on etudiant.id_classe = classe.id_classe order by date_visite asc LIMIT $start,$finish";
                    $result = mysqli_query($conn, $sql);
                    $len = mysqli_num_rows($result);
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rows[] = $row;
                    }
                    function checkDisorder(&$value)
                    {
                        if (isset($value) && $value != "")
                            return $value;
                        else {
                            return "/";
                        }
                    }
                    for ($j = 0; $j < $len; $j++) {
                        $date_naissance = $rows[$j]['date_naissance'];
                        $currentDate = $rows[$j]['date_visite'];
                        $diff = date_diff(date_create($date_naissance), date_create($currentDate));
                        $age = $diff->y;
                        echo '<div class="table-element"> ' . format($rows[$j]['date_visite']) . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['nom_classe'] . '</div>';
                        echo '<div class="table-element">' . $age . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Anxiety-related issues</h6>
                <div class="table-med t-3">
                    <div class="table-element">Stress</div>
                    <div class="table-element">General anxiety</div>
                    <div class="table-element">Social anxiety</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['stress']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['generalized anxiety']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['social anxiety']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Relationship issues</h6>
                <div class="table-med t-3">
                    <div class="table-element"> Conflict with friends</div>
                    <div class="table-element">Family issues</div>
                    <div class="table-element">Bullying</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['conflict']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['family']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['bullying']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Adjustment-related Issues</h6>
                <div class="table-med t-3">
                    <div class="table-element">Homesickness</div>
                    <div class="table-element">Cultural adjustement</div>
                    <div class="table-element">Transition difficulties</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['homesickness']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['cultural']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['transition']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Focus issues</h6>
                <div class="table-med t-2">
                    <div class="table-element">ADHD</div>
                    <div class="table-element">Attention difficulties</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['adhd']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['attention']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Linguinstic issues</h6>
                <div class="table-med t-2">
                    <div class="table-element">Dyslexia</div>
                    <div class="table-element">Language barrier</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['dylexia']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['barrier']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Learning difficulties</h6>
                <div class="table-med t-2">
                    <div class="table-element">Learning struggle</div>
                    <div class="table-element">Dyscalculia</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['struggle']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['dyscalculia']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Sleep disorders</h6>
                <div class="table-med t-3">
                    <div class="table-element">insomnia</div>
                    <div class="table-element">Hypersomnia</div>
                    <div class="table-element">Sleep-wake diturbances</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['insomnia']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['hypersomnia']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['distrubances']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Behavioural issues</h6>
                <div class="table-med t-2">
                    <div class="table-element">Agressiveness</div>
                    <div class="table-element">Restlesness</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['agressiveness']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['restlesness']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h6 class="flex-center">Mental disorders</h6>
                <div class="table-med t-2">
                    <div class="table-element">Depression</div>
                    <div class="table-element">Bipolar</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $disorders = array();
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from disorders where disorders.id_visite = '$id_visite'";
                        $dis = mysqli_query($conn, $sql);
                        while ($disorder = mysqli_fetch_assoc($dis)) {
                            $disorders[$disorder['name_disorder']] = "oui";
                        }
                        echo '<div class="table-element"> ' . checkDisorder($disorders['depression']) . '</div>';
                        echo '<div class="table-element">' . checkDisorder($disorders['bipolar']) . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
            </div>
        </div>
<?php endfor;
endif; ?>