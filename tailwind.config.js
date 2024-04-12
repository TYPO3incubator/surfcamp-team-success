
/** @type {import('tailwindcss').Config} */
export default {
  content: ["local_packages/success/**/*.html", "vendor/typo3/**/*.html"],
  theme: {
    fontFamily: {
      text: ['var(--font-text)'],
      heading: ['var(--font-heading)'],
    },
    borderRadius: {
      'none': '0px',
      DEFAULT: 'var(--radius)',
      'full': '999px'
    },
    rotate: {
      right: 'var(--rotate)',
      left: 'calc(var(--rotate) * (-1))'
    },
    colors: {
      black: 'var(--color-black)',
      white: {
        'variable': 'var(--color-white)',
        'pure': 'white',
      },
      gray: {
        '100': 'var(--color-gray-light)',
        '900': 'var(--color-gray-dark)'
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
      error: {
        DEFAULT: '#f44336'
      },
      primarytext: 'var(--color-primarytext)',
      secondarytext: 'var(--color-secondarytext)',
      lighttext: 'var(--color-lighttext)',
      whitetext: 'var(--color-whitetext)',
      blacktext: 'var(--color-blacktext)',
    },
    extend: {},
  },
  safelist: [
    'heading-xxl',
    'heading-xl',
    'heading-lg',
    'space-before-extra-small',
    'space-before-small',
    'space-before-medium',
    'space-before-large',
    'space-before-extra-large',
    'space-after-extra-small',
    'space-after-small',
    'space-after-medium',
    'space-after-large',
    'space-after-extra-large',
    'form-group',
    'form-label',
    'form-control',
    'form-text',
    'text-black',
    'text-white-variable',
    'text-white-pure',
    'default'
  ]
}
