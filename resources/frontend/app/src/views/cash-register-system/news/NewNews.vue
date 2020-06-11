<template>
  <loader>
    <div class="card m-3">
      <div class="card-header">
        Nieuw menu item
      </div>
      <div class="card-body">
        <news-form @onSubmit="submit"/>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import {ApiValidationError} from '@/types/api';
import MenuItemForm from '@/components/cash-register-system/menu-items/MenuItemForm.vue';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import NewsForm from '@/components/cash-register-system/news/NewsForm.vue';
import {NewsRequest} from '@/types/news';
import axios from 'axios';
import router from '@/router';

@Component({
  components: {NewsForm, MenuItemForm, Loader}
})
export default class NewMenuItem extends Vue {
    public dishTypes: DishType[] = [];
    public menuAdditions: string[] = [];
    public error: ApiValidationError<NewsRequest> | null = null;

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
};
</script>

<style scoped>

</style>
