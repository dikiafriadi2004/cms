/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './public/js/**/*.js',
    ],
    safelist: [
        // Brand opacity modifier classes
        'bg-brand-50/50',
        'bg-brand-600/5',
        'bg-brand-600/10',
        'bg-brand-600/20',
        'border-brand-600/20',
        'shadow-brand-600/5',
        'shadow-brand-600/20',
        'shadow-brand-600/30',
        'shadow-brand-900/5',
        'shadow-brand-900/20',
        'hover:shadow-brand-600/5',
        'bg-indigo-400/10',
        // Ad code classes — semua warna Tailwind standar (disimpan di DB, tidak bisa di-scan)
        {
            pattern: /^(bg|text|border|from|to|via|ring|shadow)-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900)$/,
            variants: ['hover', 'focus', 'active', 'group-hover'],
        },
        {
            pattern: /^bg-gradient-to-(r|l|t|b|tr|tl|br|bl)$/,
        },
        {
            pattern: /^(bg|text|border|from|to|via)-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900)\/(10|20|25|30|40|50|60|70|75|80|90)$/,
        },
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
            },
            colors: {
                brand: {
                    50:  '#f5f7ff',
                    100: '#eef0ff',
                    200: '#dde2ff',
                    300: '#b4bcff',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#1e1b4b',
                },
            },
        },
    },
    plugins: [],
};
