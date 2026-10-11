/**
 * PrakashMarg Panchang Calculator
 * Pure JavaScript astronomical calculations for Hindu Panchang
 * Calculates: Tithi, Nakshatra, Yoga, Karana, Sunrise, Sunset, Rahukaal
 */

const Panchang = (() => {

  // ─── Constants ───────────────────────────────────────────────────────────
  const TITHI_NAMES = [
    'प्रतिपदा','द्वितीया','तृतीया','चतुर्थी','पञ्चमी',
    'षष्ठी','सप्तमी','अष्टमी','नवमी','दशमी',
    'एकादशी','द्वादशी','त्रयोदशी','चतुर्दशी','पूर्णिमा',
    'प्रतिपदा','द्वितीया','तृतीया','चतुर्थी','पञ्चमी',
    'षष्ठी','सप्तमी','अष्टमी','नवमी','दशमी',
    'एकादशी','द्वादशी','त्रयोदशी','चतुर्दशी','अमावस्या'
  ];

  const NAKSHATRA_NAMES = [
    'अश्विनी','भरणी','कृत्तिका','रोहिणी','मृगशिरा',
    'आर्द्रा','पुनर्वसु','पुष्य','आश्लेषा','मघा',
    'पूर्वाफाल्गुनी','उत्तराफाल्गुनी','हस्त','चित्रा','स्वाति',
    'विशाखा','अनुराधा','ज्येष्ठा','मूल','पूर्वाषाढ़ा',
    'उत्तराषाढ़ा','श्रवण','धनिष्ठा','शतभिषा','पूर्वाभाद्रपद',
    'उत्तराभाद्रपद','रेवती'
  ];

  const YOGA_NAMES = [
    'विष्कम्भ','प्रीति','आयुष्मान','सौभाग्य','शोभन',
    'अतिगण्ड','सुकर्मा','धृति','शूल','गण्ड',
    'वृद्धि','ध्रुव','व्याघात','हर्षण','वज्र',
    'सिद्धि','व्यतीपात','वरीयान','परिघ','शिव',
    'सिद्ध','साध्य','शुभ','शुक्ल','ब्रह्म',
    'इन्द्र','वैधृति'
  ];

  const KARANA_NAMES = [
    'बव','बालव','कौलव','तैतिल','गर',
    'वणिज','विष्टि','शकुनि','चतुष्पाद','नाग','किंस्तुघ्न'
  ];

  const VARA_NAMES = ['रविवार','सोमवार','मंगलवार','बुधवार','गुरुवार','शुक्रवार','शनिवार'];
  const VARA_NAMES_EN = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
  const MASA_NAMES = [
    'चैत्र','वैशाख','ज्येष्ठ','आषाढ़','श्रावण','भाद्रपद',
    'आश्विन','कार्तिक','मार्गशीर्ष','पौष','माघ','फाल्गुन'
  ];

  // Rahukaal by weekday (fraction of daylight): [start_fraction, end_fraction]
  const RAHUKAAL_TIMES = {
    0: [0.875, 1.0],   // Sunday: 7.5/8 to end
    1: [0.875, 1.0],   // Monday: 7.5/8 — will recompute properly
    2: null, 3: null, 4: null, 5: null, 6: null
  };

  // Rahukaal slot index by weekday (each day has 8 parts)
  const RAHUKAAL_SLOT = [8, 2, 7, 5, 6, 4, 3]; // Sun,Mon,Tue,Wed,Thu,Fri,Sat → slot number

  const SHUBH_MUHURAT_BY_VARA = [
    // [startHour, endHour] — simplified auspicious times
    { name: 'अभिजित मुहूर्त', start: 11, end: 12 }, // approx
  ];

  // ─── Julian Day Number ───────────────────────────────────────────────────
  function dateToJD(year, month, day, hour = 12) {
    const a = Math.floor((14 - month) / 12);
    const y = year + 4800 - a;
    const m = month + 12 * a - 3;
    let jdn = day + Math.floor((153 * m + 2) / 5) + 365 * y +
              Math.floor(y / 4) - Math.floor(y / 100) + Math.floor(y / 400) - 32045;
    return jdn - 0.5 + hour / 24;
  }

  // ─── Sun Position (simplified VSOP) ─────────────────────────────────────
  function getSunLongitude(jd) {
    const T = (jd - 2451545.0) / 36525;
    // Mean longitude
    let L0 = 280.46646 + 36000.76983 * T + 0.0003032 * T * T;
    // Mean anomaly
    let M = 357.52911 + 35999.05029 * T - 0.0001537 * T * T;
    M = toRad(M % 360);
    // Equation of center
    const C = (1.914602 - 0.004817 * T - 0.000014 * T * T) * Math.sin(M)
            + (0.019993 - 0.000101 * T) * Math.sin(2 * M)
            + 0.000289 * Math.sin(3 * M);
    let sunLon = (L0 + C) % 360;
    if (sunLon < 0) sunLon += 360;
    return sunLon;
  }

  // ─── Moon Position (simplified ELP) ─────────────────────────────────────
  function getMoonLongitude(jd) {
    const T = (jd - 2451545.0) / 36525;
    // Moon's mean longitude
    let L = 218.3164477 + 481267.88123421 * T - 0.0015786 * T * T;
    // Moon's mean anomaly
    let M_moon = 134.9633964 + 477198.8675055 * T + 0.0087414 * T * T;
    // Moon's argument of latitude
    let F = 93.2720950 + 483202.0175233 * T - 0.0036539 * T * T;
    // Sun's mean anomaly
    let M_sun = 357.5291092 + 35999.0502909 * T - 0.0001536 * T * T;
    // Elongation of Moon from Sun
    let D = 297.8501921 + 445267.1114034 * T - 0.0018819 * T * T;

    M_moon = toRad(M_moon % 360);
    M_sun = toRad(M_sun % 360);
    F = toRad(F % 360);
    D = toRad(D % 360);

    // Major periodic terms (degrees)
    let dL = 6.288774 * Math.sin(M_moon)
            + 1.274027 * Math.sin(2 * D - M_moon)
            + 0.658314 * Math.sin(2 * D)
            + 0.213618 * Math.sin(2 * M_moon)
            - 0.185116 * Math.sin(M_sun)
            - 0.114332 * Math.sin(2 * F)
            + 0.058793 * Math.sin(2 * D - 2 * M_moon)
            + 0.057066 * Math.sin(2 * D - M_sun - M_moon)
            + 0.053322 * Math.sin(2 * D + M_moon)
            + 0.045758 * Math.sin(2 * D - M_sun);

    let moonLon = (L + dL) % 360;
    if (moonLon < 0) moonLon += 360;
    return moonLon;
  }

  // ─── Sunrise / Sunset (Meeus algorithm) ─────────────────────────────────
  function getSunriseSunset(date, lat, lon) {
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();

    const jd = dateToJD(year, month, day, 12);
    const T = (jd - 2451545.0) / 36525;

    // Solar coordinates
    let L0 = 280.46646 + 36000.76983 * T;
    let M = 357.52911 + 35999.05029 * T;
    M = toRad(M % 360);
    const C = 1.9146 * Math.sin(M) + 0.0200 * Math.sin(2 * M);
    const sunLon = toRad((L0 + C) % 360);

    // Declination
    const sinDec = Math.sin(toRad(23.439)) * Math.sin(sunLon);
    const dec = Math.asin(sinDec);

    // Hour angle
    const latRad = toRad(lat);
    const cosH = (Math.sin(toRad(-0.8333)) - Math.sin(latRad) * sinDec)
                / (Math.cos(latRad) * Math.cos(dec));

    if (Math.abs(cosH) > 1) {
      return { sunrise: '06:00', sunset: '18:00', sunriseMin: 360, sunsetMin: 1080 };
    }

    const H = toDeg(Math.acos(cosH));

    // Equation of time (simplified)
    const eot = (L0 % 360 - 0.0057183 - toDeg(Math.asin(sinDec)) * 0.9856 + C) * 4;

    // UTC offset from longitude
    const lonOffset = lon / 15 * 60; // minutes

    const sunriseUTC = 720 - H * 4 - eot + lonOffset;
    const sunsetUTC = 720 + H * 4 - eot + lonOffset;

    // IST = UTC + 5:30 = UTC + 330 min
    const IST_OFFSET = 330;
    const srIST = sunriseUTC + IST_OFFSET;
    const ssIST = sunsetUTC + IST_OFFSET;

    return {
      sunrise: minutesToTime(srIST),
      sunset: minutesToTime(ssIST),
      sunriseMin: srIST,
      sunsetMin: ssIST
    };
  }

  // ─── Rahukaal ────────────────────────────────────────────────────────────
  function getRahukaal(date, sunriseMin, sunsetMin) {
    const dow = date.getDay(); // 0=Sun
    const slot = RAHUKAAL_SLOT[dow]; // which 1/8th slot
    const totalDaylight = sunsetMin - sunriseMin;
    const slotDuration = totalDaylight / 8;

    const rahuStart = sunriseMin + (slot - 1) * slotDuration;
    const rahuEnd = rahuStart + slotDuration;

    return {
      start: minutesToTime(rahuStart),
      end: minutesToTime(rahuEnd)
    };
  }

  // ─── Abhijit Muhurta ─────────────────────────────────────────────────────
  function getAbhijitMuhurta(sunriseMin, sunsetMin) {
    const noon = (sunriseMin + sunsetMin) / 2;
    const muhurtaDuration = (sunsetMin - sunriseMin) / 15; // 1/15th of day
    return {
      start: minutesToTime(noon - muhurtaDuration / 2),
      end: minutesToTime(noon + muhurtaDuration / 2)
    };
  }

  // ─── Main Compute ────────────────────────────────────────────────────────
  function compute(date, lat = 28.6139, lon = 77.2090) {
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();

    // IST is UTC+5:30, use noon IST = 06:30 UTC
    const jdNoon = dateToJD(year, month, day, 6.5);

    const sunLon = getSunLongitude(jdNoon);
    const moonLon = getMoonLongitude(jdNoon);

    // ── Tithi ──
    let elongation = moonLon - sunLon;
    if (elongation < 0) elongation += 360;
    const tithiIndex = Math.floor(elongation / 12);
    const tithiName = TITHI_NAMES[tithiIndex] || TITHI_NAMES[0];
    const paksha = tithiIndex < 15 ? 'शुक्ल पक्ष' : 'कृष्ण पक्ष';

    // ── Nakshatra ──
    const nakshatraIndex = Math.floor(moonLon / (360 / 27));
    const nakshatraName = NAKSHATRA_NAMES[nakshatraIndex % 27];

    // ── Yoga ──
    let yogaLon = (sunLon + moonLon) % 360;
    const yogaIndex = Math.floor(yogaLon / (360 / 27));
    const yogaName = YOGA_NAMES[yogaIndex % 27];

    // ── Karana ──
    const karanaIndex = Math.floor(elongation / 6) % 11;
    const karanaName = KARANA_NAMES[karanaIndex];

    // ── Vara ──
    const dow = date.getDay();
    const varaName = VARA_NAMES[dow];

    // ── Masa (Lunar Month) ──
    const masaIndex = Math.floor(moonLon / 30) % 12;
    const masaName = MASA_NAMES[masaIndex];

    // ── Samvat ──
    const vikramSamvat = year + 56 + (month <= 3 ? 0 : 1) - 57; // rough
    const vikramSamvatActual = year + 56;

    // ── Sunrise/Sunset ──
    const { sunrise, sunset, sunriseMin, sunsetMin } = getSunriseSunset(date, lat, lon);

    // ── Rahukaal ──
    const rahukaal = getRahukaal(date, sunriseMin, sunsetMin);

    // ── Abhijit Muhurta ──
    const abhijit = getAbhijitMuhurta(sunriseMin, sunsetMin);

    // ── Auspiciousness of Yoga ──
    const SHUBH_YOGAS = ['प्रीति','आयुष्मान','सौभाग्य','शोभन','सुकर्मा','धृति','वृद्धि','ध्रुव','सिद्धि','वरीयान','शिव','सिद्ध','साध्य','शुभ','शुक्ल','ब्रह्म','इन्द्र'];
    const isShubhYoga = SHUBH_YOGAS.includes(yogaName);

    return {
      tithi: tithiName,
      paksha,
      nakshatra: nakshatraName,
      yoga: yogaName,
      isShubhYoga,
      karana: karanaName,
      vara: varaName,
      masa: masaName,
      vikramSamvat: vikramSamvatActual,
      sunrise,
      sunset,
      rahukaal,
      abhijitMuhurta: abhijit,
      sunLon: sunLon.toFixed(2),
      moonLon: moonLon.toFixed(2),
    };
  }

  // ─── Helpers ─────────────────────────────────────────────────────────────
  function toRad(deg) { return deg * Math.PI / 180; }
  function toDeg(rad) { return rad * 180 / Math.PI; }
  function minutesToTime(minutes) {
    let m = ((minutes % 1440) + 1440) % 1440;
    const h = Math.floor(m / 60);
    const min = Math.round(m % 60);
    return `${String(h).padStart(2, '0')}:${String(min).padStart(2, '0')}`;
  }

  // ─── Today's Panchang Helper ─────────────────────────────────────────────
  function getToday(lat, lon) {
    return compute(new Date(), lat, lon);
  }

  // ─── Format date in Hindi ─────────────────────────────────────────────────
  function getHindiDate(date) {
    const days = ['रविवार','सोमवार','मंगलवार','बुधवार','गुरुवार','शुक्रवार','शनिवार'];
    const months = ['जनवरी','फरवरी','मार्च','अप्रैल','मई','जून','जुलाई','अगस्त','सितम्बर','अक्टूबर','नवम्बर','दिसम्बर'];
    return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
  }

  return { compute, getToday, getHindiDate, minutesToTime };

})();

// Make globally available
window.Panchang = Panchang;
