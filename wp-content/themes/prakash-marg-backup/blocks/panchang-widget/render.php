<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Get India Standard Time
$tz      = new DateTimeZone( 'Asia/Kolkata' );
$now     = new DateTime( 'now', $tz );

// Tithi names (approximate cycle based on lunar day)
$tithis = [
    'Pratipada','Dwitiya','Tritiya','Chaturthi','Panchami',
    'Shashthi','Saptami','Ashtami','Navami','Dashami',
    'Ekadashi','Dwadashi','Trayodashi','Chaturdashi','Purnima / Amavasya'
];
// Moon-phase approximation (days since known new moon 2000-01-06)
$ref    = new DateTime( '2000-01-06', $tz );
$diff   = $now->diff($ref)->days;
$lunar  = fmod( $diff, 29.53059 );
$tithi  = $tithis[ (int)( $lunar / 29.53059 * 15 ) ] ?? 'Purnima';

$paksha     = $lunar < 14.77 ? 'Shukla Paksha' : 'Krishna Paksha';
$day_hindi  = ['Ravivaar','Somvaar','Mangalvaar','Budhvaar','Guruvaar','Shukravaar','Shanivaar'][ $now->format('w') ];

// Nakshatra names for display
$nakshatras = [
    'Ashwini','Bharani','Krittika','Rohini','Mrigashira','Ardra','Punarvasu',
    'Pushya','Ashlesha','Magha','Purva Phalguni','Uttara Phalguni','Hasta',
    'Chitra','Swati','Vishakha','Anuradha','Jyeshtha','Mula','Purva Ashadha',
    'Uttara Ashadha','Shravana','Dhanishtha','Shatabhisha','Purva Bhadrapada',
    'Uttara Bhadrapada','Revati'
];
$nakshatra = $nakshatras[ (int)( fmod($diff, 27.32) / 27.32 * 27 ) ] ?? 'Rohini';

// Rahu Kaal fixed times by weekday (Sun=0 … Sat=6)
$rahu_kaal = [
    '4:30–6:00 PM', '7:30–9:00 AM', '3:00–4:30 PM', '12:00–1:30 PM',
    '1:30–3:00 PM',  '10:30 AM–12:00 PM', '9:00–10:30 AM'
];
$rk = $rahu_kaal[ $now->format('w') ];

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'pm-panchang-widget' ] );
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="pm-panchang-inner">

        <div class="pm-panchang-header">
            <span class="pm-panchang-om">🕉️</span>
            <div>
                <h3 class="pm-panchang-title">Today's Panchang</h3>
                <p class="pm-panchang-date"><?php echo esc_html( $day_hindi . ', ' . $now->format( 'j F Y' ) ); ?></p>
            </div>
        </div>

        <div class="pm-panchang-grid">
            <div class="pm-panch-item">
                <span class="pm-panch-label">Tithi</span>
                <span class="pm-panch-value"><?php echo esc_html( $tithi ); ?></span>
            </div>
            <div class="pm-panch-item">
                <span class="pm-panch-label">Paksha</span>
                <span class="pm-panch-value"><?php echo esc_html( $paksha ); ?></span>
            </div>
            <div class="pm-panch-item">
                <span class="pm-panch-label">Nakshatra</span>
                <span class="pm-panch-value"><?php echo esc_html( $nakshatra ); ?></span>
            </div>
            <div class="pm-panch-item pm-panch-rahu">
                <span class="pm-panch-label">⚠️ Rahu Kaal</span>
                <span class="pm-panch-value"><?php echo esc_html( $rk ); ?></span>
            </div>
        </div>

        <p class="pm-panchang-note">* Approximate values. Consult a priest for precise muhurtas.</p>
    </div>
</div>
