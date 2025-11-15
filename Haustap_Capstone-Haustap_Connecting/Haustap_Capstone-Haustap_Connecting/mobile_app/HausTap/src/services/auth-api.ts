import apiClient from './api-client';

interface LoginResponse {
    data: {
        role: 'client' | 'service-provider';
        // Add other user data fields here
    };
}

export const login = async (email: string, password: string) => {
    try {
        const response = await apiClient.post<LoginResponse>('/api/auth/login', { email, password });
        // Normalize common Laravel response shapes:
        // - If backend returns { data: { ...user } } then return data
        // - otherwise return response.data directly
        if (response.data && (response.data as any).data) return (response.data as any).data;
        return response.data as any;
    } catch (error: any) {
        throw error.response ? error.response.data : error;
    }
};

export const register = async (payload: any) => {
    try {
        const response = await apiClient.post('/api/auth/register', payload);
        if (response.data && (response.data as any).data) return (response.data as any).data;
        return response.data;
    } catch (error: any) {
        throw error.response ? error.response.data : error;
    }
};
