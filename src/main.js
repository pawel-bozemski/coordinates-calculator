import 'bootstrap/dist/css/bootstrap.css';

import { createApp } from 'vue'
import VueGoogleMaps from '@fawmi/vue-google-maps'
import App from './App.vue'

const app = createApp(App);
app.use(VueGoogleMaps, {
    load: {
        key: '',        
    },
}).mount('#app')

import 'bootstrap/dist/js/bootstrap.bundle.js'