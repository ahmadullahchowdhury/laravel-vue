import './bootstrap';
import App from './layout/app.vue';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


import { createApp } from 'vue';
import { createPinia } from 'pinia';

import router from './router';

const app = createApp(App);
const pinia = createPinia();
app.use(router);
app.use(pinia);
app.use(VueSweetalert2);
app.mount('#app'); 
