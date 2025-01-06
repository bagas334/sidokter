/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                'main-base': '#F0F3FA',
            }
        },
    },
    plugins: [
        require('daisyui'),
        require('flowbite/plugin')
    ],
}

