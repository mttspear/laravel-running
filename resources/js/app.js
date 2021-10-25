/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import BootstrapVue from "bootstrap-vue";
window.Vue = require("vue").default;
Vue.use(BootstrapVue);

import "vue-progress-path/dist/vue-progress-path.css";
import VueProgress from "vue-progress-path";

Vue.use(VueProgress, {
    defaultShape: "circle",
});

//require("./three");

//import { EffectComposer } from "/node_modules/three/examples/jsm/postprocessing/EffectComposer.js";
//import { TextGeometry } from "./jsm/geometries/TextGeometry.js";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "available-players-component",
    require("./components/AvailablePlayersComponent.vue").default
);

Vue.component(
    "game-component",
    require("./components/GameComponent.vue").default
);

Vue.component(
    "scoreboard-component",
    require("./components/ScoreboardComponent.vue").default
);

Vue.component(
    "user-games-component",
    require("./components/UserGamesComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    props: [],
    data() {
        return {};
    },
    created() {},

    methods: {},
});
