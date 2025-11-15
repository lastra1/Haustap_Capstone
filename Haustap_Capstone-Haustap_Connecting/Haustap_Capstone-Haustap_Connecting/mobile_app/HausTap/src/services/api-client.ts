import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://192.168.18.115:8000',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

export default apiClient;
