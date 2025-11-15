import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function LashesScreen() {
  const router = useRouter();
  
  const services = [
    {
      title: "Classic Lash Extensions",
      price: "₱500",
      desc: "Inclusions:\n1:1 lash application for a natural look\nLightweight and comfortable for daily wear\nEnhances length and curl without heavy volume"
    },
    {
      title: "Hybrid Lash Extensions",
      price: "₱800",
      desc: "Inclusions:\nCombination of classic and volume lash techniques\nFuller and more textured effect\nBalanced style for both natural and glam looks"
    },
    {
      title: "Volume Lash Extensions",
      price: "₱1,000",
      desc: "Inclusions:\n3D–6D lash fans applied for dramatic volume\nCreates a glamorous, eye-catching effect\nIdeal for clients who prefer bold lashes"
    },
    {
      title: "Mega Volume Lash Extensions",
      price: "₱1,500",
      desc: "Inclusions:\nMultiple ultra-fine lash fans for extra density\nIntense, dramatic lash look\nBest for special occasions or high-glam styles"
    },
    {
      title: "Lash Lift + Tint",
      price: "₱500",
      desc: "Inclusions:\nLifts and curls natural lashes from the root\nTint adds depth and mascara-like effect\nLasts several weeks with low maintenance"
    },
    {
      title: "Lower Lash Extensions",
      price: "₱300",
      desc: "Inclusions:\nExtensions applied to bottom lashes\nEnhances definition and balance to eye look\nComplements upper lash extensions"
    },
    {
      title: "Lash Removal",
      price: "₱500",
      desc: "Inclusions:\nGentle and safe removal of extensions\nProtects natural lashes from damage\nRecommended for switching lash styles"
    },
    {
      title: "Lash Retouch / Refill (2–3 weeks)",
      price: "₱800",
      desc: "Inclusions:\nFills in gaps from natural lash shedding\nMaintains fullness and shape of extensions\nKeeps lashes looking fresh and even"
    }
  ];

  return (
    <View style={styles.container}>
      <ScrollView>
        <Text style={styles.header}>Lash Services</Text>
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
                  service: "Lashes",
                  mainCategory: "Beauty Services",
                  subCategory: "Lashes",
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