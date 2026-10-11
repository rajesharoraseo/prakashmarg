<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-section']);
$scriptures = []; // Placeholder empty state
?>
<section <?php echo $wrapper_attributes; ?> style="background-color: var(--color-surface); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
    <div class="pm-container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: var(--wp--preset--spacing--8);">
            <div>
                <h2 style="margin-bottom: 0.5rem;">Sacred Scriptures</h2>
                <p style="color: var(--color-text-secondary); margin: 0;">Explore ancient texts and philosophies.</p>
            </div>
            <a href="/scriptures" class="pm-btn pm-btn-ghost">Library</a>
        </div>
        
        <?php if (empty($scriptures)): ?>
            <div style="background: var(--wp--preset--color--cream); border: 1px dashed var(--color-border); border-radius: 12px; padding: 4rem 2rem; text-align: center;">
                <p style="color: var(--color-text-secondary); margin: 0; font-size: var(--wp--preset--font-size--medium);">The digital manuscript library is being initialized.</p>
            </div>
        <?php else: ?>
            <!-- Render scriptures here when API is ready -->
        <?php endif; ?>
    </div>
</section>
