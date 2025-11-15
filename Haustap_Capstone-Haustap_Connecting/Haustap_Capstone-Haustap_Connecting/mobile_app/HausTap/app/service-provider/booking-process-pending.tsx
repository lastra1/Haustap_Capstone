import { Ionicons } from "@expo/vector-icons";
import { router } from "expo-router";
import React, { useCallback, useEffect, useRef, useState } from "react";
import {
  Animated,
  PanResponder,
  PanResponderGestureState,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from "react-native";

export default function BookingsScreen() {
  const [isAccepted, setIsAccepted] = useState(false);
  const pan = useRef(new Animated.Value(0)).current;
  const [sliderWidth, setSliderWidth] = useState(0);
  const panResponderRef = useRef<any>(null);

  // ✅ Slide button setup
  useEffect(() => {
    const knobWidth = 50;

    panResponderRef.current = PanResponder.create({
      onStartShouldSetPanResponder: () => true,
      onMoveShouldSetPanResponder: () => true,

      onPanResponderMove: (_evt, gesture: PanResponderGestureState) => {
        const maxSlide = Math.max(0, sliderWidth - knobWidth);
        const newValue = Math.min(Math.max(gesture.dx, 0), maxSlide);
        pan.setValue(newValue);
      },

      onPanResponderRelease: (_evt, gesture: PanResponderGestureState) => {
        const maxSlide = Math.max(0, sliderWidth - knobWidth);
        const threshold = maxSlide * 0.8;

        if (gesture.dx >= threshold) {
          // Complete slide → navigate
          Animated.timing(pan, {
            toValue: maxSlide,
            duration: 200,
            useNativeDriver: true,
          }).start(() => {
            if (!isAccepted) {
              setIsAccepted(true);
              try {
                router.push("/service-provider/before-ongoing");
              } catch (err) {
                console.error("Navigation failed", err);
              }
            }
          });
        } else {
          // Snap back
          Animated.spring(pan, {
            toValue: 0,
            useNativeDriver: true,
            friction: 8,
            tension: 40,
          }).start();
        }
      },
    });
  }, [sliderWidth, pan, isAccepted]);

  const [isCancelling, setIsCancelling] = useState(false);
  const handleCancel = useCallback(() => {
    if (isCancelling) return;
    setIsCancelling(true);
    try {
      router.push("/service-provider/booking-process-cancelled");
    } catch (err) {
      console.error("Failed to navigate to cancelled screen", err);
      setIsCancelling(false);
    }
  }, [isCancelling]);

  return (
    <View style={styles.page}>
      <ScrollView
        style={styles.container}
        contentContainerStyle={{ paddingBottom: 20 }}
        showsVerticalScrollIndicator={false}
      >
        {/* Header */}
        <Text style={styles.header}>Bookings</Text>

        {/* Tabs */}
        <View style={styles.tabs}>
          <TouchableOpacity style={[styles.tabButton, styles.tabActive]}>
            <Text style={[styles.tabText, styles.tabTextActive]}>Pending</Text>
          </TouchableOpacity>

          <TouchableOpacity
            style={styles.tabButton}
            onPress={() => router.push("/service-provider/before-ongoing")}
          >
            <Text style={styles.tabText}>Ongoing</Text>
          </TouchableOpacity>

          <TouchableOpacity
            style={styles.tabButton}
            onPress={() => router.push("/service-provider/booking-process-completed")}
          >
            <Text style={styles.tabText}>Completed</Text>
          </TouchableOpacity>

          <TouchableOpacity
            style={styles.tabButton}
            onPress={() => router.push("/service-provider/booking-process-cancelled")}
          >
            <Text style={styles.tabText}>Cancelled</Text>
          </TouchableOpacity>

          <TouchableOpacity
            style={styles.tabButton}
            onPress={() => router.push("/service-provider/booking-process-return")}
          >
            <Text style={styles.tabText}>Return</Text>
          </TouchableOpacity>
        </View>

        {/* Booking Card */}
        <View style={styles.card}>
          {/* Header */}
          <View style={styles.cardHeader}>
            <View style={{ flex: 1 }}>
              <Text style={styles.clientName}>
                <Text style={{ fontWeight: "700" }}>Client:</Text> Jenn Bornilla
              </Text>
              <Text style={styles.serviceTitle}>Home Cleaning</Text>
              <Text style={styles.serviceSubtitle}>Bungalow - Basic Cleaning</Text>
            </View>
            <Ionicons name="chevron-down" size={20} color="#000" />
          </View>

          {/* Date & Time */}
          <View style={styles.row}>
            <View style={styles.half}>
              <Text style={styles.label}>Date</Text>
              <Text style={styles.value}>May 21, 2025</Text>
            </View>
            <View style={styles.half}>
              <Text style={styles.label}>Time</Text>
              <Text style={styles.value}>8:00 AM</Text>
            </View>
          </View>

          {/* Address */}
          <View style={styles.section}>
            <Text style={styles.label}>Address</Text>
            <Text style={styles.value}>
              B1 L50 Mango St. Phase 1 Saint Joseph Village 10{"\n"}
              Barangay Langgam, City of San Pedro, Laguna 4023
            </Text>
          </View>

          {/* Selected Section */}
          <View style={styles.section}>
            <Text style={styles.label}>Selected:</Text>
            <Text style={styles.valueBold}>Bungalow 80–150 sqm</Text>
            <Text style={styles.value}>Basic Cleaning – 1 Cleaner</Text>
          </View>

          {/* Inclusions */}
          <View style={styles.section}>
            <Text style={styles.label}>Inclusions:</Text>
            <Text style={styles.value}>
              Living Room: walls, mop, dusting furniture, trash removal{"\n"}
              Bedrooms: bed making, sweeping, dusting, trash removal{"\n"}
              Hallways: mop & sweep, remove cobwebs{"\n"}
              Windows & Mirrors: quick wipe
            </Text>
          </View>

          {/* Notes */}
          <View style={styles.section}>
            <Text style={styles.label}>Notes:</Text>
            <TextInput style={styles.textArea} placeholder="Enter notes..." multiline />
          </View>

          {/* Voucher */}
          <View style={styles.voucherBox}>
            <Ionicons name="pricetag-outline" size={18} color="#666" />
            <Text style={styles.voucherText}>No voucher added</Text>
          </View>

          {/* Price Section */}
          <View style={styles.priceSection}>
            <View style={styles.rowBetween}>
              <Text style={styles.subLabel}>Sub Total</Text>
              <Text style={styles.subAmount}>₱1,000.00</Text>
            </View>
            <View style={styles.rowBetween}>
              <Text style={styles.subLabel}>Voucher Discount</Text>
              <Text style={styles.subAmount}>₱0</Text>
            </View>
            <View style={styles.divider} />
            <View style={styles.rowBetween}>
              <Text style={styles.totalLabel}>TOTAL</Text>
              <Text style={styles.totalAmount}>₱1,000.00</Text>
            </View>
          </View>

          {/* Info Note */}
          <Text style={styles.noteInfo}>
            Full payment will be collected directly by the service provider upon completion of the service.
          </Text>

          {/* Accept Booking */}
          <View style={styles.acceptBox}>
            <Text style={styles.acceptTitle}>Accept Booking?</Text>
            <Text style={styles.acceptSubtitle}>Be the first one to accept</Text>

            {/* Slide Button */}
            <View
              style={styles.sliderContainer}
              {...(panResponderRef.current ? panResponderRef.current.panHandlers : {})}
              onLayout={(e) => setSliderWidth(e.nativeEvent.layout.width)}
            >
              <View style={styles.sliderTrack}>
                <Text style={styles.sliderText}>
                  {isAccepted ? "Booking Arrived!" : "Slide to Mark as Arrived"}
                </Text>
              </View>
              <Animated.View
                style={[
                  styles.slider,
                  { transform: [{ translateX: pan }] },
                ]}
              >
                <Ionicons name="arrow-forward" size={24} color="#fff" />
              </Animated.View>
            </View>

            {/* Cancel Button */}
            <TouchableOpacity
              style={styles.cancelButton}
              onPress={handleCancel}
              disabled={isCancelling}
            >
              <Text style={styles.cancelText}>
                {isCancelling ? "Cancelling..." : "Cancel"}
              </Text>
            </TouchableOpacity>
          </View>
        </View>
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  page: { flex: 1, backgroundColor: "#F9F9F9" },
  container: { paddingHorizontal: 16, paddingTop: 20 },
  header: { fontSize: 22, fontWeight: "700", marginBottom: 10 },
  tabs: { flexDirection: "row", justifyContent: "space-between", marginBottom: 15 },
  tabButton: { paddingBottom: 4, borderBottomWidth: 2, borderColor: "transparent" },
  tabActive: { borderColor: "#00B0B9" },
  tabText: { fontSize: 13, color: "#666" },
  tabTextActive: { color: "#00B0B9", fontWeight: "600" },
  card: {
    backgroundColor: "#F5F5F5",
    borderRadius: 10,
    padding: 14,
    shadowColor: "#000",
    shadowOpacity: 0.08,
    shadowRadius: 2,
    elevation: 2,
  },
  cardHeader: { flexDirection: "row", justifyContent: "space-between", alignItems: "center" },
  clientName: { fontSize: 13, color: "#000" },
  serviceTitle: { fontSize: 14, fontWeight: "600", color: "#000" },
  serviceSubtitle: { fontSize: 12, color: "#555" },
  row: { flexDirection: "row", justifyContent: "space-between", marginTop: 8 },
  half: { width: "48%" },
  label: { fontSize: 12, color: "#666", marginBottom: 2 },
  value: { fontSize: 13, color: "#000" },
  valueBold: { fontSize: 13, fontWeight: "600", color: "#000" },
  section: { marginTop: 8 },
  textArea: {
    borderWidth: 1,
    borderColor: "#DDD",
    borderRadius: 6,
    height: 45,
    padding: 6,
    textAlignVertical: "top",
    fontSize: 13,
  },
  voucherBox: {
    flexDirection: "row",
    alignItems: "center",
    borderWidth: 1,
    borderColor: "#DDD",
    borderRadius: 6,
    padding: 8,
    marginTop: 8,
  },
  voucherText: { marginLeft: 6, fontSize: 12, color: "#555" },
  priceSection: { marginTop: 12 },
  subLabel: { fontSize: 12, color: "#666" },
  subAmount: { fontSize: 12, color: "#000" },
  divider: { borderBottomWidth: 1, borderColor: "#EEE", marginVertical: 5 },
  totalLabel: { fontWeight: "700", fontSize: 14 },
  totalAmount: { fontWeight: "700", fontSize: 14 },
  rowBetween: { flexDirection: "row", justifyContent: "space-between" },
  noteInfo: { fontSize: 11, color: "#777", marginTop: 6, marginBottom: 10, lineHeight: 16 },
  acceptBox: { borderTopWidth: 1, borderColor: "#EEE", paddingTop: 8 },
  acceptTitle: { fontWeight: "700", fontSize: 13, color: "#000" },
  acceptSubtitle: { fontSize: 12, color: "#666", marginBottom: 6 },
  sliderContainer: {
    width: "100%",
    height: 50,
    backgroundColor: "#f0f0f0",
    borderRadius: 25,
    overflow: "hidden",
    position: "relative",
    marginVertical: 12,
  },
  slider: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: "#00B0B9",
    position: "absolute",
    left: 0,
    justifyContent: "center",
    alignItems: "center",
  },
  sliderTrack: { width: "100%", height: "100%", alignItems: "center", justifyContent: "center" },
  sliderText: { color: "#666", fontWeight: "600", fontSize: 14 },
  cancelButton: {
    borderWidth: 1,
    borderColor: "#999",
    borderRadius: 6,
    paddingVertical: 8,
    alignItems: "center",
  },
  cancelText: { fontWeight: "600", color: "#333", fontSize: 13 },
  bottomNav: { display: "none" },
  navItem: { display: "none" },
  navText: { display: "none" },
});
