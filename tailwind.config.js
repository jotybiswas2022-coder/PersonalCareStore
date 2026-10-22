import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    primary: '#2E8B57',
                    'primary-hover': '#217645',
                    'primary-dark': '#1B5E20',
                    accent: '#FFD166',
                    'accent-hover': '#F0C14B',
                    'accent-text': '#212529',
                    background: '#F8F9FA',
                    'background-light': '#FFFFFF',
                    'primary-tint': '#E8F5E9',
                    'primary-light': '#C8E6C9',
                    'primary-border': '#A5D6A7',
                },
            },
        },
    },

    plugins: [forms],
};
