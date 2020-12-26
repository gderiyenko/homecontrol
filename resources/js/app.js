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
    "objects-list",
    require("./components/ObjectsList.vue").default
);

Vue.component(
    "add-command",
    require("./components/AddCommand.vue").default
);

Vue.component(
    "commands-list",
    require("./components/CommandsList.vue").default
);

new Vue({
    vuetify,
  }).$mount('#main')