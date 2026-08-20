import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/shop.css',
                'resources/css/about.css',
                'resources/css/product-detail.css',
                'resources/css/collections.css',
                'resources/css/login.css',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/shop.js',
                'resources/js/login.js'
            ],
            refresh: true,
        }),
    ],
});
