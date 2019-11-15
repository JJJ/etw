/* eslint-env node */

const react = require('broccoli-react');

module.exports = {
  name: 'cs-ember-addon',

  preprocessTree(type, tree) {
    if (type === 'js') tree = react(tree, { transform: { es6module: true } });
    return tree;
  },

  options: {
    autoImport: {
      devtool: 'inline-source-map',
    },
  },
};
