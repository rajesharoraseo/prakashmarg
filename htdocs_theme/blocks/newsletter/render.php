<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wrapper_attributes = get_block_wrapper_attributes(['class' => 'pm-section']);
?>
<section <?php echo $wrapper_attributes; ?> style="background-color: var(--color-surface-elevated); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
    <div class="pm-container" style="max-width: 600px; text-align: center;">
        <h2 style="font-size: var(--wp--preset--font-size--x-large); margin-bottom: 1rem;">Receive Weekly Wisdom</h2>
        <p style="color: var(--color-text-secondary); margin-bottom: 2rem;">Join our community to receive gentle insights, upcoming festival reminders, and selected verses delivered to your inbox.</p>
        
        <form style="display: flex; gap: 8px; flex-wrap: wrap;">
            <input class="pm-input" type="email" placeholder="Your email address" aria-label="Email address" style="flex: 1; min-width: 250px;">
            <button class="pm-btn pm-btn-primary" type="button" style="flex-shrink: 0;">Subscribe</button>
        </form>
        <p style="font-size: var(--wp--preset--font-size--small); color: var(--color-text-muted); margin-top: 1rem; margin-bottom: 0;">We respect your privacy. No spam, ever.</p>
    </div>
</section>
