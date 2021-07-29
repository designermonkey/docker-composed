module.exports = {
  extends: 'stylelint-config-recommended-scss',
  plugins: [
    'stylelint-scss'
  ],
  rules: {
    'indentation': [
      2,
      {
        baseIndentLevel: 0
      }
    ],
    'max-empty-lines': 1,
    'no-empty-source': null
  }
}
