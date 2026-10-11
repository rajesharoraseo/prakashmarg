/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.html", "./assets/js/**/*.js"],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        'saffron': {
          DEFAULT: '#FF9933',
          light: '#FFB870',
          dark: '#E67A00',
        },
        'cream': {
          DEFAULT: '#FFFDF9',
          dark: '#F5EFE6',
        },
        'sandalwood': {
          DEFAULT: '#E3C185',
        },
        'darkbrown': {
          DEFAULT: '#3D2B1F',
          light: '#5C4332',
        },
        'navy': {
          DEFAULT: '#0f172a',
          dark: '#020617',
          light: '#1e293b',
        },
        'gold': {
          DEFAULT: '#fbbf24',
          dark: '#d97706',
          light: '#fde68a',
        }
      },
      fontFamily: {
        'sans': ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
        'hindi': ['Mukta', 'sans-serif'],
        'hindi-serif': ['Tiro Devanagari Hindi', 'serif'],
      },
      boxShadow: {
        'soft': '0 10px 40px -10px rgba(61, 43, 31, 0.08)',
        'glow': '0 0 20px rgba(255, 153, 51, 0.2)',
      }
    },
  },
  plugins: [],
}
