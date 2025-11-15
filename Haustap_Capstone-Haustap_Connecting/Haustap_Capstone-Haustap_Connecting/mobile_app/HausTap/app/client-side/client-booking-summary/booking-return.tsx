import { Ionicons } from '@expo/vector-icons';
import AsyncStorage from '@react-native-async-storage/async-storage';
import DateTimePicker from '@react-native-community/datetimepicker';
import { useFocusEffect } from '@react-navigation/native';
import { useRouter } from 'expo-router';
import React, { useCallback, useState } from 'react';
import { Modal, Platform, ScrollView, StyleSheet, Text, TouchableOpacity, View } from 'react-native';

// Example return booking shown when no stored return bookings exist
const mockReturn = [
	{
		id: 'return-001',
		mainCategory: 'Home Cleaning',
		subCategory: 'Bungalow - Basic Cleaning',
		serviceTitle: 'Bungalow - Basic Cleaning',
		providerId: 'provider-1',
		providerName: 'Ana Santos',
		date: new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }),
		time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
		address: 'B1 L50 Mango St., Saint Joseph Village 10, San Pedro, Laguna',
		total: 1000,
		desc: 'Basic Cleaning — living room, kitchen, bedroom, mopping, dusting.',
		notes: '',
		voucherCode: '',
		voucherValue: 0,
		status: 'completed',
		completedAt: new Date().toISOString(),
		// return-specific fields
		returnRequestedAt: new Date().toISOString(),
		returnReason: 'Service Not As Described',
		returnDescription: 'Did not clean the kitchen properly',
		isWithinFreeWindow: false // whether return is free (within 24h) or charged
	},
];

export default function BookingReturn() {
	const router = useRouter();
	const [bookings, setBookings] = useState<typeof mockReturn>(mockReturn);
	const [expandedId, setExpandedId] = useState<string | null>(null);
	const [filterVisible, setFilterVisible] = useState(false);
	const [filterFrom, setFilterFrom] = useState<string | null>(null);
	const [filterTo, setFilterTo] = useState<string | null>(null);
	const [filterApplied, setFilterApplied] = useState(false);
  
	// date picker states
	const [fromDate, setFromDate] = useState<Date | null>(null);
	const [toDate, setToDate] = useState<Date | null>(null);
	const [showFromPicker, setShowFromPicker] = useState(false);
	const [showToPicker, setShowToPicker] = useState(false);

	useFocusEffect(
		useCallback(() => {
			let mounted = true;
			const load = async () => {
				try {
					const raw = await AsyncStorage.getItem('HT_bookings');
					if (raw) {
						const parsed = JSON.parse(raw);
						if (Array.isArray(parsed) && mounted) {
							// show bookings that have a return reason requested
							const returned = parsed.filter((b: any) => b.returnReason);
							setBookings(returned.length ? returned : mockReturn);
							return;
						}
					}
					if (mounted) setBookings(mockReturn);
				} catch (err) {
					console.warn('Failed to load bookings', err);
					if (mounted) setBookings(mockReturn);
				}
			};
			load();
			return () => {
				mounted = false;
			};
		}, [])
	);

	const formatCurrency = (v: number) => '₱' + v.toFixed(2);

	// compute displayed list based on filter
	const displayedBookings = (() => {
		if (!filterApplied || (!filterFrom && !filterTo)) return bookings;
		try {
			const from = filterFrom ? new Date(filterFrom) : null;
			const to = filterTo ? new Date(filterTo) : null;
			return bookings.filter((b) => {
				const bd = new Date(b.date);
				if (isNaN(bd.getTime())) return false;
				if (from && bd < from) return false;
				if (to && bd > to) return false;
				return true;
			});
    } catch {
      return bookings;
    }
	})();

	return (
		<View style={styles.pageContainer}>
			<ScrollView style={styles.container} contentContainerStyle={{ padding: 16, paddingBottom: 140 }}>
				<View style={styles.headerRow}>
					<Text style={styles.headerTitle}>Bookings</Text>
					<TouchableOpacity style={styles.filterBtn} onPress={() => setFilterVisible(true)}>
						<Ionicons name="filter" size={20} color="#3DC1C6" />
					</TouchableOpacity>
				</View>

				<View style={styles.tabsRow}>
					<ScrollView horizontal showsHorizontalScrollIndicator={false}>
						<TouchableOpacity style={styles.tabButton} onPress={() => router.push('/client-side/client-booking-summary/booking-pending')}>
							<Text style={styles.tabText}>Pending</Text>
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
						<TouchableOpacity style={[styles.tabButton, styles.tabActive]}>
							<Text style={styles.tabTextActive}>Return</Text>
						</TouchableOpacity>
					</ScrollView>
				</View>

				{displayedBookings.map((b) => {
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
										<Text style={styles.priceText}>{formatCurrency(b.total)}</Text>
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
										<Text style={[styles.metaLabel, { marginBottom: 6 }]}>Service Details</Text>
										<Text style={styles.selectedTitle}>{b.serviceTitle || b.subCategory}</Text>
										<Text style={styles.inclusions}>{b.desc}</Text>
									</View>

                  <View style={[styles.cancellationBox, { marginTop: 12 }]}>
                    <Text style={[styles.metaLabel, { marginBottom: 6 }]}>Return Details</Text>
                    <Text style={styles.cancelReasonLabel}>Reason:</Text>
                    <Text style={styles.cancelReason}>{b.returnReason}</Text>
                    {b.returnDescription && (
                      <>
                        <Text style={[styles.cancelReasonLabel, { marginTop: 8 }]}>Description:</Text>
                        <Text style={styles.cancelDescription}>{b.returnDescription}</Text>
                      </>
                    )}
                    <View style={styles.returnFeeBox}>
                      <Text style={[styles.returnFeeLabel, b.isWithinFreeWindow ? { color: '#4CAF50' } : { color: '#FF4444' }]}>
                        {b.isWithinFreeWindow ? '✓ Free Return (Within 24 Hours)' : '₱300.00 Return Fee (After 24 Hours)'}
                      </Text>
                    </View>
                  </View>									<View style={{ marginTop: 12 }}>
										<Text style={styles.metaLabel}>Notes:</Text>
										<View style={styles.notesInput}>
											<Text style={styles.notesText}>{b.notes || 'No notes added.'}</Text>
										</View>
									</View>

                  <View style={styles.totalsRow}>
                    <View>
                      <Text style={styles.smallLabel}>Sub Total</Text>
                      <Text style={styles.smallLabel}>Voucher Discount</Text>
                      {!b.isWithinFreeWindow && (
                        <Text style={[styles.smallLabel, { color: '#FF4444' }]}>Return Fee</Text>
                      )}
                    </View>
                    <View style={{ alignItems: 'flex-end' }}>
                      <Text style={styles.smallLabel}>{formatCurrency(b.total)}</Text>
                      <Text style={styles.smallLabel}>{b.voucherValue ? formatCurrency(b.voucherValue) : '₱0.00'}</Text>
                      {!b.isWithinFreeWindow && (
                        <Text style={[styles.smallLabel, { color: '#FF4444' }]}>₱300.00</Text>
                      )}
                    </View>
                  </View>

                  <View style={styles.totalRow}>
                    <Text style={styles.totalLabel}>TOTAL</Text>
                    <Text style={styles.totalValue}>
                      {formatCurrency(Math.max(0, b.total - (b.voucherValue || 0) + (b.isWithinFreeWindow ? 0 : 300)))}
                    </Text>
                  </View>
                </View>
              )}
            </View>
          );
				})}
			</ScrollView>

			{/* Date Filter Modal */}
			<Modal visible={filterVisible} transparent animationType="fade">
				<View style={styles.modalOverlay}>
					<View style={styles.modalContent}>
						<Text style={styles.modalTitle}>Filter by Date</Text>

						<View style={{ marginTop: 12, width: '100%' }}>
							<Text style={styles.modalLabel}>From:</Text>
							<TouchableOpacity style={styles.dateInput} onPress={() => setShowFromPicker(true)}>
								<Text style={{ color: filterFrom ? '#000' : '#888' }}>{filterFrom ?? 'YYYY-MM-DD'}</Text>
							</TouchableOpacity>
							{showFromPicker && (
								<DateTimePicker
									value={fromDate ?? new Date()}
									mode="date"
									display={Platform.OS === 'ios' ? 'spinner' : 'default'}
									onChange={(_e: any, d: Date | undefined) => {
										if (d) {
											setFromDate(d);
											setFilterFrom(d.toISOString().slice(0, 10));
										}
										if (Platform.OS !== 'ios') setShowFromPicker(false);
									}}
								/>
							)}
						</View>

						<View style={{ marginTop: 12, width: '100%' }}>
							<Text style={styles.modalLabel}>To:</Text>
							<TouchableOpacity style={styles.dateInput} onPress={() => setShowToPicker(true)}>
								<Text style={{ color: filterTo ? '#000' : '#888' }}>{filterTo ?? 'YYYY-MM-DD'}</Text>
							</TouchableOpacity>
							{showToPicker && (
								<DateTimePicker
									value={toDate ?? new Date()}
									mode="date"
									display={Platform.OS === 'ios' ? 'spinner' : 'default'}
									onChange={(_e: any, d: Date | undefined) => {
										if (d) {
											setToDate(d);
											setFilterTo(d.toISOString().slice(0, 10));
										}
										if (Platform.OS !== 'ios') setShowToPicker(false);
									}}
								/>
							)}
						</View>

						<TouchableOpacity
							style={styles.applyBtn}
							onPress={() => {
								setFilterApplied(true);
								setFilterVisible(false);
							}}
						>
							<Text style={styles.applyText}>Apply Filter</Text>
						</TouchableOpacity>

						<TouchableOpacity
							style={styles.clearBtn}
							onPress={() => {
								setFilterFrom(null);
								setFilterTo(null);
								setFromDate(null);
								setToDate(null);
								setFilterApplied(false);
								setFilterVisible(false);
							}}
						>
							<Text style={styles.clearText}>Clear Filter</Text>
						</TouchableOpacity>
					</View>
				</View>
			</Modal>

					{/* Footer provided by layout */}
		</View>
	);
}

const styles = StyleSheet.create({
	pageContainer: { flex: 1, backgroundColor: '#fff' },
	container: { flex: 1 },
	headerRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', paddingVertical: 8 },
	headerTitle: { fontSize: 20, fontWeight: '700' },
	filterBtn: { padding: 8 },

	// Tabs
	tabsRow: { flexDirection: 'row', marginVertical: 12, gap: 8 },
	tabButton: { paddingVertical: 6, paddingHorizontal: 10, borderRadius: 8, backgroundColor: '#f0f0f0' },
	tabActive: { backgroundColor: '#fff' },
	tabText: { color: '#666' },
	tabTextActive: { color: '#3DC1C6', fontWeight: '700' },

	// Card
	card: { backgroundColor: '#fff', borderRadius: 8, padding: 12, marginBottom: 12, borderWidth: 1, borderColor: '#E0E0E0' },
	cardHeaderRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center' },
	mainCategory: { fontSize: 18, fontWeight: '700' },
	subcategory: { fontSize: 14, color: '#666', marginTop: 6 },
	bookingId: { fontSize: 12, color: '#666', marginTop: 4 },
	priceText: { fontSize: 16, fontWeight: '700', color: '#00ADB5' },
	chev: { fontSize: 12, color: '#999', marginTop: 6 },

	// Content sections
	divider: { height: 1, backgroundColor: '#E0E0E0', marginVertical: 12 },
	rowSmall: { flexDirection: 'row', justifyContent: 'space-between' },
	rowCol: { flex: 1 },
	metaLabel: { fontSize: 12, color: '#666' },
	metaValue: { fontSize: 14, fontWeight: '600', marginTop: 4 },
	vertSeparator: { width: 1, backgroundColor: '#E0E0E0', marginHorizontal: 12, alignSelf: 'stretch' },
  
	// Boxes
	addressBox: { backgroundColor: '#f9f9f9', padding: 10, borderRadius: 6, borderWidth: 1, borderColor: '#EAEAEA' },
	addressText: { fontSize: 13, color: '#333', marginTop: 6 },
	selectedBox: { backgroundColor: '#fafafa', padding: 10, borderRadius: 6, borderWidth: 1, borderColor: '#EFEFEF' },
	selectedTitle: { fontSize: 16, fontWeight: '700', marginTop: 6 },
	inclusions: { fontSize: 13, color: '#666', marginTop: 8 },
  
  // Return Box (re-using cancellation styles)
  cancellationBox: { 
    backgroundColor: '#FFF8F8', 
    padding: 10, 
    borderRadius: 6, 
    borderWidth: 1, 
    borderColor: '#FFE0E0' 
  },
  cancelReasonLabel: { 
    fontSize: 13, 
    color: '#666', 
    fontWeight: '600' 
  },
  cancelReason: { 
    fontSize: 14, 
    color: '#333', 
    marginTop: 2 
  },
  cancelDescription: { 
    fontSize: 13, 
    color: '#666', 
    marginTop: 2,
    fontStyle: 'italic'
  },
  // Return fee specific styles
  returnFeeBox: {
    marginTop: 12,
    paddingTop: 12,
    borderTopWidth: 1,
    borderTopColor: '#FFE0E0',
  },
  returnFeeLabel: {
    fontSize: 14,
    fontWeight: '600',
    color: '#333',
  },
  returnFeeAmount: {
    fontSize: 13,
    color: '#FF4444',
    marginTop: 4,
  },	// Notes
	notesInput: { backgroundColor: '#f9f9f9', padding: 10, borderRadius: 6, borderWidth: 1, borderColor: '#EAEAEA' },
	notesText: { fontSize: 13, color: '#666' },

	// Totals
	smallLabel: { fontSize: 13, color: '#666' },
	totalsRow: { flexDirection: 'row', justifyContent: 'space-between', marginTop: 12 },
	totalRow: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginTop: 10 },
	totalLabel: { fontSize: 16, fontWeight: '800', color: '#333' },
	totalValue: { fontSize: 16, fontWeight: '700', color: '#00ADB5' },

	// Filter Modal
	modalOverlay: { flex: 1, backgroundColor: 'rgba(0,0,0,0.5)', justifyContent: 'center', alignItems: 'center' },
	modalContent: { backgroundColor: '#fff', borderRadius: 12, padding: 20, width: '80%', alignItems: 'center' },
	modalTitle: { fontSize: 16, fontWeight: '700' },
	modalLabel: { fontSize: 13, color: '#333', marginBottom: 6 },
	dateInput: { width: '100%', borderWidth: 1, borderColor: '#E0E0E0', borderRadius: 6, padding: 8, backgroundColor: '#fff' },
	applyBtn: { marginTop: 16, backgroundColor: '#3DC1C6', paddingVertical: 10, paddingHorizontal: 28, borderRadius: 8 },
	applyText: { color: '#fff', fontWeight: '700' },
	clearBtn: { marginTop: 10, paddingVertical: 8, paddingHorizontal: 20 },
	clearText: { color: '#666' },

		// footer handled by layout
});

