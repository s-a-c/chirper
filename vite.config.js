import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => {
    const isTest = mode === 'test' || process.env.NODE_ENV === 'test';

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
