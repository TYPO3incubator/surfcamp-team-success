
/** @type {import('tailwindcss').Config} */
export default {
  content: ["local_packages/success/**/*.html"],
  theme: {
    fontFamily: {
      base: ['Roboto', 'sans-serif'],
      headline: ['Roboto', 'sans-serif'],
    },
    borderRadius: {
      DEFAULT: 'var(--setting-radius)'
    },
    colors: {
      black: 'black',
      white: 'white',
      transparent: 'transparent',
      current: 'currentColor',
      primary: 'var(--color-primary)',
      primarytext: 'var(--color-primarytext)',
      secondary: 'var(--color-secondary)',
      secondarytext: 'var(--color-secondarytext)',
      light: 'var(--color-light)',
      lighttext: 'var(--color-lighttext)',
    },
    extend: {},
  },
}

// For later use when using different configs

// /** @type {import('tailwindcss').Config} */
// const defaultTheme = require('tailwindcss/defaultTheme')

// module.exports = {
//   theme: {
//     fontFamily: {
//       sans: [
//         'Ubuntu',
//         'Adjusted Verdana Fallback',
//         ...defaultTheme.fontFamily.sans,
//       ],
//     },
//     extend: {
//       colors: {
//         primary: {
//           DEFAULT: '#b32',
//         },
//         secondary: {
//           DEFAULT: '#ff3',
//         },
//       },

//   },
// }
// }
