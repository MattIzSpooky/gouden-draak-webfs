<template>
  <cash-register-page>
    <div class="row">
      <div class="col-md-7">
        <menu-item-table name="Soep" :menuItems="menuItemsSoup" @menuItemClick="onMenuItemClick"/>
      </div>
      <div class="col-md-4">
        <h3>Bestelling</h3>
        <div>
          <order-table @totalValue="onTotalValueChange" :orderedMenuItems="orderedItems"/>
        </div>
      </div>
    </div>
  </cash-register-page>
</template>

<script lang="ts">
import axios from 'axios';
import {Component, Vue} from 'vue-property-decorator';
import CashRegisterPage from '@/components/cash-register-system/CashRegisterPage.vue';
import {MenuItem, MenuItemApiCollection, OrderedMenuItem} from '@/types/menu-item';
import {DishTypeName} from '@/types/dish';
import OrderTable from '@/components/cash-register-system/OrderTable.vue';
import MenuItemTable from '@/components/cash-register-system/MenuItemTable.vue';

@Component({
  components: {
    OrderTable,
    CashRegisterPage,
    MenuItemTable
  }
})
export default class Index extends Vue {
    private menuItemsSoup: MenuItem[] = [];
    private orderedItems: OrderedMenuItem[] = [];

    async created() {
      const response = await axios.get<MenuItemApiCollection>('/api/menu');
      const menuItems: MenuItem[] = response.data.data;

      this.menuItemsSoup = menuItems.filter(item => item.dish.dish_type.type === DishTypeName.SOUP);
    }

    onTotalValueChange(value: number) {
      console.log(value);
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
