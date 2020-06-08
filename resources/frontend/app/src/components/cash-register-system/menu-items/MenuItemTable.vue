<template>
  <div>
    <div class="row d-flex justify-content-center">
      <h3>{{name}}</h3>
    </div>
    <table class="table">
      <tr v-for="item in menuItems" :key="item.id" :class="{'table-danger': item.deletedAt}">
        <td>
          {{item.menuNumber}}{{item.addition}}.
        </td>
        <td>
          {{item.dish.name}}
        </td>
        <td>
          € {{item.dish.price}}
        </td>
        <td>
          <button v-if="!item.deletedAt && hasItemClickListener" type="button" class="btn btn-primary" @click="onMenuItemClick(item)">
            {{clickActionText}}
          </button>
          <button v-if="item.deletedAt" type="button" class="btn btn-success" @click="onMenuItemRestore(item)">
            Herstellen
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
      default: 'Toevoegen',
      type: String
    }) public readonly clickActionText!: string;

    get hasItemClickListener() {
      return !!this.$listeners.menuItemClick;
    }

    @Emit('menuItemClick')
    onMenuItemClick(menuItem: MenuItem) {
      return menuItem;
    }

    @Emit('menuItemRestore')
    onMenuItemRestore(menuItem: MenuItem) {
      return menuItem;
    }
};
</script>

<style scoped lang="scss">
  td {
    text-align: center;
  }
</style>
