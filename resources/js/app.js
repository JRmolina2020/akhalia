require("./bootstrap");

window.Vue = require("vue");
window.Axios = require("axios");
import store from "./store";
import SmartTable from "vuejs-smart-table";
import swal from "sweetalert";
Vue.use(SmartTable);
Vue.component("panel-home", require("./components/PanelHome.vue").default);
Vue.component("login", require("./components/Login.vue").default);
//usuarios
Vue.component("users", require("./components/User/Users.vue").default);

//STAT validate
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { extend } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import { messages } from "vee-validate/dist/locale/es.json";
Object.keys(rules).forEach(rule => {
    extend(rule, {
        ...rules[rule],
        message: messages[rule]
    });
});
Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);
//END validate

const app = new Vue({
    el: "#app",
    store
});
