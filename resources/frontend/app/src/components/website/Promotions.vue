<template>
  <div>
    <h2>{{promotion.title}}</h2>
    De promotie geldt voor de volgende producten:

    <table>
      <tr v-for="item in promotion.dishes" :key="item.id">
        <td>
          {{item.name}}
          <template v-if="item.description">
            <br/>
            <small>({{item.description}})</small>
          </template>
        </td>
      </tr>
    </table>

    <p>
      {{promotion.text}}
    </p>

    <h3>Prijs: €{{promotion.price}}</h3>
    <p>Geldig van {{transformToDutchDate(promotion.validFrom)}} tot {{transformToDutchDate(promotion.validTill)}}</p>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {PromotionalDiscount} from '@/types/promotional-discount';
import {transformToDutchDate} from '@/utils/date';

@Component({
  methods: {
    transformToDutchDate
  }
})
export default class Promotions extends Vue {
    @Prop(Object) public readonly promotion!: PromotionalDiscount;
}
</script>

<style scoped>
  td {
    padding-bottom: 16px;
    text-align: center;
  }
</style>
