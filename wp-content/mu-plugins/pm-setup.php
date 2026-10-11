<?php
/**
 * PrakashMarg One-Time Setup
 * Creates required Pages and sets Reading Settings.
 * Auto-runs once via mu-plugins, then disables itself.
 */

if (!defined('ABSPATH')) return;

// Only run once - check flag
if (get_option('pm_setup_done_v1')) return;

// Only run for logged-in admins or when explicitly triggered
if (!is_admin() && !isset($_GET['pm_setup'])) return;
if (isset($_GET['pm_setup']) && $_GET['pm_setup'] !== 'run2026') return;

add_action('init', function () {
    if (get_option('pm_setup_done_v1')) return;

    // 1. Create/find Home page
    $home_page = get_page_by_path('home');
    if (!$home_page) {
        $home_id = wp_insert_post([
            'post_title'     => 'Home',
            'post_name'      => 'home',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => '',
            'comment_status' => 'closed',
        ]);
        $home_id = is_wp_error($home_id) ? 0 : $home_id;
    } else {
        $home_id = $home_page->ID;
    }
    if ($home_id) {
        update_post_meta($home_id, '_wp_page_template', 'front-page');
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_id);
    }

    // 2. Create Panchang page
    $panchang = get_page_by_path('panchang');
    if (!$panchang) {
        $p_id = wp_insert_post([
            'post_title'   => 'पंचांग',
            'post_name'    => 'panchang',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ]);
        if (!is_wp_error($p_id)) {
            update_post_meta($p_id, '_wp_page_template', 'page-panchang');
        }
    } else {
        update_post_meta($panchang->ID, '_wp_page_template', 'page-panchang');
    }

    // 3. Create Quote page
    $quote = get_page_by_path('quote');
    if (!$quote) {
        $q_id = wp_insert_post([
            'post_title'   => 'सुविचार',
            'post_name'    => 'quote',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ]);
        if (!is_wp_error($q_id)) {
            update_post_meta($q_id, '_wp_page_template', 'page-quote');
        }
    } else {
        update_post_meta($quote->ID, '_wp_page_template', 'page-quote');
    }

    // 4. Mark as done
    update_option('pm_setup_done_v1', true);
    wp_cache_flush();

    // Show success if triggered via URL
    if (isset($_GET['pm_setup'])) {
        wp_die('<div style="font-family:monospace;background:#1a3a2e;color:#d4aa50;padding:30px;border-radius:12px;margin:40px auto;max-width:600px"><h2>✅ PrakashMarg Setup Done!</h2><p>→ Home page created & front-page template assigned.</p><p>→ Panchang page created with page-panchang template.</p><p>→ Quote page created with page-quote template.</p><p>→ WordPress reading settings updated.</p><br><a href="' . home_url() . '" style="color:#7ecfab">← Visit Homepage</a></div>', 'Setup Complete', ['response' => 200]);
    }
}, 5);
