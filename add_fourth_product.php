<?php
require_once('wp-load.php');

if (!class_exists('WooCommerce')) {
    die('WooCommerce is not active.');
}

$products = [
    [
        'name' => 'श्रीमद्भगवद् गीता',
        'price' => '399',
        'desc' => 'श्रीमद्भगवद् गीता - हिंदी अनुवाद सहित।',
    ]
];

foreach ($products as $p) {
    // Check if product exists by title
    $existing = get_page_by_title($p['name'], OBJECT, 'product');
    if (!$existing) {
        $post_id = wp_insert_post(array(
            'post_title' => $p['name'],
            'post_content' => $p['desc'],
            'post_status' => 'publish',
            'post_type' => 'product',
        ));
        
        wp_set_object_terms($post_id, 'simple', 'product_type');
        update_post_meta($post_id, '_visibility', 'visible');
        update_post_meta($post_id, '_stock_status', 'instock');
        update_post_meta($post_id, '_price', $p['price']);
        update_post_meta($post_id, '_regular_price', $p['price']);
        echo "Created: " . $p['name'] . "\n";
    } else {
        echo "Already exists: " . $p['name'] . "\n";
    }
}
echo "Done.\n";
?>
