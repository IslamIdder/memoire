<?php
require_once('config.php');
$wilayas = array("Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "M'Sila", "Mascara", "Ouargla", "Oran", "El Bayadh", "Illizi", "Bordj Bou Arréridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela", "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane");
$firstNames = array(
    'Ahmed', 'Mohamed', 'Fatima', 'Amina', 'Rachid', 'Yasmina', 'Kamel', 'Djamila', 'Said', 'Samira'
);
$familyNames = array(
    'Belkacem', 'Bouzid', 'Benali', 'Zerrouki', 'Djebbar', 'Khelifi', 'Messaoudi', 'Cherif', 'Kaci', 'Ait Hamouda'
);
$startDate = '2002-01-01';
$endDate = '2015-01-01';

$startTimestamp = strtotime($startDate);
$endTimestamp = strtotime($endDate);

$query = "SELECT DISTINCT id_classe FROM classe";
$result = mysqli_query($conn, $query);
if (!$result)
    echo mysqli_error($conn);
$id_parent = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $id_classe = $row['id_classe'];
    for ($i = 1; $i <= 10; $i++) {
        $prenom = $firstNames[rand(0, 9)];
        $nom = $familyNames[rand(0, 9)];
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
        $date_naissance = date('Y-m-d', $randomTimestamp);
        $wilaya = $wilayas[rand(0, 47)];
        $stmt = $conn->prepare("INSERT INTO etudiant (nom,prenom,date_naissance,wilaya,id_classe,id_parent) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssssi", $nom, $prenom, $date_naissance, $wilaya, $id_classe, $id_parent);
        $stmt->execute();
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
            exit;
        } else {
            echo "Success!";
        }
    }
}
$conn->close();
