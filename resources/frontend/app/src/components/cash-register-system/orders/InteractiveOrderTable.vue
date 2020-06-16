<template>
  <table class="table w-100">
    <template v-for="item in orderedMenuItems">
      <tr :key="item.id">
        <td>
          {{item.menuNumber}}{{item.addition}}<template v-if="item.menuNumber">.</template>
        </td>
        <td>
          {{item.dish.name}}
        </td>
        <td>
          &euro; {{item.dish.price.toFixed(2)}}
        </td>
        <td>
          <input type="number" class="form-control" min="0" v-model.number="item.amount">
        </td>
        <td v-if="canComment">
          <b-button v-b-toggle="'collapse-' + item.id">Beschrijving</b-button>
        </td>
      </tr>
      <tr :key="item.id + '-collapse'" v-if="canComment">
        <td colspan="5">
          <b-collapse :id="'collapse-' + item.id">
            <textarea rows="3" class="w-100 form-control" v-model="item.comment"></textarea>
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
    @Prop({
      type: Boolean,
      default: false
    }) public readonly canComment!: boolean;

    @Emit('totalValue')
    @Watch('orderedMenuItems', {deep: true, immediate: true})
    onOrderedMenuItemsChanged() {
      const toBeRemovedIndex = this.orderedMenuItems.findIndex(i => i.amount <= 0);

      if (toBeRemovedIndex !== -1) {
        this.orderedMenuItems.splice(toBeRemovedIndex, 1);
      }

      return this.orderedMenuItems.reduce(calculateTotalPriceOfOrderedMenuItems, 0);
    }
};
</script>

<style lang="scss" scoped>
  td {
    width: 10%;

    &:nth-child(2) {
      width: 20%;
    }

    &:last-of-type {
      width: 10%
    }
  }
</style>
