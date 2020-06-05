<template>
  <div>
    <router-link class="btn btn-primary" :to="{name: 'new-dish'}">Nieuwe menu item aanmaken</router-link>
    <div class="card m-3">
      <div class="card-header">
        Menu
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item p-0" v-for="itemObject in menuItems" :key="itemObject.type">
          <menu-item-table
            :name="itemObject.type"
            :menuItems="itemObject.items"
            click-action-text="Bewerken"
            @menuItemClick="onItemClick"
          />
        </li>
      </ul>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import axios from 'axios';
import {MenuItem, MenuItemsGroupedWithType} from '@/types/menu-item';
import MenuItemTable from '@/components/cash-register-system/MenuItemTable.vue';
import {ApiResource} from '@/types/api';

  @Component({
    components: {MenuItemTable},
    async beforeRouteEnter(to, _, next) {
      const response = await axios.get<ApiResource<MenuItemsGroupedWithType[]>>('/api/menu');
      const menuItems = response.data.data;

      next((vm: Dishes) => {
        vm.menuItems = menuItems;
      });
    }
  })
export default class Dishes extends Vue {
    private menuItems: MenuItemsGroupedWithType[] = [];

    async onItemClick(menuItem: MenuItem) {
      await this.$router.push({
        name: 'edit-dish',
        params: {
          id: menuItem.id.toString()
        }
      });
    }
};
</script>
