import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./app/Http/Controllers/**/*.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    400: "#F36D00",
                    500: "rgb(109,77,266,4%)",
                    600 : '#FFF4EC'
                },
                high: {
                    400: "#10B982",
                },
                medium: {
                    400: "#3B82F6",
                },
                open: {
                    400: "#00C0AF",
                },
                hold: {
                    400: "#FBBF24",
                },
                resolved: {
                    400: "#10B981",
                },
                closed: {
                    400: "#DC2626",
                },
                process: {
                    400: "#3B82F6",
                },
                base: {
                    400: "#666666",
                    500 : "#ddd"
                },
                black : {
                    400 : "#333333"
                },
                navbar: {
                    bg: "#F8FAFF",
                },
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                inter: ["Inter", "sans-serif"],
            },
        },
        screens: {
            sm: "480px",
            md: "768px",
            lg: "1024px",
            xl: "1280px",
            "2xl": "1536px",
        },
    },

    plugins: [forms],
};
