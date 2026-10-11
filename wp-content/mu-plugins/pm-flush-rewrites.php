<?php
/**
 * Auto-flush rewrite rules once.
 * This file auto-deletes itself after running once.
 * Place in: wp-content/mu-plugins/
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
    if ( get_option( 'pm_rewrites_flushed_v2' ) ) return;
    flush_rewrite_rules( true );
    update_option( 'pm_rewrites_flushed_v2', true );
    error_log( '[Prakash Marg] Rewrite rules flushed automatically.' );
} );
