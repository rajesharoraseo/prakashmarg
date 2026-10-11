<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-hero-section']);
?>
<section <?php echo $wrapper_attributes; ?> style="background-color: var(--color-surface-elevated); padding-block: 8rem 6rem; text-align: center; border-bottom: 1px solid var(--color-border);">
    <div class="pm-container pm-container-wide">
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 1.5rem;">Explore the Knowledge of Sanatan Dharma</h1>
        <p style="font-size: var(--wp--preset--font-size--medium); color: var(--color-text-secondary); max-width: 800px; margin-inline: auto; margin-bottom: 3rem;">
            Temples &bull; Scriptures &bull; Saints &bull; Festivals &bull; Mantras &bull; Traditions
        </p>
        
        <form action="<?php echo esc_url(site_url('/search')); ?>" method="get" style="max-width: 600px; margin-inline: auto; margin-bottom: 2rem; position: relative;">
            <label for="pm-global-search" class="screen-reader-text" style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0;">Search temples, scriptures, saints, festivals, mantras...</label>
            <div style="display: flex; gap: 8px;">
                <input id="pm-global-search" class="pm-input" type="search" name="q" placeholder="Search temples, scriptures, saints, festivals, mantras..." aria-label="Global Search" style="flex: 1; padding-left: 1.5rem; border-radius: 24px; box-shadow: var(--shadow-sm);">
                <button class="pm-btn pm-btn-primary" type="submit" style="border-radius: 24px; padding-inline: 2rem;">Search</button>
            </div>
        </form>
        
        <!-- Trending section removed as it contained fake production content and no architecture provides legitimate data for it -->
    </div>
</section>
