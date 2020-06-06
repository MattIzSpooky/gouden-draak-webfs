<template>
  <loader>
    <div class="card m-3">
      <div class="card-header">
        Nieuw gerecht aanmaken
      </div>
      <div class="card-body">
        <menu-item-form :dish-types="dishTypes" :menu-number-additions="menuAdditions" :error="error" @onSubmit="submit"/>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import axios from 'axios';
import {ApiResource, ApiValidationError} from '@/types/api';
import router from '@/router';
import {MenuItemRequest} from '@/types/menu-item';
import store from '@/store';
import MenuItemForm from '@/components/cash-register-system/menu-items/MenuItemForm.vue';
import Loader from '@/components/cash-register-system/common/Loader.vue';

@Component({
  components: {MenuItemForm, Loader},
  async beforeRouteEnter(to, _, next) {
    await store.dispatch('network/toggleLoad');

    const requests = await Promise.all([
      axios.get<ApiResource<DishType[]>>('/api/dish/types'),
      axios.get<ApiResource<string[]>>('api/dish/additions')
    ]);

    const dishTypeResponse = requests[0];
    const menuNumberAdditionResponse = requests[1];

    next(async (vm: NewMenuItem) => {
      vm.dishTypes = dishTypeResponse.data.data;
      vm.menuAdditions = menuNumberAdditionResponse.data.data;

      await vm.$store.dispatch('network/toggleLoad');
    });
  }
})
export default class NewMenuItem extends Vue {
  public dishTypes: DishType[] = [];
  public menuAdditions: string[] = [];
  public error: ApiValidationError<MenuItemRequest> | null = null;

  public async submit(formData: MenuItemRequest) {
    try {
      await axios.post('/api/menu', formData);
      await router.push({name: 'dishes'});
    } catch (e) {
      const errorObject = e.response.data as ApiValidationError<MenuItemRequest>;
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
