/** @format */

import { describe, it, expect, beforeEach, vi } from 'vitest';
import axios from 'axios';

// Mock window object
const mockWindow = {
    axios: null,
};

global.window = mockWindow;
global.axios = axios;

describe('bootstrap.js', () => {
    beforeEach(() => {
        // Reset window.axios before each test
        mockWindow.axios = null;
        // Re-import bootstrap to test its side effects
        vi.resetModules();
    });

    it('should set axios on window object', async () => {
        // Import bootstrap to trigger side effects
        await import('./bootstrap.js');

        expect(window.axios).toBeDefined();
        expect(window.axios).toBe(axios);
    });

    it('should configure axios default headers', async () => {
        await import('./bootstrap.js');

        expect(window.axios.defaults.headers.common['X-Requested-With']).toBe('XMLHttpRequest');
    });

    it('should make axios available globally', async () => {
        await import('./bootstrap.js');

        // axios is a function (callable) that also has properties
        expect(typeof window.axios).toBe('function');
        expect(window.axios.defaults).toBeDefined();
        expect(window.axios.defaults.headers).toBeDefined();
    });
});
