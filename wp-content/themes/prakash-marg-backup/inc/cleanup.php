<?php
/**
 * Cleanup and Hooks
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Force FSE theme to always read template parts from filesystem, never from DB.
 * This prevents any WP Site Editor customizations from overriding theme files.
 */
add_filter( 'pre_get_block_file_template', function( $template, $id, $template_type ) {
    // Only process our theme's templates
    if ( strpos( $id, 'prakash-marg//' ) !== 0 ) {
        return $template;
    }

    $slug = str_replace( 'prakash-marg//', '', $id );

    // Determine correct file path
    if ( $template_type === 'wp_template_part' ) {
        $file = get_template_directory() . '/parts/' . $slug . '.html';
    } else {
        $file = get_template_directory() . '/templates/' . $slug . '.html';
    }

    if ( ! file_exists( $file ) ) {
        return $template;
    }

    // Build template object from filesystem
    $contents = file_get_contents( $file );
    $template  = new WP_Block_Template();
    $template->id          = $id;
    $template->theme       = 'prakash-marg';
    $template->slug        = $slug;
    $template->source      = 'theme';
    $template->type        = $template_type;
    $template->content     = $contents;
    $template->title       = ucwords( str_replace( '-', ' ', $slug ) );
    $template->status      = 'publish';
    $template->has_theme_file = true;
    $template->is_custom   = false;

    return $template;
}, 10, 3 );

/**
 * Delete any DB-stored template parts on first run to ensure filesystem takes over.
 */
add_action( 'init', function() {
    if ( get_option( 'pm_fse_force_filesystem_v1' ) ) return;

    global $wpdb;
    $wpdb->query(
        "DELETE FROM {$wpdb->posts}
         WHERE post_type IN ('wp_template','wp_template_part')
         AND post_name LIKE 'prakash-marg//%'"
    );

    // Also try direct slug match
    $wpdb->query(
        "DELETE p FROM {$wpdb->posts} p
         INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
         WHERE p.post_type IN ('wp_template','wp_template_part')
         AND pm.meta_key = 'origin'
         AND pm.meta_value = 'theme'
         AND p.post_name IN ('header','footer','front-page','index')"
    );

    // Delete theme tagged posts
    $rows = $wpdb->get_results(
        "SELECT p.ID FROM {$wpdb->posts} p
         INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
         INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
         INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
         WHERE p.post_type IN ('wp_template','wp_template_part')
         AND tt.taxonomy = 'wp_theme'
         AND t.name = 'prakash-marg'"
    );
    foreach ( $rows as $row ) {
        wp_delete_post( $row->ID, true );
    }

    update_option( 'pm_fse_force_filesystem_v1', true );
    error_log( '[PM] FSE templates cleared — filesystem now active.' );
}, 5 );
