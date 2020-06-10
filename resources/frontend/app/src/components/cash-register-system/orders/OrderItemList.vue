<template>
  <table class="table">
    <tr>
      <th>
        Menu nummer
      </th>
      <th>
        Gerecht
      </th>
      <th>
        Hoeveel
      </th>
      <th>
        Prijs
      </th>
    </tr>
    <tr v-for="(item, index) in items" :key="index">
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
        {{item.amount}}
      </td>
      <td>
        € {{(item.dish.price * item.amount).toFixed(2)}}
      </td>
    </tr>
  </table>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {OrderedMenuItem} from '@/types/menu-item';

  @Component
export default class OrderItemList extends Vue {
    @Prop(Array) public readonly items!: OrderedMenuItem[];
};
</script>

<style scoped>

</style>
