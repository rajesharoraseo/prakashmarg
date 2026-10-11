<?php
namespace PrakashMarg\Core\Api;

class ToolsEndpoint {
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('pm/v1', '/tools/panchang', [
            'methods'             => 'GET',
            'callback'            => [$this, 'get_panchang'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function get_panchang(\WP_REST_Request $request) {
        $today = current_time('timestamp');
        $day   = (int) date('j', $today);
        $month = (int) date('n', $today);

        // Tithi calculation (Epoch: Oct 5, 2026 is Ashwin Krishna Dashami)
        $tithis = [
            'प्रतिपदा', 'द्वितीया', 'तृतीया', 'चतुर्थी', 'पंचमी',
            'षष्ठी', 'सप्तमी', 'अष्टमी', 'नवमी', 'दशमी',
            'एकादशी', 'द्वादशी', 'त्रयोदशी', 'चतुर्दशी', 'पूर्णिमा/अमावस्या'
        ];
        
        $ref_date = new \DateTime('2026-10-05');
        $curr_date = new \DateTime(date('Y-m-d', $today));
        $diff = (int) $ref_date->diff($curr_date)->format('%R%a');

        // Base tithi on Oct 5 is Dashami (index 9) of Krishna Paksha (paksha=1) -> absolute index 24 (15 + 9)
        $abs_tithi = (24 + $diff) % 30;
        if ($abs_tithi < 0) $abs_tithi += 30;

        $paksha_val = floor($abs_tithi / 15); // 0 = Shukla, 1 = Krishna
        $tithi_val = $abs_tithi % 15;

        $paksha = ($paksha_val == 0) ? 'शुक्ल पक्ष' : 'कृष्ण पक्ष';
        $tithi = $tithis[$tithi_val];
        if ($tithi_val == 14) {
            $tithi = ($paksha_val == 0) ? 'पूर्णिमा' : 'अमावस्या';
        }

        // Hindi month names
        $hindi_months = [
            1  => 'चैत्र',    2  => 'वैशाख',   3  => 'ज्येष्ठ',
            4  => 'आषाढ़',    5  => 'श्रावण',  6  => 'भाद्रपद',
            7  => 'आश्विन',   8  => 'कार्तिक', 9  => 'मार्गशीर्ष',
            10 => 'पौष',      11 => 'माघ',     12 => 'फाल्गुन',
        ];
        
        // Base month on Oct 5 is Ashwin (index 7)
        $masa_offset = floor((24 + $diff) / 30);
        $masa_idx = (7 + $masa_offset - 1) % 12 + 1;
        if ($masa_idx <= 0) $masa_idx += 12;
        $masa = $hindi_months[$masa_idx] ?? 'आश्विन';

        // Nakshatra (27 nakshatras, rough cycle, base Pushya = index 7)
        $nakshatras = [
            'अश्विनी', 'भरणी', 'कृत्तिका', 'रोहिणी', 'मृगशिरा',
            'आर्द्रा', 'पुनर्वसु', 'पुष्य', 'आश्लेषा', 'मघा',
            'पूर्व फाल्गुनी', 'उत्तर फाल्गुनी', 'हस्त', 'चित्रा', 'स्वाति',
            'विशाखा', 'अनुराधा', 'ज्येष्ठा', 'मूल', 'पूर्वाषाढ़ा',
            'उत्तराषाढ़ा', 'श्रवण', 'धनिष्ठा', 'शतभिषा', 'पूर्व भाद्रपद',
            'उत्तर भाद्रपद', 'रेवती'
        ];
        $nakshatra_index = (7 + $diff) % 27;
        if ($nakshatra_index < 0) $nakshatra_index += 27;
        $nakshatra = $nakshatras[$nakshatra_index];

        // Yoga (base Ayushman = index 2)
        $yogas = [
            'विष्कम्भ', 'प्रीति', 'आयुष्मान', 'सौभाग्य', 'शोभन',
            'अतिगण्ड', 'सुकर्मा', 'धृति', 'शूल', 'गण्ड',
            'वृद्धि', 'ध्रुव', 'व्याघात', 'हर्षण', 'वज्र',
            'सिद्धि', 'व्यतीपात', 'वरीयान', 'परिघ', 'शिव',
            'सिद्ध', 'साध्य', 'शुभ', 'शुक्ल', 'ब्रह्म',
            'इन्द्र', 'वैधृति'
        ];
        $yoga_index = (2 + $diff) % 27;
        if ($yoga_index < 0) $yoga_index += 27;
        $yoga = $yogas[$yoga_index];

        // Karana
        $karanas = ['बव', 'बालव', 'कौलव', 'तैतिल', 'गर', 'वणिज', 'विष्टि', 'किंस्तुघ्न'];
        $karana  = $karanas[$day % 8];

        // Vara (day of week in Hindi)
        $vara_map = ['Sunday' => 'रविवार', 'Monday' => 'सोमवार', 'Tuesday' => 'मंगलवार', 'Wednesday' => 'बुधवार', 'Thursday' => 'गुरुवार', 'Friday' => 'शुक्रवार', 'Saturday' => 'शनिवार'];
        $vara     = $vara_map[date('l', $today)] ?? date('l', $today);

        // Sunrise/Sunset (approximate for Delhi, could add lat/lon based calc)
        $lat = floatval($request->get_param('lat') ?: 28.6139);
        $lon = floatval($request->get_param('lon') ?: 77.2090);

        // Simple sunrise approximation using PHP date_sun_info
        $sun_info  = date_sun_info($today, $lat, $lon);
        $sunrise   = date('h:i A', $sun_info['sunrise'] + 19800); // +5:30 IST
        $sunset    = date('h:i A', $sun_info['sunset'] + 19800);

        // Rahukaal by day (standard table for Delhi)
        $rahukaal_table = [
            'Sunday'    => ['04:30 PM', '06:00 PM'],
            'Monday'    => ['07:30 AM', '09:00 AM'],
            'Tuesday'   => ['03:00 PM', '04:30 PM'],
            'Wednesday' => ['12:00 PM', '01:30 PM'],
            'Thursday'  => ['01:30 PM', '03:00 PM'],
            'Friday'    => ['10:30 AM', '12:00 PM'],
            'Saturday'  => ['09:00 AM', '10:30 AM'],
        ];
        $day_name = date('l', $today);
        $rahu     = $rahukaal_table[$day_name] ?? ['12:00 PM', '01:30 PM'];

        // Abhijit Muhurta (approx 11:45 AM – 12:35 PM)
        $abhijit = ['start' => '11:45 AM', 'end' => '12:35 PM'];

        return rest_ensure_response([
            'vikramSamvat'    => 2083,
            'masa'            => $masa,
            'paksha'          => $paksha,
            'tithi'           => $tithi,
            'nakshatra'       => $nakshatra,
            'yoga'            => $yoga,
            'karana'          => $karana,
            'vara'            => $vara,
            'sunrise'         => $sunrise,
            'sunset'          => $sunset,
            'rahukaal'        => ['start' => $rahu[0], 'end' => $rahu[1]],
            'abhijitMuhurta'  => $abhijit,
        ]);
    }
}
