import Vue from 'vue';
import App from './App.vue';
import router from './router';
import './axiosConfig';
import store from './store/index';
import {ModalPlugin} from 'bootstrap-vue';

Vue.config.productionTip = false;

Vue.use(ModalPlugin);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
