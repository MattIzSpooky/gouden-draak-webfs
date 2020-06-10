<template>
  <div>
    <div>
      <h3>{{name}}</h3>
    </div>
    <table>
      <tr v-for="item in menuItems" :key="item.id">
        <td>
          {{item.menuNumber}}{{item.addition}}
          <template v-if="item.menuNumber && item.addition">
            .
          </template>
        </td>
        <td>
          {{item.dish.name}}
        </td>
        <td>
          € {{item.dish.price.toFixed(2)}}
        </td>
      </tr>
    </table>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {MenuItem} from '@/types/menu-item';

  @Component
export default class MenuItemTable extends Vue {
    @Prop(String) public readonly name!: string;
    @Prop(Array) public readonly menuItems!: MenuItem[];
};
</script>

<style scoped lang="scss">
table {
  width: 75%;
  text-align: center;

  td {
    width: 25%;
  }
}
</style>
