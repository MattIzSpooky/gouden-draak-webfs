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
    <tr v-for="item in promotions" :key="item.id">
      <td>
        {{item.title}}
      </td>
      <td>
        €{{item.price.toFixed(2)}}
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
}
</script>

<style scoped>

</style>
