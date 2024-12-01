<template>
    <div class="">
        <div class="container mx-auto mt-16 px-4 py-8">
            <!-- Search and Filter Section -->
            <div class="flex flex-col lg:flex-row lg:justify-between space-y-4 lg:space-y-0">
                <!-- Search Bar -->
                <div class="w-full lg:w-1/3">
                    <div class="flex gap-4">
                        <input
                            type="text"
                            v-model="searchQuery"
                            @input="handleSearch"
                            placeholder="Search products..."
                            class="w-full text-black px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="w-full lg:w-auto">
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 sm:items-center">
                        <label for="categoryFilter" class="text-black whitespace-nowrap"
                            >Filter by Category:</label
                        >
                        <select
                            v-model="selectedCategory"
                            @change="handleCategoryChange"
                            class="w-full sm:w-auto text-black px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">All Categories</option>
                            <option
                                v-for="category in categoryStore.categories"
                                :key="category.id"
                                :value="category.id"
                            >
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

            <div v-else class="overflow-x-hidden md:overflow-x-visible">
                <ProductTable
                    :products="productStore.products"
                    @edit="handleEdit"
                    @delete="handleDelete"
                />
            </div>

            <Pagination
                :current-page="currentPage"
                :meta="productStore.products.meta"
                @page-change="handlePageChange"
            />
        </div>
    </div>
</template>

<script setup>
import ProductTable from "../components/products/ProductTable.vue";
import Pagination from "../components/products/Pagination.vue";
import { useProductStore } from "../store/productStore";
import { useCategoryStore } from "../store/categoryStore";
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
const productStore = useProductStore();
const currentPage = ref(1);
const searchQuery = ref("");
const router = useRouter();
import Swal from "sweetalert2";

const selectedCategory = ref("");

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
        category: selectedCategory._value,
    });
};

// Call fetchProducts when component mounts with pagination params
onMounted(() => {
    productStore.fetchProducts({
        page: currentPage.value,
    });
    categoryStore.fetchCategories();
});

const handlePageChange = (newPage) => {
    currentPage.value = newPage;
    productStore.fetchProducts({
        page: newPage,
    });
};

const handleEdit = (id) => {
    console.log(id);
    router.push(`/edit/${id}`);
};

const handleDelete = (id) => {
    console.log(id);

    try {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await productStore.deleteProduct({ id });
                if (response.success) {
                    Swal.fire({
                        title: "Success!",
                        text: "Product deleted successfully",
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                    productStore.fetchProducts({
                        page: currentPage.value,
                    });
                }
            }
        });
    } catch (err) {
        console.log(err);
    }
};
</script>
