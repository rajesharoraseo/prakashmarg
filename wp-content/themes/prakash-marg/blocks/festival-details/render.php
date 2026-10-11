<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id = get_the_ID();
$service = function_exists('pm_core') ? pm_core()->get('festival_service') : null;
$entity = $service ? $service->getById( $post_id ) : null;
if ( ! $entity ) return '';

$det1 = esc_html( $entity->metadata['month'] ?? '' );
$det2 = esc_html( $entity->metadata['tithi'] ?? '' );
$det3 = wp_kses_post( $entity->metadata['significance'] ?? '' );
?>
<div style="background:var(--iv); border:1px solid var(--bdl); border-radius:12px; padding:24px; margin-bottom:32px;">
    <h3 style="font-size:20px; font-family:'Tiro Devanagari Hindi',serif; color:var(--gd); margin-bottom:16px; border-bottom:2px solid var(--go); padding-bottom:8px; display:inline-block;">मुख्य विवरण</h3>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom: 16px;">
        <?php if ($det1): ?>
        <div style="background:rgba(255,255,255,0.6); padding:12px; border-radius:8px;">
            <span style="display:block; font-size:12px; color:var(--txm); text-transform:uppercase; margin-bottom:4px;"><?php echo 'Hindu Month'; ?></span>
            <span style="font-weight:600; color:var(--tx);"><?php echo $det1; ?></span>
        </div>
        <?php endif; ?>
        <?php if ($det2): ?>
        <div style="background:rgba(255,255,255,0.6); padding:12px; border-radius:8px;">
            <span style="display:block; font-size:12px; color:var(--txm); text-transform:uppercase; margin-bottom:4px;"><?php echo 'Tithi'; ?></span>
            <span style="font-weight:600; color:var(--tx);"><?php echo $det2; ?></span>
        </div>
        <?php endif; ?>
    </div>
    <?php if ($det3): ?>
    <div>
        <h4 style="font-size:14px; color:var(--txm); margin-bottom:8px;"><?php echo 'Significance'; ?></h4>
        <p style="color:var(--tx); line-height:1.6; font-size:15px; margin:0;"><?php echo $det3; ?></p>
    </div>
    <?php endif; ?>
</div>
