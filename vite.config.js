import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            ziggy: path.resolve(__dirname, 'node_modules/ziggy-js'),
        },
    },
    server: {
        host: '0.0.0.0',  // Expose le serveur Vite pour qu'il soit accessible dans le réseau Docker
        port: 5173,
        watch: {
            usePolling: true, // Nécessaire dans Docker pour que le hot-reload fonctionne
        },
        strictPort: true,    // Garde Vite sur le port 5173
    },
});
