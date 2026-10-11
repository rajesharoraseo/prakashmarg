<?php
require 'C:/xampp/htdocs/prakashmarg/wp-load.php';
global $wp_rewrite;
$wp_rewrite->set_permalink_structure('/index.php/%postname%/');
$wp_rewrite->flush_rules();
echo 'Permalink structure updated to include index.php.';
