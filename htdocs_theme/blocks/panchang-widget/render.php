<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-section pm-panchang-section']);
// Simulate no backend data available yet
$has_panchang_data = false; 
?>
<section <?php echo $wrapper_attributes; ?> style="margin-top: -3rem; position: relative; z-index: 10;">
    <div class="pm-container">
        <div class="pm-card pm-card-elevated" style="padding: var(--wp--preset--spacing--8); display: flex; flex-direction: column; gap: var(--wp--preset--spacing--6);">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <span class="pm-badge" style="background: var(--color-surface-elevated); color: var(--color-primary); margin-bottom: 0.5rem; border: 1px solid var(--color-primary);">TODAY</span>
                    <h2 style="margin:0; font-size: var(--wp--preset--font-size--large);">
                        <?php echo date('l, F j, Y'); ?>
                    </h2>
                </div>
            </div>

            <?php if (!$has_panchang_data): ?>
                <div style="background: var(--wp--preset--color--neutral-100); border-radius: 8px; padding: 1.5rem; text-align: center;">
                    <p style="color: var(--color-text-secondary); font-style: italic; margin: 0;">Astronomical data is currently being synchronized with the observatory API.</p>
                </div>
            <?php else: ?>
                <!-- This branch remains for when real data is integrated -->
            <?php endif; ?>
            
        </div>
    </div>
</section>
