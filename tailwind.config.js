module.exports = {
    mode: 'jit',
    purge: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './config/*.php',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                'pink-400': '#BC9E9F',
                'pink-500': '#f7ecea',
                'pink-700': '#a07979',
                'pink-900': '#6e504f',
                'green-300': '#D9E7E0',
                'green-500': '#76938F',
                'green-600': '#76938F',
                'gray-500': '#F0F0F0',
                'gray-800': '#707070'
            },
            boxShadow: {
                '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.1)',
                '2xl-soft': '0 25px 50px -12px rgba(0, 0, 0, 0.05)',
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}