<?php
// Load WordPress environment
require_once 'C:\xampp\htdocs\prakashmarg\wp-load.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

echo "Starting data population...\n";

// Sideload Images
function sideload_image( $file_path, $desc = null ) {
    $tmp = wp_tempnam( $file_path );
    copy( $file_path, $tmp );
    $file_array = [
        'name' => basename( $file_path ),
        'tmp_name' => $tmp
    ];
    $id = media_handle_sideload( $file_array, 0, $desc );
    if ( is_wp_error( $id ) ) {
        @unlink( $tmp );
        return false;
    }
    return $id;
}

$temple_img_id = sideload_image( 'C:\Users\hp\.gemini\antigravity-ide\brain\755a660e-ff00-4541-9a61-7e10ea008d3f\temple_image_1788365806105.jpg', 'Kashi Vishwanath' );
$scripture_img_id = sideload_image( 'C:\Users\hp\.gemini\antigravity-ide\brain\755a660e-ff00-4541-9a61-7e10ea008d3f\scripture_image_1788365827140.jpg', 'Bhagavad Gita' );

echo "Images uploaded.\n";

// 1. Create Temple
$temple_id = wp_insert_post([
    'post_type' => 'pm_temple',
    'post_title' => 'Kashi Vishwanath Temple',
    'post_status' => 'publish',
    'post_name' => 'kashi-vishwanath'
]);

if ( $temple_id ) {
    update_post_meta( $temple_id, 'pm_native_name', 'काशी विश्वनाथ' );
    update_post_meta( $temple_id, 'pm_location', 'Varanasi, Uttar Pradesh, India' );
    update_post_meta( $temple_id, 'pm_deity', 'Lord Shiva' );
    if ( $temple_img_id ) set_post_thumbnail( $temple_id, $temple_img_id );
    echo "Temple created ID: $temple_id\n";
}

// 2. Create Scripture
$scripture_id = wp_insert_post([
    'post_type' => 'pm_scripture',
    'post_title' => 'Bhagavad Gita',
    'post_status' => 'publish',
    'post_name' => 'bhagavad-gita'
]);

if ( $scripture_id ) {
    update_post_meta( $scripture_id, 'pm_native_name', 'श्रीमद्भगवद्गीता' );
    update_post_meta( $scripture_id, 'pm_author_sage', 'Ved Vyasa' );
    update_post_meta( $scripture_id, 'pm_language', 'Sanskrit' );
    update_post_meta( $scripture_id, 'pm_total_verses', '700' );
    update_post_meta( $scripture_id, 'pm_philosophy', 'Vedanta, Yoga' );
    if ( $scripture_img_id ) set_post_thumbnail( $scripture_id, $scripture_img_id );
    echo "Scripture created ID: $scripture_id\n";
}

// 3. Create Deity
$deity_id = wp_insert_post([
    'post_type' => 'pm_deity',
    'post_title' => 'Lord Shiva',
    'post_status' => 'publish',
    'post_name' => 'lord-shiva'
]);

if ( $deity_id ) {
    update_post_meta( $deity_id, 'pm_native_name', 'भगवान शिव' );
    update_post_meta( $deity_id, 'pm_avatar_of', 'Supreme' );
    update_post_meta( $deity_id, 'pm_core_mantra', 'Om Namah Shivaya' );
    update_post_meta( $deity_id, 'pm_associated_elements', 'Trident, Crescent Moon, Snake' );
    if ( $temple_img_id ) set_post_thumbnail( $deity_id, $temple_img_id );
    echo "Deity created ID: $deity_id\n";
}

// 4. Create Saint
$saint_id = wp_insert_post([
    'post_type' => 'pm_saint',
    'post_title' => 'Adi Shankaracharya',
    'post_status' => 'publish',
    'post_name' => 'adi-shankaracharya'
]);

if ( $saint_id ) {
    update_post_meta( $saint_id, 'pm_native_name', 'आदि शंकराचार्य' );
    update_post_meta( $saint_id, 'pm_tradition', 'Advaita Vedanta' );
    update_post_meta( $saint_id, 'pm_lifespan', '788 CE – 820 CE' );
    update_post_meta( $saint_id, 'pm_key_teachings', 'Non-dualism, Unity of Atman and Brahman' );
    if ( $scripture_img_id ) set_post_thumbnail( $saint_id, $scripture_img_id );
    echo "Saint created ID: $saint_id\n";
}

// 5. Create Festival
$festival_id = wp_insert_post([
    'post_type' => 'pm_festival',
    'post_title' => 'Maha Shivaratri',
    'post_status' => 'publish',
    'post_name' => 'maha-shivaratri'
]);

if ( $festival_id ) {
    update_post_meta( $festival_id, 'pm_native_name', 'महाशिवरात्रि' );
    update_post_meta( $festival_id, 'pm_month_observed', 'Phalguna' );
    update_post_meta( $festival_id, 'pm_significance', 'Night of Lord Shiva\'s marriage to Parvati' );
    update_post_meta( $festival_id, 'pm_primary_rituals', 'Fasting, all-night vigil, offering Bael leaves' );
    if ( $temple_img_id ) set_post_thumbnail( $festival_id, $temple_img_id );
    echo "Festival created ID: $festival_id\n";
}

// Link them up (Relationships)
if ($temple_id && $deity_id) add_post_meta($temple_id, 'pm_main_deity', $deity_id);
if ($temple_id && $festival_id) add_post_meta($temple_id, 'pm_major_festival', $festival_id);
if ($deity_id && $temple_id) add_post_meta($deity_id, 'pm_associated_temple', $temple_id);
if ($festival_id && $deity_id) add_post_meta($festival_id, 'pm_dedicated_to', $deity_id);

// Flush Rules
flush_rewrite_rules();
echo "Rewrite rules flushed.\nDone!\n";
