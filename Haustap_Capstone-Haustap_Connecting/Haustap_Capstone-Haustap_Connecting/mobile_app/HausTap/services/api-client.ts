import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://127.0.0.1:8000/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

export const approveApplicant = (id: string) => apiClient.post(`/firebase/applicants/${id}/approve`);
export const rejectApplicant = (id: string) => apiClient.post(`/firebase/applicants/${id}/reject`);
export const promoteApplicant = (id: string) => apiClient.post(`/firebase/applicants/${id}/promote`);
export const listApplicants = () => apiClient.get(`/firebase/applicants`);
export const createApplicant = (payload: any) => apiClient.post(`/firebase/applicants`, payload);
export const listCategories = () => apiClient.get(`/firebase/categories`);
export const createCategory = (payload: any) => apiClient.post(`/firebase/categories`, payload);
export const listServices = () => apiClient.get(`/firebase/services`);
export const createService = (payload: any) => apiClient.post(`/firebase/services`, payload);

export default apiClient;
