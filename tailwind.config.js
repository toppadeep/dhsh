module.exports = {
  mode: 'jit',
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  purge: [
    './public/**/*.html',
    './src/**/*.{js,jsx,ts,tsx,vue}',
  ],

  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        main: '#8C1824',
        second: '#A87B51',
        default: '#757575',
        dark: {
          800: '#383838',
          900: '#2D2D2D',
        },
        darkText: '#2D2D2D',
        darkElement: '#C4524F'
      },

    },
  },
  plugins: [
    require('@tailwindcss/line-clamp'),
  ],
}