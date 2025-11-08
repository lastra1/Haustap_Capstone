module.exports = function (api) {
  api.cache(true);
  return {
    presets: ['babel-preset-expo'],
    plugins: [
      [
        'module-resolver',
        {
          extensions: ['.js', '.jsx', '.ts', '.tsx'],
          alias: {
            // Redirect native-only maps to a safe stub on web/SSR
            'react-native-maps': './stubs/react-native-maps-web.tsx',
          },
        },
      ],
    ],
  };
};