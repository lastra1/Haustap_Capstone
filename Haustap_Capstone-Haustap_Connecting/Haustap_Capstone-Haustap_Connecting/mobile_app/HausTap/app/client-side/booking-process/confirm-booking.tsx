import AsyncStorage from '@react-native-async-storage/async-storage';
import { router, useLocalSearchParams } from 'expo-router';
import React from 'react';
import { Alert, Image, StyleSheet, View } from 'react-native';
import { TouchableOpacity } from 'react-native-gesture-handler';
import { ThemedText } from '../../../components/themed-text';
import { ThemedView } from '../../../components/themed-view';
import { Colors } from '../../../constants/theme';

export default function ConfirmBookingScreen() {
  const params = useLocalSearchParams();

  const handleBackToHome = async () => {
    // Save the complete booking details from the flow
    const id = `bkg-${Date.now()}`;
    const booking = {
      id,
      mainCategory: (params.mainCategory as string) || (params.category as string) || 'Service',
      subCategory: (params.subCategory as string) || (params.service as string) || 'Service',
      serviceTitle: (params.categoryTitle as string) || (params.service as string) || '',
      providerId: params.providerId as string,
      providerName: (params.providerName as string) || '',
      date: (params.date as string) || new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }),
      time: (params.time as string) || new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
      address: (params.address as string) || (params.location as string) || '—',
      total: params.categoryPrice ? Number(String(params.categoryPrice).replace(/[^0-9.]/g, "")) : 0,
      desc: (params.categoryDesc as string) || '',
      notes: (params.notes as string) || '',
      voucherCode: (params.voucherCode as string) || '',
      voucherValue: params.voucherValue ? Number(params.voucherValue) : 0,
      status: 'pending'
    };

    try {
      const raw = await AsyncStorage.getItem('HT_bookings');
      const existing = raw ? JSON.parse(raw) : [];
      const updated = Array.isArray(existing) ? [booking, ...existing] : [booking];
      await AsyncStorage.setItem('HT_bookings', JSON.stringify(updated));
    } catch (err) {
      console.warn('Failed to save booking', err);
      Alert.alert('Error', 'Could not save booking locally.');
    }

    // Navigate back to the client-side home page
    router.replace('/client-side');
  };

  return (
    <ThemedView style={styles.container}>
      <View style={styles.content}>
        {/* Logo header */}
        <Image source={require('../../../assets/images/logo.png')} style={styles.logo} resizeMode="contain" />

        {/* Success Icon */}
        <View style={styles.iconContainer}>
          <View style={styles.checkCircle}>
            <ThemedText style={styles.checkmark}>✓</ThemedText>
          </View>
        </View>

        {/* Success Message */}
        <ThemedText style={styles.title}>Thank you for booking</ThemedText>

        {/* Back to Home Button */}
        <TouchableOpacity
          style={styles.button}
          onPress={handleBackToHome}
        >
          <ThemedText style={styles.buttonText}>Back to Home</ThemedText>
        </TouchableOpacity>
      </View>
    </ThemedView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: Colors.light.background,
  },
  content: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    paddingHorizontal: 20,
  },
  iconContainer: {
    marginBottom: 24,
  },
  checkCircle: {
    width: 80,
    height: 80,
    borderRadius: 40,
    backgroundColor: '#4CAF50',
    alignItems: 'center',
    justifyContent: 'center',
  },
  checkmark: {
    color: 'white',
    fontSize: 40,
  },
  logo: {
    width: 260,
    height: 120,
    marginBottom: 24,
    alignSelf: 'center',
  },
  title: {
    fontSize: 30,
    fontWeight: '800',
    marginBottom: 32,
    textAlign: 'center',
    color: Colors.light.text,
  },
  button: {
    backgroundColor: Colors.light.tint,
    paddingHorizontal: 32,
    paddingVertical: 12,
    borderRadius: 8,
    marginTop: 16,
  },
  buttonText: {
    color: 'white',
    fontSize: 16,
    fontWeight: '600',
  },
});
