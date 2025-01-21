import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js',
        './vendor/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/resources/**/*.js',
        './vendor/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/resources/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                'vsm': '440px',
            },
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
};
