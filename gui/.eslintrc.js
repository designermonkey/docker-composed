module.exports = {
  root: true,

  env: {
    node: true
  },

  extends: [
    'eslint:recommended',
    'plugin:vue/recommended',
    '@vue/standard'
  ],

  plugins: [
    'cypress'
  ],

  parserOptions: {
    ecmaVersion: 2020,
    // parser: 'babel-eslint'
  },

  rules: {
    // 'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'vue/eqeqeq': 'error',
    'vue/html-closing-bracket-newline': [
      'error',
      {
        multiline: 'never',
        singleline: 'never'
      }
    ],
    'vue/html-indent': ['error', 2, {
      alignAttributesVertically: false
    }],
    'vue/html-self-closing': [
      'error',
      {
        html: {
          void: 'always',
          normal: 'never',
          component: 'always'
        },
        svg: 'always',
        math: 'always'
      }
    ],
    'vue/max-attributes-per-line': ['error', {
      singleline: 1,
      multiline: {
        max: 1,
        allowFirstLine: true
      }
    }],
    'vue/script-indent': ['error', 2, {
      baseIndent: 0,
      switchCase: 0
    }]
  },

  overrides: [
    {
      files: [
        '**/tests/unit/**/*.spec.{j,t}s?(x)'
      ],
      env: {
        jest: true
      }
    },
    {
      files: [
        '**/tests/cypress/**/*.spec.{j,t}s?(x)'
      ],
      env: {
        'cypress/globals': true
      },
      extends: [
        'plugin:cypress/recommended'
      ],
      rules: {
        'no-unused-expressions': 'off',
        'cypress/no-assigning-return-values': 'error',
        'cypress/no-unnecessary-waiting': 'warn',
        'cypress/assertion-before-screenshot': 'warn',
        'cypress/no-force': 'warn',
        'cypress/no-async-tests': 'error'
      }
    },
    {
      files: ['*.vue'],
      rules: {
        indent: 'off'
      }
    }
  ]
}
