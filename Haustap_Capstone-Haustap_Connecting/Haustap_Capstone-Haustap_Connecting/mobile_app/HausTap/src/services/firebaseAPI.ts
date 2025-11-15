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
  deleteDoc,
  serverTimestamp,
  Timestamp
} from 'firebase/firestore';
import { ref, uploadBytes, getDownloadURL, deleteObject } from 'firebase/storage';
import { db, storage } from '../config/firebase';

export interface Service {
  id?: string;
  name: string;
  category: string;
  description: string;
  basePrice: number;
  duration: number; // in minutes
  image?: string;
  isActive: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export interface Voucher {
  id?: string;
  code: string;
  discountType: 'percentage' | 'fixed';
  discountValue: number;
  minOrderAmount: number;
  maxDiscount: number;
  expiryDate: Date;
  usageLimit: number;
  usedCount: number;
  isActive: boolean;
  createdAt: Date;
}

export interface Notification {
  id?: string;
  userId: string;
  title: string;
  message: string;
  type: 'booking' | 'promotion' | 'system';
  isRead: boolean;
  data?: any;
  createdAt: Date;
}

class FirebaseAPIService {
  // Services Management
  async getServices(category?: string): Promise<Service[]> {
    try {
      let servicesQuery = query(
        collection(db, 'services'),
        where('isActive', '==', true),
        orderBy('name')
      );

      if (category) {
        servicesQuery = query(servicesQuery, where('category', '==', category));
      }

      const querySnapshot = await getDocs(servicesQuery);
      return querySnapshot.docs.map(doc => {
        const data = doc.data();
        return {
          id: doc.id,
          ...data,
          createdAt: data.createdAt?.toDate() || new Date(),
          updatedAt: data.updatedAt?.toDate() || new Date()
        } as Service;
      });
    } catch (error) {
      console.error('Get services error:', error);
      throw error;
    }
  }

  async getServiceById(serviceId: string): Promise<Service | null> {
    try {
      const serviceDoc = await getDoc(doc(db, 'services', serviceId));
      if (serviceDoc.exists()) {
        const data = serviceDoc.data();
        return {
          id: serviceDoc.id,
          ...data,
          createdAt: data.createdAt?.toDate() || new Date(),
          updatedAt: data.updatedAt?.toDate() || new Date()
        } as Service;
      }
      return null;
    } catch (error) {
      console.error('Get service by ID error:', error);
      throw error;
    }
  }

  // Vouchers Management
  async getValidVouchers(userId?: string): Promise<Voucher[]> {
    try {
      const now = new Date();
      const vouchersQuery = query(
        collection(db, 'vouchers'),
        where('isActive', '==', true),
        where('expiryDate', '>', now),
        where('usageLimit', '>', 0)
      );

      const querySnapshot = await getDocs(vouchersQuery);
      const vouchers = querySnapshot.docs.map(doc => {
        const data = doc.data();
        return {
          id: doc.id,
          ...data,
          expiryDate: data.expiryDate?.toDate() || new Date(),
          createdAt: data.createdAt?.toDate() || new Date()
        } as Voucher;
      });

      // Filter out used vouchers if userId is provided
      if (userId) {
        const usedVouchers = await this.getUserUsedVouchers(userId);
        return vouchers.filter(voucher => 
          !usedVouchers.includes(voucher.id!) && voucher.usedCount < voucher.usageLimit
        );
      }

      return vouchers;
    } catch (error) {
      console.error('Get valid vouchers error:', error);
      throw error;
    }
  }

  async validateVoucher(code: string, userId?: string): Promise<Voucher | null> {
    try {
      const vouchersQuery = query(
        collection(db, 'vouchers'),
        where('code', '==', code.toUpperCase()),
        where('isActive', '==', true)
      );

      const querySnapshot = await getDocs(vouchersQuery);
      if (querySnapshot.empty) return null;

      const voucherDoc = querySnapshot.docs[0];
      const voucher = {
        id: voucherDoc.id,
        ...voucherDoc.data(),
        expiryDate: voucherDoc.data().expiryDate?.toDate() || new Date()
      } as Voucher;

      // Check if voucher is expired
      if (voucher.expiryDate < new Date()) return null;

      // Check if usage limit is reached
      if (voucher.usedCount >= voucher.usageLimit) return null;

      // Check if user has already used this voucher
      if (userId) {
        const usedVouchers = await this.getUserUsedVouchers(userId);
        if (usedVouchers.includes(voucher.id!)) return null;
      }

      return voucher;
    } catch (error) {
      console.error('Validate voucher error:', error);
      throw error;
    }
  }

  async useVoucher(voucherId: string, userId: string): Promise<void> {
    try {
      const voucherRef = doc(db, 'vouchers', voucherId);
      const voucher = await getDoc(voucherRef);
      
      if (voucher.exists()) {
        await updateDoc(voucherRef, {
          usedCount: voucher.data().usedCount + 1,
          updatedAt: serverTimestamp()
        });

        // Record voucher usage
        await setDoc(doc(db, 'voucher_usage', `${userId}_${voucherId}`), {
          userId,
          voucherId,
          usedAt: serverTimestamp()
        });
      }
    } catch (error) {
      console.error('Use voucher error:', error);
      throw error;
    }
  }

  // Notifications Management
  async getUserNotifications(userId: string): Promise<Notification[]> {
    try {
      const notificationsQuery = query(
        collection(db, 'notifications'),
        where('userId', '==', userId),
        orderBy('createdAt', 'desc')
      );

      const querySnapshot = await getDocs(notificationsQuery);
      return querySnapshot.docs.map(doc => {
        const data = doc.data();
        return {
          id: doc.id,
          ...data,
          createdAt: data.createdAt?.toDate() || new Date()
        } as Notification;
      });
    } catch (error) {
      console.error('Get user notifications error:', error);
      throw error;
    }
  }

  async markNotificationAsRead(notificationId: string): Promise<void> {
    try {
      await updateDoc(doc(db, 'notifications', notificationId), {
        isRead: true,
        updatedAt: serverTimestamp()
      });
    } catch (error) {
      console.error('Mark notification as read error:', error);
      throw error;
    }
  }

  async createNotification(notification: Omit<Notification, 'id' | 'createdAt'>): Promise<string> {
    try {
      const notificationRef = doc(collection(db, 'notifications'));
      await setDoc(notificationRef, {
        ...notification,
        createdAt: serverTimestamp()
      });
      return notificationRef.id;
    } catch (error) {
      console.error('Create notification error:', error);
      throw error;
    }
  }

  // File Upload
  async uploadFile(file: File, path: string): Promise<string> {
    try {
      const storageRef = ref(storage, path);
      const snapshot = await uploadBytes(storageRef, file);
      const downloadURL = await getDownloadURL(snapshot.ref);
      return downloadURL;
    } catch (error) {
      console.error('Upload file error:', error);
      throw error;
    }
  }

  async deleteFile(path: string): Promise<void> {
    try {
      const storageRef = ref(storage, path);
      await deleteObject(storageRef);
    } catch (error) {
      console.error('Delete file error:', error);
      throw error;
    }
  }

  // Helper methods
  private async getUserUsedVouchers(userId: string): Promise<string[]> {
    try {
      const usageQuery = query(
        collection(db, 'voucher_usage'),
        where('userId', '==', userId)
      );

      const querySnapshot = await getDocs(usageQuery);
      return querySnapshot.docs.map(doc => doc.data().voucherId);
    } catch (error) {
      console.error('Get user used vouchers error:', error);
      return [];
    }
  }

  // Get dashboard statistics
  async getDashboardStats(): Promise<any> {
    try {
      const bookingsSnapshot = await getDocs(collection(db, 'bookings'));
      const usersSnapshot = await getDocs(collection(db, 'users'));
      const providersSnapshot = await getDocs(collection(db, 'service_providers'));

      const bookings = bookingsSnapshot.docs.map(doc => doc.data());
      
      return {
        totalBookings: bookings.length,
        pendingBookings: bookings.filter(b => b.status === 'pending').length,
        completedBookings: bookings.filter(b => b.status === 'completed').length,
        totalUsers: usersSnapshot.docs.length,
        totalServiceProviders: providersSnapshot.docs.length
      };
    } catch (error) {
      console.error('Get dashboard stats error:', error);
      throw error;
    }
  }
}

export const firebaseAPI = new FirebaseAPIService();