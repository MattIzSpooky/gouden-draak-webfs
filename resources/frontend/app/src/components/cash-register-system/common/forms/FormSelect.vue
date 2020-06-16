<template>
  <base-form-input :error="error" :id="id" :name="name">
    <template v-slot:input>
      <select  :required="required"  class="form-control" :multiple="multiple" :id="id" v-model="internalValue"
              :class="{'is-invalid': error && error.errors[id]}">
        <slot/>
      </select>
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
  components: {BaseFormInput}
})
export default class FormSelect extends mixins(FormInputMixin) {
  @Prop({
    required: false,
    default: false
  }) public multiple!: boolean;
}
</script>
