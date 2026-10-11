<?php
$html = file_get_contents('http://localhost/prakashmarg/');
if (stripos($html, 'viewport') !== false) {
    echo 'Viewport found!';
} else {
    echo 'No viewport!';
}
