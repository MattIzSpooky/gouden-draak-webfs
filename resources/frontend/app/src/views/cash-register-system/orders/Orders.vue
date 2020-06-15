<template>
  <loader>
    <div class="card m-3" v-if="paginatedData">
      <div class="card-header">
        Orders
      </div>
      <div class="card-body">
        <order-list :orders="paginatedData.data" @rowClick="onOrderClick"/>
      </div>
      <div class="card-footer">
        <button v-if="paginatedData.links.prev" type="button" class="btn btn-primary" @click="previousPage">
          vorige
        </button>
        <button v-if="paginatedData.links.next" type="button" class="btn btn-primary" @click="nextPage">
          volgende
        </button>
        <small>
          Huidige pagina: {{paginatedData.meta.current_page}}
        </small>
        <small>
          Laatste pagina: {{paginatedData.meta.last_page}}
        </small>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component} from 'vue-property-decorator';
import axios from 'axios';
import store from '@/store';
import MenuItemTable from '@/components/cash-register-system/menu-items/MenuItemTable.vue';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import {Paginated} from '@/types/paginated';
import {Order} from '@/types/order';
import OrderList from '@/components/cash-register-system/orders/OrderList.vue';
import {mixins} from 'vue-class-component';
import {PaginationMixin} from '@/mixins/Pagination';

  @Component({
    components: {OrderList, MenuItemTable, Loader},
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);

      const response = await axios.get<Paginated<Order>>('api/orders');
      const paginatedOrders = response.data;

      next(async(vm: Orders) => {
        vm.paginatedData = paginatedOrders;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class Orders extends mixins<PaginationMixin<Order>>(PaginationMixin) {
    public readonly routeName = 'orders';

    async onOrderClick(order: Order) {
      await this.$router.push({
        name: 'order-detail',
        params: {
          id: order.id.toString()
        }
      });
    }
};
</script>

<style scoped>

</style>
