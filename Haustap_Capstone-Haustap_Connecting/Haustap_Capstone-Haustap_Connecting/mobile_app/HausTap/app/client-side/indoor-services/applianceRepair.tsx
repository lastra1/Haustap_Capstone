import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";
import { applianceRepairCategories } from "../data/applianceRepair";

export default function ApplianceRepairScreen() {
  const router = useRouter();

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Appliance Repair Services</Text>
        <View style={styles.categoriesContainer}>
          {applianceRepairCategories.map((category, index) => (
            <TouchableOpacity 
              key={index}
              style={styles.categoryBox}
              onPress={() => router.push({
                pathname: "/client-side/booking-summary",
                params: { 
                  categoryTitle: category.title,
                  categoryDesc: category.desc,
                  categoryPrice: category.price,
                  service: "Appliance Repair",
                  mainCategory: "Indoor Services",
                  subCategory: "Appliance Repair",
                }
              })}
            >
              <View style={styles.categoryContent}>
                <Text style={styles.categoryTitle}>{category.title}</Text>
                {category.price && (
                  <Text style={styles.categoryPrice}>{category.price}</Text>
                )}
                <Text style={styles.categoryDesc}>{category.desc}</Text>
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
