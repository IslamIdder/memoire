<?php
require_once('config.php');
$search_query = $_GET['q'];
$parse = $_GET['parse'];
if ($parse == "no")
    $sql = "SELECT nom,prenom,id_etudiant FROM etudiant";
else
    $sql = "SELECT nom,prenom,id_etudiant FROM etudiant WHERE nom LIKE '$search_query%' OR prenom LIKE '$search_query%' OR id_etudiant LIKE '$search_query%'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        include 'celluleetudiant.php';
    }
} else {
    echo "Aucun etudiant trouvé";
}
mysqli_close($conn);
