<?php
function svg($width, $height, $id, $class = "")
{
    return '<svg width="' . $width . 'px" height="' . $height . 'px" class="' . $class . '">
    <use style="width:100%;height:100%;" xlink:href="/memoire/Images/icons.svg#' . $id . '"></use>
</svg>';
}
require_once("config.php") ?>
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
            <?php if ($_SESSION['access_type'] == "docteur" || $_SESSION['access_type'] == "directeur") : ?>
                <li class="nav-element flex-center <?php if (isset($current)) {
                                                        if ($current == 'statistiques') echo 'current';
                                                    }
                                                    ?>">
                    <a href="/memoire/statistiques.php">
                        Statistics
                    </a>
                </li>
            <?php endif; ?>
            <li class="flex-center">
                <div class="user-settings dropdown-button ">
                    <i class="fa-solid fa-gear "></i>
                    <div class="dropdown-menu flex-column">
                        <a class="dropdown-item" href="/memoire/logout.php">Log out</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>