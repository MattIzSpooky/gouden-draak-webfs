import Vue from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
import store from './store/index';

Vue.config.productionTip = false;

axios.defaults.withCredentials = true;
axios.defaults.xsrfCookieName = 'XSRF-TOKEN';
axios.defaults.baseURL = 'http://localhost:8000/';

axios.interceptors.request.use(function (config) {
  config.headers.Authorization = `Bearer ${(store.state as any).auth.bearerToken}`;

  return config;
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
