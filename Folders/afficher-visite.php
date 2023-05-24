<?php
if ($type_visite == 'infermier') {
    $icon = '<i class="fa-solid fa-syringe" style="font-size:50px;color:white;"></i>';
    $type = 'Vaccinatory';
    $path = "vaccin.php?id=" . $id . "&id_visite=" . $id_visite;
} elseif ($type_visite == 'generaliste') {
    $icon = '<i class="fa-solid fa-stethoscope" style="font-size:50px;color:white;"></i>';
    $type = 'Generalist';
    $path = "general.php?id_visite=" . $id_visite;
} elseif ($type_visite == 'psychologue') {
    $icon = '<svg fill="#fff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 56.00 56.00" xml:space="preserve" width="50px" height="50px" stroke="#fff" stroke-width="0.56">
    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.33599999999999997"></g>
    <g id="SVGRepo_iconCarrier">
        <g>
            <g> </g>
            <g>
                <path d="M12,24c3.309,0,6-2.691,6-6s-2.691-6-6-6s-6,2.691-6,6S8.691,24,12,24z M12,14c2.206,0,4,1.794,4,4s-1.794,4-4,4 s-4-1.794-4-4S9.794,14,12,14z"></path>
                <path d="M44,24c3.309,0,6-2.691,6-6s-2.691-6-6-6s-6,2.691-6,6S40.691,24,44,24z M44,14c2.206,0,4,1.794,4,4s-1.794,4-4,4 s-4-1.794-4-4S41.794,14,44,14z"></path>
                <path d="M54,26v13c0,1.654-1.346,3-3,3V31c0-2.757-2.243-5-5-5h-5c-0.552,0-1,0.448-1,1v4v1v1h-8c-0.552,0-1,0.448-1,1v3h-6v-3 c0-0.552-0.448-1-1-1h-8v-1v-1v-4c0-0.552-0.448-1-1-1h-5c-2.757,0-5,2.243-5,5v11c-1.654,0-3-1.346-3-3V26H0v13 c0,2.045,1.237,3.802,3,4.576V56h2V44h1h1h8v11c0,0.552,0.448,1,1,1h3h1h1v-1V40v-1h3h8h3v1v15v1h1h1h3c0.552,0,1-0.448,1-1V44h8 h1h1v12h2V43.576c1.763-0.774,3-2.531,3-4.576V26H54z M20,37h-2h-6v-6h-2v7c0,0.552,0.448,1,1,1h7c0.551,0,1,0.449,1,1v14h-2V43 c0-0.552-0.448-1-1-1H7V31c0-1.654,1.346-3,3-3h4v3v1v2c0,0.552,0.448,1,1,1h8v2H20z M40,42c-0.552,0-1,0.448-1,1v11h-2V40 c0-0.551,0.449-1,1-1h7c0.552,0,1-0.448,1-1v-7h-2v6h-6h-2h-3v-2h8c0.552,0,1-0.448,1-1v-2v-1v-3h4c1.654,0,3,1.346,3,3v11H40z"></path>
                <path d="M19,10v3c0,0.431,0.275,0.812,0.684,0.949C19.788,13.983,19.895,14,20,14c0.309,0,0.607-0.144,0.8-0.4l2.7-3.6H31 c1.654,0,3-1.346,3-3V3c0-1.654-1.346-3-3-3H19c-1.654,0-3,1.346-3,3v4C16,8.654,17.346,10,19,10z M18,3c0-0.551,0.449-1,1-1h12 c0.551,0,1,0.449,1,1v4c0,0.551-0.449,1-1,1h-8c-0.315,0-0.611,0.148-0.8,0.4L21,10V9c0-0.552-0.448-1-1-1h-1 c-0.551,0-1-0.449-1-1V3z"></path>
                <rect x="20" y="4" width="10" height="2"></rect>
                <rect x="27" y="25" width="6" height="2"></rect>
                <path d="M26,21c-1.654,0-3,1.346-3,3v4c0,1.654,1.346,3,3,3h8c1.654,0,3-1.346,3-3v-0.697l1.832-2.748 c0.205-0.307,0.224-0.701,0.05-1.026C38.708,23.203,38.369,23,38,23h-1.171c-0.413-1.164-1.525-2-2.829-2H26z M35,24 c0,0.552,0.448,1,1,1h0.131l-0.963,1.445C35.059,26.609,35,26.803,35,27v1c0,0.551-0.449,1-1,1h-8c-0.551,0-1-0.449-1-1v-4 c0-0.551,0.449-1,1-1h8C34.551,23,35,23.449,35,24z"></path>
                <rect x="23" y="16" width="2" height="2"></rect>
                <rect x="27" y="16" width="2" height="2"></rect>
                <rect x="31" y="16" width="2" height="2"></rect>
            </g>
        </g>
    </g>
</svg>';
    $type = 'Pyschological';
    $path = "psychologique.php?id_visite=" . $id_visite;
} else {
    $icon = '<i class="fa-solid fa-tooth" style="font-size:50px;color:white;"></i>';
    $type = "Dental";
    $path = "dentaire.php?id_visite=" . $id_visite . "&id=" . $id;
}
?>
<a class="history flex flex-j-center flex-column" href="<?= $path ?>">
    <div class="preview flex-center">
        <?= $icon; ?>
    </div>
    <div class="date-visite">Date: <?= $date_visite ?></div>
    <div class="med-visite">Dr.<?= $doctor_name ?></div>
    <div class="type-visite">Type: <?= $type ?></div>
</a>