<?php
$html = file_get_contents('http://localhost/prakashmarg/');
if (strpos($html, '--wp--preset--color--primary-saffron') !== false) {
    echo "Variable found!";
} else {
    echo "Variable MISSING!";
}
