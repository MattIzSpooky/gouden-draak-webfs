<template>
  <loader>
    <div class="card m-3">
      <div class="card-header">
        Nieuwe actie
      </div>
      <div class="card-body">
        <promotion-form @onSubmit="submit" :dishes="dishes" :error="error"/>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import store from '@/store';
import axios from 'axios';
import {ApiResource, ApiValidationError} from '@/types/api';
import {Dish} from '@/types/dish';
import {PromotionalDiscountRequest} from '@/types/promotional-discount';
import PromotionForm from '@/components/cash-register-system/promotional-discounts/PromotionForm.vue';
import router from '@/router';

  @Component({
    components: {
      PromotionForm,
      Loader
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);

      const response = await axios.get<ApiResource<Dish[]>>('/api/dish');
      const discounts = response.data;

      next(async (vm: NewDiscount) => {
        vm.dishes = discounts.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class NewDiscount extends Vue {
    public dishes: Dish[] = [];
    public error: ApiValidationError<PromotionalDiscountRequest> | null = null;

    async submit(formData: PromotionalDiscountRequest) {
      const wantToSave = await this.$bvModal.msgBoxConfirm('Weet u zeker dat u op wilt slaan?');
      if (!wantToSave) {
        return;
      }
      try {
        await axios.post('/api/promotions/discounts', formData);
        await this.$bvModal.msgBoxConfirm('De actie is opgeslagen');
        await router.push({name: 'promotional-discounts'});
      } catch (e) {
        await this.$bvModal.msgBoxConfirm('Er is iets misgegaan tijdens het opslaan.');
        const errorObject = e.response.data as ApiValidationError<PromotionalDiscountRequest>;
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
