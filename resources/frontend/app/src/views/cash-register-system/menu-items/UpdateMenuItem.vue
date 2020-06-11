<template>
  <loader>
    <div class="card m-3">
      <div class="card-header">
        Menu item bewerken.
      </div>
      <div class="card-body">
        <menu-item-form :dish-types="dishTypes" :menu-number-additions="menuAdditions" :form-data="menuItem" :error="error" @onSubmit="onSubmit">
          <button type="button" class="btn btn-danger ml-2" @click="deleteMenuitem">Verwijderen</button>
        </menu-item-form>
      </div>
    </div>
  </loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import axios from 'axios';
import {MenuItem, MenuItemRequest} from '@/types/menu-item';
import {ApiResource, ApiValidationError} from '@/types/api';
import router from '@/router';
import store from '@/store';
import MenuItemForm from '@/components/cash-register-system/menu-items/MenuItemForm.vue';
import Loader from '@/components/cash-register-system/common/Loader.vue';

  @Component({
    components: {MenuItemForm, Loader},
    async beforeRouteEnter(to, _, next) {
      await store.commit('network/SET_LOADING', true);

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

        await vm.$store.commit('network/SET_LOADING', false);
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
      const wantToSave = await this.$bvModal.msgBoxConfirm('Weet u zeker dat u op wilt slaan?');
      if (!wantToSave) {
        return;
      }
      try {
        await axios.put(`/api/menu/${this.$route.params.id}`, menuItemRequest);

        await this.$bvModal.msgBoxOk('Het menu item is opgeslagen');

        await router.push({name: 'dishes'});
      } catch (e) {
        const errorObject = e.response.data as ApiValidationError<MenuItemRequest>;
        this.error = {
          message: errorObject.message,
          errors: errorObject.errors
        };
      }
    }

    async deleteMenuitem() {
      const wantToDelete = await this.$bvModal.msgBoxConfirm('Weet u zeker dat u het menu item wilt verwijderen?');
      if (!wantToDelete) {
        return;
      }

      await axios.delete(`/api/menu/${this.$route.params.id}`);
      await this.$bvModal.msgBoxOk('Het menu item is verwijderd.');
      await router.push({name: 'dishes'});
    }
};
</script>
