<?php
/**
 * Render for pm/ad-slot block.
 */

$ad_type = $attributes['adType'] ?? 'client';
$client_img = $attributes['clientImageUrl'] ?? '';
$client_url = $attributes['clientTargetUrl'] ?? '#';
$adsense_code = $attributes['adsenseCode'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-ad-slot my-8 text-center']);

echo '<div ' . $wrapper_attributes . '>';

if ($ad_type === 'client' && !empty($client_img)) {
    // Render Direct Client Ad (e.g. Astrologer Banner)
    echo '<span class="block text-xs text-gray-400 uppercase tracking-widest mb-2 text-center">Advertisement</span>';
    echo '<a href="' . esc_url($client_url) . '" target="_blank" rel="noopener sponsored" class="inline-block transition-transform duration-300 hover:scale-[1.02] shadow-sm hover:shadow-xl rounded-xl overflow-hidden">';
    echo '<img src="' . esc_url($client_img) . '" alt="Sponsored Advertisement" class="w-full max-w-4xl h-auto" loading="lazy">';
    echo '</a>';
} elseif ($ad_type === 'adsense' && !empty($adsense_code)) {
    // Render Google AdSense
    echo '<span class="block text-xs text-gray-400 uppercase tracking-widest mb-2 text-center">Advertisement</span>';
    echo '<div class="pm-adsense-wrapper overflow-hidden flex justify-center">';
    // NOTE: In WP editor we might want to hide the script or just show a placeholder
    if (is_admin()) {
        echo '<div class="bg-gray-100 border border-dashed border-gray-300 p-8 text-gray-500 rounded-xl">Google AdSense Slot (Placeholder in Editor)</div>';
    } else {
        echo $adsense_code; // Raw output of JS script for Adsense
    }
    echo '</div>';
} else {
    // Empty ad slot — show prompt only in admin, invisible on frontend
    if (is_admin()) {
        echo '<div class="bg-amber-50 border border-amber-200 p-8 text-amber-700 rounded-xl text-center font-medium">Ad Slot Block — Please configure Ad settings in the block sidebar.</div>';
    }
    // On frontend: render nothing (no broken placeholder)
}

echo '</div>';
