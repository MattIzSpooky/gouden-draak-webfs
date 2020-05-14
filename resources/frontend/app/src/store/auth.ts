import axios from 'axios'

export default {
  namespaced: true,

  state: {
    authenticated: false,
    bearerToken: '',
    user: null
  },

  getters: {
    authenticated(state: any) {
      return state.authenticated
    },
    user(state: any) {
      return state.user
    }
  },

  mutations: {
    SET_AUTHENTICATED(state: any, value: any) {
      state.authenticated = value
    },

    SET_USER(state: any, value: any) {
      state.user = value
    },

    SET_BEARER_TOKEN(state: any, value: string) {
      state.bearerToken = value
    }
  },

  actions: {
    async signIn({commit, dispatch}: any, credentials: any) {
      await axios.get('/sanctum/csrf-cookie')
      const response = await axios.post('/api/login', credentials)
      commit('SET_BEARER_TOKEN', response.data)
      return dispatch('me')
    },
    async signOut({dispatch}: any) {
      await axios.post('/logout')

      return dispatch('me')
    },
    me({commit, state}: any) {
      return axios.get('/api/user', {
        headers: {
          Authorization: `Bearer ${state.bearerToken}`
        }
      }).then((response) => {
        commit('SET_AUTHENTICATED', true)
        commit('SET_USER', response.data)
      }).catch(() => {
        commit('SET_AUTHENTICATED', false)
        commit('SET_USER', null)
      })
    }
  }
}
