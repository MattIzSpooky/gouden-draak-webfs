import axios from 'axios';
import store from '@/store';
import router from '@/router';

axios.defaults.withCredentials = true;
axios.defaults.xsrfCookieName = 'XSRF-TOKEN';
axios.defaults.baseURL = 'http://localhost:8000/';

axios.interceptors.response.use((response) => response, async (error) => {
  if (error.response.status === 401) {
    await router.push({name: 'login'});
  }
  return Promise.reject(error);
});

axios.interceptors.request.use((config) => {
  // FIXME: fix typing
  // eslint-disable-next-line
  config.headers.Authorization = `Bearer ${(store.state as any).auth.bearerToken}`;

  return config;
});
