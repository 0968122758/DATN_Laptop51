require('./bootstrap');

// require('@coreui/coreui/dist/js/coreui.bundle.min');

import Vue from "vue";
import Login from "./components/auth/Login.vue"

new Vue({
    created() {
       
    },
    el: "#app",
    components: {
        Login
    },
    methods: {},
    mounted() {}
});
