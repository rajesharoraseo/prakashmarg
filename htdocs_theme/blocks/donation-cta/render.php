<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-section']);
?>
<section <?php echo $wrapper_attributes; ?> style="padding-block: 4rem; text-align: center;">
    <div class="pm-container">
        <p style="font-size: var(--wp--preset--font-size--medium); color: var(--color-text-secondary); margin-bottom: 1.5rem;">Prakash Marg is maintained as a free public knowledge platform.</p>
        <a href="/support" class="pm-btn pm-btn-ghost">Support the Mission</a>
    </div>
</section>
