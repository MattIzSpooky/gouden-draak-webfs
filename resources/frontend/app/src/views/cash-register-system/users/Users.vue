<template>
  <loader>
    <router-link class="btn btn-primary ml-3" :to="{name: 'new-user'}">Nieuwe gebruiker aanmaken</router-link>
    <div class="card m-3">
      <div class="card-header">
        Menu
      </div>
      <div class="card-body">
        <user-table :users="users" @userClick="clickUser"/>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import store from '@/store';
import axios from 'axios';
import {ApiResource} from '@/types/api';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import UserTable from '@/components/cash-register-system/users/UserTable.vue';
import {User} from '@/types/user-extra';

@Component({
  components: {
    UserTable,
    Loader
  },
  async beforeRouteEnter(to, _, next) {
    await store.commit('network/SET_LOADING', true);
    const response = await axios.get<ApiResource<User[]>>('/api/users');
    next(async (vm: Users) => {
      vm.users = response.data.data;

      await vm.$store.commit('network/SET_LOADING', false);
    });
  }
})
export default class Users extends Vue {
  public users: User[] = [];

  async clickUser(user: User) {
    await this.$router.push({
      name: 'edit-user',
      params: {
        id: user.id.toString()
      }
    });
  }
};
</script>

<style scoped>

</style>
