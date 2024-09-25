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
            colors: {
                primary: {
                    400: "#F36D00",
                    500: "rgb(109,77,266,4%)"
                },
                info: {
                    400: '#10B982',
                },
                teal: {
                    400: '#00C0AF',
                },
                process: {
                    400: '#3B82F6',
                },
                navbar: {
                    bg: '#F8FAFF'
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                inter: ["Inter", "sans-serif"]
            },
        },
        screens: {
            'sm': '480px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
        }
    },

    plugins: [forms],
};