import { createApp } from "vue";
import { createPinia } from "pinia";
import Sfdump from "./dump.js";

import App from "./App.vue";

window.Sfdump = Sfdump;

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.mount("#app");
