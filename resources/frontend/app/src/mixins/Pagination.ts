import Vue from 'vue';
import Component from 'vue-class-component';
import {Paginated} from '@/types/paginated';
import axios from 'axios';

@Component
export class PaginationMixin<T> extends Vue {
  public paginatedData: Paginated<T> | null = null;

  async nextPage() {
    await this.$store.commit('network/SET_LOADING', true);
    if (!this.paginatedData || !this.paginatedData.links.next) {
      return;
    }

    const response = await axios.get<Paginated<T>>(this.paginatedData.links.next);
    this.paginatedData = response.data;

    await this.$router.push({name: 'news-kassa', query: {page: this.paginatedData.meta.current_page.toString()}});
    await this.$store.commit('network/SET_LOADING', false);
  }

  async previousPage() {
    await this.$store.commit('network/SET_LOADING', true);
    if (!this.paginatedData || !this.paginatedData.links.prev) {
      return;
    }

    const response = await axios.get<Paginated<T>>(this.paginatedData.links.prev);
    this.paginatedData = response.data;

    await this.$router.push({name: 'news-kassa', query: {page: this.paginatedData.meta.current_page.toString()}});
    await this.$store.commit('network/SET_LOADING', false);
  }
}
