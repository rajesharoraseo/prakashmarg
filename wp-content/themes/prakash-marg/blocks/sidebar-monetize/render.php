<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$title = get_the_title();
$title_lower = mb_strtolower($title, 'UTF-8');

if (strpos($title_lower, 'हनुमान') !== false || strpos($title_lower, 'hanuman') !== false) {
    $store_product = ['title' => 'हनुमान चालीसा (पुस्तक)', 'desc' => 'सुंदर हिन्दी अर्थ सहित', 'price' => '₹149', 'old_price' => '₹199', 'img' => '📕'];
} elseif (strpos($title_lower, 'शिव') !== false || strpos($title_lower, 'shiv') !== false) {
    $store_product = ['title' => 'शिव चालीसा (पुस्तक)', 'desc' => 'सुंदर हिन्दी अर्थ सहित', 'price' => '₹129', 'old_price' => '₹159', 'img' => '📘'];
} else {
    $store_product = ['title' => 'पवित्र चालीसा संग्रह', 'desc' => 'सभी देवी-देवताओं की चालीसा', 'price' => '₹299', 'old_price' => '₹399', 'img' => '📙'];
}
?>

<div class="pm-sidebar-monetize" style="display:flex; flex-direction:column; gap:24px;">

    <!-- 1. On Page Nav -->
    <div style="background:#fff; border:1px solid var(--bdl); border-radius:12px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
        <h3 style="font-size:16px; color:var(--gd); margin-bottom:16px; font-weight:bold;">इस पृष्ठ पर</h3>
        <ul style="list-style:none; padding:0; margin:0; font-size:14px; color:var(--txm); line-height:2.2;">
            <li><a href="#chalisa-content" style="color:var(--txm); text-decoration:none;"><span style="color:var(--go);margin-right:8px;">▹</span> <?php echo $title; ?> (संपूर्ण पाठ)</a></li>
            <li><a href="#chalisa-meaning" style="color:var(--txm); text-decoration:none;"><span style="color:var(--go);margin-right:8px;">▹</span> चालीसा का अर्थ और महत्व</a></li>
            <li><a href="#chalisa-audio" style="color:var(--txm); text-decoration:none;"><span style="color:var(--go);margin-right:8px;">▹</span> पाठ करने की विधि</a></li>
            <li><a href="#related-content" style="color:var(--txm); text-decoration:none;"><span style="color:var(--go);margin-right:8px;">▹</span> संबंधित भक्ति सामग्री</a></li>
            <li><a href="#store-products" style="color:var(--txm); text-decoration:none;"><span style="color:var(--go);margin-right:8px;">▹</span> अनुशंसित पुस्तकें</a></li>
            <li><a href="#faq" style="color:var(--txm); text-decoration:none;"><span style="color:var(--go);margin-right:8px;">▹</span> अक्सर पूछे जाने वाले प्रश्न (FAQ)</a></li>
        </ul>
    </div>

    <!-- 2. Store Widget -->
    <div style="background:#fff; border:1px solid var(--bdl); border-radius:12px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
        <div style="background:var(--go); padding:10px 15px; display:flex; justify-content:space-between; align-items:center;">
            <span style="color:#fff; font-size:12px; font-weight:bold;">🌟 प्रकाश मार्ग स्टोर</span>
            <span style="background:var(--gd); color:#fff; font-size:10px; padding:2px 6px; border-radius:4px;">लोकप्रिय</span>
        </div>
        <div style="padding:20px; display:flex; gap:16px; align-items:center;">
            <div style="font-size:60px; line-height:1; filter:drop-shadow(0 4px 6px rgba(0,0,0,0.2));"><?php echo $store_product['img']; ?></div>
            <div>
                <h4 style="font-size:15px; font-weight:bold; color:var(--gd); margin:0 0 4px 0; line-height:1.3;"><?php echo $store_product['title']; ?></h4>
                <div style="font-size:12px; color:var(--txm); margin-bottom:8px;"><?php echo $store_product['desc']; ?></div>
                <div style="font-size:18px; font-weight:bold; color:var(--gd); margin-bottom:12px;">
                    <?php echo $store_product['price']; ?> <span style="font-size:12px; color:#999; text-decoration:line-through; font-weight:normal;"><?php echo $store_product['old_price']; ?></span>
                </div>
                <a href="#" style="display:inline-block; background:var(--gd); color:#fff; font-size:12px; font-weight:bold; padding:8px 16px; border-radius:4px; text-decoration:none; transition:background 0.3s;" onmouseover="this.style.background='var(--go)';" onmouseout="this.style.background='var(--gd)';">अभी खरीदें →</a>
            </div>
        </div>
    </div>

    <!-- 3. Related Spiritual Content -->
    <div style="background:#fff; border:1px solid var(--bdl); border-radius:12px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="font-size:16px; color:var(--gd); margin:0; font-weight:bold;">संबंधित भक्ति सामग्री</h3>
            <a href="#" style="font-size:12px; color:var(--go); text-decoration:none; font-weight:bold;">सभी देखें →</a>
        </div>
        <div style="display:flex; flex-direction:column; gap:16px;">
            <a href="#" style="display:flex; gap:12px; align-items:center; text-decoration:none; color:inherit; border-bottom:1px solid var(--iv); padding-bottom:12px;">
                <div style="width:50px; height:50px; background:#f9ebea; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:24px;">🛕</div>
                <div style="flex:1;">
                    <h4 style="font-size:14px; margin:0 0 2px 0; color:var(--tx); font-weight:bold;">हनुमान जी की आरती</h4>
                    <div style="font-size:11px; color:var(--txm);">आरती के बोल और अर्थ</div>
                </div>
                <div style="color:var(--go);">›</div>
            </a>
            <a href="#" style="display:flex; gap:12px; align-items:center; text-decoration:none; color:inherit; border-bottom:1px solid var(--iv); padding-bottom:12px;">
                <div style="width:50px; height:50px; background:#f9ebea; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:24px;">🛡️</div>
                <div style="flex:1;">
                    <h4 style="font-size:14px; margin:0 0 2px 0; color:var(--tx); font-weight:bold;">बजरंग बाण</h4>
                    <div style="font-size:11px; color:var(--txm);">संकट निवारण हेतु शक्तिशाली पाठ</div>
                </div>
                <div style="color:var(--go);">›</div>
            </a>
            <a href="#" style="display:flex; gap:12px; align-items:center; text-decoration:none; color:inherit;">
                <div style="width:50px; height:50px; background:#fef5e7; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:24px;">🏹</div>
                <div style="flex:1;">
                    <h4 style="font-size:14px; margin:0 0 2px 0; color:var(--tx); font-weight:bold;">श्री राम स्तुति</h4>
                    <div style="font-size:11px; color:var(--txm);">श्री रामचंद्र कृपालु भजु मन</div>
                </div>
                <div style="color:var(--go);">›</div>
            </a>
        </div>
    </div>

    <!-- 4. Ad Space -->
    <div style="background:var(--iv); border:1px dashed var(--bdl); border-radius:12px; padding:10px; text-align:center;">
        <div style="color:var(--txm); font-size:10px; margin-bottom:8px;">विज्ञापन</div>
        <div style="width:100%; height:250px; background:rgba(0,0,0,0.03); display:flex; align-items:center; justify-content:center; color:var(--txm); font-size:14px; border-radius:8px;">
            Ad Space<br>(300 × 250)
        </div>
    </div>

</div>
