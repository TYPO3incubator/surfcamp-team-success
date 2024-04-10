
/** @type {import('tailwindcss').Config} */
export default {
  content: ["local_packages/success/**/*.html"],
  theme: {
    fontFamily: {
      text: ['var(--font-text)'],
      heading: ['var(--font-heading)'],
    },
    borderRadius: {
      DEFAULT: 'var(--radius)',
      'full': '999px'
    },
    rotate: {
      right: 'var(--rotate)',
      left: 'calc(var(--rotate) * (-1))'
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
        '200': 'var(--color-primary-light)',
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
