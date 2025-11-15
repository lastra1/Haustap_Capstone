import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function SpaScreen() {
  const router = useRouter();
  
  const services = [
    { 
      title: "Facial Treatment",
      price: "From ₱1,500",
      desc: "Customized facial treatment based on skin type"
    },
    { 
      title: "Body Scrub",
      price: "₱1,200",
      desc: "Full body exfoliation and moisturizing treatment"
    },
    { 
      title: "Hot Stone Therapy",
      price: "₱2,000",
      desc: "Relaxing hot stone massage with aromatherapy"
    },
    { 
      title: "Body Wrap",
      price: "₱1,800",
      desc: "Detoxifying body wrap treatment"
    },
    { 
      title: "Aromatherapy Package",
      price: "₱2,500",
      desc: "Complete aromatherapy session with massage"
    }
  ];

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Spa Services</Text>
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
                  service: "Spa",
                  mainCategory: "Wellness Services",
                  subCategory: "Spa",
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