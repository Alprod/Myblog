/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
      'templates/**/*.html.twig',
      'assets/js/**/*.js',
      'assets/react/**/*.jsx'
    ],
    theme: {
    extend: {},
    },
    corePlugins: {
        aspectRatio: false,
    },
    plugins: [
        require('@tailwindcss/aspect-ratio')
    ],
}
