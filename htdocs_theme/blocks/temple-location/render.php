<?php
/**
 * Render template for temple-location
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; ?>>
    <div class="pm-block-placeholder">
        <h3><?php echo esc_html( 'TEMPLE LOCATION' ); ?></h3>
        <p>This block is dynamically rendered by the Entity Engine.</p>
    </div>
</div>