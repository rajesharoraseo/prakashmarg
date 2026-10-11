<?php
// Fetch the rendered homepage HTML
$html = file_get_contents('http://localhost/prakashmarg/');

// 1. Check for elements with explicit width/min-width larger than mobile
echo "=== CHECKING FOR PROBLEMATIC INLINE WIDTHS ===\n";
preg_match_all('/style="[^"]*(?:min-width|width)\s*:\s*(\d+)px[^"]*"/', $html, $matches, PREG_SET_ORDER);
foreach ($matches as $m) {
    $val = intval($m[1]);
    if ($val > 300) {
        echo "POTENTIAL ISSUE: $val px -> " . substr($m[0], 0, 120) . "\n";
    }
}

// 2. Check header structure 
echo "\n=== HEADER STRUCTURE ===\n";
if (preg_match('/<header[^>]*pm-global-header[^>]*>.*?<\/header>/is', $html, $hm)) {
    $headerHtml = $hm[0];
    echo "Header length: " . strlen($headerHtml) . " chars\n";
    // Check for the navigation button
    if (preg_match('/<button[^>]*aria-haspopup="dialog"[^>]*>/', $headerHtml, $btn)) {
        echo "Nav button found: " . substr($btn[0], 0, 200) . "\n";
    }
    // Check padding
    if (preg_match('/padding:\s*([^;"]+)/', $headerHtml, $pad)) {
        echo "Header padding: " . $pad[1] . "\n";
    }
}

// 3. Check for WP Block navigation overlay
echo "\n=== NAVIGATION OVERLAY ===\n";
if (preg_match('/wp-block-navigation__responsive-container[^"]*"/', $html, $nm)) {
    echo "Nav overlay class: " . $nm[0] . "\n";
}

// 4. Check scrollWidth diagnostic - look at body/page wrappers
echo "\n=== BODY CLASS ===\n";
if (preg_match('/<body[^>]*class="([^"]*)"/', $html, $bc)) {
    echo "Body class: " . $bc[1] . "\n";
}

// 5. Check for WP root padding aware alignments
echo "\n=== ROOT PADDING ===\n";
if (strpos($html, 'padding-right') !== false) {
    echo "Found padding-right in HTML\n";
}
if (strpos($html, 'has-global-padding') !== false) {
    echo "Found has-global-padding class\n";
}

// 6. Check WordPress generated inline styles for potential overflow
echo "\n=== WP INLINE STYLES ANALYSIS ===\n";
if (preg_match('/\.wp-site-blocks\s*\{[^}]*\}/s', $html, $sb)) {
    echo "wp-site-blocks style: " . $sb[0] . "\n";
}

echo "\n=== GLOBAL STYLES - BODY RULES ===\n";
if (preg_match('/body\s*\{[^}]+\}/s', $html, $bodyRule)) {
    echo substr($bodyRule[0], 0, 500) . "\n";
}

// 7. Count elements with position: absolute or fixed
echo "\n=== POSITION ABSOLUTE/FIXED COUNT ===\n";
$absCount = substr_count($html, 'position: absolute');
$fixCount = substr_count($html, 'position: fixed');
$stickyCount = substr_count($html, 'position: sticky');
echo "absolute: $absCount, fixed: $fixCount, sticky: $stickyCount\n";

echo "\nDONE.\n";
