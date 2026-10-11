<?php
$html = file_get_contents('http://localhost/prakashmarg/');

echo "=== INLINE WIDTHS > 300px ===\n";
preg_match_all('/style="[^"]*(?:min-width|width)\s*:\s*(\d+)px[^"]*"/i', $html, $matches, PREG_SET_ORDER);
foreach ($matches as $m) {
    $val = intval($m[1]);
    if ($val > 300) {
        echo "POTENTIAL ISSUE: {$val}px => " . substr($m[0], 0, 150) . "\n";
    }
}

echo "\n=== HEADER HTML (first 500 chars) ===\n";
if (preg_match('/<header[^>]*pm-global-header[^>]*>/i', $html, $hm)) {
    $pos = strpos($html, $hm[0]);
    echo substr($html, $pos, 500) . "\n";
}

echo "\n=== NAV BLOCK RESPONSIVE CONTAINER ===\n";
if (preg_match_all('/wp-block-navigation__responsive-container\b[^"]*/', $html, $nm)) {
    foreach ($nm[0] as $n) {
        echo $n . "\n";
    }
}

echo "\n=== CHECKING FOR .has-global-padding ===\n";
preg_match_all('/has-global-padding/', $html, $gp);
echo "Count: " . count($gp[0]) . "\n";

echo "\n=== WP NAVIGATION INLINE STYLES ===\n";
if (preg_match('/\.wp-block-navigation\s*\.wp-block-navigation__responsive-container[^{]*\{[^}]*\}/s', $html, $navStyle)) {
    echo substr($navStyle[0], 0, 500) . "\n";
}
