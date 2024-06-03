import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/login-effect.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        minify: 'esbuild',
        commonjsOptions: {
            transformMixedEsModules: true
        },
        rollupOptions: {
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/login-effect.js',
            ],
            output:{
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return id.toString().split('node_modules/')[1].split('/')[0].toString();
                    }
                }
            }
        }
    }
});
