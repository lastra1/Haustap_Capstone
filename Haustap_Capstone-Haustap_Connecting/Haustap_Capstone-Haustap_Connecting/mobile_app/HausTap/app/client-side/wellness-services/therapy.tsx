import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function TherapyScreen() {
  const router = useRouter();
  
  const services = [
    { 
      title: "Initial Assessment",
      price: "₱1,000",
      desc: "Complete physical assessment and treatment plan development"
    },
    { 
      title: "General Physical Therapy",
      price: "₱800/session",
      desc: "Standard physical therapy treatment for general conditions"
    },
    { 
      title: "Sports Injury Therapy",
      price: "₱1,200/session",
      desc: "Specialized treatment for sports-related injuries"
    },
    { 
      title: "Post-Surgery Rehabilitation",
      price: "₱1,500/session",
      desc: "Rehabilitation therapy for post-surgery recovery"
    },
    { 
      title: "Exercise Program",
      price: "₱2,000",
      desc: "Customized exercise program development with follow-up sessions"
    }
  ];

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Physical Therapy Services</Text>
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
                    service: "Therapy",
                    mainCategory: "Wellness Services",
                    subCategory: "Therapy",
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