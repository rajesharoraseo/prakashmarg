import os
import glob
import re

directory = r"c:\PrakashMarg"
html_files = glob.glob(os.path.join(directory, "*.html"))

for file_path in html_files:
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()

    original_content = content

    # 1. Add theme.js to <head>
    if '<script src="assets/js/theme.js"></script>' not in content:
        content = content.replace("</head>", '    <script src="assets/js/theme.js"></script>\n</head>')

    # 2. Update body classes
    if 'dark:bg-navy' not in content:
        content = content.replace('bg-cream ', 'bg-cream dark:bg-navy ')
        content = content.replace('text-darkbrown ', 'text-darkbrown dark:text-cream ')
        
    # 3. Update header classes for dark mode
    content = content.replace('bg-cream/90', 'bg-cream/90 dark:bg-navy/90')
    content = content.replace('bg-white ', 'bg-white dark:bg-navy-light ')
    content = content.replace('text-darkbrown ', 'text-darkbrown dark:text-cream ')
    content = content.replace('text-darkbrown-', 'text-darkbrown dark:text-cream-') # this might be messy, let's be careful.
    
    # Let's do a more targeted header dark mode:
    # Actually, tailwind allows chaining.
    
    # 4. Add Theme Toggle Button
    toggle_btn_html = '''
                <div class="flex items-center gap-2">
                    <button id="theme-toggle" aria-label="Toggle Dark Mode" class="p-2 rounded-full bg-sandalwood/10 dark:bg-navy-light text-darkbrown dark:text-gold hover:bg-sandalwood/30 transition-colors">
                        <span id="theme-toggle-light-icon" class="hidden">🌞</span>
                        <span id="theme-toggle-dark-icon">🌙</span>
                    </button>
                    <div class="md:hidden flex items-center">
                        <button id="mobile-menu-btn"'''
                        
    if 'theme-toggle' not in content:
        content = content.replace(
            '''                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn"''',
            toggle_btn_html
        )
        
        # Add the closing div
        close_target = '''                    </button>
                </div>
            </div>
        </div>'''
        close_replacement = '''                    </button>
                    </div>
                </div>
            </div>
        </div>'''
        content = content.replace(close_target, close_replacement)

    # 5. Fix mobile menu dark mode
    if 'id="mobile-menu"' in content:
        content = content.replace(
            'id="mobile-menu" class="hidden md:hidden bg-white',
            'id="mobile-menu" class="hidden md:hidden bg-white dark:bg-navy-light'
        )

    # Write back if changed
    if content != original_content:
        with open(file_path, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"Updated {os.path.basename(file_path)}")

print("Done.")
