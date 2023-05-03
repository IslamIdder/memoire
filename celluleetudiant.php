<a class="dossier-etudiant flex-center" href="Folders/ajoutervisite?id=<?= $row['id_etudiant']; ?>" data-student-id=<?= $row['id_etudiant']; ?>>
    <img src="Images\student-image.png" height="80px" alt="">
    <div class="display-info flex-center ">
        <div class="student-info"><?= $row['nom'] ?></div>
        <div class="student-info"><?= $row['prenom'] ?></div>
        <div class="student-info"><?= $row['id_etudiant'] ?></div>
    </div>
</a>