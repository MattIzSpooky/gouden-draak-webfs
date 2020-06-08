<template>
  <table class="table">
    <tr>
      <th>
        Titel
      </th>
      <th>
        Datum
      </th>
      <th>
        Actie
      </th>
    </tr>
    <tr v-for="item in newsItems" :key="item.id">
      <td>
       {{item.title}}
      </td>
      <td>
        {{transformToDutchDate(item.createdAt)}}
      </td>
      <td>
        <button v-if="hasItemClickListener" type="button" class="btn btn-primary" @click="newsItemsClick(item)">
           Bewerken
        </button>
      </td>
    </tr>
  </table>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {News} from '@/types/news';

  @Component
export default class NewsTable extends Vue {
    @Prop(Array) public readonly newsItems!: News[];

    get hasItemClickListener() {
      return !!this.$listeners.newsItemClick;
    }

    transformToDutchDate(ISOString: string) {
      return new Date(ISOString).toLocaleDateString('nl');
    }

    @Emit('newsItemClick')
    newsItemsClick(newsItem: News) {
      return newsItem;
    }
};
</script>

<style scoped>

</style>
