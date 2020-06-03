<template>
  <div>
    <div class="card m-3">
      <div class="card-header">
        Nieuw gerecht aanmaken
      </div>
      <div class="card-body">
        <create-dish-form :dish-types="dishTypes" :menu-number-additions="menuAdditions" @onSubmit="submit">
          <error-alert :error="error" v-if="hasErrors"/>
        </create-dish-form>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import axios from 'axios';
import CreateDishForm from '@/components/cash-register-system/CreateDishForm.vue';
import {NewMenuItemType} from '@/types/menu-item';
import {ApiResource, ApiValidationError} from '@/types/api';
import ErrorAlert from '@/components/cash-register-system/ErrorAlert.vue';
import router from '@/router';

@Component({
  components: {ErrorAlert, CreateDishForm}
})
export default class NewMenuItem extends Vue {
  public dishTypes: DishType[] = [];
  public menuAdditions: string[] = [];
  public error: ApiValidationError<NewMenuItemType> | null = null;

  get hasErrors() {
    return this.error && this.error.message !== '';
  }

  async beforeCreate() {
    const dishTypeResponse = await axios.get<ApiResource<DishType[]>>('/api/dish/types');

    this.dishTypes.push(...dishTypeResponse.data.data);

    const menuNumberAdditionResponse = await axios.get<ApiResource<string[]>>('api/dish/additions');
    this.menuAdditions.push(...menuNumberAdditionResponse.data.data);
  }

  public async submit(formData: NewMenuItemType) {
    try {
      await axios.post('/api/menu', formData);
      await router.push({name: 'dishes'});
    } catch (e) {
      const errorObject = e.response.data as ApiValidationError<NewMenuItemType>;
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
