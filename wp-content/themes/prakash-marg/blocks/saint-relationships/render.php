<?php
// pm/saint-relationships render.php
if ( ! defined( 'ABSPATH' ) ) exit;

$post_id = get_the_ID();
$saint_service = function_exists('pm_core') ? pm_core()->get('saint_service') : null;
$entity = $saint_service ? $saint_service->getById( $post_id ) : null;

if ( ! $entity || empty($entity->relationships) ) return '';

$scriptures = $entity->relationships['authored_text'] ?? [];
$disciples = $entity->relationships['prominent_disciple'] ?? [];
?>
<div class="pm-block pm-saint-relationships bg-gray-50 rounded-lg p-6 my-6">
    <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Lineage & Works</h3>
    
    <?php if ( ! empty($scriptures) ) : ?>
        <div class="mb-5">
            <h4 class="text-sm font-semibold text-gray-500 uppercase mb-3">Authored Texts</h4>
            <div class="flex flex-col gap-2">
                <?php foreach ( $scriptures as $scripture ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $scripture->id ) ); ?>" class="flex items-center p-3 bg-white hover:bg-orange-50 rounded shadow-sm transition group border border-transparent hover:border-orange-200">
                        <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 mr-3">
                            📜
                        </div>
                        <span class="font-medium text-gray-800 group-hover:text-orange-600"><?php echo esc_html( $scripture->title ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( ! empty($disciples) ) : ?>
        <div>
            <h4 class="text-sm font-semibold text-gray-500 uppercase mb-3">Prominent Disciples</h4>
            <div class="flex flex-col gap-2">
                <?php foreach ( $disciples as $disciple ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $disciple->id ) ); ?>" class="flex items-center p-3 bg-white hover:bg-blue-50 rounded shadow-sm transition group border border-transparent hover:border-blue-200">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                            🧘
                        </div>
                        <span class="font-medium text-gray-800 group-hover:text-blue-600"><?php echo esc_html( $disciple->title ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
