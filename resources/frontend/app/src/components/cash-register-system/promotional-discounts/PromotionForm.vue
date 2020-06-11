<template>
  <div>
    <div class="alert alert-danger" role="alert" v-if="error && error.message">
      {{error.message}}
    </div>
    <form action="#" @submit.prevent="onSubmit">
      <div class="form-group">
        <label for="title">Titel</label>
        <input type="text" required v-model="formData.title" class="form-control" id="title"
               :class="{'is-invalid': error && error.errors.title}">
        <div v-if="error && error.errors.title">
          <p v-for="error in error.error.title" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="text">Beschrijving</label>
        <textarea class="form-control" required v-model="formData.text" id="text" rows="3"
                  :class="{'is-invalid': error && error.errors.text}"></textarea>
        <div v-if="error && error.errors.text">
          <p v-for="error in error.error.text" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="price">Prijs</label>
        <input type="text" required v-model.number="formData.price" min="0" step="0.1" class="form-control" id="price"
               :class="{'is-invalid': error && error.errors.price}">
        <div v-if="error && error.errors.price">
          <p v-for="error in error.error.price" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="from">Vanaf</label>
        <b-form-datepicker required id="from" v-model="formData.validFrom" :min="new Date()" :date-format-options="datePickerOptions"
                                 locale="nl"/>
        <div v-if="error && error.errors.validFrom">
          <p v-for="error in error.error.validFrom" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="to">Tot</label>
        <b-form-datepicker id="to"
                           required
                           v-model="formData.validTill"
                           :date-format-options="datePickerOptions"
                           :min="formData.validFrom"
                           locale="nl"/>
        <div v-if="error && error.errors.validFrom">
          <p v-for="error in error.error.validFrom" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="dishes">Gerechten</label>
        <select multiple v-model.number="formData.dishes" class="form-control" id="dishes"
                :class="{'is-invalid': error && error.errors.dishes}">
          <option v-for="dish in dishes" :key="dish.id" :value="dish.id" :selected="{'selected': isSelected(dish.id)}">{{dish.name}}</option>
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

@Component({
  components: {
    BFormDatepicker
  }
})
export default class NewDiscount extends Vue {
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
    return this.formData.dishes.some(e => e.id === dishId);
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

<style scoped>

</style>
