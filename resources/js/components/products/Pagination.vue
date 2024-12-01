<template>
    <div class="flex flex-col md:flex-row items-center justify-between mt-3 space-y-4 md:space-y-0">
        <div class="flex items-center w-full md:w-auto justify-center md:justify-start">
            <span class="text-sm text-gray-700 text-center md:text-left">
                Showing {{ meta?.from }} to {{ meta?.to }} of {{ meta?.total }} entries
            </span>
        </div>
        <div class="flex items-center space-x-2 w-full md:w-auto justify-center md:justify-end">
            <button 
                @click="$emit('page-change', currentPage - 1)"
                :disabled="currentPage <= 1"
                :class="{'opacity-50 cursor-not-allowed': currentPage <= 1}"
                class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
            >
                Previous
            </button>
            <span class="text-sm text-gray-700">
                Page {{ currentPage }} of {{ meta?.last_page }}
            </span>
            <button 
                @click="$emit('page-change', currentPage + 1)"
                :disabled="currentPage >= meta?.last_page"
                :class="{'opacity-50 cursor-not-allowed': currentPage >= meta?.last_page}"
                class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
defineProps(['currentPage', 'meta']);
defineEmits(['page-change']);
</script> 