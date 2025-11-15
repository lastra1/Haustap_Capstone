import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";
import { makeupCategories } from "../data/makeup";

export default function MakeupScreen() {
  const router = useRouter();
  
  const services = makeupCategories;

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Makeup Services</Text>
        <View style={styles.categoriesContainer}>
          {services.map((service, index) => {
            if (service.section === "header") {
              return (
                <View key={index} style={styles.sectionHeader}>
                  <Text style={styles.sectionTitle}>{service.title}</Text>
                  {service.desc ? (
                    <Text style={styles.sectionDesc}>{service.desc}</Text>
                  ) : null}
                </View>
              );
            }

            return (
              <TouchableOpacity
                key={index}
                style={styles.categoryBox}
                onPress={() =>
                  router.push({
                    pathname: "/client-side/booking-summary",
                    params: {
                      categoryTitle: service.title,
                      categoryPrice: service.price,
                      categoryDesc: service.desc,
                      service: "Makeup",
                      mainCategory: "Beauty Services",
                      subCategory: "Makeup",
                    },
                  })
                }
              >
                <View style={styles.categoryContent}>
                  <Text style={styles.categoryTitle}>{service.title}</Text>
                  <Text style={styles.categoryPrice}>{service.price}</Text>
                  <Text style={styles.categoryDesc}>{service.desc}</Text>
                </View>
              </TouchableOpacity>
            );
          })}
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
  sectionHeader: {
    marginVertical: 12,
  },
  sectionTitle: {
    fontSize: 18,
    fontWeight: "700",
    color: "#222",
    marginBottom: 4,
  },
  sectionDesc: {
    fontSize: 14,
    color: "#666",
    marginBottom: 8,
  },
});