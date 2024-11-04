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
                    600: '#FFF4EC'
                },
                high: {
                    400: "#10B982",
                },
                medium: {
                    400: "#3B82F6",
                },
                resolved: {
                    400: "rgb(16,185,129,15%)",
                },
                closed: {
                    400: "rgb(155,155,155,15%)",
                },
                open: {
                    400: "rgb(239,68,68,15%)",
                },
                hold: {
                    400: "rgb(251,191,36,15%)",
                },
                inProgress: {
                    400: "rgb(59,130,246,15%)",
                },
                base: {
                    400: "#666666",
                    500: "#ddd"
                },
                black: {
                    400: "#333333"
                },
                navbar: {
                    bg: "#F8FAFF",
                },
                red: {
                    bg: "#ef4444"
                },
                background: {
                    gray: "#f3f4f6"
                },
                paragraph: "#5c5c5c",
                title: "#333333"
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
