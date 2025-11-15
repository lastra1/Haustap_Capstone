import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function GamingScreen() {
  const router = useRouter();
  
  const services = [
    {
      title: "Controller repair",
      price: "₱300 per unit",
      desc: "Inclusions:\nDiagnosis of controller issues (buttons, joystick, triggers, or connectivity)\nCleaning and calibration of internal parts\nReplacement of minor components/parts (if provided by client)\nFunctionality test and gameplay test after repair"
    },
    {
      title: "HDMI port repair",
      price: "₱700 per unit",
      desc: "Inclusions:\nDiagnosis of HDMI port issue (loose, bent, or damaged pins)\nRemoval of faulty HDMI port\nInstallation of new HDMI port (customer-provided or available stock)\nTesting of video/audio output to monitor/TV\nDevice assembly and functionality check"
    },
    {
      title: "Disc Drive Repair / Replacement",
      price: "₱800 per unit",
      desc: "Inclusions:\nDiagnosis of disc reading/ejecting issues\nCleaning of optical lens\nAdjustment or repair of disc tray mechanism\nReplacement of faulty disc drive (if provided by client)\nPlayback test with game disc"
    },
    {
      title: "Power Supply Repair / Replacement",
      price: "₱900 per unit",
      desc: "Inclusions:\nDiagnosis of power-related issues (no power, sudden shutdowns)\nChecking and repairing internal power supply\nReplacement of power supply unit (if provided by client)\nFunctionality and safety test after repair"
    },
    {
      title: "Software Reinstallation / Update",
      price: "₱300 per unit",
      desc: "Inclusions:\nSystem software update/reinstallation (PlayStation, Xbox, Nintendo, etc.)\nInstallation of latest firmware version\nOptimization of console performance\nTesting of system functions and online connectivity"
    }
  ];

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Gaming Console Repair</Text>
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
                  service: "Gaming Console Repair",
                  mainCategory: "Tech & Gadget Services",
                  subCategory: "Gaming Console Repair",
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