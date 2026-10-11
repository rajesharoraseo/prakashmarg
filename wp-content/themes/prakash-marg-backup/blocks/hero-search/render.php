<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="w-full max-w-4xl mx-auto text-center py-20 px-4">
    <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6 drop-shadow-lg tracking-tight" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
        Timeless Wisdom of Sanatan Dharma
    </h1>
    <p class="text-xl md:text-2xl text-gray-200 mb-10 drop-shadow-md" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.8);">
        Explore sacred temples, divine deities, ancient scriptures, and profound teachings.
    </p>

    <!-- Search Form — uses WordPress native /?s= search -->
    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-2xl mx-auto" role="search">
        <label for="pm-global-search" class="sr-only">Search Prakash Marg</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <!-- name="s" is WordPress native search parameter -->
            <input type="search" id="pm-global-search" name="s" class="w-full p-4 pl-12 text-lg text-gray-900 bg-white bg-opacity-95 rounded-full border border-transparent focus:ring-4 focus:ring-amber-500 focus:border-amber-500 shadow-xl placeholder-gray-500 transition duration-300 outline-none" placeholder="Search Temples, Scriptures, Saints..." required>
        </div>
        <button type="submit" class="text-white bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-bold rounded-full text-lg px-8 py-4 text-center shadow-lg transform transition duration-300 hover:scale-105 whitespace-nowrap border-none">
            Explore Now
        </button>
    </form>

    <!-- Quick Navigation Pills -->
    <div class="flex flex-wrap justify-center gap-3 mt-8">
        <a href="<?php echo esc_url( home_url( '/pm_temple' ) ); ?>" class="pm-quick-pill">🛕 Temples</a>
        <a href="<?php echo esc_url( home_url( '/pm_deity' ) ); ?>" class="pm-quick-pill">🙏 Deities</a>
        <a href="<?php echo esc_url( home_url( '/pm_scripture' ) ); ?>" class="pm-quick-pill">📖 Scriptures</a>
        <a href="<?php echo esc_url( home_url( '/pm_saint' ) ); ?>" class="pm-quick-pill">🧘 Saints</a>
        <a href="<?php echo esc_url( home_url( '/pm_festival' ) ); ?>" class="pm-quick-pill">🪔 Festivals</a>
    </div>
</div>
