<template>
  <form action="#" @submit.prevent="emitForm">
    <div class="form-group">
      <label for="dishName">Gerecht naam</label>
      <input type="text" class="form-control" id="dishName">
    </div>
    <div class="form-group">
      <label for="dishPrice">Prijs gerecht</label>
      <input type="number" min="0" class="form-control" id="dishPrice">
    </div>
    <div class="form-group">
      <label for="dishDescription">Beschrijving</label>
      <textarea class="form-control" id="dishDescription" rows="3"></textarea>
    </div>
    <div class="form-group">
      <label for="dishType">Gerecht soort</label>
      <select class="form-control" id="dishType">
        <option v-for="dishtype in dishTypes" :key="dishtype.id" :value="dishtype.id">{{dishtype.type}}</option>
      </select>
    </div>
    <div class="form-group">
      <label for="menuNumber">Menu number</label>
      <input type="number" min="0" class="form-control" id="menuNumber">
    </div>
    <div class="form-group">
      <label for="menuNumberAddition">Gerecht soort</label>
      <select class="form-control" id="menuNumberAddition">
        <option v-for="addition in menuNumberAdditions" :key="addition" :value="addition">{{addition}}</option>
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
  @Prop(Array) public menuNumberAdditions!: string[];

  @Emit('onSubmit')
  emitForm() {
    return 'test';
  }
};
</script>

<style scoped>

</style>
