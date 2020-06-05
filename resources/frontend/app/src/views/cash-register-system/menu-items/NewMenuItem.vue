<template>
  <div>
    <div class="card m-3">
      <div class="card-header">
        Nieuw gerecht aanmaken
      </div>
      <div class="card-body">
        <dish-form :dish-types="dishTypes" :menu-number-additions="menuAdditions" :error="error" @onSubmit="submit"/>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import axios from 'axios';
import DishForm from '@/components/cash-register-system/DishForm.vue';
import {ApiResource, ApiValidationError} from '@/types/api';
import ErrorAlert from '@/components/cash-register-system/ErrorAlert.vue';
import router from '@/router';
import {MenuItemRequest} from '@/types/menu-item';

@Component({
  components: {ErrorAlert, DishForm},
  async beforeRouteEnter(to, _, next) {
    const requests = await Promise.all([
      axios.get<ApiResource<DishType[]>>('/api/dish/types'),
      axios.get<ApiResource<string[]>>('api/dish/additions')
    ]);

    const dishTypeResponse = requests[0];
    const menuNumberAdditionResponse = requests[1];

    next((vm: NewMenuItem) => {
      vm.dishTypes = dishTypeResponse.data.data;
      vm.menuAdditions = menuNumberAdditionResponse.data.data;
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
