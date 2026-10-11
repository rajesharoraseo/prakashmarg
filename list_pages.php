<?php
define('WP_USE_THEMES', false);
require('C:/xampp/htdocs/prakashmarg/wp-load.php');
$pages = get_pages();
foreach ($pages as $p) {
    echo $p->post_name . ' - ' . $p->post_title . "\n";
}
