<?php
$html = file_get_contents('http://localhost/prakashmarg/');
if (preg_match('/<head>(.*?)<\/head>/s', $html, $matches)) {
    echo $matches[1];
} else {
    echo "No head found";
}
