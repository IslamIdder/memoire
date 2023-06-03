<div class="utility flex flex-a-center flex-j-sb">
    <form class="inline center">
        <div class="input-icons flex flex-a-center">
            <i class="fa-solid fa-magnifying-glass icon"></i>
            <input class="search-bar" placeholder="Search..." type="text">
        </div>
    </form>
    <?php if ($_SESSION['access_type'] == "directeur") :
        if (isset($classe)) : ?>
            <a class="btn" href="studentcreation.php">
                Add a student
            </a>
        <?php endif; ?>
    <?php endif; ?>
</div>