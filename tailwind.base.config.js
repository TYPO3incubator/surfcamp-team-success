
/** @type {import('tailwindcss').Config} */
export default {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: {},
  },
  presets: [require('tailwind-base.config')],
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
