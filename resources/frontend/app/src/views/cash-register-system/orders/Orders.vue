<template>
  <loader>
    <div class="card m-3" v-if="paginatedOrders">
      <div class="card-header">
        Orders
      </div>
      <div class="card-body">
        <order-list :orders="paginatedOrders.data" @rowClick="onOrderClick"/>
      </div>
      <div class="card-footer">
        <button v-if="paginatedOrders.links.prev" type="button" class="btn btn-primary" @click="previousPage">
          vorige
        </button>
        <button v-if="paginatedOrders.links.next" type="button" class="btn btn-primary" @click="nextPage">
          volgende
        </button>
        <small>
          Huidige pagina: {{paginatedOrders.meta.current_page}}
        </small>
        <small>
          Laatste pagina: {{paginatedOrders.meta.last_page}}
        </small>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import axios from 'axios';
import store from '@/store';
import MenuItemTable from '@/components/cash-register-system/menu-items/MenuItemTable.vue';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import {Paginated} from '@/types/paginated';
import {Order} from '@/types/order';
import OrderList from '@/components/cash-register-system/orders/OrderList.vue';

  @Component({
    components: {OrderList, MenuItemTable, Loader},
    async beforeRouteEnter(to, _, next) {
      await store.dispatch('network/toggleLoad');

      const response = await axios.get<Paginated<Order>>('api/orders');
      const paginatedOrders = response.data;

      next(async(vm: Orders) => {
        vm.paginatedOrders = paginatedOrders;

        await vm.$store.dispatch('network/toggleLoad');
      });
    }
  })
export default class Orders extends Vue {
    public paginatedOrders: Paginated<Order> | null = null;

    async onOrderClick(order: Order) {
      await this.$router.push({
        name: 'order-detail',
        params: {
          id: order.id.toString()
        }
      });
    }

    async nextPage() {
      await this.$store.dispatch('network/toggleLoad');
      if (!this.paginatedOrders || !this.paginatedOrders.links.next) {
        return;
      }

      const response = await axios.get<Paginated<Order>>(this.paginatedOrders.links.next);
      this.paginatedOrders = response.data;

      await this.$router.push({name: 'news-kassa', query: {page: this.paginatedOrders.meta.current_page.toString()}});
      await this.$store.dispatch('network/toggleLoad');
    }

    async previousPage() {
      await this.$store.dispatch('network/toggleLoad');
      if (!this.paginatedOrders || !this.paginatedOrders.links.prev) {
        return;
      }

      const response = await axios.get<Paginated<Order>>(this.paginatedOrders.links.prev);
      this.paginatedOrders = response.data;

      await this.$router.push({name: 'news-kassa', query: {page: this.paginatedOrders.meta.current_page.toString()}});
      await this.$store.dispatch('network/toggleLoad');
    }
};
</script>

<style scoped>

</style>
