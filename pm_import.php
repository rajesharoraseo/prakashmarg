<?php
/**
 * Prakash Marg Auto-Import Endpoint
 * Accepts JSON POST requests to create Custom Post Types.
 * FOR LOCAL DEV ONLY - No authentication (Do not deploy to live server without auth!)
 */
define( 'WP_USE_THEMES', false );
require_once( __DIR__ . '/wp-load.php' );

header('Content-Type: application/json');

if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    echo json_encode(['error' => 'Only POST allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ( !$input || empty($input['title']) || empty($input['post_type']) ) {
    echo json_encode(['error' => 'Missing title or post_type']);
    exit;
}

$post_data = [
    'post_title'   => wp_strip_all_tags($input['title']),
    'post_content' => $input['content'] ?? '',
    'post_status'  => 'publish',
    'post_type'    => $input['post_type'],
    'meta_input'   => []
];

if ( ! empty( $input['slug'] ) ) {
    $post_data['post_name'] = sanitize_title( $input['slug'] );
}

// Add specific meta fields based on post type
if ( $input['post_type'] === 'pm_scripture' ) {
    $post_data['meta_input']['pm_scripture_type'] = $input['scripture_type'] ?? 'chalisa';
    $post_data['meta_input']['pm_scripture_language'] = $input['language'] ?? 'hindi';
} elseif ( $input['post_type'] === 'pm_temple' ) {
    $post_data['meta_input']['pm_temple_location'] = $input['location'] ?? '';
    $post_data['meta_input']['pm_temple_deity'] = $input['deity'] ?? '';
}

$post_id = wp_insert_post( $post_data );

if ( is_wp_error( $post_id ) ) {
    echo json_encode(['error' => $post_id->get_error_message()]);
} else {
    echo json_encode([
        'success' => true,
        'post_id' => $post_id,
        'message' => "Successfully imported: " . $input['title']
    ]);
}
