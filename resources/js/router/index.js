import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../pages/HomePage.vue';
import EditPage from '../pages/EditPage.vue';
import CreatePage from '../pages/CreatePage.vue';
import NotFound from '../pages/NotFound.vue';

const routes = [
    { path: '/', component: HomePage },
    { path: '/edit/:id', component: EditPage },
    { path: '/create', component: CreatePage },
    { path: '/:pathMatch(.*)*', component: NotFound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;