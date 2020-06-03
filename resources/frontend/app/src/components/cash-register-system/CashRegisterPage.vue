<template>
  <div>
    <section>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand">
          <img class="logo" src="../../assets/images/goodpay.png" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <CashRegisterLinks>
            <li class="nav-item">
              <button type="button" class="btn btn-link nav-link" @click="clickSignOut">Log uit</button>
            </li>
          </CashRegisterLinks>
        </div>
      </nav>
    </section>
    <section class="container-fluid">
      <slot></slot>
    </section>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {mapActions} from 'vuex';
import CashRegisterLinks from '@/components/cash-register-system/CashRegisterLinks.vue';

  @Component({
    components: {CashRegisterLinks},
    methods: {
      ...mapActions({
        signOut: 'auth/signOut'
      })
    }
  })
export default class CashRegisterPage extends Vue {
    signOut!: () => void;

    async clickSignOut() {
      this.signOut();
      await this.$router.replace({name: 'login'});
    }
};
</script>

<style scoped lang="scss">
  .logo {
    height: 80px;
  }
</style>
