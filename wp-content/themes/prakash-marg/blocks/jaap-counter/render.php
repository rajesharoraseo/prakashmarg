<?php
/**
 * Render for pm/jaap-counter block.
 */

$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-jaap-counter max-w-sm mx-auto my-8']);
$theme_uri = get_template_directory_uri();
?>
<div <?php echo $wrapper_attributes; ?>>
    <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl p-8 shadow-2xl text-center relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-white opacity-10 rounded-full blur-xl"></div>
        
        <h3 class="text-white text-xl font-bold mb-1">Digital Jaap</h3>
        <p class="text-orange-100 text-sm mb-6 opacity-90">Count your mantras daily</p>
        
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 mb-8 border border-white/20 shadow-inner">
            <div id="pm-jaap-display" class="text-6xl font-black text-white tabular-nums drop-shadow-md">0</div>
            <div class="text-orange-200 text-xs mt-2 uppercase tracking-widest font-semibold">Total Count</div>
        </div>
        
        <button id="pm-jaap-btn" class="w-24 h-24 rounded-full bg-white text-orange-600 text-3xl shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 active:bg-orange-50 transition-all duration-200 mx-auto flex items-center justify-center font-bold focus:outline-none focus:ring-4 focus:ring-orange-300 focus:ring-opacity-50">
            +1
        </button>
        
        <div class="mt-6 text-center">
            <button id="pm-jaap-reset" class="text-white/60 hover:text-white text-sm underline underline-offset-2 transition-colors">Reset Counter</button>
        </div>
    </div>
</div>

<script src="<?php echo esc_url($theme_uri . '/blocks/jaap-counter/counter.js'); ?>" defer></script>
