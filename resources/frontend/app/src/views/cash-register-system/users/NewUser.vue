<template>
  <div class="card m-3">
    <div class="card-header">
      Nieuwe gebruiker aanmaken
    </div>
    <div class="card-body">
      <user-form :user-roles="userRoles" :error="error" @onSubmit="onSubmit"/>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import UserForm from '@/components/cash-register-system/users/UserForm.vue';
import store from '@/store';
import axios from 'axios';
import {ApiResource, ApiValidationError} from '@/types/api';
import {UserRoleType} from '@/types/user';
import router from '@/router';
import {UserRequest} from '@/types/user-extra';

  @Component({
    components: {
      UserForm
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);
      const userRoles = await axios.get<ApiResource<UserRoleType[]>>('/api/users/roles');

      next(async (vm: NewUser) => {
        vm.userRoles = userRoles.data.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class NewUser extends Vue {
    public userRoles: UserRoleType[] = [];
    public error: ApiValidationError<UserRequest> | null = null;

    async onSubmit(userRequest: UserRequest) {
      try {
        await axios.post('/api/users', userRequest);
        await router.push({name: 'users'});
      } catch (e) {
        const errorObject = e.response.data as ApiValidationError<UserRequest>;
        this.error = {
          message: errorObject.message,
          errors: errorObject.errors
        };
      }
    }
};
</script>

<style scoped>

</style>
