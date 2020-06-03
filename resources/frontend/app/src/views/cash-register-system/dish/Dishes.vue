<template>
  <div>
    <router-link class="btn btn-primary" :to="{name: 'new-dish'}">Nieuwe menu item aanmaken</router-link>
    <div class="card m-3">
      <div class="card-header">
        Menu
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item p-0" v-for="itemObject in menuItems" :key="itemObject.type">
          <menu-item-table :name="itemObject.type" :menuItems="itemObject.items" :has-click-action="false"/>
        </li>
      </ul>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import axios from 'axios';
import {MenuItemsGroupedWithType} from '@/types/menu-item';
import MenuItemTable from '@/components/cash-register-system/MenuItemTable.vue';
import {ApiResource} from '@/types/api';

  @Component({
    components: {MenuItemTable}
  })
export default class Dishes extends Vue {
    private menuItems: MenuItemsGroupedWithType[] = [];

    async created() {
      const response = await axios.get<ApiResource<MenuItemsGroupedWithType[]>>('/api/menu');
      this.menuItems = response.data.data;
    }
};
</script>

<style scoped>

</style>
