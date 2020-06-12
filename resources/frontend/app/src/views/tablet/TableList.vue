<template>
  <loader>
    <div v-for="table in tables" :key="table.id">{{table.name}}</div>
  </loader>
</template>

<script lang="ts">
import axios from 'axios';
import {Component, Vue} from 'vue-property-decorator';
import store from '@/store/index';
import {ApiResource} from '@/types/api';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import {Table} from '@/types/table';

  @Component({
    components: {
      Loader
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);
      const response = await axios.get<ApiResource<Table[]>>('/api/table');

      const tables = response.data;

      next(async (vm: TableList) => {
        vm.tables = tables.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class TableList extends Vue {
    public tables: Table[] = [];
};
</script>

<style scoped>

</style>
