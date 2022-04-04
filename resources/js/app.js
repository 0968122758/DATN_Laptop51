require("./bootstrap");
// require('@coreui/coreui/dist/js/coreui.bundle.min');
import Vue from "vue";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import Paginate from "vuejs-paginate";
import UserList from "./components/user/index.vue";
import CategoryList from "./components/category/index.vue";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

Vue.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 20,
  newestOnTop: true
});
Vue.use(VueSweetalert2);
Vue.component("paginate", Paginate);

new Vue({
    created() {},
    el: "#app",
    components: {
        UserList,
        CategoryList,
    },
    methods: {},
    mounted() {},
});
