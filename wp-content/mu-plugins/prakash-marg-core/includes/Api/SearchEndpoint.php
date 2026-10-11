<?php
namespace PrakashMarg\Core\Api;

class SearchEndpoint {
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('pm/v1', '/search', [
            'methods' => 'GET',
            'callback' => [$this, 'get_results'],
            'permission_callback' => '__return_true', // Public API
        ]);
    }

    public function get_results(\WP_REST_Request $request) {
        $keyword = sanitize_text_field($request->get_param('q'));
        
        if (empty($keyword)) {
            return rest_ensure_response([]);
        }

        $results = [];

        // Query across all custom post types
        $post_types = ['pm_temple', 'pm_deity', 'pm_saint', 'pm_scripture', 'pm_festival'];

        $args = [
            'post_type' => $post_types,
            'post_status' => 'publish',
            'posts_per_page' => 20,
            's' => $keyword,
        ];

        // Advanced Taxonomy Filtering (Location, Era, Tradition)
        $tax_query = ['relation' => 'AND'];
        
        if ($request->get_param('location')) {
            $tax_query[] = [
                'taxonomy' => 'pm_location',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($request->get_param('location')),
            ];
        }
        if ($request->get_param('era')) {
            $tax_query[] = [
                'taxonomy' => 'pm_era',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($request->get_param('era')),
            ];
        }
        if ($request->get_param('tradition')) {
            $tax_query[] = [
                'taxonomy' => 'pm_tradition',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($request->get_param('tradition')),
            ];
        }

        if (count($tax_query) > 1) {
            $args['tax_query'] = $tax_query;
        }

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                // Get the emoji/icon for the type
                $type_labels = [
                    'pm_temple' => ['icon' => '🛕', 'label' => 'Temple'],
                    'pm_deity' => ['icon' => '🕉️', 'label' => 'Deity'],
                    'pm_saint' => ['icon' => '🧘', 'label' => 'Saint'],
                    'pm_scripture' => ['icon' => '📖', 'label' => 'Scripture'],
                    'pm_festival' => ['icon' => '🪔', 'label' => 'Festival'],
                ];

                $type_info = $type_labels[$post->post_type] ?? ['icon' => '✨', 'label' => 'Resource'];

                $image_url = get_the_post_thumbnail_url($post->ID, 'medium');

                $results[] = [
                    'id' => $post->ID,
                    'title' => html_entity_decode(get_the_title($post->ID)),
                    'url' => get_permalink($post->ID),
                    'type' => $type_info['label'],
                    'icon' => $type_info['icon'],
                    'excerpt' => wp_trim_words($post->post_content, 15),
                    'image' => $image_url ? $image_url : null
                ];
            }
        }

        return rest_ensure_response($results);
    }
}
