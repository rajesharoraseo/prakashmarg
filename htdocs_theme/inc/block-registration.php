<?php
// Register pm-entities and pm-homepage dynamic blocks
add_action( 'init', function() {
    $blocks = [
        'temple-hero',
        'temple-quick-facts',
        'temple-gallery',
        'temple-timeline',
        'temple-relationships',
        'temple-location',
        'temple-breadcrumb',
        'hero-search',
        'panchang-widget',
        'featured-temples',
        'featured-scriptures',
        'featured-festivals',
        'daily-wisdom',
        'latest-articles',
        'featured-learning',
        'newsletter',
        'donation-cta'
    ];
    
    $block_dir = get_template_directory() . '/blocks/';
    foreach ( $blocks as $block ) {
        if ( file_exists( $block_dir . $block . '/block.json' ) ) {
            register_block_type( $block_dir . $block );
        }
    }
} );
