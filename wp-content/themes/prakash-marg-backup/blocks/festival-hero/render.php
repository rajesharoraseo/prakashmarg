<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id = get_the_ID();
$service = function_exists('pm_core') ? pm_core()->get('festival_service') : null;
$entity = $service ? $service->getById( $post_id ) : null;
if ( ! $entity ) return '';

$title = esc_html( $entity->native_name ?? get_the_title() );
$meta1 = esc_html( $entity->metadata['month'] ?? '' );
$meta2 = esc_html( $entity->metadata['tithi'] ?? '' );
$thumb = get_the_post_thumbnail_url( $post_id, 'full' );
?>
<div class="pm-article-hero" style="<?php echo $thumb ? 'background-image:url(' . esc_url( $thumb ) . ')' : 'background:var(--gd)'; ?>; margin-top:-32px; margin-bottom: 32px; border-radius:0;">
    <div class="pm-article-hero-overlay"></div>
    <div class="container pm-article-hero-inner" style="padding-top: 80px; padding-bottom: 80px;">
        <nav class="pm-breadcrumb">
            <a href="<?php echo home_url( '/' ); ?>">🏠 होम</a>
            <span>›</span>
            <a href="#"><?php echo 'त्योहार'; ?></a>
        </nav>
        <div style="margin-bottom:16px"><span class="pm-article-cat"><?php echo '🪔 त्योहार'; ?></span></div>
        <h1 class="pm-article-hero-title"><?php echo $title; ?></h1>
        <div class="pm-article-meta">
            <?php if ($meta1): ?><span class="pm-meta-item"><?php echo 'माह'; ?>: <?php echo $meta1; ?></span><?php endif; ?>
            <?php if ($meta2): ?><span class="pm-meta-item"><?php echo 'तिथि'; ?>: <?php echo $meta2; ?></span><?php endif; ?>
        </div>
    </div>
</div>
