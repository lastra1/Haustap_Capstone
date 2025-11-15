// Platform-specific booking location component
// Uses Expo's built-in platform extensions (.web.tsx, .native.tsx)
// This file serves as the entry point - Expo will automatically pick the correct platform version

import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

// Default implementation for platforms without specific files
export default function BookingLocation() {
  return (
    <View style={styles.container}>
      <Text style={styles.text}>Booking Location</Text>
      <Text style={styles.subText}>Platform-specific version not found</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#fff',
  },
  text: {
    fontSize: 18,
    fontWeight: '600',
    marginBottom: 8,
  },
  subText: {
    fontSize: 14,
    color: '#666',
  },
});