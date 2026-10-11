<?php
/**
 * Template DB override manager — fires early enough to bypass WP redirects.
 * Debug: http://127.0.0.1/prakashmarg/?pm_debug_templates=1
 * Clear:  http://127.0.0.1/prakashmarg/?pm_clear_templates=1
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// Use init (early) instead of wp hook to avoid canonical redirects
add_action( 'init', function () {
    // ── DEBUG ──────────────────────────────────────────────────────────
    if ( isset( $_GET['pm_debug_templates'] ) ) {
        global $wpdb;
        $rows = $wpdb->get_results(
            "SELECT ID, post_name, post_type, post_status FROM {$wpdb->posts}
             WHERE post_type IN ('wp_template','wp_template_part')
             ORDER BY post_type, post_name"
        );
        $count = count( $rows );

        http_response_code( 200 );
        header( 'Content-Type: text/html; charset=utf-8' );
        header( 'Cache-Control: no-store' );

        echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>PM Debug</title></head><body>';
        echo '<pre style="background:#0a0a1a;color:#39ff14;padding:24px;font-family:monospace;font-size:15px;min-height:100vh;margin:0;">';
        echo "=== Prakash Marg Template DB Debug ===\n\n";
        echo "Found: {$count} DB template override(s)\n\n";

        if ( $rows ) {
            foreach ( $rows as $r ) {
                echo "  [{$r->post_type}] {$r->post_name}  (ID: {$r->ID}, status: {$r->post_status})\n";
            }
            echo "\n→ Go to /?pm_clear_templates=1 to DELETE all {$count} override(s).";
        } else {
            echo "✅ No DB overrides! Theme file templates are live:\n";
            echo "   • parts/header.html\n   • parts/footer.html\n   • templates/front-page.html\n";
        }

        echo '</pre></body></html>';
        die();
    }

    // ── CLEAR ──────────────────────────────────────────────────────────
    if ( isset( $_GET['pm_clear_templates'] ) ) {
        global $wpdb;

        $deleted = $wpdb->query(
            "DELETE FROM {$wpdb->posts}
             WHERE post_type IN ('wp_template','wp_template_part')"
        );

        // Orphan cleanup
        $wpdb->query(
            "DELETE pm FROM {$wpdb->postmeta} pm
             LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
             WHERE p.ID IS NULL"
        );

        // Flush object cache if present
        wp_cache_flush();
        flush_rewrite_rules( true );

        http_response_code( 200 );
        header( 'Content-Type: text/html; charset=utf-8' );
        header( 'Cache-Control: no-store' );

        echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>PM Clear</title>';
        echo '<meta http-equiv="refresh" content="3;url=/prakashmarg/"></head><body>';
        echo '<pre style="background:#0a0a1a;color:#39ff14;padding:24px;font-family:monospace;font-size:15px;min-height:100vh;margin:0;">';
        echo "=== Prakash Marg Template DB Clear ===\n\n";
        echo "✅ Deleted: {$deleted} template DB override(s)\n";
        echo "✅ Rewrite rules flushed\n";
        echo "✅ Object cache flushed\n\n";
        echo "Redirecting to homepage in 3 seconds...\n";
        echo "Or click: <a href='/prakashmarg/' style='color:#39ff14;'>Go to Homepage</a>";
        echo '</pre></body></html>';
        die();
    }
}, 1 ); // Priority 1 = very early
