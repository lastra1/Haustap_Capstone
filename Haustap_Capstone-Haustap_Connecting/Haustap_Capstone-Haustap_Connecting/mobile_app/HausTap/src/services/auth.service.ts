const API_BASE = 'http://127.0.0.1:8001';

class AuthService {
  // Store sent OTPs temporarily (in a real app, this would be handled by the backend)
  private otpStore: Map<string, { otp: string; timestamp: number }> = new Map();
  private accessToken: string | null = null;
  
  // Generate a random 6-digit OTP
  private generateOTP(): string {
    return Math.floor(100000 + Math.random() * 900000).toString();
  }

  // Send OTP to email via backend
  async sendOTP(email: string, overrideOtp?: string): Promise<{ success: boolean; message?: string }> {
    try {
      // Generate new OTP
      const otp = overrideOtp ?? this.generateOTP();
      
      // Store OTP with timestamp
      this.otpStore.set(email, {
        otp,
        timestamp: Date.now()
      });

      // Call Laravel endpoint to send the OTP email
      const res = await fetch(`${API_BASE}/auth/send-otp`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, otp })
      });

      const data = await this.parseJsonSafe(res);
      if (!res.ok || (data && data.success === false)) {
        const msg = (data && (data.message || (data.errors && Object.values(data.errors)?.[0]?.[0]))) || 'Failed to send OTP';
        console.warn('Failed to send OTP via backend:', data);
        return { success: false, message: msg };
      }

      // For development visibility, also log the OTP
      console.log(`OTP for ${email}: ${otp}`);
      return { success: true };
    } catch (error) {
      console.error('Error sending OTP:', error);
      return { success: false, message: 'Network error' };
    }
  }

  // Verify the OTP
  async verifyOTP(email: string, submittedOTP: string): Promise<boolean> {
    try {
      const storedData = this.otpStore.get(email);
      
      if (!storedData) {
        throw new Error('No OTP found for this email');
      }

      const { otp, timestamp } = storedData;
      const now = Date.now();
      const otpAge = now - timestamp;
      
      // OTP expires after 5 minutes
      if (otpAge > 5 * 60 * 1000) {
        this.otpStore.delete(email);
        throw new Error('OTP has expired');
      }

      // Verify OTP
      if (submittedOTP === otp) {
        // Clear the used OTP
        this.otpStore.delete(email);
        return true;
      }

      return false;
    } catch (error) {
      console.error('Error verifying OTP:', error);
      return false;
    }
  }

  // Check if email has a valid OTP that can be resent
  canResendOTP(email: string): boolean {
    const storedData = this.otpStore.get(email);
    if (!storedData) return true;

    const now = Date.now();
    const timeSinceLastOTP = now - storedData.timestamp;
    
    // Allow resend after 30 seconds
    return timeSinceLastOTP > 30 * 1000;
  }

  // Helper: set stored access token
  setToken(token: string) {
    this.accessToken = token;
  }

  // Helper: get stored access token
  getToken(): string | null {
    return this.accessToken;
  }

  // Register with Laravel backend
  async registerWithBackend(payload: any): Promise<{ success: boolean; token?: string; user?: any; message?: string }> {
    try {
      const res = await fetch(`${API_BASE}/auth/register`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const data = await this.parseJsonSafe(res);
      if (res.status === 201 && data?.token) {
        this.setToken(data.token);
        return { success: true, token: data.token, user: data.user };
      }
      const msg = (data && (data.message || (data.errors && Object.values(data.errors)?.[0]?.[0]))) || 'Registration failed';
      return { success: false, message: msg };
    } catch (error) {
      console.error('Error registering with backend:', error);
      return { success: false, message: 'Network error' };
    }
  }

  // Login with Laravel backend
  async loginWithBackend(email: string, password: string): Promise<{ success: boolean; token?: string; user?: any; message?: string }> {
    try {
      const res = await fetch(`${API_BASE}/auth/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
      });
      const data = await this.parseJsonSafe(res);
      if (res.ok && data?.token) {
        this.setToken(data.token);
        return { success: true, token: data.token, user: data.user };
      }
      const msg = (data && (data.message || (data.errors && Object.values(data.errors)?.[0]?.[0]))) || 'Login failed';
      return { success: false, message: msg };
    } catch (error) {
      console.error('Error logging in:', error);
      return { success: false, message: 'Network error' };
    }
  }

  // Get current authenticated user via /auth/me
  async me(token?: string): Promise<any> {
    const t = token ?? this.accessToken;
    if (!t) throw new Error('No access token');
    const res = await fetch(`${API_BASE}/auth/me`, {
      method: 'GET',
      headers: { 'Authorization': `Bearer ${t}` }
    });
    if (!res.ok) {
      const data = await this.parseJsonSafe(res);
      const msg = (data && (data.message || (data.errors && Object.values(data.errors)?.[0]?.[0]))) || 'Failed to fetch user';
      throw new Error(msg);
    }
    return this.parseJsonSafe(res);
  }

  // Parse JSON safely from a fetch Response
  private async parseJsonSafe(res: Response): Promise<any | null> {
    try {
      const ct = res.headers.get('content-type') || '';
      if (ct.includes('application/json')) {
        return await res.json();
      } else {
        const text = await res.text();
        try { return JSON.parse(text); } catch { return { message: text }; }
      }
    } catch {
      return null;
    }
  }
}

// Export singleton instance
export const authService = new AuthService();




