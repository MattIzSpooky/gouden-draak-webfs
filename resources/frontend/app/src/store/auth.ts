import axios from 'axios'

export default {
  namespaced: true,

  state: {
    authenticated: false,
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
    }
  },

  actions: {
    async signIn({dispatch}: any, credentials: any) {
      await axios.get('/sanctum/csrf-cookie')
      await axios.post('/login', credentials)

      return dispatch('me')
    },
    async signOut({dispatch}: any) {
      await axios.post('/logout')

      return dispatch('me')
    },
    me({commit}: any) {
      return axios.get('/api/user').then((response) => {
        commit('SET_AUTHENTICATED', true)
        commit('SET_USER', response.data)
      }).catch(() => {
        commit('SET_AUTHENTICATED', false)
        commit('SET_USER', null)
      })
    }
  }
}
