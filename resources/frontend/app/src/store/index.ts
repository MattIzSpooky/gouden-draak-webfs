import Vue from 'vue';
import Vuex from 'vuex';
import auth from './auth';
import network from './network';
import tablet from './tablet';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth,
    network,
    tablet
  }
});
