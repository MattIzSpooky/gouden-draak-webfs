<template>
  <main>
      <b-navbar toggleable="lg" type="dark" variant="info">
        <b-navbar-brand>
          <img class="logo" src="../../assets/images/goodpay.png" alt="logo">
        </b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav class="ml-auto mr-auto">
            <tablet-links>
              <b-nav-item-dropdown :text="getTable().name" v-if="getTable().id !== 0" right>
                <b-dropdown-item @click="routeBackToTable">Terug naar tafel</b-dropdown-item>
                <b-dropdown-item @click="resetTable()">Andere tafel kiezen</b-dropdown-item>
              </b-nav-item-dropdown>
            </tablet-links>
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
import TabletLinks from '@/components/tablet/TabletLinks.vue';
import {mapActions, mapGetters} from 'vuex';
import {
  BCollapse,
  BDropdownItem,
  BNavbar,
  BNavbarBrand,
  BNavbarNav,
  BNavbarToggle,
  BNavItemDropdown
} from 'bootstrap-vue';
import {Table} from '@/types/table';

  @Component({
    components: {
      TabletLinks,
      BNavItemDropdown,
      BDropdownItem,
      BNavbar,
      BNavbarBrand,
      BNavbarToggle,
      BCollapse,
      BNavbarNav
    },
    methods: {
      ...mapGetters({
        getTable: 'tablet/getTable'
      }),
      ...mapActions({
        resetTable: 'tablet/resetTable'
      })
    }
  })
export default class TabletPage extends Vue {
    getTable!: () => Table;

    async routeBackToTable() {
      if (this.$route.name === 'table') {
        return;
      }

      await this.$router.push({
        name: 'table',
        params: {
          id: this.getTable().id.toString()
        }
      });
    }

    beforeCreate() {
      this.$store.dispatch('tablet/restore');
    }
};
</script>

<style scoped lang="scss">
  .logo {
    height: 40px;
  }
</style>
