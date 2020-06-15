<template>
 <loader>
   <router-link class="btn btn-primary" :to="{name: 'new-news'}">Nieuwe nieuws item aanmaken</router-link>
   <div class="card m-3">
     <div class="card-header">
       Nieuws items
     </div>
     <div class="card-body">
       <news-table v-if="paginatedData" :news-items="paginatedData.data" @newsItemClick="newsItemClick"/>
     </div>
     <div class="card-footer" v-if="paginatedData">
       <button v-if="paginatedData.links.prev" type="button" class="btn btn-primary" @click="previousPage">
         vorige
       </button>
       <button v-if="paginatedData.links.next" type="button" class="btn btn-primary" @click="nextPage">
         volgende
       </button>
       <small>
         Huidige pagina: {{paginatedData.meta.current_page}}
       </small>
       <small>
         Laatste pagina: {{paginatedData.meta.last_page}}
       </small>
     </div>
   </div>
 </loader>
</template>

<script lang="ts">
import {Component} from 'vue-property-decorator';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import store from '@/store';
import axios from 'axios';
import {Paginated} from '@/types/paginated';
import NewsTable from '@/components/cash-register-system/news/NewsTable.vue';
import {News as NewsType} from '@/types/news';
import {mixins} from 'vue-class-component';
import {PaginationMixin} from '@/mixins/Pagination';

@Component({
  components: {
    Loader, NewsTable
  },
  async beforeRouteEnter(to, _, next) {
    await store.commit('network/SET_LOADING', true);

    const response = await axios.get<Paginated<NewsType>>(`/api/news?page=${to.query.page}`);
    const paginatedNews = response.data;

    next(async(vm: News) => {
      vm.paginatedData = paginatedNews;
      await vm.$store.commit('network/SET_LOADING', false);
    });
  }
})
export default class News extends mixins<PaginationMixin<NewsType>>(PaginationMixin) {
  public readonly routeName = 'news-kassa';

  async newsItemClick(newsItem: NewsType) {
    await this.$router.push({
      name: 'edit-news',
      params: {
        id: newsItem.id.toString()
      }
    });
  }
};
</script>
