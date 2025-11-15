import { Ionicons } from "@expo/vector-icons";
import { Picker } from "@react-native-picker/picker";
import { useLocalSearchParams, useRouter } from "expo-router";
import React, { useState } from "react";
import {
    ScrollView,
    StyleSheet,
    Text,
    TouchableOpacity,
    View,
} from "react-native";

export default function ScheduleBooking() {
  const router = useRouter();
  const { categoryTitle, categoryPrice, categoryDesc, address, location, mainCategory, subCategory, service } = useLocalSearchParams();
  const [selectedDate, setSelectedDate] = useState<string | null>(null);
  const [selectedTime, setSelectedTime] = useState<string>("");
  const [isFullyBooked, setIsFullyBooked] = useState(false);

  // Generate dates for the next 7 days
  const dates = React.useMemo(() => {
    const result = [];
    const today = new Date();
    for (let i = 0; i < 7; i++) {
      const date = new Date(today);
      date.setDate(today.getDate() + i);
      result.push({
        date: date,
        formatted: date.toLocaleDateString("en-US", {
          month: "short",
          day: "numeric",
          year: "numeric",
        }),
        day: date.toLocaleDateString("en-US", { weekday: "long" }),
      });
    }
    return result;
  }, []);

  // Mock available times
  const availableTimes = [
    "9:00 AM",
    "10:00 AM",
    "11:00 AM",
    "1:00 PM",
    "2:00 PM",
    "3:00 PM",
    "4:00 PM",
  ];

  // Check if date is fully booked - Saturday and Sunday are fully booked
  const checkAvailability = (date: Date) => {
    const dayOfWeek = date.getDay();
    return dayOfWeek !== 0 && dayOfWeek !== 6;
  };

  // No need for useEffect since we handle availability in handleDateSelect

  const handleDateSelect = (dateItem: { date: Date, formatted: string }) => {
    setSelectedDate(dateItem.formatted);
    const isAvailable = checkAvailability(dateItem.date);
    setIsFullyBooked(!isAvailable);
    if (!isAvailable) {
      setSelectedTime("");
    }
  };

  return (
    <ScrollView style={styles.container} showsVerticalScrollIndicator={false}>
      {/* Header */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => router.back()}>
          <Ionicons name="arrow-back" size={24} color="black" />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Schedule Booking</Text>
      </View>

      <Text style={styles.sectionTitle}>Set your Date & Time</Text>

      {/* Date Selection */}
      <View style={styles.dateGrid}>
        {dates.map((item) => (
          <TouchableOpacity
            key={item.formatted}
            style={[
              styles.dateCard,
              selectedDate === item.formatted && styles.dateCardSelected,
            ]}
            onPress={() => handleDateSelect(item)}
          >
            <Text style={styles.dateDay}>{item.day}</Text>
            <Text
              style={[
                styles.dateText,
                selectedDate === item.formatted && { color: "#fff" },
              ]}
            >
              {item.formatted}
            </Text>
          </TouchableOpacity>
        ))}
      </View>

      {/* Time Selection */}
      {selectedDate && !isFullyBooked && (
        <>
          <Text style={styles.label}>Time</Text>
          <View style={styles.pickerWrapper}>
            <Picker
              selectedValue={selectedTime}
              onValueChange={(value) => setSelectedTime(value)}
              style={styles.picker}
            >
              <Picker.Item label="Select time" value="" />
              {availableTimes.map((time) => (
                <Picker.Item key={time} label={time} value={time} />
              ))}
            </Picker>
          </View>
        </>
      )}

      {/* Fully Booked Warning */}
      {isFullyBooked && selectedDate && (
        <Text style={styles.fullyBookedText}>
          Sorry, we&apos;re fully booked for today.
        </Text>
      )}

      {/* Buttons */}
      <View style={styles.buttonContainer}>
        <TouchableOpacity
          style={[
            styles.scheduleBtn,
            // cancel button always enabled (just navigate back)
          ]}
          onPress={() => router.back()}
        >
          <Text style={styles.scheduleText}>Cancel</Text>
        </TouchableOpacity>

        <TouchableOpacity
          style={[styles.nextBtn, { opacity: selectedDate && selectedTime && !isFullyBooked ? 1 : 0.5 }]}
          disabled={!selectedDate || !selectedTime || isFullyBooked}
          onPress={() =>
            router.push({
              pathname: "/client-side/booking-process/booking-overview",
              params: {
                date: selectedDate,
                time: selectedTime,
                categoryTitle,
                categoryPrice,
                categoryDesc,
                address,
                location,
                mainCategory,
                subCategory,
                service,
              },
            } as any)
          }
        >
          <Text style={styles.nextText}>Next</Text>
        </TouchableOpacity>
      </View>
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
  header: {
    flexDirection: "row",
    alignItems: "center",
    marginBottom: 20,
  },
  headerTitle: {
    fontSize: 20,
    fontWeight: "600",
    marginLeft: 10,
  },
  sectionTitle: {
    fontSize: 16,
    fontWeight: "700",
    marginBottom: 16,
  },
  dateGrid: {
    flexDirection: "row",
    flexWrap: "wrap",
    gap: 8,
    marginBottom: 24,
  },
  dateCard: {
    width: "48%",
    backgroundColor: "#F5F5F5",
    borderRadius: 8,
    padding: 12,
    alignItems: "center",
  },
  dateCardSelected: {
    backgroundColor: "#00ADB5",
  },
  dateDay: {
    fontSize: 12,
    color: "#666",
    marginBottom: 4,
  },
  dateText: {
    fontSize: 14,
    fontWeight: "600",
    color: "#000",
  },
  label: {
    fontSize: 14,
    color: "#444",
    marginBottom: 8,
  },
  pickerWrapper: {
    backgroundColor: "#F5F5F5",
    borderRadius: 8,
    marginBottom: 24,
    overflow: "hidden",
  },
  picker: {
    height: 48,
  },
  fullyBookedText: {
    color: "#FF3B30",
    textAlign: "center",
    marginVertical: 16,
    fontSize: 14,
  },
  buttonContainer: {
    flexDirection: "row",
    gap: 12,
    marginTop: "auto",
    paddingVertical: 20,
  },
  scheduleBtn: {
    flex: 1,
    backgroundColor: "#00ADB5",
    borderRadius: 8,
    paddingVertical: 14,
    alignItems: "center",
  },
  scheduleBtnDisabled: {
    backgroundColor: "#ccc",
  },
  scheduleText: {
    color: "#fff",
    fontSize: 16,
    fontWeight: "700",
  },
  nextBtn: {
    flex: 1,
    backgroundColor: "#333",
    borderRadius: 8,
    paddingVertical: 14,
    alignItems: "center",
  },
  nextText: {
    color: "#fff",
    fontSize: 16,
    fontWeight: "700",
  },
});
