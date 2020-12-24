require('./bootstrap');

require('alpinejs');

window.Vue = require("vue");

import Vue from 'vue';
import Vuetify from 'vuetify';
Vue.use(Vuetify);

new Vue({
    vuetify,
  }).$mount('#app')
const vuetify = new Vuetify({
    icons: {
        iconfont: "mdi" // default - only for display purposes
    },
    theme: {
        themes: {
            light: {
                primary: "#2CCE7A"
            }
        }
    }
});