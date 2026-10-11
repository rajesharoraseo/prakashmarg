<?php
namespace PrakashMarg\Core\Entities\Festival;

if ( ! defined( 'ABSPATH' ) ) exit;

class FestivalEntity {
    public function getById( $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post || $post->post_type !== 'pm_festival' ) return null;
        
        $entity = new \stdClass();
        $entity->id = $post->ID;
        $entity->native_name = get_post_meta( $post->ID, 'pm_native_name', true );
        
        $entity->metadata = [
            'month_observed' => get_post_meta( $post->ID, 'pm_month_observed', true ),
            'significance' => get_post_meta( $post->ID, 'pm_significance', true ),
            'primary_rituals' => get_post_meta( $post->ID, 'pm_primary_rituals', true )
        ];

        // Fetch relationships
        $entity->relationships = [];
        $deity_id = get_post_meta( $post->ID, 'pm_dedicated_to', true );
        if ($deity_id) {
            $deity = get_post($deity_id);
            if ($deity) {
                $entity->relationships['dedicated_to'][] = (object) ['id' => $deity->ID, 'title' => $deity->post_title];
            }
        }
        
        return $entity;
    }

    public function getFeatured($limit = 4) {
        $args = [
            'post_type' => 'pm_festival',
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
                'month' => get_post_meta($post->ID, 'pm_month', true) ?: 'Kartik'
            ];
            $featured[] = $entity;
        }
        return $featured;
    }
}
