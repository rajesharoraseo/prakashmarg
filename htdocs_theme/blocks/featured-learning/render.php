<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-section']);
$courses = []; // Placeholder empty state
?>
<section <?php echo $wrapper_attributes; ?>>
    <div class="pm-container">
        <h2 style="margin-bottom: var(--wp--preset--spacing--6);">Start Learning</h2>
        
        <?php if (empty($courses)): ?>
            <div style="background: var(--color-surface); border: 1px dashed var(--color-border); border-radius: 12px; padding: 4rem 2rem; text-align: center;">
                <p style="color: var(--color-text-secondary); margin: 0;">Educational modules are currently in development.</p>
            </div>
        <?php else: ?>
            <!-- Render courses here when API is ready -->
        <?php endif; ?>
    </div>
</section>
