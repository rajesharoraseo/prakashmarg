<?php
/**
 * Prakash Marg functions and definitions
 *
 * @package Prakash_Marg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'PRAKASH_MARG_VERSION', '1.0.0' );
define( 'PRAKASH_MARG_DIR', trailingslashit( get_template_directory() ) );
define( 'PRAKASH_MARG_URI', trailingslashit( get_template_directory_uri() ) );

/**
 * Bootstrapping modular includes.
 * Business logic is forbidden here.
 */
$prakash_marg_includes = [
	'inc/setup.php',
	'inc/assets.php',
	'inc/performance.php',
	'inc/accessibility.php',
	'inc/editor.php',
	'inc/security.php',
	'inc/cleanup.php'
];

foreach ( $prakash_marg_includes as $file ) {
	if ( ! locate_template( $file, true, true ) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'prakash-marg' ), $file ), E_USER_ERROR );
	}
}

require_once get_template_directory() . '/inc/block-registration.php';
