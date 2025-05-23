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
                sans: ['Inter var', 'Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eef6ff',
                    100: '#d9eaff',
                    200: '#bcd7ff',
                    300: '#8ebcff',
                    400: '#5996ff',
                    500: '#3272fc',
                    600: '#1a50f2',
                    700: '#1641e3',
                    800: '#1835b8',
                    900: '#192f91',
                    950: '#141c54',
                },
                secondary: {
                    50: '#f5f7fa',
                    100: '#ebeef3',
                    200: '#d2dae5',
                    300: '#aabace',
                    400: '#7d94b2',
                    500: '#5c7999',
                    600: '#4a627f',
                    700: '#3e4f67',
                    800: '#374357',
                    900: '#313b4b',
                    950: '#1d232e',
                },
                success: {
                    50: '#eefdf5',
                    100: '#d7faeb',
                    200: '#b2f5d9',
                    300: '#77ecbf',
                    400: '#3fdba0',
                    500: '#1ec285',
                    600: '#0f9e6a',
                    700: '#107f58',
                    800: '#126449',
                    900: '#11533e',
                    950: '#052e22',
                },
                danger: {
                    50: '#fff0f0',
                    100: '#ffdddd',
                    200: '#ffc0c0',
                    300: '#ff9494',
                    400: '#ff5757',
                    500: '#ff2323',
                    600: '#ff0000',
                    700: '#d70000',
                    800: '#b10303',
                    900: '#920a0a',
                    950: '#500000',
                },
                warning: {
                    50: '#fffaeb',
                    100: '#fff1c7',
                    200: '#ffe488',
                    300: '#ffcf4a',
                    400: '#ffbc20',
                    500: '#f99e07',
                    600: '#dd7902',
                    700: '#b75706',
                    800: '#94420c',
                    900: '#7a370f',
                    950: '#461b03',
                },
                info: {
                    50: '#f0f8ff',
                    100: '#e0f0fe',
                    200: '#bae2fd',
                    300: '#7ccdfd',
                    400: '#36b3f9',
                    500: '#0c9cf1',
                    600: '#0080cf',
                    700: '#0066a7',
                    800: '#00568a',
                    900: '#064973',
                    950: '#042e4a',
                },
                neutral: {
                    50: '#f9f9f9',
                    100: '#f2f2f2',
                    200: '#e6e6e6',
                    300: '#d1d1d1',
                    400: '#b0b0b0',
                    500: '#909090',
                    600: '#707070',
                    700: '#5e5e5e',
                    800: '#4a4a4a',
                    900: '#3d3d3d',
                    950: '#1f1f1f',
                },
            },
            boxShadow: {
                'modern': '0 4px 20px -2px rgba(0, 0, 0, 0.1), 0 0 8px -2px rgba(0, 0, 0, 0.05)',
                'card': '0 10px 25px -3px rgba(0, 0, 0, 0.07), 0 4px 12px -2px rgba(0, 0, 0, 0.04)',
                'button': '0 2px 6px 0 rgba(0, 0, 0, 0.04)',
                'hover': '0 10px 30px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.03)',
                'glass': '0 4px 30px rgba(0, 0, 0, 0.08)',
                'inner': 'inset 0 2px 6px 0 rgba(0, 0, 0, 0.04)',
            },
            borderRadius: {
                'modern': '0.75rem',
                'xl': '1rem',
                '2xl': '1.5rem',
            },
            animation: {
                'slide-up': 'slide-up 0.4s cubic-bezier(0.16, 1, 0.3, 1)',
                'fade-in': 'fade-in 0.3s cubic-bezier(0.16, 1, 0.3, 1)',
                'scale': 'scale 0.2s cubic-bezier(0.16, 1, 0.3, 1)',
            },
            backdropBlur: {
                'glass': '10px',
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                'gradient-subtle': 'linear-gradient(to right bottom, rgb(249, 250, 251), rgb(243, 244, 246))',
            },
        },
    },

    plugins: [forms],
};