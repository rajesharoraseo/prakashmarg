<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id = get_the_ID();
$title = get_the_title();
$audio_url = get_post_meta($post_id, 'pm_audio_url', true);
?>
<div class="pm-reading-toolbar" id="chalisa-audio" style="display:flex; justify-content:space-between; align-items:center; background:#fff; border:1px solid var(--bdl); border-radius:12px; padding:12px 20px; box-shadow:0 2px 10px rgba(0,0,0,0.02); margin-bottom:24px; flex-wrap:wrap; gap:16px;">
    
    <!-- Audio Player (Fake UI for now as requested by user to look like screenshot) -->
    <div style="display:flex; align-items:center; gap:12px; flex:1; min-width:250px;">
        <button style="width:40px; height:40px; border-radius:50%; background:var(--gd); color:#fff; border:none; display:flex; align-items:center; justify-content:center; cursor:pointer;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
        </button>
        <div style="flex:1;">
            <div style="font-size:12px; font-weight:bold; color:var(--gd); margin-bottom:4px;"><?php echo $title; ?> (संपूर्ण पाठ)</div>
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:10px; color:var(--txm);">0:00 / 12:28</span>
                <div style="flex:1; height:4px; background:var(--iv); border-radius:2px; position:relative;">
                    <div style="width:0%; height:100%; background:var(--gd); border-radius:2px;"></div>
                    <div style="width:8px; height:8px; background:var(--gd); border-radius:50%; position:absolute; top:-2px; left:0;"></div>
                </div>
            </div>
        </div>
        <div style="color:var(--txm); cursor:pointer;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>
        </div>
        <div style="color:var(--txm); cursor:pointer;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.06-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.73,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.06,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.49-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></svg>
        </div>
    </div>

    <!-- Controls -->
    <div style="display:flex; gap:16px; align-items:center;">
        <!-- Font Size -->
        <div style="display:flex; border:1px solid var(--bdl); border-radius:6px; overflow:hidden;">
            <button onclick="document.querySelector('.pm-ornate-frame').style.fontSize='16px'" style="background:#fff; border:none; border-right:1px solid var(--bdl); padding:4px 10px; cursor:pointer; font-size:12px; color:var(--tx);">A-</button>
            <button onclick="document.querySelector('.pm-ornate-frame').style.fontSize='20px'" style="background:var(--iv); border:none; border-right:1px solid var(--bdl); padding:4px 10px; cursor:pointer; font-size:14px; font-weight:bold; color:var(--tx);">A</button>
            <button onclick="document.querySelector('.pm-ornate-frame').style.fontSize='24px'" style="background:#fff; border:none; padding:4px 10px; cursor:pointer; font-size:16px; color:var(--tx);">A+</button>
        </div>
        <!-- Meaning Toggle -->
        <button style="background:var(--iv); border:1px solid var(--go); color:var(--go); padding:6px 12px; border-radius:6px; font-size:13px; font-weight:bold; cursor:pointer; display:flex; align-items:center; gap:6px;">
            <span style="font-size:16px;">✨</span> अर्थ दिखाएँ
        </button>
        <!-- PDF Download -->
        <a href="#" style="background:var(--gd); border:1px solid var(--gd); color:#fff; padding:6px 12px; border-radius:6px; font-size:13px; font-weight:bold; cursor:pointer; display:flex; align-items:center; gap:6px; text-decoration:none; transition:background 0.3s;" onmouseover="this.style.background='var(--gm)';" onmouseout="this.style.background='var(--gd)';">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg> PDF डाउनलोड
        </a>
    </div>
</div>
