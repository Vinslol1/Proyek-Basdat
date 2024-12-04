/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./src/**/*.{html,js,jsx,ts,tsx}"],
  theme: {
    extend: {
      colors : {
        biru_sidebar : '#002B53',
        biru_hover : '#003566',
        biru_text : '#003261',
        merah_bg : '#B15655',
        abu_tabel : '#D9D9D9'
      },
      fontFamily: {
        'poppins': ['Poppins', 'sans-serif']
      },
    },
  },
  plugins: [],
}

