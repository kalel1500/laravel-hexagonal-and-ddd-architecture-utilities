import type { Config } from 'tailwindcss'
import plugin from 'tailwindcss/plugin';

export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.ts",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      screens: {
        'vsm': '440px'
      }
    },
  },
  plugins: [
    require('flowbite/plugin'),
    plugin(function ({ addVariant }) {
      addVariant('sc', '&:is(.sc *)');
    })
  ],
} satisfies Config

