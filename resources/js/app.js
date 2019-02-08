
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueFlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import Notifications from 'vue-notification'
import VueSwal from 'vue-swal'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('form-pasien', require('./components/TambahPasien.vue').default);
Vue.component('form-pasien-edit', require('./components/EditPasien.vue').default);

Vue.component('ajax-table', require('./components/AjaxTable.vue').default);
Vue.component('sorter', require('./components/Sorter.vue').default);

Vue.component('tr-data-pasien', require('./table-row/DataPasien.vue').default);

Vue.component('modal-detail-pasien', require('./modal/DetailPasien.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
require('./components/filter.js');

Vue.use(VueFlatPickr);
Vue.use(Notifications)
Vue.use(VueSwal)

window.eventHub = new Vue();
window.app = new Vue({
    el: '#app',
    data: {
        base_path: base_path,
        base_url: base_url,
        csrf_token: $("meta[name='csrf-token']").attr("content"),
        params: {
        },
        rowparams: {},
    },
});