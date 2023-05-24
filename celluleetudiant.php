<a class="dossier-etudiant flex-center" href="Folders/dossier?id=<?= $row['id_etudiant']; ?>" data-student-id=<?= $row['id_etudiant']; ?>>
    <img src="Images\student-image.png" height="60px" alt="">
    <div class="display-info flex-center ">
        <div class="student-info"><?= $row['nom'] ?></div>
        <div class="student-info"><?= $row['prenom'] ?></div>
        <div class="student-info"><?= $row['id_etudiant'] ?></div>
    </div>
    <!-- <button class="student-settings">
        <i class="fa-solid fa-gear "></i>
    </button> -->
</a>