<template>
  <base-form-input :error="error" :id="id" :name="name">
    <template v-slot:input>
      <textarea :required="required"  class="form-control" v-model="internalValue" :id="id" :rows="rows"
                :class="{'is-invalid': error && error.errors[id]}"></textarea>
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
export default class FormTextarea extends mixins(FormInputMixin) {
    @Prop({
      required: false,
      default: '3',
      type: String
    }) public rows!: string;
}
</script>
