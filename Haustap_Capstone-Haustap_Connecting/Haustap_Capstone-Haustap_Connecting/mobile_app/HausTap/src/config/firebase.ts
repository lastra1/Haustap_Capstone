import { initializeApp } from 'firebase/app';
import { getAuth } from 'firebase/auth';
import { getFirestore } from 'firebase/firestore';
import { getStorage } from 'firebase/storage';

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: process.env.EXPO_PUBLIC_FIREBASE_API_KEY || "AIzaSyCfhR1vIh8_z4TAmdaQRESHB459CsVqJ9M",
  authDomain: process.env.EXPO_PUBLIC_FIREBASE_AUTH_DOMAIN || "haustap-booking-system.firebaseapp.com",
  projectId: process.env.EXPO_PUBLIC_FIREBASE_PROJECT_ID || "haustap-booking-system",
  storageBucket: process.env.EXPO_PUBLIC_FIREBASE_STORAGE_BUCKET || "haustap-booking-system.firebasestorage.app",
  messagingSenderId: process.env.EXPO_PUBLIC_FIREBASE_MESSAGING_SENDER_ID || "515769404711",
  appId: process.env.EXPO_PUBLIC_FIREBASE_APP_ID || "1:515769404711:web:ddf0b32df0498eb18aad02"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize services
export const auth = getAuth(app);
export const db = getFirestore(app);
export const storage = getStorage(app);

export default app;