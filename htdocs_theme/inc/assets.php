<?php
/**
 * Assets Enqueueing
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function prakash_marg_enqueue_assets() {
	// Frontend styles are mostly handled by theme.json
	wp_enqueue_style( 'prakash-marg-style', get_stylesheet_uri(), [], PRAKASH_MARG_VERSION );
}
add_action( 'wp_enqueue_scripts', 'prakash_marg_enqueue_assets' );
