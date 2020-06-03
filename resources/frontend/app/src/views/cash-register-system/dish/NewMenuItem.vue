<template>
  <div>
    <div class="card m-3">
      <div class="card-header">
        Nieuw gerecht aanmaken
      </div>
      <div class="card-body">
        <create-dish-form :dish-types="dishTypes" @onSubmit="submit"/>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {DishType, DishTypeResource} from '@/types/dish';
import axios from 'axios';
import CreateDishForm from '@/components/cash-register-system/CreateDishForm.vue';

@Component({
  components: {CreateDishForm}
})
export default class NewMenuItem extends Vue {
    public dishTypes: DishType[] = [];

    async beforeCreate() {
      const dishTypeResponse = await axios.get<DishTypeResource>('/api/dish/types');

      this.dishTypes.push(...dishTypeResponse.data.data);

      const menuNumberAdditionResponse = await axios.get<never[]>('api/dish/additions');
      console.log(menuNumberAdditionResponse.data);
    }

    public submit(formData: never) {
      console.log(formData);
    }
};
</script>

<style scoped>

</style>
