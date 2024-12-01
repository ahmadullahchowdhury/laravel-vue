<template >
    <div class="min-h-screen flex flex-col">
        <NavBar />

        <!-- Main content area -->
        <main class="flex-grow pt-16">
            <router-view></router-view>
        </main>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup>
import NavBar from '../components/shared/NavBar.vue';
import Footer from '../components/shared/Footer.vue';
</script>

