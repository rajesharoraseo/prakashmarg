<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id = get_the_ID();
$service = function_exists('pm_core') ? pm_core()->get('deity_service') : null;
$entity = $service ? $service->getById( $post_id ) : null;
if ( ! $entity || empty($entity->relationships) ) return '';

$rel1 = $entity->relationships['major_temple'] ?? [];
$rel2 = $entity->relationships['dedicated_festival'] ?? [];
?>
<div style="background:var(--iv); border:1px solid var(--bdl); border-radius:12px; padding:24px; margin-bottom:32px;">
    <h3 style="font-size:18px; font-weight:700; color:var(--gd); margin-bottom:20px; border-bottom:1px solid var(--bdl); padding-bottom:12px;">पवित्र संबंध</h3>
    
    <?php if ( ! empty($rel1) ) : ?>
        <div style="margin-bottom:20px;">
            <h4 style="font-size:13px; color:var(--txm); text-transform:uppercase; margin-bottom:12px;"><?php echo 'Major Temples'; ?></h4>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <?php foreach ( $rel1 as $rel ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $rel->id ) ); ?>" style="display:flex; align-items:center; padding:10px; background:#fff; border-radius:8px; border:1px solid var(--bdl); text-decoration:none; color:var(--tx); transition:all 0.2s;">
                        <div style="width:36px; height:36px; border-radius:50%; background:var(--sg); display:flex; align-items:center; justify-content:center; margin-right:12px; font-size:16px;">
                            <?php echo '🛕'; ?>
                        </div>
                        <span style="font-weight:600;"><?php echo esc_html( $rel->title ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( ! empty($rel2) ) : ?>
        <div>
            <h4 style="font-size:13px; color:var(--txm); text-transform:uppercase; margin-bottom:12px;"><?php echo 'Dedicated Festivals'; ?></h4>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <?php foreach ( $rel2 as $rel ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $rel->id ) ); ?>" style="display:flex; align-items:center; padding:10px; background:#fff; border-radius:8px; border:1px solid var(--bdl); text-decoration:none; color:var(--tx); transition:all 0.2s;">
                        <div style="width:36px; height:36px; border-radius:50%; background:var(--sg); display:flex; align-items:center; justify-content:center; margin-right:12px; font-size:16px;">
                            <?php echo '🪔'; ?>
                        </div>
                        <span style="font-weight:600;"><?php echo esc_html( $rel->title ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<style>
a[style]:hover { border-color: var(--go) !important; background: var(--sg) !important; }
</style>
