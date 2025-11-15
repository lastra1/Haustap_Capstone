import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function StiltHouseLargeScreen() {
	const router = useRouter();

	const services = [
		{
			title: "Basic Cleaning – 2 Cleaner",
			price: "₱2,000",
			desc: "Inclusions:\nSweep, mop, dust all rooms\nTrash removal",
		},
		{
			title: "Standard Cleaning – 2-3 Cleaners",
			price: "₱3,500",
			desc: "Inclusions:\nAll Basic tasks, Kitchen & bathroom deep clean\nUnder furniture cleaning",
		},
		{
			title: "Deep Cleaning – 3 Cleaners",
			price: "₱6,000",
			desc: "Inclusions:\nAll Standard tasks, Full tile scrubbing\nDisinfection high-touch areas\nCarpet cleaning",
		},
	];

	return (
		<View style={styles.container}>
			<ScrollView>
				<Text style={styles.header}>Stilt House Large</Text>
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
										sub: "Stilt House - Large",
										mainCategory: "Cleaning Services",
										subCategory: "Stilt House - Large",
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

