<?php
/**
 * Security Hardening
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Remove WordPress version generator meta tag
remove_action( 'wp_head', 'wp_generator' );

// Remove Windows Live Writer manifest link
remove_action( 'wp_head', 'wlwmanifest_link' );

// Remove RSD link
remove_action( 'wp_head', 'rsd_link' );
