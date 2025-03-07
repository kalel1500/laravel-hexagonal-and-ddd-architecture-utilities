import { laravelPlugin } from '@kalel1500/kalion-js/dist/plugins/tailwind';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.ts',

        './node_modules/flowbite/**/*.js',
        './node_modules/@kalel1500/kalion-js/**/*.js',
    ],
    theme: {
        extend: {
            screens: {}
        },
    },
    plugins: [
        require('flowbite/plugin'),
        laravelPlugin,
    ],
}
