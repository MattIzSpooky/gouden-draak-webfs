<template>
  <table v-if="paginatedData" style="width: 100%">
    <tr v-for="news in paginatedData.data" :key="news.title" style="padding-top:50px">
      <td align="center" style='border:1px solid black;background:floralwhite'><br>
        <h3>
          {{news.title}}
        </h3>
        <p>
          {{news.text}}
        </p>
        <small>
          {{transformToDutchDate(news.createdAt)}}
        </small>
      </td>
    </tr>
    <tr>
      <td align="center">
        <button v-if="paginatedData.links.prev" @click="previousPage">
          vorige
        </button>
        <button v-if="paginatedData.links.next" @click="nextPage">
          volgende
        </button>
      </td>
    </tr>
  </table>
</template>

<script lang="ts">
import axios from 'axios';
import DragonPage from '@/components/website/DragonPage.vue';
import {Component} from 'vue-property-decorator';
import {Paginated} from '@/types/paginated';
import {transformToDutchDate} from '@/utils/date';
import {mixins} from 'vue-class-component';
import {News as NewsType} from '@/types/news';
import {PaginationMixin} from '@/mixins/Pagination';

@Component({
  components: {
    DragonPage
  },
  methods: {
    transformToDutchDate
  },
  async beforeRouteEnter(to, _, next) {
    const response = await axios.get<Paginated<NewsType>>(`/api/news?page=${to.query.page}`);
    const paginatedNews = response.data;

    next((vm: News) => {
      vm.paginatedData = paginatedNews;
    });
  }
})
export default class News extends mixins<PaginationMixin<NewsType>>(PaginationMixin) {
  public readonly routeName = 'news';
}
</script>
