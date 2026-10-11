<?php
// pm/saint-details render.php
if ( ! defined( 'ABSPATH' ) ) exit;

$post_id = get_the_ID();
$saint_service = function_exists('pm_core') ? pm_core()->get('saint_service') : null;
$entity = $saint_service ? $saint_service->getById( $post_id ) : null;

if ( ! $entity ) return '';

$lifespan = esc_html( $entity->metadata['lifespan'] ?? 'Unknown' );
$teachings = esc_html( $entity->metadata['key_teachings'] ?? '' );
?>
<div class="pm-block pm-saint-details bg-white rounded-lg shadow-md p-6 my-6 border-t-4 border-blue-500">
    <h3 class="text-2xl font-bold mb-4 text-gray-800">Life & Teachings</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <?php if ( $lifespan ) : ?>
        <div class="bg-blue-50 p-4 rounded">
            <span class="block text-sm text-gray-500 uppercase tracking-wide">Lifespan</span>
            <span class="font-semibold text-gray-900"><?php echo $lifespan; ?></span>
        </div>
        <?php endif; ?>
    </div>
    
    <?php if ( $teachings ) : ?>
    <div class="mb-6">
        <h4 class="font-bold text-gray-700 mb-2">Key Teachings</h4>
        <p class="text-gray-600 leading-relaxed"><?php echo $teachings; ?></p>
    </div>
    <?php endif; ?>
</div>
