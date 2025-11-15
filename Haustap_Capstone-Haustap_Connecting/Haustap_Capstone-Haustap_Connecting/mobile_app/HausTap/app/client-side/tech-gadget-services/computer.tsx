import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function ComputerScreen() {
  const router = useRouter();
  
  const services = [
    {
      title: "Fan / Cooling Repair (Laptop)",
      price: "₱400 per unit",
      desc: "Inclusions:\nDiagnosis of cooling system (fan, vents, heat sink)\nCleaning of dust and minor obstructions. Fan repair or replacement (if needed, part provided separately)\nThermal paste application (if required)\nOverheating test after repair"
    },
    {
      title: "Keyboard Replacement (Laptop)",
      price: "₱600 per unit",
      desc: "Inclusions:\nReplacement of external desktop keyboard\nInstallation of new keyboard (client-provided or available stock)\nFunctional test of all keys"
    },
    {
      title: "OS Reformat + Software Installation (Laptop)",
      price: "₱500 per unit",
      desc: "Inclusions:\nFull OS reinstallation (Windows/macOS/Linux, as provided by client)\nInstallation of basic drivers (audio, display, network, etc.)\nInstallation of up to 3 client-provided software/applications\nBasic system optimization and testing, Data backup not included"
    },
    {
      title: "Fan / Cooling Repair (Desktop PC)",
      price: "₱700 per unit",
      desc: "Inclusions:\nDiagnosis of cooling system (fan, vents, heat sink)\nCleaning of dust and minor obstructions. Fan repair or replacement (if needed, part provided separately)\nThermal paste application (if required)\nOverheating test after repair"
    },
    {
      title: "Keyboard Replacement (Desktop PC)",
      price: "₱300 per unit",
      desc: "Inclusions:\nReplacement of external desktop keyboard\nInstallation of new keyboard (client-provided or available stock)\nFunctional test of all keys"
    },
    {
      title: "OS Reformat + Software Installation (Desktop PC)",
      price: "₱500 per unit",
      desc: "Inclusions:\nFull OS reinstallation (Windows/macOS/Linux, as provided by client)\nInstallation of basic drivers (audio, display, network, etc.)\nInstallation of up to 3 client-provided software/applications\nBasic system optimization and testing, Data backup not included"
    }
  ];

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Computer Repair Services</Text>
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
                  service: "Computer Repair",
                  mainCategory: "Tech & Gadget Services",
                  subCategory: "Computer Repair",
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