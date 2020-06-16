<template>
  <table class="table">
    <tr>
      <th>
        Titel
      </th>
      <th>
        Prijs
      </th>
      <th>
        Van
      </th>
      <th>
        Tot
      </th>
      <th>
        Actie
      </th>
    </tr>
    <tr v-for="item in promotions" :key="item.id" :class="{'table-success': checkIfDateIsBeforeToday(item.validFrom, item.validTill)}">
      <td>
        {{item.title}}
      </td>
      <td>
        &euro; {{item.price.toFixed(2)}}
      </td>
      <td>
        {{transformToDutchDate(item.validFrom)}}
      </td>
      <td>
        {{transformToDutchDate(item.validTill)}}
      </td>
      <td>
        <button type="button" role="button" class="btn btn-primary" @click="onRowClick(item)">Bewerken</button>
      </td>
    </tr>
  </table>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {PromotionalDiscount} from '@/types/promotional-discount';
import {transformToDutchDate} from '@/utils/date';

  @Component({
    methods: {
      transformToDutchDate
    }
  })
export default class PromotionsTable extends Vue {
    @Prop(Array) public readonly promotions!: PromotionalDiscount[];

    @Emit('onRowClick')
    onRowClick(discount: PromotionalDiscount) {
      return discount;
    }

    checkIfDateIsBeforeToday(dateFrom: string, dateTo: string) {
      const today = new Date();

      const from = new Date(dateFrom);
      from.setDate(from.getDate() - 1);
      const to = new Date(dateTo);
      to.setDate(to.getDate() + 1);

      return from <= today && today <= to;
    }
}
</script>

<style scoped>

</style>
