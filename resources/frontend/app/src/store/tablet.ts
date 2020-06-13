import {Module} from 'vuex';
import {Table} from '@/types/table';
import router from '@/router';

export interface TabletState {
  table: Table;
}

const tabletModule: Module<TabletState, never> = {
  namespaced: true,

  state: {
    table: {
      id: 0,
      name: 'DEFAULT'
    }
  },

  getters: {
    getTable(state: TabletState) {
      return state.table;
    }
  },

  mutations: {
    SET_TABLE(state: TabletState, value: Table) {
      state.table = value;
    }
  },

  actions: {
    async resetTable({commit, dispatch}) {
      commit('SET_TABLE', {
        id: 0,
        name: 'DEFAULT'
      });

      await dispatch('save');
      await router.push({name: 'tables'});
    },
    async updateTable({commit, dispatch}, value: Table) {
      commit('SET_TABLE', value);
      await dispatch('save');
    },
    async save({state}) {
      localStorage.setItem('table', JSON.stringify(state.table));
    },
    async restore({commit}) {
      const tableFromStorage = localStorage.getItem('table');

      if (!tableFromStorage) {
        return;
      }

      commit('SET_TABLE', JSON.parse(tableFromStorage));
    }
  }
};

export default tabletModule;
