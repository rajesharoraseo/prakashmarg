<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Get the search query if passed via URL ?s=
$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
?>
<div class="pm-advanced-search-wrapper" style="background:var(--iv); padding:60px 20px; min-height:60vh;">
    <div class="container" style="max-width:800px; margin:0 auto;">
        
        <div style="text-align:center; margin-bottom:40px;">
            <h1 style="font-family:'Tiro Devanagari Hindi',serif; font-size:36px; color:var(--gd); margin-bottom:12px;">खोजें (Search)</h1>
            <p style="color:var(--txm); font-size:16px;">मन्दिर, ग्रंथ, देवता, और त्योहारों को खोजें।</p>
        </div>

        <div style="position:relative; margin-bottom:40px;">
            <input type="text" id="pm-adv-search-input" value="<?php echo esc_attr($search_query); ?>" placeholder="क्या खोज रहे हैं?..." style="width:100%; padding:18px 24px; padding-left:56px; font-size:18px; border:2px solid var(--bdl); border-radius:30px; background:#fff; color:var(--tx); outline:none; transition:border-color 0.2s;" autocomplete="off">
            <div style="position:absolute; left:20px; top:50%; transform:translateY(-50%); font-size:20px; color:var(--gm);">🔍</div>
        </div>

        <div id="pm-adv-search-results" style="display:grid; grid-template-columns:1fr; gap:16px;">
            <!-- Results will be injected here via JS -->
        </div>
        
        <div id="pm-adv-search-loading" style="display:none; text-align:center; padding:40px; color:var(--go); font-size:18px;">
            खोज रहा है... ⏳
        </div>

        <div id="pm-adv-search-empty" style="display:none; text-align:center; padding:40px; background:#fff; border:1px solid var(--bdl); border-radius:12px;">
            <div style="font-size:40px; margin-bottom:12px;">🤷‍♂️</div>
            <h3 style="font-size:20px; color:var(--gd); margin-bottom:8px;">कोई परिणाम नहीं मिला</h3>
            <p style="color:var(--txm);">कृपया कुछ और खोज कर देखें।</p>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var inp = document.getElementById('pm-adv-search-input');
    var resDiv = document.getElementById('pm-adv-search-results');
    var loadingDiv = document.getElementById('pm-adv-search-loading');
    var emptyDiv = document.getElementById('pm-adv-search-empty');
    var debounceTimer;
    
    function doSearch(q) {
        if(q.length < 2) {
            resDiv.innerHTML = '';
            emptyDiv.style.display = 'none';
            loadingDiv.style.display = 'none';
            return;
        }
        
        resDiv.innerHTML = '';
        emptyDiv.style.display = 'none';
        loadingDiv.style.display = 'block';
        
        var baseUrl = (typeof PM_HOME !== 'undefined') ? PM_HOME : '';
        fetch(baseUrl + '/wp-json/pm/v1/search?q=' + encodeURIComponent(q))
            .then(r => r.json())
            .then(data => {
                loadingDiv.style.display = 'none';
                
                if (!data || data.length === 0) {
                    emptyDiv.style.display = 'block';
                    return;
                }
                
                var html = '';
                data.forEach(function(item) {
                    html += '<a href="' + item.url + '" style="display:flex; align-items:center; background:#fff; padding:16px; border:1px solid var(--bdl); border-radius:12px; text-decoration:none; transition:all 0.2s; box-shadow:0 2px 4px rgba(0,0,0,0.02);" onmouseover="this.style.borderColor=\'var(--go)\';this.style.transform=\'translateY(-2px)\';" onmouseout="this.style.borderColor=\'var(--bdl)\';this.style.transform=\'none\';">';
                    html += '<div style="width:48px; height:48px; background:var(--sg); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:24px; margin-right:16px; flex-shrink:0;">' + item.icon + '</div>';
                    html += '<div>';
                    html += '<div style="font-size:18px; font-weight:700; color:var(--tx); margin-bottom:4px;">' + item.title + '</div>';
                    html += '<div style="font-size:13px; color:var(--txm); text-transform:uppercase; letter-spacing:0.05em;">' + item.type + '</div>';
                    html += '</div></a>';
                });
                resDiv.innerHTML = html;
            })
            .catch(err => {
                loadingDiv.style.display = 'none';
                emptyDiv.style.display = 'block';
            });
    }

    inp.addEventListener('input', function(e) {
        clearTimeout(debounceTimer);
        var q = e.target.value.trim();
        debounceTimer = setTimeout(function() { doSearch(q); }, 400);
    });

    // Auto trigger if there's a prefilled value (from ?s=...)
    if (inp.value.trim().length >= 2) {
        doSearch(inp.value.trim());
    }
});
</script>
