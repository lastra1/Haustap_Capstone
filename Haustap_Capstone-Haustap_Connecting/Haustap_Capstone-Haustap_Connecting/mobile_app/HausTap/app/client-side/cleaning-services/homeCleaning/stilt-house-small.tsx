import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function StiltHouseSmallScreen() {
	const router = useRouter();

	const services = [
		{
			title: "Basic Cleaning – 1 Cleaner",
			price: "₱1,000",
			desc: "Inclusions:\nSweep, mop, dust, trash disposal\nMirror/window wipe",
		},
		{
			title: "Standard Cleaning – 1-2 Cleaners",
			price: "₱1,800",
			desc: "Inclusions:\nAll Basic tasks, Kitchen cleaning\nBathroom scrubbing",
		},
		{
			title: "Deep Cleaning – 2 Cleaners",
			price: "₱3,000",
			desc: "Inclusions:\nAll Standard tasks, Floor scrubbing, grout cleaning\nBehind furniture/appliances",
		},
	];

	return (
		<View style={styles.container}>
			<ScrollView>
				<Text style={styles.header}>Stilt House Small</Text>
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
										sub: "Stilt House - Small",
										mainCategory: "Cleaning Services",
										subCategory: "Stilt House - Small",
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

