<?php
// Register pm-entities and pm-homepage dynamic blocks
add_action( 'init', function() {
    $blocks = [
        'hero-search',
        'featured-temples',
        'featured-scriptures',
        'featured-deities',
        'featured-saints',
        'featured-festivals',
        'scripture-hero',
        'scripture-details',
        'scripture-relationships',
        'temple-hero',
        'temple-details',
        'advanced-search',
        'ad-slot',
        'jaap-counter',
        'lucky-number',
        'temple-relationships',
        'deity-hero',
        'deity-details',
        'deity-relationships',
        'saint-hero',
        'saint-details',
        'saint-relationships',
        'festival-hero',
        'festival-details',
        'festival-relationships',
        'panchang-widget',
        'daily-wisdom',
        'latest-articles',
        'featured-learning',
        'newsletter',
        'donation-cta',
        'sidebar-monetize',
        'reading-toolbar'
    ];
    
    $block_dir = get_template_directory() . '/blocks/';
    foreach ( $blocks as $block ) {
        if ( file_exists( $block_dir . $block . '/block.json' ) ) {
            register_block_type( $block_dir . $block );
        }
    }
} );
