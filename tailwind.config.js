const mix = require("laravel-mix");

module.exports = {
    purge: {
        enabled: mix.inProduction(),
        content: [
            './resources/js/components/**/*.vue',
            './resources/views/**/*.blade.php',
        ],
    },
    theme: {
        extend: {},
        customForms: (theme) => ({
            default: {
                'input, textarea, checkbox, radio, select': {
                    backgroundColor: theme('colors.gray.200'),
                },
            },
        }),
    },
    variants: {
        textDecoration: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
    },
    plugins: [
        require('@tailwindcss/custom-forms'),
    ]
};
