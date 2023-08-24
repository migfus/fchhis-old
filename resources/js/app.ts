import "admin-lte/plugins/fontawesome-free/css/all.min.css"
import "admin-lte/dist/css/adminlte.min.css"
import "admin-lte/plugins/jquery/jquery"
import "admin-lte/plugins/bootstrap/js/bootstrap.bundle"
import "admin-lte/dist/js/adminlte"

import type { Router } from 'vue-router'
import { createPinia } from "pinia"
import { createApp, markRaw } from "vue"
import router from "./Router"
import Toast from "vue-toastification"
import { abilitiesPlugin } from '@casl/vue';
import ability from './Ability';

import App from "./App.vue"

declare module 'pinia' {
    export interface PiniaCustomProperties {
        router: Router;
    }
}

const app = createApp(App)
const pinia = createPinia()

pinia.use(({ store }) => {
    store.$router = markRaw(router)
});
app.use(pinia)
app.use(Toast, { position: "bottom-right" })
app.use(router)
app.use(abilitiesPlugin, ability, {
    useGlobalProperties: true,
});

import jwtInterceptor from "./helpers/jwtInterceptor"
jwtInterceptor()

app.mount("#app")
