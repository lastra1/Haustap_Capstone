const path = require('path');
const createExpoWebpackConfigAsync = require('@expo/webpack-config');

module.exports = async function (env, argv) {
  const config = await createExpoWebpackConfigAsync(env, argv);

  // Ensure alias object exists
  config.resolve = config.resolve || {};
  config.resolve.alias = {
    ...(config.resolve.alias || {}),
    // Redirect native-only maps to a safe web stub to prevent SSR errors
    'react-native-maps': path.resolve(__dirname, 'stubs/react-native-maps-web.tsx'),
  };

  // Prefer web extensions during resolution
  config.resolve.extensions = [
    ...(config.resolve.extensions || []),
    '.web.tsx',
    '.web.ts',
    '.web.js',
  ];

  return config;
};