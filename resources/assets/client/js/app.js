window._ = require('lodash');

import Vue from 'vue'
import VueRouter from 'vue-router'
import './HttpHandler'
import VueAxios from 'vue-axios'
import routes from './routes'
import 'vue-cropperjs'
import moment from 'moment-jalali'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

import App from './App.vue'


import ErrorHandlerMixin from './Mixins/ErrorHandler'
import BaseInformationHandlerMixin from './Mixins/BaseInformationHandler'
import UiHandlerMixin from './Mixins/UiHandler'
import HelperMixin from './Mixins/Helper'
import AuthMixin from './Mixins/Auth'

moment.locale('fa');

Vue.use(VueAxios, axios);
Vue.use(VueRouter);


window.$ = jQuery;
window.Vue = Vue;
window.moment = moment;

let router = new VueRouter({
    routes: routes,
    mode: 'history',
    base: 'client-panel/'
});
router.afterEach((to, from) => {
    $("#loader").animate({"opacity": "0"}, 10, function () {
        $("#loader").css("display", "none");
    });
});
Vue.router = router;
Vue.component('breadcrumb', () => import(/* webpackChunkName: "vendor-js/" */'./components/partials/Breadcrumb'));
Vue.component('cropper-portlet', () => import(/* webpackChunkName: "vendor-js/" */'./components/helper/CropperPortlet'));
Vue.component('ui-button', () => import(/* webpackChunkName: "vendor-js/" */'./components/helper/UiButton'));
Vue.component('portlet-file-input', () => import(/* webpackChunkName: "vendor-js/" */'./components/helper/PortletFileInput'));
Vue.component('portlet-button', () => import(/* webpackChunkName: "vendor-js/" */'./components/helper/PortletButton'));
Vue.component('cropper-portlet', () => import(/* webpackChunkName: "vendor-js/" */'./components/helper/CropperPortlet'));
Vue.component('cropper-tools', () => import(/* webpackChunkName: "vendor-js/" */'./components/helper/CropperTools'));
Vue.component('submit-button', () => import(/* webpackChunkName: "vendor-js/" */'./components/helper/SubmitButton'));
Vue.component('add-button', () => import(/* webpackChunkName: "vendor-js/" */'./components/helper/AddButton'));
Vue.component('vue-dropzone', () => import('vue2-dropzone'));
Vue.component('not-found', () => import(/* webpackChunkName: "vendor-js/" */'./components/partials/NotFound'));

Vue.mixin(ErrorHandlerMixin);
Vue.mixin(UiHandlerMixin);
Vue.mixin(BaseInformationHandlerMixin);
Vue.mixin(HelperMixin);
//Vue.mixin(DataTableMixin);
Vue.mixin(AuthMixin);
/*router.afterEach((to, from) => {
    $("#loader").animate({"opacity": "0"}, 10, function () {
        $("#loader").css("display", "none");
    });
});*/
window.app = new Vue({
    el: '#app',
    router,
    components: {App}
});
