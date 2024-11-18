import { defineConfig } from 'vite';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import autoOrigin from 'vite-plugin-auto-origin';

const port = 5173;
const origin = `${process.env.DDEV_PRIMARY_URL}:${port}`;
// TYPO3 root path (relative to this config file)
const VITE_TYPO3_ROOT = "./";

// Vite input files (relative to TYPO3 root path)
const VITE_ENTRYPOINTS = [
  "assets/global.js",
  "assets/js/components/accordion.js",
  "assets/js/components/back-to-top.js",
  "assets/js/components/counter-animation.js",
  "assets/js/components/lightbox.js",
  "assets/js/components/mobile-navigation.js",
  "assets/js/components/modal.js",
  "assets/js/components/slider.js",
  "assets/fonts/comic-neue.js",
  "assets/fonts/lato.js",
  "assets/fonts/merriweather.js",
  "assets/fonts/noto-serif.js",
  "assets/fonts/open-sans.js",
  "assets/fonts/oswald.js",
  "assets/fonts/playpen-sans.js",
  "assets/fonts/roboto-mono.js",
  "assets/fonts/roboto-slab.js",
  "assets/fonts/roboto.js",
  "assets/fonts/roboto.js",
];

// Output path for generated assets
const VITE_OUTPUT_PATH = "local_packages/success/Resources/Public/Vite";

const currentDir = dirname(fileURLToPath(import.meta.url));
const rootPath = resolve(currentDir, VITE_TYPO3_ROOT);
export default defineConfig(({command, mode}) => {
  return {
    mode: `${mode}`,
    base: '',
    build: {
      minify: mode !== 'development',
      manifest: true,
      assetsInlineLimit: 100, // Do not inline SVG files, so it can be used by the SvgIconProvider
      rollupOptions: {
        input: VITE_ENTRYPOINTS.map(entry => resolve(rootPath, entry)),
        output: {
          manualChunks: (path) => path.split('/').reverse()[path.split('/').reverse().indexOf('node_modules') - 1]
        }
      },
      outDir: resolve(rootPath, VITE_OUTPUT_PATH),
    },
    publicDir: false,

    // Adjust Vites dev server for DDEV
    // https://vitejs.dev/config/server-options.html
    server: {
      // respond to all network requests:
      host: '0.0.0.0',
      port: port,
      strictPort: true,
      // Defines the origin of the generated asset URLs during development
      origin: origin
  },
    plugins: [
      // ViteImageOptimizer(),
      autoOrigin(),
    ],
  }
});



