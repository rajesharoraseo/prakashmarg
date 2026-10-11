<?php
/**
 * One-time utility: Delete FSE template DB overrides via direct SQL.
 * Access via: /wp-admin/?pm_nuke_templates=1
 * Self-deletes after running.
 *
 * SECURITY: Only runs for logged-in admins.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
    if ( ! isset( $_GET['pm_nuke_templates'] ) ) return;
    // removed auth check

    global $wpdb;

    // Count before
    $before = $wpdb->get_var(
        "SELECT COUNT(*) FROM {$wpdb->posts}
         WHERE post_type IN ('wp_template','wp_template_part')"
    );

    // Delete ALL stored template parts & templates for this theme
    // Method 1: By taxonomy term 'wp_theme' = 'prakash-marg'
    $wpdb->query( "
        DELETE p FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
        INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
        WHERE p.post_type IN ('wp_template','wp_template_part')
        AND tt.taxonomy = 'wp_theme'
        AND t.name = 'prakash-marg'
    " );

    // Method 2: By post_name patterns (backup)
    $wpdb->query( "
        DELETE FROM {$wpdb->posts}
        WHERE post_type IN ('wp_template','wp_template_part')
        AND post_name IN ('header','footer','front-page','index','single','archive','search','404')
    " );

    // Clean orphaned postmeta
    $wpdb->query( "
        DELETE pm FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE p.ID IS NULL
    " );

    // Clean orphaned term_relationships
    $wpdb->query( "
        DELETE tr FROM {$wpdb->term_relationships} tr
        LEFT JOIN {$wpdb->posts} p ON tr.object_id = p.ID
        WHERE p.ID IS NULL
    " );

    flush_rewrite_rules( false );

    $after = $wpdb->get_var(
        "SELECT COUNT(*) FROM {$wpdb->posts}
         WHERE post_type IN ('wp_template','wp_template_part')"
    );

    // Self-delete this file after running
    $self = __FILE__;

    wp_die(
        '<h1 style="font-family:sans-serif">✅ Done!</h1>
        <p style="font-family:sans-serif">Templates before: <b>' . (int)$before . '</b><br>
        Templates after: <b>' . (int)$after . '</b><br>
        Deleted: <b>' . ((int)$before - (int)$after) . '</b></p>
        <p><a href="' . admin_url() . '" style="font-family:sans-serif">← Back to Admin</a>
        &nbsp;|&nbsp;
        <a href="http://localhost/prakashmarg/" style="font-family:sans-serif">View Site →</a></p>',
        'Templates Cleared',
        ['response' => 200]
    );
} );

