<template>
  <div>
    <div class="row d-flex justify-content-center">
      <h3>{{name}}</h3>
    </div>
    <table class="table">
      <tr v-for="item in menuItems" :key="item.id">
        <td>
          {{item.menu_number}}{{item.addition}}.
        </td>
        <td>
          {{item.dish.name}}
        </td>
        <td>
          € {{item.dish.price}}
        </td>
        <td v-if="hasClickAction">
          <button type="button" class="btn btn-primary" @click="onMenuItemClick(item)">
            Toevoegen
          </button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {MenuItem} from '@/types/menu-item';

@Component
export default class MenuItemTable extends Vue {
    @Prop(String) public readonly name!: string;
    @Prop(Array) public readonly menuItems!: MenuItem[];
    @Prop({
      default: true,
      type: Boolean
    }) public readonly hasClickAction!: boolean;

    @Emit('menuItemClick')
    onMenuItemClick(menuItem: MenuItem) {
      return menuItem;
    }
};
</script>

<style scoped lang="scss">
  td {
    text-align: center;
  }
</style>
