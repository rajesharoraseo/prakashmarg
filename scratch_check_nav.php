<?php
$html = file_get_contents('http://localhost/prakashmarg/');
if (preg_match('/<nav[^>]*>/i', $html, $matches)) {
    print_r($matches);
}
if (preg_match('/<header[^>]*>.*?<\/header>/is', $html, $matches)) {
    echo "\n\nHeader HTML:\n";
    echo substr($matches[0], 0, 1000);
}
