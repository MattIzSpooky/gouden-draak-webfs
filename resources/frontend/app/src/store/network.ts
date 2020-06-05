import {Module} from 'vuex';

export interface NetworkState {
  loading: boolean;
}

const networkModule: Module<NetworkState, never> = {
  namespaced: true,

  state: {
    loading: false
  },

  getters: {
    isLoading(state: NetworkState) {
      return state.loading;
    }
  },

  mutations: {
    SET_LOADING(state: NetworkState, value: boolean) {
      state.loading = value;
    }
  },

  actions: {
    async toggleLoad({commit, state}) {
      commit('SET_LOADING', !state.loading);
    }
  }
};

export default networkModule;
