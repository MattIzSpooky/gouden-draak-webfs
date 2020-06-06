<template>
  <loader>
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
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import axios from 'axios';
import {MenuItem, MenuItemsGroupedWithType} from '@/types/menu-item';
import {ApiResource} from '@/types/api';
import store from '@/store';
import MenuItemTable from '@/components/cash-register-system/menu-items/MenuItemTable.vue';
import Loader from '@/components/cash-register-system/common/Loader.vue';

  @Component({
    components: {MenuItemTable, Loader},
    async beforeRouteEnter(to, _, next) {
      await store.dispatch('network/toggleLoad');

      const response = await axios.get<ApiResource<MenuItemsGroupedWithType[]>>('/api/menu');
      const menuItems = response.data.data;

      next(async(vm: Dishes) => {
        vm.menuItems = menuItems;

        await vm.$store.dispatch('network/toggleLoad');
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
