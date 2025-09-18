import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: true,      // biar bisa diakses selain localhost
        port: 5173,
        hmr: {
            host: 'monday.test',  // ganti dengan domain valet kamu
        },
    },
});
