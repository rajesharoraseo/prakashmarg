<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-section']);
$var = function_exists('pm_core') ? pm_core()->get('temple_service') : null;
$temples = $var ? $var->getFeatured(4) : [];
?>
<section <?php echo $wrapper_attributes; ?>>
    <div class="pm-container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: var(--wp--preset--spacing--8);">
            <div>
                <h2 style="margin-bottom: 0.5rem;">Featured Temples</h2>
                <p style="color: var(--color-text-secondary); margin: 0;">Discover sacred architecture and history.</p>
            </div>
            <a href="/temples" class="pm-btn pm-btn-ghost">View All</a>
        </div>
        
        <?php if (empty($temples)): ?>
            <div style="background: var(--color-surface); border: 1px dashed var(--color-border); border-radius: 12px; padding: 4rem 2rem; text-align: center;">
                <p style="color: var(--color-text-secondary); margin: 0; font-size: var(--wp--preset--font-size--medium);">Sacred places are currently being added to the knowledge library.</p>
            </div>
        <?php else: ?>
            <div class="pm-grid pm-grid-cols-4">
                <?php foreach($temples as $item): ?>
                    <div class="pm-card" style="display: flex; flex-direction: column; height: 100%;">
                        <div style="aspect-ratio: 16/9; background: var(--color-border); overflow: hidden;">
                            <!-- Placeholder image handling -->
                        </div>
                        <div class="pm-card-body" style="flex: 1; display: flex; flex-direction: column;">
                            <h3 style="font-size: var(--wp--preset--font-size--medium); margin-bottom: 0.5rem;"><?php echo esc_html($item->title); ?></h3>
                            <p style="color: var(--color-text-secondary); font-size: var(--wp--preset--font-size--small); margin-bottom: 1rem; flex: 1;">
                                <?php echo esc_html($item->metadata['city'] ?? 'Unknown Location'); ?>
                            </p>
                            <a href="#" class="pm-btn pm-btn-ghost" style="align-self: flex-start; padding-inline: 0; min-height: auto;">View Temple &rarr;</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
