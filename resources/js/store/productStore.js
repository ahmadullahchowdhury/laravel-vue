// resources/js/stores/userStore.js
import { defineStore } from 'pinia';
import apiClient from '../services/axios';

export const useProductStore = defineStore('productStore', {
    state: () => ({
        products: {},
        loading: false,
        error: null,
    }),

    actions: {
        async fetchProducts(params = { page: 1, search: '', category: '' }) {
            this.loading = true;
            this.error = null;
            try {
                const response = await apiClient.get('/products', {
                    params: {
                        page: params.page,
                        search: params.search,
                        category: params.category
                    }
                });
                // console.log('API Response:', response.data);
                this.products = response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Error fetching products';
            } finally {
                this.loading = false;
            }
        },
    },
});