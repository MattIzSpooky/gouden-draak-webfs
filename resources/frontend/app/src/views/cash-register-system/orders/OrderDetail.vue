<template>
  <loader>
    <div class="card">
      <div class="card-header">
        Order: {{order.id}}, {{order.table.name}}
      </div>
      <div class="card-body">
        <h5 class="card-title"> Order aangemaakt op {{transformToDutchDate(order.createdAt)}}</h5>
        <p class="card-text">
          € {{totalPrice.toFixed(2)}}
        </p>
        <p class="card-text">
          <order-item-list :show-comment="true" :items="order.items"/>
        </p>
        <div>
          Order betaald? {{order.paidAt ? 'Ja' : 'Nee'}}
        </div>
        <button type="button" role="button" v-if="!order.paidAt" @click="payOrder" class="btn btn-primary">Betaal order</button>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {ApiResource} from '@/types/api';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import axios from 'axios';
import store from '@/store';
import {Order} from '@/types/order';
import {transformToDutchDate} from '@/utils/date';
import OrderItemList from '@/components/cash-register-system/orders/OrderItemList.vue';
import {calculateTotalPriceOfOrderedMenuItems} from '@/utils/reducers';

  @Component({
    components: {OrderItemList, Loader},
    methods: {
      transformToDutchDate
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);

      const response = await axios.get<ApiResource<Order>>(`/api/orders/${to.params.id}`);
      const orderData = response.data;
      next(async(vm: OrderDetail) => {
        vm.order = orderData.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class OrderDetail extends Vue {
    public order: Order = {
      id: 1,
      items: [],
      table: { name: '', id: 0 },
      paidAt: null,
      createdAt: ''
    };

    get totalPrice() {
      return +(this.order.items.reduce(calculateTotalPriceOfOrderedMenuItems, 0) / 100 * 121).toFixed(2);
    }

    async payOrder() {
      const wantsToPay = await this.$bvModal.msgBoxConfirm('Weet u zeker dat u het order op betaald wilt zetten?');
      if (!wantsToPay) {
        return;
      }

      const response = await axios.put<ApiResource<Order>>(`/api/orders/${this.$route.params.id}`, {
        paidAt: new Date().toISOString(),
        tableId: this.order.table.id
      });

      this.order.paidAt = response.data.data.paidAt;
    }
};
</script>
