<template>
  <form action="#" @submit.prevent="emitForm">
    <div class="form-group">
      <label for="dishType">Gerecht soort</label>
      <select class="form-control" id="dishType">
        <option v-for="dishtype in dishTypes" :key="dishtype.id" :value="dishtype.id">{{dishtype.type}}</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Product aanmaken</button>
  </form>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';

@Component
export default class CreateDishForm extends Vue {
  @Prop(Array) public dishTypes!: DishType[];

  @Emit('onSubmit')
  emitForm() {
    return 'test';
  }
};
</script>

<style scoped>

</style>
