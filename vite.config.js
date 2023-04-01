import { VitePWA } from 'vite-plugin-pwa';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: 'inline',
            includeAssets: [
              'offline.html',
              'favicon.ico',
              'robots.txt',
            ],
            manifest: {
              theme_color: '#FFF3E0',
              background_color: '#FFF3E0',
              display: 'standalone',
              scope: '/',
              start_url: '/',
              short_name: 'Foodder',
              name: 'Foodder',
              icons: [
                {
                    src: 'img/Foodder_icon_48.png',
                    sizes: '48x48',
                    type: 'image/png',
                },
                {
                    src: 'img/Foodder_icon_96.png',
                    sizes: '96x96',
                    type: 'image/png',
                },  
                {
                  src: 'img/icon-192x192.png',
                  sizes: '192x192',
                  type: 'image/png',
                },
                {
                  src: 'img/Foodder_icon_512.png',
                  sizes: '512x512',
                  type: 'image/png',
                },
              ],
            },
            workbox: {
                cleanupOutdatedCaches: false,
                globPatterns: ['**/*.{js,css,html,ico,png,svg,json,vue,txt,woff2}']
            }
        }),
    ],
});
