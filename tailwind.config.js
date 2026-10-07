/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./*.php', './admin/*.php', './includes/*.php'],
  theme: {
    extend: {
      fontFamily: { sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
      colors: {
        // Set at runtime from Admin → Website Content (CSS variables in index.php)
        brand: { DEFAULT: 'rgb(var(--brand) / <alpha-value>)', 2: 'rgb(var(--brand2) / <alpha-value>)' },
        cream: '#f8f6f0',
      },
    },
  },
};
