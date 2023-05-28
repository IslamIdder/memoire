<?php require_once("config.php") ?>
<header class="main-header flex flex-a-center flex-j-sb">
    <div class="header-content flex flex-a-center">
        <a href="/memoire/<?php echo $_SESSION['home'] ?>" class="flex g-5 flex-a-center">
            <?= svg(35, 35, "logo") ?>
            <span class="highlighted">EHealth</span>
        </a>
        <ul class="navigation flex">
            <li class="nav-element flex-center <?php if (isset($current)) {
                                                    if ($current == 'accueil') echo 'current';
                                                }
                                                ?>">
                <a href="/memoire/<?php echo $_SESSION['home'] ?>">
                    Home
                </a>
            </li>

            <li class="nav-element flex-center <?php if (isset($current)) {
                                                    if ($current == 'statistiques') echo 'current';
                                                }
                                                ?>">
                <a href="/memoire/statistiques.php">
                    Statistics
                </a>
            </li>
            <li class="flex-center">
                <div class="settings-button">
                    <i class="fa-solid fa-gear user-settings"></i>
                    <!-- <i class="fa-solid fa-user-gear user-settings"></i> -->
                    <!-- <div class="user-settings flex-center"><?= svg(20, 20, "bars", ""); ?></div> -->
                    <div class="dropdown-menu flex-column">
                        <a class="dropdown-item" href="/memoire/logout.php">Log out</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>