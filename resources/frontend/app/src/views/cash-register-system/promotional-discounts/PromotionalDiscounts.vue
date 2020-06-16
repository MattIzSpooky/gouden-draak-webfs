<template>
<loader>
  <router-link class="btn btn-primary ml-3" :to="{name: 'new-promotional-discount'}">Nieuwe actie aanmaken</router-link>
  <div class="card m-3">
    <div class="card-header">
      Acties
    </div>
    <div class="card-body">
      <promotions-table :promotions="discounts" @onRowClick="onPromotionalDiscountClick"/>
    </div>
  </div>
</loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import Loader from '@/components/cash-register-system/common/Loader.vue';
import store from '@/store';
import axios from 'axios';
import {ApiResource} from '@/types/api';
import {PromotionalDiscount} from '@/types/promotional-discount';
import PromotionsTable from '@/components/cash-register-system/promotional-discounts/PromotionsTable.vue';

  @Component({
    components: {
      Loader, PromotionsTable
    },
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);

      const response = await axios.get<ApiResource<PromotionalDiscount[]>>('/api/promotions/discounts');
      const discounts = response.data;

      next(async(vm: PromotionalDiscounts) => {
        vm.discounts = discounts.data;

        await vm.$store.commit('network/SET_LOADING', false);
      });
    }
  })
export default class PromotionalDiscounts extends Vue {
  public discounts: PromotionalDiscount[] = [];

  async onPromotionalDiscountClick(discount: PromotionalDiscount) {
    await this.$router.push({
      name: 'edit-promotional-discount',
      params: {
        id: discount.id.toString()
      }
    });
  }
};
</script>

<style scoped>

</style>
