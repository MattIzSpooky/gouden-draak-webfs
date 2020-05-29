<template>
  <cash-register-page>
    <div class="row">
      <div class="col-md-7">
        <div class="card m-3">
          <div class="card-header">
            Menu
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-0">
              <menu-item-table name="Soep" :menuItems="menuItemsSoup" @menuItemClick="onMenuItemClick"/>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card m-3">
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
      </div>
    </div>
    <b-modal ref="dialog">
      {{modalContent}}
    </b-modal>
  </cash-register-page>
</template>

<script lang="ts">
import axios from 'axios';
import {Component, Vue} from 'vue-property-decorator';
import CashRegisterPage from '@/components/cash-register-system/CashRegisterPage.vue';
import {MenuItem, MenuItemApiResource, OrderedMenuItem} from '@/types/menu-item';
import {DishTypeName} from '@/types/dish';
import OrderTable from '@/components/cash-register-system/OrderTable.vue';
import MenuItemTable from '@/components/cash-register-system/MenuItemTable.vue';

import {BModal} from 'bootstrap-vue';
import {OrderApiResource} from '@/types/order';

  @Component({
    components: {
      OrderTable,
      CashRegisterPage,
      MenuItemTable,
      BModal
    }
  })
export default class Index extends Vue {
    private menuItemsSoup: MenuItem[] = [];
    private orderedItems: OrderedMenuItem[] = [];
    private totalPrice = 0;
    private modalContent = '';

    $refs!: {
      dialog: BModal;
    }

    async created() {
      const response = await axios.get<MenuItemApiResource>('/api/menu');
      const menuItems: MenuItem[] = response.data.data;

      // FIXME: should come in right format from backend.
      this.menuItemsSoup = menuItems.filter(item => item.dish.dish_type.type === DishTypeName.SOUP);
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
        await axios.post<OrderApiResource>('/api/orders', {
          items
        });
        this.modalContent = 'Verkoop succesvol!';
        this.onClickDelete();
      } catch (e) {
        this.modalContent = 'Er is iets misgegaan!';
      }

      this.$refs.dialog.show();
    }

    onClickDelete() {
      this.orderedItems.splice(0, this.orderedItems.length);
    }

    onMenuItemClick(menuItem: MenuItem) {
      const item = this.orderedItems
        .find(i => i.menu_number === menuItem.menu_number && i.addition === menuItem.addition);

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
