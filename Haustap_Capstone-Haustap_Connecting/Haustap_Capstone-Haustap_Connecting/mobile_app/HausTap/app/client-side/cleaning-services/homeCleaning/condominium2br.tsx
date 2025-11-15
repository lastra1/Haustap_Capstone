import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function Condo2BRScreen() {
	const router = useRouter();

	const services = [
		{
			title: "Basic Cleaning – 2 Cleaner",
			price: "₱1,500",
			desc: "Inclusions:\nLiving room & bedrooms: sweeping, mopping, dusting\nMirrors & windows: wipe\nTrash removal",
		},
		{
			title: "Standard Cleaning – 2-3 Cleaners",
			price: "₱2,500",
			desc: "Inclusions:\nAll Basic tasks: Kitchen: deep wipe & sink scrubbing\nBathroom: toilet, shower, sink, disinfect floors\nClean under beds & sofa",
		},
		{
			title: "Deep Cleaning – 3 Cleaners",
			price: "₱4,000",
			desc: "Inclusions:\nAll Standard tasks: Tile grout scrubbing\nBehind appliances cleaning\nCarpet shampoo/vacuum\nDisinfection of high-touch areas",
		},
	];

	return (
		<View style={styles.container}>
			<ScrollView>
				<Text style={styles.header}>Condominium 2BR</Text>
				<View style={styles.categoriesContainer}>
					{services.map((s, i) => (
						<TouchableOpacity
							key={i}
							style={styles.categoryBox}
							onPress={() =>
								router.push({
									pathname: "/client-side/booking-summary",
									params: {
										categoryTitle: s.title,
										categoryPrice: s.price,
										categoryDesc: s.desc,
										service: "Home Cleaning",
										sub: "Condominium 2BR",
										mainCategory: "Cleaning Services",
										subCategory: "Condominium 2BR",
									},
								})
							}
						>
							<View style={styles.categoryContent}>
								<Text style={styles.categoryTitle}>{s.title}</Text>
								<Text style={styles.categoryPrice}>{s.price}</Text>
								<Text style={styles.categoryDesc}>{s.desc}</Text>
							</View>
						</TouchableOpacity>
					))}
				</View>
			</ScrollView>
		</View>
	);
}

const styles = StyleSheet.create({
	container: { flex: 1, backgroundColor: "#fff" },
	header: { fontSize: 24, fontWeight: "bold", padding: 16, color: "#000" },
	categoriesContainer: { padding: 16 },
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
	categoryContent: { flex: 1 },
	categoryTitle: { fontSize: 16, fontWeight: "bold", color: "#000", marginBottom: 4 },
	categoryPrice: { fontSize: 14, color: "#444", marginBottom: 4 },
	categoryDesc: { fontSize: 14, color: "#444", lineHeight: 20 },
});
