<?php
/**
 * Render for pm/lucky-number block.
 */

$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-lucky-number max-w-sm mx-auto my-8']);
$theme_uri = get_template_directory_uri();
?>
<div <?php echo $wrapper_attributes; ?>>
    <div class="bg-gradient-to-br from-indigo-500 to-purple-700 rounded-3xl p-8 shadow-2xl text-center relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full blur-xl transform -translate-x-1/2 translate-y-1/2"></div>
        
        <h3 class="text-white text-xl font-bold mb-1">Today's Lucky Number</h3>
        <p class="text-indigo-100 text-sm mb-6 opacity-90">Find your numerology for the day</p>
        
        <div id="pm-lucky-setup" class="mb-4">
            <input type="text" id="pm-lucky-name" placeholder="Enter your first name" class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-white/50 text-center mb-4 transition-all">
            <button id="pm-lucky-btn" class="w-full py-3 bg-white text-indigo-700 rounded-xl font-bold hover:bg-indigo-50 transition-colors shadow-lg">Reveal Number</button>
        </div>
        
        <div id="pm-lucky-result" class="hidden">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-inner inline-block">
                <div id="pm-lucky-display" class="text-7xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-indigo-200 drop-shadow-sm">7</div>
            </div>
            <p id="pm-lucky-msg" class="text-indigo-100 text-sm mt-4 leading-relaxed font-medium"></p>
            <button id="pm-lucky-reset" class="mt-6 text-white/60 hover:text-white text-xs underline underline-offset-2 transition-colors">Try another name</button>
        </div>
    </div>
</div>

<script src="<?php echo esc_url($theme_uri . '/blocks/lucky-number/lucky.js'); ?>" defer></script>
