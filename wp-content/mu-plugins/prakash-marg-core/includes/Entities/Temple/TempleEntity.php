<?php
namespace PrakashMarg\Core\Entities\Temple;

if ( ! defined( 'ABSPATH' ) ) exit;

class TempleEntity {
    public function getById( $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post || $post->post_type !== 'pm_temple' ) return null;
        
        $entity = new \stdClass();
        $entity->id = $post->ID;
        $entity->native_name = get_post_meta( $post->ID, 'pm_native_name', true );
        
        $entity->metadata = [
            'location' => get_post_meta( $post->ID, 'pm_location', true ) ?: 'Varanasi, India',
            'deity'    => get_post_meta( $post->ID, 'pm_deity', true ) ?: 'Shiva'
        ];
        
        return $entity;
    }

    public function getFeatured($limit = 4) {
        $args = [
            'post_type' => 'pm_temple',
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
                'city' => get_post_meta($post->ID, 'pm_location', true) ?: 'Varanasi, India'
            ];
            $featured[] = $entity;
        }
        return $featured;
    }
}
