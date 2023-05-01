<header class="main-header flex flex-a-center flex-j-sb">
    <div class="header-content flex flex-a-center">
        <a href="/Mémoire/Doctor-front.php" class="logo">
            EHealth
        </a>
        <ul class="navigation flex-center">
            <li>
                <a href="/Mémoire/Doctor-front.php" class="nav-element <?php if (isset($current)) {
                                                                            if ($current != 'none') echo 'current';
                                                                        } else echo 'current'
                                                                        ?>">
                    Accueil
                </a>
            </li>
            <li>
                <div class="settings-button">
                    <i class="fa-solid fa-gear user-settings"></i>
                    <div class="dropdown-menu flex-column">
                        <a type="submit" class="dropdown-item">Se déconnecter
                        </a>
                        <a type="submit" class="dropdown-item">Se déconnecter
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>