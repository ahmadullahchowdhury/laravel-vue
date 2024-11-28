// resources/js/stores/userStore.js
import { defineStore } from 'pinia';
import apiClient from '../services/axios';

export const useCategoryStore = defineStore('categoryStore', {
    state: () => ({
        categories: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchCategories() {
            this.loading = true;
            this.error = null;
            try {
                const response = await apiClient.get('/categories');
                console.log('Categories Response:', response.data);
                this.categories = response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Error fetching categories';
            } finally {
                this.loading = false;
            }
        },
    },
});