let tailwindcss = require("tailwindcss")

module.exports = {
  plugins: [
    tailwindcss('./tailwind.config.js'),
    require('postcss-import'),
    require('autoprefixer')
  ]
}

// module.exports = {
//   plugins: {
//     tailwindcss: {},
//     autoprefixer: {},
//   },
// }
