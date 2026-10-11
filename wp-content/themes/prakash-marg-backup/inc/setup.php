<?php
/**
 * Theme Setup
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'prakash_marg_setup' ) ) :
	function prakash_marg_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'prakash-marg', PRAKASH_MARG_DIR . 'languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for Editor Styles.
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );

		// HTML5 markup support.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		] );

		// Responsive embeds
		add_theme_support( 'responsive-embeds' );

		// WooCommerce support
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
endif;
add_action( 'after_setup_theme', 'prakash_marg_setup' );
