<template>
<div>
  {{$route.params.id }}
</div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import Loader from '../../components/cash-register-system/common/Loader.vue';
import store from '../../store';
import axios from 'axios';
import {ApiResource} from '@/types/api';
import {Order} from '@/types/order';

  @Component({
    components: {
      Loader
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);
      const response = await axios.get<ApiResource<Order[]>>(`/api/table/${to.params.id}/history`);

      const orders = response.data;

      next(async (vm: Table) => {
        vm.history = orders.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class Table extends Vue {
    public history: Order[] = [];
};
</script>

<style scoped>

</style>
