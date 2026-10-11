<?php
$url = 'http://127.0.0.1/prakashmarg/index.php/wp-json/pm/v1/search?q=shiva';
$response = file_get_contents($url);
if ($response === false) {
    echo "Failed to fetch URL\n";
    print_r(error_get_last());
} else {
    echo "Response:\n";
    echo $response;
}
