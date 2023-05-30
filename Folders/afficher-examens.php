<?php
if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM visites
        INNER JOIN etudiant ON visites.id_etudiant = etudiant.id_etudiant
        INNER JOIN classe ON etudiant.id_classe = classe.id_classe
        WHERE visites.id_etudiant = ? AND type_visite = 'generaliste'
        ORDER BY date_visite ASC");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$numRows = mysqli_num_rows($result);

if ($numRows > 0) :
    $numPages = ceil($numRows / 5);

    for ($pageNum = 1; $pageNum <= $numPages; $pageNum++) :
        $start = ($pageNum - 1) * 5;
        $finish = min($start + 5, $numRows); ?>

        <div class="dossier flex flex-j-center">
            <div class="page-container flex flex-column">
                <h3 class="flex-center">Examen Medical de depistage</h3>
                <div class="table-med t-3">
                    <div class="table-element">Date de l'examen</div>
                    <div class="table-element">Classe fréquentée</div>
                    <div class="table-element">Age de l'élève</div>
                    <?php
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $dateNaissance = $row['date_naissance'];
                        $currentDate = $row['date_visite'];
                        $diff = date_diff(date_create($dateNaissance), date_create($currentDate));
                        $age = $diff->y;

                        echo '<div class="table-element">' . format($row['date_visite']) . '</div>';
                        echo '<div class="table-element">' . $row['nom_classe'] . '</div>';
                        echo '<div class="table-element">' . $age . '</div>';
                    }

                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    } ?>
                </div>
                <div class="table-med t-4">
                    <div class="table-element">Tension artérielle</div>
                    <div class="table-element">Acuité OD</div>
                    <div class="table-element">Acuité OG</div>
                    <div class="table-element">Pédiculose</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        echo '<div class="table-element">' . $row['tention'] . '</div>';
                        echo '<div class="table-element">' . $row['visuelle_OD'] . '</div>';
                        echo '<div class="table-element">' . $row['visuelle_OG'] . '</div>';
                        echo '<div class="table-element"></div>';
                    }
                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    }
                    ?>
                </div>
                <h3 class="flex-center">Antécédents de l'élève</h3>
                <div class="table-med t-4">
                    <div class="table-element">Hospitalisations</div>
                    <div class="table-element">Diabète</div>
                    <div class="table-element">Asthme</div>
                    <div class="table-element">Epilipsie</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $idVisite = $row['id_visite'];
                        $antecedentsParVisite = array_fill(0, 4, "/");
                        $sql = "SELECT * FROM antecedents WHERE id_visite = '$idVisite'";
                        $antecedentsResult = mysqli_query($conn, $sql);
                        while ($antecedent = mysqli_fetch_assoc($antecedentsResult)) {
                            $num = $antecedent['num_antecedent'];
                            switch ($num) {
                                case 0:
                                    $antecedentsParVisite[0] = $antecedent['date_antecedent'];
                                    break;
                                case 1:
                                    $antecedentsParVisite[1] = $antecedent['date_antecedent'];
                                    break;
                                case 2:
                                    $antecedentsParVisite[2] = $antecedent['frequence'];
                                    break;
                                case 3:
                                    $antecedentsParVisite[3] = $antecedent['frequence'];
                                    break;
                            }
                        }
                        echo '<div class="table-element">' . $antecedentsParVisite[0] . '</div>';
                        echo '<div class="table-element">' . $antecedentsParVisite[1] . '</div>';
                        echo '<div class="table-element">' . $antecedentsParVisite[2] . '</div>';
                        echo '<div class="table-element">' . $antecedentsParVisite[3] . '</div>';
                    }
                    for ($j = $finish - $start; $j < 5; $j++) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                    } ?>
                </div>
                <h3 class="flex-center">Examen Médical</h3>
                <div class="table-med t-11">
                    <div class="table-element">app.Neurologique</div>
                    <div class="table-element">app.Endocrinien</div>
                    <div class="table-element">Rachis et membres</div>
                    <div class="table-element">Peau et phanères</div>
                    <div class="table-element">app.Ophtalmique</div>
                    <div class="table-element">app.ORL</div>
                    <div class="table-element">app.Respiratoire</div>
                    <div class="table-element">app.Cardio-vasculaire</div>
                    <div class="table-element">app.Digestif</div>
                    <div class="table-element">app.Urinaire</div>
                    <div class="table-element">app.Génital</div>
                    <?php
                    mysqli_data_seek($result, $start);
                    for ($i = $start; $i < $finish; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $idVisite = $row['id_visite'];
                        $maladiesParVisite = array_fill(0, 11, "/");
                        $sql = "SELECT * FROM maladie WHERE id_visite = '$idVisite'";
                        $maladiesResult = mysqli_query($conn, $sql);
                        while ($maladie = mysqli_fetch_assoc($maladiesResult)) {
                            switch ($maladie['nom_maladie']) {
                                case 'neurologique':
                                    $maladiesParVisite[0] = "oui";
                                    break;
                                case 'endocrinien':
                                    $maladiesParVisite[1] = "oui";
                                    break;
                                case 'rachis':
                                    $maladiesParVisite[2] = "oui";
                                    break;
                                case 'peau':
                                    $maladiesParVisite[3] = "oui";
                                    break;
                                case 'ophtalmique':
                                    $maladiesParVisite[4] = "oui";
                                    break;
                                case 'orl':
                                    $maladiesParVisite[5] = "oui";
                                    break;
                                case 'respiratoire':
                                    $maladiesParVisite[6] = "oui";
                                    break;
                                case 'cardio':
                                    $maladiesParVisite[7] = "oui";
                                    break;
                                case 'digestif':
                                    $maladiesParVisite[8] = "oui";
                                    break;
                                case 'urinaire':
                                    $maladiesParVisite[9] = "oui";
                                    break;
                                case 'genital':
                                    $maladiesParVisite[10] = "oui";
                                    break;
                            }
                        }
                        echo '<div class="table-element">' . $maladiesParVisite[0] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[1] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[2] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[3] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[4] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[5] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[6] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[7] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[8] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[9] . '</div>';
                        echo '<div class="table-element">' . $maladiesParVisite[10] . '</div>';
                    }
                    for ($j = $finish - $start; $j < 5; $j++) {
                        for ($i = 1; $i <= 11; $i++) {
                            echo '<div class="table-element"></div>';
                        }
                    }
                    $start += 5;
                    ?>
                </div>
            </div>
        </div>
<?php endfor;
endif; ?>
<!-- <?php
        if (!isset($_SESSION['id']))
            header('Location: ../login.php');
        $sql = "SELECT * FROM visites INNER JOIN etudiant on visites.id_etudiant = etudiant.id_etudiant and visites.id_etudiant = $id and type_visite='generaliste'";
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
                <h3 class="flex-center">Examen Medical de depistage</h3>
                <div class="table-med t-3">
                    <div class="table-element"> Date de l'examen</div>
                    <div class="table-element">Classe fréquentée</div>
                    <div class="table-element">Age de l'élève</div>
                    <?php
                    $sql = "SELECT * FROM visites 
                    INNER JOIN etudiant on visites.id_etudiant = etudiant.id_etudiant and visites.id_etudiant = $id and type_visite='generaliste' 
                    INNER JOIN classe on etudiant.id_classe = classe.id_classe order by date_visite asc LIMIT $start,$finish";
                    $result = mysqli_query($conn, $sql);
                    $len = mysqli_num_rows($result);
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rows[] = $row;
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
                <div class="table-med t-4">
                    <div class="table-element"> Tension artérielle</div>
                    <div class="table-element">Acuité OD</div>
                    <div class="table-element">Acuité OG</div>
                    <div class="table-element">Pédiculose</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        echo '<div class="table-element"> ' . $rows[$j]['tention'] . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['visuelle_OD'] . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['visuelle_OG'] . '</div>';
                        echo '<div class="table-element"></div>';
                    }
                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    ?>
                </div>
                <h3 class="flex-center">Antécédents de l'élève</h3>
                <div class="table-med t-4">
                    <div class="table-element"> Hospitalisations</div>
                    <div class="table-element">Diabète</div>
                    <div class="table-element">Asthme</div>
                    <div class="table-element">Epilipsie</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {

                        $antecedents_par_visite = array_fill(0, 4, "/");
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from antecedents where antecedents.id_visite = '$id_visite'";
                        $ant = mysqli_query($conn, $sql);
                        while ($antecedent = mysqli_fetch_assoc($ant)) {
                            $num = $antecedent['num_antecedent'];
                            switch ($num) {
                                case 0:
                                    $antecedents_par_visite[0] = $antecedent['date_antecedent'];
                                    break;
                                case 1:
                                    $antecedents_par_visite[1] = $antecedent['date_antecedent'];
                                    break;
                                case 2:
                                    $antecedents_par_visite[2] = $antecedent['frequence'];
                                    break;
                                case 3:
                                    $antecedents_par_visite[3] = $antecedent['frequence'];
                                    break;
                            }
                        }
                        echo '<div class="table-element"> ' . $antecedents_par_visite[0] . '</div>';
                        echo '<div class="table-element">' . $antecedents_par_visite[1] . '</div>';
                        echo '<div class="table-element">' . $antecedents_par_visite[2] . '</div>';
                        echo '<div class="table-element">' . $antecedents_par_visite[3] . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    // $start = $finish;
                    // $finish = $finish + 5;
                    ?>
                </div>
                <h3 class="flex-center">Examen Médical</h3>
                <div class="table-med t-11">
                    <div class="table-element">app.Neurologique</div>
                    <div class="table-element">app.Endocrinien</div>
                    <div class="table-element">Rachis et membres</div>
                    <div class="table-element">Peau et phanères</div>
                    <div class="table-element">app.Ophtalmique</div>
                    <div class="table-element">app.ORL</div>
                    <div class="table-element">app.Respiratoire</div>
                    <div class="table-element">app.Cardio-vasculaire</div>
                    <div class="table-element">app.Digestif</div>
                    <div class="table-element">app.Urinaire</div>
                    <div class="table-element">app.Génital</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        $maladies_par_visite = array_fill(0, 11, "/");
                        $id_visite = $rows[$j]['id_visite'];
                        $sql = "SELECT * from maladie where maladie.id_visite = '$id_visite'";
                        $mal = mysqli_query($conn, $sql);
                        while ($maladie = mysqli_fetch_assoc($mal)) {
                            switch ($maladie['nom_maladie']) {
                                case 'neurologique':
                                    $maladies_par_visite[0] = "oui";
                                    break;
                                case 'endocrinien':
                                    $maladies_par_visite[1] = "oui";
                                    break;
                                case 'rachis':
                                    $maladies_par_visite[2] = "oui";
                                    break;
                                case 'peau':
                                    $maladies_par_visite[3] = "oui";
                                    break;
                                case 'ophtalmique':
                                    $maladies_par_visite[4] = "oui";
                                    break;
                                case 'orl':
                                    $maladies_par_visite[5] = "oui";
                                    break;
                                case 'respiratoire':
                                    $maladies_par_visite[6] = "oui";
                                    break;
                                case 'cardio':
                                    $maladies_par_visite[7] = "oui";
                                    break;
                                case 'digestif':
                                    $maladies_par_visite[8] = "oui";
                                    break;
                                case 'urinaire':
                                    $maladies_par_visite[9] = "oui";
                                    break;
                                case 'genital':
                                    $maladies_par_visite[10] = "oui";
                                    break;
                            }
                        }
                        echo '<div class="table-element"> ' . $maladies_par_visite[0] . '</div>';
                        echo '<div class="table-element">' . $maladies_par_visite[1] . '</div>';
                        echo '<div class="table-element">' . $maladies_par_visite[2] . '</div>';
                        echo '<div class="table-element">' . $maladies_par_visite[3] . '</div>';
                        echo '<div class="table-element"> ' . $maladies_par_visite[4] . '</div>';
                        echo '<div class="table-element">' . $maladies_par_visite[5] . '</div>';
                        echo '<div class="table-element">' . $maladies_par_visite[6] . '</div>';
                        echo '<div class="table-element">' . $maladies_par_visite[7] . '</div>';
                        echo '<div class="table-element"> ' . $maladies_par_visite[8] . '</div>';
                        echo '<div class="table-element">' . $maladies_par_visite[9] . '</div>';
                        echo '<div class="table-element">' . $maladies_par_visite[10] . '</div>';
                    }

                    while ($j < 5) {
                        for ($i = 1; $i <= 11; $i++)
                            echo '<div class="table-element"></div>';
                        $j++;
                    }
                    $start = $start + 5;
                    ?>
                </div>
            </div>
        </div>
<?php endfor;
        endif; ?> -->