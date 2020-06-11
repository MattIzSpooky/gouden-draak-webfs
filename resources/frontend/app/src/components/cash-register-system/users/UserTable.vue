<template>
  <table class="table">
    <tr>
      <th>
        Badge nummer
      </th>
      <th>
        Naam
      </th>
      <th>
        Rol
      </th>
      <th>
        Actie
      </th>
    </tr>
    <tr v-for="user in users" :key="user.id">
      <td>
       {{user.badge}}
      </td>
      <td>
        {{user.name}}
      </td>
      <td>
        {{user.role.dutchName}}
      </td>
      <td>
        <button type="button" class="btn btn-primary" @click="onClickUser(user)">
          Bewerken
        </button>
      </td>
    </tr>
  </table>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {User} from '@/types/user';

  @Component
export default class UserTable extends Vue {
    @Prop(Array) public readonly users!: User[];

    @Emit('userClick')
    onClickUser(user: User) {
      return user;
    }
};
</script>

<style scoped>

</style>
