<template>
    <div class=" mt-4">
        <table class="min-w-full  bg-white">
            <thead class="hidden md:table-header-group">
                <tr class="bg-gray-100 border-b">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr v-for="product in products.data" :key="product.id" class="w-[300px] mx-auto md:w-full flex flex-col md:flex-row md:table-row hover:bg-gray-50">
                    <td class="px-6 py-4 text-black whitespace-nowrap block md:table-cell">
                        <span class="block md:hidden font-bold">Name: </span>
                        {{ product?.name }}
                    </td>
                    <td class="px-6 py-4 text-black whitespace-nowrap block md:table-cell">
                        <span class="block md:hidden font-bold">Category: </span>
                        {{ product?.category?.name }}
                    </td>
                    <td class="px-6 py-4 text-black whitespace-nowrap block md:table-cell">
                        <span class="block md:hidden font-bold">SKU: </span>
                        {{ product?.sku }}
                    </td>
                    <td class="px-6 py-4 text-black whitespace-nowrap block md:table-cell">
                        <span class="block md:hidden font-bold">Quantity: </span>
                        {{ product?.quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap block md:table-cell">
                        <span class="block md:hidden font-bold">Price: </span>
                        <span class="text-green-600 font-bold">${{ product?.price }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap md:text-right">
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-2">
                            <button @click="$emit('edit', product.id)" class=" px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Edit
                            </button>
                            <button @click="$emit('delete', product.id)" class="   px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps(['products']);
defineEmits(['edit', 'delete']);
</script> 