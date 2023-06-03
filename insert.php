<?php
require_once('config.php');
$firstNames = array(
    'Ahmed', 'Mohamed', 'Fatima', 'Amina', 'Rachid', 'Yasmina', 'Kamel', 'Djamila', 'Said', 'Samira'
);
$familyNames = array(
    'Belkacem', 'Bouzid', 'Benali', 'Zerrouki', 'Djebbar', 'Khelifi', 'Messaoudi', 'Cherif', 'Kaci', 'Ait Hamouda'
);
for ($i = 1; $i <= 200; $i++) {
    $id_parent = "p" . $i;
    $prenom = $firstNames[rand(0, 9)];
    $nom = $familyNames[rand(0, 9)];
    $stmt = $conn->prepare("INSERT INTO parent (id_parent,nom_parent,prenom_parent) VALUES (?,?,?)");
    $stmt->bind_param("sss", $id_parent, $nom, $prenom);
    $stmt->execute();
    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Success!";
    }
}

$conn->close();
