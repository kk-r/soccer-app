
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/ExampleComponent.vue'));
Vue.component('Teams', require('./components/TeamComponent.vue'));
Vue.component('team-details', require('./components/TeamDetailComponent.vue'));
Vue.component('team-curd', require('./components/TeamCurdomponent.vue'));
Vue.component('player-curd', require('./components/PlayerCurdomponent.vue'));

const app = new Vue({
    el: '#app'
});
