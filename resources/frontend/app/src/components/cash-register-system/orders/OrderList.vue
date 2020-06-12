<template>
  <table class="table">
    <tr>
      <th>
        Datum
      </th>
       <th>
        Tafel
      </th>
      <th>
        Betaald?
      </th>
      <th>
        Bekijk bestelling
      </th>
    </tr>
    <tr v-for="order in orders" :key="order.id">
      <td>
        {{transformToDutchDate(order.createdAt)}}
      </td>
       <td>
        {{order.table.name}}
      </td>
      <td :class="{'table-danger': !order.paidAt}">
        {{order.paidAt ? 'Ja' : 'Nee'}}
      </td>
      <td>
        <button role="button" class="btn btn-primary" @click="onRowRlick(order)">Bekijk</button>
      </td>
    </tr>
  </table>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {Order} from '@/types/order';
import {transformToDutchDate} from '@/utils/date';

@Component({
  methods: {
    transformToDutchDate
  }
})
export default class OrderList extends Vue {
    @Prop(Array) public readonly orders!: Order[];

    @Emit('rowClick')
    onRowRlick(order: Order) {
      return order;
    }
};
</script>

<style scoped>

</style>
