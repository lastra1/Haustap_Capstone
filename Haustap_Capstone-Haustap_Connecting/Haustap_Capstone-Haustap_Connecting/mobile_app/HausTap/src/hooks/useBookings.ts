import { useState, useEffect } from 'react';
import { firebaseBooking, Booking } from '../services/firebaseBooking';
import { useAuth } from '../context/AuthContext';

export const useBookings = () => {
  const { user, userData } = useAuth();
  const [bookings, setBookings] = useState<Booking[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchBookings = async () => {
    if (!user || !userData) return;

    try {
      setLoading(true);
      setError(null);
      
      const role = userData.role === 'service_provider' ? 'service_provider' : 'client';
      const userBookings = await firebaseBooking.getUserBookings(user.uid, role);
      setBookings(userBookings);
    } catch (err: any) {
      setError(err.message || 'Failed to fetch bookings');
      console.error('Error fetching bookings:', err);
    } finally {
      setLoading(false);
    }
  };

  const createBooking = async (bookingData: Omit<Booking, 'id' | 'clientId' | 'createdAt' | 'updatedAt'>) => {
    if (!user) throw new Error('User not authenticated');

    try {
      const newBooking = {
        ...bookingData,
        clientId: user.uid,
      };
      
      const bookingId = await firebaseBooking.createBooking(newBooking);
      await fetchBookings(); // Refresh bookings
      return bookingId;
    } catch (err: any) {
      throw new Error(err.message || 'Failed to create booking');
    }
  };

  const cancelBooking = async (bookingId: string, reason?: string) => {
    try {
      await firebaseBooking.cancelBooking(bookingId, reason);
      await fetchBookings(); // Refresh bookings
    } catch (err: any) {
      throw new Error(err.message || 'Failed to cancel booking');
    }
  };

  const updateBookingStatus = async (bookingId: string, status: string, notes?: string) => {
    try {
      await firebaseBooking.updateBookingStatus(bookingId, status, notes);
      await fetchBookings(); // Refresh bookings
    } catch (err: any) {
      throw new Error(err.message || 'Failed to update booking status');
    }
  };

  const assignServiceProvider = async (bookingId: string, serviceProviderId: string) => {
    try {
      await firebaseBooking.assignServiceProvider(bookingId, serviceProviderId);
      await fetchBookings(); // Refresh bookings
    } catch (err: any) {
      throw new Error(err.message || 'Failed to assign service provider');
    }
  };

  const getBookingStats = async () => {
    if (!user || !userData) return null;

    try {
      const role = userData.role === 'service_provider' ? 'service_provider' : 'client';
      return await firebaseBooking.getBookingStats(user.uid, role);
    } catch (err: any) {
      console.error('Error getting booking stats:', err);
      return null;
    }
  };

  useEffect(() => {
    if (user && userData) {
      fetchBookings();
    }
  }, [user, userData]);

  return {
    bookings,
    loading,
    error,
    fetchBookings,
    createBooking,
    cancelBooking,
    updateBookingStatus,
    assignServiceProvider,
    getBookingStats,
  };
};

export const useServices = () => {
  const [services, setServices] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchServices = async (category?: string) => {
    try {
      setLoading(true);
      setError(null);
      
      // You'll need to implement this in your firebaseAPI service
      const servicesData = await firebaseAPI.getServices(category);
      setServices(servicesData);
    } catch (err: any) {
      setError(err.message || 'Failed to fetch services');
      console.error('Error fetching services:', err);
    } finally {
      setLoading(false);
    }
  };

  return {
    services,
    loading,
    error,
    fetchServices,
  };
};

export const useVouchers = () => {
  const { user } = useAuth();
  const [vouchers, setVouchers] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchVouchers = async () => {
    if (!user) return;

    try {
      setLoading(true);
      setError(null);
      
      const vouchersData = await firebaseAPI.getValidVouchers(user.uid);
      setVouchers(vouchersData);
    } catch (err: any) {
      setError(err.message || 'Failed to fetch vouchers');
      console.error('Error fetching vouchers:', err);
    } finally {
      setLoading(false);
    }
  };

  const validateVoucher = async (code: string) => {
    if (!user) return null;

    try {
      return await firebaseAPI.validateVoucher(code, user.uid);
    } catch (err: any) {
      throw new Error(err.message || 'Failed to validate voucher');
    }
  };

  const useVoucher = async (voucherId: string) => {
    if (!user) throw new Error('User not authenticated');

    try {
      await firebaseAPI.useVoucher(voucherId, user.uid);
      await fetchVouchers(); // Refresh vouchers
    } catch (err: any) {
      throw new Error(err.message || 'Failed to use voucher');
    }
  };

  useEffect(() => {
    if (user) {
      fetchVouchers();
    }
  }, [user]);

  return {
    vouchers,
    loading,
    error,
    fetchVouchers,
    validateVoucher,
    useVoucher,
  };
};

// Import the firebaseAPI service
import { firebaseAPI } from '../services/firebaseAPI';