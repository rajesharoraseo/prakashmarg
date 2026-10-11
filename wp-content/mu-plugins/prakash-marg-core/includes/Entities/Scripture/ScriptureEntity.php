<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureEntity {
    public function getById( $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post || $post->post_type !== 'pm_scripture' ) return null;
        
        $entity = new \stdClass();
        $entity->id = $post->ID;
        $entity->native_name = get_post_meta( $post->ID, 'pm_native_name', true );
        
        // Load metadata
        $entity->metadata = [
            'author_sage' => get_post_meta( $post->ID, 'pm_author_sage', true ) ?: 'Ved Vyas',
            'language'    => get_post_meta( $post->ID, 'pm_language', true ) ?: 'Sanskrit',
            'total_verses'=> get_post_meta( $post->ID, 'pm_total_verses', true ) ?: '700',
            'philosophy'  => get_post_meta( $post->ID, 'pm_philosophy', true ) ?: 'Vedanta',
            'historical_period' => get_post_meta( $post->ID, 'pm_historical_period', true ) ?: 'Ancient'
        ];
        
        $entity->media = [
            'pdf_url' => get_post_meta( $post->ID, 'pm_pdf_url', true ) ?: '#',
            'audio_url' => get_post_meta( $post->ID, 'pm_audio_url', true ) ?: '#'
        ];
        
        $entity->monetization = [
            'affiliate_link' => get_post_meta( $post->ID, 'pm_affiliate_link', true ) ?: ''
        ];

        return $entity;
    }

    public function getFeatured($limit = 4) {
        $args = [
            'post_type' => 'pm_scripture',
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
                'author_sage' => get_post_meta($post->ID, 'pm_author_sage', true) ?: 'Ved Vyasa'
            ];
            $featured[] = $entity;
        }
        return $featured;
    }
}
