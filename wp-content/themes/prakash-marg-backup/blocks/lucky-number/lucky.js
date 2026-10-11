document.addEventListener('DOMContentLoaded', () => {
    const blocks = document.querySelectorAll('.pm-lucky-number');
    
    // Some positive messages for each number 1-9
    const messages = {
        1: "A day of leadership and new beginnings. Trust your instincts.",
        2: "Partnerships and harmony are highlighted today. Be diplomatic.",
        3: "Creativity and communication flow easily. Express yourself!",
        4: "Focus on stability and hard work. Your efforts will pay off.",
        5: "Embrace change and adventure. Unexpected opportunities await.",
        6: "A day for family, love, and healing. Nurture your relationships.",
        7: "Introspection and spirituality are key. Seek inner wisdom.",
        8: "Financial success and power are in focus. Take charge.",
        9: "Completion and humanitarianism. Let go of what no longer serves you."
    };
    
    blocks.forEach(block => {
        const setupDiv = block.querySelector('#pm-lucky-setup');
        const resultDiv = block.querySelector('#pm-lucky-result');
        const nameInput = block.querySelector('#pm-lucky-name');
        const btn = block.querySelector('#pm-lucky-btn');
        const display = block.querySelector('#pm-lucky-display');
        const msg = block.querySelector('#pm-lucky-msg');
        const resetBtn = block.querySelector('#pm-lucky-reset');
        
        const calculateLuckyNumber = (name) => {
            // Get today's date string (e.g. "2023-10-25")
            const today = new Date().toISOString().split('T')[0];
            
            // Combine name and date to make it unique per person per day
            const combined = name.toLowerCase().trim() + today;
            
            // Simple hash
            let hash = 0;
            for (let i = 0; i < combined.length; i++) {
                hash = combined.charCodeAt(i) + ((hash << 5) - hash);
            }
            
            // Convert to 1-9
            let num = Math.abs(hash) % 9 + 1;
            return num;
        };
        
        btn.addEventListener('click', () => {
            const name = nameInput.value.trim();
            if (!name) {
                // simple shake animation if empty
                nameInput.style.transform = 'translateX(-10px)';
                setTimeout(() => nameInput.style.transform = 'translateX(10px)', 100);
                setTimeout(() => nameInput.style.transform = 'translateX(0)', 200);
                return;
            }
            
            const luckyNum = calculateLuckyNumber(name);
            display.textContent = luckyNum;
            msg.textContent = messages[luckyNum];
            
            setupDiv.classList.add('hidden');
            resultDiv.classList.remove('hidden');
            
            // pop animation
            display.style.transform = 'scale(0.5)';
            display.style.opacity = '0';
            setTimeout(() => {
                display.style.transition = 'all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                display.style.transform = 'scale(1)';
                display.style.opacity = '1';
            }, 50);
        });
        
        resetBtn.addEventListener('click', () => {
            resultDiv.classList.add('hidden');
            setupDiv.classList.remove('hidden');
            nameInput.value = '';
            nameInput.focus();
        });
        
        // Enter key support
        nameInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                btn.click();
            }
        });
    });
});
