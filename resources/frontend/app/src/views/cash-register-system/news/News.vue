<template>
 <loader>
   <router-link class="btn btn-primary" :to="{name: 'new-news'}">Nieuwe nieuws item aanmaken</router-link>
   <div class="card m-3">
     <div class="card-header">
       Nieuws items
     </div>
     <div class="card-body">
       <news-table v-if="paginatedNewsItems" :news-items="paginatedNewsItems.data" @newsItemClick="newsItemClick"/>
     </div>
     <div class="card-footer" v-if="paginatedNewsItems">
       <button v-if="paginatedNewsItems.links.prev" type="button" class="btn btn-primary" @click="previousPage">
         vorige
       </button>
       <button v-if="paginatedNewsItems.links.next" type="button" class="btn btn-primary" @click="nextPage">
         volgende
       </button>
       <small>
         Huidige pagina: {{paginatedNewsItems.meta.current_page}}
       </small>
       <small>
         Laatste pagina: {{paginatedNewsItems.meta.last_page}}
       </small>
     </div>
   </div>
 </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import store from '@/store';
import axios from 'axios';
import {Paginated} from '@/types/paginated';
import NewsTable from '@/components/cash-register-system/news/NewsTable.vue';
import {News as NewsType} from '@/types/news';

@Component({
  components: {
    Loader, NewsTable
  },
  async beforeRouteEnter(to, _, next) {
    await store.commit('network/SET_LOADING', true);

    const response = await axios.get<Paginated<NewsType>>(`/api/news?page=${to.query.page}`);
    const paginatedNews = response.data;

    next(async(vm: News) => {
      vm.paginatedNewsItems = paginatedNews;
      await vm.$store.commit('network/SET_LOADING', false);
    });
  }
})
export default class News extends Vue {
  public paginatedNewsItems: Paginated<NewsType> | null = null;

  async newsItemClick(newsItem: NewsType) {
    await this.$router.push({
      name: 'edit-news',
      params: {
        id: newsItem.id.toString()
      }
    });
  }

  async nextPage() {
    await this.$store.commit('network/SET_LOADING', true);
    if (!this.paginatedNewsItems || !this.paginatedNewsItems.links.next) {
      return;
    }

    const response = await axios.get<Paginated<NewsType>>(this.paginatedNewsItems.links.next);
    this.paginatedNewsItems = response.data;

    await this.$router.push({name: 'news-kassa', query: {page: this.paginatedNewsItems.meta.current_page.toString()}});
    await this.$store.commit('network/SET_LOADING', false);
  }

  async previousPage() {
    await this.$store.commit('network/SET_LOADING', true);
    if (!this.paginatedNewsItems || !this.paginatedNewsItems.links.prev) {
      return;
    }

    const response = await axios.get<Paginated<NewsType>>(this.paginatedNewsItems.links.prev);
    this.paginatedNewsItems = response.data;

    await this.$router.push({name: 'news-kassa', query: {page: this.paginatedNewsItems.meta.current_page.toString()}});
    await this.$store.commit('network/SET_LOADING', false);
  }
};
</script>
