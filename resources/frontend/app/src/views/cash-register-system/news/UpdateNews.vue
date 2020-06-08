<template>
  <loader>
    <div class="card m-3">
      <div class="card-header">
        Nieuw menu item
      </div>
      <div class="card-body">
        <news-form @onSubmit="submit" :form-data="newsRequest">
          <button type="button" role="button" class="btn btn-danger ml-2" @click="deleteNewsItem">Verwijderen</button>
        </news-form>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {ApiResource, ApiValidationError} from '@/types/api';
import MenuItemForm from '@/components/cash-register-system/menu-items/MenuItemForm.vue';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import NewsForm from '@/components/cash-register-system/news/NewsForm.vue';
import {News, NewsRequest} from '@/types/news';
import axios from 'axios';
import router from '@/router';
import store from '@/store';

  @Component({
    components: {NewsForm, MenuItemForm, Loader},
    async beforeRouteEnter(to, _, next) {
      await store.dispatch('network/toggleLoad');

      const response = await axios.get<ApiResource<News>>(`/api/news/${to.params.id}`);
      const paginatedNews = response.data;

      next(async(vm: UpdateNews) => {
        vm.newsRequest = paginatedNews.data;

        await vm.$store.dispatch('network/toggleLoad');
      });
    }
  })
export default class UpdateNews extends Vue {
    public error: ApiValidationError<NewsRequest> | null = null;
    public newsRequest: NewsRequest = {
      title: '',
      text: ''
    };

    public async submit(formData: NewsRequest) {
      const wantToSave = await this.$bvModal.msgBoxConfirm('Weet u zeker dat u op wilt slaan?');
      if (!wantToSave) {
        return;
      }
      try {
        await axios.post('/api/news', formData);
        await this.$bvModal.msgBoxConfirm('Het nieuwsbericht is opgeslagen');
        await router.push({name: 'news-kassa'});
      } catch (e) {
        await this.$bvModal.msgBoxConfirm('Er is iets misgegaan tijdens het opslaan.');
        const errorObject = e.response.data as ApiValidationError<NewsRequest>;
        this.error = {
          message: errorObject.message,
          errors: errorObject.errors
        };
      }
    }

    public async deleteNewsItem() {
      const wantsToDelete = await this.$bvModal.msgBoxConfirm('Weet u zeker dat u het nieuws item wilt verwijderen?');
      if (!wantsToDelete) {
        return;
      }

      await axios.delete(`/api/news/${this.$route.params.id}`);
      await this.$bvModal.msgBoxOk('Het news item is verwijderd.');
      await router.push({name: 'news-kassa'});
    }
};
</script>

<style scoped>

</style>
