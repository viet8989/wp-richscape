/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        teal: '#02ad83',
        darkblue: '#264191',
        light: '#FFFFFF',
        graytext: '#808080',
      },
      fontFamily: {
        sans: ['Montserrat', 'sans-serif'],
        serif: ['"Playfair Display"', 'serif'],
        body: ['"Open Sans"', 'sans-serif'],
        display: ['"Area Extended"', 'sans-serif'],
        utm: ['"UTM AVO"', 'sans-serif'],
        pws: ['"PWS Cratchedfont"', 'cursive'],
        utile: ['"Utile Semibold"', 'sans-serif'],
        manrope: ['"Manrope"', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
