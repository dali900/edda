import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import router from "./router";
import PrimeVue from "primevue/config";
import Menubar from "primevue/menubar";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Card from "primevue/card";
import ToastService from "primevue/toastservice";
import Toast from "primevue/toast";
import ConfirmationService from "primevue/confirmationservice";
import ConfirmDialog from "primevue/confirmdialog";

import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import "/node_modules/primeflex/primeflex.css";
import "./assets/main.css";
import "flatpickr/dist/flatpickr.css";

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(PrimeVue);
app.use(ToastService);
app.use(ConfirmationService);

app.component("Menubar", Menubar);
app.component("Button", Button);
app.component("Dialog", Dialog);
app.component("Card", Card);
app.component("Toast", Toast);
app.component("ConfirmDialog", ConfirmDialog);

app.mount("#app");
