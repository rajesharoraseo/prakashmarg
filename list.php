<?php
require('C:/xampp/htdocs/prakashmarg/wp-load.php');
$q = new WP_Query(['post_type'=>['post','page','pm_scripture'], 'posts_per_page'=>-1]);
foreach($q->posts as $p) {
    echo $p->post_type . ' | ' . $p->post_name . ' | ' . get_the_title($p->ID) . PHP_EOL;
}
