require('./bootstrap');
import axios from 'axios';
window.Vue = require('vue');
import App from './vue/app'
import VueResource from 'vue-resource'
import { Form, HasError, AlertError } from 'vform'

window.Form=Form;
const app=new Vue({
    el:'#app',
    components: { App }
});

Vue.use(VueResource);
