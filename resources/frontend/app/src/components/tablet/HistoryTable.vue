<template>
  <table class="table">
    <thead class="thead-dark">
    <tr>
      <th>
        Datum en tijd
      </th>
      <th>
        Aantal gerechten
      </th>
      <th>
        Totale prijs
      </th>
    </tr>
    </thead>
    <template v-for="(order, index) in orders">
      <tr :key="order.id" v-b-toggle="'collapse-' + order.id">
        <td>
          {{transformToDutchDate(order.createdAt)}} {{transFormToDutchTime(order.createdAt)}}
        </td>
        <td>
          {{countOrderItems(order)}}
        </td>
        <td>
          &euro;  {{calculateTotalPriceForOrder(order).toFixed(2)}}
        </td>
      </tr>
      <tr :key="index">
        <td colspan="3">
          <b-collapse :id="'collapse-' + order.id.toString()">
            <table class="w-100">
              <tr v-for="item in order.items" :key="order.id + item.id">
                <td>
                  {{item.dish.name}}
                </td>
                <td>
                  {{item.amount}}x
                </td>
              </tr>
            </table>
            <b-button @click="onReorderClick(order)">Opnieuw bestellen</b-button>
          </b-collapse>
        </td>
      </tr>
    </template>
  </table>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {Order} from '@/types/order';
import {calculateOrderItemsOfOrder, calculateTotalPriceOfOrderedMenuItems} from '@/utils/reducers';
import {transformToDutchDate, transFormToDutchTime} from '@/utils/date';
import {BButton, BCollapse} from 'bootstrap-vue';

  @Component({
    components: {
      BCollapse,
      BButton
    },
    methods: {
      transformToDutchDate,
      transFormToDutchTime
    }
  })
export default class Table extends Vue {
    @Prop({
      type: Array,
      required: true
    }) public orders!: Order[];

    calculateTotalPriceForOrder(order: Order) {
      return order.items.reduce(calculateTotalPriceOfOrderedMenuItems, 0);
    }

    countOrderItems(order: Order) {
      return order.items.reduce(calculateOrderItemsOfOrder, 0);
    }

    @Emit('clickReOrder')
    onReorderClick(order: Order) {
      return order;
    }
};
</script>

<style scoped>

</style>
