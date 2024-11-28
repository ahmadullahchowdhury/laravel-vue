import './bootstrap';
import App from './components/app.vue';


import { createApp } from 'vue';
import { createPinia } from 'pinia';

import router from './router';

const app = createApp(App);
const pinia = createPinia();
app.use(router);
app.use(pinia);
app.mount('#app'); 
