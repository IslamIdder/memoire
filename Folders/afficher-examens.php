<?php
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
                    $sql = "SELECT * FROM visites INNER JOIN etudiant on visites.id_etudiant = etudiant.id_etudiant and visites.id_etudiant = $id and type_visite='generaliste' LIMIT $start,$finish";
                    $result = mysqli_query($conn, $sql);
                    $len = mysqli_num_rows($result);
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rows[] = $row;
                    }
                    for ($j = 0; $j < $len; $j++) {
                        echo '<div class="table-element"> ' . format($rows[$j]['date_visite']) . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['tention'] . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['tention'] . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    // $id_visite = $row1['id_visite'];
                    // $stmt = $conn->prepare("SELECT * FROM maladie where maladie.id_visite = ?");
                    // $stmt->bind_param("i", $id_visite);
                    // $stmt->execute();
                    // $result2 = $stmt->get_result();
                    // $tooth_array = array();
                    // while ($row = $result2->fetch_assoc()) {
                    // if ($row['type_dent']) {
                    // $dent = new stdClass();
                    // $dent->type = $row['type_dent'];
                    // $dent->number = $row['numero_dent'];
                    // $tooth_array[] = $dent;
                    // }
                    // }
                    ?>
                </div>
                <div class="table-med t-4">
                    <div class="table-element"> Tension artérielle</div>
                    <div class="table-element">Acuité OD</div>
                    <div class="table-element">Acuité OG</div>
                    <div class="table-element">Pédiculose</div>
                    <?php
                    for ($j = 0; $j < $len; $j++) {
                        echo '<div class="table-element"> ' . format($rows[$j]['date_visite']) . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['tention'] . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['tention'] . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['tention'] . '</div>';
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
                        echo '<div class="table-element"> ' . format($rows[$j]['date_visite']) . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['tention'] . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['tention'] . '</div>';
                        echo '<div class="table-element">' . $rows[$j]['tention'] . '</div>';
                    }

                    while ($j < 5) {
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        echo '<div class="table-element"></div>';
                        $j++;
                    }
                    $start = $finish;
                    $finish = $finish + 5;
                    ?>
                </div>
            </div>
        </div>
<?php endfor;
endif; ?>