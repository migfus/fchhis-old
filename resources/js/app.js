import "admin-lte/plugins/fontawesome-free/css/all.min.css";
import "admin-lte/dist/css/adminlte.min.css";
import "admin-lte/plugins/jquery/jquery";
import "admin-lte/plugins/bootstrap/js/bootstrap.bundle";
import "admin-lte/dist/js/adminlte";

import { createApp, markRaw } from "vue";
import { createPinia } from "pinia";
import router from "./router";
import Toast from "vue-toastification";

import App from "./App.vue";

const app = createApp(App);
const pinia = createPinia();

pinia.use(({ store }) => {
  store.$router = markRaw(router);
});

app.use(router);
app.use(pinia);
app.use(Toast);

import jwtInterceptor from "./helpers/jwtInterceptor";
jwtInterceptor();

app.mount("#app");
