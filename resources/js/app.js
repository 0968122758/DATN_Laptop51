require('./bootstrap');
// require('@coreui/coreui/dist/js/coreui.bundle.min');

import Vue from "vue";
import UserList from "./components/user/index.vue"

new Vue({
    created() {
    },
    el: "#app",
    components: {
        UserList,
    },
    methods: {},
    mounted() {}
});
