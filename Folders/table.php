<?php
echo '<div class="flex-center ">' . $title . '</div>';
echo '<div class="table flex flex-column flex-a-center flex-j-center">';
for ($i = 1; $i <= count($elementHeaders); $i++) {
    echo '<div class="table-row">';
    echo "<div class=\"table-element c-5\">" . $elementHeaders[$i - 1] . "</div>";
    for ($j = 1; $j <= $numElements - 1; $j++) {
        echo '<input class="table-element c-5">';
    }
    echo '</div>';
}
echo '</div>';
