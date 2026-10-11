<?php
require_once 'C:/xampp/htdocs/prakashmarg/wp-load.php';
global $wpdb;
$results = $wpdb->get_results("SELECT ID, post_title, post_name, post_status FROM {$wpdb->posts} WHERE post_type='page'");
foreach ($results as $row) {
    echo $row->ID . ' | ' . $row->post_name . ' | ' . $row->post_status . ' | ' . $row->post_title . "\n";
}
