<?php
$html = file_get_contents('http://localhost/prakashmarg/');

// Check for primary-saffron variable in inline styles
if (preg_match('/global-styles-inline-css.*?<\/style>/is', $html, $match)) {
    echo "=== GLOBAL STYLES INLINE CSS ===\n";
    echo substr($match[0], 0, 3000);
} else {
    echo "GLOBAL STYLES INLINE CSS: NOT FOUND\n";
}

echo "\n\n=== CHECKING PRESET VARIABLES ===\n";
$vars = ['primary-saffron', 'deep-saffron', 'surface', 'cream', 'text-primary', 'border', 'focus'];
foreach ($vars as $v) {
    $search = '--wp--preset--color--' . $v;
    if (strpos($html, $search) !== false) {
        echo "FOUND: $search\n";
    } else {
        echo "MISSING: $search\n";
    }
}

echo "\n\n=== CHECKING BODY DOCUMENT WIDTH ===\n";
// Check for width-constraining issues
if (preg_match('/padding:\s*1\.5rem\s*2rem/', $html)) {
    echo "Found header with padding: 1.5rem 2rem\n";
}

// Check for viewport meta
if (preg_match('/<meta[^>]*viewport[^>]*>/i', $html, $m)) {
    echo "Viewport: " . $m[0] . "\n";
}

// Count total HTML size
echo "Total HTML size: " . strlen($html) . " bytes\n";
