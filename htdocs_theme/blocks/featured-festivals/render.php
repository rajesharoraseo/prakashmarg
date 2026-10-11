<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-section']);
$festivals = []; // Placeholder empty state
?>
<section <?php echo $wrapper_attributes; ?>>
    <div class="pm-container">
        <h2 style="margin-bottom: var(--wp--preset--spacing--6); text-align: center;">Upcoming Festivals</h2>
        
        <?php if (empty($festivals)): ?>
            <div style="background: var(--color-surface); border: 1px dashed var(--color-border); border-radius: 12px; padding: 4rem 2rem; text-align: center; max-width: 800px; margin-inline: auto;">
                <p style="color: var(--color-text-secondary); margin: 0;">Festival calendar is currently being synchronized.</p>
            </div>
        <?php else: ?>
            <!-- Render festivals here when API is ready -->
        <?php endif; ?>
    </div>
</section>
