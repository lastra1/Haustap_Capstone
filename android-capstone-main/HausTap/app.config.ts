import type { ExpoConfig } from '@expo/config';

function resolveMode(): 'client' | 'provider' {
  const envMode = process.env.EXPO_PUBLIC_USER_MODE?.toLowerCase();
  if (envMode === 'provider' || envMode === 'client') return envMode as 'client' | 'provider';
  const profile = process.env.EAS_BUILD_PROFILE?.toLowerCase();
  if (profile?.includes('provider')) return 'provider';
  return 'client';
}

export default ({ config }: { config: ExpoConfig }): ExpoConfig => {
  const mode = resolveMode();
  const isProvider = mode === 'provider';
  const name = isProvider ? 'HausTap Provider' : 'HausTap Client';
  const androidPackage = isProvider ? 'com.haustap.provider' : 'com.haustap.client';

  return {
    ...config,
    name,
    slug: isProvider ? 'haustap-provider' : 'haustap-client',
    plugins: [
      [
        'expo-build-properties',
        {
          android: {
            usesCleartextTraffic: true,
            enableProguardInReleaseBuilds: true,
            packagingOptions: {
              exclude: [
                'META-INF/LICENSE*',
                'META-INF/NOTICE*',
                'META-INF/DEPENDENCIES',
                'META-INF/*.kotlin_module'
              ],
            },
          },
        },
      ],
    ],
    android: {
      ...config.android,
      package: androidPackage,
      edgeToEdgeEnabled: true,
      predictiveBackGestureEnabled: false,
      adaptiveIcon: config.android?.adaptiveIcon,
    },
    extra: {
      ...config.extra,
      USER_MODE: mode,
      apiBase: process.env.EXPO_PUBLIC_API_BASE ?? 'http://127.0.0.1:8001',
    },
  };
};