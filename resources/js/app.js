import { createApp } from 'vue';
import App from './app.vue';
import '../css/app.css'; // 
import router from './router';
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap/dist/js/bootstrap.bundle.min.js';


createApp(App).use(router).mount('#app');
