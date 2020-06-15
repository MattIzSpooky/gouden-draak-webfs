<template>
  <div class="card m-3">
    <div class="card-header">
      Nieuwe gebruiker aanmaken
    </div>
    <div class="card-body">
      <user-form :user-roles="userRoles" :error="error" :form-data="userForm" :is-edit="true" @onSubmit="onSubmit">
        <button type="submit" class="btn btn-danger ml-3" @click="deleteUser">Verwijderen</button>
      </user-form>
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
import {User, UserRequest} from '@/types/user-extra';

@Component({
  components: {
    UserForm
  },
  async beforeRouteEnter(to, _, next) {
    await store.commit('network/SET_LOADING', true);
    const requests = await Promise.all([
      axios.get<ApiResource<UserRoleType[]>>('/api/users/roles'),
      axios.get<ApiResource<User>>(`api/users/${to.params.id}`)
    ]);

    const userRolesResponse = requests[0];
    const userResponse = requests[1];

    next(async (vm: NewUser) => {
      vm.userRoles = userRolesResponse.data.data;
      const user = userResponse.data.data;
      vm.userForm = {
        name: user.name,
        badge: user.badge,
        password: '',
        userRoleId: user.role.id
      };

      await vm.$store.commit('network/SET_LOADING', false);
    });
  }
})
export default class NewUser extends Vue {
    public userRoles: UserRoleType[] = [];
    public error: ApiValidationError<UserRequest> | null = null;
    public userForm: UserRequest = {
      name: '',
      badge: 10,
      password: '',
      userRoleId: 0
    };

    async onSubmit(userRequest: UserRequest) {
      const data = {
        ...userRequest,
        password: userRequest.password === '' ? null : userRequest.password
      };

      try {
        await axios.put(`api/users/${this.$route.params.id}`, data);
        await router.push({name: 'users'});
      } catch (e) {
        const errorObject = e.response.data as ApiValidationError<UserRequest>;
        this.error = {
          message: errorObject.message,
          errors: errorObject.errors
        };
      }
    }

    async deleteUser() {
      await axios.delete(`/api/users/${this.$route.params.id}`);
      await router.push({name: 'users'});
    }
};
</script>
