<template>
  <div>
    <div class="alert alert-danger" role="alert" v-if="error && error.message">
      {{error.message}}
    </div>
    <form action="#" @submit.prevent="onSubmit">
      <form-input name="Naam" id="name" v-model="formData.name" :error="error"/>
      <form-input name="Badge nummer" type="number" id="badge" min="0" step="1" v-model.number="formData.badge" :error="error"/>
      <form-input name="Wachtwoord" type="password" id="password" v-model="formData.password" :is-invalid="passwordValid" :error="error"/>
      <form-input name="Wachtwoord herhalen"  type="password" id="passwordConfirm" v-model="passwordConfirm" :is-invalid="passwordValid" :error="error">
        <template v-slot:action>
          <small v-if="!passwordValid" class="text-danger">Wachtwoorden zijn ongelijk!</small>
        </template>
      </form-input>
      <form-select name="Rol" id="role" v-model.number="formData.userRoleId" :error="error">
        <template v-slot:default>
          <option v-for="role in userRoles" :key="role.id" :value="role.id">{{role.dutchName}}</option>
        </template>
      </form-select>
      <button type="submit" class="btn btn-primary" :disabled="!canSubmit" >Opslaan</button>
      <slot></slot>
    </form>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';
import {UserRequest, UserRoleType} from '@/types/user';
import FormInput from '@/components/cash-register-system/common/forms/FormInput.vue';
import FormSelect from '@/components/cash-register-system/common/forms/FormSelect.vue';
@Component({
  components: {FormSelect, FormInput}
})
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
