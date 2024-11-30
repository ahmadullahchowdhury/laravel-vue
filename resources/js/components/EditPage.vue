<template>
    <div class="container mx-auto p-4">

        <router-link to="/" class="text-2xl font-bold mt-5 mb-4">All Products</router-link>
        <h1 class="text-2xl font-bold mt-5 mb-4">Edit Product</h1>

        <div v-if="productStore.loading">Loading...</div>

        <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ error }}
        </div>

        <form v-else-if="productStore.products" class="space-y-4" @submit.prevent="handleSubmit">
           
           <div class="flex gap-4 ">
               <div class="w-full">
                   <label for="name">Name:</label>
                   <input type="text" v-model="form.name" class="w-full border rounded mt-1 p-2" >
                   <span v-if="validationErrors.name" class="text-red-500 text-sm">{{ validationErrors.name[0] }}</span>
               </div>
               <div class="w-full">
                   <label for="name">Price:</label>
                   <input type="text" v-model="form.price" class="w-full border rounded mt-1 p-2" >
                   <span v-if="validationErrors.price" class="text-red-500 text-sm">{{ validationErrors.price[0] }}</span>
               </div>
               <div class="w-full">
                   <label for="name">Quantity:</label>
                   <input type="text" v-model="form.quantity" class="w-full border rounded mt-1 p-2" >
                   <span v-if="validationErrors.quantity" class="text-red-500 text-sm">{{ validationErrors.quantity[0] }}</span>
               </div>

            </div>
            <div class="flex gap-4 ">
                <div class="w-full">
                    <label for="name">SKU:</label>
                    <input type="text" v-model="form.sku" class="w-full border rounded mt-1 p-2" >
                    <span v-if="validationErrors.sku" class="text-red-500 text-sm">{{ validationErrors.sku[0] }}</span>
                </div>
                <div class="w-full">
                    <label for="name">Category:</label>
                    <select v-model="form.category_id" class="w-full border rounded mt-1 p-2">
                        <option v-for="category in productStore.categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <span v-if="validationErrors.category_id" class="text-red-500 text-sm">{{ validationErrors.category_id[0] }}</span>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Save Changes
                </button>
            </div>

        </form>
        <div v-else class="text-red-500">
            {{ productStore.error || 'Error loading product' }}
        </div>
    </div>
</template>
<script setup>
import { useProductStore } from '../store/productStore';
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const productStore = useProductStore();

const error = ref('');
const validationErrors = ref({});

const form = ref({
    name: '',
    price: '',
    sku: '',
    quantity: '',
    category_id: ''
});

onMounted(async () => {
    const productId = route.params.id;
    await productStore.editProduct({ id: productId });
    
    // Populate form with product data once loaded
    if (productStore.products) {
        form.value = {
            name: productStore.products.name,
            price: productStore.products.price,
            sku: productStore.products.sku,
            quantity: productStore.products.quantity,
            category_id: productStore.products.category_id
        };
    }
});

const handleSubmit = async () => {
    try {
        error.value = '';
        validationErrors.value = {};
        
        const response = await productStore.updateProduct({
            id: route.params.id,
            ...form.value
        });

        console.log(response)
        if (response.success) {
            router.push('/'); 
        }
    } catch (err) {
        if (err.response?.status === 422) {
            validationErrors.value = err.response.data.errors;
        } else {
            error.value = err.response?.data?.message || 'An error occurred while updating the product';
        }
        // console.error('Error updating product:', err);
    }
};
</script>
