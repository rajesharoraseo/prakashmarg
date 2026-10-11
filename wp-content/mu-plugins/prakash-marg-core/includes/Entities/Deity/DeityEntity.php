<?php
namespace PrakashMarg\Core\Entities\Deity;

if ( ! defined( 'ABSPATH' ) ) exit;

class DeityEntity {
    public function getById( $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post || $post->post_type !== 'pm_deity' ) return null;
        
        $entity = new \stdClass();
        $entity->id = $post->ID;
        $entity->native_name = get_post_meta( $post->ID, 'pm_native_name', true );
        
        $entity->metadata = [
            'avatar_of' => get_post_meta( $post->ID, 'pm_avatar_of', true ),
            'core_mantra' => get_post_meta( $post->ID, 'pm_core_mantra', true ),
            'associated_elements' => get_post_meta( $post->ID, 'pm_associated_elements', true )
        ];

        // Fetch relationships
        $entity->relationships = [];
        $temple_id = get_post_meta( $post->ID, 'pm_associated_temple', true );
        if ($temple_id) {
            $temple = get_post($temple_id);
            if ($temple) {
                $entity->relationships['associated_temple'][] = (object) ['id' => $temple->ID, 'title' => $temple->post_title];
            }
        }
        
        return $entity;
    }

    public function getFeatured($limit = 4) {
        $args = [
            'post_type' => 'pm_deity',
            'posts_per_page' => $limit,
            'post_status' => 'publish'
        ];
        $posts = get_posts($args);
        $featured = [];
        foreach($posts as $post) {
            $entity = new \stdClass();
            $entity->id = $post->ID;
            $entity->title = $post->post_title;
            $entity->metadata = [
                'mantra' => get_post_meta($post->ID, 'pm_mantra', true) ?: 'Om Namah Shivaya'
            ];
            $featured[] = $entity;
        }
        return $featured;
    }
}
