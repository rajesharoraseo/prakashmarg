<?php
if (!function_exists('pm_core')) return;

$templeService = pm_core()->get('temple_service');
if (!$templeService) return;

$temples = $templeService->getFeatured(4);
?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 border-l-4 border-amber-500 pl-4">Sacred Temples</h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'pm_temple' ) ?: home_url( '/?post_type=pm_temple' ) ); ?>" class="text-amber-600 hover:text-amber-700 font-semibold flex items-center gap-1 transition-colors">
            View All
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($temples as $temple): ?>
            <a href="<?php echo get_permalink($temple->id); ?>" class="group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                    <?php if (has_post_thumbnail($temple->id)): ?>
                        <?php echo get_the_post_thumbnail($temple->id, 'medium', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110']); ?>
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-amber-100 to-orange-50"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-6xl opacity-20 text-amber-600">🛕</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors"><?php echo esc_html($temple->title); ?></h3>
                    <?php if (!empty($temple->metadata['location'])): ?>
                        <p class="text-sm text-gray-500 flex items-center gap-1 border-t border-gray-50 pt-2 mt-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <?php echo esc_html($temple->metadata['location']); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
