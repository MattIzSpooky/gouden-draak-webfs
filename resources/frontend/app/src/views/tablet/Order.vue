<template>
<div>
  Maak een order aan
</div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import Loader from '../../components/cash-register-system/common/Loader.vue';
import store from '../../store';
import axios from 'axios';
import {ApiResource} from '@/types/api';
import {MenuItem} from '@/types/menu-item';

  @Component({
    components: {
      Loader
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);
      const response = await axios.get<ApiResource<MenuItem[]>>('/api/menu');

      const menuItems = response.data;

      next(async (vm: Table) => {
        vm.menu = menuItems.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class Table extends Vue {
    public menu: MenuItem[] = [];
};
</script>

<style scoped>

</style>
