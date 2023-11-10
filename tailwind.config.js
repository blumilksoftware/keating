module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
    safelist: [
        '[mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]',
        '[mask-image:radial-gradient(100%_100%_at_top_left,white,transparent)]',
    ],
}
