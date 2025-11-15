import React, { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import { User } from 'firebase/auth';
import { firebaseAuth, UserData } from '../services/firebaseAuth';

interface AuthContextType {
  user: User | null;
  userData: UserData | null;
  loading: boolean;
  login: (email: string, password: string) => Promise<void>;
  register: (email: string, password: string, userData: Partial<UserData>) => Promise<void>;
  registerServiceProvider: (email: string, password: string, userData: any) => Promise<void>;
  logout: () => Promise<void>;
  resetPassword: (email: string) => Promise<void>;
  updateProfile: (updates: Partial<UserData>) => Promise<void>;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};

interface AuthProviderProps {
  children: ReactNode;
}

export const AuthProvider: React.FC<AuthProviderProps> = ({ children }) => {
  const [user, setUser] = useState<User | null>(null);
  const [userData, setUserData] = useState<UserData | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const unsubscribe = firebaseAuth.onAuthStateChanged(async (user) => {
      setUser(user);
      if (user) {
        try {
          const data = await firebaseAuth.getUserData(user.uid);
          setUserData(data);
        } catch (error) {
          console.error('Error fetching user data:', error);
          setUserData(null);
        }
      } else {
        setUserData(null);
      }
      setLoading(false);
    });

    return unsubscribe;
  }, []);

  const login = async (email: string, password: string) => {
    try {
      const user = await firebaseAuth.login(email, password);
      setUser(user);
      const data = await firebaseAuth.getUserData(user.uid);
      setUserData(data);
    } catch (error) {
      throw error;
    }
  };

  const register = async (email: string, password: string, data: Partial<UserData>) => {
    try {
      const user = await firebaseAuth.register(email, password, data);
      setUser(user);
      const userData = await firebaseAuth.getUserData(user.uid);
      setUserData(userData);
    } catch (error) {
      throw error;
    }
  };

  const registerServiceProvider = async (email: string, password: string, data: any) => {
    try {
      const user = await firebaseAuth.registerServiceProvider(email, password, data);
      setUser(user);
      const userData = await firebaseAuth.getServiceProviderData(user.uid);
      setUserData(userData);
    } catch (error) {
      throw error;
    }
  };

  const logout = async () => {
    try {
      await firebaseAuth.logout();
      setUser(null);
      setUserData(null);
    } catch (error) {
      throw error;
    }
  };

  const resetPassword = async (email: string) => {
    try {
      await firebaseAuth.resetPassword(email);
    } catch (error) {
      throw error;
    }
  };

  const updateProfile = async (updates: Partial<UserData>) => {
    try {
      if (user) {
        await firebaseAuth.updateUserProfile(user.uid, updates);
        const updatedData = await firebaseAuth.getUserData(user.uid);
        setUserData(updatedData);
      }
    } catch (error) {
      throw error;
    }
  };

  const value = {
    user,
    userData,
    loading,
    login,
    register,
    registerServiceProvider,
    logout,
    resetPassword,
    updateProfile
  };

  return (
    <AuthContext.Provider value={value}>
      {children}
    </AuthContext.Provider>
  );
};