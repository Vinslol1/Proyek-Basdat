/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [ "./**/*.{html,js,jsx,ts,tsx}","./src/**/*.{html,js}"],
  theme: {
    extend: {
      colors : {
        biru_sidebar : '#002B53',
        biru_hover : '#003566',
        biru_text : '#003261',
        merah_bg : '#B15655',
        abu1 : '#D9D9D9'
      },
      fontFamily: {
        'sand': ['Quicksand', 'sans-serif'],
        'logo' :['Zen Kurenai','sans-serif']
      },
    },
  },
  plugins: [],
}

