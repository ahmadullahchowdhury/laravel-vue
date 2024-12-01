<template>
    <nav>
        <div class="fixed top-0 left-0 right-0 bg-white shadow-md">
            <div
                class="container mx-auto flex items-center justify-between px-4 py-3"
            >
                <router-link
                    to="/"
                    class="px-3 py-2 text-black font-bold text-lg hover:text-blue-600 rounded-md hover:bg-gray-100"
                >
                    Products
                </router-link>
                <router-link
                    to="/create"
                    class="px-3 py-2 bg-green-400 text-white hover:text-blue-600 rounded-md hover:bg-gray-100"
                >
                    Create Product
                </router-link>
            </div>
        </div>
    </nav>
</template>
