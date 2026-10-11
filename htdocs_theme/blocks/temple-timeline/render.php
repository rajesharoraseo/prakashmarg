<?php
/**
 * Render template for temple-timeline
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; ?>>
    <div class="pm-block-placeholder">
        <h3><?php echo esc_html( 'TEMPLE TIMELINE' ); ?></h3>
        <p>This block is dynamically rendered by the Entity Engine.</p>
    </div>
</div>