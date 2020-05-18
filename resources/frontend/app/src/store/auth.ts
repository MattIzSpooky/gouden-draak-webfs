import axios from 'axios';

export default {
  namespaced: true,

  state: {
    authenticated: false,
    bearerToken: '',
    user: null
  },

  getters: {
    authenticated(state: any) {
      return state.authenticated;
    },
    user(state: any) {
      return state.user;
    }
  },

  mutations: {
    SET_AUTHENTICATED(state: any, value: any) {
      state.authenticated = value;
    },

    SET_USER(state: any, value: any) {
      state.user = value;
    },

    SET_BEARER_TOKEN(state: any, value: string) {
      state.bearerToken = value;
    }
  },

  actions: {
    async signIn({commit, dispatch}: any, credentials: any) {
      const response = await axios.post('/api/login', credentials);
      commit('SET_BEARER_TOKEN', response.data);
      return dispatch('me');
    },
    async signOut({dispatch, state}: any) {
      await axios.post('/api/logout');

      return dispatch('me');
    },
    async me({commit}: any) {
      try {
        const response = await axios.get('/api/user');

        commit('SET_AUTHENTICATED', true);
        commit('SET_USER', response.data);
      } catch (e) {
        commit('SET_AUTHENTICATED', false);
        commit('SET_USER', null);
      }
    }
  }
};
