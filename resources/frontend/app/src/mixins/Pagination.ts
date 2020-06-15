import Vue from 'vue';
import Component from 'vue-class-component';
import {Paginated} from '@/types/paginated';
import axios from 'axios';

@Component
export class PaginationMixin<T> extends Vue {
  public paginatedData: Paginated<T> | null = null;
  public routeName = '';

  created() {
    if (this.routeName === '') {
      throw new Error('No route name was set. Cannot paginate.');
    }
  }

  public async nextPage() {
    return this.loaderHOF(async () => {
      if (!this.paginatedData) {
        return;
      }
      await this.paginate(this.paginatedData.links.next);
    });
  }

  public async previousPage() {
    return this.loaderHOF(async () => {
      if (!this.paginatedData) {
        return;
      }
      await this.paginate(this.paginatedData.links.prev);
    });
  }

  private async paginate(link: string | null) {
    if (!link) {
      return;
    }

    const response = await axios.get<Paginated<T>>(link);
    this.paginatedData = response.data;

    await this.$router.push({name: this.routeName, query: {page: this.paginatedData.meta.current_page.toString()}});
  }

  private async loaderHOF(func: Function) {
    await this.$store.commit('network/SET_LOADING', true);
    await func();
    await this.$store.commit('network/SET_LOADING', false);
  }
}
