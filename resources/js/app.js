require('./bootstrap');
import axios from 'axios';
window.Vue = require('vue');
import App from './vue/app'
import VueResource from 'vue-resource'
import { Form, HasError, AlertError } from 'vform'
import Swal from 'sweetalert2'

window.Form=Form;
window.Swal=Swal;
const app=new Vue({
    el:'#app',
    components: { App }
});

Vue.use(VueResource);
