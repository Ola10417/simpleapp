require('./bootstrap');
import axios from 'axios';
window.Vue = require('vue');
import App from './vue/app'

const app=new Vue({
    el:'#app',
    components: { App }
});
