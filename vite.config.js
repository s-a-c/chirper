import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import fs from 'fs';
import os from 'os';

export default defineConfig(({ mode }) => {
    const isTest = mode === 'test' || process.env.NODE_ENV === 'test';

    // HTTPS configuration for development
    const host = process.env.VITE_DEV_HOST || process.env.APP_HOST || 'chirper.test';
    const homeDir = os.homedir();
    const certPath = process.env.VITE_DEV_CERT || `${homeDir}/.config/Herd/ssl/chirper.test+4.pem`;
    const keyPath = process.env.VITE_DEV_KEY || `${homeDir}/.config/Herd/ssl/chirper.test+4-key.pem`;

    const serverConfig = {
        host,
        https: undefined,
    };

    // Only configure HTTPS if certificate files exist
    if (fs.existsSync(certPath) && fs.existsSync(keyPath)) {
        serverConfig.https = {
            cert: fs.readFileSync(certPath),
            key: fs.readFileSync(keyPath),
        };
    }

    return {
        plugins: [
            // Only load Laravel plugin when not in test mode
            ...(isTest
                ? []
                : [
                      laravel({
                          input: ['resources/css/app.css', 'resources/js/app.js'],
                          refresh: true,
                      }),
                  ]),
            tailwindcss(),
        ],
        server: serverConfig,
        test: {
            // Use jsdom environment for DOM-related tests
            environment: 'jsdom',
            // Exclude directories that shouldn't be tested
            exclude: [
                '**/node_modules/**',
                '**/dist/**',
                '**/cypress/**',
                '**/.{idea,git,cache,output,temp}/**',
                '**/{karma,rollup,webpack,vite,vitest,jest,ava,babel,nyc,cypress,tsup,build,eslint,prettier}.config.*',
                '**/.trunk/**',
                '**/vendor/**',
                '**/.ai/**',
            ],
            // Pass when no test files are found (common for projects without JS tests yet)
            passWithNoTests: true,
        },
    };
});
