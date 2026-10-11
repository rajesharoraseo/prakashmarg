<?php
$html = file_get_contents('http://localhost/prakashmarg/');
preg_match('/<meta[^>]*viewport[^>]*>/i', $html, $matches);
print_r($matches);
