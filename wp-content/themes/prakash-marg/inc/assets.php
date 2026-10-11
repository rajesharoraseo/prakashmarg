<?php
/**
 * Assets Enqueueing
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function prakash_marg_enqueue_assets() {
	// Main theme stylesheet
	wp_enqueue_style(
		'prakash-marg-style',
		get_stylesheet_uri(),
		[],
		filemtime( get_stylesheet_directory() . '/style.css' )
	);

	// Panchang astronomical calculator (must load before theme.js)
	wp_enqueue_script(
		'prakash-marg-panchang',
		PRAKASH_MARG_URI . 'assets/js/panchang.js',
		[],
		PRAKASH_MARG_VERSION,
		true
	);

	// Main theme JavaScript — all homepage interactivity
	wp_enqueue_script(
		'prakash-marg-theme',
		PRAKASH_MARG_URI . 'assets/js/theme.js',
		[ 'prakash-marg-panchang' ], // depends on panchang.js
		PRAKASH_MARG_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'prakash_marg_enqueue_assets' );



/**
 * Google Fonts preconnect for faster loading
 */
function prakash_marg_preconnect_fonts() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'prakash_marg_preconnect_fonts', 1 );

/**
 * Inject dynamic home URL for JS
 */
function prakash_marg_js_vars() {
	echo '<script>var PM_HOME = "' . esc_url( home_url() ) . '";</script>' . "\n";
}
add_action( 'wp_head', 'prakash_marg_js_vars', 2 );

/**
 * Inline JS for top-bar live date (IST)
 */
function prakash_marg_header_scripts() {
	?>
	<script>
	(function () {
		'use strict';
		var el = document.getElementById('pm-today-date');
		if (!el) return;
		var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
		var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
		var now = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Kolkata' }));
		el.textContent = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'prakash_marg_header_scripts' );

