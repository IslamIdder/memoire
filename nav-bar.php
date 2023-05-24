<header class="main-header flex flex-a-center flex-j-sb">
    <div class="header-content flex flex-a-center">
        <a href="/memoire/<?php echo $_SESSION['home'] ?>" class="flex g-5 flex-a-center">
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 236.25 182.98" height="25px">
                <defs>
                    <style>
                        .logo-1 {
                            fill: #fff;
                        }

                        .logo-2 {
                            fill: #5ca5e5;
                        }
                    </style>
                </defs>
                <path class="logo-1" d="M176.38,90.43v9.28l-13.18,0c-5.85,0-11.69,0-17.52-.17a2,2,0,0,1-1.21-.7,8.44,8.44,0,0,1-1.65-2.58C141,91.54,139.2,86.76,137,81.93c-.77-1.7-1.58-3.41-2.48-5.13-4.06,12.43-8.13,24.87-12.33,37.7l-7.13,21.81c-1.46-3.26-2.89-6.45-4.3-9.62l-3.11-6.94-9.37-21c-1-2.33-2.1-4.69-3.17-7.08-.85,5.27-3.55,5.79-6.67,5.79l-1.22,0c-3.13-.06-6.28-.08-9.42-.08-6,0-12,0-18.09,0V88.1c7.46,0,14.89-.21,22.3.09,2,.08,3.43-.33,4.41-1.33a5.89,5.89,0,0,0,1.3-2.16c.1-.26.2-.51.28-.79,1.64-5.45,3.62-10.79,5.89-17.42,1.21,2.69,2.4,5.33,3.58,8l13.33,29.71,2.77,6.19c6.92-21.24,13.61-41.78,20.65-63.41,5.18,13.82,10.08,26.51,14.63,39.32.66,1.87,1.4,3,2.6,3.68a6.3,6.3,0,0,0,3.29.57C161.86,90.21,169,90.43,176.38,90.43Z" />
                <path class="logo-2" d="M232.73,41c-9.28-24.1-27-38.17-52.48-40.44-25.89-2.31-46,8.73-59.29,31.35-.83,1.4-1.65,2.8-2.78,4.74-2.1-3.42-3.81-6.54-5.84-9.44C99.61,8.92,82,.16,59.82.12,58.66.12,57.5,0,56.34,0c-13,1.86-24.91,6.31-35.09,14.94C10.47,24.06,4.4,35.9.78,49.24c-.05.82-.05,1.65-.15,2.47-3,23.94,4.45,43.73,23.68,58.69q36.9,28.71,73.89,57.29C104.83,172.83,111.49,178,118,183l11.71-8.57,7-5.37,11.29-8.7,5.51-4.29,13.38-10.43,23.81-18.4c3.86-3.11,7.56-6.46,11.63-9.28,14.76-10.25,27-22.46,32.23-40.26C236.82,65.29,237.36,53,232.73,41ZM176.38,99.71l-13.18,0c-5.85,0-11.69,0-17.52-.17a2,2,0,0,1-1.21-.7,8.44,8.44,0,0,1-1.65-2.58C141,91.54,139.2,86.76,137,81.93c-.77-1.7-1.58-3.41-2.48-5.13-4.06,12.43-8.13,24.87-12.33,37.7l-7.13,21.81c-1.46-3.26-2.89-6.45-4.3-9.62l-3.11-6.94-9.37-21c-1-2.33-2.1-4.69-3.17-7.08-.85,5.27-3.55,5.79-6.67,5.79l-1.22,0c-3.13-.06-6.28-.08-9.42-.08-6,0-12,0-18.09,0V88.1c7.46,0,14.89-.21,22.3.09,2,.08,3.43-.33,4.41-1.33a5.89,5.89,0,0,0,1.3-2.16c.1-.26.2-.51.28-.79,1.64-5.45,3.62-10.79,5.89-17.42,1.21,2.69,2.4,5.33,3.58,8l13.33,29.71,2.77,6.19c6.92-21.24,13.61-41.78,20.65-63.41,5.18,13.82,10.08,26.51,14.63,39.32.66,1.87,1.4,3,2.6,3.68a6.3,6.3,0,0,0,3.29.57c7.09-.31,14.2-.09,21.61-.09Z" />
            </svg>
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
                    <div class="dropdown-menu flex-column">
                        <a class="dropdown-item" href="/memoire/logout.php">Log out</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>