<template>
  <loader>
    <div class="row">
      <div class="col-md-7">
        <div class="card m-3">
          <div class="card-header">
            Menu
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-0" v-for="(itemObject, index) in menu" :key="index">
              <menu-item-table :name="itemObject.type" :menuItems="itemObject.items" @menuItemClick="onMenuItemClick"/>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card m-3 fixed card-order">
          <div class="card-header">
            Bestelling
          </div>
          <ul class="list-group list-group-flush order" v-if="orderedItems.length > 0">
            <li class="list-group-item p-0">
              <order-table @totalValue="onTotalValueChange" :orderedMenuItems="orderedItems"/>
            </li>
          </ul>
          <div v-else class="card-text p-3 text-center">
            <h3>De bestelling is leeg.</h3>
          </div>
          <div class="card-footer">
            <div class="row p-3">
              <div class="col-md-8">
                <div class="d-flex h-100 justify-content-center">
                  <div class="my-auto w-100">
                    <div class="d-flex justify-content-around">
                      <h3>
                        Totaal:
                      </h3>
                      <h3>
                        &euro; {{totalPrice.toFixed(2)}}
                      </h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-primary m-1" @click="pay">
                  Afrekenen
                </button>
                <button type="button" class="btn btn-primary m-1" @click="onClickDelete">
                  Verwijderen
                </button>
              </div>
            </div>
          </div>
        </div>
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
import {MenuItem, OrderedMenuItem} from '@/types/menu-item';
import {NewOrderRequest} from '@/types/order';
import OrderTable from '@/components/cash-register-system/orders/InteractiveOrderTable.vue';
import MenuItemTable from '@/components/cash-register-system/menu-items/MenuItemTable.vue';

  @Component({
    components: {
      Loader,
      OrderTable,
      MenuItemTable
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);
      const response = await axios.get<ApiResource<MenuItem[]>>('/api/menu');

      const menuItems = response.data;

      next(async (vm: Order) => {
        vm.menu = menuItems.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class Order extends Vue {
    public menu: MenuItem[] = [];
    private orderedItems: OrderedMenuItem[] = [];
    private totalPrice = 0;

    onTotalValueChange(value: number) {
      this.totalPrice = (Math.round(value * 100) / 100);
    }

    async pay() {
      if (this.orderedItems.length === 0) {
        return await this.$bvModal.msgBoxOk('U moet producten selecteren');
      }

      const items = this.orderedItems.map(o => ({
        id: o.id,
        amount: o.amount
      }));

      try {
        await axios.post<NewOrderRequest>('api/table/orders', {
          items,
          tableId: this.$route.params.id
        });
        await this.$bvModal.msgBoxOk('De bestelling is geplaatst.');
        this.onClickDelete();

        await this.$router.push({
          name: 'table',
          params: {
            id: this.$route.params.id
          }
        });
      } catch (e) {
        if (e.response.data.errors.tableId) {
          await this.$bvModal.msgBoxOk(e.response.data.errors.tableId[0]);
        } else {
          await this.$bvModal.msgBoxOk('Er is iets mis gegaan!');
        }
      }
    }

    onClickDelete() {
      this.orderedItems = [];
      this.totalPrice = 0;
    }

    onMenuItemClick(menuItem: MenuItem) {
      const item = this.orderedItems
        .find(i => i.menuNumber === menuItem.menuNumber && i.addition === menuItem.addition);

      if (item) {
        item.amount++;
        return;
      }

      this.orderedItems.push({
        ...menuItem,
        amount: 1,
        comment: null
      });
    }
};
</script>

<style scoped>
 .fixed {
   position: fixed;
 }

 .card-order {
   width: 40rem;
 }

 .order {
   max-height: 25rem;
   overflow-y: scroll;
 }
</style>
