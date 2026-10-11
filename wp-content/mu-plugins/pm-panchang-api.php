<?php
/**
 * Direct standalone REST endpoint for Panchang — bypasses Core boot chain.
 * Registers /pm/v1/tools/panchang directly on rest_api_init.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'rest_api_init', function () {
    register_rest_route( 'pm/v1', '/tools/panchang', [
        'methods'             => 'GET',
        'callback'            => 'pm_panchang_handler',
        'permission_callback' => '__return_true',
    ] );
} );

function pm_panchang_handler( WP_REST_Request $request ) {
    $today = current_time( 'timestamp' );
    $day   = (int) date( 'j', $today );
    $month = (int) date( 'n', $today );

    $tithis = [
        'प्रतिपदा','द्वितीया','तृतीया','चतुर्थी','पंचमी',
        'षष्ठी','सप्तमी','अष्टमी','नवमी','दशमी',
        'एकादशी','द्वादशी','त्रयोदशी','चतुर्दशी','पूर्णिमा',
    ];
    $tithi   = $tithis[ $day % 15 ];
    $paksha  = ( $day <= 15 ) ? 'शुक्ल पक्ष' : 'कृष्ण पक्ष';

    $hindi_months = [
        1=>'माघ', 2=>'फाल्गुन', 3=>'चैत्र', 4=>'वैशाख',
        5=>'ज्येष्ठ', 6=>'आषाढ़', 7=>'श्रावण', 8=>'भाद्रपद',
        9=>'आश्विन', 10=>'कार्तिक', 11=>'मार्गशीर्ष', 12=>'पौष',
    ];
    $masa = $hindi_months[ $month ] ?? 'आश्विन';

    $nakshatras = [
        'अश्विनी','भरणी','कृत्तिका','रोहिणी','मृगशिरा','आर्द्रा','पुनर्वसु',
        'पुष्य','आश्लेषा','मघा','पूर्व फाल्गुनी','उत्तर फाल्गुनी','हस्त',
        'चित्रा','स्वाति','विशाखा','अनुराधा','ज्येष्ठा','मूल','पूर्वाषाढ़ा',
        'उत्तराषाढ़ा','श्रवण','धनिष्ठा','शतभिषा','पूर्व भाद्रपद','उत्तर भाद्रपद','रेवती',
    ];
    $nakshatra = $nakshatras[ ( $day * 3 + $month * 7 ) % 27 ];

    $yogas = [
        'विष्कम्भ','प्रीति','आयुष्मान','सौभाग्य','शोभन','अतिगण्ड','सुकर्मा',
        'धृति','शूल','गण्ड','वृद्धि','ध्रुव','व्याघात','हर्षण','वज्र',
        'सिद्धि','व्यतीपात','वरीयान','परिघ','शिव','सिद्ध','साध्य',
        'शुभ','शुक्ल','ब्रह्म','इन्द्र','वैधृति',
    ];
    $yoga = $yogas[ ( $day + $month * 2 ) % 27 ];

    $karanas = ['बव','बालव','कौलव','तैतिल','गर','वणिज','विष्टि','किंस्तुघ्न'];
    $karana  = $karanas[ $day % 8 ];

    $vara_map = [
        'Sunday'=>'रविवार','Monday'=>'सोमवार','Tuesday'=>'मंगलवार',
        'Wednesday'=>'बुधवार','Thursday'=>'गुरुवार','Friday'=>'शुक्रवार','Saturday'=>'शनिवार',
    ];
    $vara = $vara_map[ date( 'l', $today ) ] ?? date( 'l', $today );

    $lat = floatval( $request->get_param( 'lat' ) ?: 28.6139 );
    $lon = floatval( $request->get_param( 'lon' ) ?: 77.2090 );
    $sun = date_sun_info( $today, $lat, $lon );

    $offset  = 19800; // +5:30 IST in seconds
    $sunrise = date( 'h:i A', $sun['sunrise'] + $offset );
    $sunset  = date( 'h:i A', $sun['sunset']  + $offset );

    $rahu_table = [
        'Sunday'    => ['04:30 PM','06:00 PM'],
        'Monday'    => ['07:30 AM','09:00 AM'],
        'Tuesday'   => ['03:00 PM','04:30 PM'],
        'Wednesday' => ['12:00 PM','01:30 PM'],
        'Thursday'  => ['01:30 PM','03:00 PM'],
        'Friday'    => ['10:30 AM','12:00 PM'],
        'Saturday'  => ['09:00 AM','10:30 AM'],
    ];
    $rahu = $rahu_table[ date( 'l', $today ) ] ?? ['12:00 PM','01:30 PM'];

    return rest_ensure_response( [
        'vikramSamvat'   => 2083,
        'masa'           => $masa,
        'paksha'         => $paksha,
        'tithi'          => $tithi,
        'nakshatra'      => $nakshatra,
        'yoga'           => $yoga,
        'karana'         => $karana,
        'vara'           => $vara,
        'sunrise'        => $sunrise,
        'sunset'         => $sunset,
        'rahukaal'       => [ 'start' => $rahu[0], 'end' => $rahu[1] ],
        'abhijitMuhurta' => [ 'start' => '11:45 AM', 'end' => '12:35 PM' ],
    ] );
}
