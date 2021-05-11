const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        colors: {
            main: {
                light: '#C299FF',
                DEFAULT: '#a970ff',
                dark: '#9147FF',
            },
            black: colors.black,
            white: colors.white,
            gray: colors.trueGray,
            indigo: colors.indigo,
            red: colors.rose,
            yellow: colors.amber,
            green: colors.emerald,
            blue: colors.blue,
          },
          spinner: (theme) => ({
            default: {
              color: '#dae1e7', // color you want to make the spinner
              size: '1em', // size of the spinner (used for both width and height)
              border: '2px', // border-width of the spinner (shouldn't be bigger than half the spinner's size)
              speed: '500ms', // the speed at which the spinner should rotate
            },
            // md: {
            //   color: theme('colors.red.500', 'red'),
            //   size: '2em',
            //   border: '2px',
            //   speed: '500ms',
            // },
          }),
        extend: {
            fontFamily: {
                sans: ["Manrope", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require('tailwindcss-spinner')({ className: 'spinner', themeKey: 'spinner' }),
    ],
};
