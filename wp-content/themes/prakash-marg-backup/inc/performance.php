<?php
/**
 * Performance Optimization
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Remove query strings from static resources
function prakash_marg_remove_script_version( $src ) {
	$parts = explode( '?ver', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', 'prakash_marg_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'prakash_marg_remove_script_version', 15, 1 );

// Disable emojis (often unnecessary and adds extra requests)
function prakash_marg_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'prakash_marg_disable_emojis' );
