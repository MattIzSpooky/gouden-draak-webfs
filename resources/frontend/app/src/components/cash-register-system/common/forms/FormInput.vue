<template>
  <base-form-input :error="error" :id="id" :name="name">
    <template v-slot:input>
      <input :type="type" required v-model="internalValue" :min="min" :step="step" class="form-control" :id="id"
             :class="{'is-invalid': error && error.errors[id]} || IsInvalid">
    </template>
    <template v-slot:action>
      <slot name="action"/>
    </template>
  </base-form-input>
</template>

<script lang="ts">
import {Component, Prop} from 'vue-property-decorator';
import BaseFormInput from '@/components/cash-register-system/common/forms/BaseFormInput.vue';
import {mixins} from 'vue-class-component';
import {FormInputMixin} from '@/mixins/FormInput';

  @Component({
    components: {
      BaseFormInput
    }
  })
export default class FormInput extends mixins(FormInputMixin) {
    @Prop({
      required: false,
      default: true
    }) public IsInvalid!: boolean;

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
}
</script>
