<template>
  <div>
    <div class="alert alert-danger" role="alert" v-if="error && error.message">
      {{error.message}}
    </div>
    <form action="#" @submit.prevent="onSubmit">
      <div class="form-group">
        <label for="dishName">naam</label>
        <input type="text" required v-model="formData.name" class="form-control" id="dishName"
               :class="{'is-invalid': error && error.errors.name}">
        <div v-if="error && error.errors.name">
          <p v-for="error in error.error.name" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="badge">Badge nummer</label>
        <input type="number" required v-model.number="formData.badge" min="10" step='1' class="form-control"
               :class="{'is-invalid': error && error.errors.badge}" id="badge">
        <div v-if="error && error.errors.badge">
          <p v-for="error in error.errors.badge" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="password">Wachtwoord</label>
        <input type="password" :required="!isEdit" v-model="formData.password" class="form-control"
               :class="{'is-invalid': error && error.errors.password || !passwordValid}" id="password">
        <div v-if="error && error.errors.password">
          <p v-for="error in error.error.password" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="passwordConfirm">Wachtwoord herhalen</label>
        <input type="password" :required="!isEdit" v-model="passwordConfirm" class="form-control"
               :class="{'is-invalid': !passwordValid}" id="passwordConfirm">
        <small v-if="!passwordValid" class="text-danger">Wachtwoorden zijn ongelijk!</small>
      </div>
      <div class="form-group">
        <label for="role">Rol</label>
        <select v-model.number="formData.userRoleId" class="form-control" id="role"
                :class="{'is-invalid': error && error.errors.userRoleId}">
          <option v-for="role in userRoles" :key="role.id" :value="role.id">{{role.dutchName}}</option>
        </select>
        <div v-if="error && error.errors.userRoleId">
          <p v-for="error in error.error.userRoleId" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" :disabled="!canSubmit" >Opslaan</button>
    </form>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';
import {UserRequest, UserRoleType} from '@/types/user';

  @Component
export default class UserForm extends Vue {
    @Prop({
      required: true,
      type: Array
    }) public userRoles!: UserRoleType[];

    @Prop({
      type: Object
    }) public readonly error!: ApiValidationError<UserRequest>;

    @Prop({
      default: () => ({
        name: '',
        badge: 10,
        password: '',
        userRoleId: 0
      }),
      type: Object
    }) private readonly formData!: UserRequest;

    @Prop({
      default: false,
      type: Boolean
    }) private readonly isEdit!: boolean;

    private passwordConfirm = '';

    get passwordValid() {
      return this.passwordConfirm === this.formData.password;
    }

    get canSubmit() {
      return this.isEdit || this.passwordValid &&
        this.formData.name !== '' &&
        this.formData.badge > 9 &&
        this.formData.password !== '' &&
        this.formData.userRoleId !== 0;
    }

    @Emit('onSubmit')
    onSubmit() {
      return this.formData;
    }
};
</script>
