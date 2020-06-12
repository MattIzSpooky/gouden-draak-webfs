<template>
  <loader>
    <div class="row">
      <div class="col-md-7">
        <div class="card m-3">
          <div class="card-header">
            Menu
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-0" v-for="(itemObject, index) in menuItems" :key="index">
              <menu-item-table :name="itemObject.type" :menuItems="itemObject.items" @menuItemClick="onMenuItemClick"/>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card mb-1">
          <div class="card-header">
            Bestelling
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-0">
              <order-table @totalValue="onTotalValueChange" :orderedMenuItems="orderedItems"/>
            </li>
            <li class="list-group-item p-0">
              <div class="row p-3">
                <div class="col-md-8">
                  <div class="d-flex h-100 justify-content-center">
                    <div class="my-auto w-100">
                      <div class="d-flex justify-content-around">
                        <h3>
                          Totaal:
                        </h3>
                        <h3>
                          € {{totalPrice}}
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
            </li>
          </ul>
        </div>
        <menu-item-search @onSearch="onSearch">
          <button type="button" role="button" class="btn btn-primary ml-4" @click="onSearchReset">Reset</button>
        </menu-item-search>
      </div>
    </div>
    <b-modal ref="dialog">
      {{modalContent}}
    </b-modal>
  </loader>
</template>

<script lang="ts">
import axios from 'axios';
import {Component, Vue} from 'vue-property-decorator';
import CashRegisterPage from '@/components/cash-register-system/CashRegisterPage.vue';
import {MenuItem, MenuItemsGroupedWithType, OrderedMenuItem} from '@/types/menu-item';
import store from '@/store/index';

import {BModal} from 'bootstrap-vue';
import {NewOrderRequest} from '@/types/order';
import {ApiResource} from '@/types/api';
import OrderTable from '@/components/cash-register-system/orders/InteractiveOrderTable.vue';
import MenuItemTable from '@/components/cash-register-system/menu-items/MenuItemTable.vue';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import MenuItemSearch from '@/components/cash-register-system/menu-items/MenuItemSearch.vue';

  @Component({
    components: {
      MenuItemSearch,
      OrderTable,
      CashRegisterPage,
      MenuItemTable,
      BModal,
      Loader
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);
      const response = await axios.get<ApiResource<MenuItemsGroupedWithType[]>>('/api/menu');

      next(async (vm: CashRegister) => {
        vm.menuItems = response.data.data;
        vm.originalResults = vm.menuItems;
        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class CashRegister extends Vue {
    private menuItems: MenuItemsGroupedWithType[] = [];
    private orderedItems: OrderedMenuItem[] = [];
    private totalPrice = 0;
    private modalContent = '';

    private originalResults: MenuItemsGroupedWithType[] = [];

    $refs!: {
      dialog: BModal;
    }

    onTotalValueChange(value: number) {
      this.totalPrice = (Math.round(value * 100) / 100);
    }

    async pay() {
      const items = this.orderedItems.map(o => ({
        id: o.id,
        amount: o.amount
      }));

      try {
        await axios.post<NewOrderRequest>('/api/orders', {
          items
        });
        this.modalContent = 'Verkoop succesvol!';
        this.onClickDelete();
      } catch {
        this.modalContent = 'Er is iets misgegaan!';
      }

      this.$refs.dialog.show();
    }

    onSearchReset() {
      this.menuItems = [];
      this.menuItems.push(...this.originalResults);
    }

    onClickDelete() {
      this.orderedItems.splice(0, this.orderedItems.length);
    }

    onSearch(menuItems: MenuItemsGroupedWithType[]) {
      this.menuItems = [];
      this.menuItems.push(...menuItems);
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
        amount: 1
      });
    }
};
</script>
