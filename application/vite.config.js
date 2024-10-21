import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            script: {
                babelParserPlugins: ['decorators-legacy'],
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        }
    },
    base: 'http://localhost:8000/', // Ajuste aqui
    server: {
      host: '0.0.0.0', // Permitir acessos de qualquer IP
      port: 5173, // Porta padrão do Vite
      hmr: {
        host: '172.21.0.2', // Utilize o IP do container aqui
      },
    },
});
