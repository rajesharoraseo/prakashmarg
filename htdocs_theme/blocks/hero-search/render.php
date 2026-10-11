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
        
        <form action="/search" method="get" style="max-width: 600px; margin-inline: auto; margin-bottom: 2rem; position: relative;">
            <div style="display: flex; gap: 8px;">
                <input class="pm-input" type="search" name="q" placeholder="Search temples, scriptures, saints, festivals, mantras..." aria-label="Global Search" style="flex: 1; padding-left: 1.5rem; border-radius: 24px; box-shadow: var(--shadow-sm);">
                <button class="pm-btn pm-btn-primary" type="submit" style="border-radius: 24px; padding-inline: 2rem;">Search</button>
            </div>
        </form>
        
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; align-items: center;">
            <span style="font-size: var(--wp--preset--font-size--small); color: var(--color-text-muted);">Trending:</span>
            <?php 
            $trending = ['Bhagavad Gita', 'Hanuman Chalisa', 'Mahadev', 'Krishna', 'Ramayana', 'Gayatri Mantra'];
            foreach($trending as $term): ?>
                <a href="/search?q=<?php echo urlencode($term); ?>" style="font-size: var(--wp--preset--font-size--small); padding: 4px 12px; background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 16px; color: var(--color-text-secondary); transition: all 0.2s; text-decoration: none;">
                    <?php echo esc_html($term); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
