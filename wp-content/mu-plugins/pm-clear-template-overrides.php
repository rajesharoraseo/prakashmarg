<?php
/**
 * Clear WordPress FSE template DB overrides so theme file templates are used.
 * Runs once, then auto-disables itself via option flag.
 *
 * @package PrakashMarg
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
    if ( get_option( 'pm_templates_cleared_v5' ) ) return;

    global $wpdb;

    // Strategy 1: Delete by theme taxonomy term
    $theme_term = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT t.term_id FROM {$wpdb->terms} t
             INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
             WHERE tt.taxonomy = 'wp_theme' AND t.name = %s LIMIT 1",
            'prakash-marg'
        )
    );

    if ( $theme_term ) {
        $post_ids = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT tr.object_id FROM {$wpdb->term_relationships} tr
                 INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                 WHERE tt.term_id = %d",
                $theme_term
            )
        );

        foreach ( $post_ids as $pid ) {
            $type = $wpdb->get_var( $wpdb->prepare(
                "SELECT post_type FROM {$wpdb->posts} WHERE ID = %d", $pid
            ) );
            if ( in_array( $type, [ 'wp_template', 'wp_template_part' ], true ) ) {
                wp_delete_post( (int) $pid, true );
                error_log( "[PM] Deleted template/part DB override ID={$pid}" );
            }
        }
    }

    // Strategy 2: Delete by post_name slug containing theme prefix
    $slugs = [
        'prakash-marg//header',
        'prakash-marg//footer',
        'prakash-marg//front-page',
        'prakash-marg//index',
        'header',
        'footer',
        'front-page',
    ];
    foreach ( $slugs as $slug ) {
        $ids = $wpdb->get_col( $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts}
             WHERE post_name = %s
             AND post_type IN ('wp_template','wp_template_part')",
            $slug
        ) );
        foreach ( $ids as $pid ) {
            wp_delete_post( (int) $pid, true );
            error_log( "[PM] Deleted by slug '{$slug}' ID={$pid}" );
        }
    }

    // Strategy 3: Direct SQL DELETE for any remaining
    $wpdb->query(
        "DELETE FROM {$wpdb->posts}
         WHERE post_type IN ('wp_template','wp_template_part')
         AND (
             post_name LIKE '%header%'
             OR post_name LIKE '%footer%'
             OR post_name LIKE '%front-page%'
             OR post_name LIKE 'prakash%'
         )"
    );

    // Clean up orphaned postmeta
    $wpdb->query(
        "DELETE pm FROM {$wpdb->postmeta} pm
         LEFT JOIN {$wpdb->posts} p ON pm.post_id = p.ID
         WHERE p.ID IS NULL"
    );

    flush_rewrite_rules( false );
    update_option( 'pm_templates_cleared_v5', true );
    error_log( '[PM] FSE template DB overrides cleared v5 — filesystem now primary.' );
}, 1 );
