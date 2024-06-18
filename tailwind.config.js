/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        colors: {
          txt: "#100F0F",
          bgc: "#FDFCFC",
          accent: "#E7606A",
          btnprimary: "#B04F56",
          btnsecondary: "#DE8B90",
          btnaccent: "#FFE9E9"
        }
      },
    },
    plugins: [],
  }

