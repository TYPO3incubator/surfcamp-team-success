
/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin')

export default {
  content: ["local_packages/success/**/*.html"],
  theme: {
    fontFamily: {
      text: ['var(--font-text)'],
      heading: ['var(--font-heading)'],
    },
    borderRadius: {
      DEFAULT: 'var(--setting-radius)'
    },
    colors: {
      black: 'black',
      white: 'white',
      gray: {
        '100': '#eee',
        '900': '#333'
      },
      transparent: 'transparent',
      current: 'currentColor',
      primary: {
        '500': 'var(--color-primary)',
        '700': 'var(--color-primary-dark)',
      },
      secondary: {
        '500': 'var(--color-secondary)',
        '700': 'var(--color-secondary-dark)',
      },
      light: {
        '500': 'var(--color-light)',
        '700': 'var(--color-light-dark)',
      },
      primarytext: 'var(--color-primarytext)',
      secondarytext: 'var(--color-secondarytext)',
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
