<?php
// pm/saint-hero render.php
if ( ! defined( 'ABSPATH' ) ) exit;

$post_id = get_the_ID();
$saint_service = function_exists('pm_core') ? pm_core()->get('saint_service') : null;
$entity = $saint_service ? $saint_service->getById( $post_id ) : null;

if ( ! $entity ) return '';

$title = esc_html( $entity->native_name ?? get_the_title() );
$tradition = esc_html( $entity->metadata['tradition'] ?? '' );
$bg_url = get_the_post_thumbnail_url( $post_id, 'full' );

$bg_style = $bg_url ? "background-image: linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.4)), url('{$bg_url}');" : "background-color: #1e3a8a;"; // Blue-900 fallback
?>
<div class="pm-block pm-saint-hero relative overflow-hidden py-24 text-white rounded-lg shadow-xl mb-6" style="<?php echo $bg_style; ?> background-size: cover; background-position: center;">
    <div class="container mx-auto px-6 relative z-10">
        <h1 class="text-5xl font-bold mb-4 font-serif text-yellow-500"><?php echo $title; ?></h1>
        <?php if ($tradition): ?>
            <p class="text-xl mb-2 flex items-center">
                <span class="font-semibold text-gray-300">Tradition:</span>
                <span class="ml-2 font-medium text-blue-300"><?php echo $tradition; ?></span>
            </p>
        <?php endif; ?>
    </div>
</div>
