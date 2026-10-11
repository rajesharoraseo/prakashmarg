document.addEventListener('DOMContentLoaded', () => {

    // ==========================================================================
    // 1. Mobile Menu Toggle
    // ==========================================================================
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = mobileMenu.classList.toggle('hidden');
            // Animate hamburger → X
            const svg = mobileMenuBtn.querySelector('svg path');
            if (!isHidden) {
                svg.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            } else {
                svg.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            }
        });

        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    const svg = mobileMenuBtn.querySelector('svg path');
                    if (svg) svg.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                }
            }
        });
    }

    // ==========================================================================
    // 2. Sticky Header Shadow on Scroll
    // ==========================================================================
    const header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                header.classList.add('shadow-md');
            } else {
                header.classList.remove('shadow-md');
            }
        });
    }

    // ==========================================================================
    // 3. Back to Top Button
    // ==========================================================================
    const backToTopBtn = document.createElement('button');
    backToTopBtn.id = 'back-to-top';
    backToTopBtn.setAttribute('aria-label', 'Back to top');
    backToTopBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>`;
    backToTopBtn.style.cssText = `
        position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 99;
        width: 2.75rem; height: 2.75rem;
        background: #ff9933; color: #fff;
        border: none; border-radius: 50%; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 15px rgba(255,153,51,0.4);
        opacity: 0; pointer-events: none;
        transition: opacity 0.3s, transform 0.3s;
        transform: translateY(10px);
    `;
    document.body.appendChild(backToTopBtn);

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopBtn.style.opacity = '1';
            backToTopBtn.style.pointerEvents = 'auto';
            backToTopBtn.style.transform = 'translateY(0)';
        } else {
            backToTopBtn.style.opacity = '0';
            backToTopBtn.style.pointerEvents = 'none';
            backToTopBtn.style.transform = 'translateY(10px)';
        }
    });

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    backToTopBtn.addEventListener('mouseenter', () => {
        backToTopBtn.style.background = '#e67a00';
        backToTopBtn.style.transform = 'translateY(-2px)';
    });
    backToTopBtn.addEventListener('mouseleave', () => {
        backToTopBtn.style.background = '#ff9933';
        backToTopBtn.style.transform = window.scrollY > 300 ? 'translateY(0)' : 'translateY(10px)';
    });

    // ==========================================================================
    // 4. Scroll-triggered Fade-in Animations
    // ==========================================================================
    const fadeEls = document.querySelectorAll('.fade-in-up');
    if (fadeEls.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        fadeEls.forEach(el => observer.observe(el));
    }

    // ==========================================================================
    // 5. Search Modal
    // ==========================================================================
    const searchBtn = document.getElementById('header-search-btn');
    if (searchBtn) {
        // Create modal
        const searchModal = document.createElement('div');
        searchModal.id = 'search-modal';
        searchModal.setAttribute('role', 'dialog');
        searchModal.setAttribute('aria-modal', 'true');
        searchModal.setAttribute('aria-label', 'Site Search');
        searchModal.style.cssText = `
            display: none; position: fixed; inset: 0; z-index: 200;
            background: rgba(61,43,31,0.6); backdrop-filter: blur(4px);
            align-items: flex-start; justify-content: center; padding-top: 5rem;
        `;
        searchModal.innerHTML = `
            <div style="background:#fffdf9; border-radius:1rem; padding:1.5rem; width:min(560px, 92vw); box-shadow:0 20px 60px rgba(61,43,31,0.2); position:relative;">
                <div style="display:flex; align-items:center; gap:0.75rem; border:1.5px solid rgba(255,153,51,0.4); border-radius:0.5rem; padding: 0.6rem 1rem; background:#fff;">
                    <svg style="width:1.25rem;height:1.25rem;color:#ff9933;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input id="search-input" type="search" placeholder="खोजें... Search articles, chalisas..." style="flex:1; border:none; outline:none; font-size:1rem; font-family:Mukta,sans-serif; background:transparent; color:#3d2b1f;" autofocus>
                    <button id="close-search" aria-label="Close search" style="cursor:pointer;background:none;border:none;font-size:1.5rem;color:#9ca3af;line-height:1">×</button>
                </div>
                <div id="search-results" style="margin-top:1rem;max-height:300px;overflow-y:auto;"></div>
                <p style="margin-top:0.75rem;font-size:0.75rem;color:#9ca3af;text-align:center;">Press <kbd style="padding:0.1rem 0.4rem;border:1px solid #e5e7eb;border-radius:0.25rem;font-size:0.7rem">ESC</kbd> to close</p>
            </div>
        `;
        document.body.appendChild(searchModal);

        const searchableContent = [
            { title: 'दैनिक जीवन में ध्यान का महत्व', url: 'single.html?id=meditation-benefits', category: 'Blog' },
            { title: 'हनुमान चालीसा', url: 'single.html?id=hanuman-chalisa', category: 'Chalisa' },
            { title: 'शिव चालीसा', url: 'single.html?id=shiv-chalisa', category: 'Chalisa' },
            { title: 'दुर्गा चालीसा', url: 'single.html?id=durga-chalisa', category: 'Chalisa' },
            { title: 'पूजा विधि', url: 'puja-vidhi.html', category: 'Rituals' },
            { title: 'Spiritual Tools — ध्यान टाइमर, जाप माला', url: 'tools.html', category: 'Tools' },
            { title: 'आध्यात्मिक ई-पुस्तकें — eBook Store', url: 'shop.html', category: 'Shop' },
            { title: 'Blog & Articles', url: 'blog.html', category: 'Blog' },
            { title: 'व्रत-त्योहार Calendar', url: 'vrat-tyohar.html', category: 'Festivals' },
        ];

        const openSearch = () => {
            searchModal.style.display = 'flex';
            setTimeout(() => document.getElementById('search-input').focus(), 50);
        };
        const closeSearch = () => {
            searchModal.style.display = 'none';
            document.getElementById('search-input').value = '';
            document.getElementById('search-results').innerHTML = '';
        };

        searchBtn.addEventListener('click', openSearch);
        document.getElementById('close-search').addEventListener('click', closeSearch);
        searchModal.addEventListener('click', (e) => { if (e.target === searchModal) closeSearch(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeSearch(); });

        document.getElementById('search-input').addEventListener('input', (e) => {
            const q = e.target.value.trim().toLowerCase();
            const resultsEl = document.getElementById('search-results');
            if (!q) { resultsEl.innerHTML = ''; return; }
            const matches = searchableContent.filter(item => item.title.toLowerCase().includes(q) || item.category.toLowerCase().includes(q));
            if (matches.length === 0) {
                resultsEl.innerHTML = '<p style="text-align:center;color:#9ca3af;font-family:Mukta,sans-serif;padding:1rem">कोई परिणाम नहीं मिला (No results found)</p>';
            } else {
                resultsEl.innerHTML = matches.map(m => `
                    <a href="${m.url}" style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem;border-radius:0.5rem;text-decoration:none;color:#3d2b1f;transition:background 0.15s;font-family:Mukta,sans-serif;" onmouseover="this.style.background='rgba(255,153,51,0.08)'" onmouseout="this.style.background='transparent'">
                        <span style="font-weight:500">${m.title}</span>
                        <span style="font-size:0.7rem;background:rgba(255,153,51,0.15);color:#e67a00;padding:0.15rem 0.5rem;border-radius:999px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em">${m.category}</span>
                    </a>
                `).join('');
            }
        });
    }

    // ==========================================================================
    // 6. MEDITATION TIMER (tools.html)
    // ==========================================================================
    const meditationTimerContainer = document.getElementById('meditation-timer-container');
    if (meditationTimerContainer) {
        let timerInterval = null;
        let totalSeconds = 0;
        let running = false;

        const timerDisplay = document.getElementById('timer-display');
        const timerStartBtn = document.getElementById('timer-start-btn');
        const timerResetBtn = document.getElementById('timer-reset-btn');
        const timerOptions = document.querySelectorAll('.timer-option');

        const formatTime = (s) => {
            const m = Math.floor(s / 60).toString().padStart(2, '0');
            const sec = (s % 60).toString().padStart(2, '0');
            return `${m}:${sec}`;
        };

        timerOptions.forEach(btn => {
            btn.addEventListener('click', () => {
                timerOptions.forEach(b => b.classList.remove('active-timer'));
                btn.classList.add('active-timer');
                clearInterval(timerInterval);
                running = false;
                totalSeconds = parseInt(btn.dataset.seconds);
                timerDisplay.textContent = formatTime(totalSeconds);
                timerStartBtn.textContent = 'शुरू करें (Start)';
            });
        });

        if (timerStartBtn) {
            timerStartBtn.addEventListener('click', () => {
                if (totalSeconds <= 0) { alert('कृपया पहले समय चुनें।'); return; }
                if (running) {
                    clearInterval(timerInterval);
                    running = false;
                    timerStartBtn.textContent = 'जारी रखें (Resume)';
                } else {
                    running = true;
                    timerStartBtn.textContent = 'रोकें (Pause)';
                    timerInterval = setInterval(() => {
                        totalSeconds--;
                        timerDisplay.textContent = formatTime(totalSeconds);
                        if (totalSeconds <= 0) {
                            clearInterval(timerInterval);
                            running = false;
                            timerDisplay.textContent = '🙏 ध्यान पूर्ण!';
                            timerStartBtn.textContent = 'पूर्ण हुआ!';
                        }
                    }, 1000);
                }
            });
        }

        if (timerResetBtn) {
            timerResetBtn.addEventListener('click', () => {
                clearInterval(timerInterval);
                running = false;
                const activeOption = document.querySelector('.active-timer');
                if (activeOption) {
                    totalSeconds = parseInt(activeOption.dataset.seconds);
                    timerDisplay.textContent = formatTime(totalSeconds);
                } else {
                    totalSeconds = 0;
                    timerDisplay.textContent = '00:00';
                }
                timerStartBtn.textContent = 'शुरू करें (Start)';
            });
        }
    }

    // ==========================================================================
    // 7. JAPA MALA COUNTER (tools.html)
    // ==========================================================================
    const malaContainer = document.getElementById('japa-mala-container');
    if (malaContainer) {
        let count = 0;
        let rounds = 0;
        const MALA_COUNT = 108;

        const countDisplay = document.getElementById('mala-count');
        const roundsDisplay = document.getElementById('mala-rounds');
        const malaBtn = document.getElementById('mala-tap-btn');
        const malaResetBtn = document.getElementById('mala-reset-btn');
        const progressBar = document.getElementById('mala-progress-bar');

        const updateMala = () => {
            if (countDisplay) countDisplay.textContent = count;
            if (roundsDisplay) roundsDisplay.textContent = rounds;
            if (progressBar) progressBar.style.width = `${(count / MALA_COUNT) * 100}%`;
        };

        if (malaBtn) {
            malaBtn.addEventListener('click', () => {
                count++;
                if (count >= MALA_COUNT) { count = 0; rounds++; }
                updateMala();
                // Haptic pulse animation
                malaBtn.style.transform = 'scale(0.95)';
                setTimeout(() => { malaBtn.style.transform = 'scale(1)'; }, 100);
            });
        }

        if (malaResetBtn) {
            malaResetBtn.addEventListener('click', () => {
                count = 0; rounds = 0;
                updateMala();
            });
        }

        updateMala();
    }

    // ==========================================================================
    // 8. MANTRA OF THE DAY (tools.html)
    // ==========================================================================
    const mantraContainer = document.getElementById('mantra-of-day-container');
    if (mantraContainer) {
        const mantras = [
            { mantra: 'ॐ नमः शिवाय', meaning: 'I bow to Shiva — the pure consciousness', deity: 'Lord Shiva' },
            { mantra: 'ॐ नमो भगवते वासुदेवाय', meaning: 'Salutations to Lord Vasudeva', deity: 'Lord Vishnu' },
            { mantra: 'ॐ श्री गणेशाय नमः', meaning: 'Salutations to Lord Ganesha', deity: 'Lord Ganesha' },
            { mantra: 'ॐ ऐं सरस्वत्यै नमः', meaning: 'Salutations to Goddess Saraswati', deity: 'Goddess Saraswati' },
            { mantra: 'ॐ दुं दुर्गायै नमः', meaning: 'Salutations to Goddess Durga', deity: 'Goddess Durga' },
            { mantra: 'ॐ हनुमते नमः', meaning: 'Salutations to Lord Hanuman', deity: 'Lord Hanuman' },
            { mantra: 'ॐ भूर्भुवः स्वः', meaning: 'Gayatri — the supreme illumination of Divine light', deity: 'Surya / Universal' },
        ];
        const todayMantra = mantras[new Date().getDay() % mantras.length];
        const mantraTextEl = document.getElementById('mantra-text');
        const mantraMeaningEl = document.getElementById('mantra-meaning');
        const mantraDeityEl = document.getElementById('mantra-deity');
        if (mantraTextEl) mantraTextEl.textContent = todayMantra.mantra;
        if (mantraMeaningEl) mantraMeaningEl.textContent = todayMantra.meaning;
        if (mantraDeityEl) mantraDeityEl.textContent = todayMantra.deity;
    }

    // ==========================================================================
    // 9. Lucky Number / Numerology Logic
    // ==========================================================================
    const btnOpenLuckyNumber = document.getElementById('btn-open-lucky-number');
    const luckyNumberFront = document.getElementById('lucky-number-front');
    const luckyNumberForm = document.getElementById('lucky-number-form');
    const btnCancelNumerology = document.getElementById('btn-cancel-numerology');
    const btnCalculateNumerology = document.getElementById('btn-calculate-numerology');
    const luckyNumberResult = document.getElementById('lucky-number-result');
    const btnResetNumerology = document.getElementById('btn-reset-numerology');
    const dobInput = document.getElementById('dob-input');

    if (btnOpenLuckyNumber && luckyNumberFront && luckyNumberForm && btnCancelNumerology && btnCalculateNumerology && luckyNumberResult && btnResetNumerology && dobInput) {
        btnOpenLuckyNumber.addEventListener('click', () => {
            luckyNumberFront.classList.add('hidden');
            luckyNumberForm.classList.remove('hidden');
            luckyNumberForm.classList.add('flex');
        });

        btnCancelNumerology.addEventListener('click', () => {
            luckyNumberForm.classList.add('hidden');
            luckyNumberForm.classList.remove('flex');
            luckyNumberFront.classList.remove('hidden');
            dobInput.value = '';
        });

        btnResetNumerology.addEventListener('click', () => {
            luckyNumberResult.classList.add('hidden');
            luckyNumberResult.classList.remove('flex');
            luckyNumberForm.classList.remove('hidden');
            luckyNumberForm.classList.add('flex');
            dobInput.value = '';
        });

        const reduceToSingleDigit = (num) => {
            let sum = num;
            while (sum > 9) {
                sum = sum.toString().split('').reduce((acc, digit) => acc + parseInt(digit, 10), 0);
            }
            return sum;
        };

        const numerologyData = {
            1: { colorName: 'Saffron (भगवा)', colorHex: '#F97316', trait: 'सूर्य: नेतृत्व, स्वतंत्रता और आत्मविश्वास (Leadership & Independence)' },
            2: { colorName: 'White (सफेद)', colorHex: '#E5E7EB', trait: 'चंद्रमा: शांति, सहयोग और संवेदनशीलता (Peace & Cooperation)' },
            3: { colorName: 'Yellow (पीला)', colorHex: '#FCD34D', trait: 'बृहस्पति: रचनात्मकता, ज्ञान और विस्तार (Creativity & Wisdom)' },
            4: { colorName: 'Brown (भूरा)', colorHex: '#78350F', trait: 'राहु: स्थिरता, व्यावहारिकता और अनुशासन (Stability & Practicality)' },
            5: { colorName: 'Green (हरा)', colorHex: '#22C55E', trait: 'बुध: स्वतंत्रता, परिवर्तन और संवाद (Freedom & Communication)' },
            6: { colorName: 'Light Blue (हल्का नीला)', colorHex: '#60A5FA', trait: 'शुक्र: सद्भाव, प्रेम और सौंदर्य (Harmony & Love)' },
            7: { colorName: 'Grey (स्लेटी)', colorHex: '#9CA3AF', trait: 'केतु: आध्यात्मिकता, विश्लेषण और अंतर्ज्ञान (Spirituality & Analysis)' },
            8: { colorName: 'Black/Navy (काला)', colorHex: '#1E293B', trait: 'शनि: शक्ति, कर्म और न्याय (Power, Karma & Justice)' },
            9: { colorName: 'Red (लाल)', colorHex: '#EF4444', trait: 'मंगल: ऊर्जा, करुणा और साहस (Energy & Courage)' }
        };

        btnCalculateNumerology.addEventListener('click', () => {
            if (!dobInput.value) {
                alert('कृपया अपनी जन्म तिथि दर्ज करें। (Please enter your Date of Birth.)');
                return;
            }
            const dobString = dobInput.value;
            const parts = dobString.split('-');
            if (parts.length !== 3) return;

            const dayString = parts[2];
            const fullDateString = parts.join('');

            const moolaankRaw = dayString.split('').reduce((acc, digit) => acc + parseInt(digit, 10), 0);
            const moolaank = reduceToSingleDigit(moolaankRaw);
            const bhagyaankRaw = fullDateString.split('').reduce((acc, digit) => acc + parseInt(digit, 10), 0);
            const bhagyaank = reduceToSingleDigit(bhagyaankRaw);

            document.getElementById('moolaank-value').textContent = moolaank;
            document.getElementById('moolaank-color').textContent = numerologyData[moolaank].colorName;
            document.getElementById('moolaank-color-bar').style.backgroundColor = numerologyData[moolaank].colorHex;
            document.getElementById('moolaank-color').style.color = numerologyData[moolaank].colorHex;
            document.getElementById('moolaank-trait').textContent = numerologyData[moolaank].trait;

            document.getElementById('bhagyaank-value').textContent = bhagyaank;
            document.getElementById('bhagyaank-color').textContent = numerologyData[bhagyaank].colorName;
            document.getElementById('bhagyaank-color-bar').style.backgroundColor = numerologyData[bhagyaank].colorHex;
            document.getElementById('bhagyaank-color').style.color = numerologyData[bhagyaank].colorHex;
            document.getElementById('bhagyaank-trait').textContent = numerologyData[bhagyaank].trait;

            luckyNumberForm.classList.add('hidden');
            luckyNumberForm.classList.remove('flex');
            luckyNumberResult.classList.remove('hidden');
            luckyNumberResult.classList.add('flex');
        });
    }

    // ==========================================================================
    // 10. Product Checkout Toggle Logic
    // ==========================================================================
    const checkoutContainers = document.querySelectorAll('.product-checkout-container');
    checkoutContainers.forEach(container => {
        const productType = container.getAttribute('data-product-type');
        const digitalView = container.querySelector('.digital-checkout-view');
        const physicalView = container.querySelector('.physical-checkout-view');
        if (digitalView && physicalView) {
            if (productType === 'physical') {
                digitalView.classList.add('hidden');
                physicalView.classList.remove('hidden');
            } else {
                physicalView.classList.add('hidden');
                digitalView.classList.remove('hidden');
            }
        }
    });

    // ==========================================================================
    // 11. FAQ Accordion & JSON-LD Injection
    // ==========================================================================
    const faqContainers = document.querySelectorAll('.faq-container');
    if (faqContainers.length > 0) {
        let faqSchema = { "@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [] };
        faqContainers.forEach(container => {
            const faqItems = container.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const btn = item.querySelector('.faq-button');
                const answer = item.querySelector('.faq-answer');
                const icon = item.querySelector('.faq-icon');
                const questionElement = item.querySelector('.faq-question');
                if (!btn || !answer || !icon || !questionElement) return;

                faqSchema.mainEntity.push({
                    "@type": "Question",
                    "name": questionElement.textContent.trim(),
                    "acceptedAnswer": { "@type": "Answer", "text": answer.textContent.trim() }
                });

                btn.addEventListener('click', () => {
                    const isExpanded = btn.getAttribute('aria-expanded') === 'true';
                    // Close all others
                    container.querySelectorAll('.faq-button[aria-expanded="true"]').forEach(otherBtn => {
                        if (otherBtn !== btn) {
                            otherBtn.setAttribute('aria-expanded', 'false');
                            otherBtn.nextElementSibling?.classList.add('hidden');
                            otherBtn.querySelector('.faq-icon')?.classList.remove('rotate-180');
                        }
                    });
                    if (isExpanded) {
                        btn.setAttribute('aria-expanded', 'false');
                        answer.classList.add('hidden');
                        icon.classList.remove('rotate-180');
                    } else {
                        btn.setAttribute('aria-expanded', 'true');
                        answer.classList.remove('hidden');
                        icon.classList.add('rotate-180');
                    }
                });
            });
        });
        if (faqSchema.mainEntity.length > 0) {
            const script = document.createElement('script');
            script.type = 'application/ld+json';
            script.text = JSON.stringify(faqSchema, null, 2);
            document.head.appendChild(script);
        }
    }

    // ==========================================================================
    // 12. Daily Panchang Widget Logic (Improved with actual date-based tithi)
    // ==========================================================================
    const panchangWidgets = document.querySelectorAll('.panchang-widget');
    if (panchangWidgets.length > 0) {
        const today = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const dateString = today.toLocaleDateString('hi-IN', options);

        // Tithi cycle approximation (synodic month ~29.53 days)
        // Reference: Full Moon (Purnima) on Jan 13, 2025 (Julian Day for reference)
        const refFullMoon = new Date('2025-01-13');
        const daysSinceRef = Math.floor((today - refFullMoon) / (1000 * 60 * 60 * 24));
        const synodicMonth = 29.53059;
        const moonPhase = ((daysSinceRef % synodicMonth) + synodicMonth) % synodicMonth;
        const tithiNum = Math.floor(moonPhase) + 1;

        const tithiNames = [
            'शुक्ल पक्ष, प्रतिपदा', 'शुक्ल पक्ष, द्वितीया', 'शुक्ल पक्ष, तृतीया',
            'शुक्ल पक्ष, चतुर्थी', 'शुक्ल पक्ष, पञ्चमी', 'शुक्ल पक्ष, षष्ठी',
            'शुक्ल पक्ष, सप्तमी', 'शुक्ल पक्ष, अष्टमी', 'शुक्ल पक्ष, नवमी',
            'शुक्ल पक्ष, दशमी', 'शुक्ल पक्ष, एकादशी', 'शुक्ल पक्ष, द्वादशी',
            'शुक्ल पक्ष, त्रयोदशी', 'शुक्ल पक्ष, चतुर्दशी', 'पूर्णिमा',
            'कृष्ण पक्ष, प्रतिपदा', 'कृष्ण पक्ष, द्वितीया', 'कृष्ण पक्ष, तृतीया',
            'कृष्ण पक्ष, चतुर्थी', 'कृष्ण पक्ष, पञ्चमी', 'कृष्ण पक्ष, षष्ठी',
            'कृष्ण पक्ष, सप्तमी', 'कृष्ण पक्ष, अष्टमी', 'कृष्ण पक्ष, नवमी',
            'कृष्ण पक्ष, दशमी', 'कृष्ण पक्ष, एकादशी', 'कृष्ण पक्ष, द्वादशी',
            'कृष्ण पक्ष, त्रयोदशी', 'कृष्ण पक्ष, चतुर्दशी', 'अमावस्या'
        ];

        const nakshatras = ['अश्विनी','भरणी','कृत्तिका','रोहिणी','मृगशिरा','आर्द्रा','पुनर्वसु',
            'पुष्य','आश्लेषा','मघा','पूर्वाफाल्गुनी','उत्तराफाल्गुनी','हस्त','चित्रा',
            'स्वाती','विशाखा','अनुराधा','ज्येष्ठा','मूल','पूर्वाषाढ़ा','उत्तराषाढ़ा',
            'श्रवण','धनिष्ठा','शतभिषा','पूर्वाभाद्रपद','उत्तराभाद्रपद','रेवती'];
        const nakshatraIdx = Math.floor((daysSinceRef * 13.176358) % 27);

        // Day-of-week based Rahu Kaal
        const rahuKaalByDay = ['12:00 PM - 01:30 PM','07:30 AM - 09:00 AM','03:00 PM - 04:30 PM',
            '12:00 PM - 01:30 PM','01:30 PM - 03:00 PM','10:30 AM - 12:00 PM','09:00 AM - 10:30 AM'];
        const shubhMuhurat = ['11:41 AM - 12:29 PM','09:15 AM - 10:05 AM','10:30 AM - 11:20 AM',
            '11:45 AM - 12:35 PM','08:00 AM - 09:00 AM','09:00 AM - 10:00 AM','07:30 AM - 08:30 AM'];

        const tithi = tithiNames[Math.min(tithiNum - 1, 29)];
        const nakshatra = nakshatras[Math.abs(nakshatraIdx) % 27];
        const shubh = shubhMuhurat[today.getDay()];
        const rahu = rahuKaalByDay[today.getDay()];

        panchangWidgets.forEach(widget => {
            const dateEl = widget.querySelector('.panchang-date');
            const tithiEl = widget.querySelector('.panchang-tithi');
            const nakshatraEl = widget.querySelector('.panchang-nakshatra');
            const shubhEl = widget.querySelector('.panchang-shubh');
            const rahuEl = widget.querySelector('.panchang-rahu');
            const noticeEl = widget.querySelector('.panchang-offline-notice');

            if (dateEl) dateEl.textContent = dateString;
            setTimeout(() => {
                if (tithiEl) tithiEl.textContent = tithi;
                if (nakshatraEl) nakshatraEl.textContent = nakshatra;
                if (shubhEl) shubhEl.textContent = shubh;
                if (rahuEl) rahuEl.textContent = rahu;
                if (noticeEl) noticeEl.classList.remove('hidden');
            }, 400);
        });
    }

    // ==========================================================================
    // 13. Global Article Database
    // ==========================================================================
    const articleDatabase = {
        'meditation-benefits': {
            title: 'दैनिक जीवन में ध्यान का महत्व और इसके वैज्ञानिक लाभ',
            subtitle: 'आधुनिक जीवनशैली में मानसिक शांति प्राप्त करने के लिए ध्यान (Meditation) सबसे सरल और शक्तिशाली माध्यम है।',
            category: 'Spiritual Lifestyle',
            body: `
                <p class="text-xl leading-relaxed mb-8">आज की भागदौड़ भरी जिंदगी में तनाव, चिंता और मानसिक अशांति एक आम बात हो गई है। ऐसे में 'ध्यान' (Meditation) वह प्राचीन और प्रामाणिक मार्ग है जो हमें हमारे भीतर की शांति से जोड़ता है।</p>
                <h2>ध्यान क्या है?</h2>
                <p>ध्यान केवल आँखें बंद करके बैठना नहीं है। यह मन को एकाग्र करने और विचारों के प्रति जागरूक होने की एक सतत प्रक्रिया है। भगवद्गीता में भगवान श्री कृष्ण कहते हैं:</p>
            `
        },
        'hanuman-chalisa': {
            title: 'श्री हनुमान चालीसा',
            subtitle: 'संकटमोचन हनुमान जी की स्तुति, जो हर प्रकार के भय और संकट को दूर करती है।',
            category: 'Chalisa Sangrah',
            body: `
                <div class="chalisa-frame bg-red-50/80 border-8 border-double border-red-800 rounded-2xl p-8 md:p-12 shadow-soft relative overflow-hidden text-center max-w-3xl mx-auto">
                    <div class="absolute top-4 left-4 text-red-800/40 text-3xl">🪔</div>
                    <div class="absolute top-4 right-4 text-red-800/40 text-3xl">🪔</div>
                    <div class="absolute bottom-4 left-4 text-red-800/40 text-3xl">ॐ</div>
                    <div class="absolute bottom-4 right-4 text-red-800/40 text-3xl">ॐ</div>
                    <div class="text-red-900 font-hindi">
                        <p class="text-xl leading-relaxed mb-10 italic">हनुमान चालीसा गोस्वामी तुलसीदास जी द्वारा रचित एक अत्यंत शक्तिशाली स्तोत्र है। इसका नित्य पाठ जीवन में सुख, शांति और शक्ति लाता है।</p>
                        <h2 class="text-3xl font-hindi-serif font-bold text-red-800 mb-6 border-b-2 border-red-800/20 inline-block pb-2">॥ दोहा ॥</h2>
                        <p class="text-2xl leading-loose font-medium mb-10">
                            श्रीगुरु चरन सरोज रज, निज मनु मुकुरु सुधारि।<br>
                            बरनउँ रघुबर बिमल जसु, जो दायकु फल चारि॥<br><br>
                            बुद्धिहीन तनु जानिके, सुमिरौं पवन-कुमार।<br>
                            बल बुधि बिद्या देहु मोहिं, हरहु कलेस बिकार॥
                        </p>
                        <h2 class="text-3xl font-hindi-serif font-bold text-red-800 mb-6 border-b-2 border-red-800/20 inline-block pb-2">॥ चौपाई ॥</h2>
                        <p class="text-2xl leading-loose font-medium mb-4">
                            जय हनुमान ज्ञान गुन सागर।<br>जय कपीस तिहुं लोक उजागर॥
                        </p>
                        <p class="text-2xl leading-loose font-medium mb-4">
                            राम दूत अतुलित बल धामा।<br>अंजनि-पुत्र पवनसुत नामा॥
                        </p>
                    </div>
                </div>
            `
        },
        'shiv-chalisa': {
            title: 'श्री शिव चालीसा',
            subtitle: 'देवाधिदेव महादेव की कृपा प्राप्त करने के लिए अत्यंत प्रभावशाली स्तुति।',
            category: 'Chalisa Sangrah',
            body: `<p class="text-xl leading-relaxed mb-8">शिव चालीसा का पाठ भगवान शिव को प्रसन्न करने और जीवन में सुख-शांति लाने का एक सरल माध्यम है।</p><h2>दोहा</h2><p>जय गणेश गिरिजा सुवन, मंगल मूल सुजान।<br>कहत अयोध्यादास तुम, देहु अभय वरदान॥</p>`
        },
        'durga-chalisa': {
            title: 'श्री दुर्गा चालीसा',
            subtitle: 'माँ दुर्गा की स्तुति जो शक्ति, साहस और विजय प्रदान करती है।',
            category: 'Chalisa Sangrah',
            body: `<p class="text-xl leading-relaxed mb-8">दुर्गा चालीसा के पाठ से जीवन में आने वाली सभी बाधाएं दूर होती हैं और देवी माँ का आशीर्वाद मिलता है।</p><h2>नमो नमो दुर्गे</h2><p>नमो नमो दुर्गे सुख करनी।<br>नमो नमो अम्बे दुःख हरनी॥</p>`
        },
        'karma-yoga': {
            title: 'कर्म योग: निष्काम कर्म की शक्ति',
            subtitle: 'भगवद्गीता के अनुसार कर्म योग का वास्तविक अर्थ क्या है और इसे कैसे अपनाएं।',
            category: 'Philosophy',
            body: `<p class="text-xl leading-relaxed mb-8">कर्म योग वह मार्ग है जिसमें मनुष्य फल की आसक्ति छोड़कर कर्म करता है। यह भगवद्गीता की सर्वोच्च शिक्षाओं में से एक है।</p><h2>निष्काम कर्म क्या है?</h2><p>भगवान श्री कृष्ण अर्जुन से कहते हैं: "कर्म कर, फल की चिंता मत कर।" यही निष्काम कर्म का सार है।</p>`
        },
        'positive-energy': {
            title: 'घर में सकारात्मक ऊर्जा कैसे बढ़ाएं',
            subtitle: 'वास्तु और साधारण दैनिक उपायों से अपने घर के वातावरण को पवित्र बनाएं।',
            category: 'Rituals',
            body: `<p class="text-xl leading-relaxed mb-8">वास्तुशास्त्र और सनातन परंपरा के अनुसार कुछ सरल उपाय हैं जो घर में सकारात्मक ऊर्जा का संचार करते हैं।</p><h2>सुबह की दिनचर्या</h2><p>प्रतिदिन सुबह घर के मुख्य द्वार पर रंगोली और दीपक जलाएं। इससे घर में देवी लक्ष्मी का वास होता है।</p>`
        }
    };

    // ==========================================================================
    // 14. Taxonomy Routing (Dynamic Content Loading)
    // ==========================================================================
    const urlParams = new URLSearchParams(window.location.search);
    const articleId = urlParams.get('id');

    if (articleId) {
        const dynamicTitle = document.getElementById('dynamic-title');
        const dynamicSubtitle = document.getElementById('dynamic-subtitle');
        const dynamicCategory = document.getElementById('dynamic-category');
        const dynamicBody = document.getElementById('dynamic-article-body');
        const articleData = articleDatabase[articleId];

        if (articleData && dynamicTitle && dynamicSubtitle && dynamicCategory && dynamicBody) {
            document.title = articleData.title + ' — Prakash Marg';
            dynamicTitle.textContent = articleData.title;
            dynamicSubtitle.textContent = articleData.subtitle;
            dynamicCategory.textContent = articleData.category;
            dynamicBody.innerHTML = articleData.body;
        }
    }

    // ==========================================================================
    // 15. Theme Toggle (Dark Mode)
    // ==========================================================================
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    if (themeToggleBtn && darkIcon && lightIcon) {
        if (document.documentElement.classList.contains('dark')) {
            darkIcon.classList.add('hidden');
            lightIcon.classList.remove('hidden');
        } else {
            lightIcon.classList.add('hidden');
            darkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            } else {
                localStorage.setItem('theme', 'light');
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            }
        });
    }

    // ==========================================================================
    // 16. Bookmarking Logic
    // ==========================================================================
    const saveArticleBtn = document.getElementById('save-article-btn');
    const saveIconOutline = document.getElementById('save-icon-outline');
    const saveIconFilled = document.getElementById('save-icon-filled');
    const saveText = document.getElementById('save-text');
    const getSavedArticles = () => JSON.parse(localStorage.getItem('prakashMargSaved')) || [];

    if (saveArticleBtn && articleId) {
        let savedArticles = getSavedArticles();
        let isSaved = savedArticles.includes(articleId);
        const updateSaveUI = () => {
            if (isSaved) {
                saveIconOutline?.classList.add('hidden');
                saveIconFilled?.classList.remove('hidden');
                if (saveText) saveText.textContent = 'Saved';
            } else {
                saveIconOutline?.classList.remove('hidden');
                saveIconFilled?.classList.add('hidden');
                if (saveText) saveText.textContent = 'Save';
            }
        };
        updateSaveUI();
        saveArticleBtn.addEventListener('click', () => {
            savedArticles = getSavedArticles();
            if (isSaved) { savedArticles = savedArticles.filter(id => id !== articleId); isSaved = false; }
            else { if (!savedArticles.includes(articleId)) savedArticles.push(articleId); isSaved = true; }
            localStorage.setItem('prakashMargSaved', JSON.stringify(savedArticles));
            updateSaveUI();
        });
    }

    // ==========================================================================
    // 17. My Library Rendering
    // ==========================================================================
    const savedArticlesGrid = document.getElementById('saved-articles-grid');
    const emptyLibraryMsg = document.getElementById('empty-library-msg');
    if (savedArticlesGrid && emptyLibraryMsg) {
        const savedArticles = getSavedArticles();
        if (savedArticles.length === 0) {
            emptyLibraryMsg.classList.remove('hidden');
        } else {
            savedArticlesGrid.innerHTML = '';
            savedArticles.forEach(id => {
                const data = articleDatabase[id];
                if (data) {
                    savedArticlesGrid.insertAdjacentHTML('beforeend', `
                        <article class="bg-white dark:bg-navy-light rounded-2xl overflow-hidden shadow-sm hover:shadow-soft transition-all border border-sandalwood/30 flex flex-col h-full">
                            <div class="p-6 flex flex-col flex-grow">
                                <span class="inline-block text-saffron text-xs font-bold uppercase tracking-wider mb-3">${data.category}</span>
                                <h2 class="text-2xl font-hindi-serif font-bold text-darkbrown dark:text-cream mb-3"><a href="single.html?id=${id}" class="hover:text-saffron transition-colors">${data.title}</a></h2>
                                <p class="text-darkbrown dark:text-cream/70 font-hindi mb-6 line-clamp-3">${data.subtitle}</p>
                                <div class="mt-auto pt-4 border-t border-sandalwood/20 flex justify-between items-center">
                                    <a href="single.html?id=${id}" class="text-saffron font-bold text-sm uppercase tracking-wide hover:text-saffron-dark transition-colors">Read Now →</a>
                                </div>
                            </div>
                        </article>
                    `);
                }
            });
        }
    }

    // ==========================================================================
    // 18. Vrat & Tyohar Calendar
    // ==========================================================================
    const calendarGrid = document.getElementById('calendar-days-grid');
    const monthTitle = document.getElementById('calendar-month-title');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');

    if (calendarGrid && monthTitle) {
        let currentDate = new Date();
        currentDate.setDate(1);

        const festivalData = {
            '2026-06-06': { type: 'ekadashi', name: 'अपरा एकादशी' },
            '2026-06-14': { type: 'amavasya', name: 'ज्येष्ठ अमावस्या' },
            '2026-06-21': { type: 'ekadashi', name: 'निर्जला एकादशी' },
            '2026-06-29': { type: 'purnima', name: 'ज्येष्ठ पूर्णिमा' },
            '2026-07-06': { type: 'ekadashi', name: 'योगिनी एकादशी' },
            '2026-07-13': { type: 'amavasya', name: 'आषाढ़ अमावस्या' },
            '2026-07-21': { type: 'ekadashi', name: 'देवशयनी एकादशी' },
            '2026-07-29': { type: 'purnima', name: 'गुरु पूर्णिमा' }
        };

        const renderCalendar = () => {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const monthNamesHi = ['जनवरी','फरवरी','मार्च','अप्रैल','मई','जून','जुलाई','अगस्त','सितंबर','अक्टूबर','नवंबर','दिसंबर'];
            monthTitle.textContent = `${monthNamesHi[month]} ${year}`;
            const firstDayIndex = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const todayD = new Date();
            let html = '';
            for (let i = 0; i < firstDayIndex; i++) { html += `<div class="p-2 md:p-4 rounded-xl border border-transparent"></div>`; }
            for (let i = 1; i <= daysInMonth; i++) {
                const m = String(month + 1).padStart(2, '0');
                const d = String(i).padStart(2, '0');
                const dateKey = `${year}-${m}-${d}`;
                const fest = festivalData[dateKey];
                const isToday = (i === todayD.getDate() && month === todayD.getMonth() && year === todayD.getFullYear());
                let dayClasses = `p-2 md:p-4 rounded-xl border flex flex-col items-center justify-center min-h-[80px] transition-colors relative group cursor-pointer ${isToday ? 'border-saffron bg-saffron/10 ring-2 ring-saffron ring-offset-1' : 'border-sandalwood/20 bg-white dark:bg-navy hover:bg-saffron/10'}`;
                let badge = '';
                if (fest) {
                    if (fest.type === 'ekadashi') badge = `<div class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-saffron text-white text-[10px] flex items-center justify-center font-bold shadow-sm z-10" title="${fest.name}">ए</div>`;
                    else if (fest.type === 'amavasya') badge = `<div class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-darkbrown text-white text-[10px] flex items-center justify-center font-bold shadow-sm z-10" title="${fest.name}">अ</div>`;
                    else if (fest.type === 'purnima') badge = `<div class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-sandalwood text-darkbrown text-[10px] flex items-center justify-center font-bold shadow-sm z-10" title="${fest.name}">पू</div>`;
                    dayClasses += ' border-saffron/50 shadow-sm';
                }
                html += `
                    <div class="${dayClasses}">
                        ${badge}
                        <span class="text-lg md:text-xl font-bold ${isToday ? 'text-saffron' : 'text-darkbrown dark:text-cream'}">${i}</span>
                        ${fest ? `<span class="text-[10px] md:text-xs text-saffron font-bold text-center mt-1 hidden md:block leading-tight">${fest.name}</span>` : ''}
                        ${fest ? `<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-32 bg-darkbrown text-white text-xs text-center rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-20 md:hidden shadow-lg">${fest.name}</div>` : ''}
                    </div>`;
            }
            calendarGrid.innerHTML = html;
        };

        renderCalendar();
        prevMonthBtn?.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() - 1); renderCalendar(); });
        nextMonthBtn?.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() + 1); renderCalendar(); });
    }

});
