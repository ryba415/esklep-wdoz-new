/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.{html,js}',
    './dist/*.{html}',
  ],
  theme: {
    extend: {
      colors: {
        "wdoz-primary": "#38900D",
        "wdoz-primary-900": "#2c730a",
        "wdoz-primary-10": "#edf4e8",
        "wdoz-primary-drog": "#BE0072",
        "wdoz-primaty-drog-10": "#f6e6f0",
        "wdoz-body-bg": "#F8F8F8",
        "wdoz-text-gray": "#4F4F4F",
        "wdoz-border": "#F0F0F0",
        "wdoz-step-line": "#C0C0C0",
        "wdoz-input-border": "#B2BCCA",

      },
      textColor: ['group-hover'],
    },
  },
  plugins: [],
}

