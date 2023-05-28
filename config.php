<?php
$servername = "localhost";
$username = "root";
$password = "chelsea64";
$dbname = "ehealth";

$conn = new mysqli($servername, $username, $password, $dbname);
/**
 * Formats the date to dd-mm-yyyy.
 *
 * @param {date} - The date to be formatted.
 * @return {Date} The formatted date.
 */
function format($date)
{
    return date("d-m-Y", strtotime($date));
}


function svg($width, $height, $id, $class = "")
{
    return '<svg width="' . $width . 'px" height="' . $height . 'px" class="' . $class . '">
    <use style="width:100%;height:100%;" xlink:href="/memoire/Images/icons.svg#' . $id . '"></use>
</svg>';
}
