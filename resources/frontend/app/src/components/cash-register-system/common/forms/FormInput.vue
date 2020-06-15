<template>
  <base-form-input :error="error" :id="id" :name="name">
    <template v-slot:input>
      <input :type="type" required v-model="internalValue" :min="min" :step="step" class="form-control" :id="id"
             :class="{'is-invalid': error && error.errors[id]}">
    </template>
    <template v-slot:action>
      <slot name="action"/>
    </template>
  </base-form-input>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue, Watch} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';
import BaseFormInput from '@/components/cash-register-system/common/forms/BaseFormInput.vue';

  @Component({
    components: {
      BaseFormInput
    }
  })
export default class FormInput extends Vue {
    @Prop({
      required: true
    }) public value!: string;

    @Prop({
      required: true,
      type: String
    }) public name!: string;

    @Prop({
      required: true,
      type: String
    }) public id!: string;

    @Prop({
      required: false,
      default: 'text',
      type: String
    }) public type!: string;

    @Prop({
      required: false,
      type: String
    }) public min!: number;

    @Prop({
      required: false,
      type: String
    }) public step!: number;

    @Prop({
      type: Object
    }) public readonly error!: ApiValidationError<unknown>;

    @Watch('internalValue')
    @Emit('input')
    valueChanged() {
      return this.internalValue;
    }

    @Watch('value', {immediate: true})
    externalValueChanged() {
      this.internalValue = this.value;
    }

    private internalValue = '';

    created() {
      this.internalValue = this.value;
    }
}
</script>
