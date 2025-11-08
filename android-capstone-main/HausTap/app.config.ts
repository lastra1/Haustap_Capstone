import type { ExpoConfig } from '@expo/config';

export default ({ config }: { config: ExpoConfig }): ExpoConfig => {
  return {
    ...config,
    name: 'HausTap',
    slug: 'haustap',
    plugins: [
      ['expo-build-properties', { android: { usesCleartextTraffic: true } }],
    ],
    android: {
      ...config.android,
      package: 'com.haustap',
      edgeToEdgeEnabled: true,
      predictiveBackGestureEnabled: false,
      adaptiveIcon: config.android?.adaptiveIcon,
    },
    extra: {
      ...config.extra,
      apiBase: process.env.EXPO_PUBLIC_API_BASE ?? 'http://127.0.0.1:8001',
    },
  };
};