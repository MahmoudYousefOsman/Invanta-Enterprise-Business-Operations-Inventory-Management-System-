
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin_rtl.css',
                'resources/css/admin.css',
                'resources/js/app.js',
                // 'resources/js/admin.js',
                'resources/js/crud.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
