<template>
  <div>
    <div class="alert alert-danger" role="alert" v-if="error && error.message">
      {{error.message}}
    </div>
    <form action="#" @submit.prevent="onSubmit">
      <form-input name="Titel" id="title" v-model="formData.title" :error="error"/>
      <form-textarea name="Beschrijving" id="text" v-model="formData.text" :error="error"/>
      <form-input name="Prijs" type="number" id="price" min="0" step="0.01" v-model.number="formData.price" :error="error"/>
      <base-form-input id="from" name="Vanaf" :error="error">
        <template v-slot:input>
          <b-form-datepicker required id="from" v-model="formData.validFrom" :min="new Date()"
                             :date-format-options="datePickerOptions"
                             locale="nl"/>
        </template>
      </base-form-input>
      <base-form-input id="to" name="Tot" :error="error">
        <template v-slot:input>
          <b-form-datepicker id="to"
                             required
                             v-model="formData.validTill"
                             :date-format-options="datePickerOptions"
                             :min="formData.validFrom"
                             locale="nl"/>
        </template>
      </base-form-input>
            <div class="form-group">
              <label for="dishes">Gerechten</label>
              <select multiple v-model.number="formData.dishes" class="form-control" id="dishes"
                      :class="{'is-invalid': error && error.errors.dishes}">
                <option v-for="dish in dishes" :key="dish.id" :value="dish.id" :selected="isSelected(dish.id)">{{dish.name}}</option>
              </select>
              <div v-if="error && error.errors.dishes">
                <p v-for="error in error.error.dishes" :key="error" class="text-danger">
                  {{error}}
                </p>
              </div>
            </div>
      <button type="submit" :disabled="!checkForm" class="btn btn-primary">Opslaan</button>
      <slot></slot>
    </form>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {Dish} from '@/types/dish';
import {PromotionalDiscountRequest} from '@/types/promotional-discount';
import {BFormDatepicker} from 'bootstrap-vue';
import {ApiValidationError} from '@/types/api';
import FormInput from '@/components/cash-register-system/common/forms/FormInput.vue';
import FormTextarea from '@/components/cash-register-system/common/forms/FormTextarea.vue';
import BaseFormInput from '@/components/cash-register-system/common/forms/BaseFormInput.vue';
import FormSelect from '@/components/cash-register-system/common/forms/FormSelect.vue';

  @Component({
    components: {
      BaseFormInput,
      FormTextarea,
      FormInput,
      FormSelect,
      BFormDatepicker
    }
  })
export default class PromotionForm extends Vue {
    @Prop({
      required: true,
      type: Array
    }) public dishes!: Dish[];

    @Prop({
      default: () => ({
        price: 0,
        title: '',
        text: '',
        validFrom: '',
        validTill: '',
        dishes: []
      }),
      type: Object
    }) private readonly formData!: PromotionalDiscountRequest;

    @Prop({
      required: true
    }) public readonly error!: ApiValidationError<PromotionalDiscountRequest>;

    isSelected(dishId: number) {
      return this.formData.dishes.some(e => e === dishId);
    }

    public readonly datePickerOptions = {year: 'numeric', month: 'numeric', day: 'numeric'}

    get checkForm() {
      return this.formData.price > -1 &&
        this.formData.title !== '' &&
        this.formData.text !== '' &&
        this.formData.validFrom !== '' &&
        this.formData.validTill !== '' &&
        this.formData.dishes.length > 0;
    }

    @Emit('onSubmit')
    onSubmit() {
      return {
        ...this.formData,
        price: +this.formData.price.toFixed(2),
        validFrom: new Date(this.formData.validFrom).toISOString(),
        validTill: new Date(this.formData.validTill).toISOString()
      };
    }
};
</script>
