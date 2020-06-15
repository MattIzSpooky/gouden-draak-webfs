<template>
  <div>
    <div class="alert alert-danger" role="alert" v-if="error && error.message">
      {{error.message}}
    </div>
    <form action="#" @submit.prevent="emitForm">
      <form-input name="Gerecht naam" id="dishName" v-model="formData.name" :error="error"/>
      <form-input name="Prijs gerecht" type="number" id="dishPrice" min="0" step="0.01" v-model.number="formData.price" :error="error"/>
      <form-textarea name="Beschrijving" id="dishDescription" v-model="formData.description" :error="error"/>
      <form-select name="Gerecht soort" id="dishType" v-model.number="formData.dishTypeId" :dropdown-values="dishTypes" :error="error">
        <template v-slot:default>
          <option v-for="type in dishTypes" :key="type.id" :value="type.id">{{type.type}}</option>
        </template>
      </form-select>
      <form-input name="Menu number" type="number" id="menuNumber" min="0" v-model.number="formData.menuNumber" :error="error">
        <button type="button" class="btn btn-primary btn-sm mt-1" @click="clearMenuNumber">Leeg maken</button>
      </form-input>
      <form-select name="Menu toevoeging" id="menuNumberAddition" v-model.number="formData.addition" :dropdown-values="menuNumberAdditions" :error="error">
        <template v-slot:default>
          <option v-for="addition in menuNumberAdditions" :key="addition" :value="addition">{{addition}}</option>
        </template>
        <template v-slot:action>
          <button type="button" class="btn btn-primary btn-sm mt-1" @click="clearMenuNumberAdditions">Leeg maken</button>
        </template>
      </form-select>
      <button type="submit" class="btn btn-primary">Opslaan</button>
      <slot></slot>
    </form>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {DishType} from '@/types/dish';
import {MenuItemRequest} from '@/types/menu-item';
import {ApiValidationError} from '@/types/api';
import FormInput from '@/components/cash-register-system/common/forms/FormInput.vue';
import FormTextarea from '@/components/cash-register-system/common/forms/FormTextarea.vue';
import FormSelect from '@/components/cash-register-system/common/forms/FormSelect.vue';
@Component({
  components: {FormSelect, FormTextarea, FormInput}
})
export default class DishForm extends Vue {
    @Prop({
      required: true,
      type: Array
    }) public dishTypes!: DishType[];

    @Prop({
      required: true,
      type: Array
    }) public menuNumberAdditions!: string[];

    @Prop({
      type: Object
    }) public readonly error!: ApiValidationError<MenuItemRequest>;

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

    get formDataOut(): MenuItemRequest {
      return {
        ...this.formData,
        price: +this.formData.price.toFixed(2)
      };
    }

    @Emit('onSubmit')
    emitForm(): MenuItemRequest {
      return this.formDataOut;
    }

    @Emit('onDelete')
    emitDeleteMenuItem(): MenuItemRequest {
      return this.formDataOut;
    }

    clearMenuNumber() {
      this.formData.menuNumber = null;
    }

    clearMenuNumberAdditions() {
      this.formData.addition = null;
    }
};
</script>
