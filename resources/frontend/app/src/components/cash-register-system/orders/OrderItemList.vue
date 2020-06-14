<template>
  <table class="table">
    <tr>
      <th v-if="showDate">
        Datum
      </th>
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
      <th>
        Opmerking
      </th>
    </tr>
    <tr v-for="(item, index) in items" :key="index">
      <td v-if="showDate">
        {{transformToDutchDate(item.paidAt)}}
      </td>
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
      <td>
        {{item.comment}}
      </td>
    </tr>
  </table>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {OrderedMenuItemWithDate} from '@/types/menu-item';
import {transformToDutchDate} from '@/utils/date';

  @Component({
    methods: {
      transformToDutchDate
    }
  })
export default class OrderItemList extends Vue {
    @Prop(Array) public readonly items!: OrderedMenuItemWithDate[];
    @Prop({
      required: false,
      type: Boolean
    }) public readonly showDate!: boolean;
};
</script>

<style scoped>
  td {
    word-wrap: break-word;
    word-break: break-all;
    table-layout: fixed;
  }
</style>
