import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function MobilePhoneScreen() {
  const router = useRouter();
  
  const services = [
    {
      title: "Charging port repair – android",
      price: "₱400 per unit",
      desc: "Inclusions:\nDiagnosis of charging port issue\nCleaning or replacement of charging port\nSoldering work (if required)\nTesting for charging stability and USB connection."
    },
    {
      title: "Charging Port repair – IOS",
      price: "₱600 per unit",
      desc: "Inclusions:\nDetailed check of charging dock/port\nCleaning or replacement of faulty port\nRe-soldering and alignment adjustments\nCharging and data transfer test"
    },
    {
      title: "Screen replacement – android",
      price: "₱500 per unit",
      desc: "Inclusions:\nRemoval of broken/damaged screen\nInstallation of replacement screen (customer-provided part or available stock)\nFunctionality test for touch and display\nBasic cleaning of device exterior"
    },
    {
      title: "Screen replacement – IOS",
      price: "₱700 per unit",
      desc: "Inclusions:\nSafe removal of damaged screen\nInstallation of new/replacement screen\nTouch responsiveness and display quality test\nDevice assembly and sealing check"
    },
    {
      title: "Battery replacement - android",
      price: "₱300 per unit",
      desc: "Inclusions:\nRemoval of old/non-working battery\nInstallation of new battery (customer-provided or available stock)\nPower-on and charging function test\nDisposal of defective battery"
    },
    {
      title: "Battery replacement – IOS",
      price: "₱500 per unit",
      desc: "Inclusions:\nSafe removal of swollen/damaged battery\nInstallation of new battery\nPower, charging, and battery health check\nDevice reassembly with secure fitting"
    }
  ];

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Mobile Phone Repair Services</Text>
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
                  service: "Mobile Phone Repair",
                  mainCategory: "Tech & Gadget Services",
                  subCategory: "Mobile Phone Repair",
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