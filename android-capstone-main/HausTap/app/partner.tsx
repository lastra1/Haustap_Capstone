import { Stack } from 'expo-router';
import HausTapPartnerForm from '../src/screens/HausTapPartnerForm';

export default function PartnerScreen() {
  return (
    <>
      <Stack.Screen
        options={{
          title: "Become a Partner",
          headerShown: true,
        }}
      />
      <HausTapPartnerForm />
    </>
  );
}