<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mt-5 mb-4">Edit Product</h1>
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <router-link to="/" class="inline-flex items-center text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </router-link>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-400 md:ml-2">Edit Product</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div v-if="productStore.loading" class="text-center py-4">Loading...</div>

        <div
            v-if="error"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"
        >
            {{ error }}
        </div>

        <form
            v-else-if="productStore.products"
            class="space-y-4  mx-auto"
            @submit.prevent="handleSubmit"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="w-full">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input
                        type="text"
                        v-model="form.name"
                        class="w-full border rounded mt-1 p-2 text-sm sm:text-base"
                        placeholder="Enter product name"
                    />
                    <span
                        v-if="validationErrors.name"
                        class="text-red-500 text-xs sm:text-sm"
                        >{{ validationErrors.name[0] }}</span
                    >
                </div>
                <div class="w-full">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                    <input
                        type="text"
                        v-model="form.price"
                        class="w-full border rounded mt-1 p-2 text-sm sm:text-base"
                        placeholder="Enter price"
                    />
                    <span
                        v-if="validationErrors.price"
                        class="text-red-500 text-xs sm:text-sm"
                        >{{ validationErrors.price[0] }}</span
                    >
                </div>
                <div class="w-full">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity:</label>
                    <input
                        type="text"
                        v-model="form.quantity"
                        class="w-full border rounded mt-1 p-2 text-sm sm:text-base"
                        placeholder="Enter quantity"
                    />
                    <span
                        v-if="validationErrors.quantity"
                        class="text-red-500 text-xs sm:text-sm"
                        >{{ validationErrors.quantity[0] }}</span
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="w-full">
                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU:</label>
                    <input
                        type="text"
                        v-model="form.sku"
                        class="w-full border rounded mt-1 p-2 text-sm sm:text-base"
                        placeholder="Enter SKU"
                    />
                    <span
                        v-if="validationErrors.sku"
                        class="text-red-500 text-xs sm:text-sm"
                        >{{ validationErrors.sku[0] }}</span
                    >
                </div>
                <div class="w-full">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category:</label>
                    <select
                        v-model="form.category_id"
                        class="w-full border rounded mt-1 p-2 text-sm sm:text-base"
                    >
                        <option value="">Select a category</option>
                        <option
                            v-for="category in productStore.categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <span
                        v-if="validationErrors.category_id"
                        class="text-red-500 text-xs sm:text-sm"
                        >{{ validationErrors.category_id[0] }}</span
                    >
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="w-full sm:w-auto bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition-colors text-sm sm:text-base"
                >
                    Save Changes
                </button>
            </div>
        </form>
        <div v-else class="text-red-500 text-center py-4">
            {{ productStore.error || "Error loading product" }}
        </div>
    </div>
</template>

<script setup>
import { useProductStore } from "../store/productStore";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import Swal from "sweetalert2";

const route = useRoute();
const router = useRouter();
const productStore = useProductStore();

const error = ref("");
const validationErrors = ref({});

const form = ref({
    name: "",
    price: "",
    sku: "",
    quantity: "",
    category_id: "",
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
            category_id: productStore.products.category_id,
        };
    }
});

const handleSubmit = async () => {
    try {
        error.value = "";
        validationErrors.value = {};

        const response = await productStore.updateProduct({
            id: route.params.id,
            ...form.value,
        });

        console.log(response);
        if (response.success) {
            Swal.fire({
                title: "Success!",
                text: "Product updated successfully",
                icon: "success",
                confirmButtonText: "OK",
            });
            router.push("/");
        }
    } catch (err) {
        if (err.response?.status === 422) {
            validationErrors.value = err.response.data.errors;
        } else {
            error.value =
                err.response?.data?.message ||
                "An error occurred while updating the product";
        }
    }
};
</script>
