<template>
    <tr style="padding-top:50px">
      <td width="50px">
      </td>
      <td align="center" style='border:1px solid black;background:floralwhite'>
        <menu-item-table v-for="menuItem in menuItems" :key="menuItem.type" :name="menuItem.type" :menuItems="menuItem.items"/>
      </td>
    </tr>
</template>

<script lang="ts">
import DragonPage from '@/components/website/DragonPage.vue';
import {Component, Vue} from 'vue-property-decorator';
import axios from 'axios';
import {ApiResource} from '@/types/api';
import {MenuItemsGroupedWithType} from '@/types/menu-item';
import MenuItemTable from '@/components/website/MenuItemTable.vue';

@Component({
  components: {
    DragonPage, MenuItemTable
  },
  async beforeRouteEnter(to, _, next) {
    const response = await axios.get<ApiResource<MenuItemsGroupedWithType[]>>('/api/menu');

    next((vm: Menu) => {
      vm.menuItems = response.data.data;
    });
  }
})
export default class Menu extends Vue {
  public menuItems: MenuItemsGroupedWithType[] = [];
}
</script>
