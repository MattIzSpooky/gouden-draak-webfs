<template>
  <loader>
    <div class="card m-3">
      <div class="card-header">
        Menu item bewerken.
      </div>
      <div class="card-body">
        <dish-form :dish-types="dishTypes" :menu-number-additions="menuAdditions" :form-data="menuItem" :error="error" @onSubmit="onSubmit"/>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import axios from 'axios';
import DishForm from '@/components/cash-register-system/DishForm.vue';
import {MenuItem, MenuItemRequest} from '@/types/menu-item';
import {ApiResource, ApiValidationError} from '@/types/api';
import ErrorAlert from '@/components/cash-register-system/ErrorAlert.vue';
import router from '@/router';
import Loader from '@/components/cash-register-system/Loader.vue';
import store from '@/store';

  @Component({
    components: {ErrorAlert, DishForm, Loader},
    async beforeRouteEnter(to, _, next) {
      await store.dispatch('network/toggleLoad');

      const requests = await Promise.all([
        axios.get<ApiResource<DishType[]>>('/api/dish/types'),
        axios.get<ApiResource<string[]>>('api/dish/additions'),
        axios.get<ApiResource<MenuItem>>(`/api/menu/${to.params.id}`)
      ]);

      const dishTypeResponse = requests[0];
      const menuNumberAdditionResponse = requests[1];
      const menuItemRequest = requests[2];

      next(async(vm: UpdateMenuItem) => {
        vm.dishTypes = dishTypeResponse.data.data;
        vm.menuAdditions = menuNumberAdditionResponse.data.data;
        const item = menuItemRequest.data.data;
        vm.menuItem = {
          name: item.dish.name,
          price: item.dish.price,
          description: item.dish.description,
          dishTypeId: item.dish.dishType.id,
          addition: item.addition,
          menuNumber: item.menuNumber
        };

        await vm.$store.dispatch('network/toggleLoad');
      });
    }
  })
export default class UpdateMenuItem extends Vue {
    public dishTypes: DishType[] = [];
    public menuAdditions: string[] = [];
    public menuItem: MenuItemRequest = {
      name: '',
      price: 0.00,
      description: '',
      dishTypeId: 0,
      addition: null,
      menuNumber: null
    };

    public error: ApiValidationError<MenuItemRequest> | null = null;

    async onSubmit(menuItemRequest: MenuItemRequest) {
      try {
        await axios.put(`/api/menu/${this.$route.params.id}`, menuItemRequest);
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
