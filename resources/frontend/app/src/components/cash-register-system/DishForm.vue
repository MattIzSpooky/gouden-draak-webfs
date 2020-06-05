<template>
  <div>
    <div class="alert alert-danger" role="alert" v-if="error && error.message">
      {{error.message}}
    </div>
    <form action="#" @submit.prevent="emitForm">
      <div class="form-group">
        <label for="dishName">Gerecht naam</label>
        <input type="text" required v-model="formData.name" class="form-control" id="dishName"
               :class="{'is-invalid': error && error.errors.name}">
        <div v-if="error && error.errors.name">
          <p v-for="error in error.error.name" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="dishPrice">Prijs gerecht</label>
        <input type="number" required v-model.number="formData.price" min="0" step='0.01' class="form-control"
               :class="{'is-invalid': error && error.errors.price}" id="dishPrice">
        <div v-if="error && error.errors.price">
          <p v-for="error in error.error.price" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="dishDescription">Beschrijving</label>
        <textarea class="form-control" required v-model="formData.description" id="dishDescription" rows="3"
                  :class="{'is-invalid': error && error.errors.description}"></textarea>
        <div v-if="error && error.errors.description">
          <p v-for="error in error.error.description" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="dishType">Gerecht soort</label>
        <select class="form-control" required id="dishType" v-model="formData.dishTypeId"
                :class="{'is-invalid': error && error.errors.dishTypeId}">
          <option v-for="dishtype in dishTypes" :key="dishtype.id" :value="dishtype.id">{{dishtype.type}}</option>
        </select>
        <div v-if="error && error.errors.dishTypeId">
          <p v-for="error in error.error.dishTypeId" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="menuNumber">Menu number</label>
        <input v-model="formData.menuNumber" type="number" min="0" class="form-control" id="menuNumber"
               :class="{'is-invalid': error && error.errors.menuNumber}">
        <div v-if="error && error.errors.menuNumber">
          <p v-for="error in error.errors.menuNumber" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
        <button type="button" class="btn btn-primary btn-sm mt-1" @click="clearMenuNumber">Leeg maken</button>
      </div>
      <div class="form-group">
        <label for="menuNumberAddition">Menu toevoeging</label>
        <select v-model="formData.addition" class="form-control" id="menuNumberAddition"
                :class="{'is-invalid': error && error.errors.addition}">
          <option v-for="addition in menuNumberAdditions" :key="addition" :value="addition">{{addition}}</option>
        </select>
        <div v-if="error && error.errors.addition">
          <p v-for="error in error.error.addition" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
        <button type="button" class="btn btn-primary btn-sm mt-1" @click="clearMenuNumberAdditions">Leeg maken</button>
      </div>
      <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import {MenuItemRequest} from '@/types/menu-item';
import {ApiValidationError} from '@/types/api';

  @Component
export default class DishForm extends Vue {
    @Prop(Array) public dishTypes!: DishType[];
    @Prop(Array) public menuNumberAdditions!: string[];
    @Prop(Object) public readonly error!: ApiValidationError<MenuItemRequest>;
    @Prop({
      default: () => ({
        name: '',
        price: 0.00,
        description: '',
        dishTypeId: 0,
        addition: null,
        menuNumber: null
      }),
      type: Object
    }) private readonly formData!: MenuItemRequest;

    @Emit('onSubmit')
    emitForm(): MenuItemRequest {
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
