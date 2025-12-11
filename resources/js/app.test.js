/** @format */

import { describe, it, expect, beforeEach, vi } from 'vitest';

describe('app.js', () => {
    beforeEach(() => {
        // Reset modules to ensure clean state
        vi.resetModules();
        // Clear window.axios to test that app.js properly initializes it
        if (typeof window !== 'undefined') {
            delete window.axios;
        }
    });

    it('should import bootstrap module and initialize axios', async () => {
        // Import app.js which should import bootstrap and set up axios
        const appModule = await import('./app.js');

        // Verify that bootstrap was imported by checking its side effects
        // (bootstrap.js sets window.axios)
        expect(window.axios).toBeDefined();
        expect(window.axios.defaults.headers.common['X-Requested-With']).toBe('XMLHttpRequest');
        expect(appModule).toBeDefined();
    });

    it('should export initializeApp function', async () => {
        const appModule = await import('./app.js');

        expect(appModule.initializeApp).toBeDefined();
        expect(typeof appModule.initializeApp).toBe('function');
    });

    it('should execute initializeApp without errors', async () => {
        const appModule = await import('./app.js');

        // Execute the function to ensure it's covered
        expect(() => appModule.initializeApp()).not.toThrow();
    });

    it('should load without errors', async () => {
        // Simple test to ensure app.js can be imported
        const appModule = await import('./app.js');
        expect(appModule).toBeDefined();
        expect(appModule.initializeApp).toBeDefined();
    });
});
