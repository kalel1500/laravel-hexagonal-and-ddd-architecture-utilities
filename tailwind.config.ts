import type { Config } from 'tailwindcss'
import { laravelContent, laravelDefaultPlugins } from 'laravel-ts-utilities/dist/plugins';

export default {
    content: [
        ...laravelContent
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
