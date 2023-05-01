<a class="dossier-etudiant flex-center" href="Folders/ajoutervisite?id=<?= $row['num_insc']; ?>" data-student-id=<?= $row['num_insc']; ?>>
    <img src="Images\student-image.png" height="80px" alt="">
    <div class="display-info flex-center ">
        <div class="student-info"><?= $row['nom'] ?></div>
        <div class="student-info"><?= $row['prenom'] ?></div>
        <div class="student-info"><?= $row['num_insc'] ?></div>
    </div>
</a>