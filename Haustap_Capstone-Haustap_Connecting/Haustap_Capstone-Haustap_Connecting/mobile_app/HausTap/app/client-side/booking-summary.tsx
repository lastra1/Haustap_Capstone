import { useLocalSearchParams, useRouter } from "expo-router";
import React from "react";
import { StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function BookingSummary() {
  const router = useRouter();
  const { 
    categoryTitle, 
    categoryPrice, 
    categoryDesc,
    date,
    time,
    mainCategory,
    subCategory,
    service,
  } = useLocalSearchParams();

  // If mainCategory/subCategory aren't provided, try to infer mainCategory from the service group
  const serviceToMain: Record<string, string> = {
    Plumbing: "Indoor Services",
    Electrical: "Indoor Services",
    "Appliance Repair": "Indoor Services",
    "Pest Control": "Indoor Services",
    Makeup: "Beauty Services",
    Lashes: "Beauty Services",
    Hair: "Beauty Services",
    Nails: "Beauty Services",
    "Home Cleaning": "Cleaning Services",
    "Garden Landscaping": "Outdoor Services",
    Massage: "Wellness Services",
    Mobile: "Tech & Gadget Services",
  };

  const effectiveMainCategory = (mainCategory as string) ?? (service ? (serviceToMain[String(service)] ?? "Main Category") : "Main Category");
  const effectiveSubCategory = (subCategory as string) ?? (service as string ?? "");

  return (
    <View style={styles.container}>
      <Text style={styles.header}>Booking Summary</Text>

      <View style={styles.summaryBox}>
        {/* Service Details Section */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Service Details</Text>
          <View style={styles.divider} />
          
          <Text style={styles.label}>Service Category:</Text>
          <View style={styles.categoryHierarchyColumn}>
            <Text style={styles.mainCategory}>{effectiveMainCategory}</Text>
            <Text style={styles.subcategoryLine}>{effectiveSubCategory ? `${effectiveSubCategory} - ${categoryTitle ?? ""}` : (categoryTitle ?? "")}</Text>
          </View>

          {categoryPrice && (
            <>
              <Text style={styles.label}>Price:</Text>
              <Text style={styles.valuePrice}>{categoryPrice}</Text>
            </>
          )}

          <Text style={styles.label}>Inclusions:</Text>
          <Text style={styles.desc}>{categoryDesc}</Text>
        </View>

        {/* Location Section removed per design request */}

        {/* Schedule Section */}
        {(date || time) && (
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Schedule Details</Text>
            <View style={styles.divider} />
            
            {date && (
              <>
                <Text style={styles.label}>Service Date:</Text>
                <Text style={styles.value}>{date}</Text>
              </>
            )}
            
            {time && (
              <>
                <Text style={styles.label}>Service Time:</Text>
                <Text style={styles.value}>{time}</Text>
              </>
            )}
          </View>
        )}
      </View>

      <TouchableOpacity
        style={styles.nextButton}
        onPress={() =>
          router.push((
            `/client-side/booking-process/booking-location?categoryTitle=${encodeURIComponent(
              (categoryTitle as string) || ""
            )}&categoryPrice=${encodeURIComponent(
              ((categoryPrice as string) || "")
            )}&categoryDesc=${encodeURIComponent(((categoryDesc as string) || ""))}` +
            `&mainCategory=${encodeURIComponent(((mainCategory as string) || ""))}` +
            `&subCategory=${encodeURIComponent(((subCategory as string) || ""))}` +
            (service ? `&service=${encodeURIComponent(String(service))}` : ``)
          ) as any)
        }
      >
        <Text style={styles.nextButtonText}>Confirm Booking</Text>
      </TouchableOpacity>

      <TouchableOpacity style={styles.backButton} onPress={() => router.back()}>
        <Text style={styles.backButtonText}>Go Back</Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { 
    flex: 1, 
    backgroundColor: "#fff", 
    padding: 20 
  },
  categoryHierarchy: {
    marginTop: 8,
    // used previously for a horizontal breadcrumb; replaced by column layout
  },
  categoryPath: {
    fontSize: 14,
    color: "#666",
    marginRight: 4,
    lineHeight: 20,
  },
  selectedService: {
    fontSize: 16,
    color: "#00ADB5",
    fontWeight: "600",
    lineHeight: 22,
  },
  categoryHierarchyColumn: {
    marginTop: 8,
    flexDirection: "column",
  },
  mainCategory: {
    fontSize: 20,
    fontWeight: "700",
    color: "#222",
    marginBottom: 6,
  },
  subcategoryLine: {
    fontSize: 16,
    color: "#666",
  },
  header: { 
    fontSize: 22, 
    fontWeight: "bold", 
    marginBottom: 20, 
    color: "black" 
  },
  summaryBox: {
    backgroundColor: "#F5F5F5",
    padding: 20,
    borderRadius: 12,
    marginBottom: 40,
  },
  section: {
    marginBottom: 24,
  },
  sectionTitle: {
    fontSize: 18,
    fontWeight: "700",
    color: "#00ADB5",
    marginBottom: 8,
  },
  divider: {
    height: 1,
    backgroundColor: "#E0E0E0",
    marginBottom: 16,
  },
  label: { 
    fontSize: 14, 
    fontWeight: "600", 
    color: "#666", 
    marginTop: 12 
  },
  value: { 
    fontSize: 16, 
    color: "black", 
    marginTop: 4 
  },
  valuePrice: {
    fontSize: 18,
    color: "#00ADB5",
    fontWeight: "700",
    marginTop: 4,
  },
  desc: { 
    fontSize: 14, 
    color: "#444", 
    marginTop: 8, 
    lineHeight: 20 
  },
  nextButton: {
    backgroundColor: "#00ADB5",
    paddingVertical: 14,
    borderRadius: 10,
    alignItems: "center",
    marginBottom: 10,
  },
  nextButtonText: { 
    color: "white", 
    fontSize: 18, 
    fontWeight: "bold" 
  },
  backButton: {
    borderColor: "#00ADB5",
    borderWidth: 1.5,
    paddingVertical: 12,
    borderRadius: 10,
    alignItems: "center",
  },
  backButtonText: { 
    color: "#00ADB5", 
    fontSize: 16, 
    fontWeight: "600" 
  },
});
