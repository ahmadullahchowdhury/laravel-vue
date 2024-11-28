<template>
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl text-black font-bold mb-8">Products</h1>

            <!-- Search Bar -->

            <div class="flex justify-between">

                <!-- Search Bar -->
                <div class="mb-6">
                <div class="flex gap-4 w-1/3">
                    <input 
                        type="text" 
                        v-model="searchQuery"
                        @input="handleSearch"
                        placeholder="Search products..."
                        class="flex-1 text-black  px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
            </div>

            <!-- Category Filter -->
            <div class="mb-6">
                <div class="flex gap-4 items-center">
                    <label for="categoryFilter" class="text-black">Filter by Category:</label>
                    <select 
                        v-model="selectedCategory"
                        @change="handleCategoryChange"
                        class="flex-1 text-black px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">All Categories</option>
                        <option v-for="category in categoryStore.categories" 
                                :key="category.id" 
                                :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
            </div>

            </div>


            
            <div v-if="productStore.loading" class="text-center">
                <p class="text-gray-600 min-h-[100vh]">Loading products...</p>
            </div>
    
            <div v-else-if="productStore.error" class="text-center">
                <p class="text-red-500">{{ productStore.error }}</p>
            </div>
    
            <div v-else class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="product in productStore.products.data" :key="product.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-black whitespace-nowrap">{{ product?.name }}</td>
                            <td class="px-6 py-4 text-black whitespace-nowrap">{{ product?.category?.name }}</td>
                            <td class="px-6 py-4 text-black whitespace-nowrap">{{ product?.sku }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600 font-bold">${{ product?.price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">
                                    Edit
                                </button>
                                <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="5" class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-700">
                                            Showing {{ productStore?.products?.meta?.from }} to {{ productStore?.products?.meta?.to }} of {{ productStore?.products?.meta?.total }} entries
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            @click="handlePageChange(currentPage - 1)"
                                            :disabled="currentPage <= 1"
                                            :class="{'opacity-50 cursor-not-allowed': currentPage <= 1}"
                                            class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                                        >
                                            Previous
                                        </button>
                                        <span class="text-sm text-gray-700">
                                            Page {{ currentPage }} of {{ productStore?.products?.meta?.last_page }}
                                        </span>
                                        <button 
                                            @click="handlePageChange(currentPage + 1)"
                                            :disabled="currentPage >= productStore?.products?.meta?.last_page"
                                            :class="{'opacity-50 cursor-not-allowed': currentPage >= productStore?.products?.meta?.last_page}"
                                            class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                                        >
                                            Next
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useProductStore } from "../store/productStore";
import { useCategoryStore } from "../store/categoryStore";
import { onMounted, ref, watch } from 'vue'

const productStore = useProductStore();
const currentPage = ref(1);
const searchQuery = ref('');

const selectedCategory = ref('');

const categoryStore = useCategoryStore();
// Debounce function
const debounce = (fn, delay) => {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
    };
};

// Debounced search handler
const handleSearch = debounce(() => {
    currentPage.value = 1; // Reset to first page when searching
    productStore.fetchProducts({
        search: searchQuery.value,
    });
}, 300);

// Handle category change
const handleCategoryChange = () => {
     // Reset to first page when changing category
     console.log(selectedCategory._value);
    productStore.fetchProducts({
        category: selectedCategory._value
    });
};

// Call fetchProducts when component mounts with pagination params
onMounted(() => {
    productStore.fetchProducts({
        page: currentPage.value,
    })
    categoryStore.fetchCategories();
})

const handlePageChange = (newPage) => {
    currentPage.value = newPage;
    productStore.fetchProducts({
        page: newPage,
    })
}

</script>

