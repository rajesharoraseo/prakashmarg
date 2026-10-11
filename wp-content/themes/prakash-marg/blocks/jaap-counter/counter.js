document.addEventListener('DOMContentLoaded', () => {
    const blocks = document.querySelectorAll('.pm-jaap-counter');
    
    blocks.forEach(block => {
        const display = block.querySelector('#pm-jaap-display');
        const btn = block.querySelector('#pm-jaap-btn');
        const resetBtn = block.querySelector('#pm-jaap-reset');
        
        // Use a generic key or post-specific key if we want multiple counters
        const storageKey = 'pm_jaap_count';
        
        let count = parseInt(localStorage.getItem(storageKey)) || 0;
        
        const updateDisplay = () => {
            display.textContent = count;
            // Add a small pop animation
            display.style.transform = 'scale(1.1)';
            setTimeout(() => {
                display.style.transform = 'scale(1)';
            }, 100);
        };
        
        // Initialize
        updateDisplay();
        
        btn.addEventListener('click', () => {
            count++;
            localStorage.setItem(storageKey, count);
            updateDisplay();
            
            // Haptic feedback if supported (mobile)
            if (window.navigator && window.navigator.vibrate) {
                window.navigator.vibrate(50);
            }
        });
        
        resetBtn.addEventListener('click', () => {
            if (confirm('Are you sure you want to reset your Jaap count to 0?')) {
                count = 0;
                localStorage.setItem(storageKey, count);
                updateDisplay();
            }
        });
    });
});
