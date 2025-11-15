import { Ionicons } from "@expo/vector-icons";
import { useLocalSearchParams, useRouter } from "expo-router";
import React, { useState } from "react";
import {
    ScrollView,
    StyleSheet,
    Switch,
    Text,
    TextInput,
    TouchableOpacity,
    View,
} from "react-native";

export default function BookingOverview() {
  const router = useRouter();
  const { categoryTitle, categoryPrice, categoryDesc, address, location, date, time, mainCategory, subCategory, voucherCode, voucherValue } = useLocalSearchParams();
  const [notes, setNotes] = useState("");
  // voucherValue comes as string param (e.g. "50"); parse to number
  const parsedVoucherValue = React.useMemo(() => {
    if (!voucherValue) return 0;
    try {
      const n = String(voucherValue).replace(/[^0-9.]/g, "");
      return Number(n) || 0;
    } catch {
      return 0;
    }
  }, [voucherValue]);

  const [voucherEnabled, setVoucherEnabled] = useState(Boolean(parsedVoucherValue));
  // keep selected voucher label in state so we can show its name in the overview
  const [selectedVoucherCode, setSelectedVoucherCode] = useState<string | null>(voucherCode ? String(voucherCode) : null);

  // sync when params change (e.g., after returning from voucher screen)
  React.useEffect(() => {
    setVoucherEnabled(Boolean(parsedVoucherValue));
    setSelectedVoucherCode(voucherCode ? String(voucherCode) : null);
  }, [parsedVoucherValue, voucherCode]);

  // when user toggles the switch on, open the voucher picker so they can choose
  const handleVoucherToggle = (value: boolean) => {
    if (value) {
      // open voucher selector; when user applies one, it will return voucherCode/voucherValue
      router.push({
        pathname: "/client-side/booking-process/booking-voucher",
        params: { categoryTitle, categoryPrice, categoryDesc, address, location, date, time, mainCategory, subCategory },
      } as any);
      return;
    }

    // turning off simply disables the voucher discount (keeps selection visible)
    // remove selected voucher when toggled off per request
    setVoucherEnabled(false);
    setSelectedVoucherCode(null);
  };

  // Placeholder subtotal calculation: use categoryPrice if available (strip currency)
  const parsePrice = (p: any) => {
    if (!p) return 0;
    try {
      const num = String(p).replace(/[^0-9.]/g, "");
      return Number(num) || 0;
    } catch {
      return 0;
    }
  };

  const subtotal = parsePrice(categoryPrice);
  const voucherDiscount = voucherEnabled ? parsedVoucherValue : 0;
  const total = Math.max(0, subtotal - voucherDiscount);

  const formatCurrency = (v: number) => `₱${v.toFixed(2)}`;

  return (
  <ScrollView style={styles.container} contentContainerStyle={styles.contentContainer} showsVerticalScrollIndicator={false}>
      <View style={styles.header}>
        <TouchableOpacity onPress={() => router.back()}>
          <Ionicons name="arrow-back" size={24} color="black" />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Booking Overview</Text>
      </View>

      <Text style={styles.subtitle}>Your Booking overview</Text>

  <View style={styles.card}>
        <View style={styles.cardHeaderRow}>
          <View style={{ flex: 1 }}>
            <Text style={styles.mainCategory}>{mainCategory || "Indoor Services"}</Text>
            <Text style={styles.subcategory}>{(subCategory ? `${subCategory} - ` : "") + (categoryTitle || "Service")}</Text>
          </View>
          <View>
            <Text style={styles.priceText}>{categoryPrice ? `${categoryPrice}` : ""}</Text>
          </View>
        </View>

        <View style={styles.divider} />

  <View style={styles.rowSmall}>
          <View style={styles.rowCol}>
            <Text style={styles.metaLabel}>Date</Text>
            <Text style={styles.metaValue}>{date || "--"}</Text>
          </View>
          <View style={styles.vertSeparator} />
          <View style={styles.rowCol}>
            <Text style={styles.metaLabel}>Time</Text>
            <Text style={styles.metaValue}>{time || "--"}</Text>
          </View>
  </View>

        <View style={[styles.addressBox, { marginTop: 12 }]}>
          <Text style={styles.metaLabel}>Address</Text>
          <Text style={styles.addressText}>{address || location || "No address provided"}</Text>
        </View>

        <View style={[styles.selectedBox, { marginTop: 12 }]}>
          <Text style={[styles.metaLabel, { marginBottom: 6 }]}>You selected</Text>
          <Text style={styles.selectedTitle}>{categoryTitle || "Selected service"}</Text>
          {categoryDesc && (
            <Text style={styles.inclusions}>{categoryDesc}</Text>
          )}
        </View>

        <View style={{ marginTop: 12 }}>
          <Text style={styles.metaLabel}>Notes:</Text>
          <TextInput
            placeholder="Add notes for the provider"
            value={notes}
            onChangeText={setNotes}
            style={styles.notesInput}
            multiline
          />
        </View>
      </View>

      <View style={styles.voucherRow}>
        <TouchableOpacity
          style={styles.voucherLeft}
          onPress={() =>
            router.push({
              pathname: "/client-side/booking-process/booking-voucher",
              params: { categoryTitle, categoryPrice, categoryDesc, address, location, date, time, mainCategory, subCategory },
            } as any)
          }
        >
          <Ionicons name="pricetag-outline" size={18} color="#333" style={{ marginRight: 8 }} />
          <Text style={styles.voucherText}>{selectedVoucherCode ? selectedVoucherCode : "Add a Voucher"}</Text>
          {selectedVoucherCode && parsedVoucherValue > 0 && (
            <View style={styles.voucherBadge}>
              <Text style={styles.voucherBadgeText}>{formatCurrency(parsedVoucherValue)}</Text>
            </View>
          )}
        </TouchableOpacity>
        <Switch value={voucherEnabled} onValueChange={handleVoucherToggle} />
      </View>

      <View style={styles.totalsRow}>
        <View>
          <Text style={styles.smallLabel}>Sub Total</Text>
          <Text style={styles.smallLabel}>Voucher Discount</Text>
        </View>
        <View style={{ alignItems: "flex-end" }}>
          <Text style={styles.smallLabel}>{formatCurrency(subtotal)}</Text>
          <Text style={styles.smallLabel}>{voucherEnabled ? formatCurrency(voucherDiscount) : "₱0.00"}</Text>
        </View>
      </View>

      <View style={styles.totalRow}>
        <Text style={styles.totalLabel}>TOTAL</Text>
    <Text style={styles.totalValue}>{formatCurrency(total)}</Text>
      </View>

      <Text style={styles.payNote}>Full payment will be collected directly by the service provider upon completion of the service.</Text>

      <TouchableOpacity
        style={styles.nextBtn}
        onPress={() =>
          router.push({
            pathname: "/client-side/booking-process/booking-choose-sp",
            params: { 
              categoryTitle, 
              categoryPrice, 
              categoryDesc, 
              address, 
              location, 
              date, 
              time, 
              mainCategory, 
              subCategory,
            },
          } as any)
        }
      >
        <Text style={styles.nextText}>Next</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#fff",
    paddingHorizontal: 16,
    paddingTop: 40,
  },
  contentContainer: {
    paddingBottom: 100,
  },
  header: {
    flexDirection: "row",
    alignItems: "center",
    marginBottom: 8,
  },
  headerTitle: {
    fontSize: 20,
    fontWeight: "600",
    marginLeft: 10,
  },
  subtitle: {
    fontSize: 14,
    color: "#666",
    marginBottom: 12,
  },
  card: {
    backgroundColor: "#F5F5F5",
    borderRadius: 8,
    padding: 12,
    marginBottom: 12,
  },
  cardHeaderRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    marginBottom: 8,
  },
  // serviceMain/serviceSub kept for backward compatibility; prefer mainCategory/subcategory styles
  serviceMain: {
    fontSize: 18,
    fontWeight: "700",
    color: "#111",
  },
  serviceSub: {
    fontSize: 14,
    color: "#666",
  },
  mainCategory: {
    fontSize: 20,
    fontWeight: "800",
    color: "#111",
  },
  subcategory: {
    fontSize: 16,
    color: "#666",
    marginTop: 4,
  },
  priceText: {
    fontSize: 16,
    fontWeight: "700",
    color: "#00ADB5",
  },
  divider: {
    height: 1,
    backgroundColor: "#E0E0E0",
    marginVertical: 12,
  },
  rowSmall: {
    flexDirection: "row",
    justifyContent: "space-between",
  },
  vertSeparator: {
    width: 1,
    backgroundColor: "#E0E0E0",
    marginHorizontal: 12,
    alignSelf: "stretch",
  },
  rowCol: {
    flex: 1,
  },
  metaLabel: {
    fontSize: 12,
    color: "#666",
  },
  metaValue: {
    fontSize: 14,
    fontWeight: "600",
    marginTop: 4,
  },
  addressBox: {
    backgroundColor: "#fff",
    padding: 10,
    borderRadius: 6,
    borderWidth: 1,
    borderColor: "#EAEAEA",
  },
  addressText: {
    fontSize: 13,
    color: "#333",
    marginTop: 6,
  },
  selectedBox: {
    backgroundColor: "#fff",
    padding: 10,
    borderRadius: 6,
    borderWidth: 1,
    borderColor: "#EAEAEA",
  },
  selectedTitle: {
    fontSize: 14,
    fontWeight: "700",
    marginBottom: 6,
  },
  inclusions: {
    fontSize: 13,
    color: "#444",
    lineHeight: 18,
  },
  notesInput: {
    backgroundColor: "#fff",
    borderRadius: 6,
    borderWidth: 1,
    borderColor: "#EAEAEA",
    padding: 10,
    minHeight: 60,
    marginTop: 6,
  },
  voucherBtn: {
    backgroundColor: "#fff",
    borderRadius: 8,
    borderWidth: 1,
    borderColor: "#E0E0E0",
    padding: 12,
    alignItems: "center",
    marginBottom: 12,
  },
  voucherText: {
    color: "#333",
    fontWeight: "600",
  },
  voucherRow: {
    backgroundColor: "#fff",
    borderRadius: 8,
    borderWidth: 1,
    borderColor: "#E0E0E0",
    paddingVertical: 8,
    paddingHorizontal: 12,
    marginBottom: 12,
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
  },
  voucherLeft: {
    flexDirection: "row",
    alignItems: "center",
  },
  voucherBadge: {
    backgroundColor: "#00ADB5",
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 12,
    marginLeft: 8,
  },
  voucherBadgeText: {
    color: "#fff",
    fontWeight: "700",
    fontSize: 12,
  },
  totalsRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    paddingHorizontal: 4,
    marginBottom: 8,
  },
  smallLabel: {
    color: "#444",
    fontSize: 14,
    marginBottom: 6,
  },
  totalRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    paddingHorizontal: 4,
    marginBottom: 12,
  },
  totalLabel: {
    fontSize: 16,
    fontWeight: "700",
  },
  totalValue: {
    fontSize: 18,
    fontWeight: "700",
    color: "#111",
  },
  payNote: {
    fontSize: 12,
    color: "#666",
    marginBottom: 12,
  },
  nextBtn: {
    backgroundColor: "#00ADB5",
    borderRadius: 8,
    paddingVertical: 14,
    alignItems: "center",
    marginBottom: 24,
  },
  nextText: {
    color: "#fff",
    fontSize: 16,
    fontWeight: "700",
  },
});
