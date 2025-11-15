import { useRouter } from "expo-router";
import React from "react";
import { ScrollView, StyleSheet, Text, TouchableOpacity, View } from "react-native";

export default function BungalowScreen() {
	const router = useRouter();

	const services = [
		{
			title: "Basic Cleaning – 1 Cleaner",
			price: "₱1,000",
			desc: "Inclusions:\nLiving Room: walis, mop, dusting furniture, trash removal\nBedrooms: bed making, sweeping, dusting, trash removal\nHallways: mop & sweep, remove cobwebs\nWindows & Mirrors: quick wipe",
		},
		{
			title: "Standard Cleaning – 2 Cleaner",
			price: "₱2,000",
			desc: "Inclusions:\nAll Basic Cleaning tasks plus Kitchen: wipe countertops, sink cleaning, stove top degrease, trash removal\nBathroom: scrub toilet, sink, shower, floor disinfecting\nFurniture: cleaning under/behind furniture\nWindows & Mirrors: full wipe & polish",
		},
		{
			title: "Deep Cleaning – 3 Cleaner",
			price: "₱3,000",
			desc: "Inclusions:\nAll Standard Cleaning tasks plus Flooring: scrubbing tiles/grout, polishing if applicable\nAppliances: behind refrigerator, oven, washing machine\nCarpets/Rugs: vacuum or shampoo\nDisinfection: doorknobs, switches, high-touch surfaces",
		},
	];

	return (
		<View style={styles.container}>
			<ScrollView>
				<Text style={styles.header}>Bungalow Cleaning Options</Text>
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
										sub: "Bungalow",
										mainCategory: "Cleaning Services",
										subCategory: "Bungalow",
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
