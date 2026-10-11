<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Curated shlokas and Hindi quotes
$shlokas = [
    [
        'text'        => "कर्मण्येवाधिकारस्ते मा फलेषु कदाचन।\nमा कर्मफलहेतुर्भूर्मा ते सङ्गोऽस्त्वकर्मणि।।",
        'translation' => 'कर्म करना तुम्हारा अधिकार है, फल की चिंता मत करो।',
        'source'      => 'भगवद्गीता 2.47',
        'icon'        => '📖',
    ],
    [
        'text'        => 'सत्यमेव जयते नानृतं।',
        'translation' => 'सत्य की सदा विजय होती है, असत्य की नहीं।',
        'source'      => 'मुण्डक उपनिषद 3.1.6',
        'icon'        => '✨',
    ],
    [
        'text'        => 'सर्वे भवन्तु सुखिनः। सर्वे सन्तु निरामयाः।',
        'translation' => 'सभी सुखी हों, सभी रोगमुक्त हों, किसी को दुख न हो।',
        'source'      => 'बृहदारण्यक उपनिषद',
        'icon'        => '🙏',
    ],
    [
        'text'        => "ॐ असतो मा सद्गमय।\nतमसो मा ज्योतिर्गमय।\nमृत्योर्मा अमृतं गमय।",
        'translation' => 'अंधकार से प्रकाश की ओर, मृत्यु से अमरता की ओर ले चलो।',
        'source'      => 'बृहदारण्यक उपनिषद 1.3.28',
        'icon'        => '🕉️',
    ],
    [
        'text'        => 'ढाई आखर प्रेम का, पढ़े सो पण्डित होय।',
        'translation' => 'जो प्रेम के ढाई अक्षर पढ़ ले, वही सच्चा विद्वान है।',
        'source'      => 'कबीर दास',
        'icon'        => '❤️',
    ],
    [
        'text'        => 'मन के हारे हार है, मन के जीते जीत।',
        'translation' => 'मन से हारना सच्ची हार है और मन से जीतना सच्ची जीत।',
        'source'      => 'कबीर दास',
        'icon'        => '💪',
    ],
    [
        'text'        => 'अपना दीपक स्वयं बनो।',
        'translation' => 'अपना मार्गदर्शन स्वयं करो, दूसरों पर निर्भर मत रहो।',
        'source'      => 'गौतम बुद्ध',
        'icon'        => '🪔',
    ],
    [
        'text'        => 'विद्या विनयेन शोभते।',
        'translation' => 'विद्या विनम्रता से शोभती है।',
        'source'      => 'चाणक्य',
        'icon'        => '🎓',
    ],
    [
        'text'        => 'यत्र नार्यस्तु पूज्यन्ते, रमन्ते तत्र देवताः।',
        'translation' => 'जहाँ नारी का सम्मान होता है, वहाँ देवता निवास करते हैं।',
        'source'      => 'मनुस्मृति 3.56',
        'icon'        => '🌸',
    ],
    [
        'text'        => 'सेवा परमो धर्मः।',
        'translation' => 'सेवा ही सबसे बड़ा धर्म है।',
        'source'      => 'महाभारत',
        'icon'        => '🤲',
    ],
];


// Pick one based on the day of year for daily rotation
$day_of_year = (int) ( new DateTime( 'now', new DateTimeZone( 'Asia/Kolkata' ) ) )->format( 'z' );
$shloka      = $shlokas[ $day_of_year % count( $shlokas ) ];

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'pm-daily-wisdom' ] );
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="pm-wisdom-inner">
        <div class="pm-wisdom-header">
            <span class="pm-wisdom-icon"><?php echo esc_html( $shloka['icon'] ); ?></span>
            <div>
                <h3 class="pm-wisdom-title">💬 आज का सुविचार</h3>
                <p class="pm-wisdom-source"><?php echo esc_html( $shloka['source'] ); ?></p>
            </div>
        </div>
        <blockquote class="pm-wisdom-shloka" lang="sa" dir="ltr">
            <?php echo nl2br( esc_html( $shloka['text'] ) ); ?>
        </blockquote>
        <p class="pm-wisdom-translation">
            <?php echo esc_html( $shloka['translation'] ); ?>
        </p>
        <div class="pm-wisdom-share">
            <a href="/quote" style="font-size:13px;color:rgba(255,255,255,.7);text-decoration:none;font-weight:600">सभी सुविचार →</a>
            <button onclick="navigator.share ? navigator.share({title:'आज का सुविचार',text:this.closest('.pm-daily-wisdom').querySelector('.pm-wisdom-shloka').innerText}) : undefined" class="pm-wisdom-share-btn" title="Share this shloka">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                शेयर
            </button>
        </div>
    </div>
</div>
