<?php
define('WP_USE_THEMES', false);
require('C:/xampp/htdocs/prakashmarg/wp-load.php');

$pages_to_create = [
    'katha' => 'कथा-प्रसंग',
    'tools' => 'टूल्स'
];

foreach ($pages_to_create as $slug => $title) {
    $page = get_page_by_path($slug);
    if (!$page) {
        wp_insert_post([
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_type'    => 'page',
            'post_status'  => 'publish'
        ]);
        echo "Created page: $title ($slug)\n";
    } else {
        echo "Page exists: $title ($slug)\n";
    }
}
