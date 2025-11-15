import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function TabletScreen() {
  const router = useRouter();
  
  const services = [
    {
      title: "Screen replacement - android tablet",
      price: "₱600 per unit",
      desc: "Inclusions:\nRemoval of cracked or damaged screen\nInstallation of replacement screen (customer-provided or available stock)\nTouch and display quality test\nDevice assembly and sealing check"
    },
    {
      title: "Screen replacement – Ipad",
      price: "₱800 per unit",
      desc: "Inclusions:\nRemoval of cracked or damaged screen\nInstallation of replacement screen (customer-provided or available stock)\nTouch and display quality test\nDevice assembly and sealing check"
    },
    {
      title: "Battery replacement - android tablet",
      price: "₱400 per unit",
      desc: "Inclusions:\nRemoval of defective or swollen battery\nInstallation of new battery (customer-provided or available stock)\nCharging and power functionality test\nSafe disposal of old battery"
    },
    {
      title: "Battery replacement - Ipad",
      price: "₱600 per unit",
      desc: "Inclusions:\nRemoval of defective or swollen battery\nInstallation of new battery (customer-provided or available stock)\nCharging and power functionality test\nSafe disposal of old battery"
    }
  ];

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Tablet & iPad Repair</Text>
        <View style={styles.categoriesContainer}>
          {services.map((service, index) => (
            <TouchableOpacity 
              key={index}
              style={styles.categoryBox}
              onPress={() => router.push({
                pathname: "/client-side/booking-summary",
                params: { 
                  categoryTitle: service.title,
                  categoryPrice: service.price,
                  categoryDesc: service.desc,
                  service: "Tablet Repair",
                  mainCategory: "Tech & Gadget Services",
                  subCategory: "Tablet Repair",
                }
              })}
            >
              <View style={styles.categoryContent}>
                <Text style={styles.categoryTitle}>{service.title}</Text>
                <Text style={styles.categoryPrice}>{service.price}</Text>
                <Text style={styles.categoryDesc}>{service.desc}</Text>
              </View>
            </TouchableOpacity>
          ))}
        </View>
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#fff",
  },
  header: {
    fontSize: 24,
    fontWeight: "bold",
    padding: 16,
    color: "#000",
  },
  categoriesContainer: {
    padding: 16,
  },
  categoryBox: {
    backgroundColor: "#DEE1E0",
    borderRadius: 10,
    padding: 15,
    marginBottom: 15,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 3,
    elevation: 3,
  },
  categoryContent: {
    flex: 1,
  },
  categoryTitle: {
    fontSize: 16,
    fontWeight: "bold",
    color: "#000",
    marginBottom: 4,
  },
  categoryPrice: {
    fontSize: 14,
    color: "#444",
    marginBottom: 4,
  },
  categoryDesc: {
    fontSize: 14,
    color: "#444",
    lineHeight: 20,
  },
});