import { createApp } from 'vue'
import App from './App.vue'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import axios from 'axios'
import router from './router'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const app = createApp(App);
app.component('Datepicker', Datepicker);
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000/';
app.use(router)
app.use(VueSweetalert2)
app.mount('#app')

