<?php
session_start();
require_once('config.php');
$search_query = $_GET['q'];
$parse = $_GET['parse'];
$id_query = $_GET['id'];
$type = $_GET['type'];
switch ($type) {
    case "classe": {
            if ($parse == "no") {
                $stmt = $conn->prepare("SELECT nom,prenom,id_etudiant FROM etudiant INNER JOIN classe on etudiant.id_classe = classe.id_classe and classe.id_classe = ?");
                $stmt->bind_param("s", $id_query);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT nom,prenom,id_etudiant FROM etudiant INNER JOIN classe on etudiant.id_classe = classe.id_classe and classe.id_classe = ?  where nom LIKE CONCAT('%', ?, '%') OR prenom LIKE CONCAT('%', ?, '%') OR id_etudiant LIKE CONCAT('%', ?, '%')");
                $stmt->bind_param("ssss", $id_query, $search_query, $search_query, $search_query);
                $stmt->execute();
            }
            $path = "celluleetudiant.php";
            break;
        }
    case "ecole": {
            if ($parse == "no") {
                $stmt = $conn->prepare("SELECT * FROM classe  INNER JOIN ecole ON classe.id_ecole = ecole.id_ecole and ecole.id_ecole = ?");
                $stmt->bind_param("s", $id_query);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT * FROM classe 
                INNER JOIN ecole
                ON classe.id_ecole = ecole.id_ecole
                and ecole.id_ecole = ?  where nom_classe LIKE CONCAT('%', ?, '%') OR id_classe LIKE CONCAT('%', ?, '%') OR annee LIKE CONCAT('%', ?, '%')");
                $stmt->bind_param("ssss", $id_query, $search_query, $search_query, $search_query);
                $stmt->execute();
            }
            $path = "celluleclasse.php";
            break;
        }
    case "director-front": {
            if ($parse == "no") {
                $stmt = $conn->prepare("SELECT * FROM classe INNER JOIN directeurs on classe.id_ecole = directeurs.id_ecole where directeurs.id_directeur = ?");
                $stmt->bind_param("s", $id_query);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT * FROM classe  INNER JOIN directeurs ON classe.id_ecole = directeurs.id_ecole  AND directeurs.id_directeur = ? WHERE nom_classe LIKE CONCAT('%', ?, '%')  OR id_classe LIKE CONCAT('%', ?, '%')  OR annee LIKE CONCAT('%', ?, '%')");
                $stmt->bind_param("ssss", $id_query, $search_query, $search_query, $search_query);
                $stmt->execute();
            }
            $path = "celluleclasse.php";
            break;
        }
    case "doctor-front": {
            if ($parse == "no") {
                $stmt = $conn->prepare("SELECT * FROM ecole INNER JOIN docteurs on ecole.id_dds = docteurs.id_dds where docteurs.id_docteur = ?");
                $stmt->bind_param("s", $id_query);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT * FROM ecole INNER JOIN docteurs on ecole.id_dds = docteurs.id_dds and docteurs.id_docteur = ?  where nom_ecole LIKE CONCAT('%', ?, '%') OR id_ecole LIKE CONCAT('%', ?, '%') OR ecole.id_dds LIKE CONCAT('%', ?, '%')");
                $stmt->bind_param("ssss", $id_query, $search_query, $search_query, $search_query);
                $stmt->execute();
            }
            $path = "celluleecole.php";
            break;
        }
    case "parent": {
            if ($parse == "no") {
                $stmt = $conn->prepare("SELECT * FROM etudiant INNER JOIN parent on etudiant.id_parent= parent.id_parent where parent.id_parent = ?");
                $stmt->bind_param("s", $id_query);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT * FROM etudiant INNER JOIN parent on etudiant.id_parent= parent.id_parent and parent.id_parent = ?  where nom LIKE CONCAT('%', ?, '%') OR prenom LIKE CONCAT('%', ?, '%') OR id_etudiant LIKE CONCAT('%', ?, '%')");
                $stmt->bind_param("ssss", $id_query, $search_query, $search_query, $search_query);
                $stmt->execute();
            }
            $path = "celluleetudiant.php";
            break;
        }
}
$result = $stmt->get_result();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        include $path;
    }
} else {
    echo "Aucun resultat trouvé";
}
mysqli_close($conn);
