<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-section']);
?>
<section <?php echo $wrapper_attributes; ?> style="background-color: var(--wp--preset--color--deep-indigo); color: #fff; padding-block: 6rem; text-align: center;">
    <div class="pm-container" style="max-width: 800px;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.3; margin-bottom: 2rem;"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"></path><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.999v2.993c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"></path></svg>
        <blockquote style="margin: 0;">
            <p style="font-family: var(--wp--preset--font-family--display-serif); font-size: clamp(1.5rem, 3vw, 2.5rem); line-height: 1.4; margin-bottom: 2rem;">"You have the right to perform your prescribed duty, but you are not entitled to the fruits of action."</p>
            <footer style="font-size: var(--wp--preset--font-size--medium); opacity: 0.8;">&mdash; Bhagavad Gita, Chapter 2, Verse 47</footer>
        </blockquote>
    </div>
</section>
