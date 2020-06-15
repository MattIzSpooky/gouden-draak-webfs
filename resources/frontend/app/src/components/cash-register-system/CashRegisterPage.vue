<template>
  <main>
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-brand>
        <img class="logo" src="../../assets/images/goodpay.png" alt="logo">
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav class="ml-auto mr-auto">
          <cash-register-links>
            <li class="nav-item">
              <button type="button" class="btn btn-link nav-link" @click="clickSignOut">Log uit</button>
            </li>
          </cash-register-links>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <section class="container-fluid">
      <slot></slot>
    </section>
  </main>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {mapActions} from 'vuex';
import CashRegisterLinks from '@/components/cash-register-system/CashRegisterLinks.vue';
import {
  BCollapse,
  BDropdownItem,
  BNavbar,
  BNavbarBrand,
  BNavbarNav,
  BNavbarToggle,
  BNavItemDropdown
} from 'bootstrap-vue';

  @Component({
    components: {
      CashRegisterLinks,
      BNavItemDropdown,
      BDropdownItem,
      BNavbar,
      BNavbarBrand,
      BNavbarToggle,
      BCollapse,
      BNavbarNav
    },
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
