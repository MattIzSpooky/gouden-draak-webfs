<template>
  <table class="table">
    <tr v-for="item in orderedMenuItems" :key="item.id">
      <td>
        {{item.menu_number}}{{item.addition}}.
      </td>
      <td>
        {{item.dish.name}}
      </td>
      <td>
        € {{item.dish.price}}
      </td>
      <td>
        <input type="number" class="form-control" min="0" v-model.number="item.amount">
      </td>
    </tr>
  </table>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue, Watch} from 'vue-property-decorator';
import {OrderedMenuItem} from '@/types/menu-item';

@Component
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

      const price = this.orderedMenuItems.reduce((accumulator: number, item) => {
        let totalDishValue = 0;
        for (let i = 0; i < item.amount; i++) {
          totalDishValue = totalDishValue + item.dish.price;
        }
        return accumulator + totalDishValue;
      }, 0);

      this.emitTotalValue(price);
    }
};
</script>
