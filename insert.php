
<?php
require_once('config.php');
$wilayas = array("Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira", "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda", "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "M'Sila", "Mascara", "Ouargla", "Oran", "El Bayadh", "Illizi", "Bordj Bou Arréridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela", "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane");
$names = array("Amina", "Hakim", "Nour", "Younes", "Zahra", "Ali", "Fatima", "Karim", "Sara", "Mehdi");
$familyNames = array("Boualem", "Saidi", "Ait Ahmed", "Ait Hamouda", "Benamar", "Bouazza", "Boukadoum", "Boukhalfa", "Cherif", "Ziane");
$start_date = '2002-01-01';
$end_date = '2015-01-01';

$query = "SELECT DISTINCT id_classe FROM classe";
$result = mysqli_query($conn, $query);
if (!$result)
    echo mysqli_error($conn);
while ($row = mysqli_fetch_assoc($result)) {
    $id_classe = $row['id_classe'];
    $nbr_students_per_classe = rand(2, 5);
    for ($i = 1; $i <= $nbr_students_per_classe; $i++) {
        $wilaya = $wilayas[rand(0, 47)];
        $nom_etudiant = $names[rand(0, 9)];
        $prenom_etudiant = $familyNames[rand(0, 9)];
        $timestamp = mt_rand(strtotime($start_date), strtotime($end_date));
        $date_naissance = date('Y-m-d', $timestamp);
        $stmt = $conn->prepare("INSERT INTO etudiant (nom,prenom,wilaya,date_naissance,id_classe) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $nom_etudiant, $prenom_etudiant, $wilaya, $date_naissance, $id_classe);
        $stmt->execute();
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
            exit;
        }
    }
}
$conn->close();
