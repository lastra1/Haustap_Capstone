import { 
  collection, 
  doc, 
  setDoc, 
  getDoc, 
  getDocs, 
  query, 
  where, 
  orderBy, 
  updateDoc, 
  serverTimestamp,
  Timestamp
} from 'firebase/firestore';
import { db } from '../config/firebase';

export interface Booking {
  id?: string;
  clientId: string;
  clientUid: string; // Add for Firestore rules compatibility
  serviceProviderId?: string;
  providerUid?: string; // Add for Firestore rules compatibility
  serviceType: string;
  serviceDetails: any;
  location: {
    address: string;
    latitude: number;
    longitude: number;
  };
  schedule: {
    date: Date;
    time: string;
  };
  status: 'pending' | 'confirmed' | 'ongoing' | 'completed' | 'cancelled' | 'returned';
  pricing: {
    basePrice: number;
    additionalCharges: number;
    discount: number;
    totalPrice: number;
  };
  paymentStatus: 'pending' | 'paid' | 'refunded';
  notes?: string;
  createdAt: Date;
  updatedAt: Date;
}

export interface BookingStatus {
  bookingId: string;
  status: string;
  timestamp: Date;
  notes?: string;
}

class FirebaseBookingService {
  // Create new booking
  async createBooking(bookingData: Omit<Booking, 'id' | 'createdAt' | 'updatedAt'>): Promise<string> {
    try {
      const bookingRef = doc(collection(db, 'bookings'));
      const newBooking: Booking = {
        ...bookingData,
        id: bookingRef.id,
        clientUid: bookingData.clientId, // Set clientUid for Firestore rules
        providerUid: bookingData.serviceProviderId, // Set providerUid for Firestore rules
        createdAt: new Date(),
        updatedAt: new Date()
      };

      await setDoc(bookingRef, {
        ...newBooking,
        createdAt: serverTimestamp(),
        updatedAt: serverTimestamp()
      });

      // Create initial status
      await this.updateBookingStatus(bookingRef.id, 'pending', 'Booking created');

      return bookingRef.id;
    } catch (error) {
      console.error('Create booking error:', error);
      throw error;
    }
  }

  // Get booking by ID
  async getBooking(bookingId: string): Promise<Booking | null> {
    try {
      const bookingDoc = await getDoc(doc(db, 'bookings', bookingId));
      if (bookingDoc.exists()) {
        const data = bookingDoc.data();
        return {
          ...data,
          createdAt: data.createdAt?.toDate() || new Date(),
          updatedAt: data.updatedAt?.toDate() || new Date(),
          schedule: {
            ...data.schedule,
            date: data.schedule?.date?.toDate() || new Date()
          }
        } as Booking;
      }
      return null;
    } catch (error) {
      console.error('Get booking error:', error);
      throw error;
    }
  }

  // Get user's bookings
  async getUserBookings(userId: string, role: 'client' | 'service_provider'): Promise<Booking[]> {
    try {
      const field = role === 'client' ? 'clientUid' : 'providerUid';
      const bookingsQuery = query(
        collection(db, 'bookings'),
        where(field, '==', userId),
        orderBy('createdAt', 'desc')
      );

      const querySnapshot = await getDocs(bookingsQuery);
      return querySnapshot.docs.map(doc => {
        const data = doc.data();
        return {
          ...data,
          id: doc.id,
          createdAt: data.createdAt?.toDate() || new Date(),
          updatedAt: data.updatedAt?.toDate() || new Date(),
          schedule: {
            ...data.schedule,
            date: data.schedule?.date?.toDate() || new Date()
          }
        } as Booking;
      });
    } catch (error) {
      console.error('Get user bookings error:', error);
      throw error;
    }
  }

  // Update booking status
  async updateBookingStatus(bookingId: string, status: string, notes?: string): Promise<void> {
    try {
      const bookingRef = doc(db, 'bookings', bookingId);
      
      await updateDoc(bookingRef, {
        status,
        updatedAt: serverTimestamp()
      });

      // Add to status history
      const statusRef = collection(db, 'bookings', bookingId, 'status_history');
      await setDoc(doc(statusRef), {
        status,
        timestamp: serverTimestamp(),
        notes: notes || ''
      });
    } catch (error) {
      console.error('Update booking status error:', error);
      throw error;
    }
  }

  // Assign service provider to booking
  async assignServiceProvider(bookingId: string, serviceProviderId: string): Promise<void> {
    try {
      const bookingRef = doc(db, 'bookings', bookingId);
      await updateDoc(bookingRef, {
        serviceProviderId,
        providerUid: serviceProviderId, // Set providerUid for Firestore rules
        status: 'confirmed',
        updatedAt: serverTimestamp()
      });

      await this.updateBookingStatus(bookingId, 'confirmed', 'Service provider assigned');
    } catch (error) {
      console.error('Assign service provider error:', error);
      throw error;
    }
  }

  // Cancel booking
  async cancelBooking(bookingId: string, reason?: string): Promise<void> {
    try {
      await this.updateBookingStatus(bookingId, 'cancelled', reason || 'Booking cancelled');
    } catch (error) {
      console.error('Cancel booking error:', error);
      throw error;
    }
  }

  // Complete booking
  async completeBooking(bookingId: string): Promise<void> {
    try {
      await this.updateBookingStatus(bookingId, 'completed', 'Booking completed successfully');
    } catch (error) {
      console.error('Complete booking error:', error);
      throw error;
    }
  }

  // Get available service providers for a service
  async getAvailableServiceProviders(serviceType: string): Promise<any[]> {
    try {
      const providersQuery = query(
        collection(db, 'service_providers'),
        where('services', 'array-contains', serviceType),
        where('availability', '==', true),
        where('isActive', '==', true)
      );

      const querySnapshot = await getDocs(providersQuery);
      return querySnapshot.docs.map(doc => ({
        id: doc.id,
        ...doc.data()
      }));
    } catch (error) {
      console.error('Get available service providers error:', error);
      throw error;
    }
  }

  // Get booking statistics for a user
  async getBookingStats(userId: string, role: 'client' | 'service_provider'): Promise<any> {
    try {
      const bookings = await this.getUserBookings(userId, role);
      
      const stats = {
        total: bookings.length,
        pending: bookings.filter(b => b.status === 'pending').length,
        confirmed: bookings.filter(b => b.status === 'confirmed').length,
        ongoing: bookings.filter(b => b.status === 'ongoing').length,
        completed: bookings.filter(b => b.status === 'completed').length,
        cancelled: bookings.filter(b => b.status === 'cancelled').length
      };

      return stats;
    } catch (error) {
      console.error('Get booking stats error:', error);
      throw error;
    }
  }
}

export const firebaseBooking = new FirebaseBookingService();