// Firebase Web Configuration
// This file contains the Firebase configuration for the web application

const firebaseConfig = {
  apiKey: "AIzaSyCfhR1vIh8_z4TAmdaQRESHB459CsVqJ9M",
  authDomain: "haustap-booking-system.firebaseapp.com",
  projectId: "haustap-booking-system",
  storageBucket: "haustap-booking-system.firebasestorage.app",
  messagingSenderId: "515769404711",
  appId: "1:515769404711:web:ddf0b32df0498eb18aad02"
};

// Initialize Firebase
let app;
let auth;
let db;

try {
  app = firebase.initializeApp(firebaseConfig);
  auth = firebase.auth();
  db = firebase.firestore();
  console.log('Firebase initialized successfully');
} catch (error) {
  console.error('Firebase initialization error:', error);
}

// Firebase Authentication Helper Functions
const FirebaseAuth = {
  // Login user
  async login(email, password) {
    try {
      const userCredential = await auth.signInWithEmailAndPassword(email, password);
      const user = userCredential.user;
      const token = await user.getIdToken();
      
      // Store token and user data
      localStorage.setItem('haustap_token', token);
      localStorage.setItem('haustap_user', JSON.stringify({
        uid: user.uid,
        email: user.email,
        displayName: user.displayName
      }));
      
      return { user, token };
    } catch (error) {
      console.error('Login error:', error);
      throw error;
    }
  },

  // Register new user
  async register(email, password, userData = {}) {
    try {
      const userCredential = await auth.createUserWithEmailAndPassword(email, password);
      const user = userCredential.user;
      
      // Update user profile if displayName is provided
      if (userData.displayName) {
        await user.updateProfile({ displayName: userData.displayName });
      }
      
      // Create user document in Firestore
      await db.collection('users').doc(user.uid).set({
        uid: user.uid,
        email: user.email,
        displayName: userData.displayName || '',
        phoneNumber: userData.phoneNumber || '',
        role: userData.role || 'client',
        roles: [userData.role || 'client'], // Add roles array for rule compatibility
        createdAt: firebase.firestore.FieldValue.serverTimestamp(),
        updatedAt: firebase.firestore.FieldValue.serverTimestamp(),
        isActive: true
      });
      
      const token = await user.getIdToken();
      localStorage.setItem('haustap_token', token);
      localStorage.setItem('haustap_user', JSON.stringify({
        uid: user.uid,
        email: user.email,
        displayName: user.displayName
      }));
      
      return { user, token };
    } catch (error) {
      console.error('Registration error:', error);
      throw error;
    }
  },

  // Logout user
  async logout() {
    try {
      await auth.signOut();
      localStorage.removeItem('haustap_token');
      localStorage.removeItem('haustap_user');
      return true;
    } catch (error) {
      console.error('Logout error:', error);
      throw error;
    }
  },

  // Get current user
  getCurrentUser() {
    const userStr = localStorage.getItem('haustap_user');
    return userStr ? JSON.parse(userStr) : null;
  },

  // Get auth token
  getToken() {
    return localStorage.getItem('haustap_token');
  },

  // Check if user is authenticated
  isAuthenticated() {
    return !!this.getToken() && !!this.getCurrentUser();
  },

  // Get user role from Firestore
  async getUserRole(uid) {
    try {
      const userDoc = await db.collection('users').doc(uid).get();
      if (userDoc.exists) {
        return userDoc.data().role;
      }
      return null;
    } catch (error) {
      console.error('Error getting user role:', error);
      return null;
    }
  }
};

// Firebase Firestore Helper Functions
const FirebaseDB = {
  // Get user data
  async getUserData(uid) {
    try {
      const userDoc = await db.collection('users').doc(uid).get();
      if (userDoc.exists) {
        return userDoc.data();
      }
      return null;
    } catch (error) {
      console.error('Error getting user data:', error);
      throw error;
    }
  },

  // Update user data
  async updateUserData(uid, data) {
    try {
      data.updatedAt = firebase.firestore.FieldValue.serverTimestamp();
      await db.collection('users').doc(uid).update(data);
      return true;
    } catch (error) {
      console.error('Error updating user data:', error);
      throw error;
    }
  },

  // Create a booking
  async createBooking(bookingData) {
    try {
      const bookingRef = db.collection('bookings').doc();
      const newBooking = {
        ...bookingData,
        id: bookingRef.id,
        clientUid: bookingData.clientId || bookingData.clientUid,
        providerUid: bookingData.serviceProviderId || bookingData.providerUid || bookingData.provider_id,
        createdAt: firebase.firestore.FieldValue.serverTimestamp(),
        updatedAt: firebase.firestore.FieldValue.serverTimestamp()
      };
      
      await bookingRef.set(newBooking);
      return bookingRef.id;
    } catch (error) {
      console.error('Error creating booking:', error);
      throw error;
    }
  },

  // Get user's bookings
  async getUserBookings(userId, role = 'client') {
    try {
      const field = role === 'client' ? 'clientUid' : 'providerUid';
      const bookingsSnapshot = await db.collection('bookings')
        .where(field, '==', userId)
        .orderBy('createdAt', 'desc')
        .get();
      
      return bookingsSnapshot.docs.map(doc => ({
        id: doc.id,
        ...doc.data()
      }));
    } catch (error) {
      console.error('Error getting user bookings:', error);
      throw error;
    }
  }
};

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { FirebaseAuth, FirebaseDB };
}