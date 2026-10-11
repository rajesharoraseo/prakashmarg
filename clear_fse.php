<?php
require 'C:/xampp/htdocs/prakashmarg/wp-load.php';
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'wp_global_styles'");
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'wp_template'");
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'wp_template_part'");
echo 'Cleared FSE templates from DB to force reload from files.';
