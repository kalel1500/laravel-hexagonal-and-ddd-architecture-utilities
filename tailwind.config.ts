import type { Config } from 'tailwindcss'
import { laravelDefaultPlugins } from 'laravel-ts-utilities/dist/plugins';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.ts',
        './node_modules/flowbite/**/*.js'
    ],
    theme: {
        extend: {
            screens: {}
        },
    },
    plugins: [
        ...laravelDefaultPlugins
    ],
} satisfies Config
