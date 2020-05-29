<template>
  <div class="full-height container h-100 d-flex justify-content-center">
    <div class="card my-auto mt-5">
      <div class="card-header">
        Login kassa systeem
      </div>
      <div class="card-body">
        <div class="alert alert-danger fade show" v-if="hasError">
          Verkeerde inloggegevens.
        </div>
        <form action="#" @submit.prevent="submit">
          <div class="form-group">
            <label for="badge">Badge Nummer</label>
            <input type="number" class="form-control" id="badge" v-model="form.badge">
          </div>
          <div class="form-group">
            <label for="password">Wachtwoord</label>
            <input type="password" class="form-control" id="password" v-model="form.password">
          </div>
          <div>
            <button type="submit" class="btn" v-bind:class="{
              'btn-primary': canSendForm,
              'btn-light': !canSendForm
            }">
              Sign in
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

</template>

<script lang="ts">
import {mapActions} from 'vuex';
import {Component, Vue} from 'vue-property-decorator';
import {LoginCredentials} from '@/store/auth';

@Component({
  methods: {
    ...mapActions({
      signIn: 'auth/signIn'
    })
  }
})
export default class Login extends Vue {
  public form: LoginCredentials = {
    badge: '',
    password: ''
  };

  public hasError = false;

  signIn!: (form: LoginCredentials) => void;

  get canSendForm() {
    return this.form.badge !== '' && this.form.password !== '';
  }

  async submit() {
    try {
      await this.signIn({
        badge: this.form.badge,
        password: this.form.password
      });

      await this.$router.replace({name: 'cash-register-system'});
    } catch (e) {
      this.form.password = '';
      this.form.badge = '';

      this.hasError = true;
    }
  }
}

</script>

<style lang="scss">
  @import "~bootstrap";
  @import '~bootstrap-vue/src/index.scss';

  .full-height {
    min-height: 100vh;
  }
</style>
