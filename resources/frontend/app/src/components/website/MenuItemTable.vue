<template>
  <div>
    <div>
      <h3>{{name}}</h3>
    </div>
    <table>
      <tr v-for="item in menuItems" :key="item.id" @click.stop="onRowClick(item)">
        <td>
          {{item.menuNumber}}{{item.addition}}<template v-if="item.menuNumber || item.addition">.</template>
        </td>
        <td>
          {{item.dish.name}}
          <small v-if="item.dish.description">
            ({{item.dish.description}})
          </small>
        </td>
        <td>
          € {{item.dish.price.toFixed(2)}}
        </td>
        <td>
          <heart v-if="isFavorite(item)"/>
        </td>
      </tr>
    </table>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {MenuItem} from '@/types/menu-item';
import Heart from '@/components/website/Heart.vue';
@Component({
  components: {Heart}
})
export default class MenuItemTable extends Vue {
    @Prop({
      required: true,
      type: String
    }) public readonly name!: string;

    @Prop({
      required: true,
      type: Array
    }) public readonly menuItems!: MenuItem[];

    @Prop({
      required: true,
      type: Array
    }) public readonly favorites!: number[];

    @Emit('onRowClick')
    public onRowClick(item: MenuItem) {
      return item;
    }

    isFavorite(menuItem: MenuItem) {
      return this.favorites.some(e => e === menuItem.id);
    }
};
</script>

<style scoped lang="scss">
table {
  width: 75%;
  text-align: center;
  td {
    width: 25%;
    padding: 10px;

    &:last-of-type {
      width: 10%;
    }
  }
}
</style>
