<template>
  <table class="table">
    <template v-for="item in orderedMenuItems">
      <tr :key="item.id">
        <td>
          {{item.menuNumber}}{{item.addition}}<template v-if="item.menuNumber">.</template>
        </td>
        <td>
          {{item.dish.name}}
        </td>
        <td>
          € {{item.dish.price.toFixed(2)}}
        </td>
        <td>
          <input type="number" class="form-control" min="0" v-model.number="item.amount">
        </td>
        <td>
          <b-button v-b-toggle="'collapse-' + item.id">Beschrijving</b-button>
        </td>
      </tr>
      <tr :key="item.id + '-collapse'">
        <td colspan="5">
          <b-collapse :id="'collapse-' + item.id">
            <textarea rows="3" class="w-100" v-model="item.comment"></textarea>
          </b-collapse>
        </td>
      </tr>
    </template>
  </table>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue, Watch} from 'vue-property-decorator';
import {OrderedMenuItem} from '@/types/menu-item';
import {calculateTotalPriceOfOrderedMenuItems} from '@/utils/reducers';
import {BButton, BCollapse} from 'bootstrap-vue';

@Component({
  components: {
    BCollapse,
    BButton
  }
})
export default class OrderTable extends Vue {
    @Prop(Array) public readonly orderedMenuItems!: OrderedMenuItem[];

    @Emit('totalValue')
    emitTotalValue(value: number) {
      return value;
    }

    @Watch('orderedMenuItems', { deep: true })
    onOrderedMenuItemsChanged() {
      const toBeRemovedIndex = this.orderedMenuItems.findIndex(i => i.amount <= 0);

      if (toBeRemovedIndex !== -1) {
        this.orderedMenuItems.splice(toBeRemovedIndex, 1);
      }

      const price = this.orderedMenuItems.reduce(calculateTotalPriceOfOrderedMenuItems, 0);

      this.emitTotalValue(price);
    }
};
</script>
