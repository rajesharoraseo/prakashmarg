<?php
namespace PrakashMarg\Core\Entities\Saint;

if ( ! defined( 'ABSPATH' ) ) exit;

class SaintEntity {
    public function getById( $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post || $post->post_type !== 'pm_saint' ) return null;
        
        $entity = new \stdClass();
        $entity->id = $post->ID;
        $entity->native_name = get_post_meta( $post->ID, 'pm_native_name', true );
        
        $entity->metadata = [
            'tradition' => get_post_meta( $post->ID, 'pm_tradition', true ),
            'lifespan' => get_post_meta( $post->ID, 'pm_lifespan', true ),
            'key_teachings' => get_post_meta( $post->ID, 'pm_key_teachings', true )
        ];

        $entity->relationships = [];
        
        return $entity;
    }

    public function getFeatured($limit = 4) {
        $args = [
            'post_type' => 'pm_saint',
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
                'tradition' => get_post_meta($post->ID, 'pm_tradition', true) ?: 'Advaita Vedanta'
            ];
            $featured[] = $entity;
        }
        return $featured;
    }
}
