<template>
  <div>
    <div>
      <h3>{{name}}</h3>
    </div>
    <table>
      <tr v-for="item in menuItems" :key="item.id" @click="rowClick(item)">
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
import {Component, Prop, Vue} from 'vue-property-decorator';
import {MenuItem} from '@/types/menu-item';
import Heart from '@/components/website/Heart.vue';
@Component({
  components: {Heart}
})
export default class MenuItemTable extends Vue {
    @Prop(String) public readonly name!: string;
    @Prop(Array) public readonly menuItems!: MenuItem[];

    public favorites: number[] = [];

    rowClick(menuItem: MenuItem) {
      if (this.isFavorite(menuItem)) {
        const index = this.favorites.indexOf(menuItem.id);
        if (index === -1) {
          return;
        }

        this.favorites.splice(index, 1);
      } else {
        this.favorites.push(menuItem.id);
      }

      this.saveFavorites();
    }

    isFavorite(menuItem: MenuItem) {
      return this.favorites.some(e => e === menuItem.id);
    }

    created() {
      this.restoreFavorites();
    }

    restoreFavorites() {
      const result = localStorage.getItem('favorites');
      if (!result) {
        return;
      }

      this.favorites = JSON.parse(result);
    }

    saveFavorites() {
      localStorage.setItem('favorites', JSON.stringify(this.favorites));
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
