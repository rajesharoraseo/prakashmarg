<?php
namespace PrakashMarg\Core\Entities;

if ( ! defined( 'ABSPATH' ) ) exit;

class EntityRegistry {
    public function register_cpts() {
        add_action('init', function() {
            register_post_type( 'pm_temple', [
                'labels' => [
                    'name' => 'Temples',
                    'singular_name' => 'Temple'
                ],
                'public' => true,
                'has_archive' => true,
                'show_in_rest' => true,
                'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
                'menu_icon' => 'dashicons-building'
            ]);

            register_post_type( 'pm_scripture', [
                'labels' => [
                    'name' => 'Scriptures',
                    'singular_name' => 'Scripture'
                ],
                'public' => true,
                'has_archive' => true,
                'show_in_rest' => true,
                'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
                'menu_icon' => 'dashicons-book'
            ]);

            register_post_type( 'pm_deity', [
                'labels' => [
                    'name' => 'Deities',
                    'singular_name' => 'Deity'
                ],
                'public' => true,
                'has_archive' => true,
                'show_in_rest' => true,
                'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
                'menu_icon' => 'dashicons-universal-access-alt'
            ]);

            register_post_type( 'pm_saint', [
                'labels' => [
                    'name' => 'Saints',
                    'singular_name' => 'Saint'
                ],
                'public' => true,
                'has_archive' => true,
                'show_in_rest' => true,
                'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
                'menu_icon' => 'dashicons-groups'
            ]);

            register_post_type( 'pm_festival', [
                'labels' => [
                    'name' => 'Festivals',
                    'singular_name' => 'Festival'
                ],
                'public' => true,
                'has_archive' => true,
                'show_in_rest' => true,
                'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
                'menu_icon' => 'dashicons-calendar-alt'
            ]);
        });
    }
}
