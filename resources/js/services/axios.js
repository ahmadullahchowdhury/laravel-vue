import axios from 'axios';

const apiClient = axios.create({
    baseURL: '/api', // Laravel's API base URL
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
    },
    withCredentials: false, // Include for Laravel Sanctum
});

export default apiClient;