import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
    publicDir: false,
    build: {
        outDir: 'public/build',
        assetsDir: '',
        rollupOptions: {
            input: {
                scripts: path.resolve(__dirname, 'resources/js/app.ts'),
                styles: path.resolve(__dirname, 'resources/css/app.css'),
            },
            output: {
                entryFileNames: '[name].js',
                assetFileNames: '[name][extname]',
            },
            external: ['bootstrap'],
        },
    },
});
