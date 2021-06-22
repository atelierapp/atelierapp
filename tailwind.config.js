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
                'pink-500': '#f7ecea',
                'pink-700': '#a07979',
                'pink-900': '#6e504f',
                'green-300': '#D9E7E0',
                'green-600': '#76938F',
                'gray-500': '#F0F0F0',
                'gray-800': '#707070'
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
