import AsyncStorage from '@react-native-async-storage/async-storage';
import { accountsStore } from '../../src/services/accountsStore';
import React, { createContext, useContext, useEffect, useState } from 'react';

type Role = 'client' | 'provider';
type User = { email: string; role: Role; isHausTapPartner?: boolean; isApplicationPending?: boolean } | null;

type AuthContextValue = {
  user: User;
  loading: boolean;
  login: (email: string, password: string) => Promise<User>;
  signup: (email: string, password: string) => Promise<void>;
  logout: () => Promise<void>;
  setPartnerStatus: (value: boolean) => Promise<void>;
  setApplicationPending: (value: boolean) => Promise<void>;
  setMode: (mode: Role) => Promise<void>;
  mode: Role;
};

const AuthContext = createContext<AuthContextValue | undefined>(undefined);

const STORAGE_KEY = 'HT_user';

export const AuthProvider = ({ children }: { children: React.ReactNode }) => {
  const [user, setUser] = useState<User>(null);
  const [loading, setLoading] = useState(true);
  const [mode, setModeState] = useState<Role>('client');

  useEffect(() => {
    (async () => {
      try {
        const raw = await AsyncStorage.getItem(STORAGE_KEY);
        if (raw) {
          const parsed = JSON.parse(raw);
          setUser(parsed.user || null);
          setModeState(parsed.mode || 'client');
        }
      } catch {
        // ignore
      } finally {
        setLoading(false);
      }
    })();
  }, []);

  const persist = async (u: User, m: Role) => {
    if (u) await AsyncStorage.setItem(STORAGE_KEY, JSON.stringify({ user: u, mode: m }));
    else await AsyncStorage.removeItem(STORAGE_KEY);
  };

  const login = async (email: string, password: string) => {
    // Simulate async auth
    await new Promise((r) => setTimeout(r, 300));

    // Check created accounts first
    try {
      const acc = accountsStore.getAccountByEmail(email);
      if (acc && acc.password === password) {
        const u = { email, role: 'client' as Role, isHausTapPartner: !!acc.isHausTapPartner, isApplicationPending: !!acc.isApplicationPending };
        setUser(u);
        await persist(u, 'client');
        setModeState('client');
        return u;
      }
    } catch {
      // ignore loading errors
    }

    // Fallback mocked credentials
    const client = { email: 'haustapUser@gmail.com', password: '123haustap' };
    const provider = { email: 'haustapProvider@gmail.com', password: '123haustap' };
    const hybrid = { email: 'carleslie.organo@cdsp.edu.ph', password: 'password', isHausTapPartner: true };

    if (email === client.email && password === client.password) {
      const u = { email, role: 'client' as Role };
      setUser(u);
      await persist(u, 'client');
      setModeState('client');
      return u;
    }

    if (email === provider.email && password === password) {
      const u = { email, role: 'provider' as Role };
      setUser(u);
      await persist(u, 'provider');
      setModeState('provider');
      return u;
    }

    if (email === hybrid.email && password === hybrid.password) {
      const u = { email, role: 'client' as Role, isHausTapPartner: true };
      setUser(u);
      await persist(u, 'client');
      setModeState('client');
      return u;
    }

    // Not a valid account
    throw new Error('Invalid email or password');
  };

  const signup = async (email: string, password: string) => {
    // Persist a new account but do NOT auto-login
    await accountsStore.addAccount({ email, password, isHausTapPartner: false });
    return;
  };

  const logout = async () => {
    setUser(null);
    setModeState('client');
    await persist(null, 'client');
  };

  const setPartnerStatus = async (value: boolean) => {
    if (!user) return;
    const updated = { ...user, isHausTapPartner: value };
    setUser(updated);
    // update accounts store if account exists
    try {
      await accountsStore.updateAccount(user.email, { isHausTapPartner: value });
    } catch {
      // ignore
    }
    await persist(updated, mode);
  };

  const setApplicationPending = async (value: boolean) => {
    if (!user) return;
    const updated = { ...user, isApplicationPending: value };
    setUser(updated);
    try {
      await accountsStore.updateAccount(user.email, { isApplicationPending: value });
    } catch {
      // ignore
    }
    await persist(updated, mode);
  };

  const setMode = async (m: Role) => {
    setModeState(m);
    await persist(user, m);
  };

  return (
    <AuthContext.Provider value={{ user, loading, login, signup, logout, setPartnerStatus, setApplicationPending, setMode, mode }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => {
  const ctx = useContext(AuthContext);
  if (!ctx) throw new Error('useAuth must be used within AuthProvider');
  return ctx;
};

export default AuthContext;
