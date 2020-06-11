import axios from 'axios';
import {Module} from 'vuex';
import {LoginCredentials, User} from '@/types/user';

export interface GlobalAuthState {
  authenticated: boolean;
  bearerToken: string;
  user: User | null;
}

const authModule: Module<GlobalAuthState, never> = {
  namespaced: true,

  state: {
    authenticated: false,
    bearerToken: '',
    user: null
  },

  getters: {
    authenticated(state: GlobalAuthState) {
      return state.authenticated;
    },
    user(state: GlobalAuthState) {
      return state.user;
    }
  },

  mutations: {
    SET_AUTHENTICATED(state: GlobalAuthState, value: boolean) {
      state.authenticated = value;
    },

    SET_USER(state: GlobalAuthState, value: User | null) {
      state.user = value;
    },

    SET_BEARER_TOKEN(state: GlobalAuthState, value: string) {
      state.bearerToken = value;
    }
  },

  actions: {
    async signIn({commit, dispatch}, credentials: LoginCredentials) {
      const response = await axios.post('/api/login', credentials);
      commit('SET_BEARER_TOKEN', response.data);

      return dispatch('me');
    },
    async signOut({dispatch}) {
      await axios.post('/api/logout');

      return dispatch('me');
    },
    async me({commit}) {
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

export default authModule;
