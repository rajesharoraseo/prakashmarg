<?php
/**
 * One-time setup script for PrakashMarg WordPress installation.
 * Sets front-page template, creates Panchang & Quote pages if missing.
 * DELETE THIS FILE after running!
 */
define('ABSPATH_CHECK', true);

// Load WordPress
require_once __DIR__ . '/wp-load.php';

if (!current_user_can('administrator') && !defined('WP_CLI')) {
    wp_die('Unauthorized');
}

$actions = [];

// 1. Check if front-page template is set on any page
$pages = get_pages();
$front_page_id = get_option('page_on_front');
$show_on_front  = get_option('show_on_front');

$actions[] = "show_on_front = $show_on_front, page_on_front = $front_page_id";

// 2. Create/find a "Home" page for front-page template
$home_page = null;
foreach ($pages as $p) {
    if (get_post_meta($p->ID, '_wp_page_template', true) === 'front-page') {
        $home_page = $p;
        break;
    }
}
if (!$home_page) {
    // Try by slug
    $home_page = get_page_by_path('home');
}
if (!$home_page) {
    // Create it
    $home_id = wp_insert_post([
        'post_title'     => 'Home',
        'post_name'      => 'home',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'post_content'   => '',
        'comment_status' => 'closed',
    ]);
    if (!is_wp_error($home_id)) {
        update_post_meta($home_id, '_wp_page_template', 'front-page');
        $actions[] = "Created Home page (ID: $home_id) with front-page template.";
        $home_page = get_post($home_id);
    } else {
        $actions[] = "ERROR creating Home page: " . $home_page->get_error_message();
    }
} else {
    update_post_meta($home_page->ID, '_wp_page_template', 'front-page');
    $actions[] = "Found existing Home page (ID: {$home_page->ID}), assigned front-page template.";
}

// 3. Set WordPress reading settings
if ($home_page && !is_wp_error($home_page)) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_page->ID);
    $actions[] = "Set show_on_front = 'page', page_on_front = {$home_page->ID}";
}

// 4. Create Panchang page if not exists
$panchang_page = get_page_by_path('panchang');
if (!$panchang_page) {
    $panchang_id = wp_insert_post([
        'post_title'   => 'पंचांग',
        'post_name'    => 'panchang',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ]);
    if (!is_wp_error($panchang_id)) {
        update_post_meta($panchang_id, '_wp_page_template', 'page-panchang');
        $actions[] = "Created Panchang page (ID: $panchang_id).";
    }
} else {
    update_post_meta($panchang_page->ID, '_wp_page_template', 'page-panchang');
    $actions[] = "Found existing Panchang page (ID: {$panchang_page->ID}), assigned page-panchang template.";
}

// 5. Create Quote page if not exists
$quote_page = get_page_by_path('quote');
if (!$quote_page) {
    $quote_id = wp_insert_post([
        'post_title'   => 'सुविचार',
        'post_name'    => 'quote',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ]);
    if (!is_wp_error($quote_id)) {
        update_post_meta($quote_id, '_wp_page_template', 'page-quote');
        $actions[] = "Created Quote page (ID: $quote_id).";
    }
} else {
    update_post_meta($quote_page->ID, '_wp_page_template', 'page-quote');
    $actions[] = "Found existing Quote page (ID: {$quote_page->ID}), assigned page-quote template.";
}

// 6. Clear all caches
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    $actions[] = "Cleared WP object cache.";
}

// Done
echo "<pre style='font-family:monospace;padding:20px;background:#1a3a2e;color:#d4aa50;border-radius:12px;font-size:14px;line-height:1.7'>";
echo "<strong>✅ PrakashMarg Setup Complete</strong>\n\n";
foreach ($actions as $action) {
    echo "→ " . htmlspecialchars($action) . "\n";
}
echo "\n<strong style='color:#7ecfab'>Please DELETE this file after setup!</strong>";
echo "</pre>";
