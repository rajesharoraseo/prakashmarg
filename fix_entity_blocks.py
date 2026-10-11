import os

theme_dir = r"c:\PrakashMarg\wp-content\themes\prakash-marg\blocks"

entities = {
    'temple': {
        'icon': '🛕', 'label': 'मन्दिर',
        'meta_1_label': 'स्थान', 'meta_1_key': 'location',
        'meta_2_label': 'मुख्य देवता', 'meta_2_key': 'deity',
        'det_1_label': 'Historical Era', 'det_1_key': 'historical_era',
        'det_2_label': 'Architecture', 'det_2_key': 'architectural_style',
        'det_3_label': 'Historical Importance', 'det_3_key': 'historical_importance',
        'rel_1_label': 'Main Deities', 'rel_1_key': 'main_deity', 'rel_1_icon': '🕉️',
        'rel_2_label': 'Major Festivals', 'rel_2_key': 'major_festival', 'rel_2_icon': '🪔'
    },
    'scripture': {
        'icon': '📖', 'label': 'ग्रंथ',
        'meta_1_label': 'भाषा', 'meta_1_key': 'language',
        'meta_2_label': 'रचयिता', 'meta_2_key': 'author',
        'det_1_label': 'Language', 'det_1_key': 'language',
        'det_2_label': 'Author/Sage', 'det_2_key': 'author',
        'det_3_label': 'Core Philosophy', 'det_3_key': 'core_philosophy',
        'rel_1_label': 'Associated Deities', 'rel_1_key': 'associated_deity', 'rel_1_icon': '🕉️',
        'rel_2_label': 'Key Commentaries', 'rel_2_key': 'commentary', 'rel_2_icon': '✍️'
    },
    'deity': {
        'icon': '🕉️', 'label': 'देवता',
        'meta_1_label': 'मूल', 'meta_1_key': 'origin',
        'meta_2_label': 'अस्त्र', 'meta_2_key': 'weapon',
        'det_1_label': 'Consort', 'det_1_key': 'consort',
        'det_2_label': 'Mount (Vahana)', 'det_2_key': 'mount',
        'det_3_label': 'Mantra', 'det_3_key': 'mantra',
        'rel_1_label': 'Major Temples', 'rel_1_key': 'major_temple', 'rel_1_icon': '🛕',
        'rel_2_label': 'Dedicated Festivals', 'rel_2_key': 'dedicated_festival', 'rel_2_icon': '🪔'
    },
    'festival': {
        'icon': '🪔', 'label': 'त्योहार',
        'meta_1_label': 'माह', 'meta_1_key': 'month',
        'meta_2_label': 'तिथि', 'meta_2_key': 'tithi',
        'det_1_label': 'Hindu Month', 'det_1_key': 'month',
        'det_2_label': 'Tithi', 'det_2_key': 'tithi',
        'det_3_label': 'Significance', 'det_3_key': 'significance',
        'rel_1_label': 'Associated Deities', 'rel_1_key': 'associated_deity', 'rel_1_icon': '🕉️',
        'rel_2_label': 'Major Locations', 'rel_2_key': 'major_location', 'rel_2_icon': '📍'
    }
}

hero_template = """<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id = get_the_ID();
$service = function_exists('pm_core') ? pm_core()->get('{entity}_service') : null;
$entity = $service ? $service->getById( $post_id ) : null;
if ( ! $entity ) return '';

$title = esc_html( $entity->native_name ?? get_the_title() );
$meta1 = esc_html( $entity->metadata['{meta_1_key}'] ?? '' );
$meta2 = esc_html( $entity->metadata['{meta_2_key}'] ?? '' );
$thumb = get_the_post_thumbnail_url( $post_id, 'full' );
?>
<div class="pm-article-hero" style="<?php echo $thumb ? 'background-image:url(' . esc_url( $thumb ) . ')' : 'background:var(--gd)'; ?>; margin-top:-32px; margin-bottom: 32px; border-radius:0;">
    <div class="pm-article-hero-overlay"></div>
    <div class="container pm-article-hero-inner" style="padding-top: 80px; padding-bottom: 80px;">
        <nav class="pm-breadcrumb">
            <a href="<?php echo home_url( '/' ); ?>">🏠 होम</a>
            <span>›</span>
            <a href="#"><?php echo '{label}'; ?></a>
        </nav>
        <div style="margin-bottom:16px"><span class="pm-article-cat"><?php echo '{icon} {label}'; ?></span></div>
        <h1 class="pm-article-hero-title"><?php echo $title; ?></h1>
        <div class="pm-article-meta">
            <?php if ($meta1): ?><span class="pm-meta-item"><?php echo '{meta_1_label}'; ?>: <?php echo $meta1; ?></span><?php endif; ?>
            <?php if ($meta2): ?><span class="pm-meta-item"><?php echo '{meta_2_label}'; ?>: <?php echo $meta2; ?></span><?php endif; ?>
        </div>
    </div>
</div>
"""

details_template = """<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id = get_the_ID();
$service = function_exists('pm_core') ? pm_core()->get('{entity}_service') : null;
$entity = $service ? $service->getById( $post_id ) : null;
if ( ! $entity ) return '';

$det1 = esc_html( $entity->metadata['{det_1_key}'] ?? '' );
$det2 = esc_html( $entity->metadata['{det_2_key}'] ?? '' );
$det3 = wp_kses_post( $entity->metadata['{det_3_key}'] ?? '' );
?>
<div style="background:var(--iv); border:1px solid var(--bdl); border-radius:12px; padding:24px; margin-bottom:32px;">
    <h3 style="font-size:20px; font-family:'Tiro Devanagari Hindi',serif; color:var(--gd); margin-bottom:16px; border-bottom:2px solid var(--go); padding-bottom:8px; display:inline-block;">मुख्य विवरण</h3>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom: 16px;">
        <?php if ($det1): ?>
        <div style="background:rgba(255,255,255,0.6); padding:12px; border-radius:8px;">
            <span style="display:block; font-size:12px; color:var(--txm); text-transform:uppercase; margin-bottom:4px;"><?php echo '{det_1_label}'; ?></span>
            <span style="font-weight:600; color:var(--tx);"><?php echo $det1; ?></span>
        </div>
        <?php endif; ?>
        <?php if ($det2): ?>
        <div style="background:rgba(255,255,255,0.6); padding:12px; border-radius:8px;">
            <span style="display:block; font-size:12px; color:var(--txm); text-transform:uppercase; margin-bottom:4px;"><?php echo '{det_2_label}'; ?></span>
            <span style="font-weight:600; color:var(--tx);"><?php echo $det2; ?></span>
        </div>
        <?php endif; ?>
    </div>
    <?php if ($det3): ?>
    <div>
        <h4 style="font-size:14px; color:var(--txm); margin-bottom:8px;"><?php echo '{det_3_label}'; ?></h4>
        <p style="color:var(--tx); line-height:1.6; font-size:15px; margin:0;"><?php echo $det3; ?></p>
    </div>
    <?php endif; ?>
</div>
"""

rel_template = """<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id = get_the_ID();
$service = function_exists('pm_core') ? pm_core()->get('{entity}_service') : null;
$entity = $service ? $service->getById( $post_id ) : null;
if ( ! $entity || empty($entity->relationships) ) return '';

$rel1 = $entity->relationships['{rel_1_key}'] ?? [];
$rel2 = $entity->relationships['{rel_2_key}'] ?? [];
?>
<div style="background:var(--iv); border:1px solid var(--bdl); border-radius:12px; padding:24px; margin-bottom:32px;">
    <h3 style="font-size:18px; font-weight:700; color:var(--gd); margin-bottom:20px; border-bottom:1px solid var(--bdl); padding-bottom:12px;">पवित्र संबंध</h3>
    
    <?php if ( ! empty($rel1) ) : ?>
        <div style="margin-bottom:20px;">
            <h4 style="font-size:13px; color:var(--txm); text-transform:uppercase; margin-bottom:12px;"><?php echo '{rel_1_label}'; ?></h4>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <?php foreach ( $rel1 as $rel ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $rel->id ) ); ?>" style="display:flex; align-items:center; padding:10px; background:#fff; border-radius:8px; border:1px solid var(--bdl); text-decoration:none; color:var(--tx); transition:all 0.2s;">
                        <div style="width:36px; height:36px; border-radius:50%; background:var(--sg); display:flex; align-items:center; justify-content:center; margin-right:12px; font-size:16px;">
                            <?php echo '{rel_1_icon}'; ?>
                        </div>
                        <span style="font-weight:600;"><?php echo esc_html( $rel->title ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( ! empty($rel2) ) : ?>
        <div>
            <h4 style="font-size:13px; color:var(--txm); text-transform:uppercase; margin-bottom:12px;"><?php echo '{rel_2_label}'; ?></h4>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <?php foreach ( $rel2 as $rel ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $rel->id ) ); ?>" style="display:flex; align-items:center; padding:10px; background:#fff; border-radius:8px; border:1px solid var(--bdl); text-decoration:none; color:var(--tx); transition:all 0.2s;">
                        <div style="width:36px; height:36px; border-radius:50%; background:var(--sg); display:flex; align-items:center; justify-content:center; margin-right:12px; font-size:16px;">
                            <?php echo '{rel_2_icon}'; ?>
                        </div>
                        <span style="font-weight:600;"><?php echo esc_html( $rel->title ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<style>
a[style]:hover {{ border-color: var(--go) !important; background: var(--sg) !important; }}
</style>
"""

for ent, data in entities.items():
    hero_code = hero_template.format(entity=ent, **data)
    hero_path = os.path.join(theme_dir, f"{ent}-hero", "render.php")
    if os.path.exists(hero_path):
        with open(hero_path, "w", encoding="utf-8") as f:
            f.write(hero_code)
            
    det_code = details_template.format(entity=ent, **data)
    det_path = os.path.join(theme_dir, f"{ent}-details", "render.php")
    if os.path.exists(det_path):
        with open(det_path, "w", encoding="utf-8") as f:
            f.write(det_code)
            
    rel_code = rel_template.format(entity=ent, **data)
    rel_path = os.path.join(theme_dir, f"{ent}-relationships", "render.php")
    if os.path.exists(rel_path):
        with open(rel_path, "w", encoding="utf-8") as f:
            f.write(rel_code)

print("Rewrote all block templates.")
