import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/style.css',
                'resources/js/app.js',
                'resources/js/script.js',
                'resources/js/plugins.js',
                'resources/js/jquery-1.11.0.min.js',
            ],
            refresh: true,
        }),
    ],
});
