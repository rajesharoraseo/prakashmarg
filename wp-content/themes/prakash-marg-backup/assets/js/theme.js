/**
 * Prakash Marg — Main Theme JS
 * Handles: Panchang widget, Festival countdown, Quote rotator,
 *          Rashifal display, Bhajan filter, Lucky number calculator,
 *          Search overlay, Mobile menu toggle, Dark mode, Back-to-top.
 */
(function () {
    'use strict';

    /* ── Data ─────────────────────────────────────────────── */

    var FESTIVALS = [
        { name: 'शारदीय नवरात्रि', emoji: '🪔', date: new Date(2026, 9, 2) },
        { name: 'दशहरा',            emoji: '⚔️', date: new Date(2026, 9, 11) },
        { name: 'दीपावली',          emoji: '🪔', date: new Date(2026, 9, 31) },
        { name: 'छठ पूजा',          emoji: '🌅', date: new Date(2026, 10, 4) },
        { name: 'गुरु नानक जयंती',  emoji: '🙏', date: new Date(2026, 10, 15) },
        { name: 'मकर संक्रांति',    emoji: '🌞', date: new Date(2027, 0, 14) },
        { name: 'महाशिवरात्रि',     emoji: '🕉️', date: new Date(2027, 1, 26) },
        { name: 'होली',             emoji: '🎨', date: new Date(2027, 2, 5) },
        { name: 'रामनवमी',          emoji: '🙏', date: new Date(2027, 3, 6) },
    ];

    var QUOTES = [
        { text: '"कर्म करो, फल की चिंता मत करो।"',             author: '— भगवद्गीता' },
        { text: '"मन के जीते जीत है, मन के हारे हार।"',        author: '— कबीर दास' },
        { text: '"सत्यमेव जयते।"',                              author: '— मुण्डक उपनिषद' },
        { text: '"ढाई आखर प्रेम का, पढ़े सो पण्डित होय।"',    author: '— कबीर दास' },
        { text: '"विद्या विनयेन शोभते।"',                       author: '— चाणक्य' },
        { text: '"अपना दीपक स्वयं बनो।"',                      author: '— गौतम बुद्ध' },
        { text: '"सेवा परमो धर्मः।"',                           author: '— महाभारत' },
        { text: '"जो हुआ, अच्छा हुआ। जो हो रहा है, अच्छा हो रहा है।"', author: '— भगवद्गीता' },
    ];

    var RASHIFAL = {
        Mesh:   'आज का दिन शुभ रहेगा। नए कार्यों की शुरुआत के लिए उत्तम समय है। परिवार में सुख-शांति बनी रहेगी।',
        Vrish:  'आर्थिक दृष्टि से आज का दिन अच्छा है। व्यापार में लाभ की संभावना है।',
        Mithun: 'संचार और यात्रा के लिए शुभ दिन। नए संपर्क बनेंगे।',
        Kark:   'भावनात्मक दृष्टि से संवेदनशील दिन। परिवार के साथ समय बिताएं।',
        Singh:  'नेतृत्व के अवसर मिलेंगे। आपका व्यक्तित्व प्रभावशाली रहेगा।',
        Kanya:  'व्यावहारिकता और अनुशासन आज काम आएगा।',
        Tula:   'रिश्तों में सामंजस्य बनाए रखें। सहयोग से काम बनेगा।',
        Vrischik:'रहस्यमय विषयों में रुचि बढ़ेगी। अंतर्ज्ञान पर भरोसा करें।',
        Dhan:   'ज्ञान और विस्तार के अवसर मिलेंगे। आशावाद बनाए रखें।',
        Makar:  'कड़ी मेहनत का फल आज मिलेगा। धैर्य रखें।',
        Kumbh:  'नवाचार और सामाजिक कार्य के लिए शुभ दिन।',
        Meen:   'आध्यात्मिक ऊर्जा प्रबल रहेगी। ध्यान और भक्ति में लगाएं।',
    };

    var LUCKY_DESC = {
        1: 'आप एक नेता हैं। स्वतंत्र विचार और आत्मविश्वास आपकी पहचान है।',
        2: 'सहयोग और शांति की अद्भुत क्षमता है। संबंध मजबूत करें।',
        3: 'रचनात्मकता आपकी सबसे बड़ी शक्ति है। कला में उभरें।',
        4: 'व्यावहारिक और मेहनती हैं। स्थिरता आपकी ताकत है।',
        5: 'स्वतंत्रता और परिवर्तन आपको प्रिय है। साहसी बनें।',
        6: 'प्रेम और जिम्मेदारी आपके मूल गुण हैं। परिवार को प्राथमिकता दें।',
        7: 'आप आध्यात्मिक जिज्ञासु हैं। आत्म-ज्ञान की राह पर चलें।',
        8: 'शक्ति और सफलता आपके साथी हैं। बड़े लक्ष्य तय करें।',
        9: 'परोपकार और करुणा आपके प्राण हैं। सेवा में खुशी पाएं।',
    };

    /* ── Helpers ──────────────────────────────────────────── */

    function setEl(id, val) {
        var e = document.getElementById(id);
        if (e) e.textContent = val;
    }

    /* ── Panchang ─────────────────────────────────────────── */

    var panchangLat = 28.6139, panchangLon = 77.2090;

    function loadPanchang(lat, lon) {
        var baseUrl = (typeof PM_HOME !== 'undefined') ? PM_HOME : '';
        fetch(baseUrl + '/wp-json/pm/v1/tools/panchang?lat=' + lat + '&lon=' + lon)
            .then(res => res.json())
            .then(p => {
                var today = new Date();
                var hd = today.toLocaleDateString('hi-IN', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                setEl('hero-panchang-date', hd);
                setEl('hero-samvat',        'विक्रम संवत: ' + (p.vikramSamvat || '2083'));
                setEl('hero-masa',          'मास: ' + (p.masa || '—'));
                setEl('hero-paksha',        p.paksha    || '—');
                setEl('hero-tithi',         p.tithi     || '—');
                setEl('hero-nakshatra',     p.nakshatra || '—');
                setEl('hero-yoga',          p.yoga      || '—');
                setEl('hero-karana',        p.karana    || '—');
                setEl('hero-sunrise',       p.sunrise   || '—');
                setEl('hero-rahu',          (p.rahukaal && p.rahukaal.start ? p.rahukaal.start : '—') + '–' + (p.rahukaal && p.rahukaal.end ? p.rahukaal.end : '—'));
                setEl('hero-abhijit',       (p.abhijitMuhurta && p.abhijitMuhurta.start ? p.abhijitMuhurta.start : '—') + '–' + (p.abhijitMuhurta && p.abhijitMuhurta.end ? p.abhijitMuhurta.end : '—'));
                setEl('tp-vara',            'वार: ' + (p.vara || '—'));
                setEl('tp-tithi',           (p.tithi || '—') + ' (' + (p.paksha || '—') + ')');
                setEl('tp-nakshatra',       p.nakshatra || '—');
                setEl('tp-sunrise',         p.sunrise   || '—');
                setEl('tp-rahu',            (p.rahukaal && p.rahukaal.start ? p.rahukaal.start : '—') + ' – ' + (p.rahukaal && p.rahukaal.end ? p.rahukaal.end : '—'));
                
                // Update ticker elements with duplicate classes
                document.querySelectorAll('.t-tithi-dup').forEach(el => el.textContent = (p.tithi || '—') + ' (' + (p.paksha || '—') + ')');
                setEl('t-tithi', (p.tithi || '—') + ' (' + (p.paksha || '—') + ')');
            })
            .catch(err => {
                console.warn('[PrakashMarg] Panchang fetch error:', err);
                renderFallbackPanchang();
            });
    }

    function renderFallbackPanchang() {
        var today   = new Date();
        var options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        setEl('hero-panchang-date', today.toLocaleDateString('hi-IN', options));
    }

    window.updatePanchangCity = function () {
        var sel = document.getElementById('city-select');
        if (!sel) return;
        var parts = sel.value.split(',').map(Number);
        panchangLat = parts[0]; panchangLon = parts[1];
        loadPanchang(panchangLat, panchangLon);
    };

    /* ── Festival Countdown ───────────────────────────────── */

    function loadFestival() {
        var now      = new Date();
        var upcoming = FESTIVALS.filter(function (f) { return f.date > now; })
                                .sort(function (a, b) { return a.date - b.date; });
        if (!upcoming.length) return;
        var next = upcoming[0];
        setEl('next-festival-name',  next.name);
        setEl('next-festival-emoji', next.emoji);
        setEl('next-festival-date',  next.date.toLocaleDateString('hi-IN', { day: 'numeric', month: 'long', year: 'numeric' }));

        // Update ticker elements
        var festivalText = next.emoji + ' ' + next.name;
        setEl('t-festival', festivalText);
        document.querySelectorAll('.t-festival-dup').forEach(function(el) { el.textContent = festivalText; });

        function tick() {
            var diff = next.date - new Date();
            if (diff <= 0) return;
            setEl('cd-days',  String(Math.floor(diff / 86400000)).padStart(2, '0'));
            setEl('cd-hours', String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0'));
            setEl('cd-mins',  String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0'));
        }
        tick();
        setInterval(tick, 60000);

        var listEl = document.getElementById('upcoming-festivals-list');
        if (listEl) {
            upcoming.slice(1, 4).forEach(function (f) {
                var d = f.date.toLocaleDateString('hi-IN', { day: 'numeric', month: 'short' });
                listEl.innerHTML += '<div style="display:flex;justify-content:space-between;font-size:13px;padding:7px 0;border-bottom:1px solid var(--bdl)"><span>' + f.emoji + ' ' + f.name + '</span><span style="font-weight:700;color:var(--go)">' + d + '</span></div>';
            });
        }
    }

    /* ── Quote of the Day ─────────────────────────────────── */

    var quoteIdx = 0;

    function setTodayQuote() {
        var today      = new Date();
        var dayOfYear  = Math.floor((today - new Date(today.getFullYear(), 0, 0)) / 86400000);
        quoteIdx       = dayOfYear % QUOTES.length;
        setEl('home-quote-text',   QUOTES[quoteIdx].text);
        setEl('home-quote-author', QUOTES[quoteIdx].author);
    }

    window.refreshHomeQuote = function () {
        quoteIdx = (quoteIdx + 1) % QUOTES.length;
        var q  = QUOTES[quoteIdx];
        var el = document.getElementById('home-quote-text');
        if (el) {
            el.style.opacity = '0';
            setTimeout(function () { el.textContent = q.text; el.style.transition = 'opacity .4s'; el.style.opacity = '1'; }, 250);
        }
        setEl('home-quote-author', q.author);
    };

    /* ── Rashifal ─────────────────────────────────────────── */

    window.showRashi = function (btn, key, emoji, name) {
        document.querySelectorAll('.rashi-btn').forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        setEl('rashi-title', emoji + ' ' + name + ' राशिफल');
        setEl('rashi-text',  RASHIFAL[key] || 'आज का दिन शुभ रहेगा।');
    };

    /* ── Bhajan Filter ────────────────────────────────────── */

    window.filterBhajan = function (btn, deity) {
        document.querySelectorAll('.deity-tab').forEach(function (t) { t.classList.remove('active'); });
        btn.classList.add('active');
        document.querySelectorAll('#bhajanList .bhajan-card').forEach(function (c) {
            c.style.display = (deity === 'all' || c.dataset.deity === deity) ? 'flex' : 'none';
        });
    };

    /* ── Lucky Number Calculator ──────────────────────────── */

    window.calcLuckyNumber = function () {
        var dob  = document.getElementById('lucky-dob');
        var name = document.getElementById('lucky-name');
        if (!dob || !dob.value) { alert('कृपया जन्म तारीख चुनें।'); return; }
        var sum = dob.value.replace(/\D/g, '').split('').reduce(function (a, b) { return a + parseInt(b, 10); }, 0);
        while (sum > 9) { sum = String(sum).split('').reduce(function (a, b) { return a + parseInt(b, 10); }, 0); }
        var box = document.getElementById('lucky-result-box');
        if (box) box.classList.remove('hidden');
        setEl('lucky-number-display', sum);
        setEl('lucky-number-name',    (name && name.value) ? name.value + ' का भाग्यांक' : 'आपका भाग्यांक');
        setEl('lucky-number-desc',    LUCKY_DESC[sum] || '');
    };

    /* ── Search Overlay ───────────────────────────────────── */

    window.openSearch = function () {
        var overlay = document.getElementById('searchOverlay');
        if (!overlay) return;
        overlay.classList.add('open');
        setTimeout(function () { var inp = document.getElementById('searchInput'); if (inp) inp.focus(); }, 100);
    };

    window.closeSearch = function () {
        var overlay = document.getElementById('searchOverlay');
        if (overlay) overlay.classList.remove('open');
    };

    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') window.closeSearch(); });

    /* ── Mobile Menu ──────────────────────────────────────── */

    function initMobileMenu() {
        var btn = document.getElementById('mobMenuBtn');
        var nav = document.getElementById('mobNav');
        if (btn && nav) { btn.addEventListener('click', function () { nav.classList.toggle('open'); }); }
    }

    /* ── Dark Mode ────────────────────────────────────────── */

    function initDarkMode() {
        var btn  = document.getElementById('themeToggle');
        var root = document.documentElement;

        function applyDark(isDark) {
            if (isDark) {
                root.classList.add('dark');
                // Force body background — overrides WordPress theme.json generated inline styles
                document.body.style.setProperty('background-color', '#12090B', 'important');
                document.body.style.setProperty('color', '#F0E8E0', 'important');
                // Also force WP site blocks wrapper
                var blocks = document.querySelector('.wp-site-blocks');
                if (blocks) {
                    blocks.style.setProperty('background-color', '#12090B', 'important');
                    blocks.style.setProperty('color', '#F0E8E0', 'important');
                }
                if (btn) btn.textContent = '☀️';
            } else {
                root.classList.remove('dark');
                document.body.style.removeProperty('background-color');
                document.body.style.removeProperty('color');
                var blocks = document.querySelector('.wp-site-blocks');
                if (blocks) {
                    blocks.style.removeProperty('background-color');
                    blocks.style.removeProperty('color');
                }
                if (btn) btn.textContent = '🌙';
            }
        }

        // Apply saved preference on page load
        var saved = localStorage.getItem('pm-dark');
        applyDark(saved === '1');

        if (btn) {
            btn.addEventListener('click', function () {
                var isDark = !root.classList.contains('dark');
                localStorage.setItem('pm-dark', isDark ? '1' : '0');
                applyDark(isDark);
            });
        }
    }

    /* ── Back to Top ──────────────────────────────────────── */

    function initBackToTop() {
        var btn = document.getElementById('backToTop');
        if (!btn) return;
        window.addEventListener('scroll', function () {
            btn.style.opacity = window.scrollY > 400 ? '1' : '0';
            btn.style.pointerEvents = window.scrollY > 400 ? 'auto' : 'none';
        });
        btn.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    }

    /* ── Hero Search Redirect ─────────────────────────────── */

    function initHeroSearch() {
        var inp = document.querySelector('.hero-search-input');
        var resDiv = document.getElementById('heroSearchResults');
        if (!inp || !resDiv) return;

        var debounceTimer;
        
        inp.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            var q = e.target.value.trim();
            
            if (q.length < 2) {
                resDiv.classList.add('hidden');
                resDiv.innerHTML = '';
                return;
            }
            
            resDiv.classList.remove('hidden');
            resDiv.innerHTML = '<div style="padding:15px;text-align:center;color:var(--txm)">खोज रहा है...</div>';
            
            debounceTimer = setTimeout(function() {
                var baseUrl = (typeof PM_HOME !== 'undefined') ? PM_HOME : '';
                fetch(baseUrl + '/wp-json/pm/v1/search?q=' + encodeURIComponent(q))
                    .then(r => r.json())
                    .then(data => {
                        if (!data || data.length === 0) {
                            resDiv.innerHTML = '<div style="padding:15px;text-align:center;color:var(--txm)">कोई परिणाम नहीं मिला।</div>';
                            return;
                        }
                        
                        var html = '';
                        data.forEach(function(item) {
                            html += '<a href="' + item.url + '" class="search-result-item">';
                            html += '<div class="sri-icon">' + item.icon + '</div>';
                            html += '<div class="sri-content">';
                            html += '<div class="sri-title">' + item.title + '</div>';
                            html += '<div class="sri-type">' + item.type + '</div>';
                            html += '</div></a>';
                        });
                        resDiv.innerHTML = html;
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                        resDiv.innerHTML = '<div style="padding:15px;text-align:center;color:var(--red)">त्रुटि हुई।</div>';
                    });
            }, 300); // 300ms debounce
        });

        // Hide on click outside
        document.addEventListener('click', function(e) {
            if (!inp.contains(e.target) && !resDiv.contains(e.target)) {
                resDiv.classList.add('hidden');
            }
        });
        
        // Show again if clicked on input and has value
        inp.addEventListener('focus', function() {
            if (inp.value.trim().length >= 2) {
                resDiv.classList.remove('hidden');
            }
        });
    }

    /* ── Hero Search Submit Redirect ──────────────────────── */
    
    function initHeroSearchSubmit() {
        var form = document.getElementById('hero-search-form');
        var inp = document.querySelector('.hero-search-input');
        if (!form || !inp) return;
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var q = inp.value.trim();
            if (q.length > 0) {
                var baseUrl = (typeof PM_HOME !== 'undefined') ? PM_HOME : '';
                window.location.href = baseUrl + '/?s=' + encodeURIComponent(q);
            }
        });
    }

    /* ── Link Fixer ───────────────────────────────────────── */
    function fixHardcodedLinks() {
        if (typeof PM_HOME === 'undefined') return;
        document.querySelectorAll('a[href^="/prakashmarg/"]').forEach(function(a) {
            var href = a.getAttribute('href');
            a.setAttribute('href', href.replace(/^\/prakashmarg/, PM_HOME));
        });
    }

    /* ── Init ─────────────────────────────────────────────── */

    document.addEventListener('DOMContentLoaded', function () {
        fixHardcodedLinks();
        loadPanchang(panchangLat, panchangLon);
        loadFestival();
        setTodayQuote();
        initMobileMenu();
        initDarkMode();
        initBackToTop();
        initHeroSearch();
        initHeroSearchSubmit();

        var yearEl = document.getElementById('pm-current-year');
        if (yearEl) yearEl.textContent = new Date().getFullYear();
    });

})();
