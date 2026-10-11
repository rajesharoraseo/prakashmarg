<?php
/**
 * Reset FSE Template Parts to filesystem versions
 * Run once, then delete this file.
 */
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-load.php' );

if ( ! current_user_can('manage_options') ) {
    die('Unauthorized');
}

// Delete stored header/footer template parts from DB so WP reads from filesystem
$deleted = [];

$template_parts = get_posts([
    'post_type'      => 'wp_template_part',
    'post_status'    => 'any',
    'posts_per_page' => -1,
    'post_name__in'  => ['header', 'footer'],
]);

foreach ( $template_parts as $part ) {
    $deleted[] = $part->post_name . ' (ID: ' . $part->ID . ')';
    wp_delete_post( $part->ID, true );
}

// Also clear any template modifications
$templates = get_posts([
    'post_type'      => 'wp_template',
    'post_status'    => 'any',
    'posts_per_page' => -1,
    'post_name__in'  => ['front-page', 'index', 'page', 'single'],
]);

foreach ( $templates as $tpl ) {
    $deleted[] = 'template: ' . $tpl->post_name . ' (ID: ' . $tpl->ID . ')';
    wp_delete_post( $tpl->ID, true );
}

echo '<h2>✅ Done! Deleted ' . count($deleted) . ' stored template(s):</h2>';
echo '<ul><li>' . implode('</li><li>', $deleted) . '</li></ul>';
echo '<p>WordPress will now use the <strong>filesystem templates</strong> (your edited files).</p>';
echo '<p><a href="/prakashmarg/">→ Go to Homepage</a></p>';
?>
