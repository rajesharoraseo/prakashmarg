<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id = get_the_ID();
$title = get_the_title();
$meta1 = get_post_meta( $post_id, 'pm_language', true ) ?: 'हिन्दी';
$meta2 = get_post_meta( $post_id, 'pm_author_sage', true ) ?: 'तुलसीदास';
$thumb = get_the_post_thumbnail_url( $post_id, 'full' );

$title_lower = mb_strtolower($title, 'UTF-8');
$theme_gd = '#8F1D22'; // Default Deep Maroon
$theme_go = '#B88A36'; // Default Antique Gold
$theme_bg = '#FFF8E9'; // Default Warm Ivory
$is_chalisa = false;
$top_title = '॥ श्री परमात्मने नमः ॥';

if (strpos($title_lower, 'चालीसा') !== false || strpos($title_lower, 'chalisa') !== false) {
    $is_chalisa = true;
    if (strpos($title_lower, 'शनि') !== false || strpos($title_lower, 'shani') !== false) {
        $theme_gd = '#1a1a24'; $theme_go = '#718096'; $theme_bg = '#f7fafc'; $top_title = '॥ ॐ शं शनैश्चराय नमः ॥';
    } elseif (strpos($title_lower, 'शिव') !== false || strpos($title_lower, 'shiv') !== false) {
        $theme_gd = '#1c2833'; $theme_go = '#5dade2'; $theme_bg = '#ebf5fb'; $top_title = '॥ ॐ नमः शिवाय ॥';
    } elseif (strpos($title_lower, 'दुर्गा') !== false || strpos($title_lower, 'durga') !== false) {
        $theme_gd = '#922b21'; $theme_go = '#f1c40f'; $theme_bg = '#fdf2e9'; $top_title = '॥ ॐ दुं दुर्गायै नमः ॥';
    } elseif (strpos($title_lower, 'हनुमान') !== false || strpos($title_lower, 'hanuman') !== false) {
        $theme_gd = '#5E1019'; $theme_go = '#F2A900'; $theme_bg = '#FFF8E9'; $top_title = '॥ श्री हनुमते नमः ॥';
    } elseif (strpos($title_lower, 'राम') !== false) {
        $theme_gd = '#ba4a00'; $theme_go = '#f39c12'; $theme_bg = '#fef5e7'; $top_title = '॥ श्री राम जय राम जय जय राम ॥';
    } elseif (strpos($title_lower, 'सरस्वती') !== false || strpos($title_lower, 'saraswati') !== false) {
        $theme_gd = '#9a7d0a'; $theme_go = '#f4d03f'; $theme_bg = '#fef9e7'; $top_title = '॥ ॐ ऐं सरस्वत्यै नमः ॥';
    } elseif (strpos($title_lower, 'गणेश') !== false || strpos($title_lower, 'ganesh') !== false) {
        $theme_gd = '#c0392b'; $theme_go = '#2ecc71'; $theme_bg = '#f9ebea'; $top_title = '॥ श्री गणेशाय नमः ॥';
    }
}
?>

<?php if ($theme_gd): ?>
<style>
    body {
        --gd: <?php echo $theme_gd; ?> !important;
        --go: <?php echo $theme_go; ?> !important;
        --iv: <?php echo $theme_bg; ?> !important;
        background: var(--iv) !important;
    }
    .pm-hero-premium {
        background: linear-gradient(135deg, var(--gd) 0%, #3a080f 100%);
        position: relative;
        overflow: hidden;
        margin-top: -32px;
        margin-bottom: 32px;
        color: #fff;
        border-bottom: 4px solid var(--go);
    }
    .pm-hero-premium::before {
        content: ''; position: absolute; top:0; left:0; right:0; bottom:0;
        background-image: radial-gradient(circle at 70% 50%, rgba(242,169,0,0.15) 0%, transparent 60%);
        pointer-events: none;
    }
    .pm-hero-inner {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        padding: 60px 0;
        position: relative;
        z-index: 1;
    }
    .pm-hero-text { flex: 1; min-width: 300px; padding-right: 40px; }
    .pm-hero-image { flex: 1; min-width: 300px; text-align: center; position: relative; }
    .pm-hero-image img {
        max-height: 400px; width: auto; object-fit: contain;
        filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
    }
    .pm-hero-image::after {
        content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
        width: 300px; height: 100px; background: radial-gradient(ellipse at center, rgba(242,169,0,0.3) 0%, transparent 70%);
        z-index: -1;
    }
    .pm-top-title {
        display: inline-block; border: 1px solid var(--go); color: var(--go);
        padding: 4px 12px; font-size: 14px; margin-bottom: 16px; border-radius: 4px;
    }
    .pm-hero-title {
        font-family: 'Tiro Devanagari Hindi', serif; font-size: 56px; font-weight: bold;
        margin-bottom: 12px; line-height: 1.1; text-shadow: 0 4px 10px rgba(0,0,0,0.5);
    }
    .pm-hero-subtitle { font-size: 18px; color: rgba(255,255,255,0.8); margin-bottom: 32px; }
    .pm-hero-actions { display: flex; gap: 16px; flex-wrap: wrap; }
    .pm-btn-primary {
        background: var(--go); color: #fff; padding: 12px 24px; border-radius: 8px; text-decoration: none;
        font-weight: bold; display: flex; align-items: center; gap: 8px; transition: all 0.3s;
        border: 1px solid var(--go); box-shadow: 0 4px 15px rgba(242,169,0,0.3);
    }
    .pm-btn-primary:hover { background: transparent; color: var(--go); transform: translateY(-2px); }
    .pm-btn-secondary {
        background: rgba(0,0,0,0.3); color: #fff; padding: 12px 24px; border-radius: 8px; text-decoration: none;
        font-weight: bold; display: flex; align-items: center; gap: 8px; transition: all 0.3s;
        border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(5px);
    }
    .pm-btn-secondary:hover { background: rgba(255,255,255,0.1); border-color: #fff; transform: translateY(-2px); }
    
    @media(max-width: 768px) {
        .pm-hero-inner { flex-direction: column-reverse; padding: 40px 0; text-align: center; }
        .pm-hero-text { padding-right: 0; margin-top: 30px; }
        .pm-hero-actions { justify-content: center; }
        .pm-hero-title { font-size: 40px; }
    }
</style>
<?php endif; ?>

<div class="pm-hero-premium">
    <div class="container pm-hero-inner">
        <div class="pm-hero-text">
            <nav class="pm-breadcrumb" style="margin-bottom:24px; font-size:14px; color:rgba(255,255,255,0.6);">
                <a href="<?php echo home_url('/'); ?>" style="color:#fff;text-decoration:none;">होम</a> › 
                <a href="<?php echo home_url('/index.php/chalisa-library'); ?>" style="color:#fff;text-decoration:none;"><?php echo $is_chalisa ? 'चालीसा' : 'ग्रंथ'; ?></a> › 
                <span style="color:var(--go);"><?php echo $title; ?></span>
            </nav>
            <div class="pm-top-title"><?php echo $top_title; ?></div>
            <h1 class="pm-hero-title"><?php echo $title; ?></h1>
            <div class="pm-hero-subtitle"><?php echo $meta2; ?> कृत • अर्थ सहित • भक्तों के लिए संपूर्ण पाठ</div>
            
            <div class="pm-hero-actions">
                <a href="#chalisa-content" class="pm-btn-primary">📖 चालीसा पढ़ें ↓</a>
                <a href="#audio-player" class="pm-btn-secondary">▶ ऑडियो सुनें</a>
            </div>
        </div>
        <div class="pm-hero-image">
            <?php if ($thumb): ?>
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>">
            <?php else: ?>
                <div style="font-size:120px; line-height:1; filter:drop-shadow(0 10px 20px rgba(0,0,0,0.5));">🕉️</div>
            <?php endif; ?>
        </div>
    </div>
</div>
