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
            @menuItemRestore="onItemRestore"
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
      await store.commit('network/SET_LOADING', true);

      const response = await axios.get<ApiResource<MenuItemsGroupedWithType[]>>('api/menu/with-trashed');
      const menuItems = response.data.data;

      next(async(vm: Dishes) => {
        vm.menuItems = menuItems;

        await vm.$store.commit('network/SET_LOADING', false);
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

    async onItemRestore(menuItem: MenuItem) {
      const wantsToRestore = await this.$bvModal.msgBoxConfirm('Weet u zeker dat u het menu item terug wilt brengen?');
      if (!wantsToRestore) {
        return;
      }

      await axios.post(`/api/menu/restore/${menuItem.id}`);
      await this.$bvModal.msgBoxOk('Het menu item is terug gebracht.');
      menuItem.deletedAt = null;
    }
};
</script>
