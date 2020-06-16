<template>
<loader>
  <div class="row">
    <div class="col">
      <b-card
        title="Geschiedenis"
        class="mt-2"
      >
        <b-card-body class="p-0">
         <history-table @clickReOrder="onReOrder" :orders="history" v-if="history.length !== 0"/>
          <h2 v-else>Deze tafel heeft geen bestellingen.</h2>
        </b-card-body>
      </b-card>
    </div>
    <div class="col">
      <b-card
        title="Bestellen"
        class="mt-2"
      >
        <b-button :to="{name: 'new-order', params: {id: $route.params.id}}">Klik hier om te bestellen</b-button>
      </b-card>
    </div>
  </div>
</loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import Loader from '../../components/cash-register-system/common/Loader.vue';
import store from '../../store';
import axios from 'axios';
import {ApiResource} from '@/types/api';
import {Order} from '@/types/order';
import {BButton, BCard, BCardBody} from 'bootstrap-vue';
import HistoryTable from '@/components/tablet/HistoryTable.vue';

  @Component({
    components: {
      Loader,
      BCard,
      BCardBody,
      BButton,
      HistoryTable
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

    async onReOrder(order: Order) {
      const wantsToReOrder = await this.$bvModal.msgBoxConfirm('Weet u zeker dat u dit opnieuw wilt bestellen?');
      if (!wantsToReOrder) {
        return;
      }

      try {
        this.$store.commit('network/SET_LOADING', true);
        const response = await axios.post<ApiResource<Order>>('api/table/orders', {
          tableId: this.$route.params.id,
          items: order.items.map(i => ({
            id: i.id,
            amount: i.amount
          })),
          paidAt: null
        });
        await this.$bvModal.msgBoxOk('Het order is opnieuw besteld.');
        this.history.unshift(response.data.data);
      } catch (e) {
        await this.$bvModal.msgBoxOk(e.response.data.errors.tableId[0]);
      } finally {
        this.$store.commit('network/SET_LOADING', false);
      }
    }
};
</script>

<style scoped>

</style>
