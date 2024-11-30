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
                this.products = response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Error fetching products';
            } finally {
                this.loading = false;
            }
        },
        async editProduct(params = { id }) {
            this.categories = [];
            this.products = {};
            this.loading = true;
            this.error = null;
            try {
                const response = await apiClient.get(`/products/edit/${params.id}`);
                console.log('API Response:', response.data);
                this.products = response.data.product;
                this.categories = response.data.categories;
            } catch (error) {
                this.error = error.response?.data?.message || 'Error fetching products';
            } finally {
                this.loading = false;
            }
        },
        async updateProduct(params = { id, name, price, sku, quantity, category_id }) {
            this.loading = true;
            this.error = null;
            try {
                const response = await apiClient.put(`/products/update/${params.id}`, {
                    name: params.name,
                    price: params.price,
                    sku: params.sku,
                    quantity: params.quantity,
                    category_id: params.category_id
                });
                return response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Error updating product';
                throw error;
            } finally {
                this.loading = false;
            }
        },

    },




});