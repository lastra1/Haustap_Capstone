import { Ionicons } from "@expo/vector-icons";
import { useLocalSearchParams, useRouter } from "expo-router";
import React from "react";
import {
    Alert,
    ScrollView,
    StyleSheet,
    Text,
    TouchableOpacity,
    View,
} from "react-native";
import { ServiceProvider, serviceProvidersByCategory as sharedProvidersByCategory } from "../data/providers";

// use shared providers data
const serviceProvidersByCategory = sharedProvidersByCategory;

export default function BookingChooseSP() {
  const router = useRouter();
  const params = useLocalSearchParams();
  const [selectedRadius, setSelectedRadius] = React.useState(5);
  const [selectedProviderId, setSelectedProviderId] = React.useState<string | null>(null);
  const [expandedProviderId, setExpandedProviderId] = React.useState<string | null>(null);

  // Filter providers based on selected radius and booked service
  const filteredProviders = React.useMemo(() => {
    const result: Record<string, ServiceProvider[]> = {};
    const bookedService = params.service as string;
    const bookedCategory = params.category as string;

    // If a main category was selected, only show providers under that category
    if (bookedCategory && serviceProvidersByCategory[bookedCategory]) {
      const providers = serviceProvidersByCategory[bookedCategory] as ServiceProvider[] || [];
      let filtered = providers.filter((p: ServiceProvider) => Number(p.distance) <= selectedRadius);

      if (bookedService) {
        filtered = filtered.filter((p: ServiceProvider) =>
          p.skills.some((skill: string) =>
            skill.toLowerCase().includes(bookedService.toLowerCase()) ||
            skill.toLowerCase().includes(bookedCategory.toLowerCase())
          )
        );
      }

      if (filtered.length > 0) {
        // sort by distance ascending (closest first)
        filtered.sort((a: ServiceProvider, b: ServiceProvider) => Number(a.distance) - Number(b.distance));
        result[bookedCategory] = filtered;
      }
    } else {
      // No main category specified; fall back to showing all categories (distance & service filtered)
      const entries = Object.entries(serviceProvidersByCategory) as [string, ServiceProvider[]][];
      entries.forEach(([category, providers]) => {
        let filtered = (providers || []).filter((p: ServiceProvider) => Number(p.distance) <= selectedRadius);

        if (bookedService) {
          filtered = filtered.filter((p: ServiceProvider) =>
            p.skills.some((skill: string) =>
              skill.toLowerCase().includes(bookedService.toLowerCase()) ||
              skill.toLowerCase().includes((params.category as string || '').toLowerCase())
            )
          );
        }

        if (filtered.length > 0) {
          // sort by distance ascending
          filtered.sort((a: ServiceProvider, b: ServiceProvider) => Number(a.distance) - Number(b.distance));
          result[category] = filtered;
        }
      });
    }

    return result;
  }, [selectedRadius, params.service, params.category]);

  return (
    <View style={styles.container}>
      <View style={styles.header}>
        <TouchableOpacity onPress={() => router.back()}>
          <Ionicons name="arrow-back" size={24} color="black" />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Choose Service Provider</Text>
      </View>

      <ScrollView style={styles.scrollView}>
        {Object.keys(filteredProviders).length === 0 ? (
          <View style={{ padding: 40, alignItems: 'center' }}>
            <Text style={{ fontSize: 16, color: '#666', marginBottom: 12 }}>No providers found nearby for the selected service.</Text>
            {selectedRadius < 10 ? (
              <TouchableOpacity onPress={() => setSelectedRadius(10)} style={{ backgroundColor: '#00ADB5', paddingHorizontal: 14, paddingVertical: 10, borderRadius: 8 }}>
                <Text style={{ color: '#fff', fontWeight: '700' }}>Expand radius to 10km</Text>
              </TouchableOpacity>
            ) : (
              <Text style={{ color: '#666' }}>Try choosing a different service or location.</Text>
            )}
          </View>
        ) : (
          Object.entries(filteredProviders).map(([category, providers]) => (
            <View key={category} style={styles.categorySection}>
              <Text style={styles.categoryTitle}>{category}</Text>
              {providers.map((provider: ServiceProvider) => (
                <TouchableOpacity
                  key={provider.id}
                  style={[
                    styles.providerCard,
                    provider.id === selectedProviderId && styles.providerCardSelected,
                  ]}
                    onPress={() => setExpandedProviderId(prev => prev === provider.id ? null : provider.id)}
                >
                    <View style={styles.compactRow}>
                      <View style={styles.avatar}>
                        <Ionicons name="person" size={24} color="#666" />
                      </View>
                      <View style={{ flex: 1 }}>
                        <Text style={styles.providerName}>{provider.name}</Text>
                        <View style={styles.compactMeta}>
                          <View style={styles.ratingRow}>
                            <Ionicons name="star" size={14} color="#FFD700" />
                            <Text style={styles.ratingText}>{provider.rating}</Text>
                          </View>
                          <View style={styles.distanceRow}>
                            <Ionicons name="location" size={14} color="#666" />
                            <Text style={styles.distanceText}>{provider.distance} km away</Text>
                          </View>
                        </View>
                      </View>
                      {provider.id === selectedProviderId && (
                        <View style={styles.selectedBadge}><Text style={styles.selectedBadgeText}>Selected</Text></View>
                      )}
                      <Ionicons name={expandedProviderId === provider.id ? "chevron-up" : "chevron-down"} size={20} color="#666" />
                    </View>

                    {expandedProviderId === provider.id && (
                      <View style={styles.expandedContent}>
                        <View style={styles.skillsContainer}>
                          {provider.skills.map((skill, index) => (
                            <View key={index} style={styles.skillBadge}>
                              <Text style={styles.skillText}>{skill}</Text>
                            </View>
                          ))}
                        </View>

                        <View style={{ marginTop: 8 }}>
                          <Text style={styles.distanceText}>Experience: {provider.experience}</Text>
                        </View>
                        <View style={{ marginTop: 4 }}>
                          <Text style={styles.distanceText}>{provider.location}</Text>
                        </View>

                        <View style={styles.expandedButtonsRow}>
                          <TouchableOpacity
                            style={styles.viewProfileButton}
                            onPress={() => router.push({ pathname: "/client-side/booking-process/sp-profile-view", params: { providerId: provider.id, ...params } } as any)}
                          >
                            <Text style={styles.viewProfileText}>View Profile</Text>
                          </TouchableOpacity>

                          <TouchableOpacity
                            style={[styles.selectButton, provider.id === selectedProviderId && styles.selectButtonSelected]}
                            onPress={() => setSelectedProviderId(provider.id)}
                          >
                            <Text style={styles.selectButtonText}>{provider.id === selectedProviderId ? 'Selected' : 'Select'}</Text>
                          </TouchableOpacity>
                        </View>
                      </View>
                    )}
                </TouchableOpacity>
              ))}
            </View>
          ))
        )}
      </ScrollView>

      <View style={styles.footer}>
        <View style={styles.radiusFilter}>
          <Text style={styles.radiusLabel}>Show service providers within:</Text>
          <View style={styles.radiusOptions}>
            <TouchableOpacity
              style={[styles.radiusOption, selectedRadius === 5 && styles.radiusOptionSelected]}
              onPress={() => setSelectedRadius(5)}
            >
              <View style={styles.radioOuter}>
                {selectedRadius === 5 && <View style={styles.radioInner} />}
              </View>
              <Text style={styles.radiusText}>5km</Text>
            </TouchableOpacity>
            <TouchableOpacity 
              style={[styles.radiusOption, selectedRadius === 10 && styles.radiusOptionSelected]}
              onPress={() => setSelectedRadius(10)}
            >
              <View style={styles.radioOuter}>
                {selectedRadius === 10 && <View style={styles.radioInner} />}
              </View>
              <Text style={styles.radiusText}>10km</Text>
            </TouchableOpacity>
          </View>
        </View>

        <View style={styles.buttonRow}>
          <TouchableOpacity
            style={styles.cancelButton}
            onPress={() => router.back()}
          >
            <Text style={styles.cancelButtonText}>Cancel</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={[styles.bookButton, !selectedProviderId && styles.bookButtonDisabled]}
            disabled={!selectedProviderId}
            onPress={() => {
              if (!selectedProviderId) {
                Alert.alert('No provider selected', 'Please select a provider before continuing.');
                return;
              }

              // find provider details to pass to confirmation screen
              let providerName = '';
              const allProviders = Object.values(serviceProvidersByCategory).flat();
              const found = allProviders.find(p => p.id === selectedProviderId);
              if (found) providerName = found.name;

              // pass minimal booking details as params; other booking pages can extend this
              router.push({
                pathname: '/client-side/booking-process/confirm-booking',
                params: {
                  providerId: selectedProviderId,
                  providerName,
                  category: params.category || null,
                  service: params.service || null,
                },
              } as any);
            }}
          >
            <Text style={styles.bookButtonText}>Book</Text>
          </TouchableOpacity>
        </View>
      </View>
    </View>
  );
}



const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },
  skillsContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    marginTop: 8,
  },
  skillBadge: {
    backgroundColor: '#F0F0F0',
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 12,
    marginRight: 8,
    marginBottom: 8,
  },
  skillText: {
    fontSize: 12,
    color: '#666',
  },
  categorySection: {
    marginBottom: 20,
  },
  categoryTitle: {
    fontSize: 18,
    fontWeight: "700",
    color: "#222",
    marginBottom: 12,
    marginTop: 8,
  },
  header: {
    flexDirection: "row",
    alignItems: "center",
    paddingHorizontal: 16,
    paddingTop: 40,
    paddingBottom: 10,
    borderBottomWidth: 1,
    borderBottomColor: "#eee",
  },
  headerTitle: {
    fontSize: 20,
    fontWeight: "600",
    marginLeft: 12,
  },
  scrollView: {
    flex: 1,
    paddingHorizontal: 16,
    paddingTop: 16,
  },
  providerCard: {
    backgroundColor: "#fff",
    borderRadius: 12,
    padding: 12,
    marginBottom: 12,
    borderWidth: 1,
    borderColor: "#eee",
  },
  providerCardSelected: {
    borderColor: "#00ADB5",
    backgroundColor: "#F8FDFD",
  },
  providerInfo: {
    flexDirection: "row",
    alignItems: "center",
  },
  avatar: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: "#f0f0f0",
    justifyContent: "center",
    alignItems: "center",
    marginRight: 12,
  },
  providerDetails: {
    flex: 1,
  },
  providerName: {
    fontSize: 16,
    fontWeight: "600",
    marginBottom: 4,
  },
  ratingRow: {
    flexDirection: "row",
    alignItems: "center",
    marginBottom: 2,
  },
  ratingText: {
    fontSize: 13,
    color: "#666",
    marginLeft: 4,
  },
  distanceRow: {
    flexDirection: "row",
    alignItems: "center",
  },
  distanceText: {
    fontSize: 13,
    color: "#666",
    marginLeft: 4,
  },
  compactRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  compactMeta: {
    flexDirection: 'row',
    gap: 12,
    marginTop: 4,
    alignItems: 'center',
  },
  selectedBadge: {
    backgroundColor: '#00ADB5',
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 12,
    marginRight: 8,
  },
  selectedBadgeText: {
    color: '#fff',
    fontWeight: '700',
    fontSize: 12,
  },
  expandedContent: {
    marginTop: 12,
    borderTopWidth: 1,
    borderTopColor: '#f0f0f0',
    paddingTop: 12,
  },
  expandedButtonsRow: {
    flexDirection: 'row',
    justifyContent: 'flex-end',
    gap: 12,
    marginTop: 12,
  },
  viewProfileButton: {
    backgroundColor: '#fff',
    borderWidth: 1,
    borderColor: '#00ADB5',
    paddingHorizontal: 12,
    paddingVertical: 8,
    borderRadius: 8,
  },
  viewProfileText: {
    color: '#00ADB5',
    fontWeight: '700',
  },
  selectButton: {
    backgroundColor: '#00ADB5',
    paddingHorizontal: 14,
    paddingVertical: 8,
    borderRadius: 8,
  },
  selectButtonSelected: {
    backgroundColor: '#008f8f',
  },
  selectButtonText: {
    color: '#fff',
    fontWeight: '700',
  },
  footer: {
    paddingHorizontal: 16,
    paddingBottom: 24,
    borderTopWidth: 1,
    borderTopColor: "#eee",
    backgroundColor: "#fff",
  },
  radiusFilter: {
    paddingVertical: 16,
  },
  radiusLabel: {
    fontSize: 14,
    color: "#666",
    marginBottom: 8,
  },
  radiusOptions: {
    flexDirection: "row",
    gap: 16,
  },
  radiusOption: {
    flexDirection: "row",
    alignItems: "center",
  },
  radiusOptionSelected: {
    // Style for selected radius option
  },
  radioOuter: {
    width: 18,
    height: 18,
    borderRadius: 9,
    borderWidth: 2,
    borderColor: "#00ADB5",
    marginRight: 6,
    justifyContent: "center",
    alignItems: "center",
  },
  radioInner: {
    width: 10,
    height: 10,
    borderRadius: 5,
    backgroundColor: "#00ADB5",
  },
  radiusText: {
    fontSize: 14,
    color: "#444",
  },
  buttonRow: {
    flexDirection: "row",
    gap: 12,
    marginTop: 16,
  },
  cancelButton: {
    flex: 1,
    backgroundColor: "#eee",
    borderRadius: 8,
    paddingVertical: 12,
    alignItems: "center",
  },
  cancelButtonText: {
    fontSize: 16,
    fontWeight: "600",
    color: "#666",
  },
  bookButton: {
    flex: 1,
    backgroundColor: "#00ADB5",
    borderRadius: 8,
    paddingVertical: 12,
    alignItems: "center",
  },
  bookButtonDisabled: {
    backgroundColor: "#ccc",
  },
  bookButtonText: {
    fontSize: 16,
    fontWeight: "600",
    color: "#fff",
  },
});
