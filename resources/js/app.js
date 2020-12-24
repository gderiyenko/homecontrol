require('./bootstrap');

require('alpinejs');

window.Vue = require("vue");

import Vue from 'vue';
import Vuetify from 'vuetify';

Vue.use(Vuetify);

const vuetify = new Vuetify({
    icons: {
        iconfont: "mdi"
    },
    theme: {
        themes: {
            light: {
                primary: "#2CCE7A"
            }
        }
    }
});

Vue.component(
    "add-object",
    require("./pages/home.vue").default
);

new Vue({
    vuetify,
  }).$mount('#main')