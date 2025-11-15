import { 
  signInWithEmailAndPassword, 
  createUserWithEmailAndPassword, 
  signOut, 
  sendPasswordResetEmail,
  updateProfile,
  User
} from 'firebase/auth';
import { doc, setDoc, getDoc, updateDoc } from 'firebase/firestore';
import { auth, db } from '../config/firebase';

export interface UserData {
  uid: string;
  email: string;
  displayName?: string;
  phoneNumber?: string;
  role: 'client' | 'service_provider' | 'admin';
  createdAt: Date;
  updatedAt: Date;
  isActive: boolean;
}

export interface ServiceProviderData extends UserData {
  businessName?: string;
  services: string[];
  rating: number;
  totalBookings: number;
  availability: boolean;
}

class FirebaseAuthService {
  // Login user
  async login(email: string, password: string): Promise<User> {
    try {
      const userCredential = await signInWithEmailAndPassword(auth, email, password);
      return userCredential.user;
    } catch (error) {
      console.error('Login error:', error);
      throw error;
    }
  }

  // Register new user
  async register(email: string, password: string, userData: Partial<UserData>): Promise<User> {
    try {
      const userCredential = await createUserWithEmailAndPassword(auth, email, password);
      const user = userCredential.user;

      // Create user document in Firestore (optional for now to avoid connection issues)
      try {
        const userDoc: UserData = {
          uid: user.uid,
          email: user.email!,
          displayName: userData.displayName || '',
          phoneNumber: userData.phoneNumber || '',
          role: userData.role || 'client',
          roles: [userData.role || 'client'], // Add roles array for rule compatibility
          createdAt: new Date(),
          updatedAt: new Date(),
          isActive: true
        };

        await setDoc(doc(db, 'users', user.uid), userDoc);
      } catch (firestoreError) {
        console.warn('Firestore write failed (optional):', firestoreError);
        // Don't fail registration if Firestore is not available
      }

      // Update user profile
      if (userData.displayName) {
        await updateProfile(user, { displayName: userData.displayName });
      }

      return user;
    } catch (error) {
      console.error('Registration error:', error);
      throw error;
    }
  }

  // Register service provider
  async registerServiceProvider(
    email: string, 
    password: string, 
    userData: Partial<ServiceProviderData>
  ): Promise<User> {
    try {
      const userCredential = await createUserWithEmailAndPassword(auth, email, password);
      const user = userCredential.user;

      // Create service provider document in Firestore (optional for now to avoid connection issues)
      try {
        const providerDoc: ServiceProviderData = {
          uid: user.uid,
          email: user.email!,
          displayName: userData.displayName || '',
          phoneNumber: userData.phoneNumber || '',
          role: 'service_provider',
          roles: ['service_provider'], // Add roles array for rule compatibility
          businessName: userData.businessName || '',
          services: userData.services || [],
          rating: 0,
          totalBookings: 0,
          availability: true,
          createdAt: new Date(),
          updatedAt: new Date(),
          isActive: true
        };

        await setDoc(doc(db, 'service_providers', user.uid), providerDoc);
        await setDoc(doc(db, 'users', user.uid), { ...providerDoc, role: 'service_provider', roles: ['service_provider'] });
      } catch (firestoreError) {
        console.warn('Firestore write failed (optional):', firestoreError);
        // Don't fail registration if Firestore is not available
      }

      // Update user profile
      if (userData.displayName) {
        await updateProfile(user, { displayName: userData.displayName });
      }

      return user;
    } catch (error) {
      console.error('Service provider registration error:', error);
      throw error;
    }
  }

  // Logout user
  async logout(): Promise<void> {
    try {
      await signOut(auth);
    } catch (error) {
      console.error('Logout error:', error);
      throw error;
    }
  }

  // Reset password
  async resetPassword(email: string): Promise<void> {
    try {
      await sendPasswordResetEmail(auth, email);
    } catch (error) {
      console.error('Password reset error:', error);
      throw error;
    }
  }

  // Get user data (with fallback for Firestore issues)
  async getUserData(uid: string): Promise<UserData | null> {
    try {
      const userDoc = await getDoc(doc(db, 'users', uid));
      if (userDoc.exists()) {
        return userDoc.data() as UserData;
      }
      return null;
    } catch (error) {
      console.warn('Get user data from Firestore failed (optional):', error);
      // Return a basic user object if Firestore is not available
      const currentUser = this.getCurrentUser();
      if (currentUser && currentUser.uid === uid) {
        return {
          uid: currentUser.uid,
          email: currentUser.email || '',
          displayName: currentUser.displayName || '',
          phoneNumber: currentUser.phoneNumber || '',
          role: 'client', // Default role
          createdAt: new Date(),
          updatedAt: new Date(),
          isActive: true
        };
      }
      return null;
    }
  }

  // Get service provider data (with fallback for Firestore issues)
  async getServiceProviderData(uid: string): Promise<ServiceProviderData | null> {
    try {
      const providerDoc = await getDoc(doc(db, 'service_providers', uid));
      if (providerDoc.exists()) {
        return providerDoc.data() as ServiceProviderData;
      }
      return null;
    } catch (error) {
      console.warn('Get service provider data from Firestore failed (optional):', error);
      // Return a basic service provider object if Firestore is not available
      const currentUser = this.getCurrentUser();
      if (currentUser && currentUser.uid === uid) {
        return {
          uid: currentUser.uid,
          email: currentUser.email || '',
          displayName: currentUser.displayName || '',
          phoneNumber: currentUser.phoneNumber || '',
          role: 'service_provider',
          businessName: '',
          services: [],
          rating: 0,
          totalBookings: 0,
          availability: true,
          createdAt: new Date(),
          updatedAt: new Date(),
          isActive: true
        };
      }
      return null;
    }
  }

  // Update user profile (with fallback for Firestore issues)
  async updateUserProfile(uid: string, updates: Partial<UserData>): Promise<void> {
    try {
      const userRef = doc(db, 'users', uid);
      await updateDoc(userRef, {
        ...updates,
        updatedAt: new Date()
      });
    } catch (error) {
      console.warn('Update user profile in Firestore failed (optional):', error);
      // Don't fail if Firestore is not available - this is optional for now
    }
  }

  // Get current user
  getCurrentUser(): User | null {
    return auth.currentUser;
  }

  // Listen to auth state changes
  onAuthStateChanged(callback: (user: User | null) => void): () => void {
    return auth.onAuthStateChanged(callback);
  }
}

export const firebaseAuth = new FirebaseAuthService();