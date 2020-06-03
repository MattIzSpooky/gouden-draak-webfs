<template>
  <div>
    <div>
      <slot></slot>
    </div>
    <form action="#" @submit.prevent="emitForm">
      <div class="form-group">
        <label for="dishName">Gerecht naam</label>
        <input type="text" required v-model="formData.name" class="form-control" id="dishName">
      </div>
      <div class="form-group">
        <label for="dishPrice">Prijs gerecht</label>
        <input type="number" required v-model.number="formData.price" min="0" step='0.01' class="form-control" id="dishPrice">
      </div>
      <div class="form-group">
        <label for="dishDescription">Beschrijving</label>
        <textarea class="form-control" required v-model="formData.description" id="dishDescription" rows="3"></textarea>
      </div>
      <div class="form-group">
        <label for="dishType">Gerecht soort</label>
        <select class="form-control" required id="dishType" v-model="formData.dishTypeId">
          <option v-for="dishtype in dishTypes" :key="dishtype.id" :value="dishtype.id">{{dishtype.type}}</option>
        </select>
      </div>
      <div class="form-group">
        <label for="menuNumber">Menu number</label>
        <input v-model="formData.menuNumber" type="number" min="0" class="form-control" id="menuNumber">
        <button type="button" class="btn btn-primary btn-sm mt-1" @click="clearMenuNumber">Leeg maken</button>
      </div>
      <div class="form-group">
        <label for="menuNumberAddition">Menu toevoeging</label>
        <select v-model="formData.addition" class="form-control" id="menuNumberAddition">
          <option v-for="addition in menuNumberAdditions" :key="addition" :value="addition">{{addition}}</option>
        </select>
        <button type="button" class="btn btn-primary btn-sm mt-1" @click="clearMenuNumberAdditions">Leeg maken</button>
      </div>
      <button type="submit" class="btn btn-primary">Product aanmaken</button>
    </form>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import {NewMenuItemType} from '@/types/menu-item';

@Component
export default class CreateDishForm extends Vue {
  @Prop(Array) public dishTypes!: DishType[];
  @Prop(Array) public menuNumberAdditions!: string[];

  private formData: NewMenuItemType = {
    name: '',
    price: 0.00,
    description: '',
    dishTypeId: 0,
    addition: null,
    menuNumber: null
  };

  $refs!: {
    menuNumberAddition: HTMLSelectElement;
    menuNumber: HTMLInputElement;
  };

  @Emit('onSubmit')
  emitForm(): NewMenuItemType {
    return {
      ...this.formData,
      price: +this.formData.price.toFixed(2)
    };
  }

  clearMenuNumber() {
    this.formData.menuNumber = null;
  }

  clearMenuNumberAdditions() {
    this.formData.addition = null;
  }
};
</script>
