import { Ionicons } from '@expo/vector-icons';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { useFocusEffect } from '@react-navigation/native';
import { useRouter } from 'expo-router';
import React, { useCallback, useState } from 'react';
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from 'react-native';

// Example bookings shown when no real bookings exist yet
const mockBookings = [
  {
    id: 'example-001',
    mainCategory: 'Home Cleaning',
    subCategory: 'Bungalow - Basic Cleaning',
    serviceTitle: 'Bungalow - Basic Cleaning Service',
    providerId: 'provider-1',
    providerName: 'Juan Dela Cruz',
    date: new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }),
    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
    address: 'BT L50 Mango st. Phase 1 Saint Joseph Village 10, barangay Langgam, City of San Pedro, Laguna 4023',
    total: 1000,
    desc: 'Basic cleaning package — includes living room, kitchen, bedroom cleaning, mopping, dusting, trash removal.',
    notes: 'Please focus on the kitchen and living room. Bring disinfectant.',
    voucherCode: 'SPRING10',
    voucherValue: 100,
    status: 'pending'
  }
];

export default function BookingPending() {
  const router = useRouter();

  // bookings state — start with mock until AsyncStorage loads real ones
  const [bookings, setBookings] = useState<typeof mockBookings>(mockBookings);
  const [expandedId, setExpandedId] = useState<string | null>(null);

  // helper to parse price-like values
  const parsePrice = (p: any) => {
    if (!p && p !== 0) return 0;
    try {
      const num = String(p).replace(/[^0-9.]/g, "");
      return Number(num) || 0;
    } catch {
      return 0;
    }
  };

  const formatCurrency = (v: number) => `₱${v.toFixed(2)}`;

  // load bookings from AsyncStorage whenever screen is focused
  useFocusEffect(
    useCallback(() => {
      let mounted = true;
      const load = async () => {
        try {
          const raw = await AsyncStorage.getItem('HT_bookings');
          if (raw) {
            const parsed = JSON.parse(raw);
            if (Array.isArray(parsed) && mounted) {
              // show saved bookings first, then fall back to mock ones
              setBookings([...parsed, ...mockBookings]);
              return;
            }
          }
          if (mounted) setBookings(mockBookings);
        } catch (err) {
          console.warn('Failed to load bookings from storage', err);
          if (mounted) setBookings(mockBookings);
        }
      };
      load();
      return () => {
        mounted = false;
      };
    }, [])
  );

  return (
    <View style={styles.pageContainer}>
      <ScrollView style={styles.container} contentContainerStyle={{ padding: 16, paddingBottom: 120 }}>
      <View style={styles.headerRow}>
        <Text style={styles.headerTitle}>Bookings</Text>
      </View>

      <View style={styles.tabsRow}>
        <TouchableOpacity style={[styles.tabButton, styles.tabActive]}>
          <Text style={styles.tabTextActive}>Pending</Text>
        </TouchableOpacity>
        <TouchableOpacity style={styles.tabButton} onPress={() => router.push('/client-side/client-booking-summary/booking-ongoing')}>
          <Text style={styles.tabText}>Ongoing</Text>
        </TouchableOpacity>
        <TouchableOpacity style={styles.tabButton} onPress={() => router.push('/client-side/client-booking-summary/booking-completed')}>
          <Text style={styles.tabText}>Completed</Text>
        </TouchableOpacity>
        <TouchableOpacity style={styles.tabButton} onPress={() => router.push('/client-side/client-booking-summary/booking-cancelled')}>
          <Text style={styles.tabText}>Cancelled</Text>
        </TouchableOpacity>
        <TouchableOpacity style={styles.tabButton} onPress={() => router.push('/client-side/client-booking-summary/booking-return')}>
          <Text style={styles.tabText}>Return</Text>
        </TouchableOpacity>
      </View>

  {bookings.map((b) => {
        const expanded = expandedId === b.id;
        return (
          <View key={b.id} style={styles.card}>
            <TouchableOpacity activeOpacity={0.85} onPress={() => setExpandedId(expanded ? null : b.id)}>
              <View style={styles.cardHeaderRow}>
                <View style={{ flex: 1 }}>
                  <Text style={styles.mainCategory}>{b.mainCategory}</Text>
                  <Text style={styles.subcategory}>{b.subCategory}</Text>
                  <Text style={styles.bookingId}>Booking ID: {b.id}</Text>
                </View>
                <View style={{ alignItems: 'flex-end' }}>
                  <Text style={styles.priceText}>₱{b.total.toFixed(2)}</Text>
                  <Text style={styles.chev}>{expanded ? '▲' : '▼'}</Text>
                </View>
              </View>
            </TouchableOpacity>

            {expanded && (
              <View>
                <View style={styles.divider} />

                <View style={styles.rowSmall}>
                  <View style={styles.rowCol}>
                    <Text style={styles.metaLabel}>Date</Text>
                    <Text style={styles.metaValue}>{b.date}</Text>
                  </View>
                  <View style={styles.vertSeparator} />
                  <View style={styles.rowCol}>
                    <Text style={styles.metaLabel}>Time</Text>
                    <Text style={styles.metaValue}>{b.time}</Text>
                  </View>
                </View>

                <View style={[styles.addressBox, { marginTop: 12 }]}> 
                  <Text style={styles.metaLabel}>Address</Text>
                  <Text style={styles.addressText}>{b.address}</Text>
                </View>

                <View style={[styles.selectedBox, { marginTop: 12 }]}>
                  <Text style={[styles.metaLabel, { marginBottom: 6 }]}>You selected</Text>
                  <Text style={styles.selectedTitle}>{b.subCategory}</Text>
                  <Text style={styles.inclusions}>{b.desc || 'Basic cleaning package — includes living room, kitchen, bedroom cleaning, mopping, dusting, trash removal.'}</Text>
                </View>

                <View style={{ marginTop: 12 }}>
                  <Text style={styles.metaLabel}>Notes:</Text>
                  <Text style={[styles.notesInput, { minHeight: 40 }]}>{b.notes || '—'}</Text>
                </View>

                {/* Voucher row (matches booking-overview style) */}
                <View style={styles.voucherRowOverview}>
                  <View style={styles.voucherLeft}>
                    <Ionicons name="pricetag-outline" size={18} color="#333" style={{ marginRight: 8 }} />
                    <Text style={styles.voucherText}>{b.voucherCode ? b.voucherCode : 'Add a Voucher'}</Text>
                    {b.voucherValue ? (
                      <View style={styles.voucherBadge}>
                        <Text style={styles.voucherBadgeText}>{formatCurrency(Number(b.voucherValue))}</Text>
                      </View>
                    ) : null}
                  </View>
                </View>

                {/* Totals */}
                <View style={styles.totalsRow}>
                  <View>
                    <Text style={styles.smallLabel}>Sub Total</Text>
                    <Text style={styles.smallLabel}>Voucher Discount</Text>
                  </View>
                  <View style={{ alignItems: 'flex-end' }}>
                    <Text style={styles.smallLabel}>{formatCurrency(parsePrice(b.total))}</Text>
                    <Text style={styles.smallLabel}>{b.voucherValue ? formatCurrency(Number(b.voucherValue)) : '₱0.00'}</Text>
                  </View>
                </View>

                <View style={styles.totalRow}>
                  <Text style={styles.totalLabel}>TOTAL</Text>
                  <Text style={styles.totalValue}>{formatCurrency(Math.max(0, parsePrice(b.total) - (b.voucherValue ? Number(b.voucherValue) : 0)))}</Text>
                </View>

                <Text style={styles.payNote}>Full payment will be collected directly by the service provider upon completion of the service.</Text>

                <View style={styles.footerRow}> 
                  <TouchableOpacity 
                    style={styles.cancelBtn} 
                    onPress={() => router.push({
                      pathname: '/client-side/client-booking-summary/cancel-booking-form',
                      params: { bookingId: b.id }
                    } as any)}
                  >
                    <Text style={styles.cancelText}>Cancel</Text>
                  </TouchableOpacity>
                </View>
              </View>
            )}
          </View>
        );
      })}
      </ScrollView>

      {/* Footer provided by layout */}
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#fff' },
  headerRow: { paddingVertical: 8 },
  headerTitle: { fontSize: 20, fontWeight: '700' },
  tabsRow: { flexDirection: 'row', marginVertical: 12, gap: 8 },
  tabButton: { paddingVertical: 6, paddingHorizontal: 10, borderRadius: 8, backgroundColor: '#f0f0f0' },
  tabActive: { backgroundColor: '#fff' },
  tabText: { color: '#666' },
  tabTextActive: { color: '#3DC1C6', fontWeight: '700' },
  card: { backgroundColor: '#fff', borderRadius: 8, padding: 12, marginBottom: 12, borderWidth: 1, borderColor: '#E0E0E0' },
  cardHeaderRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center' },
  mainCategory: { fontSize: 18, fontWeight: '700' },
  subcategory: { fontSize: 14, color: '#666', marginTop: 6 },
  bookingId: { fontSize: 12, color: '#666', marginTop: 4 },
  priceText: { fontSize: 16, fontWeight: '700', color: '#00ADB5' },
  chev: { fontSize: 12, color: '#999', marginTop: 6 },
  divider: { height: 1, backgroundColor: '#E0E0E0', marginVertical: 12 },
  rowSmall: { flexDirection: 'row', justifyContent: 'space-between' },
  rowCol: { flex: 1 },
  metaLabel: { fontSize: 12, color: '#666' },
  metaValue: { fontSize: 14, fontWeight: '600', marginTop: 4 },
  vertSeparator: { width: 1, backgroundColor: '#E0E0E0', marginHorizontal: 12, alignSelf: 'stretch' },
  addressBox: { backgroundColor: '#f9f9f9', padding: 10, borderRadius: 6, borderWidth: 1, borderColor: '#EAEAEA' },
  addressText: { fontSize: 13, color: '#333', marginTop: 6 },
  selectedBox: { backgroundColor: '#fafafa', padding: 10, borderRadius: 6, borderWidth: 1, borderColor: '#EFEFEF' },
  selectedTitle: { fontSize: 16, fontWeight: '700', marginTop: 6 },
  inclusions: { fontSize: 13, color: '#666', marginTop: 8 },
  notesInput: { fontSize: 14, color: '#333', padding: 10, backgroundColor: '#fff', borderWidth: 1, borderColor: '#EAEAEA', borderRadius: 6 },
  voucherRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginTop: 12 },
  voucherLeft: { flexDirection: 'row', alignItems: 'center' },
  voucherText: { fontSize: 14, color: '#333' },
  voucherRowOverview: { backgroundColor: '#fff', borderRadius: 8, borderWidth: 1, borderColor: '#E0E0E0', paddingVertical: 8, paddingHorizontal: 12, marginTop: 12, flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' },
  voucherBadge: { backgroundColor: '#00ADB5', paddingHorizontal: 8, paddingVertical: 4, borderRadius: 12, marginLeft: 8 },
  voucherBadgeText: { color: '#fff', fontWeight: '700', fontSize: 12 },
  smallLabel: { fontSize: 13, color: '#666' },
  totalsRow: { flexDirection: 'row', justifyContent: 'space-between', marginTop: 12 },
  totalRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginTop: 10, paddingTop: 10, borderTopWidth: 1, borderTopColor: '#F0F0F0' },
  totalLabel: { fontSize: 16, fontWeight: '800', color: '#333' },
  totalValue: { fontSize: 16, fontWeight: '800', color: '#000' },
  payNote: { fontSize: 12, color: '#666', marginTop: 8 },
  footerRow: { flexDirection: 'row', justifyContent: 'flex-end', gap: 8, marginTop: 12 },
  cancelBtn: { backgroundColor: '#eee', paddingHorizontal: 12, paddingVertical: 8, borderRadius: 6 },
  cancelText: { color: '#666', fontWeight: '600' },
  viewBtn: { backgroundColor: '#3DC1C6', paddingHorizontal: 12, paddingVertical: 8, borderRadius: 6 },
  viewText: { color: '#fff', fontWeight: '700' },
  // footer handled by layout
  pageContainer: { flex: 1, backgroundColor: '#fff' },
});
