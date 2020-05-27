<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';

export default {
  computed: {
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user'
    })
  },

  methods: {
    ...mapActions({
      signOutAction: 'auth/signOut'
    }),

    async signOut() {
      await this.signOutAction();

      await this.$router.replace({name: 'home'});
    }
  }
};
</script>
