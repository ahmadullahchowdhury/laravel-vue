<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mt-5 mb-4">Create Product</h1>
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
                        <span class="ml-1 text-gray-400 md:ml-2">Create Product</span>
                    </div>
                </li>
            </ol>
        </nav>

        <form class="space-y-4" @submit.prevent="handleSubmit">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-full">
                    <label for="name">Name: <span class="text-red-500">*</span></label>
                    <input
                        placeholder="Enter Name"
                        type="text"
                        v-model="form.name"
                        class="w-full border rounded mt-1 p-2"
                    />
                    <span
                        v-if="validationErrors.name"
                        class="text-red-500 text-sm"
                        >{{ validationErrors.name[0] }}</span
                    >
                </div>
                <div class="w-full">
                    <label for="name">Price: <span class="text-red-500">*</span></label>
                    <input
                        placeholder="Enter Price"
                        type="number"
                        v-model="form.price"
                        class="w-full border rounded mt-1 p-2"
                    />
                    <span
                        v-if="validationErrors.price"
                        class="text-red-500 text-sm"
                        >{{ validationErrors.price[0] }}</span
                    >
                </div>
                <div class="w-full">
                    <label for="name">Quantity: <span class="text-red-500">*</span></label>
                    <input
                        placeholder="Enter Quantity"
                        type="number"
                        v-model="form.quantity"
                        class="w-full border rounded mt-1 p-2"
                    />
                    <span
                        v-if="validationErrors.quantity"
                        class="text-red-500 text-sm"
                        >{{ validationErrors.quantity[0] }}</span
                    >
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-full">
                    <label for="name">SKU: <span class="text-red-500">*</span></label>
                    <input
                        placeholder="Enter SKU"
                        type="text"
                        v-model="form.sku"
                        class="w-full border rounded mt-1 p-2"
                    />
                    <span
                        v-if="validationErrors.sku"
                        class="text-red-500 text-sm"
                        >{{ validationErrors.sku[0] }}</span
                    >
                </div>
                <div class="w-full">
                    <label for="name">Category: <span class="text-red-500">*</span></label>
                    <select
                        v-model="form.category_id"
                        class="w-full border rounded mt-1 p-2"
                    >
                        <option value="">Select Category</option>
                        <option
                            v-for="category in categoryStore.categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <span
                        v-if="validationErrors.category_id"
                        class="text-red-500 text-sm"
                        >{{ validationErrors.category_id[0] }}</span
                    >
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</template>
<script setup>
import { useProductStore } from "../store/productStore";
import { useCategoryStore } from "../store/categoryStore";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import Swal from "sweetalert2";

const route = useRoute();
const router = useRouter();

const productStore = useProductStore();
const categoryStore = useCategoryStore();

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
    categoryStore.fetchCategories();
});

const handleSubmit = async () => {
    console.log("submit");
    try {
        error.value = "";
        validationErrors.value = {};

        const response = await productStore.storeProduct({
            ...form.value,
        });

        // console.log(response);

        if (response.success) {
            Swal.fire({
                title: "Success!",
                text: "Product created successfully",
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
                "An error occurred while creating the product";
        }
    }
};
</script>
