/**
 * Generates assets/css/tailwind.css from the classes used in the PHP and JS
 * files. Only needed when you add Tailwind classes that aren't used yet:
 *   cd tools && npm install && npm run build:css
 */
module.exports = {
  content: {
    relative: true,
    files: ["../index.php", "../includes/**/*.php", "../assets/js/**/*.js"],
  },
  theme: {
    extend: {
      colors: {
        // Values are set in assets/css/site.css (:root).
        m: {
          bg: "rgb(var(--m-bg) / <alpha-value>)",
          surface: "rgb(var(--m-surface) / <alpha-value>)",
          text: "rgb(var(--m-text) / <alpha-value>)",
          muted: "rgb(var(--m-muted) / <alpha-value>)",
          label: "rgb(var(--m-label) / <alpha-value>)",
          line: "rgb(var(--m-line) / <alpha-value>)",
          accent: "rgb(var(--m-accent) / <alpha-value>)",
          "on-accent": "rgb(var(--m-on-accent) / <alpha-value>)",
        },
      },
      fontFamily: {
        sans: ["var(--font-sans)", "ui-sans-serif", "system-ui", "sans-serif"],
        mono: ["var(--font-mono)", "ui-monospace", "monospace"],
      },
    },
  },
  plugins: [],
};
