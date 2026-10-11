<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$count       = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 8;
$cat_exclude = isset( $attributes['excludeCategory'] ) ? $attributes['excludeCategory'] : '';

$query = new WP_Query( [
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => $count,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
] );

if ( ! $query->have_posts() ) {
    ?>
    <div class="pm-no-posts" style="text-align:center;padding:40px;color:var(--txs)">
        <p>अभी कोई लेख उपलब्ध नहीं है। जल्द ही नया लेख आएगा।</p>
    </div>
    <?php
    wp_reset_postdata();
    return;
}

$posts = $query->posts;
wp_reset_postdata();

/* ── Helpers ─────────────────────────────────────────── */

function pm_get_thumb( $post_id, $size = 'large', $fallback_url = '' ) {
    if ( has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail_url( $post_id, $size );
    }
    // Try to pull first image from content as fallback
    $post    = get_post( $post_id );
    $content = $post ? $post->post_content : '';
    preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/', $content, $matches );
    if ( ! empty( $matches[1] ) ) return esc_url( $matches[1] );
    // Ultimate fallback — a spiritual placeholder from Unsplash
    $defaults = [
        'https://images.unsplash.com/photo-1609710228159-0fa9bd7c0827?w=800&q=80',
        'https://images.unsplash.com/photo-1563788688-bc04ef2a80af?w=400&q=80',
        'https://images.unsplash.com/photo-1604537466608-109fa2f16c3b?w=400&q=80',
        'https://images.unsplash.com/photo-1531761535209-180857e963b9?w=400&q=80',
    ];
    return $fallback_url ?: $defaults[ $post_id % count( $defaults ) ];
}

function pm_read_time( $post_id ) {
    $content    = get_post_field( 'post_content', $post_id );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    $mins       = max( 1, (int) ceil( $word_count / 200 ) );
    return $mins . ' मिनट';
}

function pm_cat_label( $post_id ) {
    $cats = get_the_category( $post_id );
    if ( empty( $cats ) ) return '📝 सामान्य';
    $emojis = [ 'भजन' => '🎵', 'चालीसा' => '📖', 'पूजा' => '🪔', 'मंत्र' => '🕉️',
                'त्योहार' => '🗓️', 'ध्यान' => '🧘', 'तीर्थ' => '🛕', 'ज्ञान' => '💡',
                'भक्ति' => '🙏', 'आरती' => '🪔', 'व्रत' => '🌙', 'सुविचार' => '💬' ];
    $name  = $cats[0]->name;
    foreach ( $emojis as $keyword => $emoji ) {
        if ( mb_strpos( $name, $keyword ) !== false ) return $emoji . ' ' . $name;
    }
    return '📝 ' . $name;
}

$featured   = $posts[0];
$sidebar    = array_slice( $posts, 1, 3 );
$grid_posts = array_slice( $posts, 4, 4 );
if ( empty( $grid_posts ) ) $grid_posts = array_slice( $posts, 1, 4 );
?>

<section class="section alt pm-latest-articles">
  <div class="container">

    <div class="flex-between section-head">
      <div>
        <span class="section-eyebrow">📰 ताज़ा लेख</span>
        <h2 class="section-title">लेटेस्ट पोस्ट</h2>
        <div class="section-sep"></div>
      </div>
      <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog' ); ?>" class="see-all">सभी लेख →</a>
    </div>

    <?php /* ── Featured + Sidebar grid ── */ ?>
    <div class="grid-magazine" style="margin-bottom:20px">
      <a href="<?php echo get_permalink( $featured->ID ); ?>" class="post-feature" style="min-height:380px">
        <img
          src="<?php echo esc_url( pm_get_thumb( $featured->ID, 'large' ) ); ?>"
          alt="<?php echo esc_attr( $featured->post_title ); ?>"
          loading="lazy">
        <div class="post-feature-overlay"></div>
        <div class="post-feature-content">
          <span style="font-size:13px;font-weight:700;text-transform:uppercase;color:var(--gol);letter-spacing:.06em;display:block;margin-bottom:6px">
            <?php echo esc_html( pm_cat_label( $featured->ID ) ); ?>
          </span>
          <h3 style="font-family:'Tiro Devanagari Hindi',serif;font-size:22px;font-weight:700;color:#fff;line-height:1.35;margin-bottom:8px">
            <?php echo esc_html( $featured->post_title ); ?>
          </h3>
          <p style="font-size:13px;color:rgba(255,255,255,.65)">
            📅 <?php echo get_the_date( 'j F Y', $featured->ID ); ?>
            &nbsp;•&nbsp;
            <?php echo esc_html( pm_read_time( $featured->ID ) ); ?> पढ़ने में
          </p>
        </div>
      </a>

      <div style="display:flex;flex-direction:column;gap:14px">
        <?php foreach ( $sidebar as $sp ) : ?>
        <a href="<?php echo get_permalink( $sp->ID ); ?>" class="post-card" style="display:flex;border-radius:12px">
          <div style="flex-shrink:0;width:100px;overflow:hidden;border-radius:12px 0 0 12px">
            <img
              src="<?php echo esc_url( pm_get_thumb( $sp->ID, 'thumbnail' ) ); ?>"
              alt="<?php echo esc_attr( $sp->post_title ); ?>"
              style="width:100%;height:90px;object-fit:cover"
              loading="lazy">
          </div>
          <div class="post-card-body" style="flex:1">
            <span class="post-cat"><?php echo esc_html( pm_cat_label( $sp->ID ) ); ?></span>
            <p class="post-title"><?php echo esc_html( $sp->post_title ); ?></p>
            <span class="post-meta"><?php echo esc_html( pm_read_time( $sp->ID ) ); ?></span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>

    <?php /* ── 4-column grid ── */ ?>
    <?php if ( ! empty( $grid_posts ) ) : ?>
    <div class="grid-4">
      <?php foreach ( $grid_posts as $gp ) : ?>
      <a href="<?php echo get_permalink( $gp->ID ); ?>" class="post-card">
        <div class="post-card-img-wrap">
          <img
            src="<?php echo esc_url( pm_get_thumb( $gp->ID, 'medium' ) ); ?>"
            class="post-card-img"
            alt="<?php echo esc_attr( $gp->post_title ); ?>"
            loading="lazy">
        </div>
        <div class="post-card-body">
          <span class="post-cat"><?php echo esc_html( pm_cat_label( $gp->ID ) ); ?></span>
          <p class="post-title"><?php echo esc_html( $gp->post_title ); ?></p>
          <span class="post-meta">📅 <?php echo get_the_date( 'j M', $gp->ID ); ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

  </div>
</section>
