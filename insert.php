<?php
require_once('config.php');
$start_date = '2023-01-01';
$end_date = '2023-5-16';
$maladies = ["neurologique", "endocrinien", "rachis", "peau", "ophalmique", "orl", "respiratoire", "cardio", "digestif", "urinaire", "genital"];
$query = "SELECT DISTINCT id_etudiant FROM etudiant";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo mysqli_error($conn);
    exit;
}
while ($row = mysqli_fetch_assoc($result)) {
    $id_etudiant = $row['id_etudiant'];
    for ($i = 1; $i <= 2; $i++) {
        $OG = rand(1, 10);
        $id_docteur = "mg0";
        $OD = rand(1, 10);
        $age = rand(6, 18);
        $height = rand(150, 200);
        $weight = rand(40, 150);
        $tension = rand(1, 10);
        $type_visite = "generaliste";
        $timestamp = mt_rand(strtotime($start_date), strtotime($end_date));
        $date_naissance = date('Y-m-d', $timestamp);
        $stmt = $conn->prepare("INSERT INTO visites (visuelle_OD, visuelle_OG, tention, age, type_visite, height, weight, date_visite, id_etudiant, id_docteur) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iiiisiisis", $OD, $OG, $tension, $age, $type_visite, $height, $weight, $date_naissance, $id_etudiant, $id_docteur);
        $stmt->execute();
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
            exit;
        }
        $id_visite = $stmt->insert_id;

        $maladies_copy = $maladies; // Create a copy of the maladies array

        for ($j = 1; $j <= 2; $j++) {
            $randomIndex = array_rand($maladies_copy);
            $nom_maladie = $maladies_copy[$randomIndex];
            unset($maladies_copy[$randomIndex]); // Remove the selected maladie from the copy array
            $maladies_copy = array_values($maladies_copy); // Re-index the copy array

            $id_maladie = $id_visite . "_" . $nom_maladie;
            $stmt2 = $conn->prepare("INSERT INTO maladie (nom_maladie, id_visite, id_maladie) VALUES (?,?,?)");
            $stmt2->bind_param("sis", $nom_maladie, $id_visite, $id_maladie);
            $stmt2->execute();
            if ($stmt2->error) {
                echo "Error: " . $stmt2->error;
                exit;
            }
        }
    }
}
?>

$conn->close();