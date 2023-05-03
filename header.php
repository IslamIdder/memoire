<header class="main-header flex flex-a-center flex-j-sb">
    <div class="header-content flex flex-a-center">
        <a href="/memoire/Doctor-front.php" class="logo">
            EHealth
        </a>
        <ul class="navigation flex">
            <li class="nav-element flex-center <?php if (isset($current)) {
                                                    if ($current == 'accueil') echo 'current';
                                                }
                                                ?>">
                <a href="/memoire/Doctor-front.php">
                    Accueil
                </a>
            </li>
            <li class="nav-element flex-center <?php if (isset($current)) {
                                                    if ($current == 'statistiques') echo 'current';
                                                }
                                                ?>">
                <a href="/memoire/Doctor-front.php">
                    Statistiques
                </a>
            </li>
            <li class="flex-center">
                <div class="settings-button">
                    <i class="fa-solid fa-gear user-settings"></i>
                    <div class="dropdown-menu flex-column">
                        <a class="dropdown-item">Statistiques</a>
                        <a class="dropdown-item" href="logout.php">Se déconnecter</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>