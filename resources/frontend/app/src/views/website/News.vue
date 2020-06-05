<template>
  <dragon-page v-if="paginatedNews">
    <tr v-for="news in paginatedNews.data" :key="news.title" style="padding-top:50px">
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
        <button v-if="paginatedNews.links.prev" @click="previousPage">
          vorige
        </button>
        <button v-if="paginatedNews.links.next" @click="nextPage">
          volgende
        </button>
      </td>
    </tr>
  </dragon-page>
</template>

<script lang="ts">
import axios from 'axios';
import DragonPage from '@/components/website/DragonPage.vue';
import {Component, Vue} from 'vue-property-decorator';
import {Paginated} from '@/types/paginated';

@Component({
  components: {
    DragonPage
  },
  async beforeRouteEnter(to, _, next) {
    const response = await axios.get<Paginated<News>>(`/api/news?page=${this.$route.query.page}`);
    const paginatedNews = response.data;

    next((vm: News) => {
      vm.paginatedNews = paginatedNews;
    });
  }
})
export default class News extends Vue {
    private paginatedNews: Paginated<News> | null = null;

    transformToDutchDate(ISOString: string) {
      return new Date(ISOString).toLocaleDateString('nl');
    }

    async nextPage() {
      if (!this.paginatedNews || !this.paginatedNews.links.next) {
        return;
      }

      const response = await axios.get<Paginated<News>>(this.paginatedNews.links.next);
      this.paginatedNews = response.data;

      await this.$router.push({name: 'news', query: {page: this.paginatedNews.meta.current_page.toString()}});
    }

    async previousPage() {
      if (!this.paginatedNews || !this.paginatedNews.links.prev) {
        return;
      }

      const response = await axios.get<Paginated<News>>(this.paginatedNews.links.prev);
      this.paginatedNews = response.data;

      await this.$router.push({name: 'news', query: {page: this.paginatedNews.meta.current_page.toString()}});
    }
}
</script>
